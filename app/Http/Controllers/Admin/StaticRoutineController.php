<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\StaticRoutine;
use App\Services\Admin\StaticRoutineService;
use App\Services\Admin\PhaseService;
use App\Services\Admin\SessionService;
use File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use RuntimeException;

class StaticRoutineController extends Controller
{
    /**
     * Module name
     */
    const moduleName = 'Static Routine';

    /**
     * Redirect URL
     */
    const redirectUrl = 'admin/static_routine';

    /**
     * Module directory
     */
    const moduleDirectory = 'static_routine.';

    protected $staticRoutineService;
    protected $sessionService;
    protected $phaseService;

    /**
     * Constructor
     */
    public function __construct(
        StaticRoutineService $staticRoutineService,
        SessionService $sessionService,
        PhaseService $phaseService
    ) {
        $this->staticRoutineService = $staticRoutineService;
        $this->sessionService = $sessionService;
        $this->phaseService = $phaseService;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $data = [
            'pageTitle' => self::moduleName,
            'sessions' => $this->sessionService->listByStatus(),
            'phases' => $this->phaseService->listByStatus(),
            'tableHeads' => ['Sl.', 'Title', 'Session', 'Phase', 'Status', 'Action'],
            'dataUrl' => self::redirectUrl . '/get-data',
            'columns' => [
                ['data' => 'DT_RowIndex', 'name' => 'DT_RowIndex', 'orderable' => false, 'searchable' => false],
                ['data' => 'title', 'name' => 'title'],
                ['data' => 'session_id', 'name' => 'session_id'],
                ['data' => 'phase_id', 'name' => 'phase_id'],
                ['data' => 'status', 'name' => 'status'],
                ['data' => 'action', 'name' => 'action', 'orderable' => false]
            ],
        ];

        return view(self::moduleDirectory . 'index', $data);
    }

    public function getData(Request $request)
    {
        return $this->staticRoutineService->getAllData($request);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        $data = [
            'pageTitle' => self::moduleName,
            'sessions' => $this->sessionService->listByStatus(),
            'phases' => $this->phaseService->listByStatus(),
        ];

        return view(self::moduleDirectory . 'create', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'session_id' => 'required|exists:sessions,id',
            'phase_id' => 'required|exists:phases,id',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'routine_file' => 'required|file|mimes:pdf,doc,docx,xls,xlsx,jpg,jpeg,png|max:1024',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        // Check if the session and phase combination already exists
        $existingRoutine = StaticRoutine::where('session_id', $request->session_id)
            ->where('phase_id', $request->phase_id)
            ->first();

        if ($existingRoutine) {
            $request->session()->flash('error', 'A static routine for this session and phase already exists.');
            return redirect()->back()->withInput();
        }

        // Create static routine
        $staticRoutine = $this->staticRoutineService->save($request);

        if ($staticRoutine) {
            $request->session()->flash('success', setMessage('create', self::moduleName));
        } else {
            $request->session()->flash('error', setMessage('create.error', self::moduleName));
        }

        return redirect()->route('static_routine.index');
    }

    /**
     * Display the specified resource.
     *
     * @param StaticRoutine $staticRoutine
     * @return \Illuminate\View\View
     */
    public function show(StaticRoutine $staticRoutine)
    {
        $data = [
            'pageTitle' => self::moduleName,
            'routine' => $staticRoutine,
        ];

        return view(self::moduleDirectory . 'view', $data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param StaticRoutine $staticRoutine
     * @return \Illuminate\View\View
     */
    public function edit(StaticRoutine $staticRoutine)
    {
        $data = [
            'pageTitle' => self::moduleName,
            'routine' => $staticRoutine,
            'sessions' => $this->sessionService->listByStatus(),
            'phases' => $this->phaseService->listByStatus(),
        ];

        return view(self::moduleDirectory . 'edit', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, StaticRoutine $staticRoutine)
    {
        $validator = Validator::make($request->all(), [
            'session_id' => 'required|exists:sessions,id',
            'phase_id' => 'required|exists:phases,id',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'routine_file' => 'nullable|file|mimes:pdf,doc,docx,xls,xlsx,jpg,jpeg,png|max:1024',
            'status' => 'required|in:0,1',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // Check if the session and phase combination already exists
        $existingRoutine = StaticRoutine::where('session_id', $request->session_id)
            ->where('phase_id', $request->phase_id)
            ->where('id', '!=', $staticRoutine->id)
            ->first();
        if ($existingRoutine) {
            $request->session()->flash('error', 'A static routine for this session and phase already exists.');
            return redirect()->back()->withInput();
        }

        // Handle file upload if a new file is provided
        $staticRoutine = $this->staticRoutineService->update($request, $staticRoutine);

        if ($staticRoutine) {
            $request->session()->flash('success', setMessage('update', self::moduleName));
        } else {
            $request->session()->flash('error', setMessage('update.error', self::moduleName));
        }

        return redirect()->route('static_routine.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id)
    {
        $staticRoutine = $this->staticRoutineService->find($id);
        // Delete file
        if ($staticRoutine->file_path) {
            File::delete($staticRoutine->file_path);
        }

        $deleted = $staticRoutine->delete();

        if ($deleted) {
            return response()->json([
                'status' => true,
                'message' => 'Deleted successfully',
            ]);
        }

        return response()->json([
            'status' => false,
            'message' => 'Delete failed',
        ]);
    }

    /**
     * Get static routines by phase and session
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getStaticRoutinesByPhaseAndSession(Request $request)
    {
        $sessionId = $request->input('session_id');
        $phaseId = $request->input('phase_id');

        if (!$sessionId || !$phaseId) {
            return response()->json([
                'status' => false,
                'message' => 'Session and phase are required',
                'data' => []
            ]);
        }

        $staticRoutine = StaticRoutine::where('session_id', $sessionId)
            ->where('phase_id', $phaseId)
            ->where('status', 1)
            ->first();

        if ($staticRoutine) {
            return response()->json([
                'status' => true,
                'message' => 'Static routine found',
                'data' => $staticRoutine
            ]);
        }

        return response()->json([
            'status' => false,
            'message' => 'No static routine found for the selected session and phase',
            'data' => null
        ]);
    }
}
