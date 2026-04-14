<?php
/**
 * Created by PhpStorm.
 * User: office
 * Date: 3/22/19
 * Time: 4:24 PM
 */

namespace App\Services;

use App\Events\NotifyParentsWhenExamResultAnnounced;
use App\Events\NotifyUserWhenExamResultAnnounced;
use App\Imports\ResultImport;
use App\Models\Department;
use App\Models\ExamResult;
use App\Models\ExamSubject;
use App\Models\ExamSubjectMark;
use App\Models\PhasePromotionHistory;
use App\Models\Student;
use App\Models\Subject;
use Carbon\Carbon;
use DataTables;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Facades\Excel;
use Setting;

class ResultService extends BaseService
{

    protected $examSubject;
    protected $examSubjectMark;
    protected $phasePromotionHistory;
    protected $subjectModel;

    public function __construct(ExamResult $examResult, ExamSubject $examSubject, ExamSubjectMark $examSubjectMark, PhasePromotionHistory $phasePromotionHistory, Subject $subject)
    {
        $this->model = $examResult;
        $this->examSubject = $examSubject;
        $this->examSubjectMark = $examSubjectMark;
        $this->phasePromotionHistory = $phasePromotionHistory;
        $this->subjectModel = $subject;
    }

    public function getPassStatus($mark, $mId, $passPercentage)
    {
        return $this->calculatePassStatus($mark, $mId, $passPercentage);
    }

