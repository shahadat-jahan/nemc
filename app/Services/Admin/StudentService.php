<?php

/**
 * Created by PhpStorm.
 * User: office
 * Date: 2/11/19
 * Time: 5:45 PM
 */

namespace App\Services\Admin;

use App\Events\UpdateStudentCredit;
use App\Models\AdvanceAmountUseHistories;
use App\Models\Attencance;
use App\Models\ClassRoutine;
use App\Models\Exam;
use App\Models\Session;
use App\Models\Student;
use App\Models\StudentFee;
use App\Models\StudentFeeDetail;
use App\Models\StudentPayment;
use App\Models\User;
use App\Services\BaseService;
use App\Services\EmailService;
use App\Services\StudentFeeService;
use Carbon\Carbon;
use DataTables;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use function foo\func;

/**
 * Class StudentService
 * @package App\Services\Admin
 */
class StudentService extends BaseService
{

    /**
     * @var Session
     */
    protected $sessions;
    /**
     * @var UserService
     */
    protected $userService;
    /**
     * @var GuardianService
     */
    protected $guardianService;
    /**
     * @var EmailService
     */
    protected $emailService;
    protected $studentFee;
    protected $classRoutine;
    protected $paymentDetailService;
    protected $attendacance;
    protected $studentFeeDetail;
    protected $studentFeeService;
    protected $paymentTypeService;
    protected $studentPayment;
    protected $exam;
    protected $advanceAmountUseHistories;

    /**
     * StudentService constructor.
     *
     * @param Student         $student
     * @param Session         $sessions
     * @param UserService     $userService
     * @param GuardianService $guardianService
     * @param EmailService    $emailService
     */
    public function __construct(
        Student                   $student,
        Session                   $sessions,
        UserService               $userService,
        GuardianService           $guardianService,
        EmailService              $emailService,
        StudentFee                $studentFee,
        ClassRoutine              $classRoutine,
        PaymentDetailService      $paymentDetailService,
        Attencance                $attendacance,
        StudentFeeDetail          $studentFeeDetail,
        StudentFeeService         $studentFeeService,
        PaymentTypeService        $paymentTypeService,
        StudentPayment            $studentPayment,
        Exam                      $exam,
        AdvanceAmountUseHistories $advanceAmountUseHistories
    )
    {
        $this->model                     = $student;
        $this->sessions                  = $sessions;
        $this->userService               = $userService;
        $this->guardianService           = $guardianService;
        $this->emailService              = $emailService;
        $this->studentFee                = $studentFee;
        $this->classRoutine              = $classRoutine;
        $this->paymentDetailService      = $paymentDetailService;
        $this->attendacance              = $attendacance;
        $this->studentFeeDetail          = $studentFeeDetail;
        $this->studentFeeService         = $studentFeeService;
        $this->paymentTypeService        = $paymentTypeService;
        $this->studentPayment            = $studentPayment;
        $this->exam                      = $exam;
        $this->advanceAmountUseHistories = $advanceAmountUseHistories;
    }

    /**
     * @param $sessionId
     * @param $courseId
     *
     * @return mixed
     */
    public function getTotalStudentsBySessionAndCourse($sessionId, $courseId)
    {
        return $this->model->where('followed_by_session_id', $sessionId)->where('course_id', $courseId)->count();
    }

    /**
     * @param $sessionId
     * @param $courseId
     * @param $batch
     *
     * @return string
     */
    public function generateStudentId($sessionId, $courseId, $batch, $session)
    {
        $total = $this->getTotalStudentsBySessionAndCourse($sessionId, $courseId);

        return $session->start_year . sprintf('%03d', $batch) . sprintf('%03d', ($total + 1));
    }

    /**
     * @param      $courseId
     * @param      $sessionId
     * @param      $column
     * @param      $value
     * @param null $id
     *
     * @return mixed
     */
    public function getStudentByCourseIdAndSessionId($phaseId, $courseId, $sessionId, $column, $value, $id = null)
    {
        if ($column == 'roll_no') {
            $query = $this->model->where($column, $value)
                                 ->where('followed_by_session_id', $sessionId)
                                 ->where('course_id', $courseId)
                                 ->where('phase_id', $phaseId);
        } else {
            $query = $this->model->where($column, $value);
        }
        if (!empty($id)) {
            $query = $query->where('id', '<>', $id);
        }

        return $query->count();
    }

    public function checkStudentMobileIsUnique($request)
    {
        if ($request->has('id')) {
            return $this->model->where('id', '<>', $request->id)->where('mobile', $request->mobile)->count();
        }

        return $this->model->where('mobile', $request->mobile)->count();
    }

    public function checkStudentRegistrationIsUnique($request)
    {
        if ($request->has('id')) {
            return $this->model->where('id', '<>', $request->id)->where('reg_no', $request->reg_no)->count();
        }

        return $this->model->where('reg_no', $request->reg_no)->count();
    }

    public function getParentByStudentId($id)
    {
        return $this->model->with('parent')->where('id', $id)->first();
    }

