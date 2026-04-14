<?php

namespace App\Http\Controllers\Admin;

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
        $this->redirectUrl = 'admin/holiday';
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
        return view('holiday.index', $data);
    }

    public function getData(Request $request){

        return $this->holidayService->getAllData($request);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {
        $data = [
            'pageTitle' => 'Holiday Create',
        ];

        //get all session
        $data['sessions'] = $this->sessionService->getAllSession();
        //get all batch Type
        $data['batchTypes'] = $this->batchTypeService->getAllBatchType();

        return view('holiday.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(HolidayRequest $request) {

        $title = !empty($request->title) ? $request->title : '';
        $from_date = !empty($request->from_date) ? $request->from_date : '';
        $checkHoliday=$this->holidayService->checkHolidays($title,$from_date);

        if($checkHoliday > 0){
           $request->session()->flash('error', setMessage('create.error', 'Sorry Already Taken This Title In Year'));
            return redirect()->route('holiday.index');
        }

        $holiday = $this->holidayService->create($request->except('files', 'subject_id'));
        //send notification to users when holiday create
        event(new NotifyUserOnHolidayAnnounced($holiday));

        if ($holiday) {
            $request->session()->flash('success', setMessage('create', 'Holiday'));
            return redirect()->route('holiday.index');
        } else {
            $request->session()->flash('error', setMessage('create.error', 'Holiday'));
            return redirect()->route('holiday.index');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Holiday  $holiday
     * @return \Illuminate\Http\Response
     */
    public function show($id) {
        $data = [
            'pageTitle' => 'Holiday Detail',
            'holiday' => $this->holidayService->find($id),
        ];
        return view('holiday.view', $data);
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
        $holiday = $this->holidayService->find($id);
        event(new NotifyUserOnHolidayAnnounced($holiday));

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

    public function getCalendar(Request $request){
        $data = [
            'pageTitle' => 'Holiday',
            'holidays' => $this->holidayService->getAllHolidays($request),
            'months' => UtilityServices::$months,
            'years' => UtilityServices::getYears(10),
        ];


        return view('holiday.calendar', $data);
    }
}
