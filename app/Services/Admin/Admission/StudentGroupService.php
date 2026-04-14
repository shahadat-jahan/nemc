<?php
/**
 * Created by PhpStorm.
 * User: office
 * Date: 2/25/19
 * Time: 5:25 PM
 */

namespace App\Services\Admin\Admission;


use App\Models\StudentGroup;
use App\Services\Admin\StudentService;
use App\Services\BaseService;
use DataTables;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

/**
 * Class StudentGroupService
 * @package App\Services\Admin\Admission
 */
class StudentGroupService extends BaseService
{

    protected $studentService;

    /**
     * StudentGroupService constructor.
     * @param StudentGroup $studentGroup
     */
    public function __construct(StudentGroup $studentGroup, StudentService $studentService)
    {
        $this->model = $studentGroup;
        $this->studentService = $studentService;
    }

    /**
     * @param $request
     * @return \App\Services\insert_id|array
     */
    public function addStudentGroup($request)
    {
        if ($request->has('roll_range')){
            $roll_start = $request->roll_from;
            $roll_end = $request->roll_to;
        } else if ($request->has('rolls')) {
            $roll_start = $request->rolls[array_key_first($request->rolls)];
            $roll_end = $request->rolls[array_key_last($request->rolls)];
        }

        DB::beginTransaction();
        try {
            $studentGroup = $this->create([
                'session_id' => $request->session_id,
                'phase_id' => $request->phase_id,
                'course_id' => $request->course_id,
                'department_id' => $request->department_id,
                'group_name' => $request->title,
                'type' => $request->type,
                'roll_start' => $roll_start,
                'roll_end' => $roll_end,
                'old_student' => isset($request->is_old_students) ? 1 : 0,
            ]);

            if ($request->has('roll_range')) {
                for ($i = $request->roll_from; $i <= $request->roll_to; $i++) {
                    $student = $this->studentService->getStudentBySessionCourseAndRollNo($request->session_id, $request->course_id, $request->phase_id, $i);
                    if (!empty($student) && $student->batch_type_id == 1) {
                        $studentGroup->students()->attach($student->id, ['is_old' => 0]);
                    } elseif (!empty($student) && $student->batch_type_id == 2) {
                        $studentGroup->students()->attach($student->id, ['is_old' => 1]);
                    }
                }
            } else if ($request->has('rolls')) {
                foreach ($request->rolls as $roll) {
                    $student = $this->studentService->getStudentBySessionCourseAndRollNo($request->session_id, $request->course_id, $request->phase_id, $roll);
                    if (!empty($student) && $student->batch_type_id == 1) {
                        $studentGroup->students()->attach($student->id, ['is_old' => 0]);
                    } elseif (!empty($student) && $student->batch_type_id == 2) {
                        $studentGroup->students()->attach($student->id, ['is_old' => 1]);
                    }
                }
            }
            DB::commit();
            return $studentGroup;
        } catch (\Exception $e) {
            DB::rollBack();
            return $request->session()->flash('error', setMessage('create.error', 'Student Group'));
        }
    }

    public function getDataTable($request)
    {
        $query = $this->model->select()->orderBy('status', 'desc')->orderBy('id', 'desc');
        if (Auth::guard('web')->check()){
            $user = Auth::guard('web')->user();
            if ($user->teacher){
                $departmentId = $user->teacher->department_id;
                $courseId = $user->teacher->course_id ?? '';
                $query = $this->model->where('department_id', $departmentId)
                    ->where('course_id', $courseId)
                    ->latest();
            }
        }

        return Datatables::of($query)
            ->editColumn('session_id', function ($row) {
                return $row->session->title;
            })
            ->editColumn('phase_id', function ($row) {
                return $row->phase->title;
            })
            ->editColumn('course_id', function ($row) {
                return $row->course->title;
            })
            ->editColumn('department_id', function ($row) {
                return $row->department->title ?? 'N/A';
            })
            ->editColumn('type', function ($row) {
                if ($row->type == 2) {
                    return 'Visit';
                }
                if ($row->type == 3) {
                    return 'Clinical & Practical';
                }
                if ($row->type == 4) {
                    return 'Ward';
                }
                return 'Class & Exam';
            })
            ->addColumn('action', function ($row) {
                $actions = '';

                if (hasPermission('student_group/edit')) {
                    $actions .= '<a href="' . route('student_group.edit', [$row->id]) . '" class="m-portlet__nav-link btn m-btn m-btn--hover-brand m-btn--icon m-btn--icon-only m-btn--pill" title="Edit"><i class="flaticon-edit"></i></a>';
                }

                /*if (hasPermission('student_group/view')) {
                    $actions.= '<a href="' . route('student_group.show', [$row->id]) . '" class="m-portlet__nav-link btn m-btn m-btn--hover-brand m-btn--icon m-btn--icon-only m-btn--pill" title="View"><i class="flaticon-eye"></i></a>';
                }*/


                return $actions;
            })
            ->editColumn('status', function ($row) {
                return setStatus($row->status);
            })
            ->rawColumns(['status', 'action'])
            ->filter(function ($query) use ($request) {
                if (!empty($request->get('session_id'))) {
                    $query->where('session_id', $request->get('session_id'));
                }
                if (!empty($request->get('phase_id'))) {
                    $query->where('phase_id', $request->get('phase_id'));
                }
                if (!empty($request->get('course_id'))) {
                    $query->where('course_id', $request->get('course_id'));
                }
                if (!empty($request->get('department_id'))) {
                    $query->where('department_id', $request->get('department_id'));
                }
                if (!empty($request->get('group_name'))) {
                    $query->where('group_name', 'like', '%' . $request->get('group_name') . '%');
                }
                if (!empty($request->get('type'))) {
                    $query->where('type', $request->get('type'));
                }
            })
            ->make(true);
    }