    /**
     * @param $request
     *
     * @return mixed
     */
    public function getDataTable($request)
    {
        $query = $this->model->with('session', 'course', 'phase', 'studentCategory', 'user')
                             ->orderBy('roll_no', 'asc')->select();

        if (Auth::guard('student_parent')->check()) {
            $user = Auth::guard('student_parent')->user();
            if ($user->student) {
                $query = $query->where('id', $user->student->id);
            } else {
                $query = $query->whereIn('id', getStudentsIdByParentId($user->parent->id));
            }
        }

        if (Auth::guard('web')->check()) {
            $user = Auth::guard('web')->user();
            if ($user->teacher) {
                if (!empty($user->teacher->course_id)) {
                    $query = $query->where('course_id', $user->teacher->course_id);
                }
            } else {
                if (!empty($user->adminUser->course_id)) {
                    $query = $query->where('course_id', $user->adminUser->course_id);
                }
            }
        }

        return Datatables::of($query)
                         ->addColumn('user_id', function ($row) {
                             return '<button class="btn m-btn m-btn--hover-brand m-btn--icon m-btn--icon-only m-btn--pill copy-id" data-id="' . $row->user->user_id . '" title="Copy ID">
                <i class="fas fa-copy"></i>
            </button>
            <span id="student-id-' . $row->user->user_id . '">' . $row->user->user_id . '</span>';
                         })
                         ->addColumn('term_id', function ($row) {
                             return $row->term->title;
                         })
                         ->editColumn('session_id', function ($row) {
                             return $row->followedBySession->title;
                         })
                         ->editColumn('course_id', function ($row) {
                             return $row->course->title;
                         })
                         ->editColumn('student_category_id', function ($row) {
                             return $row->studentCategory->title;
                         })
                         ->editColumn('phase_id', function ($row) {
                             return $row->phase->title;
                         })
                         ->editColumn('batch_type_id', function ($row) {
                             return $row->batchType->title;
                         })
                         ->editColumn('photo', function ($row) {
                             $imageSrc = !empty($row->photo) ? $row->photo : getAvatar($row->gender);
                             return '<img src="' . asset($imageSrc) . '" width="100"/>';
                         })
                         ->addColumn('action', function ($row) {
                             $actions = '';

                             if (hasPermission('students/view')) {
                                 if (getAppPrefix() == 'admin') {
                                     $actions .= '<a href="' . route('students.show', [$row->id]) . '" class="m-portlet__nav-link btn m-btn m-btn--hover-brand m-btn--icon m-btn--icon-only m-btn--pill" title="View"><i class="flaticon-eye"></i></a>';
                                 } else {
                                     $actions .= '<a href="' . route('frontend.students.view', [$row->id]) . '" class="m-portlet__nav-link btn m-btn m-btn--hover-brand m-btn--icon m-btn--icon-only m-btn--pill" title="View"><i class="flaticon-eye"></i></a>';
                                 }
                             }

                             if (hasPermission('students/edit')) {
                                 $actions .= '<a href="' . route('students.edit', [$row->id]) . '" class="m-portlet__nav-link btn m-btn m-btn--hover-brand m-btn--icon m-btn--icon-only m-btn--pill" title="Edit"><i class="flaticon-edit"></i></a>';
                             }

                             if (hasPermission('students/attachment')) {
                                 if (getAppPrefix() == 'admin') {
                                     $actions .= '<a href="' . route('students.attachment.list', [$row->id]) . '" class="m-portlet__nav-link btn m-btn m-btn--hover-brand m-btn--icon m-btn--icon-only m-btn--pill" title="Attachments"><i class="fa fa-file-download"></i></a>';
                                 } else {
                                     $actions .= '<a href="' . route('frontend.students.attachment.list', [$row->id]) . '" class="m-portlet__nav-link btn m-btn m-btn--hover-brand m-btn--icon m-btn--icon-only m-btn--pill" title="Attachments"><i class="fa fa-file-download"></i></a>';
                                 }
                             }

                             if (hasPermission('students/installment')) {
                                 $actions .= '<a href="' . route('students.installment.list', [$row->id]) . '" class="m-portlet__nav-link btn m-btn m-btn--hover-brand m-btn--icon m-btn--icon-only m-btn--pill" title="Installments"><i class="fa fa-retweet"></i></a>';
                             }

                             if (getAppPrefix() == 'admin') {
                                 if (Auth::guard('web')->check()) {
                                     $user = Auth::guard('web')->user();
                                     if (!$user->teacher) {
                                         if (hasPermission('students/password')) {
                                             $actions .= '<a href="' . route('student.password-change.form', [$row->id]) . '" class="m-portlet__nav-link btn m-btn m-btn--hover-brand m-btn--icon m-btn--icon-only m-btn--pill" title="Change password"><i class="fa fa-key"></i></a>';
                                         }
                                     }
                                 }
                             } else {
                                 if (Auth::guard('student_parent')->check()) {
                                     $user = Auth::guard('student_parent')->user();
                                     if ($user->student) {
                                         if ($user->student->id == $row->id) {
                                             $actions .= '<a href="' . route('frontend.student.password-change.form', [$row->id]) . '" class="m-portlet__nav-link btn m-btn m-btn--hover-brand m-btn--icon m-btn--icon-only m-btn--pill" title="Change password"><i class="fa fa-key"></i></a>';
                                         }
                                     }
                                 } else {
                                     $actions .= '';
                                 }
                             }

                             if (Auth::guard('student_parent')->check()) {
                                 $user = Auth::guard('student_parent')->user();
                                 if ($user->student) {
                                     if ($user->student->id == $row->id) {
                                         $actions .= '';
                                     }
                                 }
                             } else {
                                 $actions .= '<a href="javascript:void(0)" class="m-portlet__nav-link btn m-btn m-btn--hover-brand m-btn--icon m-btn--icon-only m-btn--pill send-message-user" data-message-to-user-id="' . $row->user->id . '" title="Send Message to Student"><i class="fas fa-envelope"></i></a>';
                             }

                             return $actions;
                         })
                         ->editColumn('status', function ($row) {
                             return setStatus($row->status, 'student');
                         })
                         ->addColumn('clear_installment', function ($row) {
                             return (isset($row->fee) && !empty($row->fee->first())) ? paymentStatus($row->fee->first()->status) : paymentStatus(0);
                         })
                         ->rawColumns(['user_id', 'photo', 'clear_installment', 'status', 'action'])
                         ->filter(function ($query) use ($request) {
                             if (!empty($request->get('session_id'))) {
                                 $query->where('followed_by_session_id', $request->get('session_id'));
                             }
                             if (!empty($request->get('course_id'))) {
                                 $query->where('course_id', $request->get('course_id'));
                             }
                             if (!empty($request->get('student_category_id'))) {
                                 $query->where('student_category_id', $request->get('student_category_id'));
                             }
                             if (!empty($request->get('roll_no'))) {
                                 $query->where('roll_no', $request->get('roll_no'));
                             }
                             if (!empty($request->get('full_name_en'))) {
                                 $query->where('full_name_en', 'like', '%' . $request->get('full_name_en') . '%');
                             }
                             if (!empty($request->get('email'))) {
                                 $query->where('email', $request->get('email'));
                             }
                             if (!empty($request->get('phone_mobile'))) {
                                 $query->where('phone', $request->get('phone_mobile'))->orWhere('mobile', $request->get('phone_mobile'));
                             }
                             if (!empty($request->get('phase_id'))) {
                                 $query->where('phase_id', $request->get('phase_id'));
                             }
                             if (!empty($request->get('student_id'))) {
                                 $query->where('id', $request->get('student_id'));
                             }
                             if (!empty($request->get('user_id'))) {
                                 $query->whereHas('user', function ($q) use ($request) {
                                     return $q->where('user_id', $request->user_id);
                                 });
                             }
                             if (!empty($request->get('reg_no'))) {
                                 $query->where('reg_no', $request->get('reg_no'));
                             }
                             if (!empty($request->get('status'))) {
                                 $query->where('status', $request->get('status'));
                             }
                         })
                         ->make(true);
    }

