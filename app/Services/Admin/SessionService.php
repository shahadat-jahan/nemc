<?php

namespace App\Services\Admin;


use App\Models\AdmissionStudent;
use App\Models\Session;
use App\Models\SessionDetail;
use App\Models\SessionPhaseDetail;
use App\Models\Student;
use App\Services\BaseService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use DataTables;

/**
 * Class SessionService
 * @package App\Services\Admin
 */
class SessionService extends BaseService
{

    /**
     * @var SessionPhaseDetail
     */
    protected $sessionPhaseDetail;
    protected $admissionStudent;
    protected $student;
    protected $sessionDetail;


    /**
     * SessionService constructor.
     * @param Session $session
     * @param SessionPhaseDetail $sessionPhaseDetail
     */
    public function __construct(
        Session       $session, SessionPhaseDetail $sessionPhaseDetail, AdmissionStudent $admissionStudent, Student $student,
        SessionDetail $sessionDetail
    )
    {
        $this->model = $session;
        $this->sessionPhaseDetail = $sessionPhaseDetail;
        $this->admissionStudent = $admissionStudent;
        $this->student = $student;
        $this->sessionDetail = $sessionDetail;
    }

    /**
     * @param $request
     * @return mixed
     */
    public function addSession($request)
    {

        DB::beginTransaction();

        $sessions = $this->model->create([
            'title' => $request->title,
            'start_year' => $request->start_year
        ]);

        $this->__setupMBBSSession($sessions, $request);
        $this->__setupBDSSession($sessions, $request);

        DB::commit();

        return $sessions;
    }

    /**
     * @param $sessions
     * @param $request
     */
    private function __setupMBBSSession($sessions, $request)
    {
        // mbbs details
        $sessions->mbbsSessionDetails()->create([
            'course_id' => $request->mbbs_course_id,
            'batch_number' => $request->mbbs_batch_number,
            'development_fee_local' => !empty($request->mbbs_development_fee_local) ? $request->mbbs_development_fee_local : null,
            'development_fee_foreign' => !empty($request->mbbs_development_fee_foreign) ? $request->mbbs_development_fee_foreign : null,
            'tuition_fee_local' => !empty($request->mbbs_tuition_fee_local) ? $request->mbbs_tuition_fee_local : null,
            'tuition_fee_foreign' => !empty($request->mbbs_tuition_fee_foreign) ? $request->mbbs_tuition_fee_foreign : null,
            'total_phases' => !empty($request->mbbs_total_phases) ? $request->mbbs_total_phases : null
        ]);

        if (!empty($request->mbbs_phase)) {
            foreach ($request->mbbs_phase as $key => $phase) {
                $sessionPhaseDetail = $this->sessionPhaseDetail->create([
                    'session_detail_id' => $sessions->mbbsSessionDetails->firstWhere('course_id', $request->mbbs_course_id)->id,
                    'phase_id' => $phase,
                    'total_terms' => $request->mbbs_phase_term[$key],
                    'duration' => $request->mbbs_phase_duration[$key],
                    'exam_title' => $request->mbbs_exam_title[$key],
                ]);

                if (!empty($request->mbbs_phase_subjects[$key])) {
                    foreach ($request->mbbs_phase_subjects[$key] as $subject) {
                        $sessionPhaseDetail->subjects()->attach($subject);
                    }
                }
            }
        }
    }

