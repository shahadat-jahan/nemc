<?php

namespace App\Http\Controllers\FrontEnd;

use App\Http\Controllers\Controller;
use App\Services\Admin\CourseService;
use App\Services\Admin\GuardianService;
use App\Services\Admin\SessionService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class GuardianController extends Controller
{

    /**
     *
     */
    const moduleName = 'Parent Management';
    /**
     *
     */
    const redirectUrl = 'nemc/guardians';
    /**
     *
     */
    const moduleDirectory = 'frontend.guardians.';

    protected $service;
    protected $sessionService;
    protected $courseService;

    public function __construct(GuardianService $service, SessionService $sessionService, CourseService $courseService)
    {
        $this->service = $service;
        $this->sessionService = $sessionService;
        $this->courseService = $courseService;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $data = [
            'pageTitle' => 'Parents',
            'sessions' => $this->sessionService->listByStatus(),
            'courses' => $this->courseService->lists(),
            'session_id' => $request->input('session_id'),
            'course_id' => $request->input('course_id'),
            'student_id' => $request->input('student_id'),
            'tableHeads' => ['User ID','Father Name', 'Mother Name', 'Father Phone', 'Mother Phone', 'Action'],
            'dataUrl' => self::redirectUrl.'/get-data',
            'columns' => [
                ['data' => 'user_id', 'name' => 'user_id'],
                ['data' => 'father_name', 'name' => 'father_name'],
                ['data' => 'mother_name', 'name' => 'mother_name'],
                ['data' => 'father_phone', 'name' => 'father_phone'],
                ['data' => 'mother_phone', 'name' => 'mother_phone'],
                ['data' => 'action', 'name' => 'action', 'orderable' => false]
            ]
        ];

        return view(self::moduleDirectory.'index', $data);
    }

    public function getData(Request $request){
        return $this->service->getDataTable($request);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Guardian  $guardian
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $data = [
            'pageTitle' => 'Parents',
            'parentInfo' => $this->service->find($id),
        ];

        return view(self::moduleDirectory.'view', $data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Guardian  $guardian
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data = [
            'pageTitle' => 'Parents',
            'parentInfo' => $this->service->find($id),
        ];

        return view(self::moduleDirectory.'edit', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Guardian  $guardian
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $parentInfo = $this->service->updateParentInfo($request, $id);

        if ($parentInfo){
            $request->session()->flash('success', setMessage('update', 'Parents'));
            return redirect()->route('guardians.index');
        }else{
            $request->session()->flash('error', setMessage('update.error', 'Parents'));
            return redirect()->route('guardians.index');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Guardian  $guardian
     * @return \Illuminate\Http\Response
     */
    public function destroy(Guardian $guardian)
    {
        //
    }

    public function getInfoByUserId(Request $request){
        if ($request->has('userId')) {
            $userId = $request->input('userId');

            $guardian = $this->service->getGuardianInfoByUserId($userId);

            if (!empty($guardian)){
                return response()->json(['status' => true, 'data' => $guardian]);
            }else{
                return response()->json(['status' => false, 'data' => []]);
            }

        }

    }

    public function changePasswordForm($id){
        if (Auth::guard('student_parent')->check()){
            $user = Auth::guard('student_parent')->user();
            if ($user->user_group_id == 6){
                if ($user->parent->id != $id){
                    return redirect()->route('frontend.guardians.index');
                }
            }
        }else{
            return redirect()->route('frontend.guardians.index');
        }

        $data = [
            'pageTitle' => 'Parents',
            'parentId' => $id,
        ];

        return view(self::moduleDirectory.'change_password', $data);
    }

    public function changePassword(Request $request, $id){
        $changePassword = $this->service->changePassword($request, $id);

        if ($changePassword){
            $request->session()->flash('success', setMessage('update', 'Password'));
            return redirect()->route('frontend.guardians.index');
        }else{
            $request->session()->flash('error', setMessage('update.error', 'Password'));
            return redirect()->route('frontend.guardians.index');
        }
    }
}