    /**
     * @param $request
     *
     * @return mixed
     */
    public function addStudent($request)
    {
        if ($request->has(['session_id', 'course_id', 'mobile'])) {
            //prevent multiple insertion of same data of same session, course and mobile
            $checkSessionCourseMobileExist = $this->model->where([
                ['followed_by_session_id', $request->session_id],
                ['course_id', $request->course_id],
                ['mobile', $request->mobile],
                ['reg_no', $request->reg_no],
            ])->count();

            DB::beginTransaction();
            try {
                if ($checkSessionCourseMobileExist == 0) {
                    // check parent exist
                    $guardian = $this->guardianService->getGuardianInfoByUserId($request->father_user_id);

                    if (empty($guardian)) {
                        // add parent user
                        $parentUser = $this->userService->create([
                            'user_group_id' => 6,
                            'email'         => checkEmpty($request->father_email),
                            'user_id'       => 'pr' . $request->user_id,
                            'password'      => Hash::make($request->father_password),
                        ]);

                        //parents info
                        $parentsData = [
                            'user_id'                  => $parentUser->id,
                            'father_name'              => $request->father_name,
                            'mother_name'              => $request->mother_name,
                            'father_phone'             => $request->father_phone,
                            'mother_phone'             => checkEmpty($request->mother_phone),
                            'father_email'             => checkEmpty($request->father_email),
                            'mother_email'             => checkEmpty($request->mother_email),
                            'address'                  => checkEmpty($request->parent_address),
                            'occupation'               => checkEmpty($request->occupation),
                            'annual_income'            => checkEmpty($request->annual_income),
                            'annual_income_grade'      => checkEmpty($request->annual_income_grade),
                            'movable_property'         => checkEmpty($request->movable_property),
                            'movable_property_grade'   => checkEmpty($request->movable_property_grade),
                            'immovable_property'       => checkEmpty($request->immovable_property),
                            'immovable_property_grade' => checkEmpty($request->immovable_property_grade),
                            'total_asset'              => checkEmpty($request->total_asset),
                            'total_asset_grade'        => checkEmpty($request->total_asset_grade),
                            'finance_during_study'     => $request->finance_during_study,
                        ];

                        $parentUser->parent()->create($parentsData);

                        $guardianInfo = $parentUser->parent;
                    } else {
                        $guardianInfo = $guardian;
                    }

                    // add student user
                    $user = $this->userService->create([
                        'user_group_id' => 5,
                        'email'         => $request->email,
                        'user_id'       => $request->user_id,
                        'password'      => Hash::make($request->password),
                    ]);

                    $user->student()->create([
                        'batch_type_id'          => 1,
                        'phase_id'               => 1,
                        'term_id'                => 1,
                        'parent_id'              => $guardianInfo->id,
                        'course_id'              => $request->course_id,
                        'student_category_id'    => $request->student_category_id,
                        'session_id'             => $request->session_id,
                        'followed_by_session_id' => $request->session_id,
                        'full_name_en'           => $request->full_name_en,
                        'full_name_bn'           => checkEmpty($request->full_name_bn),
                        'admission_roll_no'      => checkEmpty($request->admission_roll_no),
                        'reg_no'                 => checkEmpty($request->reg_no),
                        'form_fillup_date'       => checkEmpty($request->form_fillup_date),
                        'student_id'             => $request->student_id,
                        'roll_no'                => $request->roll_no,
                        'admission_year'         => $request->admission_year,
                        'commenced_year'         => $request->commenced_year,
                        'test_score'             => checkEmpty($request->test_score),
                        'merit_score'            => checkEmpty($request->merit_score),
                        'merit_position'         => checkEmpty($request->merit_position),
                        'gender'                 => $request->gender,
                        'date_of_birth'          => $request->date_of_birth,
                        'place_of_birth'         => $request->place_of_birth,
                        'blood_group'            => checkEmpty($request->blood_group),
                        'nationality'            => $request->nationality,
                        'mother_tongue'          => checkEmpty($request->mother_tongue),
                        'knowledge_english'      => checkEmpty($request->knowledge_english),
                        'phone'                  => $request->phone,
                        'mobile'                 => $request->mobile,
                        'email'                  => checkEmpty($request->email),
                        'passport_number'        => checkEmpty($request->passport_number),
                        'visa_duration'          => checkEmpty($request->visa_duration),
                        'embassy_contact_no'     => checkEmpty($request->embassy_contact_no),
                        'permanent_address'      => checkEmpty($request->permanent_address),
                        'same_as_permanent'      => isset($request->same_as_present) ? true : false,
                        'present_address'        => checkEmpty($request->present_address),
                        'photo'                  => checkEmpty($request->applicant_photo),
                        'remarks'                => checkEmpty($request->personal_remarks),
                    ]);

                    $student = $user->student;

                    $nextRoll = Student::where('roll_no', '>=', $student->roll_no)
                                       ->where('id', '!=', $student->id)
                                       ->where('followed_by_session_id', $student->followed_by_session_id)
                                       ->where('course_id', $student->course_id)
                                       ->where('phase_id', $student->phase_id)
                                       ->whereIn('status', [1, 3])
                                       ->get();

                    if (!empty($nextRoll)) {
                        foreach ($nextRoll as $key => $roll) {
                            Student::where('id', $roll->id)->update([
                                'roll_no' => $roll->roll_no + 1,
                                'remarks' => 4,
                            ]);

                            DB::table('student_roll_no')->insert([
                                'student_id'    => $roll->id,
                                'phase_id'      => $roll->phase_id,
                                'batch_type_id' => $roll->batch_type_id,
                                'from_roll'     => $roll->roll_no,
                                'to_roll'       => $roll->roll_no + 1,
                                'created_at'    => now(),
                            ]);
                        }
                    }
                    //emergency contact
                    $emergencyContact = [
                        'full_name' => checkEmpty($request->emergency_contact_name),
                        'relation'  => checkEmpty($request->emergency_contact_relation),
                        'phone'     => checkEmpty($request->emergency_phone),
                        'email'     => checkEmpty($request->emergency_email),
                        'address'   => checkEmpty($request->emergency_address),
                    ];

                    $student->emergencyContact()->create($emergencyContact);

                    //education
                    $educationHistories = [
                        [
                            'education_level'    => $request->education_level_ssc,
                            'education_board_id' => $request->education_board_id_ssc,
                            'institution'        => $request->institution_ssc,
                            'pass_year'          => $request->pass_year_ssc,
                            'gpa'                => $request->gpa_ssc,
                            'gpa_biology'        => $request->gpa_biology_ssc,
                            'extra_activity'     => checkEmpty($request->extra_activity_ssc)
                        ],
                        [
                            'education_level'    => $request->education_level_hsc,
                            'education_board_id' => $request->education_board_id_hsc,
                            'institution'        => $request->institution_hsc,
                            'pass_year'          => $request->pass_year_hsc,
                            'gpa'                => $request->gpa_hsc,
                            'gpa_biology'        => $request->gpa_biology_hsc,
                            'extra_activity'     => checkEmpty($request->extra_activity_hsc)
                        ]
                    ];

                    $student->educations()->createMany($educationHistories);
                    //attachments
                    $applicantAttachments = [];
                    if (!empty($request->attachment_type_id)) {
                        foreach ($request->attachment_type_id as $key => $attachment) {
                            $applicantAttachments[$key] = [
                                'attachment_type_id' => $attachment,
                                'file_path'          => $request->file_path[$key],
                                'type'               => $request->type[$key],
                                'remarks'            => checkEmpty($request->remarks[$key]),
                            ];
                        }
                        unset($key);
                        $student->attachments()->createMany($applicantAttachments);
                    }

                    //Installment(student fee)
                    if ($student) {
                        //get session info
                        $sessionInfo = $student->session->sessionDetails->filter(function ($item) use ($student) {
                            return ($item->course_id == $student->course_id);
                        });

                        //get development fee according to student
                        if ($student->student_category_id == 2) {
                            $developmentFee = $sessionInfo->first()->development_fee_foreign;
                        } else if ($student->student_category_id > 2) {
                            $developmentFee = $this->paymentTypeService->getPaymentDetailByTypeIdAndCourseIdAndCategoryId(1, $student->course_id, $student->student_category_id)->amount;
                        } else {
                            $developmentFee = $sessionInfo->first()->development_fee_local;
                        }

                        //save student fee data to student fee table
                        $studentFeeData = $this->studentFeeService->create([
                            'student_id'      => $student->id,
                            'title'           => 'Development Fee',
                            'total_amount'    => $developmentFee,
                            'discount_amount' => null,
                            'payable_amount'  => $developmentFee,
                            'due_amount'      => $developmentFee,
                        ]);

                        //save student fee data to student fee detail table
                        $sessionStartYear = $student->session->start_year;
                        $duration         = $student->session->sessionDetails->where('course_id', $student->course_id)->first()->sessionPhaseDetails->first()->duration;
                        $parseDuration    = explode('.', $duration);
                        $paymentLastDate  = Carbon::create($sessionStartYear, 1, 1)->addYears($parseDuration[0])->addMonths($parseDuration[1])->lastOfMonth()->format('d/m/Y');

                        $this->studentFeeDetail->create([
                            'student_fee_id'       => $studentFeeData->id,
                            'payment_type_id'      => 1,
                            'total_amount'         => $developmentFee,
                            'discount_amount'      => null,
                            'payable_amount'       => $developmentFee,
                            'due_amount'           => $developmentFee,
                            'discount_application' => null,
                            'last_date_of_payment' => $paymentLastDate,
                        ]);
                    }

                    DB::commit();

                    // send mail to student
                    if ($student && !empty($request->email)) {
                        $studentMailBody = '
                    <table>
                        <tr>
                            <td>Dear ' . $request->full_name_en . ',</td>
                        </tr>
                        <tr>
                            <td>Welcome to NEMC student portal. Your account has been generated. To log on, please use this information: </td>
                        </tr>
                        <tr>
                            <td>URL: ' . url('/') . ' </td>
                        </tr>
                        <tr>
                            <td>User ID: ' . $request->user_id . ' </td>
                        </tr>
                        <tr>
                            <td>Password: ' . $request->password . ' </td>
                        </tr>
                    <table>';

                        $this->emailService->mailSend($request->email, 'info@nemc.edu.bd', 'NEMC: Student ID has been generated', 'new_account', $studentMailBody, '', $user);
                    }

                    // send mail student's father
                    if (!empty($guardian) && !empty($request->father_email)) {
                        $parentMailBody = '
                    <table>
                        <tr>
                            <td>Dear ' . $request->father_name . ',</td>
                        </tr>
                        <tr>
                            <td>Welcome to NEMC student portal. Your account has been generated. Now you can monitor all activities of your children. To log on, please use this information: </td>
                        </tr>
                        <tr>
                            <td>URL: ' . url('/') . ' </td>
                        </tr>
                        <tr>
                            <td>User ID: pr' . $request->user_id . ' </td>
                        </tr>
                        <tr>
                            <td>Password: ' . $request->father_password . ' </td>
                        </tr>
                    <table>';

                        $this->emailService->mailSend($request->email, 'info@nemc.edu.bd', 'NEMC: Parent ID has been generated', 'new_account', $parentMailBody);
                    }
                    return $student;
                }
                return $student = null;
            } catch (\Exception $e) {
                DB::rollBack();
                //                dd($e->getFile(), $e->getCode(), $e->getLine(), $e->getMessage());
                return $request->session()->flash('error', setMessage('create.error', 'Student'));
            }
        }
    }

