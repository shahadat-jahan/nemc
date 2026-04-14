<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StudentGroupRequest;
use App\Models\StudentGroup;
use App\Models\StudentGroupType;
use App\Services\Admin\Admission\StudentGroupService;
use App\Services\Admin\CourseService;
use App\Services\Admin\DepartmentService;
use App\Services\Admin\PhaseService;
use App\Services\Admin\SessionService;
use App\Services\Admin\StudentGroupTypeService;
use App\Services\Admin\StudentService;
use App\Services\Admin\SubjectService;
use App\Services\UtilityServices;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StudentGroupController extends Controller
{

    /**
     *
     */
    const moduleName = 'Student Groups';
    /**
     *
     */
    const redirectUrl = 'admin/student_group';
    /**
     *
     */
    const moduleDirectory = 'student_group.';

    protected $service;
    protected $sessionService;
    protected $phaseService;
    protected $courseService;
    protected $studentService;
    protected $departmentService;
    protected $subjectService;
    protected $studentGroupTypeService;

    public function __construct(StudentGroupService $service, SessionService $sessionService, PhaseService $phaseService,
                                CourseService $courseService, StudentService $studentService, DepartmentService $departmentService,
                                SubjectService $subjectService, StudentGroupTypeService $studentGroupTypeService)
    {
        $this->service = $service;
        $this->sessionService = $sessionService;
        $this->phaseService = $phaseService;
        $this->courseService = $courseService;
        $this->studentService = $studentService;
        $this->departmentService = $departmentService;
        $this->subjectService = $subjectService;
        $this->studentGroupTypeService = $studentGroupTypeService;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $data = [
            'pageTitle' => self::moduleName,
            'tableHeads' => ['Group Name', 'Session', 'Phase','Course', 'Department', 'Group Type', 'Roll Start', 'Roll End', 'Status', 'Action'],
            'dataUrl' => self::redirectUrl.'/get-data',
            'columns' => [
                ['data' => 'group_name', 'name' => 'group_name'],
                ['data' => 'session_id', 'name' => 'session_id'],
                ['data' => 'phase_id', 'name' => 'phase_id'],
                ['data' => 'course_id', 'name' => 'course_id'],
                ['data' => 'department_id', 'name' => 'department_id'],
                ['data' => 'type', 'name' => 'type'],
                ['data' => 'roll_start', 'name' => 'roll_start'],
                ['data' => 'roll_end', 'name' => 'roll_end'],
                ['data' => 'status', 'name' => 'status'],
                ['data' => 'action', 'name' => 'action', 'orderable' => false]
            ],
            'sessions' => $this->sessionService->listByStatus(),
            'phases' => $this->phaseService->lists(),
            'courses' => $this->courseService->lists(),
            'departments' => $this->departmentService->getAllDepartment(),
            'groupTypes' => $this->studentGroupTypeService->listByStatus(),
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
        $data = [
            'pageTitle' => self::moduleName,
            'sessions' => $this->sessionService->listByStatus(),
            'courses' => $this->courseService->lists(),
            'phases' => $this->phaseService->lists(),
            'groupTypes' => $this->studentGroupTypeService->listByStatus(),
        ];

        return view(self::moduleDirectory.'create', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StudentGroupRequest $request)
    {
        $studentGroup = $this->service->addStudentGroup($request);

        if ($studentGroup) {
            $request->session()->flash('success', setMessage('create', self::moduleName));
            return redirect()->route('student_group.index');
        }

        $request->session()->flash('error', setMessage('create.error', self::moduleName));
        return redirect()->route('student_group.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\StudentGroup  $studentGroup
     * @return \Illuminate\Http\Response
     */
    public function show(StudentGroup $studentGroup)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\StudentGroup  $studentGroup
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $studentGroup = $this->service->find($id);
        $students = $this->studentService->getStudentsRollBySessionCoursePhase($studentGroup->session_id, $studentGroup->course_id, $studentGroup->phase_id);
        $studentRoll = $studentGroup->students()->pluck('roll_no')->toArray();
        $subjects = $this->subjectService->getSubjectsBySessionIdCourseIdPhaseId($studentGroup->session_id, $studentGroup->course_id, $studentGroup->phase_id);
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
        $data = [
            'pageTitle' => self::moduleName,
            'sessions' => $this->sessionService->listByStatus(),
            'phases' => $this->phaseService->lists(),
            'courses' => $this->courseService->lists(),
            'studentGroup' => $studentGroup,
            'students' => $students,
            'studentRoll' => $studentRoll,
            'departments' => $departments,
            'groupTypes' => $this->studentGroupTypeService->listByStatus(),
        ];
        return view(self::moduleDirectory.'edit', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\StudentGroup  $studentGroup
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $studentGroup = $this->service->updateStudentGroup($request, $id);

        if ($studentGroup) {
            $request->session()->flash('success', setMessage('update', self::moduleName));
            return redirect()->route('student_group.index');
        }
        $request->session()->flash('error', setMessage('update.error', self::moduleName));
        return redirect()->route('student_group.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\StudentGroup  $studentGroup
     * @return \Illuminate\Http\Response
     */
    public function destroy(StudentGroup $studentGroup)
    {
        //
    }

    public function getMaxEndRollNumber(){
        return $this->service->getMaxEndRollOfStudentGroup();
    }

    public function getStudentGroupBySessionIdCourseIdAndGroupTypeId(Request $request){
        $studentGroups = [];

        if ($request->has(['sessionId', 'courseId', 'phaseId', 'studentGroupTypeId', 'departmentId'])) {
            $studentGroups = $this->service->getStudentGroupsBySessionCourseAndGroupTypeId($request->sessionId,
                $request->courseId, $request->phaseId, $request->studentGroupTypeId, $request->departmentId);
        }

        return response()->json(['status' => true, 'data' => $studentGroups]);
    }

    public function getStudentGroupBySubject(Request $request)
    {
        $departmentId = $this->subjectService->find($request->subjectId)->department_id;
        if ($request->has('categoryId')) {
            // Get the current group type (dynamically based on exam_category_id)
            $groupType = StudentGroupType::whereHas('examCategories', function ($query) use ($request) {
                $query->where('exam_category_id', $request->categoryId);
            })->first();
        } elseif ($request->has('classTypeId')) {
            $groupType = StudentGroupType::whereHas('classTypes', function ($query) use ($request) {
                $query->where('class_type_id', $request->classTypeId);
            })->first();
        }
        // Fallback if not found
        $type = $groupType->id ?? null;

        return $this->service->getStudentGroupsBySessionCourseAndGroupTypeId($request->sessionId, $request->courseId, $request->phaseId, $type, $departmentId);
    }
}