    public function processResult($insertedResultIds)
    {
        return $this->processResultStatusAfterProvidingExamSubTypeMarksNew($insertedResultIds);
    }
    public function getDatatable($request)
    {
        $query = $this->examSubject->with('exam.session', 'exam.course', 'exam.phase', 'exam.term', 'exam.examCategory', 'subject', 'exam.examMarks')
            ->whereHas('exam', function ($query) use ($request) {
                $query->where('status', 1);
            })
            ->groupBy('exam_id')->groupBy('subject_id');

        if (Auth::guard('web')->check()) {
            $user = Auth::guard('web')->user();
            if ($user->teacher) {
                $query = $query->whereIn('subject_id', getSubjectsIdByTeacherId($user->teacher->id, $user->teacher->course_id));
            }
        } elseif (Auth::guard('student_parent')->check()) {
            $user = Auth::guard('student_parent')->user();
            //if login user is student
            if ($user->student) {
                //get subject id by student course id
                $subjectIds = $this->subjectModel->whereHas('subjectGroup', function ($q) use ($user) {
                    $q->where('course_id', $user->student->course_id);
                })->pluck('id');
                $session = $user->student->followed_by_session_id;
            } //if login user is parent
            elseif ($user->parent) {
                $subjectIds = $this->subjectModel->whereHas('subjectGroup', function ($q) use ($user) {
                    $q->where('course_id', $user->parent->students->first()->course_id);
                })->pluck('id');
                $session = $user->parent->students->first()->followed_by_session_id;
            }
            $query = $query->whereIn('subject_id', $subjectIds)
                ->where('result_published', 1)
                ->whereHas('exam', function ($q) use ($session) {
                    $q->where('session_id', $session);
                });
        }
        $query->orderBy('id', 'desc')->get();

        return Datatables::of($query)
            ->addColumn('subject_id', function ($row) {
                return isset($row->subject) ? $row->subject->title : '';
            })
            ->addColumn('title', function ($row) {
                return isset($row->exam) ? $row->exam->title : '';
            })
            ->addColumn('exam_category_id', function ($row) {
                return isset($row->exam->examCategory) ? $row->exam->examCategory->title : '';
            })
            ->addColumn('session_id', function ($row) {
                return isset($row->exam->session) ? $row->exam->session->title : '';
            })
            ->addColumn('course_id', function ($row) {
                return isset($row->exam->course) ? $row->exam->course->title : '';
            })
            ->addColumn('phase_id', function ($row) {
                return isset($row->exam->phase) ? $row->exam->phase->title : '';
            })
            ->addColumn('term_id', function ($row) {
                return isset($row->exam->term) ? $row->exam->term->title : '';
            })
            ->addColumn('result_publish', function ($row) {
                return isset($row->result_published) ? resultPublishStatus($row->result_published) : '';
            })
            ->addColumn('publish_date', function ($row) {
                return isset($row->result_publish_date) ? fullDateFormat($row->result_publish_date) : '';
            })
            ->addColumn('action', function ($row) {
                if (Auth::guard('web')->check()) {
                    $actions = '';
                    $user = Auth::guard('web')->user();
                    $hod = $row->subject->department->teacher;
                    $hasHodApproval = $row->hod_edit_permission;
                    $proof = DB::table('result_edit_request')->where('exam_id', $row->exam_id)
                               ->where('subject_id', $row->subject_id)
                               ->where('user_id', $hod->user_id)
                               ->orderByDesc('id')
                               ->first();

                    if (hasPermission('result/view')) {
                        $editIcon = $row->hod_edit_permission ? 'far fa-edit' : 'far fa-eye';
                        $editTitle = $row->hod_edit_permission ? 'Edit' : 'View';

                        $actions .= '<a href="' . route('exam.subject.result.show', [
                                $row->exam_id, $row->subject_id
                            ]) . '" class="m-portlet__nav-link btn m-btn m-btn--hover-brand m-btn--icon m-btn--icon-only m-btn--pill" title="' . $editTitle . '"><i style="margin-right: 5px;" class="' . $editIcon . '"></i></a>';

                        if ($user->user_group_id == 1 && $proof && file_exists($proof->file_path)) {
                            $actions .= '<a href="' . asset($proof->file_path) . '" target="_blank" class="m-portlet__nav-link btn m-btn m-btn--hover-brand m-btn--icon m-btn--icon-only m-btn--pill"
                                title="Preview/Download Proof">
                                <i class="fas fa-file-alt"></i></a>';
                        }
                    }
                    if (hasPermission('result/edit')) {
                        $examSubjectMarks = $row->exam->examMarks->where('subject_id', $row->subject_id)->first();
                        $statusIcon = $row->hod_edit_permission ? 'fa fa-toggle-on' : 'fa fa-toggle-off';
                        $statusTitle = $row->hod_edit_permission ? 'Close edit permission' : 'Get edit permission';

                        if ($user->user_group_id == 1 && !empty($row->result_published) && !empty($examSubjectMarks->total_marks) && !empty($examSubjectMarks->result->toArray())) {
                            $actions .= '<button data-exam-id="' . $row->exam_id . '" data-subject-id="' . $row->subject_id . '" class="m-portlet__nav-link btn m-btn m-btn--hover-brand m-btn--icon m-btn--icon-only m-btn--pill toggle-edit-permission" title="' . $statusTitle . '">
                                    <i class="' . $statusIcon . '"></i>
                                    </button>';
                        }

                        if (empty($row->result_published) && !empty($examSubjectMarks->total_marks) && !empty($examSubjectMarks->result->toArray())) {
                            $actions .= '<a href="' . route('exam.subject.make.edit', [
                                    $row->exam_id, $row->subject_id
                                ]) . '" class="m-portlet__nav-link btn m-btn m-btn--hover-brand m-btn--icon m-btn--icon-only m-btn--pill" title="Edit"><i style="margin-right: 5px;" class="far fa-edit"></i></a>';
                        }
                    }

                    if (hasPermission('result/edit')) {
                        $examSubjectMarks = $row->exam->examMarks->where('subject_id', $row->subject_id)->first();
                        if (empty($row->result_published) && !empty($examSubjectMarks->total_marks) && !empty($examSubjectMarks->result->toArray())) {
                            $actions .= '<a href="javascript:void(0)" class="m-portlet__nav-link btn m-btn m-btn--hover-brand m-btn--icon m-btn--icon-only m-btn--pill modal-exam-result-publish"
                                     data-exam-id="' . $row->exam_id . '" data-subject-id="' . $row->subject_id . '" title="Publish Result">
                                     <i style="margin-right: 5px;" class="fas fa-check-double"></i>
                                     </a>';
                        }
                    }
                    if (!$hasHodApproval && $user->id == $hod->user_id && !empty($row->result_published) && !empty($examSubjectMarks->total_marks) && !empty($examSubjectMarks->result->toArray())) {
                        $actions .= '<button class="m-portlet__nav-link btn m-btn m-btn--hover-brand m-btn--icon m-btn--icon-only m-btn--pill btn-edit-request" data-exam-id="' . $row->exam_id . '" data-subject-id="' . $row->subject_id . '" title="Send edit request">
                        <i class="fas fa-envelope"></i>
                     </button>';
                    }
                } else {
                    $actions = '<a href="' . route('frontend.exam.subject.result.show', [
                            $row->exam_id, $row->subject_id
                        ]) . '" class="m-portlet__nav-link btn m-btn m-btn--hover-brand m-btn--icon m-btn--icon-only m-btn--pill" title="View"><i style="margin-right: 5px;" class="far fa-eye"></i></a>';
                }
                return $actions;
            })
            ->addIndexColumn()
            ->rawColumns(['result_publish', 'action'])
            ->filter(function ($query) use ($request) {
                $query->whereHas('exam', function ($q) use ($request) {
                    if (!empty($request->get('session_id'))) {
                        $q = $q->where('session_id', $request->get('session_id'));
                    }
                    if (!empty($request->get('course_id'))) {
                        $q = $q->where('course_id', $request->get('course_id'));
                    }
                    if (!empty($request->get('phase_id'))) {
                        $q = $q->where('phase_id', $request->get('phase_id'));
                    }
                    if (!empty($request->get('term_id'))) {
                        $q = $q->where('term_id', $request->term_id);
                    }
                    if (!empty($request->get('exam_category_id'))) {
                        $q = $q->where('exam_category_id', $request->exam_category_id);
                    }
                    if (!empty($request->get('subject_id'))) {
                        $q = $q->where('subject_id', $request->subject_id);
                    }
                    if (!empty($request->get('date_from'))) {
                        $from_date = Carbon::createFromFormat('d/m/Y', $request->date_from)->format('Y-m-d');
                        $q = $q->where('result_publish_date', '>=', $from_date);
                    }
                    if (!empty($request->get('date_to'))) {
                        $date_to = Carbon::createFromFormat('d/m/Y', $request->date_to)->format('Y-m-d');
                        $q = $q->where('result_publish_date', '<=', $date_to);
                    }
                    if ($request->filled('result_publish_status')) {
                        $q = $q->where('result_published', $request->result_publish_status);
                    }
                });
            })
            ->make(true);
    }

