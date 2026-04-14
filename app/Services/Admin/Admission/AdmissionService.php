<?php

namespace App\Services\Admin\Admission;

use App\Imports\ApplicantsImport;
use App\Models\AdmissionParent;
use App\Models\AdmissionStudent;
use App\Models\Session;
use App\Models\Student;
use App\Models\StudentFeeDetail;
use App\Services\Admin\PaymentTypeService;
use App\Services\Admin\UserService;
use App\Services\BaseService;
use App\Services\EmailService;
use App\Services\StudentFeeService;
use Carbon\Carbon;
use DataTables;
use Excel;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Mockery\Exception;

class AdmissionService extends BaseService
{

    protected $sessions;
    protected $userService;
    protected $admissionParent;
    protected $emailService;
    protected $student;
    protected $paymentTypeService;
    protected $studentFeeService;
    protected $studentFeeDetail;

    public function __construct(
        AdmissionStudent $admissionStudent, Session $sessions, UserService $userService, AdmissionParent $admissionParent,
        EmailService     $emailService, Student $student, PaymentTypeService $paymentTypeService, StudentFeeService $studentFeeService, StudentFeeDetail $studentFeeDetail
    )
    {
        $this->model = $admissionStudent;
        $this->sessions = $sessions;
        $this->userService = $userService;
        $this->admissionParent = $admissionParent;
        $this->emailService = $emailService;
        $this->student = $student;
        $this->paymentTypeService = $paymentTypeService;
        $this->studentFeeService = $studentFeeService;
        $this->studentFeeDetail = $studentFeeDetail;
    }