    /**
     * @param $request
     * @param $id
     *
     * @return \App\Services\dataObject
     */
    public function updateStudent($request, $id)
    {
        $student = $this->find($id);

        DB::beginTransaction();
        try {
            if (!empty($request->session_id)) {
                $student->update(['session_id' => $request->session_id,]);
            }
            $student->update([
                'course_id'              => $request->course_id,
                'student_category_id'    => $request->student_category_id,
                'followed_by_session_id' => $request->followed_by_session_id,
                'phase_id'               => $request->phase_id,
                'term_id'                => $request->term_id,
                'batch_type_id'          => $request->batch_type_id,
                'full_name_en'           => $request->full_name_en,
                'full_name_bn'           => checkEmpty($request->full_name_bn),
                'student_id'             => $request->student_id,
                'admission_roll_no'      => checkEmpty($request->admission_roll_no),
                'reg_no'                 => checkEmpty($request->reg_no),
                'form_fillup_date'       => checkEmpty($request->form_fillup_date),
                'roll_no'                => $request->roll_no,
                'admission_year'         => $request->admission_year,
                'commenced_year'         => $request->commenced_year,
                'test_score'             => checkEmpty($request->test_score),
                'merit_score'            => checkEmpty($request->merit_score),
                'merit_position'         => checkEmpty($request->merit_position),
                'gender'                 => $request->gender,
                'date_of_birth'          => $request->date_of_birth,
                'place_of_birth'         => $request->place_of_birth,
                'blood_group'            => checkEmpty($request->blood_group),
                'nationality'            => $request->nationality,
                'mother_tongue'          => checkEmpty($request->mother_tongue),
                'knowledge_english'      => checkEmpty($request->knowledge_english),
                'phone'                  => $request->phone,
                'mobile'                 => $request->mobile,
                'email'                  => checkEmpty($request->email),
                'passport_number'        => checkEmpty($request->passport_number),
                'visa_duration'          => checkEmpty($request->visa_duration),
                'embassy_contact_no'     => checkEmpty($request->embassy_contact_no),
                'permanent_address'      => checkEmpty($request->permanent_address),
                'same_as_permanent'      => isset($request->same_as_present) ? true : false,
                'present_address'        => checkEmpty($request->present_address),
                'photo'                  => checkEmpty($request->applicant_photo),
                'remarks'                => checkEmpty($request->personal_remarks),
                'status'                 => $request->status,

            ]);

            $student->user()->update([
                'email' => $request->email,
            ]);

            $student->emergencyContact()->update([
                'full_name' => checkEmpty($request->emergency_contact_name),
                'relation'  => checkEmpty($request->emergency_contact_relation),
                'phone'     => checkEmpty($request->emergency_phone),
                'email'     => checkEmpty($request->emergency_email),
                'address'   => checkEmpty($request->emergency_address),
            ]);

            $educationHistories = [
                [
                    'education_level'    => $request->education_level_ssc,
                    'education_board_id' => $request->education_board_id_ssc,
                    'institution'        => $request->institution_ssc,
                    'pass_year'          => $request->pass_year_ssc,
                    'gpa'                => $request->gpa_ssc,
                    'gpa_biology'        => $request->gpa_biology_ssc,
                    'extra_activity'     => checkEmpty($request->extra_activity_ssc)
                ],
                [
                    'education_level'    => $request->education_level_hsc,
                    'education_board_id' => $request->education_board_id_hsc,
                    'institution'        => $request->institution_hsc,
                    'pass_year'          => $request->pass_year_hsc,
                    'gpa'                => $request->gpa_hsc,
                    'gpa_biology'        => $request->gpa_biology_hsc,
                    'extra_activity'     => checkEmpty($request->extra_activity_hsc)
                ]
            ];

            $student->educations->each(function ($history) {
                $history->delete();
            });
            $student->educations()->createMany($educationHistories);

            DB::commit();

            return $student;
        } catch (\Exception $e) {
            DB::rollBack();
            //            dd($e->getFile(), $e->getCode(), $e->getLine(), $e->getMessage());
            return $request->session()->flash('error', setMessage('update.error', 'Student'));
        }
    }

    /**
     * @param $sessionId
     * @param $courseId
     * @param $roll
     *
     * @return mixed
     */
    public function getStudentBySessionCourseAndRollNo($sessionId, $courseId, $phaseId, $roll)
    {
        return $this->model->where('followed_by_session_id', $sessionId)
                           ->where('course_id', $courseId)
                           ->where('phase_id', $phaseId)
                           ->where('roll_no', $roll)
                           ->first();
    }

    //get student by session id
    public function getAllStudentBySessionId($sessionId)
    {
        return $this->model->where([
            ['followed_by_session_id', '=', $sessionId],
            ['status', '=', '1'],
        ])->get();
    }

    public function getStudentsBySessionCourseWith($sessionId, $courseId = '', $with = [])
    {
        return $this->model
            ->with($with)
            ->where('followed_by_session_id', $sessionId)
            ->when($courseId != null, fn($q) => $q->where('course_id', $courseId))
            ->whereIn('status', [1, 3])
            ->whereNull('deleted_at')
            ->orderBy('id')
            ->get();
    }

    //get student by session id and batch type id
    public function getStudentBySessionAndBatchTypeId($sessionId, $batchTypeId)
    {
        return $this->model->where([
            ['followed_by_session_id', '=', $sessionId],
            ['batch_type_id', '=', $batchTypeId],
            ['status', '=', '1'],
        ])->get();
    }

    public function
    getAllStudentsBySessionCoursePhase($session, $course, $phase)
    {
        return $this->model
            ->where('followed_by_session_id', $session)
            ->where('course_id', $course)
            ->where('phase_id', $phase)
            ->whereIn('status', [1, 3])
            ->orderBy('roll_no')
            ->get();
    }

    public function getCurrentSessionOldStudentsByPhaseTermCourse($phase, $term, $session, $course)
    {
        return $this->model->where('phase_id', $phase)
                           ->when($term != null, function ($query) use ($term) {
                               return $query->where('term_id', $term);
                           })
                           ->where('course_id', $course)
                           ->where('followed_by_session_id', $session)
                           ->where('batch_type_id', 2)
                           ->whereIn('status', [1, 3])
                           ->orderBy('roll_no')
                           ->get();
    }

    public function getStudents($routine, $user)
    {
        $students = [];

        if ($routine->batch_type_id == 1) {
            $students = $this->findBy([
                'followed_by_session_id' => $routine->session_id,
                'course_id'              => $routine->course_id,
                'phase_id'               => $routine->phase_id,
                // 'term_id' => $routine->term_id, //no need for attendance
                'batch_type_id'          => 1,
                'status'                 => [1, 3],
            ], 'list');

            $students = $this->filterStudentsByUserGroup($students, $routine, $user);
        }

        return $students;
    }

    public function getOldStudents($routine, $user)
    {
        $oldStudents = [];

        if ($routine->batch_type_id == 2 || $routine->old_students != 0) {
            $oldStudents = $this->getCurrentSessionOldStudentsByPhaseTermCourse(
                $routine->phase_id,
                null, //no need for attendance
                $routine->session_id,
                $routine->course_id
            );

            $oldStudents = $this->filterStudentsByUserGroup($oldStudents, $routine, $user);
        }

        return $oldStudents;
    }

    private function filterStudentsByUserGroup($students, $routine, $user)
    {
        $authorizeUser = isset($user->adminUser) && $user->adminUser->designation_id === 32;

        if ($this->isPracticalClass($routine)) {
            $allowedGroups = [4, 11]; // Teacher or teacher with extra power
            if ( in_array($user->user_group_id, $allowedGroups) ) {
                $studentIds = $this->getStudentIdsByTeacher($routine, $user);
                $students   = $students->whereIn('id', $studentIds);
            } elseif ( $authorizeUser || in_array($user->user_group_id, [1, 2, 12]) ) {
                $studentIds = $this->getStudentIds($routine);
                $students   = $students->whereIn('id', $studentIds);
            }
        }

        return $students;
    }

    private function isPracticalClass($routine)
    {
        return $routine->class_type_id != 1 && $routine->class_type_id != 9 && $routine->class_type_id != 17;
    }

    private function getStudentIdsByTeacher($routine, $user)
    {
        return $routine->studentGroup
            ->filter(function ($studentGroup) use ($user) {
                return $studentGroup->pivot->teacher_id == $user->teacher->id;
            })
            ->flatMap->students->pluck('id')->toArray();
    }

    private function getStudentIds($routine)
    {
        return $routine->studentGroup->flatMap->students->pluck('id')->toArray();
    }

    public function generateClassAbsentFeePayment($request)
    {
        $student  = $this->find($request->student_id);
        $payments = $this->paymentDetailService->getPaymentsByStudentCategoryIdAndTypes($student->student_category_id, $student->session_id, $student->course_id, [4])->first();

        $classRoutine = $this->classRoutine->where('phase_id', $student->phase_id)->whereHas('attendances', function ($q) use ($student) {
            $q->where('student_id', $student->id);
        })->orderBy('class_date', 'asc')
                                           ->select(DB::raw('MIN(class_date) as min_date'), DB::raw('MAX(class_date) as max_date'))
                                           ->first();

        $allPayments     = [];
        $studentPayments = [];

        //absent fee
        if (!empty($classRoutine->min_date) && !empty($classRoutine->max_date)) {
            $totalAbsent = $this->attendacance->whereHas('classRoutine', function ($q) use ($classRoutine) {
                $q->whereDate('class_date', '>=', $classRoutine->min_date)->whereDate('class_date', '<=', $classRoutine->max_date)->where('class_type_id', '!=', 9);
            })->where('student_id', $request->student_id)->where('attendance', 0)->count();

            if ($totalAbsent > 0) {
                $allPayments[0][0] = [
                    'payment_type_id'      => 4,
                    'payable_amount'       => ($payments->amount * $totalAbsent),
                    'last_date_of_payment' => $classRoutine->max_date,
                    'status'               => 0
                ];
            }
        }

        if (!empty($allPayments)) {
            $studentPayments = $this->saveStudentFees($request, $allPayments);
        }

        return $studentPayments;
    }

