<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\LessonPlanRequest;
use App\Services\Admin\LessonPlanService;
use App\Services\Admin\TeacherService;
use App\Services\Admin\TopicService;
use App\Services\Admin\CourseService;
use App\Models\LessonPlan;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use PDF;

class LessonPlanController extends Controller
{
    /**
     * @var LessonPlanService
     */
    protected $lessonPlanService;

    /**
     * @var TopicService
     */
    protected $topicService;

    /**
     * @var TeacherService
     */
    protected $teacherService;

    /**
     * @var CourseService
     */
    protected $courseService;

    /**
     * LessonPlanController constructor.
     *
     * @param LessonPlanService $lessonPlanService
     * @param TopicService $topicService
     * @param TeacherService $teacherService
     * @param CourseService $courseService
     */
    public function __construct(
        LessonPlanService $lessonPlanService,
        TopicService   $topicService,
        TeacherService $teacherService,
        CourseService $courseService
    ) {
        $this->lessonPlanService = $lessonPlanService;
        $this->topicService = $topicService;
        $this->teacherService = $teacherService;
        $this->courseService = $courseService;
    }

    public function index()
    {
        $data = [
            'pageTitle' => 'Lesson Plans',
            'courses' => $this->courseService->listByStatus(),
            'teachers' => $this->teacherService->getAllTeachers()->pluck('full_name', 'id'),
            'tableHeads' => ['ID', 'Title', 'Topic', 'Speaker', 'Place', 'Date', 'Time', 'Status', 'Action'],
            'dataUrl' => route('lesson.plan.data'),
            'columns' => [
                ['data' => 'id', 'name' => 'id'],
                ['data' => 'title', 'name' => 'title'],
                ['data' => 'topic_id', 'name' => 'topic_id'],
                ['data' => 'speaker_id', 'name' => 'speaker_id'],
                ['data' => 'place', 'name' => 'place'],
                ['data' => 'date', 'name' => 'date'],
                ['data' => 'time', 'name' => 'time'],
                ['data' => 'status', 'name' => 'status'],
                ['data' => 'action', 'name' => 'action', 'orderable' => false]
            ],
        ];

        return view('lesson_plan.index', $data);
    }

    /**
     * Show the form for creating a lesson plan for a topic.
     *
     * @param int $id
     * @return Response
     */
    public function create($id)
    {
        $data = [
            'pageTitle' => 'Create Lesson Plan',
            'topic' => $this->topicService->find($id),
            'teachers' => $this->topicService->getTeachersByTopicId($id),
        ];

        return view('lesson_plan.create', $data);
    }

    /**
     * Store a newly created lesson plan in storage.
     *
     * @param LessonPlanRequest $request
     * @param int $id
     * @return Response
     */
    public function store(LessonPlanRequest $request, $id)
    {
        $inputMethod = $request->input('input_method', 'form');
        $data = $request->all();

        // Handle PDF file upload
        if ($request->hasFile('pdf_file')) {
            $pdfFile = $request->file('pdf_file');
            $filePath = 'nemc_files/lesson_plans';
            $extension = $pdfFile->getClientOriginalExtension();
            $fileName = time() . '_' . uniqid() . '.' . $extension;
            $fullFilePath = $filePath . '/' . $fileName;

            if (!file_exists($filePath) && !mkdir($filePath, 0777, true) && !is_dir($filePath)) {
                throw new \RuntimeException(sprintf('Directory "%s" was not created', $filePath));
            }

            $pdfFile->move($filePath, $fileName);
            $data['pdf_file'] = $fullFilePath;
        }

        // Only build time_allocation if form method is used
        if ($inputMethod === 'form') {
            // Build contents as an associative array: key = context, value = time
            $contents = [];
            if ($request->has('contents_keys') && $request->has('contents_values')) {
                foreach ($request->contents_keys as $i => $key) {
                    $contents[] = [
                        'context' => $key,
                        'time' => $request->contents_values[$i] ?? '',
                    ];
                }
            }

            $timeAllocation = json_encode([
                'attendance' => $request->attendance,
                'objective' => $request->objective,
                'purpose' => $request->purpose,
                'prerequisite' => $request->prerequisite,
                'contents' => $contents,
                'summary' => $request->summary,
                'assessment' => $request->assessment,
            ]);
            $data['time_allocation'] = $timeAllocation;
        } elseif ($inputMethod === 'pdf') {
             // When switching to PDF mode, clear non-PDF fields for lesson plan update
             $data['place'] = null;
             $data['date'] = null;
             $data['start_time'] = null;
             $data['end_time'] = null;
             $data['duration'] = null;
             $data['method_of_instruction'] = null;
             $data['time_allocation'] = null;
        }

        $data['topic_id'] = $id;
        $lessonPlan = $this->lessonPlanService->storeLessonPlan($data);

        if ($lessonPlan) {
            $request->session()->flash('success', 'Lesson Plan created successfully');
            return redirect()->route('lesson.plan.show', $lessonPlan->id);
        }
        $request->session()->flash('error', 'Error creating Lesson Plan');
        return redirect()->route('topic.lesson.plan.create', $id);
    }

