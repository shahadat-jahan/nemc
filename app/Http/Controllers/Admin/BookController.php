<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\BookRequest;
use App\Services\Admin\BookService;
use App\Services\Admin\CourseService;
use App\Services\Admin\SubjectService;
use function GuzzleHttp\Promise\all;
use Illuminate\Http\Request;

class BookController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    protected $bookService;
    protected $subjectService;
    protected $courseService;

    protected $redirectUrl;

    public function __construct(BookService $bookService, SubjectService $subjectService, CourseService $courseService){
        $this->redirectUrl = 'admin/book';
        $this->bookService = $bookService;
        $this->subjectService = $subjectService;
        $this->courseService = $courseService;
    }


    public function index() {
        $data = [
            'pageTitle' => 'Book',
            'tableHeads' => ['Id', 'Serial No.', 'Title', 'Subject', 'Author', 'Edition', 'Reference link', 'Status', 'Action'],
            'dataUrl' => $this->redirectUrl.'/get-data',
            'columns' => [
                ['data' => 'id', 'name' => 'id'],
                ['data' => 'DT_RowIndex', 'name' => 'DT_RowIndex'],
                ['data' => 'title', 'name' => 'title'],
                ['data' => 'subject_id', 'name' => 'subject_id'],
                ['data' => 'author', 'name' => 'author'],
                ['data' => 'edition', 'name' => 'edition'],
                ['data' => 'link', 'name' => 'link'],
                ['data' => 'status', 'name' => 'status'],
                ['data' => 'action', 'name' => 'action', 'orderable' => false]
            ],
        ];
        //get all course
        $data['courses'] = $this->courseService->listByStatus();

        return view('book.index', $data);
    }

    public function getData(Request $request){

        return $this->bookService->getAllData($request);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {
        $data = [
            'pageTitle' => 'Book Create',
        ];
        //get all course
        $data['courses'] = $this->courseService->listByStatus();

        return view('book.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(BookRequest $request) {

        $book = $this->bookService->create($request->except('course_id', 'subject_group_id'));

        if ($book) {
            $request->session()->flash('success', setMessage('create', 'Book'));
            return redirect()->route('book.index');
        } else {
            $request->session()->flash('error', setMessage('create.error', 'Book'));
            return redirect()->route('book.index');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Topic  $topic
     * @return \Illuminate\Http\Response
     */
    public function show(Topic $topic)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Topic  $topic
     * @return \Illuminate\Http\Response
     */
    public function edit($id) {
        $data = [
            'pageTitle' => 'Book Edit',
            'book' => $this->bookService->find($id),
        ];
        //get all course
        $data['courses'] = $this->courseService->getAllCourse();
        return view('book.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Topic  $topic
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id) {
        //return $request->all();

        $book = $this->bookService->update($request->except('course_id', 'subject_group_id'), $id);

        if ($book) {
            $request->session()->flash('success', setMessage('update', 'Book'));
            return redirect()->route('book.index');
        } else {
            $request->session()->flash('error', setMessage('update.error', 'Book'));
            return redirect()->route('book.index');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Topic  $topic
     * @return \Illuminate\Http\Response
     */
    public function destroy(Topic $topic)
    {
        //
    }

}
