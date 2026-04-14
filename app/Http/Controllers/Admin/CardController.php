<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\CardRequest;
use App\Services\Admin\Admission\StudentGroupService;
use App\Services\Admin\CardService;
use App\Services\Admin\CourseService;
use App\Services\Admin\PhaseService;
use App\Services\Admin\SessionService;
use App\Services\Admin\StudentGroupTypeService;
use App\Services\Admin\SubjectService;
use App\Services\Admin\TeacherService;
use App\Services\Admin\TermService;
use App\Services\UtilityServices;
use Illuminate\Http\Request;
use Validator;

class CardController extends Controller
{
    /**
     *
     */
    const moduleName = 'Cards';
    /**
     *
     */
    const redirectUrl = 'admin/cards';
    /**
     *
     */
    const moduleDirectory = 'cards.';

    protected $service;
    protected $subjectService;
    protected $sessionService;
    protected $courseService;
    protected $phaseService;
    protected $termService;
    protected $studentGroupService;
    protected $studentGroupTypeService;
    protected $teacherService;

    public function __construct(
        CardService $service, SubjectService $subjectService, SessionService $sessionService, CourseService $courseService,
        PhaseService            $phaseService, TermService $termService, StudentGroupService $studentGroupService, TeacherService $teacherService,
        StudentGroupTypeService $studentGroupTypeService
    ){
        $this->service = $service;
        $this->subjectService = $subjectService;
        $this->sessionService = $sessionService;
        $this->courseService = $courseService;
        $this->phaseService = $phaseService;
        $this->termService = $termService;
        $this->studentGroupService = $studentGroupService;
        $this->studentGroupTypeService = $studentGroupTypeService;
        $this->teacherService = $teacherService;
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
            'tableHeads' => ['Card', 'Subject', 'Phase', 'Term', 'Items', 'Description', 'Status', 'Action'],
            'dataUrl' => self::redirectUrl.'/get-data',
            'columns' => [
                ['data' => 'title', 'name' => 'title'],
                ['data' => 'subject_id', 'name' => 'subject_id'],
                ['data' => 'phase_id', 'name' => 'phase_id'],
                ['data' => 'term_id', 'name' => 'term_id'],
                ['data' => 'items', 'name' => 'items'],
                ['data' => 'description', 'name' => 'description'],
                ['data' => 'status', 'name' => 'status'],
                ['data' => 'action', 'name' => 'action', 'orderable' => false]
            ],
        ];
        $data['courses'] = $this->courseService->listByStatus();

        return view(self::moduleDirectory.'index', $data);
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function getData(Request $request){
        return $this->service->getDatatable($request);
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
            /*'subjects' => $this->subjectService->listByStatus(),*/
            'phases' => $this->phaseService->listByStatus(),
            'terms' => $this->termService->listByStatus(),
        ];

        $data['courses'] = $this->courseService->listByStatus();

