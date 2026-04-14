<?php

namespace App\Services\Admin;

use App\Models\Book;
use App\Models\Subject;
use App\Services\BaseService;
use DataTables;
use Illuminate\Support\Facades\Auth;

/**
 * Class UserService
 * @package App\Services\Admin
 */
class BookService extends BaseService {

    /**
     * @var $model
     */
    protected $model;
    /**
     * @var string
     */
    protected $url = 'admin/book';
    protected $subjectModel;


    /**
     * TopicService constructor.
     * @param Topic $topic
     */
    public function __construct(Book $book, Subject $subject)
    {
        $this->model = $book;
        $this->subjectModel = $subject;
    }


    /**
     *
     * @return JsonResponse
     */
    public function getAllData($request)
    {
        $query = $this->model->with('subject')->select();

        if (Auth::guard('web')->check()){
            $user = Auth::guard('web')->user();
            if ($user->teacher){
                $query = $query->whereIn('subject_id', getSubjectsIdByTeacherId($user->teacher->id, $user->teacher->course_id));
            }
        }
        elseif (Auth::guard('student_parent')->check()) {
            $user = Auth::guard('student_parent')->user();
            //if login user is student
            if ($user->student) {
                //get subject id by student course id
                $subjectIds = $this->subjectModel->whereHas('subjectGroup', function ($q) use ($user) {
                    $q->where('course_id', $user->student->course_id);
                })->pluck('id');
            } //if login user is parent
            elseif ($user->parent) {
                $subjectIds = $this->subjectModel->whereHas('subjectGroup', function ($q) use ($user) {
                    $q->where('course_id', $user->parent->students->first()->course_id);
                })->pluck('id');
            }
            $query = $query->whereIn('subject_id', $subjectIds);
        }

        return Datatables::of($query)
            ->addColumn('action', function ($row) {
                $actions = '';

                if (hasPermission('book/edit')) {
                    $actions.= '<a href="' . route('book.edit', [$row->id]) . '" class="m-portlet__nav-link btn m-btn m-btn--hover-brand m-btn--icon m-btn--icon-only m-btn--pill" title="Edit"><i class="flaticon-edit"></i></a>';
                }
                else{
                    $actions.= '--';
                }

                return $actions;
            })

            //auto incremented serial number
            ->addIndexColumn()

            ->editColumn('subject_id', function ($row) {
                return isset($row->subject) ?  $row->subject->title : '';
            })
            ->editColumn('status', function ($row) {
                return setStatus($row->status);
            })
            ->editColumn('link', function ($row) {
                return '<a target="_blank" href="'.$row->link.'">'.$row->link_title.'</a>';
            })
            ->rawColumns(['link', 'status', 'action'])

            ->filter(function ($query) use ($request) {

                if ($request->get('title')) {
                    $query->where('title', 'like', '%'.$request->get('title').'%');
                }
                if ($request->get('author')) {
                    $query->where('author', 'like', '%'.$request->get('author').'%');
                }

                if (!empty($request->get('subject_id'))) {
                    $query->where('subject_id', $request->get('subject_id'));
                }

            })

            ->make(true);
    }

}