    /**
     * @param $sessions
     * @param $request
     */
    private function __setupBDSSession($sessions, $request)
    {
        // bds details
        $sessions->bdsSessionDetails()->create([
            'course_id' => $request->bds_course_id,
            'batch_number' => $request->bds_batch_number,
            'development_fee_local' => !empty($request->bds_development_fee_local) ? $request->bds_development_fee_local : null,
            'development_fee_foreign' => !empty($request->bds_development_fee_foreign) ? $request->bds_development_fee_foreign : null,
            'tuition_fee_local' => !empty($request->bds_tuition_fee_local) ? $request->bds_tuition_fee_local : null,
            'tuition_fee_foreign' => !empty($request->bds_tuition_fee_foreign) ? $request->bds_tuition_fee_foreign : null,
            'total_phases' => !empty($request->bds_total_phases) ? $request->bds_total_phases : null
        ]);

        if (!empty($request->bds_phase)) {
            foreach ($request->bds_phase as $key => $phase) {
                $bdsSessionPhaseDetail = $this->sessionPhaseDetail->create([
                    'session_detail_id' => $sessions->bdsSessionDetails->firstWhere('course_id', $request->bds_course_id)->id,
                    'phase_id' => $phase,
                    'total_terms' => $request->bds_phase_term[$key],
                    'duration' => $request->bds_phase_duration[$key],
                    'exam_title' => $request->bds_exam_title[$key],
                ]);

                if (!empty($request->bds_phase_subjects[$key])) {
                    foreach ($request->bds_phase_subjects[$key] as $subject) {
                        $bdsSessionPhaseDetail->subjects()->attach($subject);
                    }
                }
            }
        }
    }

    /**
     * @param $request
     * @return mixed
     */
    public function getDataTable($request)
    {
        $query = $this->model->orderBy('title', 'desc')->select();

        return Datatables::of($query)
            ->addColumn('action', function ($row) {
                $actions = '';

                if (hasPermission('sessions/edit')) {
                    $actions .= '<a href="' . route('sessions.edit', [$row->id]) . '" class="m-portlet__nav-link btn m-btn m-btn--hover-brand m-btn--icon m-btn--icon-only m-btn--pill" title="Edit"><i class="flaticon-edit"></i></a>';
                    if ($row->status != 2) {
                        $actions .= '<a href="' . route('sessions.archive', [$row->id]) . '" class="m-portlet__nav-link btn m-btn m-btn--hover-brand m-btn--icon m-btn--icon-only m-btn--pill" title="Archive"><i class="fa fa-archive"></i></a>';
                    } else {
                        $actions .= '<a href="' . route('sessions.restore', [$row->id]) . '" class="m-portlet__nav-link btn m-btn m-btn--hover-brand m-btn--icon m-btn--icon-only m-btn--pill" title="Restore"><i class="fa fa-undo"></i></a>';
                    }
                }
                $actions .= '<a href="' . route('sessions.show', [$row->id]) . '" class="m-portlet__nav-link btn m-btn m-btn--hover-brand m-btn--icon m-btn--icon-only m-btn--pill" title="View"><i class="flaticon-eye"></i></a>';

                if (hasPermission('sessions/create')) {
                    $actions .= '<a href="' . route('session.clone', [$row->id]) . '" class="m-portlet__nav-link btn m-btn m-btn--hover-brand m-btn--icon m-btn--icon-only m-btn--pill" title="Clone this session"><i class="far fa-clone"></i></a>';
                }

                return $actions;
            })
            ->editColumn('status', function ($row) {
                return setStatus($row->status, 'session');
            })
            ->rawColumns(['status', 'action'])
            ->make(true);
    }

    /**
     * @param $request
     * @param $id
     * @return \App\Services\dataObject
     */
    public function editSession($request, $id)
    {
        $sessions = $this->find($id);

        DB::beginTransaction();

        $sessions->title = $request->title;
        $sessions->start_year = $request->start_year;
        $sessions->status = $request->status;
        $sessions->save();

        $this->__cleanSessionDetails($sessions);
        $this->__setupMBBSSession($sessions, $request);
        $this->__setupBDSSession($sessions, $request);

        DB::commit();

        return $sessions;
    }

    /**
     * @param $session
     */
    private function __cleanSessionDetails($session)
    {
        $phases = $this->sessionPhaseDetail->whereHas('sessionDetail', function ($q) use ($session) {
            $q->where('session_id', $session->id);
        })->get();

        $phases->each(function ($phase) {
            $phase->subjects()->detach();
            $phase->delete();
        });


        $session->mbbsSessionDetails()->delete();
        $session->bdsSessionDetails()->delete();
    }

    public function checkSessionSttaus($sessionId)
    {
        $checkAdmission = $this->admissionStudent->where('session_id', $sessionId)->count();
        $checkStudent = $this->student->where('session_id', $sessionId)->count();

        return empty($checkAdmission) && empty($checkStudent);
    }

