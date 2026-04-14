<?php

namespace App\Http\Controllers\FrontEnd;

use App\Http\Controllers\Controller;
use App\Http\Requests\LectureMaterialRequest;
use App\Services\Admin\Admission\ClassRoutineService;
use App\Services\Admin\LectureMaterialService;
use Illuminate\Http\Request;
use PhpParser\Node\Stmt\If_;

class LectureMaterialController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    protected $lectureMaterialService;
    protected $classRoutineService;

    protected $redirectUrl;

    public function __construct(LectureMaterialService $lectureMaterialService, ClassRoutineService $classRoutineService){
        $this->redirectUrl = 'nemc/lecture_material';
        $this->lectureMaterialService = $lectureMaterialService;
        $this->classRoutineService = $classRoutineService;
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
        ];

        return view('frontend.lectureMaterial.index', $data);
    }

    public function getData(Request $request){

        return $this->lectureMaterialService->getAllData($request);
    }
    //get all lecture material by class routine id
    public function getLectureMaterialByRoutineId(Request $request, $id){

        return $this->lectureMaterialService->AllLectureMaterialByRoutineId($request, $id);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Topic  $topic
     * @return \Illuminate\Http\Response
     */
    public function show($id) {
        $data = [
            'pageTitle' => 'Lecture Material Detail',
            'lectureMaterial' => $this->lectureMaterialService->find($id),
        ];

        return view('frontend.lectureMaterial.view', $data);
    }

}
