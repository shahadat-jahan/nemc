<?php

namespace App\Http\Controllers\FrontEnd;

use App\AdminUser;
use App\Http\Controllers\Controller;
use App\Models\Guardian;
use App\Services\Admin\Admission\ClassRoutineService;
use App\Services\Admin\AttendanceService;
use App\Services\Admin\CardService;
use App\Services\Admin\DashboardService;
use App\Services\Admin\ExamService;
use App\Services\Admin\GuardianService;
use App\Services\Admin\HolidayService;
use App\Services\Admin\NoticeBoardService;
use App\Services\Admin\StudentService;
use App\Services\Admin\SubjectService;
use App\Services\Admin\UserService;
use App\Services\ResultService;
use App\Services\StudentFeeService;
use App\Services\UtilityServices;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{

    protected $guardianService;
    protected $studentService;
    protected $studentFeeService;
    protected $subjectService;
    protected $classRoutineService;
    protected $attendanceService;
    protected $cardService;
    protected $resultService;
    protected $examService;
    protected $noticeBoardService;
    protected $holidayService;

    public function __construct(
        GuardianService $guardianService, StudentService $studentService, StudentFeeService $studentFeeService,
        SubjectService $subjectService, ClassRoutineService $classRoutineService, AttendanceService $attendanceService,
        CardService $cardService, ResultService $resultService, ExamService $examService, NoticeBoardService $noticeBoardService, HolidayService $holidayService
    ){
        $this->guardianService = $guardianService;
        $this->studentService = $studentService;
        $this->studentFeeService = $studentFeeService;
        $this->subjectService = $subjectService;
        $this->classRoutineService = $classRoutineService;
        $this->attendanceService = $attendanceService;
        $this->cardService = $cardService;
        $this->resultService = $resultService;
        $this->examService = $examService;
        $this->noticeBoardService = $noticeBoardService;
        $this->holidayService = $holidayService;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        if(Auth::guard('student_parent')->check()){
            $user = Auth::guard('student_parent')->user();
        }
        if ($user->user_group_id == 6){
            // parent dashboard
            $parentId = $this->guardianService->getParentId($user->id);
            $studentId = getStudentsIdByParentId($parentId);
            $data['students'] = $this->studentService->getStudentsByStudentId($studentId);
            //get last 5 notice
            $data['latestNotices'] = $this->noticeBoardService->getLastFiveNotice($user->parent->students->first()->followed_by_session_id);
            $data['nextOneWeekHolidays'] = $this->holidayService->getOneWeekHolidays();

            return view('frontend.dashboard.parent', $data);
        }
        // student dashboard
        $data['student'] = $user->student->where('user_id', $user->id)->first();
        //get last 5 notice
        $data['latestNotices'] = $this->noticeBoardService->getLastFiveNotice($user->student->followed_by_session_id);
        $data['nextOneWeekHolidays'] = $this->holidayService->getOneWeekHolidays();

        return view('frontend.dashboard.student_dashboard', $data);
    }

    public function getStudentCardBlocksData(Request $request){
        $studentInfo = $this->studentService->find($request->studentId);
        //dd($studentInfo);
        $sessionInfo = $studentInfo->session->sessionDetails->where('course_id', $studentInfo->course_id)->first();
        //total payable amount
        $payableAmount = $this->studentFeeService->getTotalPayableAmountForStudent($request->studentId);
        //total paid amount
        $paidAmount = $this->studentFeeService->getTotalPaidAmountByStudentId($request->studentId);
        //total discount
        $discountAmount =$this->studentFeeService->getTotalDiscountForStudent($request->studentId);
        //due amount
        $dueAmount = ($payableAmount-$paidAmount)-$discountAmount;

        $cardBlocks = [
            ['title' => 'Batch', 'course' => $studentInfo->course->title, 'value' => getOrdinal($sessionInfo->batch_number), 'className' => 'm--bg-brand'],
            ['title' => 'Session', 'course' => $studentInfo->course->title, 'value' => $studentInfo->session->title, 'className' => 'm--bg-accent'],
//            ['title' => 'Paid', 'course' => ($studentInfo->student_category_id == 2 ? '$' : 'TK'), 'value' => number_format($paidAmount, 2), 'className' => 'm--bg-success'],
           // ['title' => 'Due', 'course' => ($studentInfo->student_category_id == 2 ? '$' : 'TK'), 'value' => number_format($dueAmount, 2), 'className' => 'm--bg-info'],
        ];

        return response()->json([
            'status' => true, 'cardBlocks' => $cardBlocks
        ]);
    }

    /*public function getSubjectWiseStudentAttendanceSummary(Request $request){
        $studentInfo = $this->studentService->find($request->studentId);
        $subjects = $this->subjectService->getSubjectsByCourseIdPhaseId($studentInfo->course_id, $studentInfo->phase_id);
        foreach ($subjects as $subject){
            $subjectHasClass = $this->classRoutineService->routineExistForSubject($studentInfo->followed_by_session_id,  $studentInfo->courseid, $studentInfo->phase_id, $subject->id);
            $subject->studentId = $request->studentId;
            if ($subjectHasClass){
                $attendClass = $this->attendanceService->getTotalAttendanceBySubject($subject->id, $studentInfo->id, $studentInfo->course_id, $studentInfo->phase_id);
                $attendPercent = floor(($attendClass * 100) / $subjectHasClass);
                $absentPercent = 100 - $attendPercent;
                $subject->chardData = collect([
                    ['name' => 'Present', 'y' => $attendPercent, 'color' => UtilityServices::$chartColors['green'], 'count' => $attendPercent],
                    ['name' => 'Absent', 'y' => $absentPercent, 'color' => UtilityServices::$chartColors['red'], 'count' => $absentPercent]
                ]);
            } else{
                $subject->chardData = collect([
                    ['name' => 'Present', 'y' => 0, 'color' => UtilityServices::$chartColors['green'], 'count' => 0],
                    ['name' => 'Absent', 'y' => 0, 'color' => UtilityServices::$chartColors['red'], 'count' => 0]
                ]);
            }
        }
        return response()->json([
            'status' => true, 'subjects' => $subjects
        ]);
    }*/
    public function getSubjectWiseStudentAttendanceSummary(Request $request){
        $studentInfo = $this->studentService->find($request->studentId);
        //$subjects = $this->subjectService->getSubjectsByCourseIdPhaseId($studentInfo->course_id, $studentInfo->phase_id);
        $allClasses = $this->classRoutineService->getAllClassBySessionIdCourseIdPhaseId($studentInfo->followed_by_session_id, $studentInfo->course_id, $studentInfo->phase_id, $studentInfo->batch_type_id);
        foreach ($allClasses as $singleClass){
            /*$hasClass = $this->attendanceService->checkAttendanceByClassInfo($request->studentId, $singleClass->session_id, $singleClass->course_id,
                $singleClass->phase_id, $singleClass->batch_type_id, $singleClass->subject_id, $singleClass->class_type_id);*/
            $hasClass = $this->attendanceService->checkAttendanceByClassInfo($request->studentId, $singleClass->id);
            $singleClass->studentId = $request->studentId;
            if ($hasClass){
                //total present
                $totalAttend = $this->attendanceService->getTotalClassPresentAbsentByStudentInfoAndClassInfo($request->studentId, $singleClass->session_id, $singleClass->course_id,
                    $singleClass->phase_id, $singleClass->batch_type_id, $singleClass->subject_id, $singleClass->class_type_id, $attendance = 1);
                //total present
                $totalAbsent = $this->attendanceService->getTotalClassPresentAbsentByStudentInfoAndClassInfo($request->studentId, $singleClass->session_id, $singleClass->course_id,
                    $singleClass->phase_id, $singleClass->batch_type_id, $singleClass->subject_id, $singleClass->class_type_id, $attendance = 0);
                $totalClass = $totalAttend + $totalAbsent;
                $attendPercent = floor(($totalAttend * 100) / $totalClass);
                $absentPercent = 100 - $attendPercent;
                $singleClass->chardData = collect([
                    ['name' => 'Present', 'y' => $attendPercent, 'color' => UtilityServices::$chartColors['green'], 'count' => $totalAttend],
                    ['name' => 'Absent', 'y' => $absentPercent, 'color' => UtilityServices::$chartColors['red'], 'count' => $totalAbsent]
                ]);
            } else{
                $singleClass->chardData = collect([
                    ['name' => 'Present', 'y' => 0, 'color' => UtilityServices::$chartColors['green'], 'count' => 0],
                    ['name' => 'Absent', 'y' => 0, 'color' => UtilityServices::$chartColors['red'], 'count' => 0]
                ]);
            }
        }
        return response()->json([
            'status' => true, 'allClasses' => $allClasses
        ]);
    }


    // student last 1 week class attendance
    public function studentLastWeekClassAttendance(Request $request){
        $studentInfo = $this->studentService->find($request->student_id);
        $classRoutine = $this->classRoutineService->getLastWeekTakenClassesBySessionCoursePhaseAndDateRange($studentInfo->id, $studentInfo->followed_by_session_id, $studentInfo->course_id, $studentInfo->phase_id, today());
        return $classRoutine;
    }

    //today's class routine
    public function studentTodayClassRoutine(Request $request){
        $studentInfo = $this->studentService->find($request->student_id);
        $classRoutine = $this->classRoutineService->getTodayClassesBySessionCoursePhaseAndDate($studentInfo->followed_by_session_id, $studentInfo->course_id, $studentInfo->phase_id, today());
        return $classRoutine;
    }
    //student card item exam by subject
    public function studentCardItemsResult(Request $request){
        $studentInfo = $this->studentService->find($request->studentId);
        /*$subjects = $this->subjectService->getSubjectsWithCardByCoursePhaseId($studentInfo->course_id, $studentInfo->phase_id);*/
        $subjects = $this->subjectService->getSubjectsByCourseIdPhaseIdWithCards($studentInfo->course_id, $studentInfo->phase_id);
            foreach ($subjects as $subject) {
                $cardItems = $this->cardService->getCardsItemsAndStudentResultBySubjectPhaseAndCourseId($subject->id, $studentInfo->phase_id, $studentInfo->course_id, $studentInfo->followed_by_session_id);
                $cardData = [];
                foreach($cardItems as $key => $card){
                    $itemData = [];
                    foreach ($card->cardItems as $iKey => $item){
                        $itemData[$iKey]['title'] = $item->title;
                        $checkResult = $this->resultService->getStudentItemResultByStudentIdAndItemId($request->studentId, $item->id);
                        $itemData[$iKey]['passStatus'] = false;
                        if (!empty($checkResult) && in_array($checkResult->pass_status, [1, 3])) {
                            $itemData[$iKey]['passStatus'] = true;
                        }
                    }
                    $cardData[$key]['studentId'] = $request->studentId;
                    $cardData[$key]['title'] = $card->title;
                    $cardData[$key]['id'] = $card->id;
                    $cardData[$key]['items'] = $itemData;
                }
                $subject->cardItems = $cardData;
            }

        return response()->json([
            'status' => true, 'subjects' => $subjects
        ]);
    }
    //student upcoming 1 month exam
    public function studentUpcomingExams(Request $request){
        $studentInfo = $this->studentService->find($request->student_id);
        return $this->examService->getUpcomingExamsByCourseIdPhaseInAndMonths($studentInfo->course_id, $studentInfo->phase_id, 1);
    }
}
