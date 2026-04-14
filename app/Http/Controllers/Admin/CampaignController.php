<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BatchType;
use App\Models\Campaign;
use App\Models\Course;
use App\Models\Department;
use App\Models\Designation;
use App\Models\Phase;
use App\Models\Session;
use App\Models\StudentCategory;
use App\Services\CampaignService;
use Exception;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class CampaignController extends Controller
{
    protected $campaignService;

    public function __construct(CampaignService $campaignService)
    {
        $this->campaignService = $campaignService;
    }

    public function index()
    {
        $data = [
            'pageTitle'  => 'Campaigns List',
            'tableHeads' => [
                'ID',
                'Title',
                'Channel',
                'Status',
                'Date Time',
                'Actions',
            ],
            'dataUrl'    => 'admin/campaigns/get-data',
            'columns'    => [
                ['data' => 'id', 'name' => 'id'],
                ['data' => 'title', 'name' => 'title'],
                ['data' => 'channel', 'name' => 'channel'],
                ['data' => 'status', 'name' => 'status'],
                ['data' => 'created_at', 'name' => 'created_at'],
                ['data' => 'actions', 'name' => 'actions', 'orderable' => false, 'searchable' => false],
            ]
        ];

        return view('campaign.index', $data);
    }

    public function getData(Request $request)
    {
        return $this->campaignService->getCampaignsDataTable($request);
    }

    public function create()
    {
        $pageTitle         = 'Create Campaign';
        $sessions          = Session::orderBy('title', 'desc')->get();
        $courses           = Course::orderBy('title', 'asc')->get();
        $departments       = Department::orderBy('title', 'asc')->get();
        $batchTypes        = BatchType::all();
        $studentCategories = StudentCategory::all();
        $phases            = Phase::all();
        $designations      = Designation::orderBy('title', 'asc')->get();

        return view('campaign.create', compact(
            'pageTitle', 'sessions', 'courses', 'departments',
            'batchTypes', 'studentCategories', 'phases', 'designations'
        ));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title'                        => 'required|string|max:255',
            'channel'                      => 'required|in:sms,email',
            'subject'                      => 'required_if:channel,email|nullable|string|max:255',
            'message'                      => 'required|string',
            'recipients'                   => 'required|array|min:1',
            'status'                       => 'required|in:draft,processing,scheduled',
            'scheduled_at'                 => 'required_if:status,scheduled|nullable|date',
            'session_id'                   => 'nullable|array',
            'course_id'                    => 'nullable|array',
            'batch_type_id'                => 'nullable|array',
            'student_category_id'          => 'nullable|array',
            'phase_id'                     => 'nullable|array',
            'department_id'                => 'nullable|array',
            'designation_id'               => 'nullable|array',
            'guardian_session_id'          => 'nullable|array',
            'guardian_course_id'           => 'nullable|array',
            'guardian_phase_id'            => 'nullable|array',
            'guardian_batch_type_id'       => 'nullable|array',
            'guardian_student_category_id' => 'nullable|array',
            'individual_student_ids'       => 'nullable|array',
            'individual_teacher_ids'       => 'nullable|array',
            'individual_guardian_ids'      => 'nullable|array',
        ]);

        try {
            $result = $this->campaignService->storeCampaign($request->all());
            return response()->json($result);
        } catch (Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    public function edit($id)
    {
        $pageTitle = 'Update Campaign';
        // Eager-load recipients + polymorphic recipientable so Blade can render selected recipients reliably.
        $campaign          = Campaign::with(['recipients.recipientable'])->findOrFail($id);
        $sessions          = Session::orderBy('title', 'desc')->get();
        $courses           = Course::orderBy('title', 'asc')->get();
        $departments       = Department::orderBy('title', 'asc')->get();
        $batchTypes        = BatchType::all();
        $studentCategories = StudentCategory::all();
        $phases            = Phase::all();
        $designations      = Designation::orderBy('title', 'asc')->get();

        return view('campaign.edit', compact(
            'campaign', 'sessions', 'courses', 'departments', 'pageTitle',
            'batchTypes', 'studentCategories', 'phases', 'designations'
        ));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'title'                        => 'required|string|max:255',
            'channel'                      => 'required|in:sms,email',
            'subject'                      => 'required_if:channel,email|nullable|string|max:255',
            'message'                      => 'required|string',
            'recipients'                   => 'required|array|min:1',
            'status'                       => 'required|in:draft,processing,scheduled',
            'scheduled_at'                 => 'required_if:status,scheduled|nullable|date',
            'session_id'                   => 'nullable|array',
            'course_id'                    => 'nullable|array',
            'batch_type_id'                => 'nullable|array',
            'student_category_id'          => 'nullable|array',
            'phase_id'                     => 'nullable|array',
            'department_id'                => 'nullable|array',
            'designation_id'               => 'nullable|array',
            'guardian_session_id'          => 'nullable|array',
            'guardian_course_id'           => 'nullable|array',
            'guardian_phase_id'            => 'nullable|array',
            'guardian_batch_type_id'       => 'nullable|array',
            'guardian_student_category_id' => 'nullable|array',
            'individual_student_ids'       => 'nullable|array',
            'individual_teacher_ids'       => 'nullable|array',
            'individual_guardian_ids'      => 'nullable|array',
        ]);

        try {
            $result = $this->campaignService->updateCampaign($id, $request->all());
            return response()->json($result);
        } catch (Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    public function show($id)
    {
        $pageTitle = 'View Campaign';
        $campaign  = Campaign::with(['recipients.recipientable'])->findOrFail($id);
        return view('campaign.show', compact('campaign', 'pageTitle'));
    }

    public function rerun($id): RedirectResponse
    {
        $this->campaignService->rerunCampaign($id);
        $previousUrl = url()->previous();

        return redirect()->to($previousUrl ?: route('campaigns.index'))
                         ->with('success', 'Campaign process started for failed recipients.');
    }

    public function searchRecipients(Request $request)
    {
        $result = $this->campaignService->searchRecipients($request->get('type'), $request->get('q'));
        return response()->json($result);
    }
}