        return view(self::moduleDirectory.'add', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CardRequest $request)
    {
        $card = $this->service->saveCards($request);

        if ($card){
            $request->session()->flash('success', setMessage('create', 'Card'));
            return redirect()->route('cards.index');
        }else{
            $request->session()->flash('error', setMessage('create.error', 'Card'));
            return redirect()->route('cards.index');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Card  $card
     * @return \Illuminate\Http\Response
     */
    public function show($id) {
        $data = [
            'pageTitle' => self::moduleName,
            'card' => $this->service->find($id)
        ];

        return view(self::moduleDirectory.'view', $data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Card  $card
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data = [
            'pageTitle' => self::moduleName,
            'phases' => $this->phaseService->listByStatus(),
            'terms' => $this->termService->listByStatus(),
            'card' => $this->service->find($id)
        ];
        $data['courses'] = $this->courseService->getAllCourse();

        return view(self::moduleDirectory.'edit', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Card  $card
     * @return \Illuminate\Http\Response
     */
    public function update(CardRequest $request, $id) {
        $card = $this->service->updateCards($request, $id);

        if ($card){
            $request->session()->flash('success', setMessage('update', 'Card'));
            return redirect()->route('cards.index');
        }else{
            $request->session()->flash('error', setMessage('update.error', 'Card'));
            return redirect()->route('cards.index');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Card  $card
     * @return \Illuminate\Http\Response
     */
    public function destroy(Card $card)
    {
        //
    }

    /**
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function getCardsBySubjectId($id){
        $cards = $this->service->getCardsBySubjectId($id);

        return response()->json(['status' => true, 'data' => $cards]);
    }

    /**
     * @return array|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function cardItems(Request $request){
        $cardId = $request->has('card_id') ? $request->card_id : '';
        $cardInfo = !empty($cardId) ? $this->service->find($cardId) : [];

        $data = [
            'pageTitle' => 'Card Items',
            'tableHeads' => ['Item', 'Item Serial Number', 'Card','Subject', 'Status', 'Action'],
            'dataUrl' => 'admin/card_items/datatable',
            'columns' => [
                ['data' => 'title', 'name' => 'title'],
                ['data' => 'serial_number', 'name' => 'serial_number'],
                ['data' => 'card_id', 'name' => 'card_id'],
                ['data' => 'subject_id', 'name' => 'subject_id'],
                ['data' => 'status', 'name' => 'status'],
                ['data' => 'action', 'name' => 'action', 'orderable' => false]
            ],
            'cardInfo' => $cardInfo
        ];

        $data['courses'] = $this->courseService->listByStatus();

        return view(self::moduleDirectory.'.items.index', $data);
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function getItemsData(Request $request){
        return $this->service->getCardItemsDatatable($request);
    }

    /**
     * @param null $cardId
     * @return array|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function createCardItems($cardId = null) {
        $card = !empty($cardId) ? $this->service->find($cardId) : '';
        $data = [
            'pageTitle' => self::moduleName,
            'subjects' => $this->subjectService->listByStatus(),
            'card' => $card

        ];
        $data['courses'] = $this->courseService->listByStatus();
        return view(self::moduleDirectory.'.items.add', $data);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function saveCardItems(Request $request){
        // check title unique in item title array
        $validator = Validator::make($request->all(), [
            'title' => 'required|unique:card_items',
        ]);

        // if any item exist in database then redirect to list page otherwise add to database
        if ($validator->fails()) {
            $request->session()->flash('error', 'Item title already added, Please try unique item name');
            return redirect()->route('cardItems.index');
        }

        $cardItems = $this->service->addCardItems($request);
        if ($cardItems){
            $request->session()->flash('success', setMessage('update', 'Card items'));
            return redirect()->route('cardItems.index');
        }

        $request->session()->flash('error', setMessage('update.error', 'Card items'));
        return redirect()->route('cardItems.index');
    }

    /**
     * @param $cardId
     * @return array|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function editCardItems($cardId) {
        $data = [
            'pageTitle' => self::moduleName,
            'subjects' => $this->subjectService->listByStatus(),
            'cardItem' => $this->service->getCardItemById($cardId)
        ];
        $data['courses'] = $this->courseService->getAllCourse();

        return view(self::moduleDirectory.'.items.edit', $data);
    }

   /* public function viewCardItems($cardId)
    {
        $data = [
            'pageTitle' => self::moduleName,
            'cardItem' => $this->service->getCardItemById($cardId)
        ];

        return view(self::moduleDirectory.'.items.view', $data);
    }*/

    /**
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function updateCardItems(Request $request, $id){
        $cardItems = $this->service->updateCardItems($request, $id);

        if ($cardItems){
            $request->session()->flash('success', setMessage('update', 'Card items'));
            return redirect()->route('cardItems.index');
        }else{
            $request->session()->flash('error', setMessage('update.error', 'Card items'));
            return redirect()->route('cardItems.index');
        }
    }

    //check item serial number uniqueness under a card
    public function checkCardItemSerialNumberExist(Request $request){
        $check = $this->service->ItemSerialNumberExist($request->cardId, $request->id, $request->serial_number);

        if (empty($check)){
            return 'true';
        }else{
            return 'false';
        }
    }

    public function createItemExam($id){
        $data = [
            'pageTitle' => 'Create Item Exam',
            'sessions' => $this->sessionService->listByStatus(),
            'courses' => $this->courseService->listByStatus(),
            'phases' => $this->phaseService->listByStatus(),
            'terms' => $this->termService->listByStatus(),
            'itemInfo' => $this->service->getCardItemById($id),
            'itemId' => $id,
            'itemMaxMark' => \Setting::getSiteSetting()->item_exam_mark,
            'groupTypes' => $this->studentGroupTypeService->listByStatus(),
            'teachers' => $this->teacherService->getAllTeachers()->pluck('full_name', 'id'),
        ];
        return view('exams.items.add', $data);
    }

    public function saveItemExam(Request $request, $id){

        $itemExam = $this->service->saveItemExamMarks($request, $id);

        if ($itemExam){
            $request->session()->flash('success', setMessage('create', 'Card items'));
        }else{
            $request->session()->flash('error', setMessage('create.error', 'Card items'));
        }

        return redirect()->route('result.index');
    }

    public function checkStudentGroupAlreadyGetMarkForItemExam(Request $request){
        $checkStudent = $this->service->checkExamMarkAlreadyGivenToStudentGroupByRollRangeAndItemId($request);
        if (empty($checkStudent)){
            return 'true';
        }
        return 'false';
    }

    //get item max serial number by cardId
    public function getItemMaxSerialByCardId(Request $request){
        $itemSerial = '';
        if ($request->filled('cardId')){
            $itemSerial = $this->service->getCardItemMaxSerialByCardId($request->cardId);
        }
        return response()->json([
            'status' => true,
            'data' => $itemSerial
        ]);

    }

    //get item list by cardId
    public function getItemNamesByCardId(Request $request){
        $itemList = '';
        if ($request->filled('cardId')){
            $itemList = $this->service->getCardItemListByCardId($request->cardId);
        }
        return response()->json([
            'status' => true,
            'data' => $itemList
        ]);
    }
}
