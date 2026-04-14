<?php

namespace App\Services\Admin;

use App\Events\NotifyUserWhenNoticePublished;
use App\Models\NoticeBoard;
use App\Services\BaseService;
use Carbon\Carbon;
use DataTables;
use Illuminate\Support\Facades\Auth;

/**
 * Class UserService
 * @package App\Services\Admin
 */
class NoticeBoardService extends BaseService {

    /**
     * @var $model
     */
    protected $model;
    /**
     * @var string
     */
    protected $url = 'admin/notice_board';


    public function __construct(NoticeBoard $noticeBoard)
    {
        $this->model = $noticeBoard;
    }


    /**
     *
     * @return JsonResponse
     */
    public function getAllData($request)
    {
        $query = $this->model->select();

    if (Auth::guard('student_parent')->check()){
    $user = Auth::guard('student_parent')->user();
        //if login user is student
        if ($user->student){
            $query = $query->where('session_id', $user->student->session_id)
                ->orWhereNull('session_id')
                           ->where('batch_type_id', $user->student->batch_type_id)
                ->orWhereNull('batch_type_id');
        }
        //if login user is parent
        elseif ($user->parent){
            $query = $query->where('session_id', $user->parent->students->first()->session_id)
                ->orWhereNull('session_id')
                ->where('batch_type_id', $user->parent->students->first()->batch_type_id)
                ->orWhereNull('batch_type_id');
        }
    }

        return Datatables::of($query)
            ->addColumn('action', function ($row) {
                $actions = '';

                if (hasPermission('notice_board/edit')) {
                    $actions.= '<a href="' . route('notice_board.edit', [$row->id]) . '" class="m-portlet__nav-link btn m-btn m-btn--hover-brand m-btn--icon m-btn--icon-only m-btn--pill" title="Edit"><i class="flaticon-edit"></i></a>';
                }

                if (hasPermission('notice_board/view')) {
                    $actions.= '<a href="' . route(customRoute('notice_board.show'), [$row->id]) . '" class="m-portlet__nav-link btn m-btn m-btn--hover-brand m-btn--icon m-btn--icon-only m-btn--pill" title="View"><i class="flaticon-eye"></i></a>';
                }


                return $actions;
            })
            ->editColumn('status', function ($row) {
                if (!empty($row->published_date) && $row->status == 1){
                    return setNoticeBoardStatus($row->status = 2);
                }
                return setNoticeBoardStatus($row->status);
            })

            ->editColumn('file_path', function ($row) {
                return isset($row->file_path) && file_exists(public_path('nemc_files/noticeBoard/'.$row->file_path)) ? '<a href="' . asset('nemc_files/noticeBoard/'.$row->file_path) .'" class="btn m-btn m-btn--hover-brand m-btn--icon m-btn--icon-only m-btn--pill" target="_blank" title="Download " download><i class="fa fa-download"></i></a>' : '--';

            })

            ->rawColumns(['file_path', 'status', 'action', 'description'])

            ->filter(function ($query) use ($request) {

                if ($request->get('title')) {
                    $query->where('title', 'like', '%'.$request->get('title').'%');
                }

                if (!empty($request->get('published_date'))) {
                    // change date format as in the database
                    $publishDate = Carbon::createFromFormat('d/m/Y', $request->get('published_date'))->format('Y-m-d');
                    $query->whereDate('published_date', $publishDate);
                }

            })

            ->make(true);
    }

    // save notice file and data
    public function saveNoticeData($request)
    {
        if ($request->hasFile('notice_file')) {
            $file = $request->file('notice_file');
            $currentDate = Carbon::now()->toDateString();

            $fileName = $currentDate .'_'. uniqid(). '_' .$file->getClientOriginalName();

            //if directory not exist make directory
            if (!file_exists('nemc_files/noticeBoard')) {
                mkdir('nemc_files/noticeBoard', 0777 , true);
            }

            $file->move('nemc_files/noticeBoard',$fileName);
            $request['file_path'] = $fileName;
        }

        $notice = $this->model->create($request->except(['notice_file', 'files', 'department_ids']));

        if ($request->filled('department_ids') && is_array($request->department_ids)) {
            $notice->departments()->sync($request->department_ids);
        }

        return $notice;
    }

    // update notice file and data
    public function updateNoticeData($request, $id)
    {
        $oldNoticeInfo = $this->find($id);
        $isNewlyPublished = !empty($request->is_publish) && $request->is_publish != $oldNoticeInfo->is_publish;

        if ($request->hasFile('notice_file')) {
            $file = $request->file('notice_file');
            $currentDate = Carbon::now()->toDateString();
            $fileName = $currentDate . '_' . uniqid() . '_' . $file->getClientOriginalName();

            if (!file_exists('nemc_files/noticeBoard')) {
                mkdir('nemc_files/noticeBoard', 0777, true);
            }

            $file->move('nemc_files/noticeBoard', $fileName);
            $request['file_path'] = $fileName;
        } else {
            $request['file_path'] = $oldNoticeInfo->file_path;
        }

        $updateData = [
            'title' => $request->title,
            'session_id' => checkEmpty($request->session_id),
            'course_id' => checkEmpty($request->course_id),
            'phase_id' => checkEmpty($request->phase_id),
            'batch_type_id' => checkEmpty($request->batch_type_id),
            'published_date' => checkEmpty($request->published_date),
            'file_path' => checkEmpty($request->file_path),
            'description' => $request->description,
            'status' => $request->status,
        ];
        //only update is_publish if it's newly checked
        if ($isNewlyPublished) {
            $updateData['is_publish'] = $request->is_publish;
        }

        $oldNoticeInfo->update($updateData);

        //Sync departments into pivot table
        if ($request->filled('department_ids') && is_array($request->department_ids)) {
            $oldNoticeInfo->departments()->sync($request->department_ids);
        }

        //Fire event if publishing newly
        if ($isNewlyPublished) {
            $updatedNotice = $this->findWith($id, ['departments']);
            event(new NotifyUserWhenNoticePublished($updatedNotice));
        }

        return $oldNoticeInfo;
    }

    public function getLastFiveNotice($sessionId){
        $query =  $this->model->where('status', 1);
            if(!empty($sessionId)){
                $query = $query->where('session_id', $sessionId)->orWhereNull('session_id');
            }
            return $query->orderBy('created_at', 'desc')
            ->take(5)
            ->get();
    }

}
