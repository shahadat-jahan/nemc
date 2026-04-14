<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class ComparativeAttendanceExport implements FromView
{
    protected $reportData;
    protected $subject;
    protected $percentage_filter;
    protected $percentage_type;

    public function __construct($reportData, $session, $phase, $startDate, $endDate, $subject, $percentage_filter, $percentage_type)
    {
        $this->reportData = $reportData;
        $this->session = $session;
        $this->phase = $phase;
        $this->startDate = $startDate;
        $this->endDate = $endDate;
        $this->subject = $subject;
        $this->percentage_filter = $percentage_filter;
        $this->percentage_type = $percentage_type;
    }

    public function view(): View
    {
        return view('exports.comparativeAttendance', [
            'reportData' => $this->reportData,
            'session' => $this->session,
            'phase' => $this->phase,
            'startDate' => $this->startDate,
            'endDate' => $this->endDate,
            'subject' => $this->subject,
            'percentage_filter' => $this->percentage_filter,
            'percentage_type' => $this->percentage_type
        ]);
    }
}
