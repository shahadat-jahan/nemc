<?php

namespace App\Http\Controllers\Admin;

use App\Exports\CampaignReportExport;
use App\Http\Controllers\Controller;
use App\Services\CampaignService;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use PDF;

class CampaignReportController extends Controller
{
    protected $campaignService;

    public function __construct(CampaignService $campaignService)
    {
        $this->campaignService = $campaignService;
    }

    public function index(Request $request)
    {
        $reports = $this->campaignService->getCampaignReports($request->all());

        $data = [
            'pageTitle' => 'Campaign Report',
            'reports'   => $reports,
            'filters'   => $request->all()
        ];

        return view('reports.new_campaign.index', $data);
    }

    public function exportExcel(Request $request)
    {
        $reports = $this->campaignService->getCampaignReports($request->all(), false);
        return Excel::download(new CampaignReportExport($reports), 'Campaign Report.xlsx');
    }

    public function exportPdf(Request $request)
    {
        $reports    = $this->campaignService->getCampaignReports($request->all(), false);
        $pageLayout = $request->page_layout ?? 'A4-portrait';
        $data       = [
            'reports' => $reports
        ];
        $pdf        = PDF::loadView('reports.new_campaign.pdf.campaign_report', $data, [], ['format' => $pageLayout]);
        return $pdf->stream('Campaign Report.pdf');
    }
}