    public function updateStudentGroup($request, $id)
    {
        $studentGroup = $this->find($id);

        if ($request->has('roll_range')) {
            $roll_start = $request->roll_from;
            $roll_end = $request->roll_to;
        } else if ($request->has('rolls')) {
            $roll_start = $request->rolls[array_key_first($request->rolls)];
            $roll_end = $request->rolls[array_key_last($request->rolls)];
        }

        DB::beginTransaction();
        try {
            $this->update([
                'session_id' => $request->session_id,
                'phase_id' => $request->phase_id,
                'course_id' => $request->course_id,
                'department_id' => $request->department_id,
                'group_name' => $request->title,
                'type' => $request->type,
                'roll_start' => $roll_start,
                'roll_end' => $roll_end,
                'old_student' => isset($request->is_old_students) ? 1 : 0,
                'status' => $request->status,
            ], $id);

            $studentGroup->students()->detach();

            if ($request->has('roll_range')) {
                for ($i = $request->roll_from; $i <= $request->roll_to; $i++) {
                    $student = $this->studentService->getStudentBySessionCourseAndRollNo($request->session_id, $request->course_id, $request->phase_id, $i);
                    if (!empty($student) && $student->batch_type_id == 1) {
                        $studentGroup->students()->attach($student->id, ['is_old' => 0]);
                    } elseif (!empty($student) && $student->batch_type_id == 2) {
                        $studentGroup->students()->attach($student->id, ['is_old' => 1]);
                    }
                }
            } else if ($request->has('rolls')) {
                foreach ($request->rolls as $roll) {
                    $student = $this->studentService->getStudentBySessionCourseAndRollNo($request->session_id, $request->course_id, $request->phase_id, $roll);
                    if (!empty($student) && $student->batch_type_id == 1) {
                        $studentGroup->students()->attach($student->id, ['is_old' => 0]);
                    } elseif (!empty($student) && $student->batch_type_id == 2) {
                        $studentGroup->students()->attach($student->id, ['is_old' => 1]);
                    }
                }
            }
            DB::commit();
            return $studentGroup;
        } catch (\Exception $e) {
            DB::rollBack();
            return $request->session()->flash('error', setMessage('update.error', 'Student Group'));
        }
    }

    public function listByStatus()
    {
        return $this->model->where('status', 1)->orderBy('group_name', 'asc')->pluck('group_name', 'id');
    }

    public function getMaxEndRollOfStudentGroup()
    {
        $maxEndRoll = $this->model->max('roll_end');
        return $maxEndRoll;
    }

    public function getStudentGroupsBySessionCourseAndGroupTypeId($sessionId, $courseId, $phaseId, $groupTypeId, $departmentId = null)
    {
        return $this->model->with('department')->where([
            ['session_id', $sessionId],
            ['course_id', $courseId],
            ['phase_id', $phaseId],
            ['status', 1],
        ])->when($groupTypeId != null, function ($query) use ($groupTypeId) {
            return $query->where('type', $groupTypeId);
        })->when($departmentId != null, function ($query) use ($departmentId) {
            if(is_array($departmentId)){
                return $query->whereIn('department_id', $departmentId);
            }
            return $query->where('department_id', $departmentId);
        })
            ->orderBy('department_id')
            ->orderBy('group_name')
            ->get();
    }
}
