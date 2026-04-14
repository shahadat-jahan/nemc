<?php

namespace App\Services\Admin;

use App\Models\ExamSubType;
use App\Models\Topic;
use App\Models\TopicHead;
use App\Services\BaseService;
use DataTables;
use Illuminate\Support\Facades\Auth;

/**
 * Class UserService
 * @package App\Services\Admin
 */
class TopicService extends BaseService {

    /**
     * @var $model
     */
    protected $model;
    /**
     * @var string
     */
    protected $url = 'admin/topic';


    /**
     * @param Topic $topic
     * @param TeacherService $teacherService
     */
    public function __construct(Topic $topic, TeacherService $teacherService)
    {
        $this->model = $topic;
        $this->teacherService = $teacherService;
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
            if ($user->user_group_id == 4 || $user->user_group_id == 11 || $user->user_group_id == 12) {
                $query = $query->whereHas('topicHead', function ($q) use($user){
                    $q->whereIn('subject_id', getSubjectsIdByTeacherId($user->teacher->id, $user->teacher->course_id));
                });
            }
        }elseif (Auth::guard('student_parent')->check()){
            $user = Auth::guard('student_parent')->user();
            //if login user is student
            if ($user->user_group_id == 5){
                $query = $query->whereHas('topicHead', function ($q) use($user){
                    $q->whereIn('subject_id', getSubjectsIdByCourseId($user->student->course_id));
                });
            }
            //if login user is parent
            elseif ($user->user_group_id == 6){
                $query = $query->whereHas('topicHead', function ($q) use($user){
                    $q->whereIn('subject_id', getSubjectsIdByCourseId($user->parent->students->first()->course_id));
                });
            }
        }
        return Datatables::of($query)
            ->addColumn('action', function ($row) {
                $actions = '';
                if (hasPermission('topic/edit')) {
                    $actions.= '<a href="' . route('topic.edit', [$row->id]) . '" class="m-portlet__nav-link btn m-btn m-btn--hover-brand m-btn--icon m-btn--icon-only m-btn--pill" title="Edit"><i class="flaticon-edit"></i></a>';
                }
                if (hasPermission('lesson_plan/create')) {
                    $actions .= '<a href="' . route('topic.lesson.plan.create', [$row->id]) . '" class="m-portlet__nav-link btn m-btn m-btn--hover-brand m-btn--icon m-btn--icon-only m-btn--pill" title="Create Lesson Plan"><i class="flaticon-clipboard"></i></a>';
                }
                if (hasPermission('lesson_plan/index')) {
                    $actions .= '<a href="' . route('topic.lesson.plan.index', [$row->id]) . '" class="m-portlet__nav-link btn m-btn m-btn--hover-brand m-btn--icon m-btn--icon-only m-btn--pill" title="View Lesson Plans"><i class="flaticon-list-3"></i></a>';
                }

                return $actions;
            })
            ->editColumn('topic_head_id', function ($row) {
                return isset($row->topicHead) ?  $row->topicHead->title : '';
            })
            ->editColumn('assigned_to', function ($row) {
               return $row->teachers->isNotEmpty() ? $row->teachers->first()['full_name'] : '';
            })
            ->editColumn('status', function ($row) {
                return setStatus($row->status);
            })
            ->rawColumns(['status', 'action'])
            ->filter(function ($query) use ($request) {
                if ($request->get('title')) {
                    $query->where('title', 'like', '%'.$request->get('title').'%');
                }

                if (!empty($request->get('topic_head_id'))) {
                    $query->where('topic_head_id', $request->get('topic_head_id'));
                }
                //filter topic by subject id
                if (!empty($request->get('subject_id'))) {
                    $subjectId = $request->get('subject_id');
                    $query->whereHas('topicHead', function ($q)use($subjectId){
                        $q->where('subject_id', $subjectId);
                    })->get();
                }

                if (!empty($request->get('teacher_id'))) {
                    $teacherId = $request->get('teacher_id');
                    $query->whereHas('teachers', function ($query) use ($teacherId) {
                        $query->where('id', $teacherId);
                    })->get();
                }

            })

            ->make(true);
    }

    /**
     * @param $subjectId
     * @return mixed
     */
    public function getTopicsBySubjectId($subjectId){

        return $this->model->whereHas('topicHead', function ($q) use($subjectId){
           return $q->where('subject_id', $subjectId);
        })->with('teachers')->get();
    }

    /**
     * @param $subjectId
     * @return mixed
     */
    public function getNotAssignedTopicsBySubjectId($subjectId){

        return $this->model->where('status', 1)->whereHas('topicHead', function ($q) use($subjectId){
            return $q->where('subject_id', $subjectId);
        })->doesntHave('teachers')->get();
    }

    public function updateTopic($request, $id){
        $topic = $this->find($id);

        $this->model->find($id)->update([
            'title' => $request->title,
            'topic_head_id' => $request->topic_head_id,
            'serial_number' => $request->serial_number,
            'description' => $request->description,
            'status' => $request->status,
        ]);

        $topic->teachers()->detach();
        if (!empty($request->teacher_id)){
            $topic->teachers()->attach($request->teacher_id);
        }

        return $topic;

    }

    /**
     * @param $request
     * @return \App\Services\dataObject
     */
    public function assignTopic($request){

        foreach ($request->topic as $item) {
            $topic = $this->find($item);
            $topic->teachers()->attach($request->teacher_id);
        }

        return $topic;

    }

    public function getAllTopicsBySubjectIdAndDepartmentId($subjectId, $departmentId){
        $topics =$this->model->whereHas('topicHead.subject', function ($query) use($subjectId, $departmentId){
            $query->where([
                ['id', $subjectId],
                ['department_id', $departmentId],
            ]);
        });

        if (Auth::guard('web')->check()) {
            $user = Auth::guard('web')->user();
            if ($user->teacher) {
                $teacherId = $user->teacher->id;
                $topics    = $topics->whereHas('teachers', function ($query) use ($teacherId) {
                    $query->where([
                        ['teacher_id', $teacherId],
                    ]);
                });
            }
        }
        return $topics->get();
    }

    public function getTeachersByTopicId($id)
    {
        $topic = $this->find($id);
        if ($topic) {
            $departmentId = $topic->topicHead->subject->department_id;
            return $this->teacherService->getTeachersByDepartmentIds($departmentId)->sortBy('full_name')->pluck('full_name', 'id');
        }
        return [];
    }
}