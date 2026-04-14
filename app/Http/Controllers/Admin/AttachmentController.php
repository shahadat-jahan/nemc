<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\AttachmentTypeRequest;
use App\Services\AttachmentService;
use Illuminate\Http\Request;
use Intervention\Image\Facades\Image as Image;

class AttachmentController extends Controller
{

    protected $attachmentService;

    protected $redirectUrl;


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct(AttachmentService $attachmentService) {
        $this->redirectUrl = 'admin/attachment_type';
        $this->attachmentService = $attachmentService;
    }


    public function index() {
        $data = [
            'pageTitle' => 'Attachment',
            'tableHeads' => ['Id', 'Title', 'Status', 'Action'],
            'dataUrl' => $this->redirectUrl.'/get-data',
            'columns' => [
                ['data' => 'id', 'name' => 'id'],
                ['data' => 'title', 'name' => 'title'],
                ['data' => 'status', 'name' => 'status'],
                ['data' => 'action', 'name' => 'action', 'orderable' => false]
            ],
        ];

        return view('attachmentType.index', $data);
    }

    public function getData(Request $request){

        return $this->attachmentService->getAllData($request);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {
        $data = [
            'pageTitle' => 'Attachment Type Create',
        ];
        return view('attachmentType.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(AttachmentTypeRequest $request) {
        $attachmentType = $this->attachmentService->saveAttachment($request->all());

        if ($attachmentType) {
            $request->session()->flash('success', setMessage('create', 'Attachment Type'));
            return redirect()->route('attachment_type.index');
        } else {
            $request->session()->flash('error', setMessage('create.error', 'Attachment Type'));
            return redirect()->route('attachment_type.index');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Attachment  $attachment
     * @return \Illuminate\Http\Response
     */
    public function show(Attachment $attachment)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Attachment  $attachment
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data = [
            'pageTitle' => 'Attachment TypeEdit',
            /*'attachment' => $this->attachmentService->find($id),*/
            'attachment' => $this->attachmentService->editAttachment($id),
        ];
        return view('attachmentType.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Attachment  $attachment
     * @return \Illuminate\Http\Response
     */
    public function update(AttachmentTypeRequest $request, $id) {
        /*$attachmentType = $this->attachmentService->update($request->all(), $id);*/
        $attachmentType = $this->attachmentService->updateAttachment($request->all(), $id);

        if ($attachmentType) {
            $request->session()->flash('success', setMessage('update', 'Attachment Type'));
            return redirect()->route('attachment_type.index');
        } else {
            $request->session()->flash('error', setMessage('update.error', 'Attachment Type'));
            return redirect()->route('attachment_type.index');
        }

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Attachment  $attachment
     * @return \Illuminate\Http\Response
     */
    public function destroy(Attachment $attachment)
    {
        //
    }

    public function uploadAttachment(Request $request){
        $result = $this->attachmentService->uploadAttachment($request, $request->type);
        return response()->json($result);
    }

    public function cropImage(Request $request){

        /*$img = Image::make($request->image);
        $img->crop($request->width, $request->height, $request->x1, $request->y1);*/

        Image::make($request->image)->crop($request->width, $request->height, $request->x1, $request->y1)->save($request->image)->destroy();

        return $request->image;
    }
}
