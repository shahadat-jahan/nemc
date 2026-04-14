<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class TeachersListExport extends ManipulateExcelSheet implements FromView
{
    public $course;
    public $department;
    public $teachers;

    public function __construct($course, $department, $teachers)
    {
        $this->course = $course;
        $this->department = $department;
        $this->teachers = $teachers;
        $this->rowToMerge = 4;
    }


    /**
     * @return \Illuminate\Support\Collection
     */
    public function view(): View
    {
        return view('exports.list_of_all_teachers', [
            'course' => $this->course,
            'department' => $this->department,
            'teachers' => $this->teachers,
        ]);
    }
}
