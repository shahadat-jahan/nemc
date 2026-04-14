<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Auth;
use App\Services\Admin\UserGroupService;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Spatie\Activitylog\Models\Activity;

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
        $this->middleware('guest')->except('logout');
        $this->userGroupService = $userGroupService;
    }

    /**
     * Display login page
     *
     * @return View
     */
    public function login()
    {
        return view('auth.login');
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
            return redirect('admin/login')->with('message', 'Please enter your login credentials');
        }

        $request['status'] = 1;

        if (Auth::guard('web')->attempt($this->getCredentials($request), $request->has('remember'))) {

            $userGroupId = Auth::User()->user_group_id;

            if ($userGroupId == 5 || $userGroupId == 6){
                Auth::guard('web')->logout();
                return redirect('login')->with('message', "Login credentials didn't match.");
            }

            if (Auth::guard('web')->user()->change_password == 0){
                return redirect('admin/change-password');
            }

            $userGroupPermissions = $this->userGroupService->getAvailablePermissions($userGroupId);

            // Set user group permissions to session
            session(['permissions' => $userGroupPermissions]);

            return redirect('admin/dashboard');

        }

        return redirect('admin/login')->with('message', "Login credentials didn't match.");
    }

    /**
     * @param $request
     * @return array
     */
    protected function getCredentials($request)
    {
        $response = [
            'password' => $request->input('password'),
            'status' => 1
        ];

        if (filter_var($request->input('user_id'), FILTER_VALIDATE_EMAIL)){
            $response['email'] =$request->input('user_id');
        }else{
            $response['user_id'] =$request->input('user_id');
        }

        return $response;
    }

    /**
     * User logout
     *
     * @param Request $request
     * @return RedirectResponse
     */
    public function logout(Request $request)
    {
        $this->guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return $this->loggedOut($request) ?: redirect('/home');
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
        return Auth::guard('web');
    }
}
