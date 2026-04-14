<?php

namespace App\Services\Admin;

use App\Services\BaseService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Spatie\Activitylog\Models\Activity;
use Yajra\DataTables\DataTables;
use Yajra\DataTables\DataTables as YajraDatatable;

class ActivityLogService
{
    protected $dataTable;
    protected $request;
    private $baseService;


    public function __construct(DataTables $dataTable,
                                BaseService $baseService,
                                Request    $request)
    {
        $this->dataTable = $dataTable;
        $this->request = $request;
        $this->baseService = $baseService;
    }

    public function getDataTableResponse()
    {
        $request = $this->request;
        $query = Activity::query();
        return DataTables::of($query)
            ->escapeColumns([])
            ->editColumn('user', function ($item) {
                $causerText = '';
                if ($item->causer) {
                    $user = $item->causer;
                    if ($user->student != null) {
                        $causerText = '<a href="' . url('admin/users') . '/' . $user->id . '">' . $user->student->full_name_en . ' - '.$user->group->group_name.'</a>';
                    }elseif ($user->parent != null) {
                        $causerText = '<a href="' . url('admin/users') . '/' . $user->id . '">' . $user->parent->father_name . ' - '.$user->group->group_name.'</a>';
                    }elseif ($user->teacher != null) {
                        $causerText = '<a href="' . url('admin/users') . '/' . $user->id . '">' . $user->teacher->full_name . ' - ' . $user->group->group_name . '</a>';
                    }else{
                        $causerText = '<a href="' . url('admin/users') . '/' . $user->id . '">' . $user->name . ' - '.$user->group->group_name.'</a>';
                    }
                }else {
                    $causerText = '<span class="label label-danger">No User</span>';
                }

                return $causerText;

            })
            ->editColumn('target', function ($item) {
                if ($item->subject_type) {
                    $target = explode('\\', $item->subject_type);
                    $target = end($target);
                } else {
                    $target = '';
                }
                if ($item->description) {
                    $action = $item->description;
                } else {
                    $action = '';
                }
                return $target . ' ' . $action;

            })
            ->editColumn('changes', function ($item) {
                $return = '';
                $changesArray = $item->properties->toArray();
                if ($item->properties) {
                    if (array_key_exists('old', $changesArray) and array_key_exists('attributes', $changesArray)) {
                        //Updates of fields found
                        foreach ($changesArray['old'] as $key => $oldValue) {
                            if ($key == '_token' or $key == 'password') {
                                continue;
                            }
                            if ($oldValue == null or $oldValue == '') {
                                $oldValue = 'null';
                            }
                            if (is_array($oldValue)) {
                                $oldValue = json_encode($oldValue, JSON_PRETTY_PRINT);
                            }
                            $oldValue = strip_tags($oldValue);
                            if (strlen($oldValue) > 70) {
                                $oldValue = substr($oldValue, 0, 70) . '....';
                            }
                            if (isset($changesArray['attributes'][$key])) {
                                if ($changesArray['attributes'][$key] == null or $changesArray['attributes'][$key] == '') {
                                    $newValue = null;
                                } else {
                                    $newValue = $changesArray['attributes'][$key];
                                }
                            } else {
                                continue;
                            }
                            if (is_array($newValue)) {
                                $newValue = json_encode($newValue, JSON_PRETTY_PRINT);
                            }
                            $newValue = strip_tags($newValue);
                            if (strlen($newValue) > 70) {
                                $newValue = substr($newValue, 0, 70) . '....';
                            }
                            $return .= $key . ': ' . $oldValue . ' > ' . $newValue . '<br>';
                        }
                    } elseif (array_key_exists('attributes', $changesArray) and is_array($changesArray['attributes'])) {
                        //Creation of fields found
                        foreach ($changesArray['attributes'] as $key => $value) {
                            if ($value != null and $value != '') {
                                if ($key == '_token' or $key == 'password') {
                                    continue;
                                }
                                if (is_array($value)) {
                                    $value = json_encode($value, JSON_PRETTY_PRINT);
                                }
                                $value = strip_tags($value);
                                if (strlen($value) > 70) {
                                    $value = substr($value, 0, 70) . '....';
                                }
                                $return .= $key . ': ' . $value . '<br>';
                            }
                        }
                    }else {
                        foreach ($changesArray as $key => $value) {
                            $value = json_encode($value, JSON_PRETTY_PRINT);
                            if (strlen($value) > 70) {
                                $value = substr($value, 0, 70) . '....';
                            }
                            $return .= $key . ': ' . $value . '<br>';
                        }
                    }
                }
                return $return;

            })
            ->editColumn('date', function ($item) {
                if ($item->created_at) {
                    $time = Carbon::parse($item->created_at);
                    return $time->toDayDateTimeString() . ' (' . $time->diffForHumans() . ')';
                }
            })
//            ->addColumn('action', function ($row) {
//                $actions = '';
//                if (getAppPrefix() == 'admin') {
//                    $actions .= '<a href="' . route('activity.logs.show', [$row->id]) . '" class="m-portlet__nav-link btn m-btn m-btn--hover-brand m-btn--icon m-btn--icon-only m-btn--pill" data-toggle="tooltip" title="View"><i class="flaticon-eye"></i></a>';
//                }
//                return $actions;
//            })
//            ->rawColumns(['action'])
            ->filter(function ($query) use ($request) {
                if ($request->filled('causer_id')) {
                    $query->where('causer_id', $request->get('causer_id'));
                }
                if ($request->filled('subject_type')) {
                    $query->where('subject_type', $request->get('subject_type'));
                }
                if ($request->filled('date_from')) {
                    $fromDate = Carbon::createFromFormat('d/m/Y',  $request->get('date_from'))->format('Y-m-d');
                    $query->whereDate('created_at', '>=', $fromDate);
                }
                if ($request->filled('date_to')) {
                    $toDate = Carbon::createFromFormat('d/m/Y', $request->get('date_to'))->format('Y-m-d');
                    $query->whereDate('created_at', '<=', $toDate);
                }
            })
            ->make(true);
    }


}
