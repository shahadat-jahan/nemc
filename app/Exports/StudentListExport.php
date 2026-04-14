<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class StudentListExport extends ManipulateExcelSheet implements FromView
{
    public $students, $studentStatus, $session, $course;

    public function __construct($students, $studentStatus, $session, $course)
    {
        $this->students = $students;
        $this->studentStatus = $studentStatus;
        $this->session = $session;
        $this->course = $course;
        $this->rowToMerge = 4;
    }


    /**
     * @return \Illuminate\Support\Collection
     */
    public function view(): View
    {
        return view('exports.list_of_all_student', [
            'students' => $this->students,
            'studentStatus' => $this->studentStatus,
            'session' => $this->session,
            'course' => $this->course,
        ]);
    }
}
