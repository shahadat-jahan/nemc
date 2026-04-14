<?php

namespace App\Services\Admin;

use App\Models\ClassRoutine;
use App\Models\ExamSubType;
use App\Models\LectureMaterial;
use App\Services\BaseService;
use Carbon\Carbon;
use DataTables;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;


/**
 * Class UserService
 * @package App\Services\Admin
 */
class LectureMaterialService extends BaseService {

    /**
     * @var $model
     */
    protected $model;
    protected $classRoutineModel;
    /**
     * @var string
     */
    //protected $url = 'admin/topic_head';


    public function __construct(LectureMaterial $lectureMaterial, ClassRoutine $classRoutine)
    {
        $this->model = $lectureMaterial;
        $this->classRoutineModel = $classRoutine;
    }

    /**
     * @param $request
     *
     * @return mixed
     */
    public function getAllData($request)
    {
        $query = $this->model->with('classRoutine')->select();

        if (Auth::guard('web')->check()) {
            $authUser = Auth::guard('web')->user();
            if ($authUser->teacher) {
                $teacher = $authUser->teacher;
                $query   = $query->whereHas('classRoutine', function ($q) use ($teacher) {
                    $q->whereIn('subject_id', getSubjectsIdByTeacherId($teacher->id, $teacher->course_id));
                });
            }
        } else if (Auth::guard('student_parent')->check()) {
            $authUser = Auth::guard('student_parent')->User();
            //if login user is student
            if($authUser->user_group_id == 5){
                $student = $authUser->student;
            }
            //if login user is parent
            elseif ($authUser->user_group_id == 6){
                $student = $authUser->parent->students->first();
            }
            $classRoutineIds = $this->classRoutineModel->where([
                ['session_id', $student->session_id],
                ['course_id', $student->course_id],
                ['batch_type_id', $student->batch_type_id],
                ['phase_id', $student->phase_id],
            ])->pluck('id');

            $query = $query->whereIn('class_routine_id', $classRoutineIds);
        }

        return Datatables::of($query)
            ->addColumn('action', function ($row) {
                $actions = '';

                if (getAppPrefix() == 'admin'){
                    $viewRoute = 'lecture_material.show';
                } else {
                    $viewRoute = 'frontend.lecture_material.show';
                }

                if (hasPermission('lecture_material/edit')) {
                    $actions .= '<a href="' . route('lecture_material.edit', [$row->id]) . '" class="m-portlet__nav-link btn m-btn m-btn--hover-brand m-btn--icon m-btn--icon-only m-btn--pill" title="Edit"><i class="flaticon-edit"></i></a>';
                }

                if (hasPermission('lecture_material/view')) {
                    $actions .= '<a href="' . route($viewRoute, [$row->id]) . '" class="m-portlet__nav-link btn m-btn m-btn--hover-brand m-btn--icon m-btn--icon-only m-btn--pill" title="View111"><i class="flaticon-eye"></i></a>';
                }

                return $actions;
            })


            ->editColumn('class_routine_id', function ($row) {
                return isset($row->classRoutine->classType) ? $row->classRoutine->classType->title : '';
            })

            ->editColumn('content', function ($row) {
                return isset($row->content) ? Str::limit(strip_tags($row->content), 50) : '';
            })

            ->editColumn('attachment', function ($row) {
                return isset($row->attachment) ? '<a href="' . asset('nemc_files/lecture_material/'.$row->attachment) .'" class=" btn m-btn m-btn--hover-brand m-btn--icon m-btn--icon-only m-btn--pill" target="_blank" title="Download " download><i class="fa fa-download"></i></a>' : '';

            })

            ->editColumn('status', function ($row) {
                return setStatus($row->status);
            })
            ->rawColumns(['content', 'attachment', 'status', 'action'])
            ->filter(function ($query) use ($request) {
                if ($request->get('title')) {
                    $query->where('content', 'like', '%' . $request->get('title') . '%');
                }

                if (!empty($request->get('session_id'))) {
                    $query->whereHas('classRoutine', function ($q) use ($request) {
                        $q->where('session_id', $request->get('session_id'));
                    });
                }

                if (!empty($request->get('course_id'))) {
                    $query->whereHas('classRoutine', function ($q) use ($request) {
                        $q->where('course_id', $request->get('course_id'));
                    });
                }

                if (!empty($request->get('phase_id'))) {
                    $query->whereHas('classRoutine', function ($q) use ($request) {
                        $q->where('phase_id', $request->get('phase_id'));
                    });
                }

                if (!empty($request->get('subject_id'))) {
                    $query->whereHas('classRoutine', function ($q) use ($request) {
                        $q->where('subject_id', $request->get('subject_id'));
                    });
                }
            })

            ->make(true);
    }


