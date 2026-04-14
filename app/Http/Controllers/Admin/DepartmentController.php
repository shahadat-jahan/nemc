<?php

namespace App\Http\Controllers\Admin;

use App\Department;
use App\Http\Controllers\Controller;
use App\Http\Requests\DepartmentRequest;
use App\Services\Admin\DepartmentService;
use App\Services\Admin\SubjectService;
use App\Services\Admin\TeacherService;
use App\Services\Admin\UserService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DepartmentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    protected $redirectUrl;

    protected $departmentService;
    protected $userService;
    protected $teacherService;
    protected $subjectService;



    public function __construct(DepartmentService $departmentService, UserService $userService, TeacherService $teacherService, SubjectService $subjectService){
        $this->redirectUrl = 'admin/department';
        $this->departmentService = $departmentService;
        $this->userService = $userService;
        $this->teacherService = $teacherService;
        $this->subjectService = $subjectService;
    }


    public function index(){
        $data = [
            'pageTitle' => 'Department',
            'tableHeads' => ['Id', 'Title', 'Department Head', 'Description',  'Status', 'Action'],
            'dataUrl' => $this->redirectUrl.'/get-data',
            'columns' => [
                ['data' => 'id', 'name' => 'id'],
                ['data' => 'title', 'name' => 'title'],
                ['data' => 'department_lead_id', 'name' => 'department_lead_id'],
                ['data' => 'description', 'name' => 'description'],
                ['data' => 'status', 'name' => 'status'],
                ['data' => 'action', 'name' => 'action', 'orderable' => false]
            ],
        ];

        // get user for department lead
        //$data['departmentLeads'] = $this->userService->getAllDepartmentLead();
        $data['departmentLeads'] = $this->teacherService->getAllTeachers();

        return view('department.index', $data);
    }

    public function getData(Request $request){

        return $this->departmentService->getAllData($request);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data = [
            'pageTitle' => 'Department create',
        ];

        // get user for department lead
        $data['departmentLeads'] = $this->teacherService->getAllTeachers();

        return view('department.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(DepartmentRequest $request) {
        $department = $this->departmentService->create($request->all());

        if ($department) {
            $request->session()->flash('success', setMessage('create', 'Department'));
            return redirect()->route('department.index');
        } else {
            $request->session()->flash('error', setMessage('create.error', 'Department'));
            return redirect()->route('department.index');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Department  $department
     * @return \Illuminate\Http\Response
     */
    public function show(Department $department)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Department  $department
     * @return \Illuminate\Http\Response
     */
    public function edit($id) {
        $data = [
            'pageTitle' => 'Department Edit',
            'department' => $this->departmentService->find($id),
        ];
        // get user for department lead
        $data['departmentLeads'] = $this->teacherService->getAllTeachers();

        return view('department.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Department  $department
     * @return \Illuminate\Http\Response
     */
    public function update(DepartmentRequest $request, $id) {
        $department = $this->departmentService->update($request->all(), $id);

        if ($department) {
            $request->session()->flash('success', setMessage('update', 'Department'));
            return redirect()->route('department.index');
        } else {
            $request->session()->flash('error', setMessage('update.error', 'Department'));
            return redirect()->route('department.index');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Department  $department
     * @return \Illuminate\Http\Response
     */
    public function destroy(Department $department){
        //
    }

    public function getDepartmentBySessionCoursePhase(Request $request){
        $subjects = $this->subjectService->getSubjectsBySessionIdCourseIdPhaseId($request->sessionId, $request->courseId, $request->phaseId);
        $departments = [];
        if ($subjects){
            if (Auth::guard('web')->check()){
                $user = Auth::guard('web')->user();
                if ($user->teacher){
                    foreach ($subjects->sortBy('department_id') as $subject){
                        if ($user->teacher->department_id == $subject->department->id)
                            $departments[$subject->department->id] = $subject->department;
                    }
                }else {
                    foreach ($subjects->sortBy('department_id') as $subject){
                        $departments[$subject->department->id] = $subject->department;
                    }
                }
            }
        }
        return response()->json(['status' => true, 'departments' => $departments]);
    }
}
