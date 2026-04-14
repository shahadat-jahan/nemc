<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\Admin\CourseService;
use App\Services\Admin\ExamService;
use App\Services\Admin\PhaseService;
use App\Services\Admin\SessionService;
use App\Services\Admin\StudentService;
use App\Services\ResultService;
use Illuminate\Http\Request;

class StudentProgressController extends Controller
{
    /**
     *
     */
    const moduleName = 'Selection for Professional Exam';
    /**
     *
     */
    const moduleDirectory = 'student_progress.';

    protected $courseService;
    protected $phaseService;
    protected $examService;
    protected $studentService;
    protected $resultService;
    protected $sessionService;

    public function __construct(
        CourseService $courseService, PhaseService $phaseService, ExamService $examService, StudentService $studentService,
        ResultService $resultService, SessionService $sessionService
    ){
        $this->courseService = $courseService;
        $this->phaseService = $phaseService;
        $this->examService = $examService;
        $this->studentService = $studentService;
        $this->resultService = $resultService;
        $this->sessionService = $sessionService;
    }

    public function getStudentsResults(Request $request){
        if (!empty($request->course_id) && !empty($request->phase_id)){
//            $exams = $this->examService->getExamsByCourseIdPhaseId($request->course_id, $request->phase_id, $request->session_id);
//            $examsGroup = $this->examService->getExamsByCourseIdPhaseIdGroup($request->course_id, $request->phase_id, $request->session_id);
            $studentsResults = $this->resultService->getStudentsResultStatus($request->course_id, $request->phase_id,$request->session_id,$request->roll_no, $request->reg_no);
        }
        else{
//            $exams = [];
//            $examsGroup=[];
            $studentsResults = [];
        }
        if (!empty($studentsResults) && $studentsResults->isNotEmpty()){
            $sessions = $this->sessionService->getSessionsGreaterThanCurrent($studentsResults->first()->exam_session);
        }else{
            $sessions = $this->sessionService->listByStatus();
        }

        $data = [
            'pageTitle' => 'Selection for Promotion',
            'courses' => $this->courseService->listByStatus(),
            'phases' => $this->phaseService->listByStatus(),
            //            'exams'      => $exams,
            //            'examsGroup' => $examsGroup,
            'studentsResults' => $studentsResults,
            'sessions' => $sessions,
            'sessions_list'=> $this->sessionService->listByStatus()
        ];

        return view('student_progress.index', $data);
    }

    public function changeStudentPhaseStatus(Request $request)
    {
        $student = $this->resultService->promoteStudentToNextPhase($request);

        if ($student){
            $request->session()->flash('success', 'Student\'s selection status has been changed');
            return response()->json(['status' => true, 'redirect_url' => route('student_progress_result', ['course_id' => $request->course_id, 'phase_id' => $request->phase_id,'session_id' => $request->session_id])]);
        }
        $request->session()->flash('error', 'Updating student\'s selection status unsuccessful');
        return response()->json(['status' => false, 'redirect_url' => route('student_progress_result', ['course_id' => $request->course_id, 'phase_id' => $request->phase_id,'session_id' => $request->session_id])]);
    }

}
