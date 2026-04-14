<?php
/**
 * Created by PhpStorm.
 * User: office
 * Date: 2/7/19
 * Time: 2:25 PM
 */

namespace App\Services;


use App\Models\Attachment;
use App\Models\AttachmentType;
use Carbon\Carbon;
use DataTables;
use Illuminate\Support\Facades\Storage as DiskStorage;
use Intervention\Image\Facades\Image as Image;

class AttachmentService extends BaseService
{

    const admissionDir = 'nemc_files/admission';
    const admissionStudentDir = 'nemc_files/admission_students';
    const teacherDir = 'nemc_files/teachers';
    const studentAttachmentDir = 'nemc_files/students/attachments';
    const userAttachmentDir = 'nemc_files/users';

    protected $attachmentType;
    protected $url = 'admin/attachment_type';

    public function __construct(Attachment $attachment, AttachmentType $attachmentType)
    {
        $this->model = $attachment;
        $this->attachmentType = $attachmentType;
    }

    public function getListOfAttachmentTypes(){
        return $this->attachmentType->where('status', 1)->orderBy('title', 'asc')->pluck('title', 'id');
    }

    public function uploadAttachment($file, $type)
    {
        $attachment = $file->file('file');
        $filePath  = '';
        $fileName  = '';
        $pathInfo = [];

        if ($type == 'admission'){
            if (!file_exists(self::admissionDir)) {
                mkdir(self::admissionDir, 755, true);
            }
            $filePath = self::admissionDir;
            $fileName = time() . '_' . str_replace(' ', '_',$attachment->getClientOriginalName());
            $pathInfo = pathinfo(self::admissionDir . '/' . $fileName);

        }else if ($type == 'admission.student.photo'){
            if (!file_exists(self::admissionStudentDir)) {
                mkdir(self::admissionStudentDir, 755, true);
            }
            $filePath = self::admissionStudentDir;
            $fileName = time() . '_' . str_replace(' ', '_',$attachment->getClientOriginalName());
            $pathInfo = pathinfo(self::admissionStudentDir . '/' . $fileName);

        } else if ($type == 'teacher.photo'){
            if (!file_exists(self::teacherDir)) {
                mkdir(self::teacherDir, 755, true);
            }
            $filePath = self::teacherDir;
            $fileName = time() . '_' . str_replace(' ', '_',$attachment->getClientOriginalName());
            $pathInfo = pathinfo(self::teacherDir . '/' . $fileName);

        }else if ($type == 'student.attachments'){
            if (!file_exists(self::studentAttachmentDir)) {
                mkdir(self::studentAttachmentDir, 755, true);
            }
            $filePath = self::studentAttachmentDir;
            $fileName = time() . '_' . str_replace(' ', '_',$attachment->getClientOriginalName());
            $pathInfo = pathinfo(self::studentAttachmentDir . '/' . $fileName);
        }else if ($type == 'user.photo'){
            if (!file_exists(self::userAttachmentDir)) {
                mkdir(self::userAttachmentDir, 755, true);
            }
            $filePath = self::userAttachmentDir;
            $fileName = time() . '_' . str_replace(' ', '_',$attachment->getClientOriginalName());
            $pathInfo = pathinfo(self::userAttachmentDir . '/' . $fileName);
        }

        if ($type == 'admission.student.photo'){
            Image::make($attachment)->resize(300, null, function ($constraint) {
                $constraint->aspectRatio();
            })->save(self::admissionStudentDir . '/' . $fileName)->destroy();
        }else if ($type == 'teacher.photo'){
            Image::make($attachment)->resize(300, null, function ($constraint) {
                $constraint->aspectRatio();
            })->save(self::teacherDir . '/' . $fileName)->destroy();
        }else{
            $attachment->move($filePath, $fileName);
        }

        return [
            'name' => $pathInfo['basename'],
            'full_path' => $filePath . '/' . $fileName,
            'extension' => $pathInfo['extension']
        ];

        /*if ($attachment->move($filePath, $fileName)) {
            return [
                'name' => $pathInfo['basename'],
                'full_path' => $filePath . '/' . $fileName,
                'extension' => $pathInfo['extension']
            ];
        }*/
    }

    public function getAllData($request)
    {
        $query = $this->attachmentType->select();

        return Datatables::of($query)
            ->addColumn('action', function ($row) {
                $actions = '';

                if (hasPermission('attachment_type/edit')) {
                    $actions.= '<a href="' . route('attachment_type.edit', [$row->id]) . '" class="m-portlet__nav-link btn m-btn m-btn--hover-brand m-btn--icon m-btn--icon-only m-btn--pill" title="Edit"><i class="flaticon-edit"></i></a>';
                }

                /*$actions.= '<a href="' . route('attachment_type.show', [$row->id]) . '" class="m-portlet__nav-link btn m-btn m-btn--hover-brand m-btn--icon m-btn--icon-only m-btn--pill" title="View"><i class="flaticon-eye"></i></a>';*/

                return $actions;
            })
            ->editColumn('status', function ($row) {
                return setStatus($row->status);
            })
            ->rawColumns(['status', 'action'])
            ->make(true);
    }
    //save attachment to table
    public function saveAttachment($request){

        return $this->attachmentType->create($request);
    }

    //get single attachment
    public function editAttachment($id) {

        return $this->attachmentType->find($id);
    }

    //get single attachment
    public function updateAttachment($request, $id) {
        return $this->attachmentType->find($id)->update($request);

        //return $this->attachmentType->find($id);
    }

    public function getAttachmentsDataTableByStudentId($request, $id){

        $query = $this->model->where('student_id', $id)->select();

        return Datatables::of($query)
            ->editColumn('attachment_type_id', function ($row) {
                return isset($row->attachmentType) ? $row->attachmentType->title : '';
            })
            ->editColumn('created_at', function ($row) {
                /*return Carbon::parse($row->created_at)->toDateString();*/
                return Carbon::parse($row->created_at)->format('m/d/Y');
            })
            ->addColumn('action', function ($row) {
                $actions= '<a href="' . asset($row->file_path) . '" class=" btn m-btn m-btn--hover-brand m-btn--icon m-btn--icon-only m-btn--pill" target="_blank" title="Download"><i class="fa fa-download"></i></a>';

                if (getAppPrefix() == 'admin'){
                    if (hasPermission('attachment/delete')) {
                        $actions .= '<a href="javascript:void(0)" class="btn m-btn m-btn--icon m-btn--icon-only remove-attachment" data-attachment-id="' . $row->id . '" data-student-id="' . $row->student_id . '" title="Delete"><i class="fa fa-trash-alt"></i></a>';
                    }
                }

                return $actions;
            })
            ->rawColumns(['status', 'action'])
            ->make(true);
    }

    public function addAttachments($request, $id){

        $attachment = '';
        foreach ($request->file_path as $key => $path) {
            $attachments = [
                'attachment_type_id' => $request->attachment_type_id[$key],
                'student_id' => $id,
                'file_path' => $path,
                'type' => $request->type[$key],
                'remarks' => checkEmpty($request->remarks[$key]),
            ];

            $attachment = $this->create($attachments);
        }

        return $attachment;
    }

    public function deleteAttachment($id){
        $attachment = $this->find($id);
        DiskStorage::delete($attachment->file_path);

        return $attachment->delete();
    }

    public function getAttachmentIdByStudentIdAndBankSlip($student_id, $bankSlipNumber){
        return $this->model->where([
            ['student_id', '=', $student_id],
            ['title', '=', $bankSlipNumber],
        ])->first();

    }

}
