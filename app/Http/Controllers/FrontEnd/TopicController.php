<?php

namespace App\Http\Controllers\FrontEnd;

use App\Http\Controllers\Controller;
use App\Http\Requests\AssignTopic;
use App\Http\Requests\TopicRequest;
use App\Services\Admin\CourseService;
use App\Services\Admin\SubjectService;
use App\Services\Admin\TopicHeadService;
use App\Services\Admin\TopicService;
use App\Topic;
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
        $this->redirectUrl = 'nemc/topic';
        $this->topicService = $topicService;
        $this->topicHeadService = $topicHeadService;
        $this->subjectService = $subjectService;
        $this->courseService = $courseService;
    }


    public function index() {
        $data = [
            'pageTitle' => 'Topic',
            'tableHeads' => ['Id', 'Title','Serial No', 'Topic Head', 'Assigned To', 'Status'],
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
            ],
        ];
        //get all topic head
        $data['topicHeads'] = $this->topicHeadService->getAllTopicHead();
        //get all course
        $data['courses'] = $this->courseService->getAllCourse();

        return view('frontend.topic.index', $data);
    }

    public function getData(Request $request){

        return $this->topicService->getAllData($request);
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
        return view('frontend.topic.view', $data);
    }


    public function getTopicsBySubjecId(Request $request){
        $topics = $this->topicService->getNotAssignedTopicsBySubjectId($request->input('subjectId'));

        return response()->json(['status' => true, 'data' => $topics]);
    }
}
