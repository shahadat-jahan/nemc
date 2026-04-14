<?php

namespace App\Exports;


use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class AttendanceByTermExport extends ManipulateExcelSheet implements FromView
{

    public $attendance;
    public $totalLectureClass;
    public $totalPracticalClass;
    public $subjectInfo;
    public $min_max_date;
    public $sessionInfo;
    public $courseInfo;
    public $department;

    public function __construct($sessionInfo, $course, $phase, $term, $department, $totalLectureClass, $totalPracticalClass, $attendanceReport)
    {
        $this->totalLectureClass = $totalLectureClass;
        $this->totalPracticalClass = $totalPracticalClass;
        $this->attendance = $attendanceReport;
        $this->sessionInfo = $sessionInfo;
        $this->department = $department;
        $this->course = $course;
        $this->phase = $phase;
        $this->term = $term;
        $this->rowToMerge = 3;
    }


    /**
     * @return \Illuminate\Support\Collection
     */
    public function view(): View
    {
        return view('exports.attendanceByTerm', [
            'sessionInfo' => $this->sessionInfo,
            'department' => $this->department,
            'course' =>$this->course,
            'phase' => $this->phase,
            'term' => $this->term,
            'attendanceReport' => $this->attendance,
            'totalLectureClass' => $this->totalLectureClass,
            'totalPracticalClass' => $this->totalPracticalClass,
        ]);
    }
}
