<?php

namespace App\Http\Controllers\Admin;

use App\Message;
use App\Http\Controllers\Controller;
use App\Services\Admin\MessageService;
use Illuminate\Http\Request;

class MessageController extends Controller
{
    protected $messageService;

    protected $redirectUrl;

    public function __construct(MessageService $messageService)
    {
        $this->redirectUrl = 'admin/message';
        $this->messageService = $messageService;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = [
            'pageTitle' => 'Message',
            'tableHeads' => ['Id', 'Send To', 'Send By', 'Subject', 'File', 'Is Seen', 'Is Replied', 'Action'],
            'dataUrl' => $this->redirectUrl . '/get-data',
            'columns' => [
                ['data' => 'id', 'name' => 'id'],
                ['data' => 'user_id', 'name' => 'user_id'],
                ['data' => 'created_by', 'name' => 'created_by'],
                ['data' => 'subject', 'name' => 'subject'],
                ['data' => 'file_path', 'name' => 'file_path'],
                ['data' => 'is_seen', 'name' => 'is_seen'],
                ['data' => 'is_replied', 'name' => 'is_replied'],
                ['data' => 'action', 'name' => 'action', 'orderable' => false]
            ],
        ];


        return view('message.index', $data);
    }

    public function getData(Request $request)
    {

        return $this->messageService->getAllData($request);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $message = $this->messageService->saveMessage($request);
        //$message = $this->messageService->create($request->all());
        if ($message) {
            $request->session()->flash('success', setMessage('create', 'Message'));
            return redirect()->back();
        }

        $request->session()->flash('error', setMessage('create.error', 'Message'));
        return redirect()->back();
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Message $message
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $data = [
            'pageTitle' => 'Message Detail',
            'userMessage' => $this->messageService->find($id),
        ];
        //dd($data);
        return view('message.view', $data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Message $message
     * @return \Illuminate\Http\Response
     */
    public function edit(Message $message)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Message $message
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Message $message)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Message $message
     * @return \Illuminate\Http\Response
     */
    public function destroy(Message $message)
    {
        //
    }


    public function saveReplyMessage($messageId, Request $request)
    {
        $request->validate([
            'reply_message' => [
                'required',
                'string',
                function ($attribute, $value, $fail) {
                    $stripped = strip_tags($value);
                    $cleaned = preg_replace('/\s+/', '', $stripped);
                    if (empty($cleaned)) {
                        $fail('The reply message cannot be empty or contain only whitespace.');
                    }
                }
            ]
        ]);

        $replyMessage = $this->messageService->saveReplyMessageData($messageId, $request);

        if ($replyMessage) {
            $request->session()->flash('success', 'Message replied successful');
            return redirect()->back();
        }

        $request->session()->flash('error', 'Message replied fail');
        return redirect()->back();
    }
}
