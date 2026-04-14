<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class DueBySessionExport implements FromView
{
    public $sessionInfo;
    public $courseInfo;
    public $studentsDue;

    /**
     * Constructor to accept export data
     *
     * @param array|Collection $data
     */
    public function __construct($sessionInfo, $courseInfo, $studentsDue)
    {
        $this->sessionInfo = $sessionInfo;
        $this->courseInfo = $courseInfo;
        $this->studentsDue = $studentsDue;
    }

    /**
     * Return the view to export
     *
     * @return View
     */
    public function view(): View
    {
        return view('exports.due_by_session', [
            'sessionInfo' => $this->sessionInfo,
            'courseInfo' => $this->courseInfo,
            'studentsDue' => $this->studentsDue,
        ]);
    }
}
