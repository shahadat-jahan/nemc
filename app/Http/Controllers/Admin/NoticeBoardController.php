<?php

namespace App\Http\Controllers\Admin;

use App\Events\NotifyUserWhenNoticePublished;
use App\Http\Controllers\Controller;
use App\Http\Requests\NoticeBoardRequest;
use App\Models\Notification;
use App\Services\Admin\BatchTypeService;
use App\Services\Admin\CourseService;
use App\Services\Admin\DepartmentService;
use App\Services\Admin\NoticeBoardService;
use App\Services\Admin\PhaseService;
use App\Services\Admin\SessionService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NoticeBoardController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    protected $noticeBoardService;
    protected $sessionService;
    protected $courseService;
    protected $phaseService;
    protected $departmentService;
    protected $batchTypeService;
    protected $redirectUrl;

    public function __construct(NoticeBoardService $noticeBoardService, SessionService $sessionService, CourseService $courseService,
                                PhaseService       $phaseService, DepartmentService $departmentService, BatchTypeService $batchTypeService)
    {
        $this->redirectUrl = 'admin/notice_board';
        $this->noticeBoardService = $noticeBoardService;
        $this->sessionService = $sessionService;
        $this->courseService = $courseService;
        $this->phaseService = $phaseService;
        $this->departmentService = $departmentService;
        $this->batchTypeService = $batchTypeService;
    }

    public function index()
    {
        $data = [
            'pageTitle' => 'Notice Board',
            'tableHeads' => ['Id', 'Title', 'Published Date', 'Notice File', 'Status', 'Action'],
            'dataUrl' => $this->redirectUrl . '/get-data',
            'columns' => [
                ['data' => 'id', 'name' => 'id'],
                ['data' => 'title', 'name' => 'title'],
                ['data' => 'published_date', 'name' => 'published_date'],
                ['data' => 'file_path', 'name' => 'file_path'],
                /* ['data' => 'session_id', 'name' => 'session_id'],
                 ['data' => 'batch_type_id', 'name' => 'batch_type_id'],*/
                ['data' => 'status', 'name' => 'status'],
                ['data' => 'action', 'name' => 'action', 'orderable' => false],
            ],
        ];
        return view('noticeBoard.index', $data);
    }

    public function getData(Request $request)
    {
        return $this->noticeBoardService->getAllData($request);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $departments = [];
        $allDepartments = $this->departmentService->listByStatus();

        if (Auth::guard('web')->check()) {
            $user = Auth::guard('web')->user();
            if ($user->teacher) {
                foreach ($allDepartments as $id => $department) {
                    if ($user->teacher->department_id == $id)
                        $departments[$id] = $department;
                }
            } else {
                foreach ($allDepartments as $id => $department) {
                    $departments[$id] = $department;
                }
            }
        }

        $data = [
            'pageTitle' => 'Notice Create',
            'sessions' => $this->sessionService->listByStatus(),
            'courses' => $this->courseService->listByStatus(),
            'phases' => $this->phaseService->listByStatus(),
            'departments' => $departments,
            'batchTypes' => $this->batchTypeService->listByStatus(),
        ];

        return view('noticeBoard.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(NoticeBoardRequest $request)
    {
        $notice = $this->noticeBoardService->saveNoticeData($request);

        if ($notice && !empty($notice->is_publish)) {
            $notice->load('departments');
            event(new NotifyUserWhenNoticePublished($notice));
        }

        if ($notice) {
            $request->session()->flash('success', setMessage('create', 'Notice'));
            return redirect()->route('notice_board.index');
        }

        $request->session()->flash('error', setMessage('create.error', 'Notice'));
        return redirect()->route('notice_board.index');
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Holiday $holiday
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $data = [
            'pageTitle' => 'Notice Detail',
            'notice' => $this->noticeBoardService->find($id),
        ];
        return view('noticeBoard.view', $data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Holiday $holiday
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $notice = $this->noticeBoardService->find($id);

        $departments = [];
        $allDepartments = $this->departmentService->listByStatus();

        if (Auth::guard('web')->check()) {
            $user = Auth::guard('web')->user();
            if ($user->teacher) {
                foreach ($allDepartments as $departmentId => $department) {
                    if ($user->teacher->department_id == $departmentId)
                        $departments[$departmentId] = $department;
                }
            } else {
                foreach ($allDepartments as $departmentId => $department) {
                    $departments[$departmentId] = $department;
                }
            }
        }

        $data = [
            'pageTitle' => 'Notice Edit',
            'sessions' => $this->sessionService->listByStatus(),
            'courses' => $this->courseService->listByStatus(),
            'phases' => $this->phaseService->listByStatus(),
            'departments' => $departments,
            'batchTypes' => $this->batchTypeService->listByStatus(),
            'notice' => $notice,
        ];

        return view('noticeBoard.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Holiday $holiday
     * @return \Illuminate\Http\Response
     */
    public function update(NoticeBoardRequest $request, $id)
    {
        $notice = $this->noticeBoardService->updateNoticeData($request, $id);

        if ($notice) {
            $request->session()->flash('success', setMessage('update', 'Notice'));
            return redirect()->route('notice_board.index');
        }
        $request->session()->flash('error', setMessage('update.error', 'Notice'));
        return redirect()->route('notice_board.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Holiday $holiday
     * @return \Illuminate\Http\Response
     */
    public function destroy(Holiday $holiday)
    {
        //
    }

    public function checkNewNotice()
    {
        if (Auth::guard('student_parent')->check()) {
            $userId = Auth::guard('student_parent')->check() ? Auth::guard('student_parent')->user()->id : '';
        } else {
            $userId = Auth::guard('web')->check() ? Auth::user()->id : '';
        }

        $newNotices = Notification::with('resource')
                                      ->whereHasMorph('resource', ['App\Models\NoticeBoard'], function ($query) {
                                          $query->where('status', 1);
                                      })
                                      ->where('user_id', $userId)
                                      ->where('is_seen', 0)
                                      ->where('notification_type', 'notice_board')
                                      ->orderBy('created_at', 'desc')
                                      ->get();

        return response()->json($newNotices);
    }
}