    public function saveStudentFees($request, $data)
    {
        DB::beginTransaction();

        foreach ($data as $row) {
            $studentPayment = $this->studentFee->create([
                'student_id'      => $request->student_id,
                'title'           => 'Class Absent Fees',
                'total_amount'    => collect($row)->sum('payable_amount'),
                'discount_amount' => 0,
                'payable_amount'  => collect($row)->sum('payable_amount'),
                'due_amount'      => collect($row)->sum('payable_amount'),
                'status'          => 0,
            ]);

            $paymentDetail = [];
            foreach ($row as $key => $item) {
                $paymentDetail[$key] = [
                    'payment_type_id'      => $item['payment_type_id'],
                    'total_amount'         => $item['payable_amount'],
                    'discount_amount'      => 0,
                    'payable_amount'       => $item['payable_amount'],
                    'due_amount'           => $item['payable_amount'],
                    'last_date_of_payment' => Carbon::createFromFormat('Y-m-d', $item['last_date_of_payment'])->format('d/m/Y'),
                    'bill_year'            => Carbon::parse($item['last_date_of_payment'])->year,
                    'bill_month'           => Carbon::parse($item['last_date_of_payment'])->month,
                    'status'               => $item['status'],
                ];
            }

            $studentPayment->feeDetails()->createMany($paymentDetail);
        }

        DB::commit();

        return $studentPayment;
    }

    public function getStudentFees($student_id)
    {
        return $this->studentFee->where('student_id', $student_id)->get();
    }

    public function getStudentFeesByType($student_id, $type)
    {
        return $this->studentFee->where('student_id', $student_id)->whereHas('feeDetails', function ($q) use ($type) {
            $q->where('payment_type_id', $type);
        })->get();
    }

    /*public function getStudentFees($student_id){
        return $this->studentFee->where('student_id', $student_id)->get();
    }*/

    public function getStudentFeesByFeeId($feeId)
    {
        return $this->studentFee->with('feeDetails')->where('id', $feeId)->first();
    }

    public function checkPaymentExists($request)
    {
        return $this->studentFeeDetail->whereIn('payment_type_id', [4])
                                      ->whereHas('fee', function ($q) use ($request) {
                                          $q->where('student_id', $request->student_id);
                                      })->orderBy('bill_year', 'desc')->orderBy('bill_month', 'desc')->first();
    }

    public function checkAbsentFeeExistsByStudentIdAndPhaseId($request)
    {
        return $this->studentFeeDetail->where('payment_type_id', 4)
                                      ->whereHas('fee.student', function ($q) use ($request) {
                                          $q->where([
                                              ['id', $request->student_id],
                                              ['phase_id', $request->phase_id],
                                          ]);
                                      })->count();
    }

    public function getStudentIdCardData($studentId)
    {
        return $this->model->where([
            ['id', '=', $studentId],
            ['status', '!=', 2],
        ])->first();
    }

    public function getStudentTestimonialData($studentId)
    {
        return $this->model->where([
            ['id', '=', $studentId],
            ['status', '=', 5],
        ])->first();
    }

    public function getTotalStudentsByCourseIdPhaseIds($courseId, $phaseIds)
    {
        return $this->model
            ->where('course_id', $courseId)
            ->whereIn('phase_id', $phaseIds)
            ->whereIn('status', [1, 3])
            ->count();
    }

    public function getTotalStudentsByCourseId($courseId)
    {
        return $this->model->where('course_id', $courseId)->count();
    }

    public function getTotalStudentsBySessionIdAndCourseId($sessionId, $courseId, $phaseIds)
    {
        return $this->model->where([
            ['followed_by_session_id', $sessionId],
            ['course_id', $courseId],
        ])
                           ->whereIn('phase_id', $phaseIds)
                           ->whereIn('status', [1, 3])
                           ->count();
    }

    public function getTotalStudentsBySessionIdAndCourseIds($sessionId, $courseIds)
    {
        return $this->model->where('followed_by_session_id', $sessionId)->whereIn('course_id', [$courseIds])->count();
    }

    public function getTotalStudentsBySessionCourseAndBatch($sessionId, $courseId, $batchTypeId)
    {
        return $this->model->where('followed_by_session_id', $sessionId)->where('course_id', $courseId)->where('batch_type_id', $batchTypeId)->count();
    }

    public function getStudentsByStudentId(array $studentId)
    {
        return $this->model->whereIn('id', $studentId)->where('status', 1)->get();
    }

    //student fee by student and fee type id
    public function getStudentFeeByStudentAndPaymentTypeId($studentId, $paymentTypeId)
    {
        return $this->studentFee->where('student_id', $studentId)
                                ->whereHas('feeDetails', function ($query) use ($paymentTypeId) {
                                    if ($paymentTypeId == 3) {
                                        $query->whereIn('payment_type_id', [3, 5, 6]);
                                    } else {
                                        $query->where('payment_type_id', $paymentTypeId);
                                    }
                                })->with([
                'feeDetails' => function ($q) {
                    $q->orderBy('bill_year', 'DESC')->orderBy('bill_month', 'DESC');
                },
                'studentPaymentDetails.studentPayment'
            ])->get();
        /*return $this->studentFee->where('student_id', $studentId)
            ->whereHas('feeDetails', function ($query) use($paymentTypeId) {
                $query->where('payment_type_id', $paymentTypeId);
            })->get();*/
    }

    public function getStudentAmountCheck($studentId)
    {
        $data   = [];
        $result = DB::table('student_fees')
                    ->select('users.user_id', 'students.roll_no', 'students.student_category_id', 'payment_types.title', 'student_fee_details.payment_type_id', \DB::raw('SUM(student_fee_details.discount_amount) as total_discount_amount'), \DB::raw('SUM(student_fee_details.due_amount) as total_due_amount'))
                    ->join('student_fee_details', 'student_fee_details.student_fee_id', '=', 'student_fees.id')
                    ->join('students', 'students.id', '=', 'student_fees.student_id')
                    ->join('users', 'users.id', '=', 'students.user_id')
                    ->join('payment_types', 'payment_types.id', '=', 'student_fee_details.payment_type_id')
                    ->where('student_fees.student_id', $studentId)
                    ->groupBy('student_fee_details.payment_type_id')
                    ->get();

        if ($result !== null) {
            foreach ($result as $value) {
                $result2 = StudentPayment::select(\DB::raw('SUM(discount_amount) as single_total_discount_amount'), \DB::raw('SUM(available_amount) as total_available_amount'))
                                         ->where('student_id', $studentId)
                                         ->where('payment_type_id', $value->payment_type_id)
                                         ->first();

                $total_due = $value->total_due_amount;

                $data[] = [
                    'user_id'                      => $value->user_id,
                    'roll_no'                      => $value->roll_no,
                    'payment_type_id'              => $value->payment_type_id,
                    'total_due_amount'             => $value->total_due_amount,
                    'total_discount_amount'        => $value->total_discount_amount,
                    'total_available_amount'       => $result2->total_available_amount,
                    'single_total_discount_amount' => $result2->single_total_discount_amount,
                    'payment_type_title'           => $value->title,
                    'total_due'                    => $total_due,
                    'student_category'             => $value->student_category_id,
                ];
            }
        }
        return $data;
    }

    public function getStudentFeeDueCheck($studentId, $paymentTypeId)
    {
        $result          = DB::table('student_fees')->where('student_id', $studentId)->get();
        $dueAmount       = [];
        $discount_amount = [];
        $data            = [];
        if (!empty($result)) {
            foreach ($result as $value) {
                $resu       = DB::table('student_fee_details')
                                ->where('student_fee_id', $value->id)
                                ->where('payment_type_id', $paymentTypeId)
                                ->first();
                $due_amount = !empty($resu->due_amount) ? $resu->due_amount : 0;
                //$dueAmount[]=$due_amount++;
                $discount_amount = !empty($resu->discount_amount) ? $resu->discount_amount : 0;
                //$discount_amount[]=$discount_amount++;
                //print_r($discount_amount);
                $data['due_amount'][]      = $due_amount++;
                $data['discount_amount'][] = $discount_amount++;
            }
        }

        //        $result=StudentFee::select(\DB::raw('SUM(student_fee_details.due_amount) as total_due_amount'))
        //         ->leftJoin('student_fee_details', 'student_fee_details.student_fee_id', '=', 'student_fees.id')
        //         ->where('student_fees.student_id', $studentId)
        //         ->where('student_fee_details.payment_type_id', $paymentTypeId)
        //         ->get();

        $result2 = StudentPayment::select(\DB::raw('SUM(discount_amount) as total_discount_amount'))
                                 ->where('student_id', $studentId)
                                 ->where('payment_type_id', $paymentTypeId)
                                 ->first();

        $total_due_amount      = array_sum($data['due_amount']);
        $total_discount_amount = !empty($result2->total_discount_amount) ? $result2->total_discount_amount : 0;
        $data                  = $total_due_amount - $total_discount_amount - array_sum($data['discount_amount']);
        if ($data > 0) {
            return $data;
        } else {
            return 0;
        }
    }

