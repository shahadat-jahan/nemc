<?php

namespace App\Services\Admin;

use App\Models\StaticRoutine;
use App\Services\BaseService;
use DataTables;
use File;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use RuntimeException;

class StaticRoutineService extends BaseService
{
    /**
     * @var $model
     */
    protected $model;
    /**
     * @var string
     */
    protected $url = 'admin/static_routine';

    public function __construct(StaticRoutine $model)
    {
        $this->model = $model;
    }

    /**
     * Get all data for DataTables
     *
     * @param $request
     * @return JsonResponse
     */
    public function getAllData($request)
    {
        $query = $this->model->with('session', 'phase')->select();

        return Datatables::of($query)
            ->addColumn('action', function ($row) {
                $actions = '';
                if (hasPermission('static_routine/view')) {
                    $actions .= '<a href="' . route('static_routine.show', [$row->id]) . '" class="m-portlet__nav-link btn m-btn m-btn--hover-brand m-btn--icon m-btn--icon-only m-btn--pill" title="View"><i class="flaticon-eye"></i></a>';
                }

                if (hasPermission('static_routine/edit')) {
                    $actions .= '<a href="' . route('static_routine.edit', [$row->id]) . '" class="m-portlet__nav-link btn m-btn m-btn--hover-brand m-btn--icon m-btn--icon-only m-btn--pill" title="Edit"><i class="flaticon-edit"></i></a>';
                }
                if (hasPermission('static_routine/delete')) {
                    $actions .= '<a href="javascript:void(0)" class="btn m-btn m-btn--icon m-btn--icon-only text-danger routine-delete"
                                 title="Delete" data-routine-id="' . $row->id . '"><i class="flaticon-delete"></i></a>';
                }

                return $actions;
            })
            ->addColumn('session_id', function ($row) {
                return $row->session ? $row->session->title : '-';
            })
            ->addColumn('phase_id', function ($row) {
                return $row->phase ? $row->phase->title : '-';
            })
            ->editColumn('status', function ($row) {
                return setStatus($row->status);
            })
            ->addIndexColumn()
            ->rawColumns(['status', 'action'])
            ->filter(function ($query) use ($request) {
                if ($request->get('title')) {
                    $query->where('title', 'like', '%' . $request->get('title') . '%');
                }
                if ($request->get('session_id')) {
                    $query->where('session_id', $request->get('session_id'));
                }
                if ($request->get('phase_id')) {
                    $query->where('phase_id', $request->get('phase_id'));
                }
            })
            ->make(true);
    }

    public function save($request)
    {
        $data = $request->except('routine_file');

        if ($request->file('routine_file')) {
            $attachment = $request->file('routine_file');
            $filePath = 'nemc_files/static_routine';
            $extension = $attachment->getClientOriginalExtension();
            $fileName = time() . '.' . $extension;
            $fullFilePath = $filePath . '/' . $fileName;

            if (!file_exists($filePath) && !mkdir($filePath, 755, true) && !is_dir($filePath)) {
                throw new RuntimeException(sprintf('Directory "%s" was not created', $filePath));
            }
            $attachment->move($filePath, $fileName);
            $data['file_path'] = $fullFilePath;
        }

        return $this->model->create($data);
    }

    public function update($request, $staticRoutine)
    {
        $data = $request->except('routine_file');

        if ($request->hasFile('routine_file')) {
            if (!empty($staticRoutine->file_path) && file_exists($staticRoutine->file_path)) {
                File::delete($staticRoutine->file_path);
            }

            $attachment = $request->file('routine_file');
            $filePath = 'nemc_files/static_routine';
            $extension = $attachment->getClientOriginalExtension();
            $fileName = time() . '.' . $extension;
            $fullFilePath = $filePath . '/' . $fileName;

            if (!file_exists($filePath) && !mkdir($filePath, 755, true) && !is_dir($filePath)) {
                throw new RuntimeException(sprintf('Directory "%s" was not created', $filePath));
            }

            $attachment->move($filePath, $fileName);
            $data['file_path'] = $fullFilePath;
        } else {
            $data['file_path'] = $staticRoutine->file_path;
        }

        return $staticRoutine->update($data);
    }

    public function find($id)
    {
        return $this->model->find($id);
    }
}
