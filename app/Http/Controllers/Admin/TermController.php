<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\TermRequest;
use App\Services\Admin\TermService;
use App\Term;
use Illuminate\Http\Request;

class TermController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    protected $termService;

    protected $redirectUrl;

    public function __construct(TermService $termService){
        $this->redirectUrl = 'admin/term';
        $this->termService = $termService;
    }


    public function index(){
        $data = [
            'pageTitle' => 'Term',
            'tableHeads' => ['Id', 'Title', 'Status', 'Action'],
            'dataUrl' => $this->redirectUrl.'/get-data',
            'columns' => [
                ['data' => 'id', 'name' => 'id'],
                ['data' => 'title', 'name' => 'title'],
                ['data' => 'status', 'name' => 'status'],
                ['data' => 'action', 'name' => 'action', 'orderable' => false]
            ],
        ];

        return view('term.index', $data);
    }

    public function getData(Request $request){

        return $this->termService->getAllData($request);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {
        $data = [
            'pageTitle' => 'Term Create',
        ];
        return view('term.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(TermRequest $request) {

        $term = $this->termService->create($request->all());

        if ($term) {
            $request->session()->flash('success', setMessage('create', 'Term'));
            return redirect()->route('term.index');
        } else {
            $request->session()->flash('error', setMessage('create.error', 'Term'));
            return redirect()->route('term.index');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Term  $term
     * @return \Illuminate\Http\Response
     */
    public function show(Term $term)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Term  $term
     * @return \Illuminate\Http\Response
     */
    public function edit($id) {
        $data = [
            'pageTitle' => 'Edit Term',
            'term' => $this->termService->find($id),
        ];
        return view('term.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Term  $term
     * @return \Illuminate\Http\Response
     */
    public function update(TermRequest $request, $id) {

        $term = $this->termService->update($request->all(), $id);

        if ($term) {
            $request->session()->flash('success', setMessage('update', 'Term'));
            return redirect()->route('term.index');
        } else {
            $request->session()->flash('error', setMessage('update.error', 'Term'));
            return redirect()->route('term.index');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Term  $term
     * @return \Illuminate\Http\Response
     */
    public function destroy(Term $term)
    {
        //
    }
}
