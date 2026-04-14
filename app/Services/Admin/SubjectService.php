<?php

namespace App\Services\Admin;

use App\Models\Book;
use App\Models\Card;
use App\Models\ClassRoutine;
use App\Models\ExamSubType;
use App\Models\SessionDetail;
use App\Models\SessionPhaseDetail;
use App\Models\Subject;
use App\Models\SubjectGroup;
use App\Services\BaseService;
use DataTables;
use function foo\func;
use Illuminate\Support\Facades\Auth;

/**
 * Class UserService
 * @package App\Services\Admin
 */
class SubjectService extends BaseService
{

    /**
     * @var $model
     */
    protected $model;
    protected $subjectGroup;
    protected $sessionPhaseDetail;
    protected $bookModel;
    protected $classRoutine;
    protected $sessionDetail;
    protected $cardModel;

    /**
     * @var string
     */
    protected $url = 'admin/subject';

    public function __construct(
        Subject $subject, SubjectGroup $subjectGroup, SessionPhaseDetail $sessionPhaseDetail, Book $book, ClassRoutine $classRoutine,
        SessionDetail $sessionDetail, Card $card
    )
    {
        $this->model = $subject;
        $this->subjectGroup = $subjectGroup;
        $this->sessionPhaseDetail = $sessionPhaseDetail;
        $this->bookModel = $book;
        $this->classRoutine = $classRoutine;
        $this->sessionDetail = $sessionDetail;
        $this->cardModel = $card;
    }

    /**
     *
     * @return JsonResponse
     */
    public function getAllData($request)
    {
        $query = $this->model->with(['subjectGroup', 'subjectGroup.course'])->select();

        if (Auth::guard('web')->check()) {
            $user = Auth::guard('web')->user();
            if ($user->teacher) {
                $query = $query->whereIn('id', getSubjectsIdByTeacherId($user->teacher->id, $user->teacher->course_id));
            }
        } elseif (Auth::guard('student_parent')->check()) {
            $user = Auth::guard('student_parent')->user();
            //if login user is student
            if ($user->student) {
                //get subject id by student course id
                $subjectIds = $this->model->whereHas('subjectGroup', function ($q) use ($user) {
                    $q->where('course_id', $user->student->course_id);
                })->pluck('id');
            } //if login user is parent
            elseif ($user->parent) {
                $subjectIds = $this->model->whereHas('subjectGroup', function ($q) use ($user) {
                    $q->where('course_id', $user->parent->students->first()->course_id);
                })->pluck('id');
            }
            $query = $query->whereIn('id', $subjectIds);
        }

        return Datatables::of($query)
            ->addColumn('action', function ($row) {
                $actions = '';

                if (hasPermission('subject/edit')) {
                    $actions .= '<a href="' . route('subject.edit', [$row->id]) . '" class="m-portlet__nav-link btn m-btn m-btn--hover-brand m-btn--icon m-btn--icon-only m-btn--pill" title="Edit"><i class="flaticon-edit"></i></a>';
                }
                if (hasPermission('subject/view')) {
                    $actions .= '<a href="' . route(customRoute('subject.show'), [$row->id]) . '" class="m-portlet__nav-link btn m-btn m-btn--hover-brand m-btn--icon m-btn--icon-only m-btn--pill" title="View"><i class="flaticon-eye"></i></a>';
                } else {
                    $actions .= '--';
                }
                return $actions;
            })
            ->addColumn('course_id', function ($row) {
                return isset($row->subjectGroup->course) ? $row->subjectGroup->course->title : '';
            })
            ->editColumn('subject_group_id', function ($row) {
                return isset($row->subjectGroup) ? $row->subjectGroup->title : '';
            })
            ->editColumn('status', function ($row) {
                return setStatus($row->status);
            })
            ->rawColumns(['status', 'action'])
            ->filter(function ($query) use ($request) {
                if (!empty($request->get('subject_group_id'))) {
                    $query->where('subject_group_id', $request->get('subject_group_id'));
                }
                if ($request->get('title')) {
                    $query->where('title', 'like', '%' . $request->get('title') . '%');
                }

                if (!empty($request->get('code'))) {
                    $query->where('code', $request->get('code'));
                }
                if (!empty($request->get('status'))) {
                    $query->where('status', $request->get('status'));
                }
            })
            ->make(true);
    }

