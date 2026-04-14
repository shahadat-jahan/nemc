<?php

namespace App\Http\Controllers\FrontEnd\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Auth;
use App\Services\Admin\UserGroupService;
use Illuminate\Support\Facades\Validator;

class LoginController extends Controller
{
    use AuthenticatesUsers;

    /**
     * @var string
     * @var $userGroupService
     */
    protected $redirectTo = '/';

    protected $userGroupService;

    /**
     * LoginController constructor.
     * @param UserGroupService $userGroupService
     */
    public function __construct(UserGroupService $userGroupService)
    {
//        $this->middleware('guest')->except('logout');
        $this->userGroupService = $userGroupService;
    }

    /**
     * Display login page
     *
     * @return View
     */
    public function login()
    {
        if (Auth::guard('student_parent')->check()){
            return redirect('/nemc/dashboard');
        }
        return view('frontend.auth.login');
    }

    /**
     * User login
     *
     * @param Request $request
     * @return RedirectResponse
     */
    public function doLogin(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user_id' => 'required',
            'password' => 'required',
        ]);

        if ($validator->fails()) {
            return redirect('login')->with('message', 'Please enter your user id and password.');
        }

        $request['status'] = 1;

        if (Auth::guard('student_parent')->attempt($this->getCredentials($request), $request->has('remember'))) {

            $userGroupId = Auth::guard('student_parent')->User()->user_group_id;
            if ($userGroupId != 5 && $userGroupId != 6){
                Auth::guard('student_parent')->logout();
                return redirect('login')->with('message', "User ID or password didn't match.");
            }

            if (Auth::guard('student_parent')->user()->change_password == 0){
                return redirect('nemc/change-password');
            }

            $userGroupPermissions = $this->userGroupService->getAvailablePermissions($userGroupId);

            // Set user group permissions to session
            session(['permissions' => $userGroupPermissions]);

            return redirect('/nemc/dashboard');

        } else {
            return redirect('login')->with('message', "User ID or password didn't match.");
        }
    }

    /**
     * @param $request
     * @return array
     */
    protected function getCredentials($request)
    {
        return [
            'user_id'    => $request->input('user_id'),
            'password' => $request->input('password'),
            'status' => 1
        ];
    }

    /**
     * User logout
     *
     * @param Request $request
     * @return RedirectResponse
     */
    public function logout(Request $request)
    {
        $this->guard('student_parent')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();
        return $this->loggedOut($request) ?: redirect('/');
//        return $this->loggedOut($request) ?: redirect('/login');
    }

    /**
     * @param Request $request
     */
    protected function loggedOut(Request $request)
    {
        //
    }

    protected function guard()
    {
        return Auth::guard('student_parent');
    }
}
