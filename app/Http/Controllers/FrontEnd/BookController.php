<?php

namespace App\Http\Controllers\FrontEnd;

use App\Http\Controllers\Controller;
use App\Services\Admin\BookService;
use App\Services\Admin\SubjectService;
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

    protected $redirectUrl;

    public function __construct(BookService $bookService, SubjectService $subjectService){
        $this->redirectUrl = 'nemc/book';
        $this->bookService = $bookService;
        $this->subjectService = $subjectService;
    }


    public function index() {
        $data = [
            'pageTitle' => 'Book',
            'tableHeads' => ['Id',  'Title', 'Subject', 'Author', 'Edition', 'Reference link', 'Status', 'Action'],
            'dataUrl' => $this->redirectUrl.'/get-data',
            'columns' => [
                ['data' => 'id', 'name' => 'id'],
                ['data' => 'title', 'name' => 'title'],
                ['data' => 'subject_id', 'name' => 'subject_id'],
                ['data' => 'author', 'name' => 'author'],
                ['data' => 'edition', 'name' => 'edition'],
                ['data' => 'link', 'name' => 'link'],
                ['data' => 'status', 'name' => 'status'],
                ['data' => 'action', 'name' => 'action', 'orderable' => false]
            ],
        ];
        //get all subject
        $data['subjects'] = $this->subjectService->getAllSubject();

        return view('frontend.book.index', $data);
    }

    public function getData(Request $request){

        return $this->bookService->getAllData($request);
    }

}
