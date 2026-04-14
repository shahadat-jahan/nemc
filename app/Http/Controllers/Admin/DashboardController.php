<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CardItem;
use App\Services\Admin\Admission\ClassRoutineService;
use App\Services\Admin\AttendanceService;
use App\Services\Admin\CardService;
use App\Services\Admin\CourseService;
use App\Services\Admin\ExamService;
use App\Services\Admin\HolidayService;
use App\Services\Admin\NoticeBoardService;
use App\Services\Admin\PaymentTypeService;
use App\Services\Admin\PhaseService;
use App\Services\Admin\SessionService;
use App\Services\Admin\StudentService;
use App\Services\Admin\SubjectService;
use App\Services\Admin\TeacherService;
use App\Services\StudentFeeService;
use App\Services\UtilityServices;
use Carbon\Carbon;
use Google\Auth\Cache\Item;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{

    const moduleDirectory = 'dashboard.';

    protected $studentService;
    protected $courseService;
    protected $teacherService;
    protected $subjectService;
    protected $sessionService;
    protected $phaseService;
    protected $classRoutineService;
    protected $attendanceService;
    protected $cardService;
    protected $examService;
    protected $studentFeeService;
    protected $noticeBoardService;
    protected $holidayService;
    protected $paymentTypeService;


    public function __construct(
        StudentService $studentService, CourseService $courseService, TeacherService $teacherService, SubjectService $subjectService,
        SessionService $sessionService, PhaseService $phaseService, ClassRoutineService $classRoutineService, AttendanceService $attendanceService,
        CardService $cardService, ExamService $examService, StudentFeeService $studentFeeService, NoticeBoardService $noticeBoardService,
        HolidayService $holidayService, PaymentTypeService $paymentTypeService
    ){
        $this->studentService = $studentService;
        $this->courseService = $courseService;
        $this->teacherService = $teacherService;
        $this->subjectService = $subjectService;
        $this->sessionService = $sessionService;
        $this->phaseService = $phaseService;
        $this->classRoutineService = $classRoutineService;
        $this->attendanceService = $attendanceService;
        $this->cardService = $cardService;
        $this->examService = $examService;
        $this->studentFeeService = $studentFeeService;
        $this->noticeBoardService = $noticeBoardService;
        $this->holidayService = $holidayService;
        $this->paymentTypeService = $paymentTypeService;
    }

    /**
     * @return array|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request) {

        $groupId = Auth::user()->user_group_id;
        $authUser = Auth::user();
        //general teacher and teacher with extra(given by department head) role
        if ($authUser->teacher) {
            $teacherInfo = Auth::guard('web')->user()->teacher;
            $courseId = $request->has('course_id') ? $request->course_id : $teacherInfo->course_id;

            if ($authUser->user_group_id == 12){
                //department head
                $common = [
                    'sessions' => $this->sessionService->listByStatus(),
                    'courses' => $this->courseService->listByStatus(),
                    'phases' => $this->phaseService->listBySubjectId(getSubjectsIdByDepartmentIdAndCourseId($teacherInfo->department_id, $courseId))
                ];
                $phaseIds = array_keys($common['phases']->toArray());
                $mergeAllData = [
                    $common,
                    $this->_getTeacherDashboardData($request, $phaseIds),
                ];

                $data = array_reduce($mergeAllData, 'array_merge', []);
                return view(self::moduleDirectory.'teacher_dashboard', $data);
            }

            //teacher
            $common       = [
                'sessions' => $this->sessionService->listByStatus(),
                'courses' => $this->courseService->listByStatus(),
                'phases'  => $this->phaseService->listBySubjectId(getSubjectsIdByTeacherId($teacherInfo->id, $courseId))
            ];
            $phaseIds     = array_keys($common['phases']->toArray());
            $mergeAllData = [
                $common,
                $this->_getTeacherDashboardData($request, $phaseIds),
            ];
            $data         = array_reduce($mergeAllData, 'array_merge', []);

            return view(self::moduleDirectory.'teacher_dashboard', $data);
        }

        if ($groupId == 7 || $groupId == 14 || $groupId == 15 || $groupId == 16) {

            // staff accounts
            $common = [
                'sessions' => $this->sessionService->listByStatus(),
                'courses' => $this->courseService->listByStatus(),
                'phases' => $this->phaseService->listByStatus()
            ];

            $mergeAllData = [
                $common,
                $this->_getStaffAccountsDashboardData($request),
            ];

            $data = array_reduce($mergeAllData, 'array_merge', []);

            return view(self::moduleDirectory.'stuff_account_dashboard', $data);
        }

        if ($groupId == 3) {

            // staff office
            $common = [
                'sessions' => $this->sessionService->listByStatus(),
                'courses' => $this->courseService->listByStatus(),
                'phases' => $this->phaseService->listByStatus()
            ];

            $mergeAllData = [
                $common,
                $this->_getStaffOfficeDashboardData($request),
            ];

            $data = array_reduce($mergeAllData, 'array_merge', []);

            return view(self::moduleDirectory.'stuff_office_dashboard', $data);
        }

        if ($groupId == 1 || $groupId == 2) {

            //admin, super admin
            $common = [
                'sessions' => $this->sessionService->listByStatus(),
                'courses' => $this->courseService->listByStatus(),
                'phases' => $this->phaseService->listByStatus()
            ];
            $phaseIds = array_keys($common['phases']->toArray());
            $mergeAllData = [
                $common,
                $this->_getAdminDashboardData($request, $phaseIds),
            ];
            $data = array_reduce($mergeAllData, 'array_merge', []);

            return view(self::moduleDirectory.'admin_dashboard', $data);
        }

        //other user
        $common = [
            'sessions' => $this->sessionService->listByStatus(),
            'courses'  => $this->courseService->listByStatus(),
            'phases'   => $this->phaseService->listByStatus()
        ];

        $mergeAllData = [
            $common,
            $this->_getOthersDashboardData($request),
        ];

        $data = array_reduce($mergeAllData, 'array_merge', []);

        return view(self::moduleDirectory . 'others_dashboard', $data);
    }

    /**
     * @param $request
     * @return mixed
     */
    private function _getAdminDashboardData($request, $phaseIds)
    {
        /*$currentYear = Carbon::now()->year;
        $currentSessionId = $this->sessionService->getCurrentSessionIdByCurrentYear($currentYear);*/
        $courseId = $request->input('course_id', Auth::guard('web')->user()->adminUser->course_id ?? 1);
        $currentSessionId = $data['currentSessionId'] = $this->sessionService->getCurrentSessionIdByCurrentYear(Carbon::now()->year);
        $sessionId = $request->has('session_id') ? $request->session_id : $currentSessionId;

        $data['batchNumber'] = $this->sessionService->getBatchBySessionIdAndCourseId($sessionId, $courseId);
        $data['totalStudents'] = $this->studentService->getTotalStudentsBySessionIdAndCourseId($sessionId, $courseId, $phaseIds);
        $data['totalTeachers'] = $this->teacherService->getTotalTeachersByCourseId($courseId);
        $data['totalSubjects'] = $this->subjectService->getTotalSubjectsByCourseId($courseId);

        //fees title
        $paymentType = $this->paymentTypeService->listByStatus()->toArray();
        ksort($paymentType); // Sorts by key (ID)
        $data['feeNames'] = array_values($paymentType);


        //fees of bangladesh
        $data['mbbsFeeAmounts'] = $this->studentFeeService->getAllFeeAmountSumBySessionAndCourseId($sessionId, 1, 'normal');
        $data['bdsFeeAmounts'] = $this->studentFeeService->getAllFeeAmountSumBySessionAndCourseId($sessionId, 2, 'normal');
        //fees of foreign
        $data['foreignMbbsFeeAmounts'] = $this->studentFeeService->getAllFeeAmountSumBySessionAndCourseId($sessionId, 1, 'foreign');
        $data['foreignBdsFeeAmounts'] = $this->studentFeeService->getAllFeeAmountSumBySessionAndCourseId($sessionId, 2, 'foreign');
        //get last 5 notice
        $data['latestNotices'] = $this->noticeBoardService->getLastFiveNotice($sessionId);
        $data['nextOneWeekHolidays'] = $this->holidayService->getOneWeekHolidays();

        return $data;
    }

    /**
     * @param $request
     * @return mixed
     */
    private function _getTeacherDashboardData($request, $phaseIds)
    {
        $teacherInfo = Auth::guard('web')->user()->teacher;
        $courseId = $request->has('course_id') ? $request->course_id : $teacherInfo->course_id;
        $currentSessionId = $data['currentSessionId'] = $this->sessionService->getCurrentSessionIdByCurrentYear(Carbon::now()->year);
        $sessionId = $request->has('session_id') ? $request->session_id : $currentSessionId;

        $data['totalStudents'] = $this->studentService->getTotalStudentsByCourseIdPhaseIds($courseId, $phaseIds);
        $data['totalClasses'] = $this->classRoutineService->getTotalClassByTeacherIdAndCourseId($teacherInfo->id, $courseId);
        $data['totalCards'] = $this->cardService->getTotalCardsByCourseIdAndDepartmentId($courseId, $teacherInfo->department_id);
        $data['totalItems'] = $this->cardService->getTotalItemsByCourseIdAndDepartmentId($courseId, $teacherInfo->department_id);
        $data['department'] = $teacherInfo->department->title;
        //get last 5 notice
        $data['latestNotices'] = $this->noticeBoardService->getLastFiveNotice($sessionId);
        $data['nextOneWeekHolidays'] = $this->holidayService->getOneWeekHolidays();
        $data['monthlyClasses'] =  $this->classRoutineService->getDailyClassNumberForCurrentMonth($teacherInfo->id, $courseId);

        return $data;
    }

    public function _getStaffAccountsDashboardData($request){
        $staffAccountsInfo = Auth::guard('web')->user()->adminUser;
        $userGroupId = Auth::guard('web')->user()->user_group_id;
        $currentSessionId = $data['currentSessionId'] = $this->sessionService->getCurrentSessionIdByCurrentYear(Carbon::now()->year);
        $sessionId = $request->has('session_id') ? $request->session_id : $currentSessionId;
        //$courseIds = array();
        if ($request->filled('course_id')){
            $courseIds = $request->course_id;
        }elseif ($userGroupId == 14){
            //User group-Accounts Admin - BDS
            $courseIds = 2;
        }elseif ($userGroupId == 15){
            //User group-Accounts Admin - MBBS
            $courseIds = 1;
        } elseif ($userGroupId == 16){
            //User group-Accounts Admin (MBBS+BDS)
            $courseIds = [1, 2];
        } elseif (isset($staffAccountsInfo->course_id)){
            $courseIds = $staffAccountsInfo->course_id;
        } else{
            $courseIds = $this->courseService->getAllCourseId();
        }

        $data['totalDevelopmentFeeOfBdStudent'] = $this->studentFeeService->getTotalDevelopmentFeeOfBdBySessionIdAndCourseIds($sessionId,  $courseIds);
        $data['totalDevelopmentFeeOfForeignStudent'] = $this->studentFeeService->getTotalDevelopmentFeeOfForeignBySessionIdAndCourseIds($sessionId,  $courseIds);
        $data['totalTuitionOfBdStudent'] = $this->studentFeeService->getTotalTuitionFeeOfBdBySessionIdAndCourseIds($sessionId,  $courseIds);
        $data['totalTuitionOfForeignStudent'] = $this->studentFeeService->getTotalTuitionFeeOfForeignBySessionIdAndCourseIds($sessionId,  $courseIds);
        $data['totalReadmissionOfBdStudent'] = $this->studentFeeService->getTotalReadmissionFeeOfBdBySessionIdAndCourseIds($sessionId,  $courseIds);
        $data['totalReadmissionOfForeignStudent'] = $this->studentFeeService->getTotalReadmissionFeeOfForeignBySessionIdAndCourseIds($sessionId,  $courseIds);
        $data['totalAbsentOfBdStudent'] = $this->studentFeeService->getTotalAbsentFeeOfBdBySessionIdAndCourseIds($sessionId,  $courseIds);
        $data['totalAbsentOfForeignStudent'] = $this->studentFeeService->getTotalAbsentFeeOfForeignBySessionIdAndCourseIds($sessionId,  $courseIds);
        //get last 5 notice
        $data['latestNotices'] = $this->noticeBoardService->getLastFiveNotice($sessionId);
        $data['nextOneWeekHolidays'] = $this->holidayService->getOneWeekHolidays();
        return $data;

    }

    public function _getStaffOfficeDashboardData($request){
        $staffAccountsInfo = Auth::guard('web')->user()->adminUser;
        $currentSessionId = $data['currentSessionId']= $this->sessionService->getCurrentSessionIdByCurrentYear(Carbon::now()->year);
        $sessionId = $request->has('session_id') ? $request->session_id : $currentSessionId;
        //$courseIds = array();
        if ($request->filled('course_id')){
            $courseIds = $request->course_id;
        } elseif (isset($staffAccountsInfo->course_id)){
            $courseIds = $staffAccountsInfo->course_id;
        } else{
            $courseIds = $this->courseService->getAllCourseId();
        }
        $data['totalBatches'] = $this->sessionService->getTotalStudentBatchesBySessionIdAndCourseIds($sessionId, $courseIds);
        $data['totalStudents'] = $this->studentService->getTotalStudentsBySessionIdAndCourseIds($sessionId, $courseIds);
        $data['totalTeachers'] = $this->teacherService->getTotalTeachersByCourseId($courseIds);
        $data['totalSubjects'] = $this->subjectService->getTotalSubjectsByCourseId($courseIds);
        //get last 5 notice
        $data['latestNotices'] = $this->noticeBoardService->getLastFiveNotice($sessionId);
        $data['nextOneWeekHolidays'] = $this->holidayService->getOneWeekHolidays();

        return $data;
    }

    public function _getOthersDashboardData($request)
    {
        $userInfo         = Auth::guard('web')->user()->adminUser;
        $currentSessionId = $data['currentSessionId'] = $this->sessionService->getCurrentSessionIdByCurrentYear(Carbon::now()->year);
        $sessionId        = $request->has('session_id') ? $request->session_id : $currentSessionId;
        //$courseIds = array();
        if ($request->filled('course_id')) {
            $courseIds = $request->course_id;
        } elseif (isset($userInfo->course_id)) {
            $courseIds = $userInfo->course_id;
        } else {
            $courseIds = $this->courseService->getAllCourseId();
        }
        $data['totalBatches']  = $this->sessionService->getTotalStudentBatchesBySessionIdAndCourseIds($sessionId, $courseIds);
        $data['totalStudents'] = $this->studentService->getTotalStudentsBySessionIdAndCourseIds($sessionId, $courseIds);
        $data['totalTeachers'] = $this->teacherService->getTotalTeachersByCourseId($courseIds);
        $data['totalSubjects'] = $this->subjectService->getTotalSubjectsByCourseId($courseIds);
        //get last 5 notice
        $data['latestNotices']       = $this->noticeBoardService->getLastFiveNotice($sessionId);
        $data['nextOneWeekHolidays'] = $this->holidayService->getOneWeekHolidays();

        return $data;
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */

    public function todayAttendance(Request $request){
        $currentSessionId = $request->session_id ?? $this->sessionService->getCurrentSessionIdByCurrentYear(Carbon::now()->year);
        $todaysClasses = $this->classRoutineService->getAllClassTodayByCourseIdPhaseIdTeacherIdAndDate($currentSessionId, $request->course_id, $request->phase_id, now());

        foreach ($todaysClasses as $key => $todaysClass){
            $hasClass = $this->attendanceService->checkAttendanceByClassRoutineId($todaysClass->id);
            if ($hasClass){
                //total present today
                $totalAttend = $this->attendanceService->getTotalPresentByClassRoutineId($todaysClass->id);
                //total absent today
                $totalAbsent = $this->attendanceService->getTotalAbsentByClassRoutineId($todaysClass->id);
                $totalStudents = $totalAttend + $totalAbsent;

                $attendPercent = floor(($totalAttend * 100) / $totalStudents);
                $absentPercent = 100 - $attendPercent;
                $todaysClass->chardData = collect([
                    ['name' => 'Present', 'y' => $attendPercent, 'color' => UtilityServices::$chartColors['green'], 'count' => $totalAttend],
                    ['name' => 'Absent', 'y' => $absentPercent, 'color' => UtilityServices::$chartColors['red'], 'count' => ($totalStudents - $totalAttend)]
                ]);

            }else{
                $todaysClass->chardData = collect([
                    ['name' => 'No Attendance', 'y' => 100, 'color' => UtilityServices::$chartColors['gray'], 'count' => 0 ]
                ]);
            }

            $todaysClass->phaseId = $request->phase_id;
        }



        return response()->json([
            'status' => true, 'todaysClasses' => $todaysClasses
        ]);
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function todayClassRoutine(Request $request){
        $currentSessionId = $this->sessionService->getCurrentSessionIdByCurrentYear(Carbon::now()->year);
        $sessionId = $request->has('session_id') ? $request->session_id : $currentSessionId;
        return $this->classRoutineService->getClassesByCoursePhaseAndDate($sessionId, $request->course_id, $request->phase_id, today());
    }

    public function lastWeekClassRoutine(Request $request){
        return $this->classRoutineService->getClassesByCoursePhaseAndWeek($request->session_id,$request->course_id, $request->phase_id, today());
    }

    public function cardItemsResult(Request $request){

        $currentSessionId = $this->sessionService->getCurrentSessionIdByCurrentYear(Carbon::now()->year);
        $sessionId = $request->has('session_id') ? $request->session_id : $currentSessionId;

        $authUser = Auth::guard('web')->user();
        // for teacher
        if ($authUser->teacher){
            // department head
            if ($authUser->user_group_id == 12){
                $teacherInfo = $authUser->teacher;
                $subjectIds = getSubjectsIdByDepartmentIdAndCourseId($teacherInfo->department_id, $request->course_id);
                $subjects = $this->subjectService->getSubjectsBySubjectIds($subjectIds);
            }else{
                //general teachers
                $teacherInfo = $authUser->teacher;
                $subjectIds = getSubjectsIdByTeacherId($teacherInfo->id, $request->course_id);
                $subjects = $this->subjectService->getSubjectsBySubjectIds($subjectIds);
            }
        }else{
            //admin
            $subjects = $this->subjectService->getSubjectsByCourseIdPhaseId($request->course_id, $request->phase_id);
        }

        foreach ($subjects as $subject){
            $cardItems = $this->cardService->getCardsItemsAndStudentResultBySubjectPhaseAndCourseId($subject->id, $request->phase_id, $request->course_id, $sessionId);
            $cardData = [];
            foreach($cardItems as $key => $card){
                $itemNames = [];
                $itemCompleted = [];
                $itemNotCompleted = [];
                foreach ($card->cardItems as $iKey => $item){
                    $totalPass = 0;
                    $totalFail = 0;

                    // Collect all results in a single collection to avoid nested loops
                    $allResults = collect();

                    if (!empty($item->examSubjects) && $item->examSubjects->isNotEmpty()) {
                        foreach ($item->examSubjects as $examSubject) {
                            if (!empty($examSubject->exam)) {
                                $exam = $examSubject->exam;
                                if (!empty($exam->examMarks) && $exam->examMarks->isNotEmpty()) {
                                    foreach ($exam->examMarks as $examMark) {
                                        if (!empty($examMark->result) && $examMark->result->isNotEmpty()) {
                                            $allResults = $allResults->concat($examMark->result);
                                        }
                                    }
                                }
                            }
                        }
                    }

                    // Count pass/fail results in a single operation
                    if ($allResults->isNotEmpty()) {
                        $totalPass = $allResults->whereIn('pass_status', [1, 3])->count();
                        $totalFail = $allResults->whereNotIn('pass_status', [1, 3])->count();
                    }

                    $itemNames[$iKey] = $item->title;
                    $itemCompleted[$iKey] = $totalPass;
                    $itemNotCompleted[$iKey] = $totalFail;
                }

                $cardData[$key]['id'] =  $card->id;
                $cardData[$key]['title'] =  $card->title;
                $cardData[$key]['phaseId'] =  $request->phase_id;
                $cardData[$key]['subjectId'] =  $subject->id;
                $cardData[$key]['cardItems'] =  $itemNames;
                $cardData[$key]['seriesData'] =  [
                    ['name' => 'Cleared', 'data' => $itemCompleted, 'color' => UtilityServices::$chartColors['green']],
                    ['name' => 'Not Cleared', 'data' => $itemNotCompleted, 'color' => UtilityServices::$chartColors['red'], 'count' => 0],
                ];
            }

            $subject->cardItems = $cardData;
        }

        return response()->json([
            'status' => true, 'subjects' => $subjects
        ]);
    }

    public function upcomingExams(Request $request){
        return $this->examService->getUpcomingExamsByCourseIdPhaseInAndMonths($request->course_id, $request->phase_id, 1, $request->session_id);
    }

    public function monthlyAttendance(Request $request){
        $authUser = Auth::guard('web')->user();
        //for teacher
        if ($authUser->teacher){
            //department head
            if ($authUser->user_group_id == 12){
                $teacherInfo = Auth::guard('web')->user()->teacher;
                $subjectIds = getSubjectsIdByDepartmentIdAndCourseId($teacherInfo->department_id, $request->course_id);
                $subjects = $this->subjectService->getSubjectsBySubjectIds($subjectIds);
            }else{
                //other teachers
                $teacherInfo = Auth::guard('web')->user()->teacher;
                $subjectIds = getSubjectsIdByTeacherId($teacherInfo->id, $request->course_id);
                $subjects = $this->subjectService->getSubjectsBySubjectIds($subjectIds);
            }
        }else{
            //admin
            $subjects = $this->subjectService->getSubjectsByCourseIdPhaseId($request->course_id, $request->phase_id);
        }


        $dateStart = Carbon::now()->firstOfMonth()->toDateString();
        $dateEnd = Carbon::now()->lastOfMonth()->toDateString();

        foreach ($subjects as $subject){
            $subject->phaseId = $request->phase_id;
            $classRoutine = $this->classRoutineService->getClassesBySubjectIdAndDateRange($subject->id, $request->phase_id, $dateStart, $dateEnd);

            if(!empty($classRoutine)){
                $classDates = [];
                $classPresent = [];
                $classAbsent = [];
                foreach ($classRoutine as $key => $routine){
                    $classDates[$key] = $routine->class_date;
                    $classPresent[$key] = $routine->present;
                    $classAbsent[$key] = $routine->absent;
                }

                $subject->classDates = $classDates;
                $subject->seriesData = [
                    ['name' => 'Present', 'data' => $classPresent, 'color' => UtilityServices::$chartColors['green']],
                    ['name' => 'Absent', 'data' => $classAbsent, 'color' => UtilityServices::$chartColors['red']],
                ];
            }else{
                $subject->classDates = [$dateStart];
                $subject->seriesData = [
                    ['name' => 'Present', 'data' => [0], 'color' => UtilityServices::$chartColors['green']],
                    ['name' => 'Absent', 'data' => [0], 'color' => UtilityServices::$chartColors['red']],
                ];
            }
        }

        return response()->json([
            'status' => true, 'subjects' => $subjects
        ]);
    }
}
