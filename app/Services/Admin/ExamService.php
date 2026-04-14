<?php

namespace App\Services\Admin;

use App\Models\Exam;
use App\Models\ExamResult;
use App\Models\ExamSubject;
use App\Models\ExamSubjectMark;
use App\Models\ExamSubType;
use App\Services\BaseService;
use Carbon\Carbon;
use DataTables;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ExamService extends BaseService
{
    protected $examSubType;
    protected $examSubject;
    protected $examSubjectMark;
    protected $examResult;

    public function __construct(
        Exam       $exam, ExamSubType $examSubType, ExamSubject $examSubject, ExamSubjectMark $examSubjectMark,
        ExamResult $examResult
    )
    {
        $this->model = $exam;
        $this->examSubType = $examSubType;
        $this->examSubject = $examSubject;
        $this->examSubjectMark = $examSubjectMark;
        $this->examResult = $examResult;
    }

    public function getExamSubTypesBySubjectIdAndExamTypeId($subjectId, $examTypeId)
    {
        return $this->examSubType->where('exam_type_id', $examTypeId)
            ->whereHas('subjects', function ($q) use ($subjectId) {
                $q->where('id', $subjectId);
            })->get();
    }

    public function saveExam($request)
    {
        DB::beginTransaction();

        try {
            $exam = $this->create([
                'session_id' => $request->session_id,
                'course_id' => $request->course_id,
                'phase_id' => $request->phase_id,
                'term_id' => $request->term_id,
                'exam_category_id' => $request->exam_category_id,
                'title' => $request->title,
                'main_exam_id' => $request->exam_category_id == 5 ? $request->main_exam_id : null,
            ]);

            if (!is_null($request->subject_id)) {
                foreach ($request->subject_id as $key => $subject) {
                    if (is_null($subject)) {
                        DB::rollBack();
                        return 403;
                    }

                    if (empty($request->written_exam_sub_type[$key]) && empty($request->practical_exam_sub_type[$key])) {
                        DB::rollBack();
                        return 403;
                    }

                    $mainDate = $this->getMainDate($request, $key);
                    if ($mainDate === null) {
                        DB::rollBack();
                        return 403;
                    }

                    $examSubjectNew = $this->examSubject->create([
                        'exam_id' => $exam->id,
                        'subject_group_id' => $request->subject_group_id[$key],
                        'subject_id' => $subject,
                        'card_id' => checkEmpty($request->card_id[$key]),
                        'exam_type_id' => $request->exam_type_id[$key],
                        'exam_date' => checkEmpty($mainDate),
                        'exam_time' => checkEmpty($request->exam_time[$key]),
                    ]);

                    $this->createExamSubTypes($request, $examSubjectNew, $key);
                }

                DB::commit();
                return $exam;
            }

            if ($request->exam_category_id == 5 && $request->main_exam_id != null) {
                // Clone the main exam setup
                $cloneSuccess = $this->cloneExamSetup($request, $exam);

                if (!$cloneSuccess) {
                    DB::rollBack();
                    return response()->json(['message' => 'Failed to clone the exam setup.'], 500);
                }

                DB::commit();
                return $exam;
            }
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }

        return false;
    }

    private function cloneExamSetup($request, $newExam)
    {
        $mainExam = $this->model->with(['examSubjects.examSubTypes'])->find($request->main_exam_id);
        if (!$mainExam) {
            return false;
        }

        if ($mainExam->examSubjects->isEmpty()) {
            return false;
        }

        DB::beginTransaction();

        try {
            // Clone each subject of the main exam
            foreach ($mainExam->examSubjects as $mainSubject) {
                $clonedSubject = $this->examSubject->create([
                    'exam_id' => $newExam->id,
                    'subject_group_id' => $mainSubject->subject_group_id,
                    'subject_id' => $mainSubject->subject_id,
                    'card_id' => $mainSubject->card_id,
                    'exam_type_id' => $mainSubject->exam_type_id,
                    'exam_date' => $mainSubject->exam_date,
                    'exam_time' => $mainSubject->exam_time,
                ]);

                // Clone student groups for the subject
                $examSubjectStudentGroups = DB::table('exam_subject_student_groups')->where('exam_subject_id', $mainSubject->id)->get();
                foreach ($examSubjectStudentGroups as $subTypeStudentGroup) {
                    DB::table('exam_subject_student_groups')->insert([
                        'exam_subject_id' => $clonedSubject->id,
                        'exam_sub_type_id' => $subTypeStudentGroup->exam_sub_type_id,
                        'student_group_id' => $subTypeStudentGroup->student_group_id,
                        'exam_date' => $subTypeStudentGroup->exam_date,
                        'exam_time' => $subTypeStudentGroup->exam_time,
                        'created_at' => now(),
                    ]);
                }

                // Clone subtypes and their marks
                foreach ($mainSubject->examSubTypes->unique() as $subType) {
                    $mainMark = $this->examSubjectMark
                        ->where('exam_id', $mainExam->id)
                        ->where('subject_id', $mainSubject->subject_id)
                        ->where('exam_sub_type_id', $subType->id)
                        ->first();

                    if ($mainMark) {
                        $this->examSubjectMark->create([
                            'exam_id' => $newExam->id,
                            'subject_id' => $mainMark->subject_id,
                            'exam_sub_type_id' => $mainMark->exam_sub_type_id,
                            'total_marks' => $mainMark->total_marks,
                        ]);
                    }
                }
            }

            DB::commit();
            return true;
        } catch (\Exception $e) {
            DB::rollBack();
            return false;
        }
    }

    public function updateExam($request, $id)
    {
        $exam = $this->find($id);

        if (!$exam) {
            return false;
        }

        DB::beginTransaction();

        try {
            if ($request->status != $exam->status) {
                $this->update([
                    'status' => $request->status,
                ], $id);
                DB::commit();

                return true;
            }

            $this->update([
                'session_id' => $request->session_id,
                'course_id' => $request->course_id,
                'phase_id' => $request->phase_id,
                'term_id' => $request->term_id,
                'exam_category_id' => $request->exam_category_id,
                'title' => $request->title,
                'main_exam_id' => $request->exam_category_id == 5 ? $request->main_exam_id : null,
                'status' => $request->status,
            ], $id);

            if (!empty($request->exam_subject_id)) {
                foreach ($request->exam_subject_id as $examSubjectId) {
                    $examSubject = $this->examSubject->find($examSubjectId);
                    if ($examSubject) {
                        $examSubject->delete();
                    }
                }
            }
            if (!is_null($request->subject_id)) {
                foreach ($request->subject_id as $key => $subject) {
                    if (is_null($subject)) {
                        DB::rollBack();
                        return 403;
                    }

                    if (empty($request->written_exam_sub_type[$key]) && empty($request->practical_exam_sub_type[$key])) {
                        DB::rollBack();
                        return 403;
                    }

                    $mainDate = $this->getMainDate($request, $key);
                    if ($mainDate === null) {
                        DB::rollBack();
                        return 403;
                    }

                    $examSubjectNew = $this->examSubject->create([
                        'exam_id' => $exam->id,
                        'subject_group_id' => $request->subject_group_id[$key],
                        'subject_id' => $subject,
                        'card_id' => checkEmpty($request->card_id[$key]),
                        'exam_type_id' => $request->exam_type_id[$key],
                        'exam_date' => checkEmpty($mainDate),
                        'exam_time' => checkEmpty($request->exam_time[$key]),
                    ]);

                    $this->createExamSubTypes($request, $examSubjectNew, $key);
                }

                DB::commit();
                return $exam;
            }
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
        return false;
    }

    private function getMainDate($request, $key)
    {
        if (!empty($request->exam_date[$key])) {
            return $request->exam_date[$key];
        }

        if (!empty($request->written_exam_date[$key][0])) {
            return $request->written_exam_date[$key][0];
        }

        if (!empty($request->practical_exam_date[$key][0])) {
            return $request->practical_exam_date[$key][0];
        }

        return null;
    }

    private function createExamSubTypes($request, $examSubjectNew, $key)
    {
        if (!empty($request->written_exam_sub_type[$key])) {
            foreach ($request->written_exam_sub_type[$key] as $wSubTypeKey => $writtenSubTypes) {
                if (!empty($writtenSubTypes)) {
                    $subDate = $this->getSubDate($request->written_exam_date[$key][$wSubTypeKey]);
                    if ($examSubjectNew) {
                        DB::table('exam_subject_student_groups')->insert([
                            'exam_subject_id' => $examSubjectNew->id,
                            'exam_sub_type_id' => checkEmpty($writtenSubTypes),
                            'exam_date' => checkEmpty($subDate),
                            'exam_time' => checkEmpty($request->exam_time[$key]),
                            'created_at' => Carbon::now()
                        ]);
                    }
                }
            }
        }

        if (!empty($request->practical_exam_sub_type[$key])) {
            foreach ($request->practical_exam_sub_type[$key] as $pSubTypeKey => $practicalSubTypes) {
                if (!empty($practicalSubTypes)) {
                    $subDate = $this->getSubDate($request->practical_exam_date[$key][$pSubTypeKey]);
                    if ($examSubjectNew) {
                        DB::table('exam_subject_student_groups')->insert([
                            'exam_subject_id' => $examSubjectNew->id,
                            'exam_sub_type_id' => checkEmpty($practicalSubTypes),
                            'student_group_id' => checkEmpty($request->practical_student_groups[$key][$pSubTypeKey]),
                            'exam_date' => checkEmpty($subDate),
                            'exam_time' => checkEmpty($request->exam_time[$key]),
                            'created_at' => Carbon::now()
                        ]);
                    }
                }
            }
        }
    }

    private function getSubDate($date)
    {
        return !empty($date) ? Carbon::createFromFormat('d/m/Y', $date)->format('Y-m-d') : '';
    }

    public function getExamsDatatable($request)
    {
        $query = $this->model->with('course', 'phase', 'term', 'examCategory', 'examSubjects')->latest();

        if (Auth::guard('web')->check()) {
            $user = Auth::guard('web')->user();
            if ($user->user_group_id == 4 || $user->user_group_id == 11 || $user->user_group_id == 12) {
                $query = $query->whereHas('examSubjects', function ($q) use ($user) {
                    $q->whereIn('subject_id', getSubjectsIdByTeacherId($user->teacher->id, $user->teacher->course_id));
                });
            }
        } elseif (Auth::guard('student_parent')->check()) {
            $user = Auth::guard('student_parent')->user();
            if ($user->user_group_id == 5) {
                $student = $user->student;
            } elseif ($user->user_group_id == 6) {
                $student = $user->parent->students->first();
            }
            $query = $query->where([
                ['session_id', $student->session_id],
                ['course_id', $student->course_id],
                ['phase_id', $student->phase_id],
                ['status', 1],
            ]);
        }

        return Datatables::of($query)
            ->editColumn('course_id', function ($row) {
                return $row->course->title;
            })
            ->editColumn('phase_id', function ($row) {
                return $row->phase->title;
            })
            ->editColumn('term_id', function ($row) {
                return $row->term->title;
            })
            ->editColumn('exam_category_id', function ($row) {
                return $row->examCategory->title;
            })
            ->addColumn('session_id', function ($row) {
                return $row->session->title;
            })
            ->editColumn('status', function ($row) {
                return setStatus($row->status);
            })
            ->addColumn('action', function ($row) {
                $checkResultPublished = $row->examSubjects->where('result_published', 1);
                $actions = '';

                if (hasPermission('exams/edit') && Auth::guard('web')->check() && empty($checkResultPublished->toArray())) {
                    $user = Auth::guard('web')->user();
                    $statusIcon = $row->status ? 'fa fa-toggle-on' : 'fa fa-toggle-off';
                    $statusTitle = $row->status ? 'Deactivate' : 'Activate';
                    $statusButton = '<button data-id="' . $row->id . '" class="m-portlet__nav-link btn m-btn m-btn--hover-brand m-btn--icon m-btn--icon-only m-btn--pill toggle-status" title="' . $statusTitle . '">
                                                    <i class="' . $statusIcon . '"></i>
                                                  </button>';
                    $editButton = '<a href="' . route('exams.edit', [$row->id]) . '" class="m-portlet__nav-link btn m-btn m-btn--hover-brand m-btn--icon m-btn--icon-only m-btn--pill" title="Edit"><i class="flaticon-edit"></i></a>';


                    if ($user->user_group_id == 4  && !empty($row->examSubjects->whereIn('subject_id', getSubjectsIdByTeacherId($user->teacher->id, $user->teacher->course_id))->toArray())) {
                        $actions .= $statusButton;
                        if ($row->exam_category_id != 5) {
                            $actions .= $editButton;
                        }
                    } else {
                        $actions .= $statusButton;
                        if ($row->exam_category_id != 5) {
                            $actions .= $editButton;
                        }
                    }
                }

                if (getAppPrefix() == 'admin') {
                    if (hasPermission('exams/view')) {
                        $actions .= '<a href="' . route('exams.view', [$row->id]) . '" class="m-portlet__nav-link btn m-btn m-btn--hover-brand m-btn--icon m-btn--icon-only m-btn--pill" title="View"><i class="flaticon-eye"></i></a>';
                    }
                } else if (hasPermission('exams/view')) {
                    $actions .= '<a href="' . route('frontend.exams.view', [$row->id]) . '" class="m-portlet__nav-link btn m-btn m-btn--hover-brand m-btn--icon m-btn--icon-only m-btn--pill" title="View"><i class="flaticon-eye"></i></a>';
                }

                if (hasPermission('exams/edit') && $row->exam_category_id != 1 && Auth::guard('web')->check()) {
                    $user = Auth::guard('web')->user();
                    if ($user->user_group_id == 4) {
                        if (empty($checkResultPublished->toArray()) && !empty($row->examSubjects->whereIn('subject_id', getSubjectsIdByTeacherId($user->teacher->id, $user->teacher->course_id))->toArray())) {
                            $actions .= '<a href="' . route('exams.mark.setup', [$row->id]) . '" class="m-portlet__nav-link btn m-btn m-btn--hover-brand m-btn--icon m-btn--icon-only m-btn--pill" title="Marks Setup"><i class="fa fa-cog"></i></a>';
                        }
                    } else if (empty($checkResultPublished->toArray())) {
                        $actions .= '<a href="' . route('exams.mark.setup', [$row->id]) . '" class="m-portlet__nav-link btn m-btn m-btn--hover-brand m-btn--icon m-btn--icon-only m-btn--pill" title="Marks Setup"><i class="fa fa-cog"></i></a>';
                    }
                }

                if (hasPermission('exams/delete') && empty($checkResultPublished->toArray())) {
                    $actions .= '<a href="javascript:void(0)" class="btn m-btn m-btn--icon m-btn--icon-only exam-delete" data-exam-id="' . $row->id . '" title="Delete"><i class="fa fa-trash-alt"></i></a>';
                }

                return $actions;
            })
            ->rawColumns(['status', 'action'])
            ->filter(function ($query) use ($request) {
                if (Auth::guard('student_parent')->check()) {
                    $user = Auth::guard('student_parent')->user();
                    if ($user->user_group_id == 5) {
                        $query = $query->where('session_id', $user->student->session_id);
                        $query = $query->where('course_id', $user->student->course_id);
                    }
                } else {
                    if (!empty($request->get('session_id'))) {
                        $query->where('session_id', $request->get('session_id'));
                    }
                }

                if (!empty($request->get('course_id'))) {
                    $query->where('course_id', $request->get('course_id'));
                }
                if (!empty($request->get('phase_id'))) {
                    $query->where('phase_id', $request->get('phase_id'));
                }
                if (!empty($request->get('term_id'))) {
                    $query->where('term_id', $request->get('term_id'));
                }

                if (!empty($request->get('exam_category_id'))) {
                    $query->where('exam_category_id', $request->get('exam_category_id'));
                }

                $fromDate = $request->get('from_date');
                $toDate = $request->get('to_date');
                if (!empty($fromDate) && !empty($toDate)) {
                    $fromDate = Carbon::createFromFormat('d/m/Y', $fromDate)->format('Y-m-d');
                    $toDate = Carbon::createFromFormat('d/m/Y', $toDate)->format('Y-m-d');
                    $query->whereBetween('created_at', [$fromDate, $toDate]);
                } elseif (!empty($fromDate)) {
                    $fromDate = Carbon::createFromFormat('d/m/Y', $fromDate)->format('Y-m-d');
                    $query->whereDate('created_at', '>=', $fromDate);
                } elseif (!empty($toDate)) {
                    $toDate = Carbon::createFromFormat('d/m/Y', $toDate)->format('Y-m-d');
                    $query->whereDate('created_at', '>=', $toDate);
                }
            })
            ->make(true);
    }

    public function getWrittenExamsByExamId($examId)
    {
        $query = $this->examSubject
            ->where('exam_id', $examId)
            ->whereIn('exam_type_id', [1, 3])
            ->with('subject', 'examSubTypes')
            ->orderBy('exam_date', 'ASC')
            ->get();

        return $query;
    }

    public function getPracticalExamsByExamId($examId)
    {
        $query = $this->examSubject
            ->where('exam_id', $examId)
            ->whereIn('exam_type_id', [4, 5, 6])
            ->with('subject', 'examSubTypes')
            ->orderBy('exam_date', 'ASC')
            ->get();

        return $query;
    }

    public function saveExamMarks($request, $examId)
    {
        $subject_id = array();
        $sub_type_id = array();
        foreach ($request->subject_id as $subjectId) {
            $subject_id[] = $subjectId;
            if (!empty($request->sub_type_id[$subjectId])) {
                foreach ($request->sub_type_id[$subjectId] as $key => $subType) {
                    $sub_type_id[] = $subType;
                    $check = $this->examSubjectMark->where('exam_id', $examId)->where('subject_id', $subjectId)->where('exam_sub_type_id', $subType)->first();
                    if (!empty($check)) {
                        $examMarks = $this->examSubjectMark->find($check->id)->update([
                            'exam_id' => $examId,
                            'subject_id' => $subjectId,
                            'exam_sub_type_id' => $subType,
                            'total_marks' => $request->marks[$subjectId][$key],
                        ]);
                    } else {
                        $examMarks = $this->examSubjectMark->create([
                            'exam_id' => $examId,
                            'subject_id' => $subjectId,
                            'exam_sub_type_id' => $subType,
                            'total_marks' => $request->marks[$subjectId][$key],
                        ]);
                    }
                }
            }
        }
        if ($examId) {
            try {
                $this->examSubjectMark->where('exam_id', $examId)
                    ->whereIn('subject_id', $subject_id)
                    ->whereNotIn('exam_sub_type_id', $sub_type_id)
                    ->forcedelete();
                return $examMarks;
            } catch (\Exception $e) {
                return $examMarks;
            }
        }
        return $examMarks;
    }

    public function getAllExamBySearchCriteria($sessionId, $courseId, $subjectGroupId, $startDate, $endDate)
    {
        return $this->model->whereHas('examSubjects', function ($query) use ($subjectGroupId, $startDate, $endDate) {
            $query->where('subject_group_id', $subjectGroupId)->whereBetween('exam_date', [$startDate, $endDate]);
        })->where([
            ['session_id', $sessionId],
            ['course_id', $courseId],
            ['status', 1],
        ])->get();
    }

    public function getExamsByCourseIdPhaseId($courseId, $phaseId, $sessionId)
    {
        return $this->model->where('session_id', $sessionId)
            ->where('course_id', $courseId)
            ->where('phase_id', $phaseId)
            ->where('exam_category_id', 7)
            ->where('status', 1)
            ->with([
                'examSubjects' => function ($q) {
                    $q->where('result_published', 1)
                        ->orderBy('subject_id', 'ASC');
                }
            ])
            ->orderBy('id', 'ASC')
            ->get();
    }

    public function getExamsByCourseIdPhaseIdGroup($courseId, $phaseId, $sessionId)
    {
        return DB::table('exams')
            ->join('exam_subjects', 'exams.id', '=', 'exam_subjects.exam_id')
            ->select('exams.id', 'exams.title', 'exam_subjects.subject_id', 'exam_subjects.subject_group_id')
            ->where('exams.session_id', '=', $sessionId)
            ->where('exams.course_id', '=', $courseId)
            ->where('exams.phase_id', '=', $phaseId)
            ->where('exams.exam_category_id', 7)
            ->where('exams.status', 1)
            ->where('exam_subjects.result_published', 1)
            ->orderBy('exam_subjects.subject_id', 'ASC')
            ->get()->toArray();
    }

    public function getSubjectsBySessionCoursePhaseAndExamCategoryId($sessionId, $courseId, $phaseId, $categoryId)
    {
        return $this->examSubject->whereHas('exam', function ($q) use ($sessionId, $courseId, $phaseId, $categoryId) {
            $q->where('session_id', $sessionId)->where('course_id', $courseId)->where('phase_id', $phaseId)->where('exam_category_id', $categoryId);
        })->with('subjectGroup')
            ->groupBy('subject_group_id')->get();
    }

    public function checkResultIsPublishedByExamAndSubjectId($examId, $subjectId)
    {
        $query = $this->examResult->whereHas('examSubjectMark', function ($q) use ($subjectId, $examId) {
            $q->where('subject_id', $subjectId)->where('exam_id', $examId);
        })->count();

        return $query;
    }

    public function getUpcomingExamsByCourseIdPhaseInAndMonths($courseId, $phaseId, $months, $sessionId = '')
    {
        $nextDate = Carbon::now()->addMonth($months);

        $query = $this->examSubject->whereHas('exam', function ($q) use ($courseId, $phaseId, $nextDate, $sessionId) {
            $q->where('course_id', $courseId)->where('phase_id', $phaseId)->where('session_id', $sessionId);
        })->whereDate('exam_date', '>=', now())->whereDate('exam_date', '<=', $nextDate)
            ->with('exam.session', 'exam.phase', 'exam.term', 'subject');

        return Datatables::of($query)
            ->addColumn('title', function ($row) {
                return $row->exam->title;
            })
            ->editColumn('subject_id', function ($row) {
                return $row->subject->title;
            })
            ->editColumn('phase_id', function ($row) {
                return $row->exam->phase->title;
            })
            ->editColumn('term_id', function ($row) {
                return $row->exam->term->title;
            })
            ->editColumn('session_id', function ($row) {
                return $row->exam->session->title;
            })
            ->editColumn('exam_time', function ($row) {
                if (isset($row->exam_time)) {
                    return parseClassTimeInTwelveHours($row->exam_time);
                }
            })
            ->addColumn('action', function ($row) {
                $checkResultPublished = $row->where('result_published', 1)->get();
                $actions = '';

                if (getAppPrefix() == 'admin') {
                    if (hasPermission('exams/view')) {
                        $actions .= '<a href="' . route('exams.view', [$row->exam->id]) . '" class="m-portlet__nav-link btn m-btn m-btn--hover-brand m-btn--icon m-btn--icon-only m-btn--pill" title="Edit"><i class="flaticon-eye"></i></a>';
                    }
                } else if (hasPermission('exams/view')) {
                    $actions .= '<a href="' . route('frontend.exams.view', [$row->exam->id]) . '" class="m-portlet__nav-link btn m-btn m-btn--hover-brand m-btn--icon m-btn--icon-only m-btn--pill" title="Edit"><i class="flaticon-eye"></i></a>';
                }

                if (hasPermission('exams/edit') && Auth::guard('web')->check() && empty($checkResultPublished->toArray())) {
                    $user = Auth::guard('web')->user();
                    if (($row->exam_category_id != 5) && ($user->user_group_id == 4) && !empty($row->whereIn('subject_id', getSubjectsIdByTeacherId($user->teacher->id, $user->teacher->course_id))->toArray())) {
                        $actions .= '<a href="' . route('exams.edit', [$row->exam->id]) . '" class="m-portlet__nav-link btn m-btn m-btn--hover-brand m-btn--icon m-btn--icon-only m-btn--pill" title="Edit"><i class="flaticon-edit"></i></a>';
                    } else if ($row->exam_category_id != 5) {
                        $actions .= '<a href="' . route('exams.edit', [$row->exam->id]) . '" class="m-portlet__nav-link btn m-btn m-btn--hover-brand m-btn--icon m-btn--icon-only m-btn--pill" title="Edit"><i class="flaticon-edit"></i></a>';
                    }
                }

                if (hasPermission('result/create') && Auth::guard('web')->check()) {
                    $user = Auth::guard('web')->user();
                    if ($user->user_group_id == 4) {
                        if (empty($checkResultPublished->toArray()) && !empty($row->whereIn('subject_id', getSubjectsIdByTeacherId($user->teacher->id, $user->teacher->course_id))->toArray())) {
                            $actions .= '<a href="' . route('exams.mark.setup', [$row->exam->id]) . '" class="m-portlet__nav-link btn m-btn m-btn--hover-brand m-btn--icon m-btn--icon-only m-btn--pill" title="Marks Setup"><i class="fa fa-cog"></i></a>';
                        }
                    } else if (empty($checkResultPublished->toArray())) {
                        $actions .= '<a href="' . route('exams.mark.setup', [$row->exam->id]) . '" class="m-portlet__nav-link btn m-btn m-btn--hover-brand m-btn--icon m-btn--icon-only m-btn--pill" title="Marks Setup"><i class="fa fa-cog"></i></a>';
                    }
                }

                return $actions;
            })
            ->rawColumns(['action'])
            ->make(true);
    }

    public function check_marks_is_entered($examId)
    {
        $results = $this->examSubjectMark->join('exam_results', 'exam_results.exam_subject_mark_id', '=', 'exam_subject_marks.id')->where('exam_id', $examId)->first();
        if ($results) {
            return true;
        }
        return false;
    }

    public function checkExamBySessionCoursePhaseTermCategorySubject($request)
    {
        return $this->model->with('examSubjects')
            ->where('session_id', $request->sessionId)
            ->where('course_id', $request->courseId)
            ->where('phase_id', $request->phaseId)
            ->where('term_id', $request->termId)
            ->where('exam_category_id', $request->categoryId)
            ->where('status', 1)
            ->whereHas('examSubjects', function ($query) use ($request) {
                $query->where('subject_id', $request->subjectId)
                    ->where('exam_type_id', $request->examTypeId);
            })->first();
    }
}
