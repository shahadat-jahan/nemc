@extends('frontend.layouts.default')
@section('pageTitle', $pageTitle)
@push('style')
    <link href="{{asset('assets/global/plugins/datatables/datatables.bundle.css')}}" rel="stylesheet"
          type="text/css"/>
    <style>
        .table td {
            padding-top: 0.6rem !important;
            padding-bottom: .6rem !important;
            vertical-align: top;
            border-top: 1px solid #f4f5f8;
        }
    </style>
@endpush

<?php
$mode = isset(app()->request->mode) ? app()->request->mode : '';

$case = 'general';

if ($mode == 'routine'){
    $case = 'attendance';
}else if ($mode == 'lecture'){
    $case = 'lecture';
}
?>
@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="m-portlet view-page">
                <div class="m-portlet__head">
                    <div class="m-portlet__head-caption">
                        <div class="m-portlet__head-title">
                            <h3 class="m-portlet__head-text"><i class="fa fa-clock fa-md pr-2"></i>Class Routine Detail</h3>
                        </div>
                    </div>
                    <div class="m-portlet__head-tools">
                        <a href="{{ route('class_routine.show', [$classRoutine->id]) }}" class="btn btn-primary m-btn m-btn--icon" title="Applicants"><i class="fa fa-clock"></i> Class Routines</a>
                    </div>
                </div>

                <div class="m-portlet__body">
                    <div class="m-section__content">

                        <ul class="nav nav-tabs  m-tabs-line m-tabs-line--success" role="tablist">
                            <li class="nav-item m-tabs__item">
                                <a class="nav-link m-tabs__link {{($case == 'general') ? 'active' : ''}}" data-toggle="tab" href="#m_tabs_1" role="tab"><i class="fa fa-clock"></i> General Information</a>
                            </li>
                            <li class="nav-item m-tabs__item">
                                <a class="nav-link m-tabs__link {{($case == 'lecture') ? 'active' : ''}} load-contents" data-content="lecture" data-set-data="0" data-toggle="tab" href="#m_tabs_2" role="tab"><i class="la la-cloud-upload"></i> Lecture Materials</a>
                            </li>
                            <li class="nav-item m-tabs__item">
                                <a class="nav-link m-tabs__link {{($case == 'attendance') ? 'active' : ''}} load-contents" data-content="attendance" data-set-data="0" data-toggle="tab" href="#m_tabs_3" role="tab"><i class="fa fa-user-tag"></i> Attendance</a>
                            </li>
                        </ul>

                        <div class="tab-content">
                            <div class="tab-pane {{($case == 'general') ? 'active' : ''}}" id="m_tabs_1" role="tabpanel">
                                <div class="row">
                                    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                                        <div class="card">
                                            <ul class="list-group list-group-flush">
                                                <li class="list-group-item">
                                                    <div class="row">
                                                        <div class="col-md-4">Session :</div>
                                                        <div class="col-md-8">{{$classRoutine->session->title}}</div>
                                                    </div>
                                                </li>
                                                <li class="list-group-item">
                                                    <div class="row">
                                                        <div class="col-md-4">Phase :</div>
                                                        <div class="col-md-8">{{$classRoutine->phase->title}}</div>
                                                    </div>
                                                </li>
                                                <li class="list-group-item">
                                                    <div class="row">
                                                        <div class="col-md-4">Type :</div>
                                                        <div class="col-md-8">{{$classRoutine->classType->title}}</div>
                                                    </div>
                                                </li>
                                                <li class="list-group-item">
                                                    <div class="row">
                                                        <div class="col-md-4">Date :</div>
                                                        <div class="col-md-8">{{date('d/m/Y', strtotime($classRoutine->class_date))}}</div>
                                                    </div>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                                        <div class="card">
                                            <ul class="list-group list-group-flush">
                                                <li class="list-group-item">
                                                    <div class="row">
                                                        <div class="col-md-4">Subject :</div>
                                                        <div class="col-md-8">{{$classRoutine->subject->title}}</div>
                                                    </div>
                                                </li>
                                                <li class="list-group-item">
                                                    <div class="row">
                                                        <div class="col-md-4">Day :</div>
                                                        <div class="col-md-8">{{getDayName($classRoutine->class_date)}}</div>
                                                    </div>
                                                </li>
                                                <li class="list-group-item">
                                                    <div class="row">
                                                        <div class="col-md-4">Class Room :</div>
                                                        <div class="col-md-8">{{isset($classRoutine->hall) ? $classRoutine->hall->title : 'n/a'}}</div>
                                                    </div>
                                                </li>
                                                <li class="list-group-item">
                                                    <div class="row">
                                                        <div class="col-md-4">Time :</div>
                                                        <div class="col-md-8">{{parseClassTimeInTwelveHours($classRoutine->start_from).' - '.(parseClassTimeInTwelveHours($classRoutine->end_at))}}</div>
                                                    </div>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane {{($case == 'lecture') ? 'active' : ''}}" id="m_tabs_2" role="tabpanel">
                                <div class="row">
                                    <div class="col-xs-12 col-sm-12 col-md-9 col-lg-9 col-xl-9">
                                        <h4 class="m-portlet__head-text">Lecture Materials</h4>
                                    </div>
                                </div><br>
                                <div class="row">
                                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
                                        <table class="table table-bordered table-hover" id="lecture-data">
                                            <thead>
                                            <tr>
                                                <th class="uppercase">Id</th>
                                                <th class="uppercase">Class Type</th>
                                                <th class="uppercase">Content</th>
                                                <th class="uppercase">Attachment</th>
                                                <th class="uppercase">Status</th>
                                                {{--<th class="uppercase">Created By</th>--}}
                                                <th class="uppercase">Action</th>
                                            </tr>
                                            </thead>
                                            <tbody></tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane {{($case == 'attendance') ? 'active' : ''}}" id="m_tabs_3" role="tabpanel">

                                <div class="row">
                                    <div class="col-xs-12 col-sm-12 col-md-10 col-lg-10 col-xl-10">
                                        <h4 class="m-portlet__head-text">Student's Attendance</h4>
                                    </div>
                                </div>


                                <div class="row">
                                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
                                        <table class="table table-bordered table-hover" id="attendance-data">
                                            <thead>
                                            <tr>
                                                <th class="uppercase">Student</th>
                                                <th class="uppercase">Subject</th>
                                                <th class="uppercase">Attendance</th>
                                                <th class="uppercase">Action</th>
                                            </tr>
                                            </thead>
                                            <tbody></tbody>
                                        </table>

                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>

    @include('attendance.edit_attendance_modal')

