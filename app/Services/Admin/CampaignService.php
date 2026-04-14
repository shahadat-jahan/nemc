<?php

namespace App\Services\Admin;

use App\Models\CampaignLog;
use App\Models\User;
use App\Services\Admin\Admission\ClassRoutineService;
use App\Services\BaseService;
use Carbon\Carbon;
use DataTables;

class CampaignService extends BaseService
{
    protected $classRoutineService;
    protected $subjectService;
    protected $studentService;
    protected $campaignLog;

    public function __construct(CampaignLog $campaignLog,ClassRoutineService $classRoutineService, SubjectService $subjectService, StudentService $studentService)
    {
        $this->model = $campaignLog;
        $this->subjectService = $subjectService;
        $this->studentService = $studentService;
        $this->classRoutineService = $classRoutineService;
    }

    public function getDataTable($request)
    {
        $query = $this->model->orderBy('created_at', 'desc')->select();

        return Datatables::of($query)
            ->editColumn('campaign_type', function ($row) {
                $type = $row->campaign_type;
                return trim($type ? str_ireplace( '_', ' ', ucfirst($type)) : '');
            })->editColumn('purpose', function ($row) {
                $purpose = $row->purpose;
                return trim($purpose ? str_ireplace( '_', ' ', ucfirst($purpose)) : '');
            })
            ->editColumn('receiver', function ($row) {
                // MorphTo relation to get receiver type and name
                $type = class_basename($row->receiver_type);
                $name = $row->receiver->full_name ?? 'Not found';
                return $type . ' - ' . $name;
            })
            ->editColumn('message', function ($row) {
                return strip_tags($row->message);
            })
            ->editColumn('email', function ($row) {
                return $row->email ?? 'N\A';
            })
            ->editColumn('mobile_number', function ($row) {
                return $row->mobile_number ?? 'N\A';
            })
            ->addColumn('status', function ($row) {
                if ($row->status == 1) {
                    return '<span class="text-success">Success</span>';
                }

                if ($row->status == null && $row->response == null) {
                return '<span class="text-warning">N/A</span>';
                }

                    return '<span class="text-danger">Failed</span>';
            })
            ->addColumn('response', function ($row) {
                if ($row->status == 1) {
                    return '<span class="text-success">' . $row->response . '</span>';
                }

                if ($row->status == null && $row->response == null) {
                return '<span class="text-warning">N\A</span>';
                }

                    return '<span class="text-danger">' . $row->response . '</span>';
            })
            ->editColumn('created_by', function ($row) {
                return $row->created_by == 1698 ? 'System' : $row->sender->full_name;
            })
            ->editColumn('created_at', function ($row) {
                return dateFormat($row->created_at);
            })
            ->rawColumns(['status','response'])
            ->addIndexColumn()
            ->filter(function ($query) use ($request) {
                if (!empty($request->get('sender_id'))) {
                    $query->where('created_by', $request->get('sender_id'));
                }

                if (!empty($request->get('receiver_type'))) {
                    $query->where('receiver_type', $request->get('receiver_type'));
                }

                if (!empty($request->get('campaign_type'))) {
                    $query->where('campaign_type', $request->get('campaign_type'));
                }

                if (!empty($request->get('purpose'))) {
                    $query->where('purpose', $request->get('purpose'));
                }

                if ($request->get('status') !== null && $request->get('status') !== '') {
                    $query->where('status', $request->get('status'));
                }
            })
            ->make(true);
    }

    /**
     * Get all unique senders
     *
     * @return array [user_id => user_name]
     */
    public function getAllSender()
    {
        // Get all unique created_by values from the model
        $senderIds = $this->model
            ->whereNotNull('created_by')
            ->distinct()
            ->pluck('created_by')
            ->toArray();

        if (empty($senderIds)) {
            return [];
        }

        // Eager load possible relations for username resolution
        $users = User::with(['adminUser', 'teacher'])
            ->whereIn('id', $senderIds)
            ->get();

        $userArray = [];
        foreach ($users as $user) {
            if ($user->teacher) {
                $userName = $user->teacher->full_name;
            } elseif ($user->adminUser) {
                $userName = $user->adminUser->full_name;
            } else {
                $userName = 'User #' . $user->id;
            }
            $userArray[$user->id] = $userName;
        }
        return $userArray;
    }

    public function getAllReceiverType()
    {
        $receiverTypes = $this->model->distinct()->pluck('receiver_type');

        return $receiverTypes->mapWithKeys(function ($item) {
            return [$item => array_slice(explode('\\', $item), -1)[0]];
        })->toArray();
    }

    public function getPurposes()
    {
        $purposes = $this->model->distinct()->pluck('purpose');

        return $purposes->mapWithKeys(function ($item) {
            return [$item => str_replace('_', ' ', ucfirst($item))];
        })->toArray();
    }
}
