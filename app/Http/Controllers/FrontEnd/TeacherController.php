<?php

namespace App\Http\Controllers\FrontEnd;

use App\Http\Controllers\Controller;
use App\Models\TeacherEvaluation;
use App\Models\TeacherEvaluationStatement;
use App\Services\Admin\CourseService;
use App\Services\Admin\DepartmentService;
use App\Services\Admin\DesignationService;
use App\Services\Admin\TeacherService;
use App\Services\UtilityServices;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class TeacherController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    protected $teacherService;
    protected $departmentService;
    protected $designationService;
    protected $courseService;

    protected $redirectUrl;

    public function __construct(TeacherService $teacherService, DepartmentService $departmentService, DesignationService $designationService,
         CourseService $courseService){
        $this->redirectUrl = 'nemc/teacher';
        $this->teacherService = $teacherService;
        $this->departmentService = $departmentService;
        $this->designationService = $designationService;
        $this->courseService = $courseService;
    }

    public function index(){
        $data = [
            'pageTitle' => 'Teacher',
            'tableHeads' => ['Id','Image','Name', 'Designation', 'Department', 'Phone', 'Email', 'Course', 'Status', 'Action'],
            'dataUrl' => $this->redirectUrl.'/get-data',
            'columns' => [
                ['data' => 'id', 'name' => 'id'],
                ['data' => 'photo', 'name' => 'photo'],
                ['data' => 'name', 'name' => 'name'],
                ['data' => 'designation_id', 'name' => 'designation_id'],
                ['data' => 'department_id', 'name' => 'department_id'],
                ['data' => 'phone', 'name' => 'phone'],
                ['data' => 'email', 'name' => 'email'],
                ['data' => 'course_id', 'name' => 'course_id'],
                ['data' => 'status', 'name' => 'status'],
                ['data' => 'action', 'name' => 'action', 'orderable' => false]
            ],
        ];

        //get all department
        $data['departments'] = $this->departmentService->getAllDepartment();
        //get all course
        $data['courses'] = $this->courseService->getAllCourse();
        return view('frontend.teacher.index', $data);
    }

    public function getData(Request $request){
        return $this->teacherService->getAllData($request);
    }

    public function show($id)
    {
        $teacher = $this->teacherService->findWith($id, ['evaluations.statementRatings']);

        $roleModelPercentage = $teacher->getRoleModelPercentage();
        $averageRating = TeacherEvaluationStatement::whereHas('evaluation', function($q) use ($id) {
            $q->where('teacher_id', $id);
        })->avg('rating');

        // If student is logged in, check their evaluation
        $hasEvaluated = false;
        $userEvaluation = null;

        if (Auth::guard('student_parent')->check()) {
            $user = Auth::guard('student_parent')->user();
            if ($user->student) {
                $student = $user->student;

                // Check if student has evaluated this teacher in current phase
                $userEvaluation = $this->teacherService->getEvaluationByStudentAndTeacher($student, $id);

                $hasEvaluated = $userEvaluation !== null;

                // Get phase-specific statistics for this student's phase
                if ($student->phase_id) {
                    $phaseEvaluations = $teacher->evaluations()
                                                ->where('phase_id', $student->phase_id)
                                                ->get();

                    $totalEvaluations = $phaseEvaluations->count();
                    $roleModelCount = $phaseEvaluations->where('is_role_model', true)->count();
                    $roleModelPercentage = $totalEvaluations > 0 ? ($roleModelCount / $totalEvaluations) * 100 : 0;

                    // Average rating for this phase
                    $evaluationIds = $phaseEvaluations->pluck('id');
                    $averageRating = TeacherEvaluationStatement::whereIn('teacher_evaluation_id', $evaluationIds)
                                                               ->avg('rating');
                }
            }
        }

        $data = [
            'pageTitle' => 'Teacher Detail',
            'teacher' => $teacher,
            'averageRating' => round($averageRating, 2),
            'roleModelPercentage' => round($roleModelPercentage, 2),
            'totalEvaluations' => $totalEvaluations,
            'hasEvaluated' => $hasEvaluated,
            'userEvaluation' => $userEvaluation,
        ];

        return view('frontend.teacher.view', $data);
    }

    /**
     * Show evaluation form (student side)
     */
    public function evaluationCreate($teacherId)
    {
        $evaluationStatements = UtilityServices::$evaluationStatements;
        $user = Auth::guard('student_parent')->user();

        if (!$user || !$user->student) {
            return redirect()->back()->with('error', 'Only students can evaluate teachers.');
        }

        $student = $user->student;
        $teacher              = $this->teacherService->find($teacherId);

        // Check if student has already evaluated this teacher in current phase
        $existingEvaluation = $this->teacherService->getEvaluationByStudentAndTeacher($student, $teacherId);

        if ($existingEvaluation) {
            return redirect()->route('frontend.teacher.show', $teacherId)
                             ->with('error', 'You have already evaluated this teacher for this phase.');
        }

        $data = [
            'pageTitle' => 'Evaluate Teacher',
            'teacher' => $teacher,
            'student' => $student,
            'evaluationStatements' => $evaluationStatements,
        ];

        return view('frontend.teacher.evaluation.create', $data);
    }

    /**
     * Store a new evaluation
     */
    public function evaluationStore(Request $request, $teacherId)
    {
        $evaluationStatements = UtilityServices::$evaluationStatements;
        $user = Auth::guard('student_parent')->user();

        if (!$user || !$user->student) {
            return redirect()->back()->with('error', 'Only students can evaluate teachers.');
        }

        $student = $user->student;
        $teacher              = $this->teacherService->find($teacherId);

        if (!$teacher) {
            return redirect()->back()->with('error', 'Teacher not found.');
        }

        // Check if already evaluated
        $existingEvaluation = $this->teacherService->getEvaluationByStudentAndTeacher($student, $teacher->d);

        if ($existingEvaluation) {
            return redirect()->route('frontend.teacher.show', $teacherId)
                             ->with('error', 'You have already evaluated this teacher for this phase.');
        }

        DB::beginTransaction();
        try {
            // Create ONE evaluation record
            $evaluation = TeacherEvaluation::create([
                'student_id' => $student->id,
                'teacher_id' => $teacherId,
                'session_id' => $student->session_id,
                'course_id' => $student->course_id,
                'phase_id' => $student->phase_id,
                'is_role_model' => $request->boolean('is_role_model'),
            ]);

            // Create statement ratings in pivot table
            $ratingsData = [];
            foreach ($evaluationStatements as $statementId => $statementText) {
                $ratingKey = "statement_{$statementId}_rating";
                $ratingsData[] = [
                    'statement_id' => $statementId,
                    'rating' => $request->input($ratingKey),
                ];
            }

            $evaluation->statementRatings()->createMany($ratingsData);

            DB::commit();

            return redirect()->route('frontend.teacher.show', $teacherId)
                             ->with('success', 'Thank you for your evaluation!');

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Evaluation creation failed: ' . $e->getMessage());

            return redirect()->back()
                             ->with('error', 'Failed to submit evaluation. Please try again.')
                             ->withInput();
        }
    }

    /**
     * Show the edit form for an existing evaluation
     */
    public function evaluationEdit($id)
    {
        $evaluationStatements = UtilityServices::$evaluationStatements;
        $user = Auth::guard('student_parent')->user();

        if (!$user || !$user->student) {
            return redirect()->back()->with('error', 'Only students can evaluate teachers.');
        }

        $student = $user->student;

        // Load the evaluation with its ratings
        $evaluation = TeacherEvaluation::with(['teacher', 'statementRatings'])
            ->find($id);

        // Get ratings as array for easy access in view
        $ratings = $evaluation->statementRatings->pluck('rating', 'statement_id')->toArray();

        $data = [
            'pageTitle' => 'Update Teacher Evaluation',
            'teacher' => $evaluation->teacher,
            'student' => $student,
            'evaluation' => $evaluation,
            'ratings' => $ratings,
            'evaluationStatements' => $evaluationStatements,
        ];

        return view('frontend.teacher.evaluation.edit', $data);
    }

    /**
     * Update an existing evaluation
     */
    public function evaluationUpdate(Request $request, $id)
    {
        $evaluationStatements = UtilityServices::$evaluationStatements;
        $user = Auth::guard('student_parent')->user();

        if (!$user || !$user->student) {
            return redirect()->back()->with('error', 'Only students can evaluate teachers.');
        }

        // Load evaluation
        $evaluation = TeacherEvaluation::find($id);

        DB::beginTransaction();
        try {
            // Update the main evaluation record
            $evaluation->update([
                'is_role_model' => $request->boolean('is_role_model'),
            ]);

            // Update each statement rating
            foreach ($evaluationStatements as $statementId => $statementText) {
                $ratingKey = "statement_{$statementId}_rating";

                TeacherEvaluationStatement::updateOrCreate(
                    [
                        'teacher_evaluation_id' => $evaluation->id,
                        'statement_id' => $statementId,
                    ],
                    [
                        'rating' => $request->input($ratingKey),
                    ]
                );
            }

            DB::commit();

            return redirect()->route('frontend.teacher.show', $evaluation->teacher_id)
                             ->with('success', 'Your evaluation has been updated successfully!');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Evaluation update failed: ' . $e->getMessage());

            return redirect()->back()
                             ->with('error', 'Failed to update evaluation. Please try again.')
                             ->withInput();
        }
    }

    public function getTeachersBySubjectId(Request $request)
    {

        $teachers = $this->teacherService->getTeachersBySubjectId($request->subjectId);

        return response()->json(['status' => true, 'data' => $teachers]);
    }
}