    public function saveStudentPayments($request)
    {
        $payment   = '';
        $a         = $request->amount;
        $aa        = array_filter($a);
        $b         = $request->discount_amount;
        $bb        = array_filter($b);
        $valuedata = $aa + $bb;
        $datavalue = [];

        foreach ($valuedata as $key => $value) {
            $datavalue[$key] = $request->payment_type_id[$key];
        }
        $lastId = DB::table('student_payments')->get()->last()->id;
        //$lastId=1;
        $last = count($datavalue);
        //$counter = 1;
        $sl        = 0;
        $invoiceNo = $lastId . date("yd") . date("h");

        foreach ($datavalue as $key => $val) {
            if ($val == 3) {
                $allFees = $this->studentFeeDetail->whereHas('fee', function ($q) use ($request) {
                    $q->where('student_id', $request->student_id);
                })->where('payment_type_id', 3)
                    //->whereIn('payment_type_id', [3, 5, 6])
                                                  ->orderBy('bill_year', 'ASC')->orderBy('bill_month', 'ASC')->where('status', '<>', 1)->with('fee')->get();
            } else if ($val == 1) {
                // development fee
                $allFees = $this->studentFeeDetail->whereHas('fee', function ($q) use ($request) {
                    $q->where('student_id', $request->student_id);
                })->where('payment_type_id', 1)->where('status', '<>', 1)->with('fee')->get();
            } else if ($val == 2) {
                // Admission Fee
                $allFees = $this->studentFeeDetail->whereHas('fee', function ($q) use ($request) {
                    $q->where('student_id', $request->student_id);
                })->where('payment_type_id', 2)->where('status', '<>', 1)->with('fee')->get();
            } else if ($val == 5) {
                // Late fee
                $allFees = $this->studentFeeDetail->whereHas('fee', function ($q) use ($request) {
                    $q->where('student_id', $request->student_id);
                })->where('payment_type_id', 5)->where('status', '<>', 1)->with('fee')->get();
            } else if ($val == 6) {
                // Re-admission  fee
                $allFees = $this->studentFeeDetail->whereHas('fee', function ($q) use ($request) {
                    $q->where('student_id', $request->student_id);
                })->where('payment_type_id', 6)->where('status', '<>', 1)->with('fee')->get();
            } else {
                // Class Absent Fee
                $allFees = $this->studentFeeDetail->whereHas('fee', function ($q) use ($request) {
                    $q->where('student_id', $request->student_id);
                })->where('payment_type_id', 4)->where('status', '<>', 1)->with('fee')->get();
            }
            $payment = $this->_processStudentPaymentsNew($request, $allFees, $key, $invoiceNo);
            $sl++;
        }

        // update student credit
        event(new UpdateStudentCredit($request->student_id));

        return $payment;
    }

    public function saveStudentPayments_old($request)
    {
        if ($request->payment_type_id == 3) {
            // tuition fee
            $allFees = $this->studentFeeDetail->whereHas('fee', function ($q) use ($request) {
                $q->where('student_id', $request->student_id);
            })->whereIn('payment_type_id', [3, 5, 6])
                                              ->orderBy('bill_year', 'ASC')->orderBy('bill_month', 'ASC')->where('status', '<>', 1)->with('fee')->get();
        } else if ($request->payment_type_id == 1) {
            // development fee
            $allFees = $this->studentFeeDetail->whereHas('fee', function ($q) use ($request) {
                $q->where('student_id', $request->student_id);
            })->where('payment_type_id', 1)->where('status', '<>', 1)->with('fee')->get();
        } else {
            $allFees = $this->studentFeeDetail->whereHas('fee', function ($q) use ($request) {
                $q->where('student_id', $request->student_id);
            })->where('payment_type_id', 4)->where('status', '<>', 1)->with('fee')->get();
        }

        $payment = $this->_processStudentPayments($request, $allFees);

        return $payment;
    }

    private function _processStudentPayments($request, $allFees, $key, $invoiceNo = '')
    {
        $bankCopy = null;

        if ($request->hasFile('bank_copy')) {
            $file     = $request->file('bank_copy');
            $filename = time() . '_' . $file->getClientOriginalName();
            $bankCopy = 'nemc_files/payment/' . $filename;
            if (!file_exists('nemc_files/payment')) {
                mkdir('nemc_files/payment', 0777, true);
            }
            $file->move('nemc_files/payment', $filename);
        }

        //        if($allFees->isNotEmpty()==false){
        //           return '';
        //        }

        //   if(!empty($request->amount[$key])){
        DB::beginTransaction();
        try {
            $payment = '';
            //if(!empty($request->amount[$key])){
            $payment = $this->studentPayment->create([
                'student_id'        => $request->student_id,
                'invoice_no'        => $invoiceNo,
                'payment_type_id'   => $request->payment_type_id[$key],
                'payment_method_id' => $request->payment_method_id,
                'bank_id'           => checkEmpty($request->bank_id),
                'bank_copy'         => checkEmpty($bankCopy),
                'due_amount'        => !empty($request->due_amount[$key]) ? $request->due_amount[$key] : '',
                'amount'            => !empty($request->amount[$key]) ? $request->amount[$key] : '',
                'discount_amount'   => !empty($request->discount_amount[$key]) ? $request->discount_amount[$key] : '',
                'available_amount'  => !empty($request->amount[$key]) ? $request->amount[$key] : '',
                'payment_date'      => $request->payment_date,
                'verify_payment'    => 1,
                'remarks'           => checkEmpty($request->remarks),
                'status'            => 1,
            ]);
            //}

            $result2         = StudentPayment::select(\DB::raw('SUM(available_amount) as total_available_amount'))
                                             ->where('student_id', $request->student_id)
                                             ->where('payment_type_id', $request->payment_type_id[$key])
                                             ->first();
            $availableAmount = !empty($result2->total_available_amount) ? $result2->total_available_amount : 0;

            //$availableAmount = $request->amount[$key];
            //            $availableAmount = $total_discount_amount;
            $status = 2;

            //        if($allFees->isNotEmpty()==false){
            //           return '';
            //        }

            if ($payment) {
                $discount = $payment->discount_amount;
                foreach ($allFees as $feeDetails) {
                    if ($availableAmount > 0) {
                        if ($feeDetails->due_amount <= $availableAmount) {
                            $payable = $feeDetails->due_amount;
                            $status  = 1;
                        } else {
                            $payable = $availableAmount;
                        }
                        $availableAmount -= $feeDetails->due_amount;

                        //create payment details
                        $payment->studentPaymentDetails()->create([
                            'student_fee_id'        => $feeDetails->student_fee_id,
                            'student_fee_detail_id' => $feeDetails->id,
                            'amount'                => $payable,
                            'status'                => 1,
                        ]);

                        $payment->available_amount = ($payment->available_amount - $payable);
                        $payment->save();

                        //update fee details
                        $feeDetails->due_amount = ($feeDetails->due_amount - $payable);
                        $feeDetails->status     = $status;
                        $feeDetails->save();

                        //update fee
                        $feeDetails->fee->paid_amount = ($feeDetails->fee->paid_amount + $payable);
                        $feeDetails->fee->due_amount  = ($feeDetails->fee->due_amount - $payable);
                        $checkStatus                  = $this->studentFeeDetail->where('student_fee_id', $feeDetails->student_fee_id)->where('status', '<>', 1)->count();

                        if (empty($checkStatus)) {
                            $feeDetails->fee->status = 1;
                        } else {
                            $feeDetails->fee->status = 2;
                        }
                        $feeDetails->fee->save();
                    } else {
                        if (!empty($discount)) {
                            if ($feeDetails->due_amount <= $discount) {
                                $payable = $feeDetails->due_amount;
                                $status  = 1;
                            } else {
                                $payable = $discount;
                                $status  = 2;
                            }
                            //create payment details
                            $payment->studentPaymentDetails()->create([
                                'student_fee_id'        => $feeDetails->student_fee_id,
                                'student_fee_detail_id' => $feeDetails->id,
                                'amount'                => $payable,
                                'status'                => 1,
                            ]);

                            //update fee details
                            $feeDetails->due_amount = ($feeDetails->due_amount - $payable);
                            $feeDetails->status     = $status;
                            $feeDetails->save();

                            //update fee
                            $feeDetails->fee->paid_amount = ($feeDetails->fee->paid_amount + $payable);
                            $feeDetails->fee->due_amount  = ($feeDetails->fee->due_amount - $payable);

                            $checkStatus = $this->studentFeeDetail->where('student_fee_id', $feeDetails->student_fee_id)->where('status', '<>', 1)->count();

                            if (empty($checkStatus)) {
                                $feeDetails->fee->status = 1;
                            } else {
                                $feeDetails->fee->status = 2;
                            }
                            $feeDetails->fee->save();
                        }
                    }
                }
            }
            DB::commit();
            $paymentInsertedId = !empty($payment->id) ? $payment->id : '';
            $studentInfo       = Student::with('session', 'course', 'phase', 'fee')->where('id', $request->student_id)->first();
            $invoice           = StudentPayment::where('invoice_no', $invoiceNo)->get();
            return array(
                'studentInfo'       => !empty($studentInfo) ? $studentInfo : '',
                'payment'           => !empty($payment) ? $payment : '',
                'invoice'           => !empty($invoice) ? $invoice : '',
                'invoiceNumber'     => $invoiceNo,
                'paymentInsertedId' => !empty($paymentInsertedId) ? $paymentInsertedId : ''
            );
        } catch (\Exception $e) {
            DB::rollBack();
            dd($e->getFile(), $e->getCode(), $e->getLine(), $e->getMessage());
            return $request->session()->flash('error', setMessage('create.error', 'student Payment data'));
        }
    }