    /**
     * Display a listing of the lesson plans for a topic.
     *
     * @param int $id
     * @return Response
     */
    public function indexByTopicId($id)
    {
        $topic = $this->topicService->find($id);

        $data = [
            'pageTitle' => 'Lesson Plans for ' . $topic->title,
            'courses' => $this->courseService->listByStatus(),
            'topic' => $topic,
            'topics' => [$topic->id => $topic->title],
            'teachers' => $this->topicService->getTeachersByTopicId($id),
            'tableHeads' => ['ID', 'Title', 'Topic', 'Speaker', 'Place', 'Date', 'Time', 'Status', 'Action'],
            'dataUrl' => route('topic.lesson.plan.data.id', $id),
            'columns' => [
                ['data' => 'id', 'name' => 'id'],
                ['data' => 'title', 'name' => 'title'],
                ['data' => 'topic_id', 'name' => 'topic_id'],
                ['data' => 'speaker_id', 'name' => 'speaker_id'],
                ['data' => 'place', 'name' => 'place'],
                ['data' => 'date', 'name' => 'date'],
                ['data' => 'time', 'name' => 'time'],
                ['data' => 'status', 'name' => 'status'],
                ['data' => 'action', 'name' => 'action', 'orderable' => false]
            ],
        ];

        return view('lesson_plan.index', $data);
    }

    public function getData(Request $request)
    {
        return $this->lessonPlanService->getAllData($request);
    }

    public function allLessonPlansByTeacherId(Request $request, $id, $teacherId = null)
    {
        if ($teacherId) {
            $request->merge(['topic_id' => $id, 'speaker_id' => $teacherId]);
        } else {
            $request->merge(['topic_id' => $id]);
        }
        return $this->lessonPlanService->getAllData($request);
    }
    /**
     * Get lesson plans data for DataTables.
     *
     * @param Request $request
     * @param int $id
     * @return JsonResponse
     */
    public function getDataById(Request $request, $id)
    {
        $request->merge(['topic_id' => $id]);
        return $this->lessonPlanService->getAllData($request);
    }

    /**
     * Display the specified lesson plan.
     *
     * @param int $id
     * @return Response
     */
    public function show($id)
    {
        $lessonPlan = $this->lessonPlanService->find($id);

        $data = [
            'pageTitle' => 'Lesson Plan Details',
            'lessonPlan' => $lessonPlan,
        ];

        return view('lesson_plan.show', $data);
    }

    /**
     * Show the form for editing the specified lesson plan.
     *
     * @param int $id
     * @return Response
     */
    public function edit($id)
    {
        $lessonPlan = $this->lessonPlanService->find($id);

        $data = [
            'pageTitle' => 'Edit Lesson Plan',
            'lessonPlan' => $lessonPlan,
            'topic' => $lessonPlan->topic,
            'teachers' => $this->topicService->getTeachersByTopicId($lessonPlan->topic->id),
        ];

        return view('lesson_plan.edit', $data);
    }

