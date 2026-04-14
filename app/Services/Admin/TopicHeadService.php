<?php

namespace App\Services\Admin;

use App\Models\ExamSubType;
use App\Models\TopicHead;
use App\Services\BaseService;
use DataTables;
use Illuminate\Support\Facades\Auth;

/**
 * Class UserService
 * @package App\Services\Admin
 */
class TopicHeadService extends BaseService {

    /**
     * @var $model
     */
    protected $model;

    public function __construct(TopicHead $topicHead){
        $this->model = $topicHead;
    }

    /**
     *
     * @return JsonResponse
     */
    public function getAllData($request)
    {
        $query = $this->model->select();

        if (Auth::guard('web')->check()){
            $user = Auth::guard('web')->user();
            if ($user->teacher){
                $query = $query->whereIn('subject_id', getSubjectsIdByTeacherId($user->teacher->id, $user->teacher->course_id));
            }
        }elseif (Auth::guard('student_parent')->check()){
            $user = Auth::guard('student_parent')->user();
            //if login user is student
            if ($user->student){
                $query = $query->whereIn('subject_id', getSubjectsIdByCourseId($user->student->course_id));
            }
            //if login user is parent
            elseif ($user->parent){
                $query = $query->whereIn('subject_id', getSubjectsIdByCourseId($user->parent->students->first()->course_id));
            }
        }

        return Datatables::of($query)
            ->addColumn('action', function ($row) {
                $actions = '';

                if (hasPermission('topic_head/edit')) {
                    $actions.= '<a href="' . route('topic_head.edit', [$row->id]) . '" class="m-portlet__nav-link btn m-btn m-btn--hover-brand m-btn--icon m-btn--icon-only m-btn--pill" title="Edit"><i class="flaticon-edit"></i></a>';
                }
                if (hasPermission('topic_head/view')) {
                    $actions.= '<a href="' . route(customRoute('topic_head.show'), [$row->id]) . '" class="m-portlet__nav-link btn m-btn m-btn--hover-brand m-btn--icon m-btn--icon-only m-btn--pill" title="View"><i class="flaticon-eye"></i></a>';
                }

                return $actions;
            })

            //auto incremented serial number
            ->addIndexColumn()

            ->editColumn('subject_id', function ($row) {
                return isset($row->subject) ? $row->subject->title : '';
            })

            ->addColumn('topics', function ($row) {
                return isset($row->topics) ? $row->topics->count() : 0;
            })

            ->editColumn('status', function ($row) {
                return setStatus($row->status);
            })

            ->rawColumns(['status', 'action'])

            ->filter(function ($query) use ($request) {

                if ($request->get('title')) {
                    $query->where('title', 'like', '%'.$request->get('title').'%');
                }

                if (!empty($request->get('subject_id'))) {
                    $query->where('subject_id', $request->get('subject_id'));
                }

                if (!empty($request->get('subject_id'))) {
                    $query->where('subject_id', $request->get('subject_id'));
                }
            })

            ->make(true);
    }

    //get all topic head list
    public function getAllTopicHead() {
        $query = $this->model->where('status', 1);

        if (Auth::guard('web')->check()){
            $user = Auth::guard('web')->user();
            if ($user->teacher){
                $query = $query->whereIn('subject_id', getSubjectsIdByTeacherId($user->teacher->id, $user->teacher->course_id));
            }
        }elseif (Auth::guard('student_parent')->check()){
            $user = Auth::guard('student_parent')->user();
            //if login user is student
            if ($user->student){
                $query = $query->whereIn('subject_id', getSubjectsIdByCourseId($user->student->course_id));
            }
            //if login user is parent
            elseif ($user->parent){
                $query = $query->whereIn('subject_id', getSubjectsIdByCourseId($user->parent->students->first()->course_id));
            }
        }
        return $query->get();
    }

    public function getTopicHeadsBySubjectId($subjectId) {
        return $this->model->where('subject_id', $subjectId)->get();
    }

}
