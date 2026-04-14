<?php

namespace App\Exports;


use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class ExamResultsExportByPhase extends ManipulateExcelSheet implements FromView
{

    public $examSubjects, $exams, $examResults, $sessionInfo, $phaseInfo;

    public function __construct($examSubjects, $exams, $examResults, $sessionInfo, $phaseInfo)
    {
        $this->examSubjects = $examSubjects;
        $this->exams = $exams;
        $this->examResults = $examResults;
        $this->sessionInfo = $sessionInfo;
        $this->phaseInfo = $phaseInfo;
        $this->rowToMerge = 4;
    }


    /**
     * @return \Illuminate\Support\Collection
     */
    public function view(): View
    {
        return view('exports.exam_results_by_phase', [
            'examSubjects' => $this->examSubjects,
            'exams' => $this->exams,
            'examResults' => $this->examResults,
            'session' => $this->sessionInfo,
            'phase' => $this->phaseInfo,
        ]);
    }
}