    public function saveStudentsResult($request)
    {
        if ($request->file('sheet')) {
            try {
                Excel::import($data = new ResultImport($request, $this), $request->file('sheet'));
                return $data;
            } catch (Exception $e) {
                return $e;
            }
        }

        $passPercentage = Setting::getSiteSetting()->pass_mark;
        $examMarks = [];
        $insertedResultIds = [];

        if ($request->has('student_id') && !empty($request->student_id)) {
            DB::beginTransaction();

            try {
                foreach ($request->student_id as $student) {
                    if ($request->has('sub_type_mark') && !empty($request->sub_type_mark[$student])) {
                        foreach ($request->sub_type_mark[$student] as $mId => $mark) {
                            $passStatus = $this->calculatePassStatus($mark, $mId, $passPercentage);

                            $studentMark = [
                                'student_id' => $student,
                                'exam_subject_mark_id' => $mId,
                                'responsible_teacher_id' => $request->teacher_id,
                                'marks' => !empty($mark) ? $mark : null,
                                'result_date' => Carbon::now()->format('d/m/Y'),
                                'pass_status' => $passStatus,
                                'remarks' => $request->comment[$student] ?? '',
                            ];

                            $examMarks = $this->create($studentMark);
                            $insertedResultIds[] = $examMarks->id;
                        }
                    }
                }

                $this->processResultStatusAfterProvidingExamSubTypeMarksNew($insertedResultIds);

                if ($request->has('publish_result')) {
                    $this->examSubject->where([
                        'exam_id' => $request->exam_id,
                        'subject_id' => $request->subject_id,
                    ])->update([
                        'result_published' => true,
                        'result_publish_date' => Carbon::now(),
                    ]);
                }

                DB::commit();
            } catch (Exception $e) {
                DB::rollBack();
                Log::error('Error saving student results: ' . $e->getMessage(), ['exception' => $e]);
                return ['status' => 'error', 'message' => 'An error occurred while saving results.'];
            }
        }
        return $examMarks;
    }

    public function getAllExamResults()
    {
        $query = $this->examSubject
            ->with('exam.session', 'exam.course', 'exam.phase', 'exam.term', 'exam.examCategory', 'subject', 'exam.examMarks');
        if (Auth::guard('web')->check()) {
            $user = Auth::guard('web')->user();
            if ($user->teacher) {
                $query = $query->whereIn('subject_id', getSubjectsIdByTeacherId($user->teacher->id, $user->teacher->course_id));
            }
        } elseif (Auth::guard('student_parent')->check()) {
            $user = Auth::guard('student_parent')->user();
            //if login user is student
            if ($user->student) {
                //get subject id by student course id
                $subjectIds = $this->subjectModel->whereHas('subjectGroup', function ($q) use ($user) {
                    $q->where('course_id', $user->student->course_id);
                })->pluck('id');
                $session = $user->student->followed_by_session_id;
            } //if login user is parent
            elseif ($user->parent) {
                $subjectIds = $this->subjectModel->whereHas('subjectGroup', function ($q) use ($user) {
                    $q->where('course_id', $user->parent->students->first()->course_id);
                })->pluck('id');
                $session = $user->parent->students->first()->followed_by_session_id;
            }
            $query = $query->whereIn('subject_id', $subjectIds)
                ->where('result_published', 1)
                ->whereHas('exam', function ($q) use ($session) {
                    $q->where('session_id', $session);
                });
        }
        return $query->orderBy('id', 'desc')->get();
    }

    public function getExamSubjectsAndMarks($request)
    {
        $query = $this->examSubject->whereHas('exam', function ($q) use ($request) {
            $q->where('session_id', $request->session_id)->where('course_id', $request->course_id);
            if ($request->has('phase_id') && !empty($request->phase_id)) {
                $q = $q->where('phase_id', $request->phase_id);
            }
            if ($request->has('term_id') && !empty($request->term_id)) {
                $q = $q->where('term_id', $request->term_id);
            }
            if ($request->has('exam_category_id') && !empty($request->exam_category_id)) {
                $q = $q->where('exam_category_id', $request->exam_category_id);
            }
            if ($request->has('subject_id') && !empty($request->subject_id)) {
                $q = $q->where('subject_id', $request->subject_id);
            }
            if ($request->has('date_from') && !empty($request->date_from)) {
                $from_date = Carbon::createFromFormat('d/m/Y', $request->date_from)->format('Y-m-d');
                $q = $q->where('result_publish_date', '>=', $from_date);
            }
            if ($request->has('date_to') && !empty($request->date_to)) {
                $date_to = Carbon::createFromFormat('d/m/Y', $request->date_to)->format('Y-m-d');
                $q = $q->where('result_publish_date', '<=', $date_to);
            }
            if ($request->has('result_publish_status') && $request->result_publish_status != null && (!empty($request->result_publish_status) || $request->result_publish_status == 0)) {
                $q = $q->where('result_published', $request->result_publish_status);
            }
        })->with('exam.session', 'exam.course', 'exam.phase', 'exam.term', 'exam.examCategory', 'subject', 'exam.examMarks')
            ->where('exam_type_id', 3)->groupBy('exam_id', 'subject_id');

        if (Auth::guard('web')->check()) {
            $user = Auth::guard('web')->user();
            if ($user->teacher) {
                $query = $query->whereIn('subject_id', getSubjectsIdByTeacherId($user->teacher->id, $user->teacher->course_id));
            }
        } elseif (Auth::guard('student_parent')->check()) {
            $user = Auth::guard('student_parent')->user();
            //if login user is student
            if ($user->student) {
                //get subject id by student course id
                $subjectIds = $this->subjectModel->whereHas('subjectGroup', function ($q) use ($user) {
                    $q->where('course_id', $user->student->course_id);
                })->pluck('id');
            } //if login user is parent
            elseif ($user->parent) {
                $subjectIds = $this->subjectModel->whereHas('subjectGroup', function ($q) use ($user) {
                    $q->where('course_id', $user->parent->students->first()->course_id);
                })->pluck('id');
            }
            $query = $query->whereIn('subject_id', $subjectIds)
                ->where('result_published', 1);
        }

        return $query->orderBy('id', 'desc')->get();
    }

