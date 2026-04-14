<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\Admin\PageService;
use App\Http\Requests\PageRequest;

class PageController extends Controller
{

    protected $moduleName;
    protected $redirectUrl;
    protected $pageDirectory;
    protected $pageService;

    /**
     * PageController constructor.
     * @param PageService $pageService
     */
    public function __construct(PageService $pageService)
    {
        $this->moduleName = 'Page';
        $this->redirectUrl = 'admin/pages';
        $this->pageDirectory = 'pages.';
        $this->service = $pageService;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = [
            'pageTitle' => str_plural($this->moduleName),
            'dataUrl' => $this->redirectUrl.'/getData',
            'tableHeads' => ['Id', 'Title', 'Slug', 'Meta description', 'Meta keyword', 'Status', 'Action'],
            'columns' => [
                ['data' => 'id', 'name' => 'id'],
                ['data' => 'title', 'name' => 'title'],
                ['data' => 'slug', 'name' => 'slug'],
                ['data' => 'meta_description', 'name' => 'meta_description'],
                ['data' => 'meta_keyword', 'name' => 'meta_keyword'],
                ['data' => 'status', 'name' => 'status'],
                ['data' => 'action', 'name' => 'action', 'orderable' => false]
            ],
            'pages' => $this->service->lists(),
        ];

        return view($this->pageDirectory.'index', $data);
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function getData(Request $request)
    {
        return $this->service->getAllData($request);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view($this->pageDirectory.'create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(PageRequest $request)
    {
        $request->merge(['slug' => strtolower($request->get('slug'))]);
        $request->request->remove('files');

        $this->service->create($request->all());

        return redirect($this->redirectUrl)->with('message', setMessage('create', $this->moduleName));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $data = [
            'page' => $this->service->find($id),
        ];

        $data['metaKeywords'] = explode(',', $data['page']->meta_keyword);

        return view($this->pageDirectory.'view', $data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data = [
            'pageTitle' => 'Edit '.$this->moduleName,
            'page' => $this->service->find($id)
        ];

        return view($this->pageDirectory.'edit', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(PageRequest $request, $id)
    {
        $request->merge(['slug' => strtolower($request->get('slug'))]);
        $request->request->remove('files');

        $this->service->update($request->all(), $id);
        return redirect($this->redirectUrl)->with('message', setMessage('update', $this->moduleName));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
