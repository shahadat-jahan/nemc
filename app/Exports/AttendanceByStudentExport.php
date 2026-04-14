<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromView;

class AttendanceByStudentExport extends ManipulateExcelSheet implements FromView
{
    public $student;
    public $sessionInfo;
    public $course;
    public $phase;
    public $term;
    public $selectedClassTypes;
    public $showAllClassTypes;
    public $department;
    public $totalLectureClass;
    public $totalTutorialClass;
    public $totalLectureAttendance;
    public $totalTutorialAttendance;
    public $attendanceData;
    public $start_date;
    public $end_date;

    public function __construct($student, $sessionInfo, $course, $phase, $selectedClassTypes, $showAllClassTypes,
                                $department, $totalClass, $totalAttendance, $attendanceData, $start_date = null, $end_date = null)
    {
        $this->student            = $student;
        $this->sessionInfo        = $sessionInfo;
        $this->course             = $course;
        $this->phase              = $phase;
        $this->selectedClassTypes = $selectedClassTypes;
        $this->showAllClassTypes  = $showAllClassTypes;
        $this->department         = $department;
        $this->totalClass         = $totalClass;
        $this->totalAttendance    = $totalAttendance;
        $this->attendanceData     = $attendanceData;
        $this->start_date         = $start_date;
        $this->end_date           = $end_date;
        $this->rowToMerge         = 5;
    }

    /**
     * @return Collection
     */
    public function view(): View
    {
        return view('exports.attendanceByStudent', [
            'student'            => $this->student,
            'sessionInfo'        => $this->sessionInfo,
            'course'             => $this->course,
            'phase'              => $this->phase,
            'selectedClassTypes' => $this->selectedClassTypes,
            'showAllClassTypes'  => $this->showAllClassTypes,
            'department'         => $this->department,
            'totalClass'         => $this->totalClass,
            'totalAttendance'    => $this->totalAttendance,
            'attendanceData'     => $this->attendanceData,
            'start_date' => $this->start_date,
            'end_date' => $this->end_date,
        ]);
    }
}