    public function getLists($course)
    {
        return $this->model->whereHas('subjectGroup', function ($q) use ($course) {
            $q->where('course_id', $course);
        })
                           ->where('status', 1)
                           ->orderBy('code', 'asc')
                           ->pluck('title', 'id');
    }

    public function saveSubject($request)
    {
        //receive subject related data
        $subjectData = [
            'subject_group_id' => $request['subject_group_id'],
            'department_id' => $request['department_id'],
            'title' => $request['title'],
            'code' => $request['code'],
            /*'status' => $request['status'],*/

        ];

        //save subject related data to table
        $subject = $this->model->create($subjectData);

        //save category
        /*if (!empty($request->examCategories)) {
            foreach ($request->examCategories as $examCategory) {
                $subject->examCategories()->attach($examCategory);
            }
            unset($examCategory);
        }*/

        //save exam sub type
        if (!empty($request->examSubTypes)) {
            foreach ($request->examSubTypes as $examSubType) {
                $subject->examSubTypes()->attach($examSubType);
            }
            unset($examSubType);
        }

        return $subject;
    }

    public function updateSubject($request, $id)
    {
        //update subject related data

        $this->update([
            'subject_group_id' => $request['subject_group_id'],
            'department_id' => $request['department_id'],
            'title' => $request['title'],
            'code' => $request['code'],
            'status' => $request['status'],
        ], $id);

        $subject = $this->find($id);

        //update category
        /*if (!empty($request['examCategories'])) {
            $subject->examCategories()->detach();
            foreach ($request['examCategories'] as $examCategory) {
                $subject->examCategories()->attach($examCategory);
            }
            unset($examCategory);
        }*/

        //update exam sub type

        if (!empty($request['examSubTypes'])) {
            $subject->examSubTypes()->detach();
            foreach ($request['examSubTypes'] as $examSubType) {
                $subject->examSubTypes()->attach($examSubType);
            }
            unset($examSubType);
        }

        return $subject;
    }

    //get all subject list
    public function getAllSubject()
    {
        $query = $this->model->where('status', 1);

        if (Auth::guard('web')->check()) {
            $user = Auth::guard('web')->user();
            if ($user->teacher) {
                $query = $query->whereIn('id', getSubjectsIdByTeacherId($user->teacher->id, $user->teacher->course_id));
            }
        } elseif (Auth::guard('student_parent')->check()) {
            $user = Auth::guard('student_parent')->user();
            //if login user is student
            if ($user->student) {
                $query = $query->whereIn('id', getSubjectsIdByCourseId($user->student->course_id));
            } //if login user is parent
            elseif ($user->parent) {
                $query = $query->whereIn('id', getSubjectsIdByCourseId($user->parent->students->first()->course_id));
            }
        }

        return $query->get();
    }

    public function getSubjectsBySessionIdCourseIdPhaseId($sessionId, $courseId, $phaseId)
    {
        $query = $this->model->where('status', 1)
                             ->whereHas('sessionPhase', function ($query) use ($sessionId, $courseId, $phaseId) {
                                 $query->where('phase_id', $phaseId)
                                       ->whereHas('sessionDetail', function ($query) use ($sessionId, $courseId) {
                                           $query->where('session_id', $sessionId)->where('course_id', $courseId);
                                       });
                             });

        // if the login user is a teacher, then he gets the subject related to his department
        if (Auth::guard('web')->check()) {
            $user = Auth::guard('web')->user();

            if ($user->teacher) {
                $teacherDepartmentId = $user->teacher->department_id;
                $query->whereHas('department', function ($q) use ($teacherDepartmentId) {
                    $q->where('id', $teacherDepartmentId);
                });
            }
        }

        return $query->get();
    }