    public function getExamResultsByExamIdAndSubjectId($examId, $subjectId)
    {
        return $this->model->with('student', 'examSubjectMark.examSubType')->whereHas('examSubjectMark', function ($q) use ($examId, $subjectId) {
            $q->where('exam_id', $examId)->where('subject_id', $subjectId);
        })->get()
            //sort by student roll no
            ->sortBy(function ($value) {
                return $value->student->roll_no;
            });
    }

    public function getExamResultsByExamInAndSubjectGroupId($examId, $subjectGroupId)
    {
        return $this->model->whereHas('examSubjectMark', function ($q) use ($examId, $subjectGroupId) {
            $q->where('exam_id', $examId)->whereHas('subject', function ($q1) use ($subjectGroupId) {
                $q1->where('subject_group_id', $subjectGroupId);
            });
        })->get();
    }

    public function getExamResultsByExamIdSubjectIdAndStudentId($examId, $subjectId, $studentId)
    {
        $query = $this->model;

        if (is_array($studentId)) {
            $query = $query->whereIn('student_id', $studentId);
        } else {
            $query = $query->where('student_id', $studentId);
        }

        return $query->whereHas('examSubjectMark', function ($q) use ($examId, $subjectId) {
            $q->where('exam_id', $examId)->where('subject_id', $subjectId);
        })->get();
    }

    public function getExamResultsByExamIdSubjectGroupIdAndStudentId($examId, $subjectGroupId, $studentId)
    {
        return $this->model->where('student_id', $studentId)->whereHas('examSubjectMark', function ($q) use ($examId, $subjectGroupId) {
            $q->where('exam_id', $examId)->whereHas('subject', function ($q) use ($subjectGroupId) {
                $q->where('subject_group_id', $subjectGroupId);
            });
        })
            ->with('examSubjectMark.examSubType')
            ->get();
    }

    public function updateExamResultBySubject($request, $examId, $subjectId)
    {
        $result = false;
        $passPercentage = Setting::getSiteSetting()->pass_mark;

        if ($request->has('student_id') && !empty($request->student_id)) {
            DB::beginTransaction();

            try {
                $updatedResultIds = [];

                foreach ($request->student_id as $student) {
                    if ($request->has('sub_type_mark') && !empty($request->sub_type_mark[$student])) {
                        foreach ($request->sub_type_mark[$student] as $mId => $mark) {
                            $passStatus = $this->calculatePassStatus($mark, $mId, $passPercentage);

                            $studentMark = [
                                'marks' => $mark ?? null,
                                'pass_status' => $passStatus,
                                'remarks' => $request->comment[$student] ?? '',
                            ];

                            $result = $this->model->updateOrCreate(
                                ['exam_subject_mark_id' => $mId, 'student_id' => $student],
                                $studentMark
                            );

                            $updatedResultIds[] = $result->id;
                        }
                    }
                }

                $this->processResultStatusAfterProvidingExamSubTypeMarksNew($updatedResultIds);

                if ($request->has('publish_result')) {
                    $this->examSubject->where(['exam_id' => $examId, 'subject_id' => $subjectId])
                        ->update([
                            'result_published' => true,
                            'result_publish_date' => Carbon::now(),
                        ]);

                    // send system notification to students
                    event(new NotifyUserWhenExamResultAnnounced($examId, $subjectId));

                    //send email to parents
                    event(new NotifyParentsWhenExamResultAnnounced($examId, $subjectId));
                }

                DB::commit();
            } catch (Exception $e) {
                DB::rollBack();
                throw $e;
            }

            if ($request->has('publish_result')) {
                event(new NotifyUserWhenExamResultAnnounced($examId, $subjectId));
                event(new NotifyParentsWhenExamResultAnnounced($examId, $subjectId));
            }
        }

        return $result;
    }

    private function calculatePassStatus($mark, $mId, $passPercentage)
    {
        // Retrieve full marks for the exam sub-type
        $subTypeFullMark = $this->examSubjectMark->find($mId)->total_marks;

        // Check if the mark is null (Absent)
        if ($mark === null) {
            return 4; // Absent
        }

        // Calculate percentage
        $checkPercentage = ($mark * 100) / $subTypeFullMark;

        // Determine pass or fail status
        if ($checkPercentage >= $passPercentage) {
            return 1; // Pass
        }

        return 2; // Fail
    }

    private function processResultStatusAfterProvidingExamSubTypeMarksNew($updatedResultIdsArr)
    {
        $passPercentage = Setting::getSiteSetting()->pass_mark;
        // Fetch the exam results using Eloquent
        $results = ExamResult::whereIn('id', $updatedResultIdsArr)->get();

        // Iterate through the results and update the result status
        foreach ($results as $result) {
            if ($result->pass_status == 4) {
                $resultStatus = 'Absent';
            } elseif ($result->pass_status == 3) {
                $graceMarks = $result->grace_marks ?? 0;
                $obtainedMark = $result->marks + $graceMarks;
                $checkPercentage = ($obtainedMark * 100) / $result->examSubjectMark->total_marks;
                $resultStatus = ($checkPercentage >= $passPercentage) ? 'Pass(Grace)' : 'Fail';
            } else {
                $checkPercentage = ($result->marks * 100) / $result->examSubjectMark->total_marks;
                $resultStatus = ($checkPercentage >= $passPercentage) ? 'Pass' : 'Fail';
            }

            // Update the result status
            $result->update(['result_status' => $resultStatus]);
        }
    }

