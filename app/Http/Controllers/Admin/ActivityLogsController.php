<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Services\Admin\ActivityLogService;
use App\Services\Admin\UserService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ActivityLogsController extends Controller
{
    protected $model = User::class;
    protected $modelClass = User::class;
    protected $url = 'admin/activity-logs';
    protected $userService;
    protected $request;
    protected $activityLogService;
    public function __construct(UserService $userService, User $modelClass, User $model, Request $request, ActivityLogService $activityLogService)
    {
        $this->userService = $userService;
        $this->modelClass = $modelClass;
        $this->model = $model;
        $this->request = $request;
        $this->activityLogService = $activityLogService;
    }

    public function index()
    {
        $data = [
            'pageTitle' => 'Activity Logs',
            'url' => $this->url,
            'users' => $this->userService->allUserListByStatus(),
            'subjectType' => DB::table('activity_log')->distinct()->pluck('subject_type', 'subject_type')->toArray()
        ];
        return view('activity_logs.index', $data);
    }

    public function data()
    {
        return $this->activityLogService->getDataTableResponse();
    }
}
