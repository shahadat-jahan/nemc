<?php

namespace App\Services\Admin;

use App\Models\Holiday;
use App\Services\BaseService;
use Carbon\Carbon;
use DataTables;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;

/**
 * Class UserService
 * @package App\Services\Admin
 */
class HolidayService extends BaseService {

    /**
     * @var $model
     */
    protected $model;
    /**
     * @var string
     */
    protected $url = 'admin/holiday';


    public function __construct(Holiday $holiday)
    {
        $this->model = $holiday;
    }


    /**
     *
     * @return JsonResponse
     */

    public function checkHolidays($title,$year){
         $yearF=Carbon::createFromFormat('d/m/Y', $year)->format('Y');
         $query = $this->model->where('title',$title);
                  $query->whereYear('from_date', $yearF);
           return $query->count();
    }

    public function getAllData($request)
    {
        $query = $this->model->select();

        if (Auth::guard('student_parent')->check()){
            $user = Auth::guard('student_parent')->user();
            //if login user is student
            if ($user->student){
                $query = $query->where('session_id', $user->student->session_id)
                    ->orWhere('session_id', null)
                    ->where('batch_type_id', $user->student->batch_type_id)
                    ->orWhere('batch_type_id', null);
            }
            //if login user is parent
            elseif ($user->parents){
                $query = $query->where('session_id', $user->parents->first()->session_id)
                    ->orWhere('session_id', null)
                    ->where('batch_type_id', $user->parents->first()->batch_type_id)
                    ->orWhere('batch_type_id', null);
            }
        }

        return Datatables::of($query)
            ->addColumn('action', function ($row) {
                $actions = '';
                //$expireDate = !empty($row->to_date) ? $row->to_date : $row->from_date;
               /* if ( Carbon::today()->toDateString() < $row->from_date) {
                    if (hasPermission('holiday/edit')) {
                        $actions.= '<a href="' . route('holiday.edit', [$row->id]) . '" class="m-portlet__nav-link btn m-btn m-btn--hover-brand m-btn--icon m-btn--icon-only m-btn--pill" title="Edit"><i class="flaticon-edit"></i></a>';
                    }
                }*/

                if (hasPermission('holiday/edit')) {
                    $actions.= '<a href="' . route('holiday.edit', [$row->id]) . '" class="m-portlet__nav-link btn m-btn m-btn--hover-brand m-btn--icon m-btn--icon-only m-btn--pill" title="Edit"><i class="flaticon-edit"></i></a>';
                }

                if (hasPermission('holiday/view')) {
                    $actions .= '<a href="' . route(customRoute('holiday.show'), [$row->id]) . '" class="m-portlet__nav-link btn m-btn m-btn--hover-brand m-btn--icon m-btn--icon-only m-btn--pill" title="View"><i class="flaticon-eye"></i></a>';
                }

                return $actions;
            })

            ->editColumn('session_id', function ($row) {
                return isset($row->session) ?  $row->session->title : 'All';
            })

            ->editColumn('batch_type_id', function ($row) {
                return isset($row->batchType) ?  $row->batchType->title : 'All';
            })

            ->editColumn('status', function ($row) {
                return setHolidayStatus($row->status);
            })
           /* ->editColumn('status', function ($row) {
                if (Carbon::today()->toDateString() <  $row->from_date){
                    return setHolidayStatus($row->status);
                } else{
                    return setHolidayStatus( 2);
                }
            })*/
            ->rawColumns(['status', 'action', 'description'])

            ->filter(function ($query) use ($request) {

                if ($request->get('title')) {
                    $query->where('title', 'like', '%'.$request->get('title').'%');
                }
                if ($request->get('month')) {
                    $query->where(function ($q) use($request){
                        $q->whereMonth('from_date', $request->get('month'))->orWhereMonth('to_date', $request->get('month'));
                    });
                }

                if ($request->get('year')) {
                    $query->where(function ($q) use($request){
                        $q->whereYear('from_date', $request->get('year'))->orWhereyear('to_date', $request->get('year'));
                    });
                }

            })

            ->make(true);
    }

    public function getHolidayByDate($date){
        return $this->model->where('status', 1)
            ->where(function ($q) use($date){
            $q->where('from_date', '<=', $date )->where('to_date', '>=', $date);
        })->orWhere(function ($q) use($date){
            $q->where('from_date', $date )->whereNull('to_date');
        })->get();
    }

    public function getAllHolidayBySearchCriteria($sessionId, $startDate, $endDate){
        $startDate = date('Y-m-d', strtotime($startDate));
        $endDate = date('Y-m-d', strtotime($endDate));
        $holidays = $this->model->where([
            ['session_id', $sessionId],
            ['status', 1],
        ])->whereBetween('from_date', [$startDate, $endDate])->get();

        if ($holidays->isEmpty()){
            $holidays = $this->model->where('status', 1)->whereBetween('from_date', [$startDate, $endDate])->get();
        }

        return $holidays;
    }

    public function getAllHolidays($request){
        $year = !empty($request->year) ? $request->year : date('Y');

        $query = $this->model->where('status', 1)
            ->where(function ($q) use($request){
            $q->when(isset($request->month) && !empty($request->month), function ($q) use($request){
                return $q->whereMonth('from_date', $request->month)->orWhereMonth('to_date', $request->month);
            });
        })->where(function ($q) use($year){
            $q->whereYear('from_date', $year)->orWhereyear('to_date', $year);
        })->latest();

        return $query->get();
    }

    public function getOneWeekHolidays(){
        $today = now()->format('Y-m-d');
        $NextWeekDate = now()->addDays(7)->format('Y-m-d');
       return $this->model->with(['session', 'batchType'])->where('status', 1)->whereBetween('from_date', [$today, $NextWeekDate])->get();
    }

    public function getCurrentMonthAndNextMonthHolidays(){
        $today = now();
        $firstDateOfCurrentMonth = $today->firstOfMonth()->format('Y-m-d');
        $nextMonth = $today->addMonth();
        $lastDateOfNextMonth = $nextMonth->endOfMonth()->format('Y-m-d');
        $query = $this->model->where('status', 1)->whereBetween('from_date', [$firstDateOfCurrentMonth, $lastDateOfNextMonth]);
       return $query->get();
    }

    public function getTwoOldMonthAndNextMonthHolidays()
    {
        $oldMonth = Carbon::now()->subMonths(2)->startOfDay();
        $nextMonth = Carbon::now()->addMonth()->endOfDay();
        $cacheKey = sprintf(
            'holidays:window:%s:%s',
            $oldMonth->toDateString(),
            $nextMonth->toDateString()
        );

        return Cache::remember($cacheKey, 600, function () use ($oldMonth, $nextMonth) {
            return $this->model->where('status', 1)
                ->whereBetween('from_date', [$oldMonth, $nextMonth])
                ->get();
        });
    }

}