@endsection

@push('scripts')
    <script src="{{asset('assets/global/plugins/datatables/datatables.bundle.js')}}" type="text/javascript"></script>
    <script src="{{asset('assets/global/scripts/charts.js')}}"></script>
    <script>
        var status = '{{$case}}';
        var routineId = '{{$classRoutine->id}}';

        $('.load-contents').click(function (e) {
            e.preventDefault();
            var selected = $(this);




            if ($(this).attr('data-set-data') == 0){

                mApp.blockPage({
                    overlayColor: "#000000",
                    type: "loader",
                    state: "primary",
                    message: "Please wait..."
                });

                //lecture material table header
                if ($(this).data('content') == 'lecture'){
                    var lectureTableColumn = [
                        {"data":"id","name":"id"},
                        {"data":"class_routine_id","name":"class_routine_id"},
                        {"data":"content","name":"content"},
                        {"data":"attachment","name":"attachment"},
                        {"data":"status","name":"status"},
                        /*{"data":"created_by","name":"created_by"},*/
                        {"data":"action","name":"action"}
                    ];
                    //get list of lecture material according to class routine
                    generateDatatable('lecture-data', lectureTableColumn, '{{route(customRoute('lecture.material.list'), [$classRoutine->id])}}');

                }

                if ($(this).data('content') == 'attendance'){
                    var attendanceTableColumn = [
                        {"data":"student_id","name":"student_id"},
                        {"data":"subject_id","name":"subject_id"},
                        {"data":"attendance","name":"attendance"},
                        {"data":"action","name":"action"}
                    ];

                    generateDatatable('attendance-data', attendanceTableColumn, baseUrl+'nemc/attendance/get-data/'+routineId, 1, 'asc');
                }

                mApp.unblockPage()


                $(this).attr('data-set-data', 1);

            }
        });

        if (status == 'attendance'){
            var attendanceTableColumn = [
                {"data":"student_id","name":"student_id"},
                {"data":"subject_id","name":"subject_id"},
                {"data":"attendance","name":"attendance"},
                {"data":"action","name":"action"}
            ];

            mApp.blockPage({
                overlayColor: "#000000",
                type: "loader",
                state: "primary",
                message: "Please wait..."
            });
            generateDatatable('attendance-data', attendanceTableColumn, baseUrl+'nemc/attendance/get-data/'+routineId, 1, 'asc');

            mApp.unblockPage()
        }

        if (status == 'lecture'){
            mApp.blockPage({
                overlayColor: "#000000",
                type: "loader",
                state: "primary",
                message: "Please wait..."
            });

            var lectureTableColumn = [
                {"data":"id","name":"id"},
                {"data":"class_routine_id","name":"class_routine_id"},
                {"data":"content","name":"content"},
                {"data":"attachment","name":"attachment"},
                {"data":"status","name":"status"},
                /*{"data":"created_by","name":"created_by"},*/
                {"data":"action","name":"action"}
            ];
            //get list of lecture material according to class routine
            generateDatatable('lecture-data', lectureTableColumn, '{{route(customRoute('lecture.material.list'), [$classRoutine->id])}}');
            mApp.unblockPage()
        }



    </script>
@endpush