    public function updateIndividualStudentResultBySubjectId($request)
    {
        $response = false;
        $updatedResultIdsArr = [];
        $passPercentage = Setting::getSiteSetting()->pass_mark;
        DB::beginTransaction();
        try {
            foreach ($request->sub_type_mark as $id => $mark) {
                $subTypeFullMark = $this->model->find($id)->examSubjectMark->total_marks;
                $graceMarks = $request->grace_marks[$id] ?? 0;
                $obtainedMarkWithoutGrace = $mark;
                $obtainedMark = $mark + $graceMarks;
                $checkPercentageWithoutGrace = ($obtainedMarkWithoutGrace * 100) / $subTypeFullMark;
                $checkPercentage = ($obtainedMark * 100) / $subTypeFullMark;

                if ($mark === null) {
                    // Absent
                    $passStatus = 4;
                } elseif ($checkPercentageWithoutGrace >= $passPercentage) {
                    // Passed without grace
                    $passStatus = 1;
                } elseif ($checkPercentage >= $passPercentage) {
                    // Passed with grace
                    $passStatus = 3;
                } else {
                    // Failed
                    $passStatus = 2;
                }

                if (is_null($request->special_consideration)) {
                    $response = $this->update([
                        'marks' => $mark ?? null,
                        'pass_status' => $passStatus,
                        'special_status' => null,
                        'grace_marks' => $graceMarks ?: null,
                        'remarks' => $request->comment,
                    ], $id);
                } else {
                    $response = $this->update([
                        'special_status' => $request->result_status,
                    ], $id);
                }

                $updatedResultIdsArr[] = $id;
            }
            $this->processResultStatusAfterProvidingExamSubTypeMarksNew($updatedResultIdsArr);
            DB::commit();
            return $response;
        } catch (Exception $e) {
            DB::rollBack();
            return $e->getMessage() . $e->getLine() . $e->getCode();
        }
    }

    public function getStudentsResultStatus($courseId, $phaseId, $sessionId, $rollNo = '', $regNo = '')
    {
        $nextPhaseId = (int)$phaseId + 1;
        $query = $this->model->select(
            'er.student_id', 'er.pass_status', 'er.result_status', 'er.remarks', 'er.result_date', 'e.id as exam_id', 'esm.subject_id', 's.full_name_en',
            's.roll_no', 's.reg_no', 's.student_status', 's.session_id', 'e.phase_id', 'e.course_id', 'e.session_id as exam_session',
            DB::raw('(SELECT COUNT(*) FROM `phase_promotion_histories` WHERE `student_id` = `s`.`id` AND `promoted_from` = ' . (int)$phaseId . ' AND `promoted_to` = ' . $nextPhaseId . ' AND `deleted_at` IS NULL) AS `promoted`'),
            DB::raw('(SELECT COUNT(*) FROM `phase_promotion_histories` WHERE `student_id` = `s`.`id` AND `promoted_from` = ' . (int)$phaseId . ' AND `promoted_to` = ' . (int)$phaseId . ') AS `demoted`')
        );

        $query->from('exam_results as er');

        $query->join('exam_subject_marks as esm', 'esm.id', '=', 'er.exam_subject_mark_id');

        $query->join('exams as e', function ($join) use ($courseId, $phaseId, $sessionId) {
            return $join->on('e.id', '=', 'esm.exam_id')
                ->whereIn('e.exam_category_id', [3, 7])
                ->where('e.phase_id', $phaseId)
                ->where('e.course_id', $courseId)
                ->where('e.session_id', $sessionId);
        });

        $query->join('exam_subjects as es', 'es.exam_id', '=', 'e.id');
        $query->where('es.result_published', 1);

        $query->join('students as s', 's.id', '=', 'er.student_id');
        $query->where('s.student_status', 0)
//            ->where('s.phase_id', '=', $phaseId)
            ->whereIn('s.status', [1, 3]);
        if (!empty($rollNo)) {
            $query->where('s.roll_no', '=', $rollNo);
        }
        if (!empty($regNo)) {
            $query->where('s.reg_no', '=', $regNo);
        }
        $query->groupBy(['s.student_id', 'e.id', 'esm.subject_id']);
        $query->orderBy('s.roll_no', 'asc');

        return $query->get();
    }

