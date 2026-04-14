<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\TopicHeadRequest;
use App\Services\Admin\CourseService;
use App\Services\Admin\SubjectService;
use App\Services\Admin\TopicHeadService;
use App\Topic;
use Illuminate\Http\Request;

class TopicHeadController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    protected $topicHeadService;
    protected $subjectService;
    protected $courseService;

    protected $redirectUrl;

    public function __construct(TopicHeadService $topicHeadService, SubjectService $subjectService, CourseService $courseService){
        $this->redirectUrl = 'admin/topic_head';
        $this->topicHeadService = $topicHeadService;
        $this->subjectService = $subjectService;
        $this->courseService = $courseService;
    }


    public function index(){
        $data = [
            'pageTitle' => 'Topic Head',
            'tableHeads' => ['Id', 'Serial No.', 'Title', 'Subject', 'Topics', 'Status', 'Action'],
            'dataUrl' => $this->redirectUrl.'/get-data',
            'columns' => [
                ['data' => 'id', 'name' => 'id'],
                ['data' => 'DT_RowIndex', 'name' => 'DT_RowIndex'],
                ['data' => 'title', 'name' => 'title'],
                ['data' => 'subject_id', 'name' => 'subject_id'],
                ['data' => 'topics', 'name' => 'topics'],
                ['data' => 'status', 'name' => 'status'],
                ['data' => 'action', 'name' => 'action', 'orderable' => false]
            ],
        ];
        $data['courses'] = $this->courseService->listByStatus();

        return view('topicHead.index', $data);
    }


    public function getData(Request $request){
        return $this->topicHeadService->getAllData($request);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {
        $data = [
            'pageTitle' => 'Topic Head Create',
        ];
        //get all course
        $data['courses'] = $this->courseService->listByStatus();


        return view('topicHead.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(TopicHeadRequest $request) {
        $topicHead = $this->topicHeadService->create($request->except('course_id', 'subject_group_id'));
        if ($topicHead) {
            $request->session()->flash('success', setMessage('create', 'Topic Head'));
            return redirect()->route('topic_head.index');
        } else {
            $request->session()->flash('error', setMessage('create.error', 'Topic Head'));
            return redirect()->route('topic_head.index');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Topic  $topic
     * @return \Illuminate\Http\Response
     */
    public function edit($id) {
        $data = [
            'pageTitle' => 'Topic Head Edit',
            'topicHead' => $this->topicHeadService->find($id),
        ];
        //get all course
        $data['courses'] = $this->courseService->getAllCourse();
        return view('topicHead.edit', $data);
    }

    public function show($id) {
        $data = [
            'pageTitle' => 'Topic Head Details',
            'topicHead' => $this->topicHeadService->find($id)
        ];

        return view('topicHead.view', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Topic  $topic
     * @return \Illuminate\Http\Response
     */
    public function update(TopicHeadRequest $request, $id) {
        $topicHead = $this->topicHeadService->update($request->except('course_id', 'subject_group_id'), $id);
        if ($topicHead) {
            $request->session()->flash('success', setMessage('update', 'Topic Head'));
            return redirect()->route('topic_head.index');
        } else {
            $request->session()->flash('error', setMessage('update.error', 'Topic Head'));
            return redirect()->route('topic_head.index');
        }
    }


    public function getTopicHead(Request $request){
        $topicHeads = $this->topicHeadService->getTopicHeadsBySubjectId($request->input('subject_id'));
        return response()->json($topicHeads);
    }
}
