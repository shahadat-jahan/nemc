<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class AllStudentPaymentsExport extends ManipulateExcelSheet implements FromView
{
    public $studentInstallments, $studentPayments, $session, $course;

    public function __construct($studentInstallments, $studentPayments, $session, $course, $paymentTypeArr, $paymentTypeId)
    {
//        dd($studentInstallments);
        $this->studentInstallments = $studentInstallments;
        $this->studentPayments = $studentPayments;
        $this->session = $session;
        $this->course = $course;
        $this->paymentType = $paymentTypeArr;
        $this->paymentTypeId = $paymentTypeId;
        $this->rowToMerge = 4;
    }


    /**
     * @return \Illuminate\Support\Collection
     */
    public function view(): View
    {
        return view('exports.payments_of_all_student', [
            'studentInstallments' => $this->studentInstallments,
            'studentPayments' => $this->studentPayments,
            'session' => $this->session,
            'course' => $this->course,
            'paymentType' => $this->paymentType,
            'paymentTypeId' => $this->paymentTypeId,
        ]);
    }
}
