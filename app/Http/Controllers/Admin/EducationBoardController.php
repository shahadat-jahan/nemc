<?php

namespace App\Http\Controllers\Admin;

use App\EducationBoard;
use App\Http\Controllers\Controller;
use App\Http\Requests\EducationBoardRequest;
use App\Services\Admin\EducationBoardService;
use Illuminate\Http\Request;

class EducationBoardController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    protected $educationBoardService;

    protected $redirectUrl;

    public function __construct(EducationBoardService $educationBoardService){
        $this->redirectUrl = 'admin/education_board';
        $this->educationBoardService = $educationBoardService;
    }


    public function index(){
        $data = [
            'pageTitle' => 'Education Board',
            'tableHeads' => ['Id', 'Title', 'Status', 'Action'],
            'dataUrl' => $this->redirectUrl.'/get-data',
            'columns' => [
                ['data' => 'id', 'name' => 'id'],
                ['data' => 'title', 'name' => 'title'],
                ['data' => 'status', 'name' => 'status'],
                ['data' => 'action', 'name' => 'action', 'orderable' => false]
            ],
        ];

        return view('educationBoard.index', $data);
    }

    public function getData(Request $request){

        return $this->educationBoardService->getAllData($request);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {
        $data = [
            'pageTitle' => 'Education Board Create',
        ];
        return view('educationBoard.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(EducationBoardRequest $request) {

        $board = $this->educationBoardService->create($request->all());

        if ($board){
            $request->session()->flash('success', setMessage('create', 'Education Board'));
            return redirect()->route('education_board.index');
        }else{
            $request->session()->flash('error', setMessage('create.error', 'Education Board'));
            return redirect()->route('education_board.index');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\EducationBoard  $educationBoard
     * @return \Illuminate\Http\Response
     */
    public function show($id){
        $data = [
            'pageTitle' => 'Education Board Details',
            'educationBoard' => $this->educationBoardService->find($id)
        ];

        if ($data['educationBoard']) {
            return view('educationBoard.view', $data);
        }

        return redirect($this->redirectUrl)->with('message', setMessage('error', 'Class Type'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\EducationBoard  $educationBoard
     * @return \Illuminate\Http\Response
     */
    public function edit($id) {
        $data = [
            'pageTitle' => 'Edit Education Board',
            'educationBoard' => $this->educationBoardService->find($id),
        ];
        return view('educationBoard.edit', $data);

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\EducationBoard  $educationBoard
     * @return \Illuminate\Http\Response
     */
    public function update(EducationBoardRequest $request, $id) {

        $board = $this->educationBoardService->update($request->all(), $id);

        if ($board){
            $request->session()->flash('success', setMessage('update', 'Education Board'));
            return redirect()->route('education_board.index');
        }else{
            $request->session()->flash('error', setMessage('update.error', 'Education Board'));
            return redirect()->route('education_board.index');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\EducationBoard  $educationBoard
     * @return \Illuminate\Http\Response
     */
    public function destroy(EducationBoard $educationBoard)
    {
        //
    }
}
