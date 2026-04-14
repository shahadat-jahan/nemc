<?php

namespace App\Http\Controllers\FrontEnd;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;
use App\Services\Admin\NotificationService;

class NotificationController extends Controller
{

    protected $service;


    public function __construct(NotificationService $notificationService)
    {
        $this->service = $notificationService;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = [
            'notifications' => $this->service->getAllNotifications(),
        ];

        return view('frontend.notifications.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $this->service->markNotificationAsSeen($id);
        $data = $this->service->getNotificationById($id);
        return redirect('nemc/'.$data->notification_type.'/'.$data->resource_id);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    /**
     * get the latest notifications
     * @return mixed
     */
    public function getLatestNotifications() {
        return $this->service->getLatestNotifications(null);
    }

    public function updateSeenStatus(Request $request){
        $result = $this->service->updateSeenStatus($request->user);

        if ($result){
            return response()->json(['status'=> true]);
        }else{
            return response()->json(['status'=> false]);
        }
    }
}
