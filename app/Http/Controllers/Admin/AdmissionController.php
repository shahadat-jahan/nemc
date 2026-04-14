<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\TransferStudent;
use App\Models\AdmissionAttachment;
use App\Models\AdmissionEducationHistory;
use App\Models\AdmissionEmergencyContact;
use Illuminate\Support\Facades\Log;
use App\Services\Admin\Admission\AdmissionService;
use App\Services\Admin\CourseService;
use App\Services\Admin\EducationBoardService;
use App\Services\Admin\SessionService;
use App\Services\Admin\StudentCategoryService;
use App\Services\Admin\StudentService;
use App\Services\AttachmentService;
use App\Services\CountryService;
use App\Services\UtilityServices;
use DB;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Validators\ValidationException;

class AdmissionController extends Controller
{
    /**
     *
     */
    const moduleName = 'Admission Management';
    /**
     *
     */
    const redirectUrl = 'admin/admission';
    /**
     *
     */
    const moduleDirectory = 'admission.';

    protected $service;
    protected $sessionService;
    protected $courseService;
    protected $studentCategoryService;
    protected $country;
    protected $educationBoardService;
    protected $attachmentService;
    protected $studentService;

    public function __construct(AdmissionService $service, SessionService $sessionService, CourseService $courseService,
                                StudentCategoryService $studentCategoryService, CountryService $country, EducationBoardService $educationBoardService,
                                AttachmentService $attachmentService, StudentService $studentService
    )
    {
        $this->service = $service;
        $this->sessionService = $sessionService;
        $this->courseService = $courseService;
        $this->studentCategoryService = $studentCategoryService;
        $this->country = $country;
        $this->educationBoardService = $educationBoardService;
        $this->attachmentService = $attachmentService;
        $this->studentService = $studentService;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = [
            'pageTitle' => 'Applicants List',
            'tableHeads' => ['Image', 'Name', 'Session', 'Course', 'Category', 'Merit Position', 'Admission Roll', 'Status', 'Action'],
            'dataUrl' => self::redirectUrl . '/get-data',
            'columns' => [
                ['data' => 'photo', 'name' => 'photo'],
                ['data' => 'full_name_en', 'name' => 'full_name_en'],
                ['data' => 'session_id', 'name' => 'session_id'],
                ['data' => 'course_id', 'name' => 'course_id'],
                ['data' => 'student_category_id', 'name' => 'student_category_id'],
                ['data' => 'merit_position', 'name' => 'merit_position'],
                ['data' => 'admission_roll_no', 'name' => 'admission_roll_no'],
                ['data' => 'status', 'name' => 'status'],
                ['data' => 'action', 'name' => 'action', 'orderable' => false]
            ],
            'sessions' => $this->sessionService->listByStatus(),
            'courses' => $this->courseService->lists(),
            'studentCategories' => $this->studentCategoryService->lists(),
            'admissionStatus' => UtilityServices::$admissionStatus,
        ];

        return view(self::moduleDirectory . 'index', $data);
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function getData(Request $request)
    {
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
            'studentCategories' => $this->studentCategoryService->lists(),
            'countries' => $this->country->lists(),
            'certifications' => UtilityServices::$certificates,
            'educationBoards' => $this->educationBoardService->listByStatus(),
            'attachmentTypes' => $this->attachmentService->getListOfAttachmentTypes(),

        ];

        return view(self::moduleDirectory . 'add', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if (isset($request->parent_exist)) {
            if ($request->student_category_id != 2) {
                $rules = [
                    'mobile' => 'required|regex:/^(?=.*[1-9])[0-9]{11}$/|unique:admission_students,mobile',
                    'father_phone' => 'required|regex:/^(?=.*[1-9])[0-9]{11}$/'
                ];
            } else {
                $rules = [
                    'mobile' => 'required|regex:/^\+\d{1,3}(?:[-.\s]?\(?\d{1,4}\)?)?[-.\s]?\d{1,6}[-.\s]?\d{1,10}$/|unique:admission_students,mobile',
                    'father_phone' => 'required|regex:/^\+\d{1,3}(?:[-.\s]?\(?\d{1,4}\)?)?[-.\s]?\d{1,6}[-.\s]?\d{1,10}$/'
                ];
            }
        } else {
            if ($request->student_category_id != 2) {
                $rules = [
                    'mobile' => 'required|regex:/^(?=.*[1-9])[0-9]{11}$/|unique:admission_students,mobile',
                    'father_phone' => 'required|regex:/^(?=.*[1-9])[0-9]{11}$/|unique:admission_parents,father_phone'
                ];
            } else {
                $rules = [
                    'mobile' => 'required|regex:/^\+\d{1,3}(?:[-.\s]?\(?\d{1,4}\)?)?[-.\s]?\d{1,6}[-.\s]?\d{1,10}$/|unique:admission_students,mobile',
                    'father_phone' => 'required|regex:/^\+\d{1,3}(?:[-.\s]?\(?\d{1,4}\)?)?[-.\s]?\d{1,6}[-.\s]?\d{1,10}$/|unique:admission_parents,father_phone'
                ];
            }
        }

        $messages = [
            'mobile.required' => 'The student mobile number is required.',
            'mobile.regex' => 'The student mobile number format is invalid.',
            'mobile.unique' => 'The student mobile number has already been taken.',
            'father_phone.required' => 'The father\'s phone number is required.',
            'father_phone.regex' => 'The father\'s phone number format is invalid.',
            'father_phone.unique' => 'The father\'s phone number has already been taken.'
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            $errorMessages = $validator->errors()->all();
            $request->session()->flash('error', implode(' ', $errorMessages));
            return redirect()
                ->back()
                ->withErrors($validator)
                ->withInput();
        }

        $admission = $this->service->addApplicant($request);

        if ($admission) {
            $request->session()->flash('success', setMessage('create', 'Applicant'));
        } elseif ($admission == null) {
            $request->session()->flash('success', setMessage('create', 'Applicant has created, you can not add multiple applicant with same mobile number'));
        } else {
            $request->session()->flash('error', setMessage('create.error', 'Applicant'));
        }
        return redirect()->route('admission.index');
    }

    /**
     * Display the specified resource.
     *
     * @param \App\admissionStudent $admission_students
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $data = [
            'pageTitle' => self::moduleName,
            'applicant' => $this->service->find($id),
            'educationLevel' => UtilityServices::$certificates
        ];

        return view(self::moduleDirectory . 'view', $data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\AdmissionStudent $admission_students
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data = [
            'pageTitle' => self::moduleName,
            'applicant' => $this->service->find($id),
            'sessions' => $this->sessionService->listByStatus(),
            'courses' => $this->courseService->lists(),
            'studentCategories' => $this->studentCategoryService->lists(),
            'countries' => $this->country->lists(),
            'certifications' => UtilityServices::$certificates,
            'educationBoards' => $this->educationBoardService->listByStatus(),
            'attachmentTypes' => $this->attachmentService->getListOfAttachmentTypes(),
            'admissionStatus' => UtilityServices::$admissionStatus,

        ];

        return view(self::moduleDirectory . 'edit', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\AdmissionStudent $admission_students
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $applicant = $this->service->find($id);
        $parentId = $applicant->admission_parent_id;

        $rules = [
            'mobile' => 'required|unique:admission_students,mobile,' . $id,
            'father_phone' => 'required|unique:admission_parents,father_phone,' . $parentId
        ];

        if ($request->student_category_id != 2) {
            $rules['mobile'] .= '|regex:/^(?=.*[1-9])[0-9]{11}$/';
            $rules['father_phone'] .= '|regex:/^(?=.*[1-9])[0-9]{11}$/';
        } else {
            $rules['mobile'] .= '|regex:/^\+\d{1,3}(?:[-.\s]?\(?\d{1,4}\)?)?[-.\s]?\d{1,6}[-.\s]?\d{1,10}$/';
            $rules['father_phone'] .= '|regex:/^\+\d{1,3}(?:[-.\s]?\(?\d{1,4}\)?)?[-.\s]?\d{1,6}[-.\s]?\d{1,10}$/';
        }

        $messages = [
            'mobile.required' => 'The student mobile number is required.',
            'mobile.regex' => 'The student mobile number format is invalid.',
            'mobile.unique' => 'The student mobile number has already been taken.',
            'father_phone.required' => 'The father\'s phone number is required.',
            'father_phone.regex' => 'The father\'s phone number format is invalid.',
            'father_phone.unique' => 'The father\'s phone number has already been taken.'
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            $errorMessages = $validator->errors()->all();
            $request->session()->flash('error', implode(' ', $errorMessages));
            return redirect()
                ->back()
                ->withErrors($validator)
                ->withInput();
        }

        $admission = $this->service->editApplicant($request, $id);

        if ($admission) {
            $request->session()->flash('success', setMessage('update', 'Applicant'));
        } else {
            $request->session()->flash('error', setMessage('update.error', 'Applicant'));
        }
        return redirect()->route('admission.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\AdmissionStudent $admission_students
     * @return JsonResponse
     */
    public function destroy($id)
    {

        try {
            // Begin a database transaction
            DB::beginTransaction();
            // Find the applicant
            $applicant = $this->service->find($id);

            // Check if the applicant exists
            if (!$applicant) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Applicant not found.'
                ], 404);
            }

