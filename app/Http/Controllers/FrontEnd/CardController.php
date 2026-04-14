<?php

namespace App\Http\Controllers\FrontEnd;

use App\Http\Controllers\Controller;
use App\Http\Requests\CardRequest;
use App\Services\Admin\Admission\StudentGroupService;
use App\Services\Admin\CardService;
use App\Services\Admin\CourseService;
use App\Services\Admin\PhaseService;
use App\Services\Admin\SessionService;
use App\Services\Admin\SubjectService;
use App\Services\Admin\TermService;
use App\Services\UtilityServices;
use Illuminate\Http\Request;

class CardController extends Controller
{
    /**
     *
     */
    const moduleName = 'Cards';
    /**
     *
     */
    const redirectUrl = 'nemc/cards';
    /**
     *
     */
    const moduleDirectory = 'frontend.cards.';

    protected $service;
    protected $subjectService;
    protected $sessionService;
    protected $courseService;
    protected $phaseService;
    protected $termService;
    protected $studentGroupService;

    public function __construct(
        CardService $service, SubjectService $subjectService, SessionService $sessionService, CourseService $courseService,
        PhaseService $phaseService, TermService $termService, StudentGroupService $studentGroupService
    ){
        $this->service = $service;
        $this->subjectService = $subjectService;
        $this->sessionService = $sessionService;
        $this->courseService = $courseService;
        $this->phaseService = $phaseService;
        $this->termService = $termService;
        $this->studentGroupService = $studentGroupService;
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
        $data['courses'] = $this->courseService->getAllCourse();

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
            'tableHeads' => ['Item', 'Item Serial Number', 'Card','Subject', 'Status'],
            'dataUrl' => 'nemc/card_items/datatable',
            'columns' => [
                ['data' => 'title', 'name' => 'title'],
                ['data' => 'serial_number', 'name' => 'serial_number'],
                ['data' => 'card_id', 'name' => 'card_id'],
                ['data' => 'subject_id', 'name' => 'subject_id'],
                ['data' => 'status', 'name' => 'status'],
            ],
            'cardInfo' => $cardInfo
        ];

        $data['courses'] = $this->courseService->getAllCourse();
        return view(self::moduleDirectory.'.items.index', $data);
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function getItemsData(Request $request){
        return $this->service->getCardItemsDatatable($request);
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


    public function checkStudentGroupAlreadyGetMarkForItemExam(Request $request){
        $checkStudent = $this->service->checkExamMarkAlreadyGivenToStudentGroupByRollRangeAndItemId($request);
        if (empty($checkStudent)){
            return 'true';
        }

        return 'false';
    }
}