    public function AllLectureMaterialByRoutineId($request, $id){
        $query = $this->model->where('class_routine_id', $id);

        return Datatables::of($query)

            ->addColumn('action', function ($row) {
                $actions = '';
                if (hasPermission('lecture_material/edit')) {
                    $actions.= '<a href="' . route('lecture_material.edit', [$row->id]) . '" class="m-portlet__nav-link btn m-btn m-btn--hover-brand m-btn--icon m-btn--icon-only m-btn--pill" title="Edit"><i class="flaticon-edit"></i></a>';
                }
                if (hasPermission('lecture_material/view')) {
                    /*$actions.= '<a href="' . route('lecture_material.show', [$row->id]) . '" class="m-portlet__nav-link btn m-btn m-btn--hover-brand m-btn--icon m-btn--icon-only m-btn--pill" title="View"><i class="flaticon-eye"></i></a>';*/
                    $actions.= '<a href="' . route(customRoute('lecture_material.show'), [$row->id]) . '" class="m-portlet__nav-link btn m-btn m-btn--hover-brand m-btn--icon m-btn--icon-only m-btn--pill" title="View"><i class="flaticon-eye"></i></a>';
                }

                return $actions;
            })

            ->editColumn('class_routine_id', function ($row) {
                return isset($row->classRoutine->classType) ? $row->classRoutine->classType->title : '';
            })

            ->editColumn('content', function ($row) {
                return isset($row->content) ? Str::limit(strip_tags($row->content), 10) : '';
            })

            ->editColumn('attachment', function ($row) {
                return isset($row->attachment) ? '<a href="' . asset('nemc_files/lecture_material/'.$row->attachment) .'" class=" btn m-btn m-btn--hover-brand m-btn--icon m-btn--icon-only m-btn--pill" target="_blank" title="Download " download><i class="fa fa-download"></i></a>' : '';

                /*return '<a href="' . asset('nemc_files/lecture_material/'.$row->attachment) .'" class=" btn m-btn m-btn--hover-brand m-btn--icon m-btn--icon-only m-btn--pill" target="_blank" title="Download " download><i class="fa fa-download"></i></a>\'';*/
            })

            ->editColumn('status', function ($row) {
                return setStatus($row->status);
            })
            ->rawColumns(['content', 'attachment', 'status', 'action'])
            ->make(true);
    }



    public function saveLectureMaterial($request){

        if ($request->hasFile('attachment_file')) {
            //accept file from file type field
            $file = $request->file('attachment_file');
            $currentDate = Carbon::now()->toDateString();
            //create name for file
            $fileName = $currentDate .'_'. uniqid(). '_' .$file->getClientOriginalName();

            //if directory not exist make directory
            if (!file_exists('nemc_files/lecture_material'))  {
                mkdir('nemc_files/lecture_material', 0777 , true);

            }
            //move file to directory
            $file->move('nemc_files/lecture_material',$fileName);
            //assign file name to request attachment
            $request['attachment'] = $fileName;
        }

        //save data to lecture material table
        $lectureMaterialData =  $this->model->create($request->except('files', 'attachment_file', 'mode'));
        return $lectureMaterialData;

    }

    public function updateLectureMaterial($request, $id){
        $lectureMaterialData = $this->find($id);
        if ($request->hasFile('attachment_file')) {

            //accept file from file type field
            $file = $request->file('attachment_file');
            $currentDate = Carbon::now()->toDateString();
            //create name for file
            $fileName = $currentDate .'_'. uniqid(). '_' .$file->getClientOriginalName();

            //if directory not exist make directory
            if (!file_exists('nemc_files/lecture_material'))  {
                mkdir('nemc_files/lecture_material', 0777 , true);

            }
            //move file to directory
            $file->move('nemc_files/lecture_material',$fileName);
            //assign file name to request attachment
            $request['attachment'] = $fileName;
        }
        //take old attachment if dont select new attachment
        else{
            $request['attachment'] = $lectureMaterialData->attachment;
        }
        //update lecture material data
        $lectureMaterialData->update([
            'class_routine_id' => $request->class_routine_id,
            'content' => $request->content,
            'attachment' => $request->attachment,
            'resource_url' => $request->resource_url,
            'status' => $request->status,
        ]);

        return $lectureMaterialData;

    }

}