            // Delete related records
            AdmissionAttachment::where('admission_student_id', $id)->delete();
            AdmissionEducationHistory::where('admission_student_id', $id)->delete();
            AdmissionEmergencyContact::where('admission_student_id', $id)->delete();

            // Delete the applicant
            $applicant->delete();

            // Commit the transaction
            DB::commit();

            // Return a success response
            return response()->json([
                'status' => 'success',
                'message' => 'Applicant deleted successfully.'
            ]);
        } catch (Exception $e) {
            // Rollback the transaction if something goes wrong
            DB::rollBack();

            // Return an error response
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to delete applicant. ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * @param Request $request
     * @return string
     */
    public function checkEmail(Request $request)
    {
        $check = $this->service->checkEmailIsUnique($request);

        if (empty($check)) {
            return 'true';
        } else {
            return 'false';
        }
    }

    public function checkRollIsUnique(Request $request)
    {
        $check = $this->service->checkRollIsUnique($request);

        if (empty($check)) {
            return 'true';
        } else {
            return 'false';
        }
    }

    public function checkMobile(Request $request)
    {
        $check = $this->service->checkMobileIsUnique($request);

        if (empty($check)) {
            return 'true';
        } else {
            return 'false';
        }
    }

    /**
     * @param Request $request
     * @param $id
     */
    public function transferToStudent($id)
    {
        $applicant = $this->service->find($id);
        $sessionDetail = ($applicant->course_id == 1) ? $applicant->session->mbbsSessionDetails->first() : $applicant->session->bdsSessionDetails->first();

        $data = [
            'pageTitle' => self::moduleName,
            'applicant' => $applicant,
            'educationLevel' => UtilityServices::$certificates,
            'studentID' => $this->studentService->generateStudentId($applicant->session_id, $applicant->course_id, $sessionDetail->batch_number, $sessionDetail->session),
            'batchNumber' => $sessionDetail->batch_number,
            'studentRoll' => $this->studentService->getTotalStudentsBySessionAndCourse($applicant->session_id, $applicant->course_id),
        ];

        return view(self::moduleDirectory . 'transfer_to_student', $data);
    }

    public function transferStudentData(TransferStudent $request, $id)
    {
        if ($request->student_category_id != 2) {
            $validator = Validator::make($request->all(), [
                'mobile' => 'required|regex:/^(?=.*[1-9])[0-9]{11}$/|unique:students,mobile',
            ]);
        } else {
            $validator = Validator::make($request->all(), [
                'mobile' => 'required|regex:/^\+\d{1,3}(?:[-.\s]?\(?\d{1,4}\)?)?[-.\s]?\d{1,6}[-.\s]?\d{1,10}$/|unique:students,mobile',
            ]);
        }

        if ($validator->fails()) {
            $request->session()->flash('error', 'Please filled the required field.');
            return redirect()
                ->back()
                ->withErrors($validator)
                ->withInput();
        }

        $student = $this->service->transferDataToStudent($request, $id);

        if ($student) {
            $request->session()->flash('success', 'Student data has been transferred successfully');
        } elseif ($student === null) {
            $request->session()->flash('error', 'Student already exist');
        } else {
            $request->session()->flash('error', 'Error in transferring student data');
        }
        return redirect()->route('admission.index');
    }

    //update single applicant status data
    public function updateSingleApplicantStatus(Request $request, $applicantId)
    {
        if (!empty($request->status)) {
            $applicantStatus = $this->service->updateApplicantStatus($request, $applicantId);
            return response()->json(['status' => true, 'data' => $applicantStatus]);
        }
    }

    public function applicantsImport(Request $request)
    {
        // Validate request data
        $validator = Validator::make($request->all(), [
            'session_id' => 'required|exists:sessions,id',
            'course_id' => 'required|exists:courses,id',
            'applicants_file' => 'required|file|mimes:xlsx,xls|max:1024'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => $validator->errors()->first()
            ], 422);
        }

        try {
            $data = $this->service->importApplicants($request);

            if (!$data || !isset($data->info)) {
                $request->session()->flash('error', 'Invalid response from import service');
                return redirect()->route('admission.index');
            }

            $status = $data->info['status'] ?? true;
            $message = $data->info['message'] ?? 'Applicants imported successfully';
            $flashType = $status === false ? 'error' : 'success';
            $request->session()->flash($flashType, nl2br($message));
        } catch (ValidationException $e) {
            Log::error('Validation error while importing applicants', [
                'errors' => $e->failures(),
                'exception' => $e
            ]);
            $request->session()->flash('error', 'Invalid data in import file. Please check your file and try again.');
        } catch (Exception $e) {
            Log::error('Error importing applicants: ' . $e->getMessage(), ['exception' => $e]);
            $request->session()->flash('error', 'Something went wrong while importing applicants.');
        }
        return redirect()->route('admission.index');
    }
}