    /**
     * Update the specified lesson plan in storage.
     *
     * @param LessonPlanRequest $request
     * @param int $id
     * @return Response
     */
    public function update(LessonPlanRequest $request, $id)
    {
        $lessonPlan = $this->lessonPlanService->find($id);
        $inputMethod = $request->input('input_method', $lessonPlan->pdf_file ? 'pdf' : 'form');
        $data = $request->all();

        // Handle PDF file upload
        $wasFormBased = !$lessonPlan->pdf_file && $lessonPlan->time_allocation;
        $isSwitchingToPdf = $inputMethod === 'pdf' && $wasFormBased;

        if ($request->hasFile('pdf_file')) {
            // Delete old PDF if exists
            if ($lessonPlan->pdf_file && file_exists(public_path($lessonPlan->pdf_file))) {
                @unlink(public_path($lessonPlan->pdf_file));
            }

            $pdfFile = $request->file('pdf_file');
            $filePath = 'nemc_files/lesson_plans';
            $extension = $pdfFile->getClientOriginalExtension();
            $fileName = time() . '_' . uniqid() . '.' . $extension;
            $fullFilePath = $filePath . '/' . $fileName;

            if (!file_exists($filePath) && !mkdir($filePath, 0777, true) && !is_dir($filePath)) {
                throw new \RuntimeException(sprintf('Directory "%s" was not created', $filePath));
            }

            $pdfFile->move($filePath, $fileName);
            $data['pdf_file'] = $fullFilePath;
        } elseif ($inputMethod === 'pdf' && $lessonPlan->pdf_file) {
            // Keep existing PDF if staying in PDF mode
            $data['pdf_file'] = $lessonPlan->pdf_file;
        } elseif ($inputMethod === 'form' || $request->has('remove_pdf')) {
            // Switching to form mode or explicitly removing PDF - remove PDF if exists
            if ($lessonPlan->pdf_file && file_exists(public_path($lessonPlan->pdf_file))) {
                @unlink(public_path($lessonPlan->pdf_file));
            }
            $data['pdf_file'] = null;
        } elseif ($isSwitchingToPdf && !$request->hasFile('pdf_file')) {
            // Switching from form to PDF but no file uploaded - validation should catch this
            // But as a safety measure, don't change pdf_file
            $data['pdf_file'] = $lessonPlan->pdf_file;
        }

        // Only build time_allocation if form method is used
        if ($inputMethod === 'form') {
            // Build contents as an associative array: key = context, value = time
            $contents = [];
            if ($request->has('contents_keys') && $request->has('contents_values')) {
                foreach ($request->contents_keys as $i => $key) {
                    $contents[] = [
                        'context' => $key,
                        'time' => $request->contents_values[$i] ?? '',
                    ];
                }
            }
            $timeAllocation = json_encode([
                'attendance' => $request->attendance,
                'objective' => $request->objective,
                'purpose' => $request->purpose,
                'prerequisite' => $request->prerequisite,
                'contents' => $contents,
                'summary' => $request->summary,
                'assessment' => $request->assessment,
            ]);
            $data['time_allocation'] = $timeAllocation;
        } elseif ($inputMethod === 'pdf') {
            // When switching to PDF mode, clear non-PDF fields for lesson plan update
            $data['place'] = null;
            $data['date'] = null;
            $data['start_time'] = null;
            $data['end_time'] = null;
            $data['duration'] = null;
            $data['method_of_instruction'] = null;
            $data['time_allocation'] = null;
        }

        $lessonPlan = $this->lessonPlanService->updateLessonPlan($data, $id);

        if ($lessonPlan) {
            $request->session()->flash('success', 'Lesson Plan updated successfully');
            return redirect()->route('lesson.plan.show', $lessonPlan->id);
        }

        $request->session()->flash('error', 'Error updating Lesson Plan');
        return redirect()->route('lesson.plan.edit', $id);
    }

    /**
     * Remove the specified lesson plan from storage.
     *
     * @param int $id
     * @return Response
     */
    public function delete($id)
    {
        $lessonPlan = $this->lessonPlanService->find($id);
        $topicId = $lessonPlan->topic_id;

        if ($this->lessonPlanService->delete($id)) {
            session()->flash('success', 'Lesson Plan deleted successfully');
        } else {
            session()->flash('error', 'Error deleting Lesson Plan');
        }

        return redirect()->route('lesson.plan.index', $topicId);
    }

    /**
     * Export the specified lesson plan as PDF.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function exportPdf($id)
    {
        $lessonPlan = $this->lessonPlanService->find($id);
        // Get department name from the lesson plan's topic's subject's department, if available
        $department = null;
        if ($lessonPlan->topic && $lessonPlan->topic->topicHead->subject->department) {
            $department = $lessonPlan->topic->topicHead->subject->department->title;
            $subject = $lessonPlan->topic->topicHead->subject->title;
        }

        $data = [
            'lessonPlan' => $lessonPlan,
            'department' => $department,
            'subject' => $subject,
        ];
        $document = 'lesson_plan' . ($subject ? '_of_' . str_replace(' ', '_', strtolower($subject)) : '') . '_' . strtotime(now()) . '.pdf';
        $pdf = PDF::loadView('lesson_plan.pdf', $data);
        return $pdf->stream($document);
    }

    /**
     * Download the uploaded PDF file for a lesson plan.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function downloadPdf($id)
    {
        $lessonPlan = $this->lessonPlanService->find($id);

        if (!$lessonPlan->pdf_file || !file_exists(public_path($lessonPlan->pdf_file))) {
            abort(404, 'PDF file not found');
        }

        return response()->download(public_path($lessonPlan->pdf_file));
    }
}
