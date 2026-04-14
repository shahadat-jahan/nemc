<?php

namespace App\Exports;


use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class AttendanceByPhaseExport extends ManipulateExcelSheet implements FromView
{

    public $sessionInfo;
    public $subjects;
    public $attendanceByStudent;

    public function __construct($sessionInfo, $course, $phase, $subjects, $attendanceByStudent)
    {
        $this->sessionInfo = $sessionInfo;
        $this->course = $course;
        $this->phase = $phase;
        $this->subjects = $subjects;
        $this->attendanceByStudent = $attendanceByStudent;
        $this->rowToMerge = 4;
    }


    /**
     * @return \Illuminate\Support\Collection
     */
    public function view(): View
    {
        return view('exports.attendanceByPhase', [
            'sessionInfo' => $this->sessionInfo,
            'course' =>$this->course,
            'phase' => $this->phase,
            'subjects' => $this->subjects,
            'attendanceByStudent' => $this->attendanceByStudent,
        ]);
    }
}
