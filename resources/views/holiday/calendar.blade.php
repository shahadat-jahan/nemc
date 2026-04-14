@extends('layouts.default')
@section('pageTitle', $pageTitle)
@push('style')
    <link rel="stylesheet" href="{{asset('assets/global/plugins/fullcalendar/fullcalendar.bundle.css')}}">
@endpush

<?php
$allHolidays = [];
if (!empty($holidays)) {
    $i = 0;
    foreach ($holidays as $hday) {

        $allHolidays[$i] = [
            'start' => \Carbon\Carbon::createFromFormat('d/m/Y', $hday->from_date)->format('Y-m-d'),
            'title' => $hday->title,
            'event_id' => $hday->id,
            'className' => "m-fc-event--info  m-fc-event--solid-metal",
        ];
        if (!empty($hday->to_date)) {
            $allHolidays[$i]['end'] = \Carbon\Carbon::createFromFormat('d/m/Y', $hday->to_date)->addDay()->format('Y-m-d');
        }
        $i++;
    }
}

$month = !empty(request()->month) ? request()->month : date('m');
$year = !empty(request()->year) ? request()->year : date('Y');

$monthStart = \Carbon\Carbon::create($year, $month, 1);

$startOfCurrentYear = \Carbon\Carbon::now()->startOfYear()->format('Y-m-d');
$endOfCurrentYear = \Carbon\Carbon::now()->endOfYear()->format('Y-m-d');

?>
@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="m-portlet">
                <div class="m-portlet__head">
                    <div class="m-portlet__head-caption">
                        <div class="m-portlet__head-title">
                            <h3 class="m-portlet__head-text"><i class="fas fa-list-ul pr-2"></i>Holiday Calendar</h3>
                        </div>
                    </div>
                    <div class="m-portlet__head-tools">
                        <a href="{{route('holiday.index') }}" class="btn btn-primary m-btn m-btn--icon mr-2"><i
                                class="fas fa-list pr-2"></i>List View</a>
                        @if (hasPermission('holiday/create'))
                            <a href="{{route('holiday.create') }}" class="btn btn-primary m-btn m-btn--icon"><i
                                    class="fa fa-plus pr-2"></i>Create</a>
                        @endif
                    </div>
                </div>

                <div class="m-portlet__body">
                    <form id="searchForm" role="form" method="get">
                        <div class="form-body">
                            <div class="row">
                                <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 col-xl-6">
                                    <div class="form-group">
                                        <select name="month" class="form-control" id="month">
                                            {!! select($months, $month) !!}
                                        </select>
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 col-xl-6">
                                    <div class="form-group">
                                        <select name="year" class="form-control" id="year">
                                            {!! select($years, $year) !!}
                                        </select>
                                    </div>
                                </div>


                                <div class="col-md-12">
                                    <div class="pull-right search-action-btn">
                                        <button class="btn btn-primary m-btn m-btn--icon"><i class="fa fa-search"></i>
                                            Search
                                        </button>
                                        <button type="reset" class="btn btn-default reset"><i
                                                class="fas fa-sync-alt search-reset"></i> Reset
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <br/>
                        </div>
                    </form>
                    <div class="m-section__content">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="">
                                    <div class="table m-table table-responsive">
                                        <div id="holiday-calendar"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

@push('scripts')
    <script src="{{asset('assets/global/plugins/fullcalendar/fullcalendar.bundle.js')}}"
            type="text/javascript"></script>
    <script>
        $(document).ready(function () {

            $('#holiday-calendar').fullCalendar({
                header: {
                    left: 'title',
                    center: '',
                    right: 'prev,next',
                },
                defaultDate: '{{$monthStart->format('Y-m-d')}}',
                visibleRange: {
                    start: '{{$monthStart->format('Y-m-d')}}',
                    end: '{{$monthStart->lastOfMonth()->format('Y-m-d')}}'
                },
                validRange: {
                    start: '{{$startOfCurrentYear}}',
                    end: '{{$endOfCurrentYear}}'
                },
                events: {!! json_encode($allHolidays) !!},
                eventClick: function(calEvent, jsEvent, view) {
                    // console.log(calEvent);
                },
                eventRender: function(event, element) {
                    //
                }
            })
        });

    </script>
@endpush

