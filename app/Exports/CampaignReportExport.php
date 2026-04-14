<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class CampaignReportExport implements FromView
{
    protected $data;

    public function __construct($data)
    {
        $this->data = $data;
    }

    /**
    * @return View
    */
    public function view(): View
    {
        return view('exports.campaign_report', [
            'reports' => $this->data
        ]);
    }
}
