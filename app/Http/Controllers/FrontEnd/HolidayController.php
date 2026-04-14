<?php

namespace App\Http\Controllers\FrontEnd;

use App\Events\NotifyUserOnHolidayAnnounced;
use App\Http\Requests\HolidayRequest;
use App\Http\Controllers\Controller;
use App\Services\Admin\BatchTypeService;
use App\Services\Admin\HolidayService;
use App\Services\Admin\SessionService;
use App\Services\UtilityServices;
use Illuminate\Http\Request;

class HolidayController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    protected $holidayService;
    protected $sessionService;
    protected $batchTypeService;
    protected $redirectUrl;

    public function __construct(HolidayService $holidayService, SessionService $sessionService, BatchTypeService $batchTypeService) {
        $this->redirectUrl = 'nemc/holiday';
        $this->holidayService = $holidayService;
        $this->sessionService = $sessionService;
        $this->batchTypeService = $batchTypeService;
    }


    public function index() {
        $data = [
            'pageTitle' => 'Holiday',
            'tableHeads' => ['Id',  'Title', 'From Date', 'To Date', 'Session', 'Batch Type', 'Status', 'Action'],
            'dataUrl' => $this->redirectUrl.'/get-data',
            'months' => UtilityServices::$months,
            'years' => UtilityServices::getYears(10),
            'columns' => [
                ['data' => 'id', 'name' => 'id'],
                ['data' => 'title', 'name' => 'title'],
                ['data' => 'from_date', 'name' => 'from_date'],
                ['data' => 'to_date', 'name' => 'to_date'],
                ['data' => 'session_id', 'name' => 'session_id'],
                ['data' => 'batch_type_id', 'name' => 'batch_type_id'],
                ['data' => 'status', 'name' => 'status'],
                ['data' => 'action', 'name' => 'action', 'orderable' => false]
            ],
        ];
        return view('frontend.holiday.index', $data);
    }

    public function getData(Request $request){

        return $this->holidayService->getAllData($request);
    }

    public function show($id) {
        $data = [
            'pageTitle' => 'Holiday Detail',
            'holiday' => $this->holidayService->find($id),
        ];
        return view('frontend.holiday.view', $data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Holiday  $holiday
     * @return \Illuminate\Http\Response
     */
    public function edit($id) {
        $data = [
            'pageTitle' => 'Holiday Edit',
            'holiday' => $this->holidayService->find($id),
        ];
        //get all session
        $data['sessions'] = $this->sessionService->getAllSession();
        //get all batch Type
        $data['batchTypes'] = $this->batchTypeService->getAllBatchType();
        return view('holiday.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Holiday  $holiday
     * @return \Illuminate\Http\Response
     */
    public function update(HolidayRequest $request, $id) {

        $holiday = $this->holidayService->update($request->except('files'), $id);

        if ($holiday) {
            $request->session()->flash('success', setMessage('update', 'Holiday'));
            return redirect()->route('holiday.index');
        } else {
            $request->session()->flash('error', setMessage('update.error', 'Holiday'));
            return redirect()->route('holiday.index');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Holiday  $holiday
     * @return \Illuminate\Http\Response
     */
    public function destroy(Holiday $holiday)
    {
        //
    }
}
