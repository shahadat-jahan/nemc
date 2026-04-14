<?php

namespace App\Services;

use App\Jobs\ProcessCampaignJob;
use App\Models\Campaign;
use App\Models\CampaignDetail;
use App\Models\Guardian;
use App\Models\Student;
use App\Models\Teacher;
use App\Models\User;
use Carbon\Carbon;
use DataTables;
use Exception;
use Illuminate\Support\Facades\DB;

class CampaignService extends BaseService
{
    public function __construct(Campaign $campaign)
    {
        $this->model = $campaign;
    }

    /**
     * Get Campaign Data for DataTable
     */
    public function getCampaignsDataTable($request)
    {
        $query = $this->model->query()->orderBy('created_at', 'desc');

        return DataTables::of($query)
                         ->editColumn('channel', function ($row) {
                             $class = $row->channel == 'email' ? 'success' : 'brand';
                             $text  = strtoupper($row->channel);
                             return '<span class="m-badge m-badge--' . $class . ' m-badge--wide">' . $text . '</span>';
                         })
                         ->editColumn('status', function ($row) {
                             $statusColors = [
                                 'completed'  => 'success',
                                 'processing' => 'warning',
                                 'scheduled'  => 'info',
                                 'draft'      => 'metal'
                             ];
                             $class        = $statusColors[$row->status] ?? 'info';
                             $text         = ucfirst($row->status);
                             return '<span class="m-badge m-badge--' . $class . ' m-badge--wide">' . $text . '</span>';
                         })
                         ->addColumn('actions', function ($row) {
                             $actions = '';
                             if (hasPermission('campaigns/view')) {
                                 $actions = '<a href="' . route('campaigns.show', $row->id) . '"
                            class="btn btn-outline-primary btn-sm m-btn m-btn--icon m-btn--pill" title="View">
                            <span><i class="la la-eye"></i><span>View</span></span>
                        </a>';
                             }
                             if (in_array($row->status, ['draft', 'scheduled']) && hasPermission('campaigns/edit')) {
                                 $actions .= ' <a href="' . route('campaigns.edit', $row->id) . '"
                                class="btn btn-outline-warning btn-sm m-btn m-btn--icon m-btn--pill" title="Edit">
                                <span><i class="la la-edit"></i><span>Edit</span></span>
                            </a>';
                             }

                             return $actions;
                         })
                         ->editColumn('created_at', function ($row) {
                             return $row->created_at ? Carbon::parse($row->created_at)->format('d M, Y h:i A') .
                                 '<br>' . '<small class="text-muted">' .
                                 ($row->created_at ? Carbon::parse($row->created_at)->diffForHumans() : '') . '</small>' : 'N/A';
                         })
                         ->filter(function ($query) use ($request) {
                             if ($request->filled('status')) {
                                 $query->where('status', $request->status);
                             }
                             if ($request->filled('channel')) {
                                 $query->where('channel', $request->channel);
                             }
                             if ($request->filled('date_from')) {
                                 $from = Carbon::createFromFormat('d/m/Y', $request->date_from)->startOfDay();
                                 $query->where('created_at', '>=', $from);
                             }

                             if ($request->filled('date_to')) {
                                 $to = Carbon::createFromFormat('d/m/Y', $request->date_to)->endOfDay();
                                 $query->where('created_at', '<=', $to);
                             }
                         })
                         ->rawColumns(['channel', 'status', 'created_at', 'actions'])
                         ->make(true);
    }