    public function getDataTable($request)
    {
        $query = $this->model->select(
            '*',
            \DB::raw('(SELECT count(*) FROM `students` WHERE `mobile` = `admission_students`.`mobile` AND `session_id` = `admission_students`.`session_id` AND `course_id` = `admission_students`.`course_id`) AS `student_transfer`'))
                             ->orderBy('student_transfer', 'asc')
                             ->orderBy('status', 'desc')
                             ->orderBy(\DB::raw('CAST(admission_roll_no AS UNSIGNED)'), 'asc')
                             ->latest()
                             ->with('session', 'course', 'studentCategory');

        if (Auth::guard('web')->check()) {
            $user = Auth::guard('web')->user();
            if ($user->teacher) {
                if (!empty($user->teacher->course_id)) {
                    $query = $query->where('course_id', $user->teacher->course_id);
                }
            } else if (!empty($user->adminUser->course_id)) {
                $query = $query->where('course_id', $user->adminUser->course_id);
            }
        }

        if (!empty($request->get('session_id'))) {
            $query = $query->where('session_id', $request->get('session_id'));
        }

        return Datatables::of($query)
                         ->editColumn('session_id', function ($row) {
                             return $row->session->title;
                         })
                         ->editColumn('course_id', function ($row) {
                             return $row->course->title;
                         })
                         ->editColumn('student_category_id', function ($row) {
                             return $row->studentCategory->title;
                         })
                         ->editColumn('photo', function ($row) {
                             $imageSrc = !empty($row->photo) ? $row->photo : getAvatar($row->gender);
                             return '<img src="' . asset($imageSrc) . '" width="50px">';
                         })
                         ->addColumn('action', function ($row) {
                             $actions = '';
                             $checkData = $this->student->where('mobile', $row->mobile)->where('session_id', $row->session_id)->where('course_id', $row->course_id)->count();
                             if ($row->status == 3) {
                                 if (hasPermission('admission/transfer')) {
                                     if ($checkData == 0) {
                                         $actions .= '<a href="' . route('admission.transfer.student.form', [$row->id]) . '" class="m-portlet__nav-link btn m-btn m-btn--hover-brand m-btn--icon m-btn--icon-only m-btn--pill" title="Transfer to student"><i class="fa fa-user"></i></a>';
                                     }
                                 }
                             }
                             if (hasPermission('admission/edit')) {
                                 if ($checkData == 0) {
                                     $actions .= '<a href="' . route('admission.edit', [$row->id]) . '" class="m-portlet__nav-link btn m-btn m-btn--hover-brand m-btn--icon m-btn--icon-only m-btn--pill" title="Edit"><i class="flaticon-edit"></i></a>';
                                     $actions .= '<a href="#" class="m-portlet__nav-link btn m-btn m-btn--hover-brand m-btn--icon m-btn--icon-only m-btn--pill status-update" data-applicant-id="' . $row->id . '" data-applicant-status="' . $row->status . '" title="Update Status"><i class="fas fa-external-link-alt"></i></a>';
                                 }
                             }
                             //open modal and send id and status to modal
                             /*                $actions.= '<a href="#" class="m-portlet__nav-link btn m-btn m-btn--hover-brand m-btn--icon m-btn--icon-only m-btn--pill status-update" data-applicant-id="'.$row->id.'" data-applicant-status="'.$row->status.'" title="Update Status"><i class="fas fa-external-link-alt"></i></a>';*/

                             $actions .= '<a href="' . route('admission.show', [$row->id]) . '" class="m-portlet__nav-link btn m-btn m-btn--hover-brand m-btn--icon m-btn--icon-only m-btn--pill" title="View"><i class="flaticon-eye"></i></a>';

                             if (($row->status == 1) && hasPermission('admission/delete') && $checkData == 0) {
                                 $actions .= '<a href="javascript:void(0)" class="btn m-btn m-btn--icon m-btn--icon-only applicant-delete" data-applicant-id="' . $row->id . '" title="Delete"><i class="fa fa-trash-alt"></i></a>';
                             }

                             return $actions;
                         })
                         ->editColumn('status', function ($row) {
                             return !empty($row->status) ? admissionApplicantStatus($row->status) : admissionApplicantStatus(1);
                         })
                         ->rawColumns(['photo', 'status', 'action'])
                         ->filter(function ($query) use ($request) {
                             if (!empty($request->get('session_id'))) {
                                 $query->where('session_id', $request->get('session_id'));
                             }
                             if (!empty($request->get('course_id'))) {
                                 $query->where('course_id', $request->get('course_id'));
                             }
                             if (!empty($request->get('student_category_id'))) {
                                 $query->where('student_category_id', $request->get('student_category_id'));
                             }
                             if ($request->get('full_name_en')) {
                                 $query->where('full_name_en', 'like', '%' . $request->get('full_name_en') . '%');
                             }
                             if (!empty($request->get('admission_roll_no'))) {
                                 $query->where('admission_roll_no', $request->get('admission_roll_no'));
                             }
                             if (!empty($request->get('email'))) {
                                 $query->where('email', $request->get('email'));
                             }
                             if (!empty($request->get('phone_mobile'))) {
                                 $query->where('phone', $request->get('phone_mobile'))->orWhere('mobile', $request->get('phone_mobile'));
                             }
                             if (!empty($request->get('status'))) {
                                 $query->where('status', $request->get('status'));
                             }
                         })
                         ->make(true);
    }