    public function promoteStudentToNextPhase($request)
    {
        DB::beginTransaction();
        try {
            $promote = false;
            $request->merge(['promotion_date' => Carbon::createFromFormat('d/m/Y', $request->promotion_date)->format('Y-m-d')]);

            if ($request->promoteStatus) {
                $this->revertStudent($request);
            }

            $phaseId = $request->phase_id;
            $studentId = $request->student_id;
            $latestPromotion = $this->phasePromotionHistory
                ->where('student_id', $studentId)
                ->latest()
                ->first();

            if ($request->promotion == 1) {
//                if (empty($latestPromotion)) {
                if ($phaseId < 4) {
                    $promote = $this->phasePromotionHistory->create([
                        'student_id' => $studentId,
                        'promoted_from' => $phaseId,
                        'promoted_to' => $phaseId + 1,
                        'pass_professional' => 0,
                        'remarks' => checkEmpty($request->remarks),
                        'promotion_date' => !empty($request->promotion_date) ? $request->promotion_date : now(),
                        'promoted_by' => Auth::guard('web')->user()->id,
                    ]);
                } else {
                    $promote = $latestPromotion->update([
                        'pass_professional' => 1,
                        'remarks' => checkEmpty($request->remarks),
                        'promotion_date' => !empty($request->promotion_date) ? $request->promotion_date : now(),
                        'promoted_by' => Auth::guard('web')->user()->id,
                    ]);
                }
                if ($promote) {
                    $this->updateStudentRollNew($promote->student->id);
                    $promote->student->phase_id = $phaseId < 4 ? $phaseId + 1 : $phaseId;
                    $promote->student->followed_by_session_id = $request->followed_by_session_id;
                    $promote->student->status = $phaseId == 4 ? 5 : $promote->student->status;
                    $promote->student->save();
                }
//                }
                if ($request->promoteStatus && !empty($latestPromotion)) {
                    $this->phasePromotionHistory->where('id', $latestPromotion->id)->delete();
                }
            } else {
                $promote = $this->phasePromotionHistory->create([
                    'student_id' => $studentId,
                    'promoted_from' => $phaseId,
                    'promoted_to' => $phaseId,
                    'pass_professional' => 0,
                    'remarks' => checkEmpty($request->remarks),
                    'promotion_date' => !empty($request->promotion_date) ? $request->promotion_date : now(),
                    'promoted_by' => Auth::guard('web')->user()->id,
                ]);
                if ($request->promoteStatus && !empty($latestPromotion)) {
                    $this->phasePromotionHistory->where('id', $latestPromotion->id)->delete();
                }
                if ($promote) {
                    $promote->student->phase_id = $phaseId;
                    $promote->student->followed_by_session_id = $request->followed_by_session_id;
                    $promote->student->batch_type_id = 2;
                    $promote->student->save();
//                    $promote->delete();
                    $this->updateStudentRollNewNotPromoted($promote->student->id);
                }
            }
            DB::commit();
            return $promote;
        } catch (Exception $e) {
            DB::rollBack();
            return $e->getMessage() . $e->getLine() . $e->getCode();
        }
    }

    public function getExamResultTotalBySessionCoursePhaseAndCategoryId($sessionId, $courseId, $phaseId, $categoryId)
    {
        $query = $this->model->select('er.student_id', 's.full_name_en', 'e.id as exam_id', 'esm.subject_id', 'er.result_status', 'er.remarks', DB::raw("SUM(er.marks) as totalMark"), DB::raw("SUM(er.grace_marks) as totalGrace"))
            ->from('exam_results as er')
            ->join('exam_subject_marks as esm', 'esm.id', '=', 'er.exam_subject_mark_id')
            ->join('exams as e', function ($join) use ($sessionId, $courseId, $phaseId, $categoryId) {
                $join->on('e.id', '=', 'esm.exam_id')
                    ->where('e.session_id', $sessionId)
                    ->where('e.course_id', $courseId)
                    ->where('e.phase_id', $phaseId)
                    ->where('e.exam_category_id', $categoryId);
            })
            ->join('students as s', 's.id', '=', 'er.student_id')
            ->groupBy(['s.student_id', 'e.id', 'esm.subject_id'])
            ->orderBy('s.student_id', 'ASC')
            ->orderBy('e.id', 'ASC')
            ->orderBy('esm.subject_id', 'ASC');

        return $query->get();
    }

    public function getStudentResultBySubjectExamCategoryStudentAndPhaseId($subjectId, $examCategoryId, $studentId, $phaseId)
    {
        $query = $this->examSubject->where('subject_id', $subjectId)->whereHas('exam', function ($q) use ($examCategoryId, $phaseId, $studentId) {
            $q->where('exam_category_id', $examCategoryId)->where('phase_id', $phaseId)->where('result_published', 1)
                ->whereHas('examMarks.result', function ($q1) use ($studentId) {
                    $q1->where('student_id', $studentId);
                });
        })->with([
            'exam.examMarks' => function ($q) use ($subjectId, $studentId) {
                $q->where('subject_id', $subjectId)->with([
                    'result' => function ($q1) use ($studentId) {
                        $q1->where('student_id', $studentId);
                    }
                ]);
            }, 'exam.term'
        ])->groupBy('exam_id');

        return $query->get();
    }

    public function getStudentItemResultByStudentIdAndItemId($studentId, $itemId)
    {
        return $this->model->where('student_id', $studentId)
            ->whereHas('examSubjectMark.exam.examSubjects', function ($q) use ($itemId) {
                $q->where('card_item_id', $itemId);
            })
            ->first();
    }

    //publish exam result from list page by modal
    public function publishExamResultByExamIdAndSubjectId($request)
    {
        $resultPublish = false;
        if ($request->filled('result_published')) {
            $resultPublish = $this->examSubject->where([
                'exam_id' => $request->exam_id,
                'subject_id' => $request->subject_id,
            ])->update([
                'result_published' => true,
                'result_publish_date' => Carbon::now(),
            ]);
        }

        if ($request->has('publish_result')) {
            // send system notification to students
            event(new NotifyUserWhenExamResultAnnounced($request->exam_id, $request->subject_id));

            //send email to parents
            event(new NotifyParentsWhenExamResultAnnounced($request->exam_id, $request->subject_id));
        }

        return $resultPublish;
    }

