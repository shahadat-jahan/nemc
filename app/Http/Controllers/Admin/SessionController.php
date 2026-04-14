<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\Admin\PhaseService;
use App\Services\Admin\SessionService;
use App\Services\Admin\SubjectService;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

/**
 * Class SessionController
 * @package App\Http\Controllers\Admin
 */
class SessionController extends Controller
{

    /**
     *
     */
    const moduleName = 'Session Management';
    /**
     *
     */
    const redirectUrl = 'admin/sessions';
    /**
     *
     */
    const moduleDirectory = 'sessions.';

    /**
     * @var SessionService
     */
    protected $service;
    /**
     * @var PhaseService
     */
    protected $phaseService;
    /**
     * @var SubjectService
     */
    protected $subjectService;

    /**
     * SessionController constructor.
     * @param SessionService $service
     * @param PhaseService $phaseService
     * @param SubjectService $subjectService
     */
    public function __construct(SessionService $service, PhaseService $phaseService, SubjectService $subjectService)
    {
        $this->service = $service;
        $this->phaseService = $phaseService;
        $this->subjectService = $subjectService;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = [
            'pageTitle' => self::moduleName,
            'tableHeads' => ['Id', 'Title', 'Start Year', 'Status', 'Action'],
            'dataUrl' => self::redirectUrl . '/get-data',
            'columns' => [
                ['data' => 'id', 'name' => 'id'],
                ['data' => 'title', 'name' => 'title'],
                ['data' => 'start_year', 'name' => 'start_year'],
                ['data' => 'status', 'name' => 'status'],
                ['data' => 'action', 'name' => 'action', 'orderable' => false]
            ],
        ];

        return view(self::moduleDirectory . 'index', $data);
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function getData(Request $request)
    {
        return $this->service->getDataTable($request);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data = [
            'pageTitle' => self::moduleName,
            'phases' => $this->phaseService->listByStatus(),
            'mbbs_subjects' => $this->subjectService->getLists(1),
            'bds_subjects' => $this->subjectService->getLists(2),
        ];

        return view(self::moduleDirectory . 'create', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $sessions = $this->service->addSession($request);

        if ($sessions) {
            $request->session()->flash('success', setMessage('create', 'Session'));
            return redirect()->route('sessions.index');
        }

        $request->session()->flash('error', setMessage('create.error', 'Session'));
        return redirect()->route('sessions.index');
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Session $session
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $data = [
            'pageTitle' => self::moduleName,
            'sessionData' => $this->service->find($id),
        ];

        return view(self::moduleDirectory . 'view', $data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Session $session
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data = [
            'pageTitle' => self::moduleName,
            'sessionData' => $this->service->find($id),
            'phases' => $this->phaseService->listByStatus(),
            'mbbs_subjects' => $this->subjectService->getLists(1),
            'bds_subjects' => $this->subjectService->getLists(2),
            'check_edit' => $this->service->checkSessionSttaus($id),
        ];

        return view(self::moduleDirectory . 'edit', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Session $session
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $sessions = $this->service->editSession($request, $id);

        if ($sessions) {
            $request->session()->flash('success', setMessage('update', 'Session'));
            return redirect()->route('sessions.index');
        }

        $request->session()->flash('error', setMessage('update.error', 'Session'));
        return redirect()->route('sessions.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Session $session
     * @return \Illuminate\Http\Response
     */
    public function destroy(Session $session)
    {
        //
    }

    public function checkBatchIsUnique(Request $request)
    {
        $check = $this->service->checkBatchIsUnique($request);

        if (empty($check)) {
            return 'true';
        }

        return 'false';
    }

    //clone session
    public function cloneSession($id)
    {
        $data = [
            'pageTitle' => self::moduleName,
            'sessionData' => $this->service->find($id),
            'phases' => $this->phaseService->listByStatus(),
            'mbbs_subjects' => $this->subjectService->getLists(1),
            'bds_subjects' => $this->subjectService->getLists(2),
            'check_edit' => $this->service->checkSessionSttaus($id),
        ];

        return view(self::moduleDirectory . 'clone_session', $data);
    }

    //save clone session data
    public function saveCloneSessionData(Request $request)
    {
        $request->validate([
            'title' => 'required|unique:sessions',
        ]);
        $sessions = $this->service->addSession($request);

        if ($sessions) {
            $request->session()->flash('success', setMessage('create', 'Session'));
            return redirect()->route('sessions.index');
        }

        $request->session()->flash('error', setMessage('create.error', 'Session'));
        return redirect()->route('sessions.index');
    }

    public function archiveSession(Request $request, $id)
    {
        $archived = $this->service->archiveSessionIfEligible($id);
        if ($archived) {
            $request->session()->flash('success', 'Session archived successfully.');
        } else {
            $request->session()->flash('error', 'Session cannot be archived. Not all students have completed their degrees.');
        }

        return redirect()->route('sessions.index');
    }

    // `app/Http/Controllers/Admin/SessionController.php`
    public function restoreSession(Request $request, $id)
    {
        $restored = $this->service->restoreSession($id);

        if ($restored) {
            $request->session()->flash('success', 'Session restored successfully.');
        } else {
            $request->session()->flash('error', 'Session cannot be restored.');
        }

        return redirect()->route('sessions.index');
    }
}