    public function addApplicant($request)
    {
        if ($request->has(['session_id', 'course_id', 'mobile'])) {
            //prevent multiple insertion of same data of same session, course and mobile
            $checkSessionCourseMobileExist = $this->model->where([
                ['session_id', $request->session_id],
                ['course_id', $request->course_id],
                ['mobile', $request->mobile],
            ])->count();

            DB::beginTransaction();
            try {
                if ($checkSessionCourseMobileExist == 0) {

                    //parents info
                    $parentInfo = [];
                    if (isset($request->parent_exist)) {
                        $parentInfo = $this->admissionParent->where('father_phone', $request->father_phone)->first();
                    }

                    if (empty($parentInfo)) {
                        $parentsData = [
                            'father_name' => $request->father_name,
                            'mother_name' => $request->mother_name,
                            'father_phone' => $request->father_phone,
                            'mother_phone' => checkEmpty($request->mother_phone),
                            'father_email' => checkEmpty($request->father_email),
                            'mother_email' => checkEmpty($request->mother_email),
                            'address' => checkEmpty($request->parent_address),
                            'occupation' => checkEmpty($request->occupation),
                            'annual_income' => checkEmpty($request->annual_income),
                            'annual_income_grade' => checkEmpty($request->annual_income_grade),
                            'movable_property' => checkEmpty($request->movable_property),
                            'movable_property_grade' => checkEmpty($request->movable_property_grade),
                            'immovable_property' => checkEmpty($request->immovable_property),
                            'immovable_property_grade' => checkEmpty($request->immovable_property_grade),
                            'total_asset' => checkEmpty($request->total_asset),
                            'total_asset_grade' => checkEmpty($request->total_asset_grade),
                            'finance_during_study' => $request->finance_during_study,
                        ];

                        $parentInfo = $this->admissionParent->create($parentsData);
                    }

                    $parentInfo->admissionStudents()->create([
                        'course_id' => $request->course_id,
                        'student_category_id' => $request->student_category_id,
                        'session_id' => $request->session_id,
                        'full_name_en' => $request->full_name_en,
                        'full_name_bn' => checkEmpty($request->full_name_bn),
                        'admission_roll_no' => checkEmpty($request->admission_roll_no),
                        'form_fillup_date' => $request->form_fillup_date,
                        'admission_year' => $request->admission_year,
                        'commenced_year' => $request->commenced_year,
                        'test_score' => checkEmpty($request->test_score),
                        'merit_score' => checkEmpty($request->merit_score),
                        'merit_position' => checkEmpty($request->merit_position),
                        'gender' => $request->gender,
                        'date_of_birth' => $request->date_of_birth,
                        'blood_group' => checkEmpty($request->blood_group),
                        'place_of_birth' => $request->place_of_birth,
                        'nationality' => $request->nationality,
                        'mother_tongue' => checkEmpty($request->mother_tongue),
                        'knowledge_english' => checkEmpty($request->knowledge_english),
                        'phone' => $request->phone,
                        'mobile' => $request->mobile,
                        'email' => checkEmpty($request->email),
                        'passport_number' => checkEmpty($request->passport_number),
                        'visa_duration' => checkEmpty($request->visa_duration),
                        'embassy_contact_no' => checkEmpty($request->embassy_contact_no),
                        'permanent_address' => checkEmpty($request->permanent_address),
                        'same_as_permanent' => isset($request->same_as_present) ? true : false,
                        'present_address' => checkEmpty($request->present_address),
                        'photo' => checkEmpty($request->applicant_photo),
                        'remarks' => checkEmpty($request->personal_remarks),
                    ]);

                    $applicant = $parentInfo->admissionStudents[count($parentInfo->admissionStudents) - 1];

                    //emergency contact
                    $emergencyContact = [
                        'full_name' => checkEmpty($request->emergency_contact_name),
                        'relation' => checkEmpty($request->emergency_contact_relation),
                        'phone' => checkEmpty($request->emergency_phone),
                        'email' => checkEmpty($request->emergency_email),
                        'address' => checkEmpty($request->emergency_address),
                    ];

                    $applicant->admissionEmergencyContact()->create($emergencyContact);

                    //education
                    $educationHistories = [
                        [
                            'education_level' => $request->education_level_ssc,
                            'education_board_id' => $request->education_board_id_ssc,
                            'institution' => $request->institution_ssc,
                            'pass_year' => $request->pass_year_ssc,
                            'gpa' => $request->gpa_ssc,
                            'gpa_biology' => $request->gpa_biology_ssc,
                            'extra_activity' => checkEmpty($request->extra_activity_ssc)
                        ],
                        [
                            'education_level' => $request->education_level_hsc,
                            'education_board_id' => $request->education_board_id_hsc,
                            'institution' => $request->institution_hsc,
                            'pass_year' => $request->pass_year_hsc,
                            'gpa' => $request->gpa_hsc,
                            'gpa_biology' => $request->gpa_biology_hsc,
                            'extra_activity' => checkEmpty($request->extra_activity_hsc)
                        ]
                    ];

                    $applicant->admissionEducationHistories()->createMany($educationHistories);

                    //attachments
                    $applicantAttachments = [];
                    if (!empty($request->attachment_type_id)) {
                        foreach ($request->attachment_type_id as $key => $attachment) {
                            $applicantAttachments[$key] = [
                                'attachment_type_id' => $attachment,
                                'file_path' => $request->file_path[$key],
                                'type' => $request->type[$key],
                                'remarks' => checkEmpty($request->remarks[$key]),
                            ];
                        }
                        unset($key);
                        $applicant->admissionAttachments()->createMany($applicantAttachments);
                    }

                    DB::commit();

                    return $applicant;
                }
                return $applicant = null;
            } catch (\Exception $e) {
                DB::rollBack();
//                dd($e->getFile(), $e->getCode(), $e->getLine(), $e->getMessage());
                return $request->session()->flash('error', setMessage('create.error', 'Applicant'));
            }
        }
    }