    private function
    _processStudentPaymentsNew($request, $allFees, $key, $invoiceNo = '')
    {
        $bankCopy = null;
        if ($request->hasFile('bank_copy')) {
            $file     = $request->file('bank_copy');
            $filename = time() . '_' . $file->getClientOriginalName();
            $bankCopy = 'nemc_files/payment/' . $filename;
            if (!file_exists('nemc_files/payment')) {
                mkdir('nemc_files/payment', 0777, true);
            }
            $file->move('nemc_files/payment', $filename);
        }

        DB::beginTransaction();

        try {
            $payment            = '';
            $payment            = $this->studentPayment->create([
                'student_id'        => $request->student_id,
                'invoice_no'        => $invoiceNo,
                'payment_type_id'   => $request->payment_type_id[$key],
                'payment_method_id' => $request->payment_method_id,
                'bank_id'           => checkEmpty($request->bank_id),
                'bank_copy'         => checkEmpty($bankCopy),
                'due_amount'        => !empty($request->due_amount[$key]) ? $request->due_amount[$key] : '',
                'amount'            => !empty($request->amount[$key]) ? $request->amount[$key] : '',
                'discount_amount'   => !empty($request->discount_amount[$key]) ? $request->discount_amount[$key] : '',
                'available_amount'  => !empty($request->amount[$key]) ? $request->amount[$key] : '',
                'payment_date'      => $request->payment_date,
                'verify_payment'    => 1,
                'remarks'           => checkEmpty($request->remarks),
                'status'            => 1,
            ]);
            $availableAmount    = 0;
            $availableAmountSum = 0;

            $result2         = StudentPayment::select(\DB::raw('SUM(available_amount) as total_available_amount'))
                                             ->where('student_id', $request->student_id)
                                             ->where('payment_type_id', $request->payment_type_id[$key])
                                             ->first();
            $status          = 2;
            $availableAmount = $result2->total_available_amount;
            $discount        = $payment->discount_amount ?? 0;
            $payable         = 0;
            if ($payment) {
                foreach ($allFees as $feeDetails) {
                    if ($availableAmount > 0 || $discount > 0) {
                        if ($discount > 0) {
                            if ($discount < $feeDetails->due_amount) {
                                $feeDetails->discount_amount += $discount;
                                $feeDetails->payable_amount  = $feeDetails->total_amount - $feeDetails->discount_amount;
                                $feeDetails->due_amount      -= $discount;
                                $discount                    -= $feeDetails->discount_amount;
                                $feeDetails->save();
                                $status = 2;
                            } else {
                                $feeDetails->discount_amount += $feeDetails->due_amount;
                                $feeDetails->payable_amount  = $feeDetails->total_amount - $feeDetails->discount_amount;
                                $feeDetails->due_amount      -= $feeDetails->discount_amount;
                                $discount                    -= $feeDetails->discount_amount;
                                $feeDetails->save();
                                $status = 1;
                            }
                        }

                        if ($availableAmount > 0) {
                            if ($feeDetails->due_amount <= $availableAmount) {
                                $payable = $feeDetails->due_amount;
                                $status  = 1;
                            } else {
                                $payable = $availableAmount;
                                $status  = 2;
                            }
                        }
                        //create payment details
                        $payment->studentPaymentDetails()->create([
                            'student_fee_id'        => $feeDetails->student_fee_id,
                            'student_fee_detail_id' => $feeDetails->id,
                            'amount'                => $payable,
                            'status'                => 1,
                        ]);

                        if ($request->use_this) {
                            $paymentTypeIdArr = $request->use_this;
                            if ($request->use_this_total > 0) {
                                $x                = array_combine($request->use_this, $request->available_amount);
                                $paymentTypeIdArr = array_keys(array_filter($x));
                            }
                            $result             = StudentPayment::where('student_id', $request->student_id)
                                                                ->whereIn('payment_type_id', $paymentTypeIdArr)
                                                                ->where('available_amount', '>', 0)
                                                                ->orderBy('payment_type_id')
                                                                ->pluck('available_amount', 'id')->toArray();
                            $availableAmountSum = array_sum($result);
                        }

                        if (!empty($result)) {
                            if ($availableAmountSum > 0) {
                                foreach ($result as $id => $avlAmount) {
                                    if ($avlAmount >= $payable) {
                                        $avlAmount -= $payable;
                                        StudentPayment::where("id", $id)->update(['available_amount' => $avlAmount]);
                                        StudentPayment::where("id", $payment->id)->update(['advance_used' => 1]);
                                        $studentPayment = StudentPayment::where("id", $id)->select('payment_type_id')->first();

                                        $useHistories       = $this->advanceAmountUseHistories->create([
                                            'student_id'            => $request->student_id,
                                            'student_fee_detail_id' => $feeDetails->id,
                                            'from_payment_type_id'  => $studentPayment->payment_type_id,
                                            'to_payment_type_id'    => $payment->payment_type_id,
                                            'amount'                => $payable,
                                        ]);
                                        $availableAmountSum -= $payable;
                                    } else {
                                        StudentPayment::where("id", $id)
                                                      ->update([
                                                          'available_amount' => 0.00,
                                                      ]);
                                        StudentPayment::where("id", $payment->id)->update(['advance_used' => 1]);
                                        $studentPayment = StudentPayment::where("id", $id)->select('payment_type_id')->first();

                                        $useHistories       = $this->advanceAmountUseHistories->create([
                                            'student_id'            => $request->student_id,
                                            'student_fee_detail_id' => $feeDetails->id,
                                            'from_payment_type_id'  => $studentPayment->payment_type_id,
                                            'to_payment_type_id'    => $payment->payment_type_id,
                                            'amount'                => $avlAmount,
                                        ]);
                                        $availableAmountSum -= $avlAmount;
                                    }
                                }
                            }
                        }

                        if ($availableAmount > 0) {
                            $payment->available_amount -= $payable;
                            $payment->save();
                            $availableAmount -= $payable;
                        }

                        //update fee details
                        $feeDetails->due_amount -= $payable;
                        $feeDetails->status     = $status;
                        $feeDetails->save();

                        //update fee
                        $feeDetails->fee->discount_amount += $feeDetails->discount_amount;
                        $feeDetails->fee->payable_amount  = ($feeDetails->fee->total_amount - $feeDetails->fee->discount_amount);
                        $feeDetails->fee->paid_amount     += $payable;
                        $feeDetails->fee->due_amount      -= ($feeDetails->discount_amount + $payable);

                        $checkStatus = $this->studentFeeDetail->where('student_fee_id', $feeDetails->student_fee_id)->where('status', '<>', 1)->count();

                        if (empty($checkStatus)) {
                            $feeDetails->fee->status = 1;
                        } else {
                            $feeDetails->fee->status = 2;
                        }
                        $feeDetails->fee->save();
                    }
                }
            }

            DB::commit();

            $paymentInsertedId = !empty($payment->id) ? $payment->id : '';
            $studentInfo       = Student::with('session', 'course', 'phase', 'fee')->where('id', $request->student_id)->first();
            $invoice           = StudentPayment::where('invoice_no', $invoiceNo)->get();
            return array(
                'studentInfo'       => !empty($studentInfo) ? $studentInfo : '',
                'payment'           => !empty($payment) ? $payment : '',
                'invoice'           => !empty($invoice) ? $invoice : '',
                'invoiceNumber'     => $invoiceNo,
                'paymentInsertedId' => !empty($paymentInsertedId) ? $paymentInsertedId : ''
            );
        } catch (\Exception $e) {
            DB::rollBack();
            dd($e->getFile(), $e->getCode(), $e->getLine(), $e->getMessage());
            return $request->session()->flash('error', setMessage('create.error', 'student Payment data'));
        }
    }

