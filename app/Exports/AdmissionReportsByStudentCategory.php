<?php

namespace App\Exports;


use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class AdmissionReportsByStudentCategory extends ManipulateExcelSheet implements FromView
{
    public $sessionId, $courseId, $type, $searchResult, $sessions, $courses;

    public function __construct($sessionId, $courseId, $type, $searchResult, $sessions, $courses)
    {
        $this->sessionId = $sessionId;
        $this->courseId = $courseId;
        $this->type = $type;
        $this->searchResult = $searchResult;
        $this->sessions = $sessions;
        $this->courses = $courses;
        $this->rowToMerge = 2;
    }

    /**
    * @return \Illuminate\Support\Collection
    */
    public function view(): View
    {
        if ($this->type == 1){
            return view('exports.admission_normal_students', [
                'sessionId' => $this->sessionId,
                'courseId' => $this->courseId,
                'searchResult' => $this->searchResult,
                'sessions' => $this->sessions,
                'courses' => $this->courses,
            ]);
        }

        if ($this->type == 2) {
            return view('exports.admission_foreign_students', [
                'sessionId' => $this->sessionId,
                'courseId' => $this->courseId,
                'searchResult' => $this->searchResult,
                'sessions' => $this->sessions,
                'courses' => $this->courses,
            ]);
        }

        return view('exports.admission_poor_fund_students', [
            'sessionId'    => $this->sessionId,
            'courseId'     => $this->courseId,
            'searchResult' => $this->searchResult,
            'sessions'     => $this->sessions,
            'courses'      => $this->courses,
        ]);
    }
}