    public function getCourseSubjectGroupsBySessionIdCourseIdPhaseId($sessionId, $courseId, $phaseId){

        $query = $this->subjectGroup->whereHas('subjects', function ($query) use($sessionId, $courseId, $phaseId){
            $query->whereHas('sessionPhase', function($query) use($sessionId, $courseId, $phaseId){
                $query->where('phase_id', $phaseId)->whereHas('sessionDetail', function($query) use($sessionId, $courseId){
                    $query->where('session_id', $sessionId)->where('course_id', $courseId);
                });
            });

            // if the login user is teacher then he gets the subject related to his department
            if (Auth::guard('web')->check() and Auth::user()->teacher){
                $user = Auth::guard('web')->user();
                if ($user->teacher){
                    $teacherDepartmentId = $user->teacher->department_id;
                    $query = $query->whereHas('department', function ($q) use($teacherDepartmentId) {
                        $q->where('department_id', $teacherDepartmentId);

                    });
                }
            }
        });

        return $query->get();
    }

    public function getSubjectsByCourseId($sessionId, $courseId)
    {
        $query = $this->model->where('status', 1)->whereHas('sessionPhase', function ($q) use ($sessionId, $courseId) {
            $q->whereHas('sessionDetail', function ($q) use ($sessionId, $courseId) {
                $q->where('session_id', $sessionId)->where('course_id', $courseId);
            });
        });

        if (Auth::guard('web')->check()) {
            $user = Auth::guard('web')->user();

            if ($user->teacher) {
                $teacherDepartmentId = $user->teacher->department_id;
                $query = $query->whereHas('department', function ($q) use ($teacherDepartmentId) {
                    $q->where('id', $teacherDepartmentId);
                });
            }
        }

        return $query->get();
    }

    public function getSubjectsByGroupIdAndCourseId($sessionId, $courseId, $groupId)
    {
        $query = $this->model->where('status', 1)->whereHas('sessionPhase', function ($q) use ($sessionId, $courseId) {
            $q->whereHas('sessionDetail', function ($q) use ($sessionId, $courseId) {
                $q->where('session_id', $sessionId)->where('course_id', $courseId);
            });
        })->whereHas('subjectGroup', function ($q) use ($groupId) {
            $q->where('id', $groupId)->where('status', 1);
        })->orderBy('title');

        if (Auth::guard('web')->check()) {
            $user = Auth::guard('web')->user();

            if ($user->teacher) {
                $teacherDepartmentId = $user->teacher->department_id;
                $query = $query->whereHas('department', function ($q) use ($teacherDepartmentId) {
                    $q->where('id', $teacherDepartmentId);
                });
            }
        }

        return $query->get();
    }

    public function getPhasesBySubjectGroupId($subjectGroupId, $sessionId, $courseId)
    {
        return $this->sessionPhaseDetail->whereHas('sessionDetail', function ($q) use ($sessionId, $courseId) {
            $q->where('session_id', $sessionId)->where('course_id', $courseId);
        })->whereHas('subjects', function ($q) use ($subjectGroupId) {
            $q->where('subject_group_id', $subjectGroupId)->where('status', 1);
        })->get();
    }

    public function getAllBookBySearchCriteria($subjectGroupId)
    {

        $books = $this->bookModel->where('status', 1)
                                 ->whereHas('subject', function ($q) use ($subjectGroupId) {
                                     $q->where('subject_group_id', $subjectGroupId)->where('status', 1);
                                 })->get();

        return $books;
    }

    public function getTotalSubjectsByCourseId($courseId)
    {
        return $this->model->where('status', 1)
                           ->whereHas('subjectGroup', function ($q) use ($courseId) {
                               $q->where('course_id', $courseId);
                           })->count();
    }

    public function lists()
    {
        $query = $this->model->orderBy('title', 'asc');

        if (Auth::guard('web')->check()) {
            $user = Auth::guard('web')->user();
            if ($user->teacher) {
                $query = $query->whereIn('id', getSubjectsIdByTeacherId($user->teacher->id, $user->teacher->course_id));
            }
        }

        return $query->pluck('title', 'id');
    }

