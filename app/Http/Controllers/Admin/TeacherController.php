<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\TeacherRequest;
use App\Http\Requests\TeacherUpdateRequest;
use App\Models\TeacherEvaluationStatement;
use App\Services\Admin\CourseService;
use App\Services\Admin\DepartmentService;
use App\Services\Admin\DesignationService;
use App\Services\Admin\TeacherService;
use App\Services\Admin\UserGroupService;
use App\Models\Teacher;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;
use PDF;

class TeacherController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Response
     */
    protected $teacherService;
    protected $departmentService;
    protected $designationService;
    protected $courseService;
    protected $userGroupService;

    protected $redirectUrl;

    public function __construct(
        TeacherService $teacherService,
        DepartmentService $departmentService,
        DesignationService $designationService,
        CourseService $courseService,
        UserGroupService $userGroupService
    ) {
        $this->redirectUrl = 'admin/teacher';
        $this->teacherService = $teacherService;
        $this->departmentService = $departmentService;
        $this->designationService = $designationService;
        $this->courseService = $courseService;
        $this->userGroupService = $userGroupService;
    }


    public function index()
    {
        $data = [
            'pageTitle' => 'Teacher',
            'tableHeads' => ['Id', 'Image', 'Name', 'User Id', 'User Group', 'Designation', 'Department', 'Phone', 'Email', 'Course', 'Status', 'Action'],
            'dataUrl' => $this->redirectUrl . '/get-data',
            'columns' => [
                ['data' => 'id', 'name' => 'id'],
                ['data' => 'photo', 'name' => 'photo'],
                ['data' => 'name', 'name' => 'name'],
                ['data' => 'user_id', 'name' => 'user_id'],
                ['data' => 'user_group', 'name' => 'user_group'],
                ['data' => 'designation_id', 'name' => 'designation_id'],
                ['data' => 'department_id', 'name' => 'department_id'],
                ['data' => 'phone', 'name' => 'phone'],
                ['data' => 'email', 'name' => 'email'],
                ['data' => 'course_id', 'name' => 'course_id'],
                ['data' => 'status', 'name' => 'status'],
                ['data' => 'action', 'name' => 'action', 'orderable' => false]
            ],
        ];

        //get all department
        $data['departments'] = $this->departmentService->getAllDepartment();
        //get all course
        $data['courses'] = $this->courseService->listByStatus();

        return view('teacher.index', $data);
    }

    public function getData(Request $request)
    {

        return $this->teacherService->getAllData($request);
    }

    /**
     * Show the form for creating a new resource.
     * @return View
     */
    public function create()
    {
        $data = [
            'pageTitle' => 'Teacher Create',
        ];

        //get all department
        $data['departments'] = $this->departmentService->getAllDepartment();
        //get all designation
        $data['designations'] = $this->designationService->getAllDesignation();
        //get all course
        $data['courses'] = $this->courseService->listByStatus();

        return view('teacher.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param TeacherRequest $request
     *
     * @return Response
     */
    public function store(TeacherRequest $request)
    {
        //set email and phone share to zero if dont check
        if (!$request->exists('share_email')) {
            $request->merge(['share_email' => 0]);
        }
        if (!$request->exists('share_phone')) {
            $request->merge(['share_phone' => 0]);
        }
        $teacher = $this->teacherService->saveTeacher($request);

        if ($teacher) {
            $request->session()->flash('success', setMessage('create', 'Teacher'));

            return redirect()->route('teacher.index');
        }
        $request->session()->flash('error', setMessage('create.error', 'Teacher'));

        return redirect()->route('teacher.index');
    }

    /**
     * Display the specified resource.
     *
     * @param $id
     *
     * @return View
     */
    public function show($id)
    {
        $teacher = $this->teacherService->find($id);

        // Load evaluations for this teacher and calculate statistics
        $teacher->load('evaluations');
        $roleModelPercentage = $teacher->getRoleModelPercentage();
        $totalEvaluations = $teacher->evaluations()->count();
        $averageRating = $teacher->getAverageRating();

        $data = [
            'pageTitle'           => 'Teacher Detail',
            'teacher'             => $teacher,
            'teacherWiseClass'    => $this->teacherService->teacherDetailClass($id),
            'averageRating'       => round($averageRating, 2),
            'roleModelPercentage' => round($roleModelPercentage, 2),
            'totalEvaluations'    => $totalEvaluations,
        ];

        return view('teacher.view', $data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param $id
     *
     * @return View
     */
    public function edit($id): View
    {
        $data = [
            'pageTitle' => 'Edit Teacher',
            'teacher' => $this->teacherService->find($id),
        ];
        //get all department
        $data['departments'] = $this->departmentService->getAllDepartment();
        //get all designation
        $data['designations'] = $this->designationService->getAllDesignation();
        //get all course
        $data['courses'] = $this->courseService->getAllCourse();
        //get teacher user group
        $data['userGroups'] = $this->userGroupService->getTeacherUserGroup();

        return view('teacher.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param Teacher $teacher
     *
     * @return Response
     */
    public function update(TeacherUpdateRequest $request, $id)
    {
        //set email and phone share to zero if dont check
        if (!$request->exists('share_email')) {
            $request->merge(['share_email' => 0]);
        }
        if (!$request->exists('share_phone')) {
            $request->merge(['share_phone' => 0]);
        }

        //$request['password'] = Hash::make($request->input('password'));

        $request['password'] = Hash::make($request->input('password'));

        $teacher = $this->teacherService->updateTeacher($request, $id);

        if ($teacher) {
            $request->session()->flash('success', setMessage('update', 'Teacher'));
            return redirect()->route('teacher.index');
        }

        $request->session()->flash('error', setMessage('update.error', 'Teacher'));
        return redirect()->route('teacher.index');
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param Teacher $teacher
     *
     * @return Response
     */
    public function destroy(Teacher $teacher)
    {
        //
    }

    // Teacher Change password
    public function changePasswordForm($id)
    {
        if (Auth::guard('web')->check()) {
            $user = Auth::guard('web')->user();
            if ($user->user_group_id == 4) {
                if ($user->teacher->id != $id) {
                    return redirect()->route('teacher.index');
                }
            }
        } else {
            return redirect()->route('teacher.index');
        }

        $data = [
            'pageTitle' => 'Teacher',
            'teacherId' => $id,
        ];

        return view('teacher.change_password', $data);
    }

    public function changePassword(Request $request, $id)
    {

        $changePassword = $this->teacherService->changePassword($request, $id);

        if ($changePassword) {
            $request->session()->flash('success', setMessage('update', 'Password'));
            return redirect()->route('teacher.index');
        }

        $request->session()->flash('error', setMessage('update.error', 'Password'));
        return redirect()->route('teacher.index');
    }


    public function getTeachersBySubjectId(Request $request)
    {
        $teachers = $this->teacherService->getTeachersBySubjectId($request->subjectId);

        return response()->json(['status' => true, 'data' => $teachers]);
    }

    //check teacher name is unique
    public function checkTeacherUserNameUnique(Request $request)
    {
        $checkUserName = $this->teacherService->checkTeacherUserNameIsUnique($request);

        if (empty($checkUserName)) {
            return 'true';
        }

        return 'false';
    }

    //check teacher email is unique
    public function teacherUniqueEmailCheck(Request $request)
    {
        $check = $this->teacherService->checkTeacherEmailIsUnique($request);
        if (empty($check)) {
            return 'true';
        }
        return 'false';
    }

    public function teacherUniquePhoneCheck(Request $request)
    {
        $check = $this->teacherService->checkTeacherPhoneIsUnique($request);
        if (empty($check)) {
            return 'true';
        }

        return 'false';
    }

    // Teacher Attendance PDF
    public function attendancePdf($id)
    {
        $teacher = $this->teacherService->find($id);
        $teacherWiseClass = $this->teacherService->teacherDetailClass($id);

        $data = [
            'pageTitle' => 'Teacher Attendance',
            'teacher' => $teacher,
            'teacherWiseClass' => $teacherWiseClass,
        ];

        $document = 'teacher_attendance_' . $teacher->full_name . '.pdf';
        return PDF::loadView('teacher.pdf.attendance', $data)->stream($document);
    }
}
