<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
class ExamResultsExportByCategory extends ManipulateExcelSheet implements FromView
{
    public $exam, $examTypeSubType, $examResult, $subject, $letters;

    public function __construct($exam, $examTypeSubType, $examResult, $subject)
    {
        $this->exam = $exam;
        $this->examTypeSubType = $examTypeSubType;
        $this->examResult = $examResult;
        $this->subject = $subject;
        $this->rowToMerge = 4;
    }


    /**
     * @return \Illuminate\Support\Collection
     */
    public function view(): View
    {
        return view('exports.exam_results_by_category', [
            'exam' => $this->exam,
            'examTypeSubType' => $this->examTypeSubType,
            'examResult' => $this->examResult,
            'subject' => $this->subject,
        ]);
    }
}
