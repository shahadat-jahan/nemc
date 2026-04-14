<?php

namespace App\Http\Controllers\FrontEnd;

use App\Events\NotifyUserWhenNoticePublished;
use App\Http\Controllers\Controller;
use App\Http\Requests\NoticeBoardRequest;
use App\Models\Notification;
use App\Services\Admin\BatchTypeService;
use App\Services\Admin\NoticeBoardService;
use App\Services\Admin\SessionService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NoticeBoardController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    protected $noticeBoardService;
    protected $sessionService;
    protected $batchTypeService;
    protected $redirectUrl;

    public function __construct(NoticeBoardService $noticeBoardService, SessionService $sessionService, BatchTypeService $batchTypeService) {
        $this->redirectUrl = 'nemc/notice_board';
        $this->noticeBoardService = $noticeBoardService;
        $this->sessionService = $sessionService;
        $this->batchTypeService = $batchTypeService;
    }


    public function index() {
        $data = [
            'pageTitle' => 'Notice Board',
            'tableHeads' => ['Id',  'Title',  'Published Date', 'Status', 'Action'],
            'dataUrl' => $this->redirectUrl.'/get-data',
            'columns' => [
                ['data' => 'id', 'name' => 'id'],
                ['data' => 'title', 'name' => 'title'],
                ['data' => 'published_date', 'name' => 'published_date'],
               /* ['data' => 'session_id', 'name' => 'session_id'],
                ['data' => 'batch_type_id', 'name' => 'batch_type_id'],*/
                ['data' => 'status', 'name' => 'status'],
                ['data' => 'action', 'name' => 'action', 'orderable' => false]
            ],
        ];
        return view('frontend.noticeBoard.index', $data);
    }

    public function getData(Request $request){

        return $this->noticeBoardService->getAllData($request);
    }

    public function show($id) {
        $data = [
            'pageTitle' => 'Notice Detail',
            'notice' => $this->noticeBoardService->find($id),
        ];
        return view('frontend.noticeBoard.view', $data);
    }

    public function checkNewNotice()
    {
        if (Auth::guard('student_parent')->check()){
            $userId = Auth::guard('student_parent')->check() ? Auth::guard('student_parent')->user()->id : '';
        }else{
            $userId = Auth::guard('web')->check() ? Auth::user()->id : '';
        }

        $newNotices = Notification::with('resource')
                                  ->whereHasMorph('resource', ['App\Models\NoticeBoard'], function ($query) {
                                      $query->where('status', 1);
                                  })
                                  ->where('user_id', $userId)
                                  ->where('is_seen', 0)
                                  ->where('notification_type', 'notice_board')
                                  ->orderBy('created_at', 'desc')
                                  ->get();
        return response()->json($newNotices);
    }
}
