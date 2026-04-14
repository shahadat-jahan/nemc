@extends('layouts.default')
@section('pageTitle', $pageTitle)
@push('style')
    <link href="{{asset('assets/global/plugins/datatables/datatables.bundle.css')}}" rel="stylesheet"
          type="text/css"/>
@endpush

<?php
    $user = Auth::guard('web')->user();
    $userGroupId = Auth::guard('web')->user()->user_group_id;
    $authorizeUser = isset($user->adminUser) && $user->adminUser->designation_id === 32;
    $authorizeTeacher = isset($user->teacher) && $user->teacher->id == $classRoutine->teacher_id;
    $mode = isset(app()->request->mode) ? app()->request->mode : '';

    $case = 'general';

if ($mode == 'routine') {
    $case = 'attendance';
} elseif ($mode == 'lecture') {
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
                            <h3 class="m-portlet__head-text"><i class="fa fa-clock fa-md pr-2"></i>Class Routine Detail
                            </h3>
                        </div>
                    </div>
                    <div class="m-portlet__head-tools">
                        @if (hasPermission('class_routine/edit'))
                            @if (empty($classRoutine->attendances->toArray()))
                                <a href="{{route('class_routine.edit.single', [$classRoutine->id])}}"
                                   class="btn btn-primary m-btn m-btn--icon mr-2"
                                   title="Edit"><i class="flaticon-edit pr-2"></i> Edit</a>
                            @endif
                        @endif
                        <a href="{{ route('class_routine.show', [$classRoutine->id]) }}"
                           class="btn btn-primary m-btn m-btn--icon" title="Applicants"><i class="fa fa-clock pr-2"></i>
                            Class Routines</a>
                    </div>
                </div>

                <div class="m-portlet__body">
                    <div class="m-section__content">
                        <ul class="nav nav-tabs  m-tabs-line m-tabs-line--success" role="tablist">
                            <li class="nav-item m-tabs__item">
                                <a class="nav-link m-tabs__link {{($case == 'general') ? 'active' : ''}}"
                                   data-toggle="tab" href="#m_tabs_1" role="tab"><i class="fa fa-clock"></i> General
                                    Information</a>
                            </li>
                            <li class="nav-item m-tabs__item">
                                <a class="nav-link m-tabs__link {{($case == 'lecture') ? 'active' : ''}} load-contents"
                                   data-content="lecture" data-set-data="0" data-toggle="tab" href="#m_tabs_2"
                                   role="tab"><i class="la la-cloud-upload"></i> Lecture Materials</a>
                            </li>
                            @if(hasPermission('attendance/view'))
                                @if($classRoutine->class_type_id == 1 || $classRoutine->class_type_id == 9)
                                    @if(in_array(Auth::guard('web')->user()->user_group_id,[1,12]) || $authorizeUser || $authorizeTeacher)
                                        @if($classRoutine->class_date <= \Illuminate\Support\Carbon::today()->format('Y-m-d'))
                                            <li class="nav-item m-tabs__item">
                                                <a class="nav-link m-tabs__link {{($case == 'attendance') ? 'active' : ''}} load-contents"
                                                   data-content="attendance" data-set-data="0" data-toggle="tab"
                                                   href="#m_tabs_3" role="tab"><i class="fa fa-user-tag"></i> Attendance</a>
                                            </li>
                                        @endif
                                    @endif
                                @else
                                    @if($classRoutine->class_date <= \Illuminate\Support\Carbon::today()->format('Y-m-d'))
                                        <li class="nav-item m-tabs__item">
                                            <a class="nav-link m-tabs__link {{($case == 'attendance') ? 'active' : ''}} load-contents"
                                               data-content="attendance" data-set-data="0" data-toggle="tab"
                                               href="#m_tabs_3" role="tab"><i class="fa fa-user-tag"></i> Attendance</a>
                                        </li>
                                    @endif
                                @endif
                            @endif
                            @if($classRoutine->topic)
                                @if(Auth::guard('web')->user()->user_group_id == 12 || Auth::guard('web')->user()->user_group_id == 1 || $classRoutine->teacher_id == Auth::guard('web')->user()->teacher->id)
                                    <li class="nav-item m-tabs__item">
                                        <a class="nav-link m-tabs__link {{($case == 'lesson') ? 'active' : ''}} load-contents"
                                           data-content="lesson" data-set-data="0" data-toggle="tab"
                                           href="#m_tabs_4" role="tab"><i class="fa fa-book"></i> Lesson Plans</a>
                                    </li>
                                @endif
                            @endif
                        </ul>
                        <div class="tab-content">
                            <div class="tab-pane {{($case == 'general') ? 'active' : ''}}" id="m_tabs_1"
                                 role="tabpanel">
                                <div class="row">
                                    <div class="col-12">
                                        <!-- Lecture class -->
                                        @if(in_array($classRoutine->class_type_id,[1, 9, 17]))
                                            <h4 class="text-center">Teacher and Topic</h4>
                                            <ul class="list-group list-group-horizontal-xl w-75 m-auto">
                                                @if($classRoutine->topic)
                                                    <li class="list-group-item">
                                                        <strong>Topic :</strong> {{$classRoutine->topic->title}}
                                                    </li>
                                                @endif
                                                @if($classRoutine->teacher)
                                                    <li class="list-group-item">
                                                        <strong>Teacher
                                                            :</strong> {{$classRoutine->teacher->full_name}}
                                                    </li>
                                                @endif
                                            </ul>
                                        @else
                                            <!-- Practical class -->
                                            @if(isset($classRoutine->studentGroupTeacher))
                                                <h4 class="text-center">Teacher, Topic and Student Group</h4>
                                                <ul class="list-group list-group-horizontal-xl w-75 m-auto">
                                                    @if($classRoutine->topic)
                                                        <li class="list-group-item">
                                                            <strong>Topic :</strong> {{$classRoutine->topic->title}}
                                                        </li>
                                                    @endif
                                                    @foreach($classRoutine->studentGroupTeacher as $key => $teacher)
                                                        <li class="list-group-item">
                                                            <strong>Teacher :</strong> {{$teacher->full_name}},
                                                            <strong>Group:</strong> {{$classRoutine->studentGroup[$key]->group_name}}
                                                        </li>
                                                    @endforeach
                                                </ul>
                                            @endif
                                        @endif
                                        <br>
                                    </div>
                                    <hr>
                                    <div class="col-12">
                                        <h4 class="text-center">Class Basic Info</h4>
                                    </div>
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
                                                        <div class="col-md-4">Course :</div>
                                                        <div class="col-md-8">{{$classRoutine->course->title}}</div>
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
                                                        <div class="col-md-4">Term :</div>
                                                        <div
                                                            class="col-md-8">{{$classRoutine->term ? $classRoutine->term->title : '--'}}</div>
                                                    </div>
                                                </li>
                                                <li class="list-group-item">
                                                    <div class="row">
                                                        <div class="col-md-4">Date :</div>
                                                        <div
                                                            class="col-md-8">{{date('d M,  Y', strtotime($classRoutine->class_date))}}</div>
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
                                                        <div class="col-md-4">Type :</div>
                                                        <div class="col-md-8">{{$classRoutine->classType->title}}</div>
                                                    </div>
                                                </li>
                                                <li class="list-group-item">
                                                    <div class="row">
                                                        <div class="col-md-4">Day :</div>
                                                        <div
                                                            class="col-md-8">{{getDayName($classRoutine->class_date)}}</div>
                                                    </div>
                                                </li>
                                                <li class="list-group-item">
                                                    <div class="row">
                                                        <div class="col-md-4">Class Room :</div>
                                                        <div
                                                            class="col-md-8">{{isset($classRoutine->hall) ? $classRoutine->hall->title : 'n/a'}}</div>
                                                    </div>
                                                </li>
                                                <li class="list-group-item">
                                                    <div class="row">
                                                        <div class="col-md-4">Time :</div>
                                                        <div
                                                            class="col-md-8">{{parseClassTimeInTwelveHours($classRoutine->start_from).' - '.(parseClassTimeInTwelveHours($classRoutine->end_at))}}</div>
                                                    </div>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane {{($case == 'lecture') ? 'active' : ''}}" id="m_tabs_2"
                                 role="tabpanel">
                                <div class="row">
                                    <div class="col-xs-12 col-sm-12 col-md-9 col-lg-9 col-xl-9">
                                        <h4 class="m-portlet__head-text">Lecture Materials</h4>
                                    </div>
                                    @if($classRoutine->status === 1)
                                        @if(hasPermission('lecture_material/create'))
                                            <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3 col-xl-3">
                                                <div class="text-right">
                                                    <a href="{{ route('lecture_material.create', ['class_id' => $classRoutine->id]) }}"
                                                       class="btn btn-primary m-btn m-btn--icon"><i
                                                            class="fa fa-plus pr-2"></i> Lecture Material</a>
                                                </div>
                                            </div>
                                        @endif
                                    @endif
                                </div>
                                <br>
                                <div class="row">
                                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
                                        <div class="table m-table table-responsive">
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
                            </div>
                            <div class="tab-pane {{($case == 'attendance') ? 'active' : ''}}" id="m_tabs_3"
                                 role="tabpanel">

                                <div class="row">
                                    <div class="col-xs-12 col-sm-12 col-md-8 col-lg-8 col-xl-8">
                                        <h4 class="m-portlet__head-text">Student's Attendance</h4>
                                        @php
                                            $totalPresent = \App\Models\Attencance::where('class_routine_id', $classRoutine->id)->where('attendance', 1)->count();
                                            $totalAbsent = \App\Models\Attencance::where('class_routine_id', $classRoutine->id)->where('attendance', 0)->count();
                                        @endphp

                                        @if($checkAttendance)
                                            <span
                                                class="m-badge m-badge--success">Total Present : {{$totalPresent}}</span>
                                            <span class="m-badge m-badge--danger">Total Absent : {{$totalAbsent}}</span>
                                        @endif
                                    </div>
                                    @if($classRoutine->status === 1)
                                        <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4 col-xl-4 text-right">
                                            <a href="{{ route('attendance.index') }}" target="_blank"
                                               class="btn btn-primary btn-sm m-btn--icon "><i
                                                    class="fas fa-filter pr-2"></i>
                                                Filter Attendance</a>
                                            @if($checkAttendance && hasPermission('attendance/view'))
                                                    <a href="{{ route('attendance.pdf', [$classRoutine->id]) }}"
                                                       target="_blank"
                                                       class="btn btn-primary btn-sm m-btn--icon"><i
                                                            class="fas fa-print pr-2"></i>
                                                        Print Attendance
                                                    </a>
                                            @endif
                                                <!-- get authenticate user -->
                                            @if(hasPermission('attendance/create'))
                                                    <!-- if class is lecture or revised -->
                                                @if($classRoutine->class_type_id == 1 || $classRoutine->class_type_id == 9)
                                                    @if(empty($checkAttendance) && ($authorizeUser || $authorizeTeacher || $userGroupId == 1 || $userGroupId == 12))
                                                            <a href="{{ route('attendance.create', ['class_id' => $classRoutine->id]) }}"
                                                               class="btn btn-primary m-btn m-btn--icon"><i
                                                                    class="fa fa-plus pr-2"></i>Attendance</a>
                                                    @endif
                                                    <!-- if class is practical type -->
                                                @else
                                                    <!-- if login user is super admin or Authorize User or department head teacher  -->
                                                    @if(empty($checkAttendance) && ($authorizeUser || $userGroupId == 1 || $userGroupId == 12))
                                                            <a href="{{ route('attendance.create', ['class_id' => $classRoutine->id]) }}"
                                                               class="btn btn-primary m-btn m-btn--icon"><i
                                                                    class="fa fa-plus pr-2"></i>Attendance</a>
                                                        <!-- if login user is general teacher or teacher with some extra power -->
                                                    @elseif($attendanceStudentExist == 0 && ($authorizeUser || $userGroupId == 4 || $userGroupId == 11))
                                                            <a href="{{ route('attendance.create', ['class_id' => $classRoutine->id]) }}"
                                                               class="btn btn-primary m-btn m-btn--icon"><i
                                                                    class="fa fa-plus pr-2"></i>Attendance</a>
                                                    @endif
                                                @endif
                                            @endif
                                        </div>
                                    @endif
                                </div>
                                @if($checkAttendance && hasPermission('attendance/edit') && ($userGroupId == 1 || $userGroupId == 2 || $userGroupId == 11 || $userGroupId == 12))
                                    <div class="my-3">
                                        <input type="checkbox" id="bulk_records">
                                        <button type="button" id="bulk_apply"
                                                class="btn btn-success not-allowed" disabled>Send
                                        </button>
                                    </div>
                                @endif
                                <br>
                                <div class="row">
                                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
                                        <div class="table m-table table-responsive">
                                            <table class="table table-bordered table-hover" id="attendance-data">
                                                <thead>
                                                <tr>
                                                    <th></th>
                                                    <th class="uppercase">Student</th>
                                                    <th class="uppercase">Roll No</th>
                                                    <th class="uppercase">Subject</th>
                                                    <th class="uppercase">Attendance</th>
                                                    <th class="uppercase">SMS Sent</th>
                                                    <th class="uppercase">Action</th>
                                                </tr>
                                                </thead>
                                                <tbody></tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @if($classRoutine->topic)
                                <div class="tab-pane {{($case == 'lesson') ? 'active' : ''}}" id="m_tabs_4"
                                     role="tabpanel">
                                    <div class="row">
                                        <div class="col-xs-12 col-sm-12 col-md-9 col-lg-9 col-xl-9">
                                            <h4 class="m-portlet__head-text">Lesson Plans</h4>
                                        </div>
                                        @if($classRoutine->status === 1)
                                            @if(hasPermission('lesson_plan/create'))
                                                <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3 col-xl-3">
                                                    <div class="text-right">
                                                        <a href="{{ route('topic.lesson.plan.create', $classRoutine->topic->id) }}"
                                                           class="btn btn-primary m-btn m-btn--icon"><i
                                                                class="fa fa-plus pr-2"></i> Lesson Plan</a>
                                                    </div>
                                                </div>
                                            @endif
                                        @endif
                                    </div>
                                    <br>
                                    <div class="row">
                                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
                                            <div class="table m-table table-responsive">
                                                <table class="table table-bordered table-hover" id="lesson-data">
                                                    <thead>
                                                    <tr>
                                                        <th class="uppercase">Id</th>
                                                        <th class="uppercase">Title</th>
                                                        <th class="uppercase">Topic</th>
                                                        <th class="uppercase">Speaker</th>
                                                        <th class="uppercase">Place</th>
                                                        <th class="uppercase">Date</th>
                                                        <th class="uppercase">Time</th>
                                                        <th class="uppercase">Status</th>
                                                        <th class="uppercase">Action</th>
                                                    </tr>
                                                    </thead>
                                                    <tbody></tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endif
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
        $(document).ready(function () {
            var status = '{{$case}}';
            var routineId = '{{$classRoutine->id}}';

            $('.load-contents').click(function (e) {
                e.preventDefault();
                var selected = $(this);

                if ($(this).attr('data-set-data') == 0) {

                    mApp.blockPage({
                        overlayColor: "#000000",
                        type: "loader",
                        state: "primary",
                        message: "Please wait..."
                    });

                    //lecture material table header
                    if ($(this).data('content') == 'lecture') {
                        var lectureTableColumn = [
                            {"data": "id", "name": "id"},
                            {"data": "class_routine_id", "name": "class_routine_id"},
                            {"data": "content", "name": "content"},
                            {"data": "attachment", "name": "attachment"},
                            {"data": "status", "name": "status"},
                            /*{"data":"created_by","name":"created_by"},*/
                            {"data": "action", "name": "action"}
                        ];
                        //get list of lecture material according to class routine
                        generateDatatable('lecture-data', lectureTableColumn, '{{route('lecture.material.list', [$classRoutine->id])}}');
                    }

                    if ($(this).data('content') == 'attendance') {
                        var attendanceTableColumn = [
                            {"data": "check", "name": "check"},
                            {"data": "student_id", "name": "student_id"},
                            {"data": "roll_no", "name": "roll_no"},
                            {"data": "subject_id", "name": "subject_id"},
                            {"data": "attendance", "name": "attendance"},
                            {"data": "send_sms", "name": "send_sms"},
                            {"data": "action", "name": "action"}
                        ];
                        generateDatatable('attendance-data', attendanceTableColumn, baseUrl + 'admin/attendance/get-data/' + routineId, 4, 'asc');
                    }

                    //lesson plan table header
                    @if($classRoutine->topic)
                    if ($(this).data('content') == 'lesson') {
                        var lessonTableColumn = [
                            {data: 'id', name: 'id'},
                            {data: 'title', name: 'title'},
                            {data: 'topic_id', name: 'topic_id'},
                            {data: 'speaker_id', name: 'speaker_id'},
                            {data: 'place', name: 'place'},
                            {data: 'date', name: 'date'},
                            {data: 'time', name: 'time'},
                            {data: 'status', name: 'status'},
                            {data: 'action', name: 'action', orderable: false}
                        ];
                        //get list of lesson plan according to class routine
                        generateDatatable('lesson-data', lessonTableColumn, '{{route('topic.lesson.plan.by.teacher.id', [$classRoutine->topic->id, $classRoutine->teacher->id])}}');
                    }
                    @endif
                    mApp.unblockPage()

                    $(this).attr('data-set-data', 1);
                }
            });

            if (status == 'attendance') {
                var attendanceTableColumn = [
                    {"data": "check", "name": "check"},
                    {"data": "student_id", "name": "student_id"},
                    {"data": "roll_no", "name": "roll_no"},
                    {"data": "subject_id", "name": "subject_id"},
                    {"data": "attendance", "name": "attendance"},
                    {"data": "send_sms", "name": "send_sms"},
                    {"data": "action", "name": "action"}
                ];

                mApp.blockPage({
                    overlayColor: "#000000",
                    type: "loader",
                    state: "primary",
                    message: "Please wait..."
                });
                generateDatatable('attendance-data', attendanceTableColumn, baseUrl + 'admin/attendance/get-data/' + routineId, 4, 'asc');

                mApp.unblockPage()
            }

            if (status == 'lecture') {
                var lectureTableColumn = [
                    {"data": "id", "name": "id"},
                    {"data": "class_routine_id", "name": "class_routine_id"},
                    {"data": "content", "name": "content"},
                    {"data": "attachment", "name": "attachment"},
                    {"data": "status", "name": "status"},
                    /*{"data":"created_by","name":"created_by"},*/
                    {"data": "action", "name": "action"}
                ];
                //get list of lecture material according to class routine
                generateDatatable('lecture-data', lectureTableColumn, '{{route('lecture.material.list', [$classRoutine->id])}}');
            }
            @if($classRoutine->topic)
            if (status == 'lesson') {
                var lessonTableColumn = [
                    {data: 'id', name: 'id'},
                    {data: 'title', name: 'title'},
                    {data: 'topic_id', name: 'topic_id'},
                    {data: 'speaker_id', name: 'speaker_id'},
                    {data: 'place', name: 'place'},
                    {data: 'date', name: 'date'},
                    {data: 'time', name: 'time'},
                    {data: 'status', name: 'status'},
                    {data: 'action', name: 'action', orderable: false}
                ];
                //get list of lesson plan according to class routine
                generateDatatable('lesson-data', lessonTableColumn, '{{route('topic.lesson.plan.by.teacher.id', [$classRoutine->topic->id, $classRoutine->teacher->id])}}');
            }
            @endif


            $('#attendance-data').on('click', '.bulk_record', function () {
                if ($('.bulk_record').prop('checked') || $('.bulk_record:checked').length > 0) {
                    $('#bulk_apply').removeAttr("disabled").removeClass("not-allowed");
                    $(".send-attendance-sms").addClass("m--hide");
                    $("#bulk_apply").prop("disabled", false);
                } else {
                    $(".send-attendance-sms").removeClass("m--hide");
                    $("#bulk_apply").prop("disabled", true);
                    $('#bulk_apply').attr("disabled", "disabled").addClass("not-allowed");
                }
            });

            $('#bulk_records').click(function () {
                if ($(this).prop('checked')) {
                    $(".send-attendance-sms").addClass("m--hide");
                    $("#bulk_apply").prop("disabled", false);
                } else {
                    $(".send-attendance-sms").removeClass("m--hide");
                    $("#bulk_apply").prop("disabled", true);
                }
                $('.bulk_record').not(this).prop('checked', this.checked);
                $('#bulk_records').not(this).prop('checked', this.checked);
                return true;
            });

            $('#attendance-data').on('click', '.send-attendance-sms', function (e) {
                e.preventDefault();
                let attendanceId = $(this).data('attendance-id');
                let attendanceStatus = $(this).data('attendance-status');
                let classRoutineId = $(this).data('routine-id');

                $.ajax({
                    type: 'GET',
                    url: baseUrl + 'admin/attendance/send/sms-details',
                    data: {
                        attendanceId: attendanceId,
                        attendanceStatus: attendanceStatus,
                        classRoutineId: classRoutineId,
                        _token: "{{ csrf_token() }}",
                    },
                    success: function (response) {
                        Swal.fire({
                            title: 'Confirmation',
                            html: response,
                            icon: 'warning',
                            showCancelButton: true,
                            confirmButtonText: 'Send',
                            cancelButtonText: 'Cancel',
                        }).then((result) => {
                            console.log(result)
                            if (result.value) {
                                // User confirmed, make the AJAX call
                                $.ajax({
                                    type: 'POST',
                                    url: baseUrl + 'admin/attendance/send/sms',
                                    data: {
                                        attendanceId: attendanceId,
                                        attendanceStatus: attendanceStatus,
                                        classRoutineId: classRoutineId,
                                        _token: "{{ csrf_token() }}",
                                    },
                                    success: function (response) {
                                        console.log(response);
                                        toastr.success('Successfully sent');
                                        $('#attendance-data').DataTable().draw(false); // Refresh the attendance data table
                                    },
                                    error: function (error) {
                                        console.log(error);
                                        toastr.error(error);
                                    }
                                });
                            }
                        });
                    },
                    error: function (error) {
                        console.log(error);
                        toastr.error(error);
                    }
                });
            });

            $(document).on('click', '#bulk_apply', function () {
                var selectedDataArray = [];
                $('.bulk_record:checkbox:checked').each(function () {
                    var attendanceId = $(this).data('attendance-id'); // Assuming you have a data attribute like data-attendance-id on the checkbox
                    var attendanceStatus = $(this).data('attendance-status'); // Assuming you have a data attribute like data-attendance-status on the checkbox
                    var classRoutineId = $(this).data('routine-id'); // Assuming you have a data attribute like data-class-routine-id on the checkbox

                    selectedDataArray.push({
                        attendanceId: attendanceId,
                        attendanceStatus: attendanceStatus,
                        classRoutineId: classRoutineId,
                    });
                });
                Swal.fire({
                    title: 'Confirmation',
                    html: 'Dear Parents, One of our students, named <b>{Student name}</b>, was recently found absent in a scheduled class of <b>{Subject}</b> (<b>{Class type}</b>), dated <b>{Class date}</b>.<br><br>If you are unaware of this absence, please contact the office at +8802996635181.',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Send',
                    cancelButtonText: 'Cancel',
                }).then((result) => {
                    console.log(result)
                    if (result.value) {
                        // User confirmed, make the AJAX call
                        $.ajax({
                            type: 'POST',
                            url: '{{ url('admin/attendance/send/bulk/sms') }}',
                            data: {
                                data: selectedDataArray,
                                _token: "{{ csrf_token() }}",
                            },
                            success: function (result) {
                                console.log(result);
                                toastr.success('Successfully sent');
                            },
                            error: function (xhr) {
                                console.log(xhr);
                                toastr.error(xhr);
                            }
                        });
                    }
                });
                return false;
            });
        });
    </script>
@endpush
