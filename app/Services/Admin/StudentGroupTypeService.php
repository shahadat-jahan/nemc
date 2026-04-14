<?php

namespace App\Services\Admin;

use App\Models\StudentGroupType;
use App\Services\BaseService;
use Yajra\DataTables\Facades\DataTables;

/**
 * Class StudentGroupTypeService
 * @package App\Services\Admin
 */
class StudentGroupTypeService extends BaseService
{
    /**
     * @var $model
     */
    protected $model;
    /**
     * @var string
     */
    protected $url = 'admin/student_group_type';

    public function __construct(StudentGroupType $studentGroupType)
    {
        $this->model = $studentGroupType;
    }

    public function getDataTable($request)
    {
        $query = $this->model->with('classTypes', 'examCategories')
                             ->select()->orderBy('status', 'desc')->orderBy('id', 'asc');

        return DataTables::of($query)
                         ->addColumn('title', function ($row) {
                             return $row->title;
                         })
                         ->addColumn('description', function ($row) {
                             return $row->description;
                         })
                         ->addColumn('class_type_title', function ($row) {
                             return optional($row->classTypes)->pluck('title')->implode(', ');
                         })
                         ->addColumn('exam_category_title', function ($row) {
                             return optional($row->examCategories)->pluck('title')->implode(', ');
                         })
                         ->addColumn('status', function ($row) {
                             return setStatus($row->status);
                         })
                         ->addColumn('action', function ($row) {
                             $action = '';
                             if (hasPermission('student_group_type/edit')) {
                                 $action .= '<a href="' . route('student_group_type.edit', $row->id) . '" class="m-portlet__nav-link btn m-btn m-btn--hover-brand m-btn--icon m-btn--icon-only m-btn--pill" title="Edit"><i class="flaticon-edit"></i></a>';
                             }
                             if (hasPermission('student_group_type/view')) {
                                 $action .= '<a href="' . route('student_group_type.show', $row->id) . '" class="m-portlet__nav-link btn m-btn m-btn--hover-brand m-btn--icon m-btn--icon-only m-btn--pill" title="View"><i class="flaticon-eye"></i></a>';
                             }
                             return $action;
                         })
                         ->addIndexColumn()
                         ->rawColumns(['status', 'action'])
                         ->filter(function ($query) use ($request) {
                             if (!empty($request->get('title'))) {
                                 $query->where('title', 'like', '%' . $request->get('title') . '%');
                             }
                             if (!empty($request->get('class_type_id'))) {
                                 $query->whereHas('classTypes', function ($q) use ($request) {
                                     $q->where('id', $request->get('class_type_id'));
                                 });
                             }
                             if (!empty($request->get('exam_category_id'))) {
                                 $query->whereHas('examCategories', function ($q) use ($request) {
                                     $q->where('id', $request->get('exam_category_id'));
                                 });
                             }
                         })
                         ->make(true);
    }

    public function addStudentGroupType($request)
    {
        $userId = auth()->id();
        $now = now();

        $studentGroupType = $this->model->create([
            'title' => $request->title,
            'description' => checkEmpty($request->description),
        ]);

        // Class Types sync
        $classTypeIds = $request->input('class_type_ids');
        $studentGroupType->classTypes()->sync(
            $this->buildSyncData((array)$classTypeIds, $userId, $now)
        );


        // Exam Categories sync
        $examCategoryIds = $request->input('exam_category_ids');
        $studentGroupType->examCategories()->sync(
            $this->buildSyncData((array)$examCategoryIds, $userId, $now)
        );

        return $studentGroupType;
    }

    public function updateStudentGroupType($studentGroupType, $request)
    {
        $userId = auth()->id();
        $now = now();

        $studentGroupType->update([
            'title' => $request->title,
            'description' => checkEmpty($request->description),
            'status' => $request->status,
        ]);

        // Class Types sync
        $classTypeIds = (array)$request->input('class_type_ids');
        $studentGroupType->classTypes()->sync(
            $this->buildSyncData($classTypeIds, $userId, $now)
        );

        // Exam Categories sync
        $examCategoryIds = (array)$request->input('exam_category_ids');
        $studentGroupType->examCategories()->sync(
            $this->buildSyncData($examCategoryIds, $userId, $now)
        );

        return $studentGroupType;
    }

    protected function buildSyncData(array $ids, $userId, $timestamp)
    {
        return collect($ids)->mapWithKeys(fn($id) => [
            $id => [
                'created_by' => $userId,
                'updated_by' => $userId,
                'created_at' => $timestamp,
                'updated_at' => $timestamp,
            ]
        ])->toArray();
    }
}
