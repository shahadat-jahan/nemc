<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StudentAttachments;
use App\Models\ExamSubject;
use App\Models\Student;
use App\Models\User;
use App\Services\Admin\Admission\StudentGroupService;
use App\Services\Admin\AttendanceService;
use App\Services\Admin\BatchTypeService;
use App\Services\Admin\CardService;
use App\Services\Admin\CourseService;
use App\Services\Admin\EducationBoardService;
use App\Services\Admin\ExamCategoryService;
use App\Services\Admin\ExamService;
use App\Services\Admin\PaymentTypeService;
use App\Services\Admin\PhaseService;
use App\Services\Admin\SessionService;
use App\Services\Admin\StudentCategoryService;
use App\Services\Admin\StudentService;
use App\Services\Admin\SubjectService;
use App\Services\Admin\TermService;
use App\Services\AttachmentService;
use App\Services\CountryService;
use App\Services\ResultService;
use App\Services\Setting\Facades\Setting;
use App\Services\StudentFeeService;
use App\Services\UtilityServices;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class StudentController extends Controller
{
    /**
     *
     */
    const moduleName = 'Student Management';
    /**
     *
     */
    const redirectUrl = 'admin/students';
    /**
     *
     */
    const moduleDirectory = 'students.';

    protected $service;
    protected $sessionService;
    protected $courseService;
    protected $studentCategoryService;
    protected $phaseService;
    protected $country;
    protected $educationBoardService;
    protected $attachmentService;
    protected $studentFeeService;
    protected $paymentService;
    protected $termService;
    protected $batchTypeService;
    protected $subjectService;
    protected $attendanceService;
    protected $cardService;
    protected $examCategoryService;
    protected $resultService;
    protected $studentGroupService;
    protected $examService;

    public function __construct(
        StudentService    $service,
        SessionService $sessionService,
        CourseService $courseService,
        StudentCategoryService $studentCategoryService,
        PhaseService      $phaseService,
        CountryService $country,
        EducationBoardService $educationBoardService,
        AttachmentService $attachmentService,
        StudentFeeService $studentFeeService,
        PaymentTypeService $paymentService,
        TermService $termService,
        BatchTypeService $batchTypeService,
        SubjectService    $subjectService,
        AttendanceService $attendanceService,
        CardService $cardService,
        ExamCategoryService $examCategoryService,
        ResultService $resultService,
        StudentGroupService $studentGroupService,
        ExamService $examService
    ) {
        $this->service               = $service;
        $this->sessionService        = $sessionService;
        $this->courseService         = $courseService;
        $this->studentCategoryService = $studentCategoryService;
        $this->phaseService          = $phaseService;
        $this->country               = $country;
        $this->educationBoardService = $educationBoardService;
        $this->attachmentService     = $attachmentService;
        $this->studentFeeService     = $studentFeeService;
        $this->paymentService        = $paymentService;
        $this->termService           = $termService;
        $this->batchTypeService      = $batchTypeService;
        $this->subjectService        = $subjectService;
        $this->attendanceService     = $attendanceService;
        $this->cardService           = $cardService;
        $this->examCategoryService   = $examCategoryService;
        $this->resultService         = $resultService;
        $this->studentGroupService   = $studentGroupService;
        $this->examService = $examService;
    }

    /**
     * Display a listing of the resource.
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = [
            'pageTitle'     => 'Student List',
            'tableHeads'    => [
                'User ID',
                'Name',
                'Roll No',
                'Session',
                'Course',
                'Phase',
                'Term',
                'Category',
                'Batch',
                'Installments',
                'Status',
                'Action'
            ],
            'dataUrl'       => self::redirectUrl . '/get-data',
            'columns'       => [
                ['data' => 'user_id', 'name' => 'user_id'],
                ['data' => 'full_name_en', 'name' => 'full_name_en'],
                ['data' => 'roll_no', 'name' => 'roll_no'],
                ['data' => 'session_id', 'name' => 'session_id'],
                ['data' => 'course_id', 'name' => 'course_id'],
                ['data' => 'phase_id', 'name' => 'phase_id'],
                ['data' => 'term_id', 'name' => 'term_id'],
                ['data' => 'student_category_id', 'name' => 'student_category_id'],
                ['data' => 'batch_type_id', 'name' => 'batch_type_id'],
                ['data' => 'clear_installment', 'name' => 'clear_installment'],
                ['data' => 'status', 'name' => 'status'],
                ['data' => 'action', 'name' => 'action', 'orderable' => false]
            ],
            'sessions'      => $this->sessionService->listByStatus(),
            'courses'       => $this->courseService->lists(),
            'studentCategories' => $this->studentCategoryService->lists(),
            'phases'        => $this->phaseService->lists(),
            'studentStatus' => UtilityServices::$studentStatus,
        ];

        return view(self::moduleDirectory . 'index', $data);
    }

    /**
     * @param Request $request
     *
     * @return mixed
     */
    public function getData(Request $request)
    {
        return $this->service->getDataTable($request);
    }

    /**
     * Show the form for creating a new resource.
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data = [
            'pageTitle'       => self::moduleName,
            'sessions'        => $this->sessionService->listByStatus(),
            'courses'         => $this->courseService->lists(),
            'studentCategories' => $this->studentCategoryService->lists(),
            'countries'       => $this->country->lists(),
            'certifications'  => UtilityServices::$certificates,
            'educationBoards' => $this->educationBoardService->listByStatus(),
            'attachmentTypes' => $this->attachmentService->getListOfAttachmentTypes(),
        ];

        return view(self::moduleDirectory . 'add', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if ($request->student_category_id != 2) {
            $validator = Validator::make($request->all(), [
                'reg_no' => 'unique:students,reg_no',
                'mobile' => 'required|regex:/^(?=.*[1-9])[0-9]{11}$/|unique:students,mobile',
                'father_phone' => 'required|regex:/^(?=.*[1-9])[0-9]{11}$/|unique:guardians,father_phone'
            ]);
        } else {
            $validator = Validator::make($request->all(), [
                'reg_no' => 'unique:students,reg_no',
                'mobile' => 'required|regex:/^\+\d{1,3}(?:[-.\s]?\(?\d{1,4}\)?)?[-.\s]?\d{1,6}[-.\s]?\d{1,10}$/|unique:students,mobile',
                'father_phone' => 'required|regex:/^\+\d{1,3}(?:[-.\s]?\(?\d{1,4}\)?)?[-.\s]?\d{1,6}[-.\s]?\d{1,10}$/|unique:guardians,father_phone'
            ]);
        }

        if ($validator->fails()) {
            $request->session()->flash('error', setMessage('create.error', 'Student'));
            return redirect()
                ->back()
                ->withErrors($validator)
                ->withInput();
        }

        $student = $this->service->addStudent($request);

        if ($student) {
            $request->session()->flash('success', setMessage('create', 'Student'));
        } elseif ($student == null) {
            $request->session()->flash('success', setMessage('create', 'Student has created, you can not add multiple student with same mobile number'));
        } else {
            $request->session()->flash('error', setMessage('create.error', 'Student'));
        }
        return redirect()->route('students.index');
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Student $student
     *
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $data = [
            'pageTitle'     => self::moduleName,
            'student'       => $this->service->find($id),
            'educationLevel' => UtilityServices::$certificates,
            'studentStatus' => UtilityServices::$studentStatus
        ];

        return view(self::moduleDirectory . 'view', $data);
    }

    public function studentsProfile(Request $request)
    {
        $user = User::where('user_id', $request->student_user_id)->first();
        $student = $this->service->findBy(['user_id' => $user->id]);
        return redirect(route('students.show', $student->id));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Student $student
     *
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data = [
            'pageTitle'       => self::moduleName,
            'student'         => $this->service->find($id),
            'sessions'        => $this->sessionService->listByStatus(),
            'courses'         => $this->courseService->lists(),
            'studentCategories' => $this->studentCategoryService->lists(),
            'countries'       => $this->country->lists(),
            'certifications'  => UtilityServices::$certificates,
            'educationBoards' => $this->educationBoardService->listByStatus(),
            'attachmentTypes' => $this->attachmentService->getListOfAttachmentTypes(),
            'phases'          => $this->phaseService->listByStatus(),
            'terms'           => $this->termService->listByStatus(),
            'batches'         => $this->batchTypeService->listByStatus(),
            'studentStatus'   => UtilityServices::$studentStatus,
        ];

        return view(self::moduleDirectory . 'edit', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Student $student
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        if ($request->student_category_id != 2) {
            $validator = Validator::make($request->all(), [
                'reg_no' => 'unique:students,reg_no,' . $id,
                'mobile' => 'required|regex:/^(?=.*[1-9])[0-9]{11}$/|unique:students,mobile,' . $id
            ]);
        } else {
            $validator = Validator::make($request->all(), [
                'reg_no' => 'unique:students,reg_no,' . $id,
                'mobile' => 'required|regex:/^\+\d{1,3}(?:[-.\s]?\(?\d{1,4}\)?)?[-.\s]?\d{1,6}[-.\s]?\d{1,10}$/|unique:students,mobile,' . $id
            ]);
        }

        if ($validator->fails()) {
            $request->session()->flash('error', setMessage('update.error', 'Student'));
            return redirect()
                ->back()
                ->withErrors($validator)
                ->withInput();
        }

        $student = $this->service->updateStudent($request, $id);

        if ($student) {
            $request->session()->flash('success', setMessage('update', 'Student'));
        } else {
            $request->session()->flash('error', setMessage('update.error', 'Student'));
        }
        return redirect()->route('students.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Student $student
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(Student $student)
    {
        //
    }

    /**
     * @param Request $request
     *
     * @return string
     */
    public function checkStudentDataUnique(Request $request)
    {
        if ($request->has('student_id')) {
            $column = 'student_id';
            $value = $request->student_id;
        } else if ($request->has('roll_no')) {
            $column = 'roll_no';
            $value = $request->roll_no;
        } else if ($request->has('email')) {
            $column = 'email';
            $value = $request->email;
        }

        if ($request->has('id')) {
            $check = $this->service->getStudentByCourseIdAndSessionId($request->phase_id, $request->course_id, $request->session_id, $column, $value, $request->id);
        } else {
            $check = $this->service->getStudentByCourseIdAndSessionId($request->phase_id, $request->course_id, $request->session_id, $column, $value);
        }

        if (empty($check)) {
            return 'true';
        }
        return 'false';
    }

    //check student mobile uniqueness
    public function checkStudentMobileUnique(Request $request)
    {
        $check = $this->service->checkStudentMobileIsUnique($request);

        if (empty($check)) {
            return 'true';
        }
        return 'false';
    }

    public function checkStudentRegistrationUnique(Request $request)
    {
        $check = $this->service->checkStudentRegistrationIsUnique($request);

        if (empty($check)) {
            return 'true';
        } else {
            return 'false';
        }
    }

    /**
     * @param Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function getBatchInfo(Request $request)
    {
        $sessionId = $request->input('sessionId');
        $courseId = $request->input('courseId');

        $sessionDetail = $this->sessionService->getSessionDetailBySessionIdAndCourseId($sessionId, $courseId);
        //dd($sessionDetail->session);
        if ($sessionDetail) {
            $rollNo   = $this->service->getTotalStudentsBySessionAndCourse($sessionId, $courseId);
            $response = [
                'student_id' => $this->service->generateStudentId($sessionId, $courseId, $sessionDetail->batch_number, $sessionDetail->session),
                'roll_no' => $rollNo + 1,
                'user_id' => $sessionDetail->batch_number . ($rollNo + 1)
            ];
            return response()->json(['status' => true, 'data' => $response]);
        }

        return response()->json(['status' => false, 'data' => []]);
    }

    /**
     * @param Request $request
     *
     * @return mixed
     */
    public function getListsBySessionIdAndCourseId(Request $request)
    {
        $sessionId = $request->input('sessionId');
        $courseId = $request->input('courseId');

        return $this->service->getAllStudentBySessionAndCourseId($sessionId, $courseId);
    }

    /**
     * @param $id
     *
     * @return array|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function installmentsList($id)
    {
        $student = $this->service->find($id);
        $data = [
            'pageTitle'    => 'Installments for ' . $student->full_name_en,
            /*'tableHeads' => ['Id', 'Title', 'Payable Amount', 'Last Date of Payment','Paid Amount', 'Status'],*/
            'tableHeads'   => ['Id', 'Title', 'Payable Amount', 'Last Date of Payment', 'Status'],
            'dataUrl'      => self::redirectUrl . '/' . $student->id . '/installment/data-table',
            'columns'      => [
                ['data' => 'id', 'name' => 'id'],
                ['data' => 'title', 'name' => 'title'],
                ['data' => 'payable_amount', 'name' => 'payable_amount'],
                ['data' => 'last_date_of_payment', 'name' => 'last_date_of_payment'],
                /*['data' => 'paid_amount', 'name' => 'paid_amount'],*/
                ['data' => 'status', 'name' => 'status']
                /*['data' => 'action', 'name' => 'action', 'orderable' => false]*/
            ],
            'student'      => $student,
            'totalInstallmentFee' => $this->studentFeeService->getTotalPayableAmountByPaymentIdAndStudentId(1, $id),
            'installments' => $this->studentFeeService->getStudentInstallments($id)->where('status', '!=', 0),

        ];
        //dd($data);

        return view(self::moduleDirectory . 'installments', $data);
    }

    /**
     * @param Request $request
     * @param         $id
     *
     * @return mixed
     */
    public function installmentsListDataTable(Request $request, $id)
    {
        return $this->studentFeeService->getInstallmentsDataTable($request, $id);
    }

    /**
     * @param $id
     *
     * @return array|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function makeInstallments($id)
    {
        $student = $this->service->find($id);
        $sessionInfo = $student->session->sessionDetails->filter(function ($item) use ($student) {
            return ($item->course_id == $student->course_id);
        });
        //dd($student);

        if ($student->student_category_id == 2) {
            $developmentFee = $sessionInfo->first()->development_fee_foreign;
        } else if ($student->student_category_id > 2) {
            $developmentFee = $this->paymentService->getPaymentDetailByTypeIdAndCourseIdAndCategoryId(1, $student->course_id, $student->student_category_id)->amount;
        } else {
            $developmentFee = $sessionInfo->first()->development_fee_local;
        }

        $data = [
            'pageTitle' => self::moduleName,
            'student'   => $student,
            'developmentFee' => $developmentFee,
        ];

        return view(self::moduleDirectory . 'make_installment', $data);
    }

    /**
     * @param Request $request
     * @param         $id
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function saveInstallments(Request $request, $id)
    {
        $request->merge(['fee_title' => 'Development Fee']);

        $installments = $this->studentFeeService->saveStudentInstallment($request, $id);

        if ($installments) {
            $request->session()->flash('success', setMessage('create', 'Installments'));
            return redirect()->route('students.installment.list', [$id]);
        }
        $request->session()->flash('error', setMessage('create.error', 'Installments'));
        return redirect()->route('students.installment.list', [$id]);
    }

    public function editInstallments($id)
    {
        $student = $this->service->find($id);
        $sessionInfo = $student->session->sessionDetails->filter(function ($item) use ($student) {
            return ($item->course_id == $student->course_id);
        });

        if ($student->student_category_id == 2) {
            $developmentFee = $sessionInfo->first()->development_fee_foreign;
        } else if ($student->student_category_id > 2) {
            $developmentFee = $this->paymentService->getPaymentDetailByTypeIdAndCourseId(1, $student->course_id)->amount;
        } else {
            $developmentFee = $sessionInfo->first()->development_fee_local;
        }

        $installments = $this->studentFeeService->getStudentInstallments($id);

        $data = [
            'pageTitle'    => 'Edit Installment',
            'student'      => $student,
            'developmentFee' => $developmentFee,
            'installments' => $installments,
        ];

        return view(self::moduleDirectory . 'edit_installment', $data);
    }

    public function updateInstallments(Request $request, $studentId)
    {
        $installments = $this->studentFeeService->updateStudentInstallment($request, $studentId);

        if ($installments) {
            $request->session()->flash('success', setMessage('create', 'Installments'));
            return redirect()->route('students.installment.list', [$studentId]);
        }
        $request->session()->flash('error', setMessage('create.error', 'Installments'));
        return redirect()->route('students.installment.list', [$studentId]);
    }

    /**
     * @param $id
     *
     * @return array|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getAttachmentsList($id)
    {
        $student = $this->service->find($id);
        $data = [
            'pageTitle' => 'Attachments of ' . $student->full_name_en,
            'tableHeads' => ['Id', 'Attachment Type', 'Document Type', 'Remarks', 'Upload Time', 'Action'],
            'dataUrl'   => self::redirectUrl . '/' . $student->id . '/attachment/data-table',
            'columns'   => [
                ['data' => 'id', 'name' => 'id'],
                ['data' => 'attachment_type_id', 'name' => 'attachment_type_id'],
                ['data' => 'type', 'name' => 'type'],
                ['data' => 'remarks', 'name' => 'remarks'],
                ['data' => 'created_at', 'name' => 'created_at'],
                ['data' => 'action', 'name' => 'action', 'orderable' => false]
            ],
            'student'   => $student,
        ];

        return view(self::moduleDirectory . 'attachments.index', $data);
    }

    /**
     * @param Request $request
     * @param         $id
     *
     * @return mixed
     */
    public function attachmentsListDataTable(Request $request, $id)
    {
        return $this->attachmentService->getAttachmentsDataTableByStudentId($request, $id);
    }

    public function addAttachment($id)
    {
        $student = $this->service->find($id);

        $data = [
            'pageTitle' => self::moduleName,
            'student'   => $student,
            'attachmentTypes' => $this->attachmentService->getListOfAttachmentTypes(),
        ];

        return view(self::moduleDirectory . 'attachments.add', $data);
    }

    public function saveAttachments(StudentAttachments $request, $id)
    {
        $attachments = $this->attachmentService->addAttachments($request, $id);

        if ($attachments) {
            $request->session()->flash('success', setMessage('create', 'Attachment'));
            return redirect()->route('students.attachment.list', [$id]);
        }
        $request->session()->flash('error', setMessage('create.error', 'Attachment'));
        return redirect()->route('students.attachment.list', [$id]);
    }

    public function deleteAttachment($studentId, $id)
    {
        $attachment = $this->attachmentService->deleteAttachment($id);

        if ($attachment) {
            return response()->json(['status' => true, 'message' => 'Attachment Deleted']);
        }
        return response()->json(['status' => true, 'message' => 'Error in deleting Attachment']);
    }

    public function getStudentsBySessionCoursePhaseTerm(Request $request)
    {
        if (!$request->filled(['sessionId', 'courseId', 'phaseId'])) {
            return response()->json(['status' => false, 'message' => 'Missing required parameters'], 400);
        }

        $exam = null;
        if ($request->filled('examId') && !empty($request->examId)) {
            $exam = $this->examService->find($request->examId);
        }

        if ($exam && $exam->exam_category_id == 5 && $exam->main_exam_id != null) {
            $students = $this->resultService->getFailedStudentsByExam($exam->main_exam_id, $request->subjectId);
        } else {
            $students = $this->service->findBy([
                'followed_by_session_id' => $request->sessionId,
                'course_id'              => $request->courseId,
                'phase_id'               => $request->phaseId,
                'batch_type_id'          => 1,
                'status'                 => [1, 3],
            ], 'list')->sortBy('roll_no');

            if ($request->boolean('oldStudents') || $request->filled('examId')) {
                $oldStudents = $this->service->getCurrentSessionOldStudentsByPhaseTermCourse(
                    $request->phaseId,
                    null,
                    $request->sessionId,
                    $request->courseId
                );
                $students    = $students->merge($oldStudents);
            }

            if ($request->filled('examId')) {
                $examSubjects = ExamSubject::where('exam_id', $request->examId)->get();
                if ($examSubjects->isNotEmpty() && $examSubjects->whereIn('exam_type_id', [1, 3])->count() == 0) {
                    $examStudents = $examSubjects->flatMap->studentGroups->flatMap->students->unique('id');
                    if ($examStudents->isNotEmpty()) {
                        $students     = $students->whereIn('id', $examStudents->pluck('id'));
                    }
                }
            }

            if ($request->filled(['studentGroupId', 'itemId']) && $request->studentGroupId !== 'all') {
                $studentGroup = $this->studentGroupService->find($request->studentGroupId);
                if ($studentGroup) {
                    $studentGroupIds = $studentGroup->students->pluck('id');
                    $students        = $students->whereIn('id', $studentGroupIds);
                } else {
                    $students = collect();
                }
            }
        }

        return response()->json(['status' => true, 'students' => $students->values()]);
    }

    //generate student id card
    public function generateIdCard($studentId)
    {
        $data['studentInfo'] = $this->service->getStudentIdCardData($studentId);
        return view(self::moduleDirectory . 'id_card', $data);
    }

    //print student id card
    public function printIdCard($studentId)
    {
        $data['studentInfo'] = $this->service->getStudentIdCardData($studentId);
        return view(self::moduleDirectory . 'id_card_print', $data);
    }

    //generate student testimonial
    public function generateTestimonial($studentId)
    {
        $data['studentInfo'] = $this->service->getStudentTestimonialData($studentId);
        return view(self::moduleDirectory . 'testimonial', $data);
    }

    //print student testimonial
    public function printTestimonial($studentId)
    {
        $data['studentInfo'] = $this->service->getStudentTestimonialData($studentId);
        return view(self::moduleDirectory . 'testimonial_print', $data);
    }

    public function getAttendanceByStudent($id)
    {
        $student = $this->service->find($id);
        $subjects = $this->subjectService->getSubjectsBySessionIdCourseIdPhaseId($student->session_id, $student->course_id, $student->phase_id);
        if (!$student->studentGroups->isEmpty()) {
            $student_group_id = $student->studentGroups->first()->id;
        } else {
            $student_group_id = null;
        }

        foreach ($subjects as $subject) {
            //$totalLectureClass[$subject->id] = $this->attendanceService->getTotalClassBySubjectId($student->id, $student->session_id, $student->course_id, $student->phase_id, $subject->id, [1], true);
            //$totalTutorialClass[$subject->id] = $this->attendanceService->getTotalClassBySubjectGroupId($student->id, $student->session_id, $student->course_id, $student->phase_id, $subject->id, [1,6,7,9]);
            $totalLectureClass[$subject->id]        = $this->attendanceService->getTotalClassBySubjectGroupId($student->session_id, $student->course_id, $student->phase_id, null, $subject->subject_group_id, [1], true);
            $totalTutorialClass[$subject->id]       = $this->attendanceService->getTotalClassBySubjectGroupId($student->session_id, $student->course_id, $student->phase_id, null, $subject->subject_group_id, [
                1, 6, 7, 9
            ], false, null, null, $student_group_id);
            $totalLectureClassAttend[$subject->id]  = $this->attendanceService->getTotalAttendanceBySessionCoursePhaseSubjectAndStudentId($student->session_id, $student->course_id, $student->phase_id, $subject->id, $id, [1], true);
            $totalTutorialClassAttend[$subject->id] = $this->attendanceService->getTotalAttendanceBySessionCoursePhaseSubjectAndStudentId($student->session_id, $student->course_id, $student->phase_id, $subject->id, $id, [
                1, 6, 7, 9
            ]);
        }
        unset($subject);
        $data = [
            'pageTitle'               => 'Student Attendance',
            'student'                 => $student,
            'sessionPhases'           => $this->sessionService->getSessionPhaseDetailBySessionIdAndCourseId($student->session_id, $student->course_id),
            'subjects'                => $subjects,
            'totalLectureClass'       => $totalLectureClass,
            'totalTutorialClass'      => $totalTutorialClass,
            'totalLectureClassAttend' => $totalLectureClassAttend,
            'totalTutorialClassAttend' => $totalTutorialClassAttend,
            'studentStatus'           => UtilityServices::$studentStatus
        ];

        return view(self::moduleDirectory . 'attendance.index', $data);
    }

    public function getAttendanceByStudentAndPhase(Request $request, $id)
    {
        $student = $this->service->find($id);
        $subjects = $this->subjectService->getSubjectsBySessionIdCourseIdPhaseId($student->session_id, $student->course_id, $request->phaseId);

        $totalLecturePercent = 0;
        $totalTutorialPercent = 0;
        foreach ($subjects as $subject) {
            $percentLecture = 0;
            $percentTutorial = 0;
            $percentTotal   = 0;

            $totalLectureClass        = $this->attendanceService->getTotalClassBySubjectId($student->session_id, $student->course_id, $request->phaseId, $subject->id, [1], []);
            $totalLectureClassAttend  = $this->attendanceService->getTotalAttendanceBySessionCoursePhaseSubjectAndStudentId($student->session_id, $student->course_id, $request->phaseId, $subject->id, $id, [1], true);
            $totalTutorialClass       = $this->attendanceService->getTotalClassBySubjectId($student->session_id, $student->course_id, $request->phaseId, $subject->id, [
                1, 6, 7, 9
            ], []);
            $totalTutorialClassAttend = $this->attendanceService->getTotalAttendanceBySessionCoursePhaseSubjectAndStudentId($student->session_id, $student->course_id, $request->phaseId, $subject->id, $id, [
                1, 6, 7, 9
            ]);

            if (!empty($totalLectureClass[$subject->id])) {
                $totalLecturePercent = round((($totalLectureClassAttend[$subject->id] * 100) / $totalLectureClass[$subject->id]), 2);
            }
            if (!empty($totalTutorialClass[$subject->id])) {
                $totalTutorialPercent = round((($totalTutorialClassAttend[$subject->id] * 100) / $totalTutorialClass[$subject->id]), 2);
            }
            if (!empty($totalLectureClass[$subject->id]) || !empty($totalTutorialClass[$subject->id])) {
                $percentTtotal = round(((($totalTutorialClassAttend[$subject->id] + $totalLectureClassAttend[$subject->id]) * 100) / ($totalLectureClass[$subject->id] + $totalTutorialClass[$subject->id])), 2);
            }

            $subject->totalLectureClass       = $totalLectureClass;
            $subject->totalLectureClassAttend = $totalLectureClassAttend;
            $subject->totalTutorialClass      = $totalTutorialClass;
            $subject->totalTutorialClassAttend = $totalTutorialClassAttend;
            $subject->totalLecturePercent     = $totalLecturePercent;
            $subject->totalTutorialPercent    = $totalTutorialPercent;
            $subject->totalClass              = $totalLectureClass + $totalTutorialClass;
            $subject->totalAttend             = $totalLectureClassAttend + $totalTutorialClassAttend;
            $subject->percentTotal            = $percentTotal;
        }
        unset($subject);

        return response()->json([
            'status' => true, 'subjects' => $subjects
        ]);
    }

    public function getCardItemsByStudent($id)
    {
        $student = $this->service->find($id);
        $subjects = $this->subjectService->getSubjectsBySessionIdCourseIdPhaseId($student->session_id, $student->course_id, $student->phase_id);

        foreach ($subjects as $subject) {
            $cardItems[$subject->id] = $this->cardService->getCardsItemsAndStudentResultBySubjectStudentAndPhaseId($subject->id, $id, $student->phase_id);
        }
        unset($subject);

        $data = [
            'pageTitle'     => 'Items & Cards',
            'student'       => $student,
            'sessionPhases' => $this->sessionService->getSessionPhaseDetailBySessionIdAndCourseId($student->session_id, $student->course_id),
            'subjects'      => $subjects,
            'cardItems'     => $cardItems,
            'studentStatus' => UtilityServices::$studentStatus
        ];

        return view(self::moduleDirectory . 'card_items.index', $data);
    }

    public function getCardItemsByStudentAndPhase(Request $request, $id)
    {
        $student              = $this->service->find($id);
        $subjects = $this->subjectService->getSubjectsBySessionIdCourseIdPhaseId($student->session_id, $student->course_id, $request->phaseId);

        foreach ($subjects as $subject) {
            $cardItems = $this->cardService->getCardsItemsAndStudentResultBySubjectStudentAndPhaseId($subject->id, $id, $request->phaseId);
            foreach ($cardItems->groupBy('term_id') as $termId => $cards) {
                $term = $termId - 1;

                $cardData = [];
                foreach ($cards as $key => $card) {
                    $totalItem = $card->cardItems->count();
                    $itemPass = 0;
                    foreach ($card->cardItems as $item) {
                        if (!empty($item->examSubjects->count())) {
                            if (!empty($item->examSubjects->first()->exam->examMarks->count())) {
                                if (!empty($item->examSubjects->first()->exam->examMarks->first()->result->count())) {
                                    if ($item->examSubjects->first()->exam->examMarks->first()->result->first()->pass_status == 1) {
                                        $itemPass++;
                                    }
                                }
                            }
                        }
                    }
                    $percentage = !empty($totalItem) ? round(($itemPass * 100) / $totalItem, 2) : 0;

                    $cardData[$key]['title']       = $card->title;
                    $cardData[$key]['total_items'] = $totalItem;
                    $cardData[$key]['item_cleared'] = $itemPass;
                    $cardData[$key]['percentage']  = $percentage;
                }

                $subject->terms = collect([
                    $term => [
                        'term_id' => $termId,
                        'cards' => $cardData,
                    ]
                ]);
            }
        }

        return response()->json([
            'status' => true, 'subjects' => $subjects
        ]);
    }

    public function getCardItemDetailByStudent($id, $cardId)
    {
        $student = $this->service->find($id);

        $data = [
            'pageTitle'     => 'Card Items',
            'cardItems'     => $this->cardService->getCardItemsByCardId($cardId),
            'student'       => $student,
            'studentStatus' => UtilityServices::$studentStatus
        ];

        return view(self::moduleDirectory . 'card_items.card_items', $data);
    }

    public function getExamResultByStudent(Request $request, $id)
    {
        $student = $this->service->find($id);
        $subjects = $this->subjectService->getSubjectsBySessionIdCourseIdPhaseId($student->followed_by_session_id, $student->course_id, $student->phase_id);

        $categoryId = $request->has('cat_id') ? $request->cat_id : 3;

        foreach ($subjects as $subject) {
            $examSubjects[$subject->id] = $this->resultService->getStudentResultBySubjectExamCategoryStudentAndPhaseId($subject->id, $categoryId, $id, $student->phase_id);
        }

        $data = [
            'pageTitle'     => 'Exam Results',
            'student'       => $student,
            'sessionPhases' => $this->sessionService->getSessionPhaseDetailBySessionIdAndCourseId($student->session_id, $student->course_id),
            'subjects'      => $subjects,
            'examSubjects'  => $examSubjects,
            'examCategories' => $this->examCategoryService->listByStatus(),
            'passStatus'    => UtilityServices::$passStatus,
            'studentStatus' => UtilityServices::$studentStatus,
        ];

        return view(self::moduleDirectory . 'exam_results.index', $data);
    }

    public function getExamResultByStudentAndPhase(Request $request, $id)
    {
        try {
            $student = $this->service->find($id);
            if (!$student) {
                return response()->json([
                    'status' => false,
                    'message' => 'Student not found'
                ], 404);
            }

            $subjects = $this->subjectService->getSubjectsBySessionIdCourseIdPhaseId(
                $student->followed_by_session_id,
                $student->course_id,
                $request->phaseId
            );

            foreach ($subjects as $subject) {
                $examSubjects = $this->resultService->getStudentResultBySubjectExamCategoryStudentAndPhaseId(
                    $subject->id,
                    $request->cat_id,
                    $id,
                    $request->phaseId
                );
                $resultArr = [];
                $total = 0;
                foreach ($examSubjects as $key => $examSubject) {
                    if (!empty($examSubject->exam->examMarks->toArray())) {
                        $examTotalMarks = $examSubject->exam->examMarks->sum('total_marks');
                        if (!empty($examSubject->exam->examMarks->first()->result->toArray())) {
                            $examTypeMarksArr = [];
                            $totalMarksByExamType = [];

                            foreach ($examSubject->exam->examMarks as $examMark) {
                                $examTypeId = $examMark->examSubType->examType->id ?? null;
                                if ($examTypeId && !isset($totalMarksByExamType[$examTypeId])) {
                                    $totalMarksByExamType[$examTypeId] = 0;
                                }
                                foreach ($examMark->result as $result) {
                                    $marks = $result->marks + $result->grace_marks;
                                    $total += $marks;
                                    if ($examTypeId) {
                                        $totalMarksByExamType[$examTypeId] += $marks;
                                    }
                                }

                                if ($examTypeId) {
                                    $examTypeMarksArr[$examTypeId] = isset($examTypeMarksArr[$examTypeId])
                                        ? $examTypeMarksArr[$examTypeId] + $examMark->total_marks
                                        : $examMark->total_marks;
                                }
                            }
                        }
                        $examTotalMarks = $total;
                        $total = 0;
                    }
                    // Initialize variables
                    $examMarksTotal = 0;
                    $total = 0;
                    $passPercentage = Setting::getSiteSetting()->pass_mark;
                    $resultStatus = '';
                    $textColor = '';
                    $remark = '';

                    // Get exam marks if available
                    $examMarks = $examSubject->exam->examMarks;
                    if ($examMarks->isNotEmpty()) {
                        $examMarksTotal = $examMarks->sum('total_marks');
                        // Calculate total marks from results
                        $firstResult = $examMarks->first()->result;
                        $special = $examMarks->first()->result->whereNotNull('special_status')->count();
                        $absent = $examMarks->first()->result->where('pass_status', 4)->count();
                        $grace = $examMarks->first()->result->whereNotNull('grace_marks')->count();
                        $totalGrace = $examMarks->first()->result->sum('grace_marks');
                        $failCount = 0;

                        // Handle special cases first
                        if ($special > 0) {
                            $isSpecialPass = $examMarks->first()->result->where('special_status', 1)->count() > 0;
                            $resultStatus = $isSpecialPass ? 'Pass(SC)' : 'Fail(SC)';
                            $textColor = $isSpecialPass ? 'text-info' : 'text-danger';
                        } else {
                            // Calculate pass/fail based on percentages - only needed if not special case
                            foreach ($examTypeMarksArr as $key => $totalPossibleMarks) {
                                if ($totalPossibleMarks > 0) {
                                    $actualMarks = $totalMarksByExamType[$key] ?? 0;
                                    $percentage = ($actualMarks * 100) / $totalPossibleMarks;

                                    if ($passPercentage > $percentage) {
                                        $failCount++;
                                        break;
                                    }
                                }
                            }
                            // Determine final status
                            if ($absent > 0) {
                                $resultStatus = 'Absent';
                                $textColor = 'text-warning';
                            } elseif ($failCount > 0) {
                                $resultStatus = 'Fail';
                                $textColor = 'text-danger';
                            } elseif ($grace > 0) {
                                $resultStatus = "Pass(Grace - $totalGrace)";
                                $textColor = 'text-info';
                            } else {
                                $resultStatus = 'Pass';
                                $textColor = 'text-success';
                            }
                        }
                    }

                    if (!empty($examSubject->exam->examMarks->first()->result->toArray())) {
                        $remark = $examSubject->exam->examMarks->first()->result->first()->remarks;
                    }

                    // Build a result array
                    $resultArr[$key] = [
                        'result_url' => route('exam.subject.result.show', [
                            'examId' => $examSubject->exam->id,
                            'subjectId' => $examSubject->subject_id,
                            'studentId' => $id
                        ]),
                        'title' => $examSubject->exam->title,
                        'term' => $examSubject->exam->term->title,
                        'total_marks' => $examMarksTotal . '/' . $examTotalMarks,
                        'resultStatus' => $resultStatus,
                        'textColor' => $textColor,
                        'remark' => $remark,
                        'action' => ''
                    ];
                }

                $subject->phase_id = $request->phaseId;
                $subject->examSubjects = $resultArr;
            }

            return response()->json([
                'status' => true,
                'subjects' => $subjects
            ]);
        } catch (\Exception $e) {
            \Log::error('Error in getExamResultByStudentAndPhase: ' . $e->getMessage());
            return response()->json([
                'status' => false,
                'message' => 'An error occurred while fetching exam results'
            ], 500);
        }
    }

    //change student password form
    public function changePasswordForm($id)
    {
        $data = [
            'pageTitle' => 'Student',
            'studentId' => $id,
        ];

        return view(self::moduleDirectory . 'change_password', $data);
    }

    //change student password
    public function changePassword(Request $request, $id)
    {
        $changePassword = $this->service->changePassword($request, $id);

        if ($changePassword) {
            $request->session()->flash('success', setMessage('update', 'Password'));
            return redirect()->route('students.index');
        }

        $request->session()->flash('error', setMessage('update.error', 'Password'));
        return redirect()->route('students.index');
    }

    public function fuzzySearch(Request $request)
    {
        $searchTerm = $request->get('search_term');
        if ($request->filled('search_column')) {
            $search_column = $request->get('search_column');
        } else {
            $search_column = 'full_name_en';
        }
        $query = DB::table('students')
            ->where('full_name_en', 'LIKE', "%$searchTerm%")
//            ->orWhere('registration_number', 'LIKE', "%$request->get('search_term')%")
            ->orWhere('roll_no', 'LIKE', "%$searchTerm%")
            ->orWhere('mobile', 'LIKE', "%$searchTerm%")
            ->select(DB::raw("CONCAT(full_name_en,' ',mobile) AS name"), 'id');

        $result = $query->get()->pluck('name', 'id')->toArray();
        return $result;
        return $result->pluck(DB::raw("CONCAT(full_name_en,' ',mobile) AS name"), 'id')->toArray();
    }

    public function studentsRoll(Request $request)
    {
        $data = [
            'pageTitle' => 'Students Roll',
            'sessions' => $this->sessionService->listByStatus(),
            'courses'  => $this->courseService->lists(),
            'phases'   => $this->phaseService->lists(),
        ];
        if (!empty($request->session_id) && !empty($request->course_id) && !empty($request->phase_id)) {
            $data['totalStudents'] = $this->service->getTotalStudentsByCurrentSessionIdAndCourseId($request->session_id, $request->course_id, $request->phase_id);
            $data['students'] = $this->service->getStudentListWithStatus($request);
        }
        return view(self::moduleDirectory . 'students_roll', $data);
    }

    public function studentsRollUpdate(Request $request)
    {
        DB::beginTransaction();
        try {
            if (!empty($request->students)) {
                $studentIdArr = json_decode($request->students);
                foreach ($studentIdArr as $key => $value) {
                    $student = Student::find($value);
                    $prevRoll = $student->roll_no;
                    $student->update([
                        'roll_no' => $key + 1
                    ]);
                    DB::table('student_roll_no')->insert([
                        'student_id' => $value,
                        'phase_id'   => $student->phase_id,
                        'batch_type_id' => $student->batch_type_id,
                        'from_roll'  => $prevRoll,
                        'to_roll'    => $student->roll_no,
                        'created_at' => now(),
                    ]);
                }
                DB::commit();
                $request->session()->flash('success', setMessage('update', 'Students roll'));
                return redirect()->route('students.roll');
            }
        } catch (\Exception $e) {
            DB::rollBack();
            $request->session()->flash('error', setMessage('update.error', 'Students roll'));
            return redirect()->route('students.roll');
            //            return $e->getMessage() . $e->getLine() . $e->getCode();
        }
    }

    public function getStudentsBySessionCoursePhase(Request $request)
    {
        $sessionId = $request->input('sessionId');
        $courseId = $request->input('courseId');
        $phaseId = $request->input('phaseId');
        return $students = $this->service->getAllStudentsBySessionCoursePhase($sessionId, $courseId, $phaseId);
    }

    public function getInfo(Request $request)
    {
        $userId = $request->userId;
        $user = User::where('user_id', $userId)->first();
        $student = $user && $this->service->findBy(['user_id' => $user->id])
            ? $this->service->findBy(['user_id' => $user->id])
            : null;
        return response()->json(['status' => true, 'student' => $student]);
    }
}
