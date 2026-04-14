<?php

namespace App\Http\Controllers\FrontEnd;

use App\Events\NotifyUserOnHolidayAnnounced;
use App\Http\Requests\HolidayRequest;
use App\Http\Controllers\Controller;
use App\Services\Admin\Admission\ClassRoutineService;
use App\Services\Admin\BatchTypeService;
use App\Services\Admin\BookService;
use App\Services\Admin\CourseService;
use App\Services\Admin\ExamService;
use App\Services\Admin\HolidayService;
use App\Services\Admin\PhaseService;
use App\Services\Admin\SessionService;
use App\Services\Admin\SubjectGroupService;
use App\Services\Admin\SubjectService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use PDF;
class AcademicCalendarController extends Controller
{
    protected $redirectUrl;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    protected $holidayService;
    protected $sessionService;
    protected $courseService;
    protected $phaseService;
    protected $examService;
    protected $classRoutineService;
    protected $subjectService;
    protected $bookService;
    protected $subjectGroupService;

    public function __construct(HolidayService $holidayService, SessionService $sessionService,
        CourseService $courseService, PhaseService $phaseService, ExamService $examService, ClassRoutineService $classRoutineService, SubjectGroupService $subjectGroupService,
        SubjectService $subjectService, BookService $bookService
    ) {
        $this->redirectUrl = 'admin/academic_calendar';
        $this->holidayService = $holidayService;
        $this->sessionService = $sessionService;
        $this->courseService = $courseService;
        $this->phaseService = $phaseService;
        $this->examService = $examService;
        $this->classRoutineService = $classRoutineService;
        $this->subjectService = $subjectService;
        $this->bookService = $bookService;
        $this->subjectGroupService = $subjectGroupService;
    }


    public function index(Request $request) {
        $data = [
            'pageTitle' => 'Academic Calender',
            'sessions' => $this->sessionService->listByStatus(),
            'courses' => $this->courseService->listByStatus(),
            //'phases' => $this->phaseService->listByStatus(),
        ];

        if (!empty($request->session_id) && !empty($request->course_id) && !empty($request->subject_group_id)){

            $subjectPhase= $this->subjectService->getPhasesBySubjectGroupId($request->subject_group_id, $request->session_id,  $request->course_id);
            $session = $this->sessionService->find($request->session_id);

            $phaseStart = $session->sessionDetails->where('course_id', $request->course_id)->first()->sessionPhaseDetails->where('phase_id', '<', $subjectPhase->first()->phase_id)->first();

            if (!empty($phaseStart)){
                $startDurationAfter = explode('.', $phaseStart->duration);
                if (empty($startDurationAfter[1])){
                    $startDate = Carbon::create($session->start_year, 1, 1)->addYear($startDurationAfter[0])->addMonth(1);
                    $endDate = Carbon::create($session->start_year, 1, 1)->addYear($startDurationAfter[0])->addMonth(1);
                }else{
                    $startDate = Carbon::create($session->start_year, 1, 1)->addYear($startDurationAfter[0])->addMonth(($startDurationAfter[1] + 1));
                    $endDate = Carbon::create($session->start_year, 1, 1)->addYear($startDurationAfter[0])->addMonth(($startDurationAfter[1] + 1));
                }
            }else{
                $startDate = Carbon::create($session->start_year, 1, 1);
                $endDate = Carbon::create($session->start_year, 1, 1);
            }

            $duration = $session->sessionDetails->where('course_id', $request->course_id)->first()->sessionPhaseDetails->whereIn('phase_id', $subjectPhase->pluck('phase_id')->toArray())->sum('duration');
            $endYear = explode('.', $duration);

            if (!empty($endYear[1])){
                $endDate->addYear($endYear[0])->addMonth($endYear[1])->lastOfMonth();
            }else{
                $endDate->addYear($endYear[0])->subMonth(1)->lastOfMonth();
            }

            $data['holidays'] = $this->holidayService->getAllHolidayBySearchCriteria($request->session_id, $startDate, $endDate);
            $data['classRoutines'] = $this->classRoutineService->getAllClassRoutineBySearchCriteria($request->session_id, $request->course_id, $request->subject_group_id, $startDate, $endDate);
            $data['exams'] = $this->examService->getAllExamBySearchCriteria($request->session_id, $request->course_id, $request->subject_group_id, $startDate, $endDate);
            $data['books'] = $this->subjectService->getAllBookBySearchCriteria($request->subject_group_id);
        }


        return view('frontend.academicCalender.index', $data);
    }


    public function generatePdf(Request $request) {

        if (!empty($request->session_id) && !empty($request->course_id) && !empty($request->subject_group_id)){

            $subjectPhase= $this->subjectService->getPhasesBySubjectGroupId($request->subject_group_id, $request->session_id,  $request->course_id);
            $session = $this->sessionService->find($request->session_id);

            $phaseStart = $session->sessionDetails->where('course_id', $request->course_id)->first()->sessionPhaseDetails->where('phase_id', '<', $subjectPhase->first()->phase_id)->first();

            if (!empty($phaseStart)){
                $startDurationAfter = explode('.', $phaseStart->duration);
                if (empty($startDurationAfter[1])){
                    $startDate = Carbon::create($session->start_year, 1, 1)->addYear($startDurationAfter[0])->addMonth(1);
                    $endDate = Carbon::create($session->start_year, 1, 1)->addYear($startDurationAfter[0])->addMonth(1);
                }else{
                    $startDate = Carbon::create($session->start_year, 1, 1)->addYear($startDurationAfter[0])->addMonth(($startDurationAfter[1] + 1));
                    $endDate = Carbon::create($session->start_year, 1, 1)->addYear($startDurationAfter[0])->addMonth(($startDurationAfter[1] + 1));
                }
            }else{
                $startDate = Carbon::create($session->start_year, 1, 1);
                $endDate = Carbon::create($session->start_year, 1, 1);
            }

            $duration = $session->sessionDetails->where('course_id', $request->course_id)->first()->sessionPhaseDetails->whereIn('phase_id', $subjectPhase->pluck('phase_id')->toArray())->sum('duration');
            $endYear = explode('.', $duration);

            if (!empty($endYear[1])){
                $endDate->addYear($endYear[0])->addMonth($endYear[1])->lastOfMonth();
            }else{
                $endDate->addYear($endYear[0])->subMonth(1)->lastOfMonth();
            }

            $data['holidays'] = $this->holidayService->getAllHolidayBySearchCriteria($request->session_id, $startDate, $endDate);
            $data['classRoutines'] = $this->classRoutineService->getAllClassRoutineBySearchCriteria($request->session_id, $request->course_id, $request->subject_group_id, $startDate, $endDate);
            $data['exams'] = $this->examService->getAllExamBySearchCriteria($request->session_id, $request->course_id, $request->subject_group_id, $startDate, $endDate);
            $data['books'] = $this->subjectService->getAllBookBySearchCriteria($request->subject_group_id);
        }
            $data['session'] = $this->sessionService->find($request->session_id)->title;
            $data['course'] = $this->courseService->find($request->course_id)->title;
            $data['subjectGroup'] = $this->subjectGroupService->find($request->subject_group_id)->title;

            $pdf = PDF::loadView('academicCalender.generatePdf', $data, [], [
                'format' => 'A4'
            ]);

            return $pdf->stream('document.pdf');


    }

}
