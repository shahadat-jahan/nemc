<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class ExamResultsExport implements FromView
{
    protected $examTypes;
    protected $students;

    public function __construct($examTypes, $students)
    {
        $this->examTypes = $examTypes;
        $this->students = $students;
    }

    /**
     * Render the Blade view for the Excel export.
     */
    public function view(): View
    {
        return view('exports.exam_result_upload', [
            'examTypes' => $this->examTypes,
            'students' => $this->students,
        ]);
    }
}
