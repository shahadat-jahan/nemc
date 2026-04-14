<?php

namespace App\Listeners;

use App\Events\NotifyUserWhenExamResultAnnounced;
use App\Models\Exam;
use App\Models\ExamResult;
use App\Models\SessionDetail;
use App\Services\Admin\NotificationService;
use App\Services\Admin\StudentService;
use App\Services\Admin\SubjectService;
use App\Services\UtilityServices;

class NotifyUserWhenExamResultAnnouncedListener
{

    public $notificationService;
    public $subjectService;
    public $sessionDetail;
    public $studentService;
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct(NotificationService $notificationService, SubjectService $subjectService, SessionDetail $sessionDetail, StudentService $studentService)
    {
        $this->notificationService = $notificationService;
        $this->subjectService = $subjectService;
        $this->sessionDetail = $sessionDetail;
        $this->studentService = $studentService;
    }

    /**
     * Handle the event.
     *
     * @param  NotifyUserWhenExamResultAnnounced  $event
     * @return void
     */
    public function handle(NotifyUserWhenExamResultAnnounced $event)
    {
        $exam = Exam::whereHas('examSubjects', function ($q) use($event){
            $q->where('exam_id', $event->examId)->where('subject_id', $event->subjectId)->where('result_published', 1);
        })->first();

        $subject = $this->subjectService->find($event->subjectId);

        $examMarksId = $exam->examMarks->pluck('id')->toArray();

        ExamResult::whereIn('exam_subject_mark_id', $examMarksId)->groupBy('student_id')->each(function ($item) use($event, $exam, $subject){

            /*if ($exam->exam_category_id == 3){
                $checkTerm = $this->sessionDetail->where('session_id', $exam->session_id)->where('course_id', $exam->course_id)
                    ->with(['sessionPhaseDetails' => function($q) use($exam){
                        $q->where('phase_id', $exam->phase_id);
                    }])
                    ->first();

                if ($checkTerm->sessionPhaseDetails->first()->total_terms > $item->student->term_id){
                    $this->studentService->update(['term_id' => ($item->student->term_id + 1)], $item->student_id);
                }
            }*/


            $this->notificationService->create([
                'notification_type' => 'result/show/' . $event->examId,
                'user_id' => $item->student->user_id,
                'resource_id' => $event->subjectId,
                'resource_type' => UtilityServices::$notificationModels[4],
                'message' => "Exam result of <b>" . $exam->title . "</b> for the subject <b>".$subject->title."</b>, has been published"
            ]);

        });


    }
}