    private function updateStudentRoll($studentId)
    {
        DB::beginTransaction();
        try {
            $student = Student::find($studentId);
            $prevRoll = $student->roll_no - 1;
            if ($student->batch_type_id == 1) {
                $check = Student::where('id', '!=', $studentId)
                    ->where('followed_by_session_id', $student->followed_by_session_id)
                    ->where('course_id', $student->course_id)
                    ->where('phase_id', $student->phase_id)
                    ->where('roll_no', $prevRoll)
                    ->whereIn('status', [1, 3])
                    ->count();

                if (empty($check) && $prevRoll > 0) {
                    $student->update([
                        'roll_no' => $prevRoll,
                    ]);
                    // Insert data into the "student_roll_no" table
                    DB::table('student_roll_no')->insert([
                        'student_id' => $studentId,
                        'phase_id' => $student->phase_id,
                        'batch_type_id' => $student->batch_type_id,
                        'roll_no' => $prevRoll,
                        'created_at' => now(),
                    ]);
                } else {
                    // Insert data into the "student_roll_no" table
                    DB::table('student_roll_no')->insert([
                        'student_id' => $studentId,
                        'phase_id' => $student->phase_id,
                        'batch_type_id' => $student->batch_type_id,
                        'roll_no' => $student->roll_no,
                        'created_at' => now(),
                    ]);
                }
            } else {
                $check = Student::where('id', '!=', $studentId)
                    ->where('followed_by_session_id', $student->followed_by_session_id)
                    ->where('course_id', $student->course_id)
                    ->where('phase_id', $student->phase_id)
                    ->whereIn('status', [1, 3])
                    ->count();

                $student->update([
                    'roll_no' => $check + 1,
                ]);
                // Insert data into the "student_roll_no" table
                DB::table('student_roll_no')->insert([
                    'student_id' => $studentId,
                    'phase_id' => $student->phase_id,
                    'batch_type_id' => $student->batch_type_id,
                    'roll_no' => $check + 1,
                    'created_at' => now(),
                ]);
            }

            DB::commit();
            return true;
        } catch (Exception $e) {
            DB::rollBack();
            return $e->getMessage() . $e->getLine() . $e->getCode();
        }
    }

    public function getFailedStudentsByExam($examId, $subjectId)
    {
        $students = collect();
        $passPercentage = Setting::getSiteSetting()->pass_mark;
        $examResults = $this->getExamResultsByExamIdAndSubjectId($examId, $subjectId);

        $examResults->groupBy('student_id')->each(function ($studentResults) use ($students, $passPercentage) {
            $examTypeMarksArr = [];
            $totalMarksByExamType = [];
            $specialStatus = false;
            $absentCount = 0;
            $failCount = 0;

            foreach ($studentResults->sortBy('id') as $result) {
                $examTypeId = $result->examSubjectMark->examSubType->examType->id;
                $marks = $result->marks + $result->grace_marks;

                $examTypeMarksArr[$examTypeId] = ($examTypeMarksArr[$examTypeId] ?? 0) + $result->examSubjectMark->total_marks;
                $totalMarksByExamType[$examTypeId] = ($totalMarksByExamType[$examTypeId] ?? 0) + $marks;

                $specialStatus = $specialStatus || $result->special_status;
                if ($result->pass_status == 4) {
                    $absentCount++;
                }
            }

            foreach ($examTypeMarksArr as $typeId => $totalMark) {
                $percentage = ($totalMarksByExamType[$typeId] * 100) / $totalMark;
                if ($percentage < $passPercentage) {
                    $failCount++;
                }
            }

            if (!$specialStatus && ($absentCount > 0 || $failCount > 0)) {
                $students->push($studentResults->first()->student);
            }
        });

        return $students;
    }

    private function updateStudentRollNew($studentId)
    {
        DB::beginTransaction();

        try {
            $student = Student::find($studentId);
            $prevRoll = $student->roll_no;
            $checkRoll = Student::where('roll_no', '=', $student->roll_no)
                ->where('followed_by_session_id', $student->followed_by_session_id)
                ->where('course_id', $student->course_id)
                ->where('phase_id', $student->phase_id + 1)
                ->where('batch_type_id', 1)
                ->whereIn('status', [1, 3])
                ->first();

            if (is_null($checkRoll)) {
                $previousRoll = Student::where('roll_no', '<', $student->roll_no)
                    ->where('followed_by_session_id', $student->followed_by_session_id)
                    ->where('course_id', $student->course_id)
                    ->where('phase_id', $student->phase_id + 1)
                    ->whereIn('status', [1, 3])
                    ->get();
                if ($previousRoll->count() == 0) {
                    $student->update([
                        'roll_no' => 1,
                        'remarks' => 1,
                    ]);

                    DB::table('student_roll_no')->insert([
                        'student_id' => $studentId,
                        'phase_id' => $student->phase_id < 4 ? $student->phase_id + 1 : $student->phase_id,
                        'batch_type_id' => $student->batch_type_id,
                        'from_roll' => $prevRoll,
                        'to_roll' => 1,
                        'created_at' => now(),
                    ]);
                } else {
                    $student->update([
                        'roll_no' => $previousRoll->last()->roll_no + 1,
                        'remarks' => 2,
                    ]);

                    DB::table('student_roll_no')->insert([
                        'student_id' => $studentId,
                        'phase_id' => $student->phase_id < 4 ? $student->phase_id + 1 : $student->phase_id,
                        'batch_type_id' => $student->batch_type_id,
                        'from_roll' => $prevRoll,
                        'to_roll' => $previousRoll->last()->roll_no + 1,
                        'created_at' => now(),
                    ]);
                }

                $nextRoll = Student::where('roll_no', '>=', $student->roll_no)
                    ->where('id', '!=', $studentId)
                    ->where('followed_by_session_id', $student->followed_by_session_id)
                    ->where('course_id', $student->course_id)
                    ->where('phase_id', $student->phase_id + 1)
                    ->whereIn('status', [1, 3])
                    ->get();

                if (!empty($nextRoll)) {
                    foreach ($nextRoll as $roll) {
                        Student::where('id', $roll->id)->update([
                            'roll_no' => $roll->roll_no + 1,
                            'remarks' => 4,
                        ]);

                        DB::table('student_roll_no')->insert([
                            'student_id' => $roll->id,
                            'phase_id' => $roll->phase_id,
                            'batch_type_id' => $roll->batch_type_id,
                            'from_roll' => $roll->roll_no,
                            'to_roll' => $roll->roll_no + 1,
                            'created_at' => now(),
                        ]);
                    }
                }
            } else {
                $student->update([
                    'roll_no' => $student->roll_no,
                    'remarks' => 3,
                ]);

                DB::table('student_roll_no')->insert([
                    'student_id' => $studentId,
                    'phase_id' => $student->phase_id < 4 ? $student->phase_id + 1 : $student->phase_id,
                    'batch_type_id' => $student->batch_type_id,
                    'from_roll' => $prevRoll,
                    'to_roll' => $student->roll_no,
                    'created_at' => now(),
                ]);

                $nextRoll = Student::where('roll_no', '>=', $student->roll_no)
                    ->where('id', '!=', $studentId)
                    ->where('followed_by_session_id', $student->followed_by_session_id)
                    ->where('course_id', $student->course_id)
                    ->where('phase_id', $student->phase_id + 1)
                    ->whereIn('status', [1, 3])
                    ->get();

                if (!empty($nextRoll)) {
                    foreach ($nextRoll as $roll) {
                        Student::where('id', $roll->id)->update([
                            'roll_no' => $roll->roll_no + 1,
                            'remarks' => 4,
                        ]);

                        DB::table('student_roll_no')->insert([
                            'student_id' => $roll->id,
                            'phase_id' => $roll->phase_id,
                            'batch_type_id' => $roll->batch_type_id,
                            'from_roll' => $roll->roll_no,
                            'to_roll' => $roll->roll_no + 1,
                            'created_at' => now(),
                        ]);
                    }
                }
            }
            DB::commit();
            return true;
        } catch (Exception $e) {
            DB::rollBack();
            return $e->getMessage() . $e->getLine() . $e->getCode();
        }
    }

