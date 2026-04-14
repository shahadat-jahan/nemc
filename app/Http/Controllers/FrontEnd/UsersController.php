<?php

namespace App\Http\Controllers\FrontEnd;

use App\Http\Controllers\Controller;
use App\Services\Admin\UserService;
use App\Services\Admin\UserGroupService;
use Illuminate\Http\Request;
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
    protected $pageDirectory;

    protected $service;
    protected $userGroupService;

    /**
     * UsersController constructor.
     *
     * @param UserService $userService
     * @param UserGroupService $userGroupService
     */
    public function __construct(
        UserService $userService, UserGroupService $userGroupService){
        $this->pageDirectory = 'frontend.users.';
        $this->service = $userService;
        $this->userGroupService = $userGroupService;
    }



    public function changePassword(){
        return view($this->pageDirectory.'change_password');
    }

    public function updatePassword(Request $request){
        $userInfo = Auth::guard('student_parent')->user();

        $user = $this->service->changePassword($request->password, $userInfo->id);

        if ($user) {
            $userGroupPermissions = $this->userGroupService->getAvailablePermissions($userInfo->user_group_id);

            // Set user group permissions to session
            session(['permissions' => $userGroupPermissions]);
            $request->session()->flash('success', 'Password successfully updated');
            return redirect('nemc/dashboard');
        } else {
            $request->session()->flash('error', 'Error in updating password');
            return redirect()->route('user.change-password');
        }
    }

    public function cancelPassword(Request $request){
        Auth::guard('student_parent')->logout();

        $request->session()->invalidate();

        return redirect('/');
    }

}
