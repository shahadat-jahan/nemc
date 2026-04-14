<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\UserGroupRequest;
use App\Http\Controllers\Controller;
use App\Models\Teacher;
use App\Models\User;
use App\Services\Admin\UserGroupService;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

class UserGroupsController extends Controller
{
    /**
     * @var $moduleName
     * @var $redirectUrl
     * @var $pageDirectory
     * @var $userGroupService
     */
    protected $moduleName;
    protected $redirectUrl;
    protected $pageDirectory;
    protected $userGroupService;
    protected $teacherModel;
    protected $userModel;

    /**
     * UserGroupsController constructor.
     *
     * @param UserGroupService $userGroupService
     */
    public function __construct(UserGroupService $userGroupService, Teacher $teacher, User $user)
    {
        $this->moduleName = 'User Group';
        $this->redirectUrl = 'admin/user_groups';
        $this->pageDirectory = 'user_groups.';
        $this->userGroupService = $userGroupService;
        $this->teacherModel = $teacher;
        $this->userModel = $user;
    }

    /**
     * Get user group list
     *
     * @return view
     */
    public function index()
    {
        $data = [
            'pageTitle' => Str::plural($this->moduleName),
            'results' => $this->userGroupService->getData()
        ];

        return view($this->pageDirectory.'index', $data);
    }

    /**
     * Create user group
     *
     * @return View
     */
    public function create()
    {
        $data = [
            'pageTitle' => 'Create '.$this->moduleName
        ];

        return view($this->pageDirectory.'create', $data);
    }

    /**
     * Store the user group.
     *
     * @param  Request  $request
     * @return redirectResponse
     */
    public function store(UserGroupRequest $request)
    {
        $this->userGroupService->create($request->all());

        return redirect($this->redirectUrl)->with('message', setMessage('create', $this->moduleName));
    }

    /**
     * Edit user group
     *
     * @param  int $id
     * @return view
     */
    public function edit($id)
    {
        $userGroup = $this->userGroupService->find($id);

        return view($this->pageDirectory.'edit', compact('userGroup'));
    }

    /**
     * Update user group
     *
     * @param  UserGroupRequest $request
     * @param  int $id
     * @return redirectResponse
     */
    public function update(UserGroupRequest $request, $id)
    {
        $this->userGroupService->update($request->all(), $id);

        return redirect($this->redirectUrl)->with('message', setMessage('update', $this->moduleName));
    }

    /**
     * Set user group permission
     *
     * @param  int $userGroupId
     * @return view
     */
    public function permission($userGroupId)
    {
        $userGroup = $this->userGroupService->find($userGroupId);
        $userGroupPermissions = $this->userGroupService->getPermissions($userGroupId);

        return view($this->pageDirectory.'permissions', compact('userGroup', 'userGroupPermissions'));
    }

    /**
     * Update user group permission
     *
     * @param  Request $request
     * @param  int $userGroupId
     * @return RedirectResponse
     */
    public function updatePermission(Request $request, $userGroupId)
    {
        $this->userGroupService->updatePermission($request, $userGroupId);
        $request->session()->flash('success', setMessage('update', 'User Group Permission'));

        return redirect($this->redirectUrl)->with('message', setMessage('update', 'Permission'));
    }

    public function getTeacherCurrentGroupPermission($teacherId){
        $teacher = $this->teacherModel->findOrFail($teacherId);
        $data['teacherId'] = $teacherId;
        $data['userGroup'] = $this->userGroupService->find($teacher->user->user_group_id);
        $data['userGroupPermissions'] = $this->userGroupService->getPermissionsByGroupIdAndUserId($teacher->user->user_group_id, $teacher->user_id);
        $data['onlyTeacherGroupPermissions'] = $this->userGroupService->getOnlyTeacherGroupPermissions($teacher->user->user_group_id);
        return view('teacher.permissions',$data);
    }

    public function updateTeacherPermission(Request $request){
       $teacherUserId = $this->teacherModel->findOrFail($request->teacher_id)->user_id;
       $teacherPermission = $this->userGroupService->updateTeacherModulePermission($request, $teacherUserId);
        if ($teacherPermission) {
            $request->session()->flash('success', setMessage('update', 'Teacher Permission'));
            return redirect()->route('teacher.index');
        }

        $request->session()->flash('error', setMessage('update.error', 'Teacher Permission'));
        return redirect()->route('teacher.index');
    }

    public function getUserCurrentGroupPermission($userId){
        $user = $this->userModel->findOrFail($userId);
        $data['userId'] = $userId;
        $data['userGroup'] = $this->userGroupService->find($user->user_group_id);
        $data['userGroupPermissions'] = $this->userGroupService->getPermissionsByGroupIdAndUserId($user->user_group_id, $userId);
        $data['onlyUserGroupPermissions'] = $this->userGroupService->getOnlyTeacherGroupPermissions($user->user_group_id);

        return view('users.permissions',$data);
    }

    public function updateAdminUserPermission(Request $request){
        $userId = $request->user_id;
        $userPermission = $this->userGroupService->updateAdminUserModulePermission($request, $userId);

        if ($userPermission) {
            $request->session()->flash('success', setMessage('update', 'Admin User Permission'));
            return redirect()->back();
        }

        $request->session()->flash('error', setMessage('update.error', 'Admin User Permission'));
        return redirect()->back();
    }

}
