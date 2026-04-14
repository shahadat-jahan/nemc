<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\DesignationsRequest;
use App\Services\Admin\DesignationService;
use Illuminate\Http\Request;

class DesignationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    /**
    * Display a listing of the resource.
    *
    * @return \Illuminate\Http\Response
    */

    /**
     * @var DesignationService
     */
    protected $designation;
    protected $redirectUrl;
    protected $designationService;

    public function __construct(DesignationService $designationService){
        $this->redirectUrl = 'admin/designation';
        $this->designation = $designationService;
    }


    public function index(){
        $data = [
            'pageTitle' => 'Designation',
            'tableHeads' => ['Id', 'Title', 'Description', 'Org order', 'Status', 'Action'],
            'dataUrl' => $this->redirectUrl.'/get-data',
            'columns' => [
                ['data' => 'id', 'name' => 'id'],
                ['data' => 'title', 'name' => 'title'],
                ['data' => 'description', 'name' => 'description'],
                ['data' => 'org_order', 'name' => 'org_order'],
                ['data' => 'status', 'name' => 'status'],
                ['data' => 'action', 'name' => 'action', 'orderable' => false]
            ],
        ];

        return view('designation.index', $data);
    }

    public function getData(Request $request){
        return $this->designation->getAllData($request);
    }



    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {
        $data = [
            'pageTitle' => 'Designation create',
        ];
        return view('designation.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(DesignationsRequest $request){
        $designation = $this->designation->create($request->all());

        if ($designation) {
            $request->session()->flash('success', setMessage('create', 'Designation'));
            return redirect()->route('designation.index');
        } else {
            $request->session()->flash('error', setMessage('create.error', 'Designation'));
            return redirect()->route('designation.index');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Designation  $designation
     * @return \Illuminate\Http\Response
     */
    public function show($id) {
        $data = [
            'pageTitle' => 'Designation Details',
            'designation' => $this->designation->find($id)
        ];

        return view('designation.view', $data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Designation  $designation
     * @return \Illuminate\Http\Response
     */
    public function edit($id){
        $data = [
            'designation' => $this->designation->find($id),
        ];
        return view('designation.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Designation  $designation
     * @return \Illuminate\Http\Response
     */
    public function update(DesignationsRequest $request, $id){
        $designation = $this->designation->update($request->all(), $id);

        if ($designation) {
            $request->session()->flash('success', setMessage('update', 'Designation'));
            return redirect()->route('designation.index');
        } else {
            $request->session()->flash('error', setMessage('update.error', 'Designation'));
            return redirect()->route('designation.index');
        }
    }
}
