<?php

namespace App\Services\Admin;

use App\Models\LessonPlan;
use App\Services\BaseService;
use DataTables;
use Illuminate\Support\Facades\Auth;

/**
 * Class LessonPlanService
 * @package App\Services\Admin
 */
class LessonPlanService extends BaseService {

    /**
     * @var $model
     */
    protected $model;

    /**
     * @var string
     */
    protected $url = 'admin/lesson-plan';

    /**
     * LessonPlanService constructor.
     * @param LessonPlan $lessonPlan
     */
    public function __construct(LessonPlan $lessonPlan)
    {
        $this->model = $lessonPlan;
    }

    /**
     * Get all lesson plans for a topic
     *
     * @param int $topicId
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getLessonPlansByTopicId($topicId)
    {
        return $this->model->where('topic_id', $topicId)->get();
    }

    /**
     * Get all lesson plans data for DataTables
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getAllData($request)
    {
        $query = $this->model->select();

        if (!empty($request->get('topic_id'))) {
            $query->where('topic_id', $request->get('topic_id'));
        }

        if (!empty($request->get('speaker_id'))) {
            $query->where('speaker_id', $request->get('speaker_id'));
        }

        return Datatables::of($query)
            ->addColumn('action', function ($row) {
                $actions = '';

                if (hasPermission('lesson_plan/edit')) {
                    $actions .= '<a href="' . route('lesson.plan.edit', [$row->id]) . '" class="m-portlet__nav-link btn m-btn m-btn--hover-brand m-btn--icon m-btn--icon-only m-btn--pill" title="Edit"><i class="flaticon-edit"></i></a>';
                }
                if (hasPermission('lesson_plan/view')) {
                    $actions .= '<a href="' . route('lesson.plan.show', [$row->id]) . '" class="m-portlet__nav-link btn m-btn m-btn--hover-brand m-btn--icon m-btn--icon-only m-btn--pill" title="View"><i class="flaticon-eye"></i></a>';
                }
                if (hasPermission('lesson_plan/delete')) {
                    $actions .= '<a href="#"'
                        . ' class="m-portlet__nav-link btn m-btn m-btn--hover-brand m-btn--icon m-btn--icon-only m-btn--pill delete-lesson-plan"'
                        . ' title="Delete" data-url="' . route('lesson.plan.delete', [$row->id]) . '">'
                        . '<i class="flaticon-delete"></i></a>';
                }

                return $actions;
            })
            ->editColumn('topic_id', function ($row) {
                return $row->topic_id ? $row->topic->title : '';
            })
            ->editColumn('speaker_id', function ($row) {
                return $row->speaker_id ? $row->speaker->full_name : '';
            })
            ->editColumn('date', function ($row) {
                return $row->date ? date('d M Y', strtotime($row->date)) : '';
            })
            ->editColumn('time', function ($row) {
                return ($row->start_time && $row->end_time) ? parseClassTimeInTwelveHours($row->start_time) . ' - ' . parseClassTimeInTwelveHours($row->end_time) : 'Not specified';
            })
            ->editColumn('status', function ($row) {
                return setStatus($row->status);
            })
            ->rawColumns(['status', 'action'])
            ->filter(function ($query) use ($request) {
                if ($request->get('title')) {
                    $query->where('title', 'like', '%' . $request->get('title') . '%');
                }
                if ($request->get('speaker_id')) {
                    $query->where('speaker_id', $request->get('speaker_id'));
                }
                if ($request->get('topic_id')) {
                    $query->where('topic_id', $request->get('topic_id'));
                }
            })
            ->make(true);
    }

    /**
     * Store a new lesson plan
     *
     * @param array $data
     * @return \App\Models\LessonPlan
     */
    public function storeLessonPlan($data)
    {
        return $this->model->create($data);
    }

    /**
     * Update a lesson plan
     *
     * @param array $data
     * @param int $id
     * @return \App\Models\LessonPlan
     */
    public function updateLessonPlan($data, $id)
    {
        $lessonPlan = $this->find($id);
        $lessonPlan->update($data);
        return $lessonPlan;
    }
}
