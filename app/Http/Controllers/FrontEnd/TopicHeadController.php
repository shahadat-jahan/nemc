<?php

namespace App\Http\Controllers\FrontEnd;

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
        $this->redirectUrl = 'nemc/topic_head';
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
        //get all course
        $data['courses'] = $this->courseService->getAllCourse();

        return view('frontend.topicHead.index', $data);
    }


    public function getData(Request $request){
        return $this->topicHeadService->getAllData($request);
    }


    public function show($id) {
        $data = [
            'pageTitle' => 'Topic Head Details',
            'topicHead' => $this->topicHeadService->find($id)
        ];

        return view('frontend.topicHead.view', $data);
    }



    public function getTopicHead(Request $request){
        $topicHeads = $this->topicHeadService->getTopicHeadsBySubjectId($request->input('subject_id'));
        return response()->json($topicHeads);
    }
}