    public function checkBatchIsUnique($request)
    {
        if ($request->has('id')) {
            return $this->sessionDetail->where('session_id', '<>', $request->id)->where('course_id', $request->course_id)->where('batch_number', $request->batch_number)->count();
        }

        return $this->sessionDetail->where('course_id', $request->course_id)->where('batch_number', $request->batch_number)->count();
    }

    public function getSessionDetailBySessionIdAndCourseId($sessionId, $courseId)
    {
        return $this->sessionDetail->where('session_id', $sessionId)->where('course_id', $courseId)->first();
    }

    public function getAllSession()
    {

        return $this->model->where('status', 1)->orderBy('start_year', 'desc')->get();
    }

    public function lists()
    {
        $query = $this->model;

        if (Auth::guard('student_parent')->check()) {
            $user = Auth::guard('student_parent')->user();
            if ($user->student) {
                $query = $query->where('id', $user->student->session_id);
            }
        }

        return $query->orderBy('title', 'desc')->pluck('title', 'id');
    }

    public function listByStatus()
    {
        $query = $this->model;

        if (Auth::guard('student_parent')->check()) {
            $user = Auth::guard('student_parent')->user();
            if ($user->student) {
                $query = $query->where('id', $user->student->session_id);
            } else {
                $query = $query->whereHas('students', function ($q) use ($user) {
                    $q->whereIn('id', getStudentsIdByParentId($user->parent->id));
                });
            }
        }

        return $query->where('status', 1)->orderBy('title', 'desc')->pluck('title', 'id');
    }

    public function getSessionDetailByCourseIdAndPhaseId($courseId, $phaseId)
    {
        return $this->sessionPhaseDetail->where('phase_id', $phaseId)->with([
            'sessionDetail' => function ($q) use ($courseId) {
            $q->where('course_id', $courseId);
        }])->latest()->first();
    }

    public function getBatchBySessionIdAndCourseId($sessionId, $courseId)
    {
        return optional($this->sessionDetail->where([
            ['session_id', $sessionId],
            ['course_id', $courseId]
        ])->first(['batch_number']))->batch_number;
    }

    public function getTotalStudentBatchesBySessionIdAndCourseId($sessionId, $courseId)
    {
        return $this->sessionDetail->where([
            ['session_id', $sessionId],
            ['course_id', $courseId]
        ])->count();
    }

    public function getSessionPhaseDetailBySessionIdAndCourseId($sessionId, $courseId)
    {
        return $this->sessionPhaseDetail->whereHas('sessionDetail', function ($q) use ($sessionId, $courseId) {
            $q->where('session_id', $sessionId)->where('course_id', $courseId);
        })->with('phase')->get();
    }

    public function getSessionsGreaterThanCurrent($sessionId)
    {
        $startYear = $this->model->find($sessionId);
        return $this->model->where('start_year', '>=', $startYear->start_year)->orderBy('start_year')->pluck('title', 'id');
    }

    public function getCurrentSessionIdByCurrentYear($currentYear)
    {
        $data = $this->model->where('start_year', $currentYear)->first();
        if (!$data) {
            $data = $this->model->orderBy('start_year', 'desc')->first();
        }
        return $data->id;
    }

    public function getTotalStudentBatchesBySessionIdAndCourseIds($sessionId, $courseIds)
    {

        return $this->sessionDetail->where('session_id', $sessionId)->whereIn('course_id', [$courseIds])->count();
    }

    /**
     * Archive a session if all students have completed their degrees.
     *
     * @param int $sessionId
     * @return bool
     */
    public function archiveSessionIfEligible($sessionId)
    {
        $students = $this->student->where('followed_by_session_id', $sessionId)->get();
        $allCompleted = $students->every(function ($student) {
            return $student->status !== 1;
        });

        if ($allCompleted) {
            $session = $this->model->find($sessionId);
            $session->status = 2;
            $session->save();

            return true;
        }

        return false;
    }

    /**
     * Restore a session from archived status.
     *
     * @param int $sessionId
     * @return bool
     */
    public function restoreSession($sessionId)
    {
        $session = $this->model->find($sessionId);

        if ($session && $session->status == 2) {
            $session->status = 1;
            $session->save();

            return true;
        }

        return false;
    }
}
