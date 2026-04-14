<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\HallRequest;
use App\Services\Admin\HallService;
use App\Services\UtilityServices;
use Exception;
use Illuminate\Http\Request;

class HallController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    protected $hallService;

    protected $redirectUrl;

    public function __construct(HallService $hallService){
        $this->redirectUrl = 'admin/hall';
        $this->hallService = $hallService;
    }


    public function index(){
        $data = [
            'pageTitle' => 'Hall',
            'tableHeads' => ['Id', 'Title', 'Floor Number', 'Room Number', 'Status', 'Action'],
            'dataUrl' => $this->redirectUrl.'/get-data',
            'columns' => [
                ['data' => 'id', 'name' => 'id'],
                ['data' => 'title', 'name' => 'title'],
                ['data' => 'floor_number', 'name' => 'floor_number'],
                ['data' => 'room_number', 'name' => 'room_number'],
                ['data' => 'status', 'name' => 'status'],
                ['data' => 'action', 'name' => 'action', 'orderable' => false]
            ],
        ];

        return view('hall.index', $data);
    }

    public function getData(Request $request){

        return $this->hallService->getAllData($request);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {
        $data = [
            'pageTitle' => 'Hall Create',
        ];
        $data['floors'] = UtilityServices::getFloors();
        return view('hall.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return false
     */
    public function store(HallRequest $request) {
        try {
            $hall = $this->hallService->create($request->all());
        }catch (Exception $e){
            $request->session()->flash('error', 'Room number must be unique.');
            return redirect()->route('hall.index');
        }

        if ($hall) {
            $request->session()->flash('success', setMessage('create', 'Class Room'));
            return redirect()->route('hall.index');
        } else {
            $request->session()->flash('error', setMessage('create.error', 'Class Room'));
            return redirect()->route('hall.index');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Hall  $hall
     * @return \Illuminate\Http\Response
     */
    public function show(Hall $hall)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Hall  $hall
     * @return \Illuminate\Http\Response
     */
    public function edit($id) {
        $data = [
            'pageTitle' => 'Edit Hall',
            'hall' => $this->hallService->find($id),
        ];
        $data['floors'] = UtilityServices::getFloors();
        return view('hall.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Hall  $hall
     * @return false
     */
    public function update(HallRequest $request, $id) {

        try {
            $hall = $this->hallService->update($request->all(), $id);
        }catch (Exception $e){
            $request->session()->flash('error', 'Room number must be unique.');
            return redirect()->route('hall.index');
        }

        if ($hall) {
            $request->session()->flash('success', setMessage('update', 'Class Room'));
            return redirect()->route('hall.index');
        } else {
            $request->session()->flash('error', setMessage('update.error', 'Class Room'));
            return redirect()->route('hall.index');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Hall  $hall
     * @return \Illuminate\Http\Response
     */
    public function destroy(Hall $hall)
    {
        //
    }
}
