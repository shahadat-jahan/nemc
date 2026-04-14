<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Events\AfterSheet;

class ExportExamResultByStudent extends ManipulateExcelSheet implements FromView
{
    public $exam, $subject, $examTypeSubType, $examResult;

    public function __construct($exam, $subject, $examTypeSubType, $examResult)
    {
        $this->exam = $exam;
        $this->subject = $subject;
        $this->examTypeSubType = $examTypeSubType;
        $this->examResult = $examResult;
        $this->rowToMerge = 5;
    }


    /**
     * @return \Illuminate\Support\Collection
     */
    public function view(): View
    {
        return view('exports.exam_results_by_student', [
            'exam' => $this->exam,
            'subject' => $this->subject,
            'examTypeSubType' => $this->examTypeSubType,
            'examResult' => $this->examResult,
        ]);
    }
}
