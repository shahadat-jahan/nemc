<?php

namespace App\Listeners;

use App\Jobs\ResultPublishEmails;
use App\Models\Exam;
use App\Models\ExamResult;
use App\Services\Admin\ExamTypeService;
use App\Services\Admin\SubjectService;
use App\Services\ResultService;

class NotifyParentsWhenExamResultAnnouncedListener
{

    public $subjectService;
    public $examTypeService;
    public $resultService;

    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct(SubjectService $subjectService, ExamTypeService $examTypeService, ResultService $resultService)
    {
        $this->subjectService = $subjectService;
        $this->examTypeService = $examTypeService;
        $this->resultService = $resultService;
    }

    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle($event)
    {
        $exam = Exam::whereHas('examSubjects', function ($q) use($event){
            $q->where('exam_id', $event->examId)->where('subject_id', $event->subjectId)->where('result_published', 1);
        })->first();

        $subject = $this->subjectService->find($event->subjectId);

        $examMarksId = $exam->examMarks->pluck('id')->toArray();

        $examTypeSubType = $this->examTypeService->getExamTypesSubTypesWithMarkByExamIdAndSubjectId($event->examId, $event->subjectId);

        ExamResult::whereIn('exam_subject_mark_id', $examMarksId)->groupBy('student_id')->each(function ($item) use($event, $exam, $subject, $examTypeSubType){

            if (!empty($item->student->parent->father_email)){
                $examResult = $this->resultService->getExamResultsByExamIdSubjectIdAndStudentId($event->examId, $event->subjectId, $item->student->id);

                ResultPublishEmails::dispatch($item->student->parent->father_email, $exam, $subject, $examTypeSubType, $examResult)->delay(now()->addSeconds(5));
            }

        });
    }
}
