<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\StudentGroupType;
use App\Services\Admin\ClassTypeService;
use App\Services\Admin\ExamCategoryService;
use App\Services\Admin\StudentGroupTypeService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class StudentGroupTypeController extends Controller
{
    /**
     *
     */
    const moduleName = 'Student Group Types';
    /**
     *
     */
    const redirectUrl = 'admin/student_group_type';
    /**
     *
     */
    const moduleDirectory = 'student_group_type.';

    protected $service;
    protected $classTypeService;
    protected $examCategoryService;

    public function __construct(StudentGroupTypeService $service, ClassTypeService $classTypeService, ExamCategoryService $examCategoryService)
    {
        $this->service = $service;
        $this->classTypeService = $classTypeService;
        $this->examCategoryService = $examCategoryService;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $data = [
            'pageTitle' => self::moduleName,
            'tableHeads' => ['Sl.', 'Title', 'Description', 'Class Type', 'Exam Category', 'Status', 'Action'],
            'dataUrl' => self::redirectUrl.'/get-data',
            'columns' => [
                ['data' => 'DT_RowIndex', 'name' => 'DT_RowIndex', 'orderable' => false],
                ['data' => 'title', 'name' => 'title'],
                ['data' => 'description', 'name' => 'description'],
                ['data' => 'class_type_title', 'name' => 'class_type_title'],
                ['data' => 'exam_category_title', 'name' => 'exam_category_title'],
                ['data' => 'status', 'name' => 'status'],
                ['data' => 'action', 'name' => 'action', 'orderable' => false]
            ],
            'classTypes' => $this->classTypeService->listByStatus(),
            'examCategories' => $this->examCategoryService->listByStatus(),
        ];

        return view(self::moduleDirectory.'index', $data);
    }

    public function getData(Request $request){
        return $this->service->getDataTable($request);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data = [
            'pageTitle' => self::moduleName,
            'classTypes' => $this->classTypeService->listByStatus(),
            'examCategories' => $this->examCategoryService->listByStatus(),
        ];

        return view(self::moduleDirectory.'create', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'title' => 'required|string|max:191|unique:student_group_types,title',
            'description' => 'nullable|string|max:255',
            'class_type_ids' => 'nullable|array',
            'class_type_ids.*' => 'exists:class_types,id',
            'exam_category_ids' => 'nullable|array',
            'exam_category_ids.*' => 'exists:exam_categories,id',
        ]);
        
        if ($validate->fails()) {
            return redirect()->back()->withErrors($validate)->withInput();
        }

        $studentGroupType = $this->service->addStudentGroupType($request);

        if ($studentGroupType) {
            $request->session()->flash('success', setMessage('create', self::moduleName));
            return redirect()->route('student_group_type.index');
        }

        $request->session()->flash('error', setMessage('create.error', self::moduleName));
        return redirect()->route('student_group_type.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\StudentGroupType  $studentGroupType
     * @return \Illuminate\Http\Response
     */
    public function show(StudentGroupType $studentGroupType)
    {
        $data = [
            'pageTitle' => self::moduleName,
            'studentGroupType' => $studentGroupType,
            'classTypes' => $this->classTypeService->listByStatus(),
            'examCategories' => $this->examCategoryService->listByStatus(),
        ];

        return view(self::moduleDirectory.'view', $data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\StudentGroupType  $studentGroupType
     * @return \Illuminate\Http\Response
     */
    public function edit(StudentGroupType $studentGroupType)
    {
        $data = [
            'pageTitle' => self::moduleName,
            'studentGroupType' => $studentGroupType,
            'classTypes' => $this->classTypeService->listByStatus(),
            'examCategories' => $this->examCategoryService->listByStatus(),
        ];
        return view(self::moduleDirectory.'edit', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\StudentGroupType  $studentGroupType
     * @return \Illuminate\Http\Response
     */

    public function update(Request $request, StudentGroupType $studentGroupType)
    {
        $validate = Validator::make($request->all(), [
            'title' => 'required|string|max:191|unique:student_group_types,title,' . $studentGroupType->id,
            'description' => 'nullable|string|max:255',
            'class_type_ids' => 'nullable|array',
            'class_type_ids.*' => 'exists:class_types,id',
            'exam_category_ids' => 'nullable|array',
            'exam_category_ids.*' => 'exists:exam_categories,id',
            'status' => 'required|boolean',
        ]);

        if ($validate->fails()) {
            return redirect()->back()->withErrors($validate)->withInput();
        }

        $studentGroupType = $this->service->updateStudentGroupType($studentGroupType, $request);

        if ($studentGroupType) {
            $request->session()->flash('success', setMessage('update', self::moduleName));
            return redirect()->route('student_group_type.index');
        }

        $request->session()->flash('error', setMessage('update.error', self::moduleName));
        return redirect()->route('student_group_type.index');
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\StudentGroupType  $studentGroupType
     * @return \Illuminate\Http\Response
     */
    public function destroy(StudentGroupType $studentGroupType)
    {
        //
    }
}