    private function _processStudentPayments_old($request, $allFees)
    {
        $bankCopy = null;

        if ($request->hasFile('bank_copy')) {
            $file     = $request->file('bank_copy');
            $filename = time() . '_' . $file->getClientOriginalName();
            $bankCopy = 'nemc_files/payment/' . $filename;
            if (!file_exists('nemc_files/payment')) {
                mkdir('nemc_files/payment', 0777, true);
            }
            $file->move('nemc_files/payment', $filename);
        }

        DB::beginTransaction();

        $payment = $this->studentPayment->create([
            'student_id'        => $request->student_id,
            'payment_type_id'   => $request->payment_type_id,
            'payment_method_id' => $request->payment_method_id,
            'bank_id'           => checkEmpty($request->bank_id),
            'bank_copy'         => checkEmpty($bankCopy),
            'amount'            => $request->amount,
            'available_amount'  => $request->amount,
            'payment_date'      => $request->payment_date,
            'verify_payment'    => 1,
            'remarks'           => checkEmpty($request->remarks),
            'status'            => 1,
        ]);

        $availableAmount = $request->amount;
        $status          = 2;

        if ($payment) {
            foreach ($allFees as $fee) {
                if ($availableAmount > 0) {
                    if ($fee->due_amount <= $availableAmount) {
                        $payable = $fee->due_amount;
                        $status  = 1;
                    } else {
                        $payable = $availableAmount;
                    }
                    $availableAmount = $availableAmount - $fee->due_amount;

                    $payment->studentPaymentDetails()->create([
                        'student_fee_id'        => $fee->student_fee_id,
                        'student_fee_detail_id' => $fee->id,
                        'amount'                => $payable,
                        'status'                => 1,
                    ]);

                    $payment->available_amount = ($payment->available_amount - $payable);
                    $payment->save();

                    $fee->due_amount = ($fee->due_amount - $payable);
                    $fee->status     = $status;
                    $fee->save();

                    $fee->fee->paid_amount = ($fee->fee->paid_amount + $payable);
                    $fee->fee->due_amount  = ($fee->fee->due_amount - $payable);

                    $checkStatus = $this->studentFeeDetail->where('student_fee_id', $fee->student_fee_id)->where('status', '<>', 1)->count();

                    if (empty($checkStatus)) {
                        $fee->fee->status = 1;
                    } else {
                        $fee->fee->status = 2;
                    }
                    $fee->fee->save();
                }
            }
        }

        DB::commit();

        $paymentInsertedId = $payment->id;
        //dd($paymentInsertedId);

        $studentInfo = Student::with('session', 'course', 'phase', 'fee')->where('id', $request->student_id)->first();
        //dd($studentInfo);

        return array(
            'studentInfo'       => $studentInfo,
            'payment'           => $payment,
            'paymentInsertedId' => $paymentInsertedId
        );
    }

    public function getFailedStudentsByExamIdCourseIdPhaseIdSubjectId($examId, $subjectId, $courseId, $phaseId)
    {
        if (!empty($examId)) {
            $exam = $this->exam->find($examId);

            $lastExamByType = $this->exam->where('exam_category_id', $exam->exam_category_id)->where('term_id', $exam->term_id)->where('course_id', $courseId)->where('phase_id', $phaseId)->pluck('id')->toArray();

            $students = $this->model->whereDoesntHave('result', function ($q) use ($lastExamByType, $subjectId, $courseId, $phaseId) {
                $q->where('status', 1)->whereHas('examSubjectMark', function ($q) use ($lastExamByType, $subjectId, $courseId, $phaseId) {
                    $q->where('subject_id', $subjectId)->whereIn('exam_id', $lastExamByType);
                });
            })->where([
                ['course_id', $courseId],
                ['phase_id', $phaseId],
                ['batch_type_id', 2]
            ])->orderBy('roll_no')->get();

            return $students;
        } else {
            $students = $this->model->whereDoesntHave('result', function ($q) use ($subjectId, $courseId, $phaseId) {
                $q->where('status', 1)->whereHas('examSubjectMark', function ($q) use ($subjectId, $courseId, $phaseId) {
                    $q->where('subject_id', $subjectId);
                });
            })->where([
                ['course_id', $courseId],
                ['phase_id', $phaseId],
                ['batch_type_id', 2]
            ])->orderBy('roll_no')->get();

            return $students;
        }
    }

    public function changePassword($request, $id)
    {
        $student = $this->find($id);
        $student->user->update([
            'password' => Hash::make($request->new_password)
        ]);

        if ($student->email) {
            $user                    = User::where('id', $student->user_id)->first();
            $studentPasswordMailBody = '
                    <table>
                        <tr>
                            <td>Dear ' . $student->full_name_en . ',</td>
                        </tr>
                        <tr>
                            <td>Your Password has been reset </td>
                        </tr>
                        <tr>
                            <td>URL: ' . url('/login') . ' </td>
                        </tr>
                        <tr>
                            <td>User ID: ' . $user->user_id . ' </td>
                        </tr>
                        <tr>
                            <td>Password: ' . $request->new_password . ' </td>
                        </tr>
                    <table>';
            $this->emailService->mailSend($student->email, '', 'NEMC: Student Password', 'password_reset', $studentPasswordMailBody, '', $user);
        }

        return $student;
    }

    public function getStudentListWithStatus($request)
    {
        $students = $this->model->with('session', 'course', 'phase', 'studentCategory')->where([
            ['followed_by_session_id', $request->session_id],
            ['course_id', $request->course_id]
        ])
                                ->whereIn('status', [1, 3])
                                ->orderBy('roll_no');

        if (!empty($request->student_category_id)) {
            $students = $students->where('student_category_id', $request->student_category_id);
        }
        if (!empty($request->phase_id)) {
            $students = $students->where('phase_id', $request->phase_id);
        }
        if (!empty($request->roll_no)) {
            $students = $students->where('roll_no', $request->roll_no);
        }
        if (!empty($request->email)) {
            $students = $students->where('email', $request->email);
        }
        if (!empty($request->phone)) {
            $students = $students->where('phone', $request->phone);
        }

        return $students->get();
    }

    // student admission report
    public function searchStudentsByTypeSessionIdCourseId($type, $sessionId, $courseId)
    {
        $search = $this->model->with([
            'parent',
            'country',
            'educations',
            'studentCategory',
            'educations.educationBoard'
        ])
                              ->where('status', '!=', 2)
                              ->orderBy('roll_no', 'ASC');

        if ($type == 3) {
            $search = $search->where('student_category_id', '>=', $type);
        } elseif ($type !== 'all') {
            $search = $search->where('student_category_id', $type);
        }

        if (!empty($sessionId)) {
            $search = $search->where('followed_by_session_id', $sessionId);
        }

        if (!empty($courseId)) {
            $search = $search->where('course_id', $courseId);
        }

        if ($type == 3) {
            return $search->get()->sortByDesc(function ($q) {
                return $q->parent->total_asset_grade;
            });
        } else {
            return $search->get();
        }
    }

    // count total absent class number by student info
    public function countStudentAbsentClassNumber($request)
    {
        $student      = $this->find($request->studentId);
        $classRoutine = $this->classRoutine->where('phase_id', $request->phaseId)->whereHas('attendances', function ($q) use ($student) {
            $q->where('student_id', $student->id);
        })->orderBy('class_date', 'asc')
                                           ->select(DB::raw('MIN(class_date) as min_date'), DB::raw('MAX(class_date) as max_date'))
                                           ->first();
        //absent fee
        if (!empty($classRoutine->min_date) && !empty($classRoutine->max_date)) {
            $totalAbsent = $this->attendacance->whereHas('classRoutine', function ($q) use ($classRoutine) {
                $q->whereDate('class_date', '>=', $classRoutine->min_date)->whereDate('class_date', '<=', $classRoutine->max_date)->where('class_type_id', '!=', 9);
            })->where('student_id', $request->studentId)->where('attendance', 0)->count();

            return $totalAbsent;
        }
    }

    public function getAllStudentBySessionAndCourseId($sessionId, $courseId)
    {
        return $this->model->with('user')->where([
            ['followed_by_session_id', $sessionId],
            ['course_id', $courseId]
        ])
                           ->whereIn('status', [1, 3])
                           ->orderBy('roll_no', 'asc')->get();
    }

    public function getStudentsRollBySessionCoursePhase($session, $course, $phase)
    {
        return $this->model->where('followed_by_session_id', $session)
                           ->where('course_id', $course)
                           ->where('phase_id', $phase)
                           ->whereIn('status', [1, 3])
                           ->orderBy('roll_no')
                           ->pluck('roll_no', 'id')->toArray();
    }

    public function getTotalStudentsByCurrentSessionIdAndCourseId($session, $course, $phase)
    {
        return $this->model->where('followed_by_session_id', $session)
                           ->where('course_id', $course)
                           ->where('phase_id', $phase)
                           ->whereIn('status', [1, 3])
                           ->count();
    }
}
