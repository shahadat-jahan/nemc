<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class AllTeacherWiseClassExport extends ManipulateExcelSheet implements FromView
{
    public $teacherWiseClass, $session, $subject;

    public function __construct($teacherWiseClass, $session, $subject)
    {
        $this->teacherWiseClass = $teacherWiseClass;
        $this->session = $session;
        $this->subject = $subject;
        $this->rowToMerge = 4;
    }


    /**
     * @return \Illuminate\Support\Collection
     */
    public function view(): View
    {
        return view('exports.teacher_wise_total_class', [
            'teacherWiseClass' => $this->teacherWiseClass,
            'session' => $this->session,
            'subject' => $this->subject,
        ]);
    }
}