    private function updateStudentRollNewNotPromoted($studentId)
    {
        DB::beginTransaction();
        try {
            $student = Student::find($studentId);
            $prevRoll = $student->roll_no;
            $checkRoll = Student::where('id', '!=', $studentId)
                ->where('followed_by_session_id', $student->followed_by_session_id)
                ->where('course_id', $student->course_id)
                ->where('phase_id', $student->phase_id)
                ->whereIn('status', [1, 3])
                ->latest('roll_no')->first();

            if (is_null($checkRoll)) {
                $student->update([
                    'roll_no' => 1,
                    'remarks' => 1,
                ]);

                DB::table('student_roll_no')->insert([
                    'student_id' => $studentId,
                    'phase_id' => $student->phase_id,
                    'batch_type_id' => $student->batch_type_id,
                    'from_roll' => $prevRoll,
                    'to_roll' => 1,
                    'created_at' => now(),
                ]);
            } else {
                $student->update([
                    'roll_no' => $checkRoll->roll_no + 1,
                    'remarks' => 2,
                ]);

                DB::table('student_roll_no')->insert([
                    'student_id' => $studentId,
                    'phase_id' => $student->phase_id,
                    'batch_type_id' => $student->batch_type_id,
                    'from_roll' => $prevRoll,
                    'to_roll' => $checkRoll->roll_no + 1,
                    'created_at' => now(),
                ]);
            }
            DB::commit();
            return true;
        } catch (Exception $e) {
            DB::rollBack();
            return $e->getMessage() . $e->getLine() . $e->getCode();
        }
    }

    private function revertStudent($request)
    {
        DB::beginTransaction();
        try {
            $student = Student::find($request->student_id);
            $prevPhase = $this->phasePromotionHistory->withTrashed()->where('student_id', $request->student_id)->get()->last();
            $prevRoll = DB::table('student_roll_no')->where('student_id', $request->student_id)->first('from_roll');
            $nextRoll = Student::where('roll_no', '>', $student->roll_no)
                ->where('id', '!=', $request->student_id)
                ->where('followed_by_session_id', $student->followed_by_session_id)
                ->where('course_id', $student->course_id)
                ->where('phase_id', $student->phase_id)
                ->whereIn('status', [1, 3])
                ->get();

            if (!empty($nextRoll)) {
                foreach ($nextRoll as $roll) {
                    Student::where('id', $roll->id)->update([
                        'roll_no' => $roll->roll_no - 1,
                        'remarks' => 4,
                    ]);

                    DB::table('student_roll_no')->insert([
                        'student_id' => $roll->id,
                        'phase_id' => $roll->phase_id,
                        'batch_type_id' => $roll->batch_type_id,
                        'from_roll' => $roll->roll_no,
                        'to_roll' => $roll->roll_no - 1,
                        'created_at' => now(),
                    ]);
                }
            }

            DB::table('student_roll_no')->insert([
                'student_id' => $request->student_id,
                'phase_id' => $prevPhase->promoted_from,
                'batch_type_id' => $request->promoteStatus == 1 ? 2 : 1,
                'from_roll' => $student->roll_no,
                'to_roll' => $prevRoll->from_roll,
                'created_at' => now(),
            ]);
            $student->update([
                'followed_by_session_id' => $request->followed_by_session_id,
                'phase_id' => $prevPhase->promoted_from,
                'batch_type_id' => $request->promoteStatus == 1 ? 2 : 1,
                'roll_no' => $prevRoll->from_roll,
                'remarks' => 'Revert Student',
            ]);
            DB::commit();
            return true;
        } catch (Exception $e) {
            DB::rollBack();
            return $e->getMessage() . $e->getLine() . $e->getCode();
        }
    }
}