    public function listByStatus()
    {
        $query = $this->model->where('status', 1);
        if (Auth::guard('web')->check()) {
            $user = Auth::guard('web')->user();
            if ($user->teacher) {
                $query = $query->whereIn('id', getSubjectsIdByTeacherId($user->teacher->id, $user->teacher->course_id));
            }
        }

        return $query->orderBy('title', 'asc')->pluck('title', 'id');
    }

    public function getAllSubjectByCourseIdAndSubjectGroupId($courseId, $subjectGroupId)
    {
        $query = $this->model->where('status', 1)
                             ->whereHas('subjectGroup', function ($query) use ($subjectGroupId) {
                                 $query->where('id', $subjectGroupId)->where('status', 1);
                             })->whereHas('subjectGroup.course', function ($query) use ($courseId) {
                $query->where('id', $courseId);
            });

        if (Auth::guard('web')->check()) {
            $user = Auth::guard('web')->user();

            if ($user->teacher) {
                $teacherDepartmentId = $user->teacher->department_id;
                $query = $query->whereHas('department', function ($q) use ($teacherDepartmentId) {
                    $q->where('id', $teacherDepartmentId);
                });
            }
        }

        return $query->get();
    }

    public function getSubjectsByCourseIdPhaseId($courseId, $phaseId)
    {
        $result = [];
        $routine = $this->classRoutine->where('status', 1)->where('course_id', $courseId)->where('phase_id', $phaseId)->latest()->first();
        if (!empty($routine)) {
            $sessionId = $routine->session_id;
        } else {
            $sessionDetail = $this->sessionDetail->where('course_id', $courseId)->whereHas('sessionPhaseDetails', function ($q) use ($phaseId) {
                $q->where('phase_id', $phaseId);
            })->first();
            if (!empty($sessionDetail)) {
                $sessionId = $sessionDetail->session_id;
            }
        }

        if (!empty($sessionId)) {
            $query = $this->model->where('status', 1)->whereHas('sessionPhase', function ($query) use ($sessionId, $courseId, $phaseId) {
                $query->where('phase_id', $phaseId)->whereHas('sessionDetail', function ($query) use ($sessionId, $courseId) {
                    $query->where('session_id', $sessionId)->where('course_id', $courseId);
                });
            });
            $result = $query->get();
        }
        return $result;
    }

    public function getSubjectsByCourseIdPhaseIdWithCards($courseId, $phaseId)
    {
        $routine = $this->classRoutine->where('status', 1)->where('course_id', $courseId)->where('phase_id', $phaseId)->latest()->first();
        if (!empty($routine)) {
            $sessionId = $routine->session_id;
        } else {
            $sessionDetail = $this->sessionDetail->where('course_id', $courseId)->whereHas('sessionPhaseDetails', function ($q) use ($phaseId) {
                $q->where('phase_id', $phaseId);
            })->first();
            $sessionId = $sessionDetail->session_id;
        }

        $query = $this->model->where('status', 1)->whereHas('sessionPhase', function ($query) use ($sessionId, $courseId, $phaseId) {
            $query->where('phase_id', $phaseId)->whereHas('sessionDetail', function ($query) use ($sessionId, $courseId) {
                $query->where('session_id', $sessionId)->where('course_id', $courseId);
            });
        })->has('cards');

        return $query->get();
    }

    public function getSubjectsBySessionCoursePhaseTermId($sessionId, $courseId, $phaseId)
    {
        return $this->model->where('status', 1)->whereHas('classRoutines', function ($query) use ($sessionId, $courseId, $phaseId) {
            $query->where([
                ['session_id', $sessionId],
                ['course_id', $courseId],
                ['phase_id', $phaseId],
            ]);
        })->get();
    }

    public function getSubjectsBySubjectIds(array $subejcts)
    {
        return $this->model->where('status', 1)->whereIn('id', $subejcts)->get();
    }

}
