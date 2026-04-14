<?php

namespace App\Exports;


use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class AttendanceExport implements FromView
{

    public $attendance;
    public $subjectInfo;
    public $sessionInfo;
    public $courseInfo;
    public $phaseInfo;
    public $showAllClassTypes;
    public $selectedClassTypes;
    public $start_date;
    public $end_date;

    public function __construct($attendance, $subjectInfo, $sessionInfo, $courseInfo, $phaseInfo, $showAllClassTypes, $selectedClassTypes, $start_date, $end_date)
    {
        $this->attendance = $attendance;
        $this->subjectInfo = $subjectInfo;
        $this->sessionInfo = $sessionInfo;
        $this->courseInfo = $courseInfo;
        $this->phaseInfo = $phaseInfo;
        $this->showAllClassTypes = $showAllClassTypes;
        $this->selectedClassTypes = $selectedClassTypes;
        $this->start_date = $start_date;
        $this->end_date = $end_date;
        $this->rowToMerge         = 4;
    }


    /**
    * @return \Illuminate\Support\Collection
    */
    public function view(): View
    {
        return view('exports.attendance', [
            'attendanceReport' => $this->attendance,
            'subjectInfo' => $this->subjectInfo,
            'sessionInfo' => $this->sessionInfo,
            'courseInfo' => $this->courseInfo,
            'phaseInfo' => $this->phaseInfo,
            'showAllClassTypes' => $this->showAllClassTypes,
            'selectedClassTypes' => $this->selectedClassTypes,
            'start_date' => $this->start_date,
            'end_date' => $this->end_date,
        ]);
    }
}