    /**
     * Store a new campaign
     */
    public function storeCampaign($data)
    {
        DB::beginTransaction();
        try {
            $campaign = $this->model->create([
                'title'        => $data['title'],
                'channel'      => $data['channel'],
                'subject'      => $data['subject'] ?? null,
                'message'      => $data['message'],
                'status'       => $data['status'],
                'scheduled_at' => $data['status'] == 'scheduled' ? $data['scheduled_at'] : null,
            ]);

            $this->syncRecipients($campaign, $data['recipients'], $data);

            DB::commit();

            $this->dispatchCampaignJob($campaign);

            return [
                'success'  => true,
                'message'  => 'Campaign created successfully!',
                'campaign' => $campaign
            ];
        } catch (Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    /**
     * Update an existing campaign
     */
    public function updateCampaign($id, $data)
    {
        $campaign = $this->model->findOrFail($id);

        DB::beginTransaction();
        try {
            $campaign->update([
                'title'        => $data['title'],
                'channel'      => $data['channel'],
                'subject'      => $data['subject'] ?? null,
                'message'      => $data['message'],
                'status'       => $data['status'],
                'scheduled_at' => $data['status'] == 'scheduled' ? $data['scheduled_at'] : null,
            ]);

            if ($campaign->status != 'completed') {
                $this->syncRecipients($campaign, $data['recipients'], $data);
            }

            DB::commit();

            $this->dispatchCampaignJob($campaign);

            return [
                'success'  => true,
                'message'  => 'Campaign updated successfully!',
                'campaign' => $campaign
            ];
        } catch (Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    /**
     * Sync recipients for a campaign
     */
    public function syncRecipients($campaign, $recipients, $filters)
    {
        $campaign->recipients()->forceDelete();

        $types = [
            'students'  => [
                Student::class, 'student',
                ['session_id', 'course_id', 'batch_type_id', 'student_category_id', 'phase_id']
            ],
            'teachers'  => [Teacher::class, 'teacher', ['department_id', 'designation_id']],
            'guardians' => [
                Guardian::class, 'guardian', [
                    'guardian_session_id', 'guardian_course_id', 'guardian_phase_id', 'guardian_batch_type_id',
                    'guardian_student_category_id'
                ]
            ],
        ];

        $allInsertData = [];

        foreach ($recipients as $type) {
            if (!isset($types[$type])) continue;
            [$model, $singular, $filterKeys] = $types[$type];

            $userIds = collect($filters["individual_{$singular}_ids"] ?? [])->filter()->unique();

            if ($userIds->isNotEmpty()) {
                $ids = $model::whereHas('user', fn($q) => $q->whereIn('user_id', $userIds))->pluck('id');
            } else {
                $query = $model::query();

                if ($type === 'guardians') {
                    $activeFilters = collect($filters)->only($filterKeys)->filter();
                    if ($activeFilters->isNotEmpty()) {
                        $query->whereHas('students', function ($q) use ($activeFilters) {
                            foreach ($activeFilters as $key => $value) {
                                $column = str_replace('guardian_', '', $key);
                                if (is_array($value)) {
                                    $q->whereIn($column, $value);
                                } else {
                                    $q->where($column, $value);
                                }
                            }
                        });
                    }
                } else {
                    foreach ($filterKeys as $key) {
                        if ($val = $filters[$key] ?? null) {
                            if (is_array($val)) {
                                $query->whereIn($key, $val);
                            } else {
                                $query->where($key, $val);
                            }
                        }
                    }
                }
                $ids = $query->pluck('id');
            }

            foreach ($ids as $id) {
                $allInsertData[] = [
                    'campaign_id'        => $campaign->id,
                    'recipientable_id'   => $id,
                    'recipientable_type' => $model,
                    'status'             => 'pending',
                    'created_at'         => now(),
                    'updated_at'         => now(),
                ];
            }
        }

        if (!empty($allInsertData)) {
            foreach (array_chunk($allInsertData, 500) as $chunk) {
                DB::table('campaign_recipients')->insert($chunk);
            }
        }
    }

    /**
     * Dispatch Campaign Job
     */
    protected function dispatchCampaignJob($campaign)
    {
        if ($campaign->status === 'processing') {
            ProcessCampaignJob::dispatch($campaign->id);
        } elseif ($campaign->status === 'scheduled') {
            $delay = Carbon::parse($campaign->scheduled_at)->diffInSeconds(now());
            if ($delay > 0) {
                ProcessCampaignJob::dispatch($campaign->id)->delay($delay);
            } else {
                ProcessCampaignJob::dispatch($campaign->id);
            }
        }
    }

    /**
     * Rerun a campaign for failed recipients
     */
    public function rerunCampaign($id)
    {
        $campaign = $this->model->findOrFail($id);

        // Reset failed recipients to pending
        $campaign->recipients()->where('status', 'failed')->update([
            'status'   => 'pending',
            'sent_at'  => null,
            'response' => null
        ]);

        // Dispatch process job
        ProcessCampaignJob::dispatch($campaign->id);
    }

    /**
     * Search recipients for AJAX search
     */
    public function searchRecipients($type, $search)
    {
        $relationMap = [
            'student'  => 'student',
            'teacher'  => 'teacher',
            'guardian' => 'parent',
        ];

        $relation = $relationMap[$type] ?? null;
        if (!$relation) return ['items' => [], 'total_count' => 0];

        $items = [];

        if (is_string($search) && preg_match('/^\d+$/', trim($search))) {
            $user = User::with($relation)->where('user_id', trim($search))->first();
            if ($user && $user->{$relation}) {
                $items = [
                    [
                        'id'   => $user->user_id,
                        'text' => $user->{$relation}->full_name . ' (' . $user->user_id . ')',
                    ]
                ];
            }
        }

        if (empty($items)) {
            $items = User::with($relation)
                         ->whereHas($relation)
                         ->where(function ($q) use ($search) {
                             $q->where('user_id', 'LIKE', "%{$search}%")
                               ->orWhere(DB::raw("CONCAT(first_name, ' ', last_name)"), 'LIKE', "%{$search}%");
                         })
                         ->limit(30)
                         ->get()
                         ->map(function ($user) use ($relation) {
                             return [
                                 'id'   => $user->user_id,
                                 'text' => $user->{$relation}->full_name . ' (' . $user->user_id . ')',
                             ];
                         });
        }

        return [
            'items'       => $items,
            'total_count' => count($items),
        ];
    }

    /**
     * Get Campaign Reports with filters
     */
    public function getCampaignReports($filters, $paginate = true)
    {
        $query = CampaignDetail::query()->orderBy('created_at', 'desc');

        if (isset($filters['channel']) && $filters['channel'] != '') {
            $query->where('channel', $filters['channel']);
        }

        if (isset($filters['status']) && $filters['status'] != '') {
            $query->where('status', $filters['status']);
        }

        if (isset($filters['date_from']) && !empty($filters['date_from'])) {
            $from = Carbon::createFromFormat('d/m/Y', $filters['date_from'])->startOfDay();
            $query->where('created_at', '>=', $from);
        }

        if (isset($filters['date_to']) && !empty($filters['date_to'])) {
            $to = Carbon::createFromFormat('d/m/Y', $filters['date_to'])->endOfDay();
            $query->where('created_at', '<=', $to);
        }

        if ($paginate) {
            return $query->paginate(20);
        }

        return $query->get();
    }
}
