<?php

namespace App\Exports;


use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class parentList extends ManipulateExcelSheet implements FromView
{
    public $parents, $session, $course;

    public function __construct($parents, $session, $course)
    {
        $this->parents = $parents;
        $this->session = $session;
        $this->course = $course;
        $this->rowToMerge = 4;
    }

    /**
    * @return \Illuminate\Support\Collection
    */
    public function view(): View
    {
            return view('exports.parentList', [
                'parents' => $this->parents,
                'session' => $this->session,
                'course' => $this->course,
            ]);
    }
}
