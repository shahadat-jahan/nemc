<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\LectureMaterialRequest;
use App\Services\Admin\Admission\ClassRoutineService;
use App\Services\Admin\Admission\StudentGroupService;
use App\Services\Admin\AttendanceService;
use App\Services\Admin\BatchTypeService;
use App\Services\Admin\ClassTypeService;
use App\Services\Admin\CourseService;
use App\Services\Admin\HallService;
use App\Services\Admin\LectureMaterialService;
use App\Services\Admin\PhaseService;
use App\Services\Admin\SessionService;
use App\Services\Admin\SubjectService;
use App\Services\Admin\TeacherService;
use App\Services\Admin\TermService;
use App\Services\Admin\TopicService;
use App\Services\UtilityServices;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use PhpParser\Node\Stmt\If_;

class LectureMaterialController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Response
     */
    protected $lectureMaterialService;
    protected $classRoutineService;
    protected $sessionService;
    protected $courseService;
    protected $phaseService;
    protected $redirectUrl;

    public function __construct(LectureMaterialService $lectureMaterialService, ClassRoutineService $classRoutineService,
                                SessionService         $sessionService, CourseService $courseService, PhaseService $phaseService)
    {
        $this->redirectUrl = 'admin/lecture_material';
        $this->lectureMaterialService = $lectureMaterialService;
        $this->classRoutineService = $classRoutineService;
        $this->sessionService = $sessionService;
        $this->courseService = $courseService;
        $this->phaseService = $phaseService;
    }


    public function index(){
        $data = [
            'pageTitle' => 'Lecture Material',
            'tableHeads' => ['Id',  'Class Type', 'Content', 'Attachment','Status', 'Action'],
            'dataUrl' => $this->redirectUrl.'/get-data',
            'columns' => [
                ['data' => 'id', 'name' => 'id'],
                ['data' => 'class_routine_id', 'name' => 'class_routine_id'],
                ['data' => 'content', 'name' => 'content'],
                ['data' => 'attachment', 'name' => 'attachment'],
                ['data' => 'status', 'name' => 'status'],
                ['data' => 'action', 'name' => 'action', 'orderable' => false]
            ],
            'sessions' => $this->sessionService->listByStatus(),
            'courses'  => $this->courseService->listByStatus(),
            'phases'   => $this->phaseService->listByStatus(),
        ];

        return view('lectureMaterial.index', $data);
    }

    public function getData(Request $request){

        return $this->lectureMaterialService->getAllData($request);
    }
    //get all lecture material by class routine id
    public function getLectureMaterialByRoutineId(Request $request, $id){

        return $this->lectureMaterialService->AllLectureMaterialByRoutineId($request, $id);
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request) {

        $data = [
            'pageTitle' => 'Lecture Material Create',
        ];
        //receive class id
        $data['classId'] = $request->class_id;
        $data['mode'] = 'lecture';
        return view('lectureMaterial.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(LectureMaterialRequest $request) {
        $lectureMaterial = $this->lectureMaterialService->saveLectureMaterial($request);

        if ($lectureMaterial){
            $request->session()->flash('success', setMessage('create', 'Lecture Material'));
        }else{
            $request->session()->flash('error', setMessage('create.error', 'Lecture Material'));
        }

        if ($request->mode == 'lecture'){
            return redirect()->route('class_routine.info.single', [$request->class_routine_id,'mode' => $request->mode]);
        }

        return redirect()->route('lecture_material.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  $id
     *
     * @return \Illuminate\Http\Response
     */
    public function show($id) {
        $data = [
            'pageTitle' => 'Lecture Material Edit',
            'lectureMaterial' => $this->lectureMaterialService->find($id),
        ];

        return view('lectureMaterial.view', $data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  $id
     *
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data = [
            'pageTitle' => 'Lecture Material Edit',
            'lectureMaterial' => $this->lectureMaterialService->find($id),
        ];

        $data['mode'] = 'lecture';
        return view('lectureMaterial.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Topic  $topic
     * @return \Illuminate\Http\Response
     */
    public function update(LectureMaterialRequest $request, $id) {

        $lectureMaterial = $this->lectureMaterialService->updateLectureMaterial($request, $id);

        if ($lectureMaterial){
            $request->session()->flash('success', setMessage('update', 'Lecture Material'));
        }else{
            $request->session()->flash('error', setMessage('update.error', 'Lecture Material'));
        }

        if ($request->mode == 'lecture'){
            return redirect()->route('class_routine.info.single', [$request->class_routine_id,'mode' => $request->mode]);
        }

        return redirect()->route('lecture_material.index');
    }

}