    public function editApplicant($request, $id)
    {

        $applicant = $this->find($id);

        DB::beginTransaction();

        try {
            $applicant->update([
                'course_id' => $request->course_id,
                'student_category_id' => $request->student_category_id,
                'session_id' => $request->session_id,
                'full_name_en' => $request->full_name_en,
                'full_name_bn' => checkEmpty($request->full_name_bn),
                'admission_roll_no' => checkEmpty($request->admission_roll_no),
                'form_fillup_date' => $request->form_fillup_date,
                'admission_year' => $request->admission_year,
                'commenced_year' => $request->commenced_year,
                'test_score' => checkEmpty($request->test_score),
                'merit_score' => checkEmpty($request->merit_score),
                'merit_position' => checkEmpty($request->merit_position),
                'gender' => $request->gender,
                'date_of_birth' => $request->date_of_birth,
                'place_of_birth' => $request->place_of_birth,
                'blood_group' => checkEmpty($request->blood_group),
                'nationality' => $request->nationality,
                'mother_tongue' => checkEmpty($request->mother_tongue),
                'knowledge_english' => checkEmpty($request->knowledge_english),
                'phone' => $request->phone,
                'mobile' => $request->mobile,
                'email' => checkEmpty($request->email),
                'passport_number' => checkEmpty($request->passport_number),
                'visa_duration' => checkEmpty($request->visa_duration),
                'embassy_contact_no' => checkEmpty($request->embassy_contact_no),
                'permanent_address' => checkEmpty($request->permanent_address),
                'same_as_permanent' => isset($request->same_as_present) ? true : false,
                'present_address' => checkEmpty($request->present_address),
                'photo' => checkEmpty($request->applicant_photo),
                'remarks' => checkEmpty($request->personal_remarks),
                'status' => $request->status,
            ]);

            //parents info
            $parentsData = [
                'father_name' => $request->father_name,
                'mother_name' => $request->mother_name,
                'father_phone' => $request->father_phone,
                'mother_phone' => checkEmpty($request->mother_phone),
                'father_email' => checkEmpty($request->father_email),
                'mother_email' => checkEmpty($request->mother_email),
                'address' => checkEmpty($request->parent_address),
                'occupation' => checkEmpty($request->occupation),
                'annual_income' => checkEmpty($request->annual_income),
                'annual_income_grade' => checkEmpty($request->annual_income_grade),
                'movable_property' => checkEmpty($request->movable_property),
                'movable_property_grade' => checkEmpty($request->movable_property_grade),
                'immovable_property' => checkEmpty($request->immovable_property),
                'immovable_property_grade' => checkEmpty($request->immovable_property_grade),
                'total_asset' => checkEmpty($request->total_asset),
                'total_asset_grade' => checkEmpty($request->total_asset_grade),
                'finance_during_study' => $request->finance_during_study,
            ];

            $applicant->admissionParent()->update($parentsData);

            //emergency contact
            $emergencyContact = [
                'full_name' => checkEmpty($request->emergency_contact_name),
                'relation' => checkEmpty($request->emergency_contact_relation),
                'phone' => checkEmpty($request->emergency_phone),
                'email' => checkEmpty($request->emergency_email),
                'address' => checkEmpty($request->emergency_address),
            ];

            $applicant->admissionEmergencyContact()->update($emergencyContact);

            //education
            $educationHistories = [
                [
                    'education_level' => $request->education_level_ssc,
                    'education_board_id' => $request->education_board_id_ssc,
                    'institution' => $request->institution_ssc,
                    'pass_year' => $request->pass_year_ssc,
                    'gpa' => $request->gpa_ssc,
                    'gpa_biology' => $request->gpa_biology_ssc,
                    'extra_activity' => checkEmpty($request->extra_activity_ssc)
                ],
                [
                    'education_level' => $request->education_level_hsc,
                    'education_board_id' => $request->education_board_id_hsc,
                    'institution' => $request->institution_hsc,
                    'pass_year' => $request->pass_year_hsc,
                    'gpa' => $request->gpa_hsc,
                    'gpa_biology' => $request->gpa_biology_hsc,
                    'extra_activity' => checkEmpty($request->extra_activity_hsc)
                ]
            ];

            $applicant->admissionEducationHistories->each(function ($history) {
                $history->delete();
            });
            $applicant->admissionEducationHistories()->createMany($educationHistories);

            //attachments
            $applicantAttachments = [];
            if (!empty($request->attachment_type_id)) {
                $applicant->admissionAttachments->each(function ($attachment) {
                    $attachment->delete();
                });

                foreach ($request->attachment_type_id as $key => $attachment) {
                    $applicantAttachments[$key] = [
                        'attachment_type_id' => $attachment,
                        'file_path' => $request->file_path[$key],
                        'type' => $request->type[$key],
                        'remarks' => checkEmpty($request->remarks[$key]),
                    ];
                }
                unset($key);

                $applicant->admissionAttachments()->createMany($applicantAttachments);
            }

            DB::commit();

            return $applicant;
        } catch (\Exception $e) {
            DB::rollBack();
//            dd($e->getFile(), $e->getCode(), $e->getLine(), $e->getMessage());
            return $request->session()->flash('error', setMessage('Update.error', 'Applicant'));
        }
    }

