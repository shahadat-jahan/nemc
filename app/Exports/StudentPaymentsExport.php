<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class StudentPaymentsExport extends ManipulateExcelSheet implements FromView
{
    public $studentInstallments, $totalDevelopmentAvailableAmount, $studentPayments, $totalTuitionAvailableAmount, $student, $fromDate, $to_date;

    public function __construct($studentInstallments, $totalDevelopmentAvailableAmount, $studentPayments, $totalTuitionAvailableAmount, $student, $fromDate, $toDate)
    {
        $this->studentInstallments = $studentInstallments;
        $this->totalDevelopmentAvailableAmount = $totalDevelopmentAvailableAmount;
        $this->studentPayments = $studentPayments;
        $this->totalTuitionAvailableAmount = $totalTuitionAvailableAmount;
        $this->student = $student;
        $this->fromDate = $fromDate;
        $this->to_date = $toDate;
        $this->rowToMerge = 4;
    }


    /**
     * @return \Illuminate\Support\Collection
     */
    public function view(): View
    {
        return view('exports.payments_by_student', [
            'studentInstallments' => $this->studentInstallments,
            'totalDevelopmentAvailableAmount' => $this->totalDevelopmentAvailableAmount,
            'studentPayments' => $this->studentPayments,
            'totalTuitionAvailableAmount' => $this->totalTuitionAvailableAmount,
            'student' => $this->student,
            'fromDate' => $this->fromDate,
            'to_date' => $this->to_date,
        ]);
    }
}
