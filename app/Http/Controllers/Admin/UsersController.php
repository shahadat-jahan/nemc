<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserRequest;
use App\Http\Requests\UserUpdateRequest;
use App\Services\Admin\CourseService;
use App\Services\Admin\DepartmentService;
use App\Services\Admin\DesignationService;
use App\Services\Admin\UserService;
use App\Services\Admin\UserGroupService;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Auth;

class UsersController extends Controller
{
    /**
     * @var $moduleName
     * @var $redirectUrl
     * @var $pageDirectory
     *
     * @var $userService
     * @var $userGroupService
     */
    protected $moduleName;
    protected $redirectUrl;
    protected $pageDirectory;

    protected $userService;
    protected $userGroupService;
    protected $departmentService;
    protected $designationService;
    protected $courseService;

    /**
     * UsersController constructor.
     *
     * @param UserService $userService
     * @param UserGroupService $userGroupService
     */
    public function __construct(
        UserService $userService, UserGroupService $userGroupService, DepartmentService $departmentService,
        DesignationService $designationService, CourseService $courseService){
        $this->moduleName = 'User';
        $this->redirectUrl = 'admin/users';
        $this->pageDirectory = 'users.';

        $this->service = $userService;
        $this->userGroupService = $userGroupService;
        $this->departmentService = $departmentService;
        $this->designationService = $designationService;
        $this->courseService = $courseService;
    }

    /**
     * Display user list
     *
     * @return View
     */
    public function index()
    {
        $data = [
            'pageTitle' => Str::plural($this->moduleName),
            'dataUrl' => $this->redirectUrl.'/getData',
            'tableHeads' => ['Id', 'Image', 'Name', 'User ID', 'Email', 'Group name', 'Status', 'Action'],
            'columns' => [
                ['data' => 'id', 'name' => 'id'],
                ['data' => 'photo', 'name' => 'photo'],
                ['data' => 'name', 'name' => 'name'],
                ['data' => 'user_id', 'name' => 'user_id'],
                ['data' => 'email', 'name' => 'email'],
                //['data' => 'phone_number', 'name' => 'phone_number'],
                ['data' => 'user_group_id', 'name' => 'user_group_id'],
                ['data' => 'status', 'name' => 'status'],
                ['data' => 'action', 'name' => 'action', 'orderable' => false]
            ],
            'userGroups' => $this->userGroupService->getAdminUserGroup()
        ];
        return view($this->pageDirectory.'index', $data);
    }

    /**
     * Get user list
     *
     * @param $request
     * @return array
     */
    public function getData(Request $request)
    {
        return $this->service->getAllData($request);
    }

    /**
     * Create user
     *
     * @return View
     */
    public function create()
    {
        $data = [
            'pageTitle' => 'Create '.$this->moduleName,
            'userGroups' => $this->userGroupService->listsByNotInGroupId([4,5,6]),
            'departments' => $this->departmentService->lists(),
            'designations' => $this->designationService->lists(),
        ];
        $data['courses'] = $this->courseService->getAllCourse();

        return view($this->pageDirectory.'create', $data);
    }

    /**
     * Store user
     *
     * @param UserRequest $request
     * @return RedirectResponse
     */
    public function store(UserRequest $request)
    {
        //$request['password'] = Hash::make($request->input('password'));
        $this->service->createUser($request);

        return redirect($this->redirectUrl)->with('message', setMessage('create', $this->moduleName));
    }

    /**
     * Edit user
     *
     * @param  int $id
     * @return view
     */
    public function edit($id)
    {
        $data = [
            'pageTitle' => 'Edit '.$this->moduleName,
            'user' => $this->service->find($id),
            'userGroups' => $this->userGroupService->lists(),
            'departments' => $this->departmentService->lists(),
            'designations' => $this->designationService->lists(),
        ];
        $data['courses'] = $this->courseService->getAllCourse();

        return view($this->pageDirectory.'edit', $data);
    }

    /**
     * Update user
     *
     * @param  UserRequest $request
     * @param  int $id
     * @return redirectResponse
     */
    public function update(UserUpdateRequest $request, $id)
    {
        $this->service->updateUser($request, $id);
        //$this->service->update($request->all(), $id);

        return redirect($this->redirectUrl)->with('message', setMessage('update', $this->moduleName));
    }

    /*
     * Get user deyails
     *
     * @param int $id
     * @return view
     */
    public function show($id)
    {
        $data = [
            'pageTitle' => 'User Details',
            'user' => $this->service->find($id)
        ];

        if ($data['user']) {
            return view($this->pageDirectory.'view', $data);
        }

        return redirect($this->redirectUrl)->with('message', setMessage('error', 'User not found.'));
    }

    /*
     * Get user deyails
     *
     * @return view
     */
    public function profile()
    {
        $id = Auth::user()->id;
        $data = [
            'pageTitle' => 'User Details',
            'user' => $this->service->find($id)
        ];

        if ($data['user']) {
            return view($this->pageDirectory.'view', $data);
        }

        return redirect($this->redirectUrl)->with('message', setMessage('error', 'User not found.'));
    }

    //check user Id is unique
    public function checkUserIdExist(Request $request){
        $check = $this->service->checkUserIdExist($request);

        if (empty($check)){
            return 'true';
        }

        return 'false';
    }

    //check user email is unique
    public function userUniqueEmailCheck(Request $request){
        $check = $this->service->checkUserEmailIsUnique($request);

        if (empty($check)){
            return 'true';
        }

        return 'false';
    }
    public function userChangePasswordForm($id){
        $data = [
            'pageTitle' => 'User',
            'userId' => $id,
        ];
        return view('users.user_change_password', $data);
    }

    public function userChangePassword(Request $request, $id){

        $changePassword = $this->service->userChangePassword($request, $id);

        if ($changePassword){
            $request->session()->flash('success', setMessage('update', 'Password'));
            return redirect()->route('users.index');
        }
        $request->session()->flash('error', setMessage('update.error', 'Password'));
        return redirect()->route('users.index');
    }
    public function changePassword(){
        return view($this->pageDirectory.'change_password');
    }

    public function updatePassword(Request $request){
        $userInfo = Auth::guard('web')->user();

        $user = $this->service->changePassword($request->password, $userInfo->id);

        if ($user) {
            $userGroupPermissions = $this->userGroupService->getAvailablePermissions($userInfo->user_group_id);

            // Set user group permissions to session
            session(['permissions' => $userGroupPermissions]);
            $request->session()->flash('success', 'Password successfully updated');
            return redirect('admin/dashboard');
        } else {
            $request->session()->flash('error', 'Error in updating password');
            return redirect()->route('user.change-password');
        }
    }

    public function cancelPassword(Request $request){
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        return redirect('/admin');
    }


}