    public function checkEmailIsUnique($request)
    {
        if ($request->has('id')) {
            return $this->model->where('id', '<>', $request->id)->where('email', $request->email)->count();
        } else {
            return $this->model->where('email', $request->email)->count();
        }
    }

    public function checkRollIsUnique($request)
    {
        if ($request->has('id')) {
            return $this->model->where('id', '<>', $request->id)
                               ->where('admission_roll_no', $request->admission_roll_no)
                               ->where('session_id', $request->session_id)
                               ->where('course_id', $request->course_id)
                               ->count();
        }

        return $this->model->where('admission_roll_no', $request->admission_roll_no)
                           ->where('session_id', $request->session_id)
                           ->where('course_id', $request->course_id)
                           ->count();
    }

    public function checkMobileIsUnique($request)
    {
        if ($request->has('id')) {
            return $this->model->where('id', '<>', $request->id)->where('mobile', $request->mobile)->count();
        }

        return $this->model->where('mobile', $request->mobile)->count();
    }

    public function transferDataToStudent($request, $id)
    {
        if ($request->has('roll_no')) {
            //prevent multiple insertion of same data of same session, course and mobile
            $studentInfo = $this->find($id)->replicate();
            $checkRollExist = $this->student->where('roll_no', $request->roll_no)
                                            ->where('session_id', $studentInfo->session_id)
                                            ->where('course_id', $studentInfo->course_id)
                                            ->count();

            try {

                DB::beginTransaction();

                if ($checkRollExist == 0) {
                    $admissionStudent = $this->model->where('id', $id)->with('admissionParent', 'admissionEmergencyContact', 'admissionEducationHistories', 'admissionAttachments')->first()->replicate();

                    unset($studentInfo->admission_parent_id, $studentInfo->created_by, $studentInfo->updated_by, $studentInfo->status, $studentInfo->remarks);
                    $studentInfo->student_id = $request->student_id;
                    $studentInfo->batch_type_id = 1;
                    $studentInfo->phase_id = 1;
                    $studentInfo->term_id = 1;
                    $studentInfo->roll_no = $request->roll_no;

                    $parentInfo = $admissionStudent->admissionParent->replicate();
                    unset($parentInfo->created_by, $parentInfo->updated_by);
                    $emergencyContactInfo = $admissionStudent->admissionEmergencyContact->replicate();
                    unset($emergencyContactInfo->admission_student_id, $emergencyContactInfo->created_by, $emergencyContactInfo->updated_by);

                    $educationInfo = [];
                    foreach ($admissionStudent->admissionEducationHistories as $key => $history) {
                        $history = $history->replicate();
                        unset($history->admission_student_id, $history->created_by, $history->updated_by);
                        $educationInfo[$key] = $history->toArray();
                    }

                    $attachmentInfo = [];
                    if (!empty($admissionStudent->admissionAttachments)) {
                        foreach ($admissionStudent->admissionAttachments as $key => $attachment) {
                            $attachment = $attachment->replicate();
                            unset($attachment->admission_student_id, $attachment->created_by, $attachment->updated_by);
                            $attachmentInfo[$key] = $attachment->toArray();
                        }
                    }

                    $checkUser = $this->userService->getUserByParentPhone($parentInfo->father_phone);
                    if (empty($checkUser)) {
                        //parent user
                        $parentUser = $this->userService->create([
                            'user_group_id' => 6,
                            'email' => checkEmpty($parentInfo->father_email),
                            'user_id' => 'pr' . $request->user_id,
                            'password' => Hash::make('123456'),
                        ]);

                        $parentInfo->user_id = $parentUser->id;
                        $parentUser->parent()->create(json_decode($parentInfo, true));
                    } else {
                        $parentUser = $checkUser;
                    }

                    // add user
                    $user = $this->userService->create([
                        'user_group_id' => 5,
                        'email' => $admissionStudent->email,
                        'user_id' => $request->user_id,
                        'password' => Hash::make($request->password),
                    ]);

                    $studentInfo->parent_id = $parentUser->parent->id;
                    $studentInfo->roll_no = $request->roll_no;
                    $studentInfo->followed_by_session_id = $admissionStudent->session_id;

                    $studentInfo = json_decode($studentInfo, true);

                    $user->student()->create($studentInfo);

                    $student = $user->student;
                    //Installment(student fee)
                    if ($student) {
                        //get session info
                        $sessionInfo = $student->session->sessionDetails->filter(function ($item) use ($student) {
                            return ($item->course_id == $student->course_id);
                        });

                        //get development fee according to student
                        if ($student->student_category_id == 2) {
                            $developmentFee = $sessionInfo->first()->development_fee_foreign;
                        } elseif ($student->student_category_id > 2) {
                            $developmentFee = $this->paymentTypeService->getPaymentDetailByTypeIdAndCourseIdAndCategoryId(1, $student->course_id, $student->student_category_id)->amount;
                        } else {
                            $developmentFee = $sessionInfo->first()->development_fee_local;
                        }
                        //save student fee data to student fee table
                        $studentFeeData = $this->studentFeeService->create([
                            'student_id' => $student->id,
                            'title' => 'Development Fee',
                            'total_amount' => $developmentFee,
                            'discount_amount' => null,
                            'payable_amount' => $developmentFee,
                            'due_amount' => $developmentFee,
                        ]);

                        //save student fee data to student fee detail table
                        $sessionStartYear = $student->session->start_year;
                        $duration = $student->session->sessionDetails->where('course_id', $student->course_id)->first()->sessionPhaseDetails->first()->duration;
                        $parseDuration = explode('.', $duration);
                        $paymentLastDate = Carbon::create($sessionStartYear, 1, 1)->addYears($parseDuration[0])->addMonths($parseDuration[1])->lastOfMonth()->format('d/m/Y');

                        $this->studentFeeDetail->create([
                            'student_fee_id' => $studentFeeData->id,
                            'payment_type_id' => 1,
                            'total_amount' => $developmentFee,
                            'discount_amount' => null,
                            'payable_amount' => $developmentFee,
                            'due_amount' => $developmentFee,
                            'discount_application' => null,
                            'last_date_of_payment' => $paymentLastDate,
                        ]);
                    }

                    $student->emergencyContact()->create(json_decode($emergencyContactInfo, true));

                    $student->educations()->createmany($educationInfo);

                    if (!empty($attachmentInfo)) {
                        $student->attachments()->createMany($attachmentInfo);
                    }

                    // send mail to student
                    if ($student && !empty($studentInfo->email)) {
                        $studentMailBody = '
                    <table>
                        <tr>
                            <td>Dear ' . $studentInfo->full_name_en . ',</td>
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
                        //$this->emailService->mailSend($studentInfo->email, 'info@nemc.edu.bd', 'NEMC: Student ID has been generated', $studentMailBody);
                    }

                    // send mail to student father
                    if (!empty($parentUser) && !empty($parentInfo->father_email)) {
                        $parentMailBody = '
                    <table>
                        <tr>
                            <td>Dear ' . $parentInfo->father_name . ',</td>
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
                            <td>Password: 123456 </td>
                        </tr>
                    <table>';
                        //$this->emailService->mailSend($request->email, 'info@nemc.edu.bd', 'NEMC: Parent ID has been generated', $parentMailBody);
                    }

                    DB::commit();

                    return $student;
                }
                return null;
            } catch (\Exception $e) {
                DB::rollBack();
//                dd($e->getFile(), $e->getCode(), $e->getLine(), $e->getMessage());
                return $request->session()->flash('error', setMessage('create.error', 'Student'));
            }
        }
    }

