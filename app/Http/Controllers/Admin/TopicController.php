<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\AssignTopic;
use App\Http\Requests\TopicRequest;
use App\Services\Admin\CourseService;
use App\Services\Admin\SubjectService;
use App\Services\Admin\TopicHeadService;
use App\Services\Admin\TopicService;
use Illuminate\Http\Request;

class TopicController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    protected $topicService;
    protected $topicHeadService;
    protected $subjectService;
    protected $courseService;

    protected $redirectUrl;

    public function __construct(
        TopicService $topicService, TopicHeadService $topicHeadService, SubjectService $subjectService, CourseService $courseService

    ){
        $this->redirectUrl = 'admin/topic';
        $this->topicService = $topicService;
        $this->topicHeadService = $topicHeadService;
        $this->subjectService = $subjectService;
        $this->courseService = $courseService;
    }


    public function index() {
        $data = [
            'pageTitle' => 'Topic',
            'tableHeads' => ['ID', 'Title', 'Serial No', 'Topic Head', 'Assigned To', 'Status', 'Action'],
            'dataUrl' => $this->redirectUrl.'/get-data',
            'columns' => [
                ['data' => 'id', 'name' => 'id'],
               /* ['data' => 'DT_RowIndex', 'name' => 'DT_RowIndex'],*/
                ['data' => 'title', 'name' => 'title'],
                ['data' => 'serial_number', 'name' => 'serial_number'],
                ['data' => 'topic_head_id', 'name' => 'topic_head_id'],
                //['data' => 'subject', 'name' => 'subject'],
                ['data' => 'assigned_to', 'name' => 'assigned_to'],
                ['data' => 'status', 'name' => 'status'],
                ['data' => 'action', 'name' => 'action', 'orderable' => false]
            ],
        ];
        //get all topic head
        $data['topicHeads'] = $this->topicHeadService->listByStatus();
        //get all course
        $data['courses'] = $this->courseService->listByStatus();

        return view('topic.index', $data);
    }

    public function getData(Request $request){

        return $this->topicService->getAllData($request);
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
        //get all subject
        $data['subjects'] = $this->subjectService->getAllSubject();
        //get all topic head
        $data['topicHeads'] = $this->topicHeadService->getAllTopicHead();
        //get all course
        $data['courses'] = $this->courseService->listByStatus();

        return view('topic.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(TopicRequest $request) {
        $topic = $this->topicService->create($request->except('files', 'course_id', 'subject_group_id', 'subject_id'));

        if ($topic) {
            $request->session()->flash('success', setMessage('create', 'Topic'));
            return redirect()->route('topic.index');
        } else {
            $request->session()->flash('error', setMessage('create.error', 'Topic'));
            return redirect()->route('topic.index');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Topic  $topic
     * @return \Illuminate\Http\Response
     */
    public function show($id){
        $data = [
            'pageTitle' => 'Topic Detail',
            'topic' => $this->topicService->find($id),
        ];
        return view('topic.view', $data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Topic  $topic
     * @return \Illuminate\Http\Response
     */
    public function edit($id) {
        $data = [
            'pageTitle' => 'Topic Edit',
            'topic' => $this->topicService->find($id),
        ];
        //get all subject
        $data['subjects'] = $this->subjectService->getAllSubject();
        //get all topic head
        $data['topicHeads'] = $this->topicHeadService->getAllTopicHead();
        //get all course
        $data['courses'] = $this->courseService->getAllCourse();
        return view('topic.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Topic  $topic
     * @return \Illuminate\Http\Response
     */
    public function update(TopicRequest $request, $id) {

        $topic = $this->topicService->updateTopic($request, $id);

        if ($topic) {
            $request->session()->flash('success', setMessage('update', 'Topic'));
            return redirect()->route('topic.index');
        } else {
            $request->session()->flash('error', setMessage('update.error', 'Topic'));
            return redirect()->route('topic.index');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Topic  $topic
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function getTopicsBySubjecId(Request $request){
        $topics = $this->topicService->getNotAssignedTopicsBySubjectId($request->input('subjectId'));

        return response()->json(['status' => true, 'data' => $topics]);
    }

    public function topicToTeacher(){
        $data = [
            'pageTitle' => 'Assign Topic',
            'subjects' => $this->subjectService->listByStatus()
        ];
        //get all course
        $data['courses'] = $this->courseService->listByStatus();


        return view('topic.assign_topic.add', $data);
    }

    public function assignTopicToTeacher(AssignTopic $request){
        $assignTopic = $this->topicService->assignTopic($request);

        if ($assignTopic){
            $request->session()->flash('success', 'Teacher has been assigned successfully');
            return redirect()->route('topic.index');
        }else{
            $request->session()->flash('error', 'Error in assigning teacher');
            return redirect()->route('topic.index');
        }
    }

    /**
     * Return all active topics for a given subject (for AJAX dropdown)
     */
    public function listBySubject(Request $request)
    {
        $topics = $this->topicService->getTopicsBySubjectId($request->input('subjectId'));
        return response()->json(['status' => true, 'data' => $topics]);
    }
}