    public function searchStudentsByTypeSessionIdCourseId($type, $sessionId, $courseId)
    {
        $search = $this->model->with(['admissionParent', 'country', 'admissionEducationHistories']);

        if ($type == 3) {
            $search = $search->where('student_category_id', '>=', $type);
        } else {
            $search = $search->where('student_category_id', $type);
        }

        if (!empty($sessionId)) {
            $search = $search->where('session_id', $sessionId);
        }

        if (!empty($courseId)) {
            $search = $search->where('course_id', $courseId);
        }

        if ($type == 3) {
            return $search->get()->sortByDesc(function ($q) {
                return $q->admissionParent->total_asset_grade;
            });
        }

        return $search->get();
    }

    //update status of applicant
    public function updateApplicantStatus($request, $applicantId)
    {
        $applicantData = $this->find($applicantId);
        $applicantData->update([
            'status' => $request->status
        ]);

        return $applicantData;
    }

    public function importApplicants($request)
    {
        if (!$request->hasFile('applicants_file')) {
            return response()->json([
                'message' => 'No file was uploaded',
                'status' => false
            ]);
        }

        try {
            $file = $request->file('applicants_file');
            Excel::import($import = new ApplicantsImport($request, $this, $this->admissionParent), $file);

            return $import;
        } catch (\Exception $e) {
            Log::error('Applicants import failed: ' . $e->getMessage());
            throw new Exception($e->getMessage());
        }
    }

    public function getAdmissionParent()
    {
        return $this->admissionParent;
    }

}
