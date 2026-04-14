@extends('layouts.default')
@section('pageTitle', 'Dashboard')

@push('style')
    <link href="{{ asset('assets/global/plugins/datatables/datatables.bundle.css') }}" rel="stylesheet" type="text/css" />
    <style>
        .dropdown-toggle::after,
        .btn.dropdown-toggle::after {
            content: "" !important;
        }

        .m-subheader {
            padding: 0 0 30px 0 !important;
        }

        .mb-25 {
            margin-bottom: 25px;
        }
    </style>
@endpush

@section('content')
    <?php
    $courseId = isset(app()->request->course_id) && !empty(app()->request->course_id) ? app()->request->course_id : (!empty(Auth::guard('web')->user()->teacher->course_id) ? Auth::guard('web')->user()->teacher->course_id : 1);
    $selectedPhaseId = arrayKeyFirst($phases->toArray());
    $sessionId = isset(app()->request->session_id) && !empty(app()->request->session_id) ? app()->request->session_id : $currentSessionId;
    ?>

    <!-- BEGIN: Subheader -->
    <div class="m-subheader">
        <div class="d-flex flex-wrap align-items-md-center justify-content-between gap-2">
            <div class="mr-auto mb-3">
                <h3 class="m-subheader__title">Dashboard</h3>
            </div>

            {{-- Class View Form --}}
            @if (hasPermission('class_routine/view'))
                <form method="get" action="{{ route('class.single') }}" class="d-flex flex-row flex-nowrap mb-2 mb-md-0"
                    style="max-width: 15rem;">
                    @csrf
                    <input type="number" name="class_id" class="form-control border-success" placeholder="Class ID"
                        required>
                    <button type="submit" class="btn btn-success mr-2">View Class</button>
                </form>
            @endif
            {{-- Session & Course Filter --}}
            <form method="get" action="{{ route('dashboard') }}"
                  class="d-flex flex-row align-items-center mb-2 mb-md-0" style="max-width: 100%;">
                @csrf
                <select name="session_id" class="form-control border-success mr-2 mb-2 mb-md-0">
                    <option value="">--- Session ---</option>
                    {!! select($sessions, request()->session_id ?? $sessionId) !!}
                </select>
                @if (empty(Auth::guard('web')->user()->teacher->course_id))
                <select name="course_id" class="form-control border-success mr-2 mb-2 mb-md-0">
                    <option value="">--- Course ---</option>
                    {!! select($courses, request()->course_id ?? $courseId) !!}
                </select>
                @endif
                <button type="submit" class="btn btn-success mr-2 mb-2 mb-md-0" title="Search">
                    <i class="fas fa-search"></i>
                </button>
                <a href="{{ route('dashboard') }}" class="btn btn-success mb-2 mb-md-0" title="Reset">
                    <i class="fas fa-sync-alt"></i>
                </a>
            </form>
            {{-- Course Dropdown --}}
{{--            @if (empty(Auth::guard('web')->user()->teacher->course_id))--}}
{{--                <div class="w-md-auto mb-2">--}}
{{--                    <div class="m-dropdown m-dropdown--inline m-dropdown--arrow" m-dropdown-toggle="click">--}}
{{--                        <a href="#" class="m-dropdown__toggle btn btn-success dropdown-toggle">--}}
{{--                            Course: {{ $courses[$courseId] }}--}}
{{--                        </a>--}}
{{--                        <div class="m-dropdown__wrapper">--}}
{{--                            <span class="m-dropdown__arrow m-dropdown__arrow--left"></span>--}}
{{--                            <div class="m-dropdown__inner">--}}
{{--                                <div class="m-dropdown__body">--}}
{{--                                    <div class="m-dropdown__content">--}}
{{--                                        <ul class="m-nav">--}}
{{--                                            <li class="m-nav__section m-nav__section--first">--}}
{{--                                                <span class="m-nav__section-text">Select Course</span>--}}
{{--                                            </li>--}}
{{--                                            @foreach ($courses as $key => $course)--}}
{{--                                                <li class="m-nav__item">--}}
{{--                                                    <a href="{{ url('admin/dashboard?course_id=' . $key) }}"--}}
{{--                                                        class="m-nav__link">--}}
{{--                                                        <i class="m-nav__link-icon fas fa-book-reader"></i>--}}
{{--                                                        <span class="m-nav__link-text">{{ $course }}</span>--}}
{{--                                                    </a>--}}
{{--                                                </li>--}}
{{--                                            @endforeach--}}
{{--                                        </ul>--}}
{{--                                    </div>--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--            @endif--}}
        </div>
    </div>

    <!-- END: Subheader -->

    <!--begin:: Widgets/Stats-->
    <div class="m-portlet  m-portlet--unair">
        <div class="m-portlet__body  m-portlet__body--no-padding">
            <div class="row m-row--no-padding m-row--col-separator-xl">
                <div class="col-md-12 col-lg-6 col-xl-3">
                    <div class="m-widget24">
                        <div class="m-widget24__item">
                            <h4 class="m-widget24__title">My Students</h4><br>
                            <span class="m-widget24__desc">{{ $courses[$courseId] }}</span>
                            <span class="m-widget24__stats m--font-brand">{{ $totalStudents }}</span>
                            <div class="m--space-10"></div>
                            <div class="progress m-progress--sm mb-25">
                                <div class="progress-bar m--bg-brand" role="progressbar" style="width: 100%;"
                                    aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-12 col-lg-6 col-xl-3">
                    <div class="m-widget24">
                        <div class="m-widget24__item">
                            <h4 class="m-widget24__title">My Classes</h4><br>
                            <span class="m-widget24__desc">{{ $courses[$courseId] }}</span>
                            <span class="m-widget24__stats m--font-accent">{{ $totalClasses }}</span>
                            <div class="m--space-10"></div>
                            <div class="progress m-progress--sm mb-25">
                                <div class="progress-bar m--bg-accent" role="progressbar" style="width: 100%;"
                                    aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-12 col-lg-6 col-xl-3">
                    <div class="m-widget24">
                        <div class="m-widget24__item">
                            <h4 class="m-widget24__title">Total Cards</h4><br>
                            <span class="m-widget24__desc">{{ $department }}</span>
                            <span class="m-widget24__stats m--font-success">{{ $totalCards }}</span>
                            <div class="m--space-10"></div>
                            <div class="progress m-progress--sm mb-25">
                                <div class="progress-bar m--bg-success" role="progressbar" style="width: 100%;"
                                    aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-12 col-lg-6 col-xl-3">
                    <div class="m-widget24">
                        <div class="m-widget24__item">
                            <h4 class="m-widget24__title">Total Items</h4><br>
                            <span class="m-widget24__desc">{{ $department }}</span>
                            <span class="m-widget24__stats m--font-info">{{ $totalItems }}</span>
                            <div class="m--space-10"></div>
                            <div class="progress m-progress--sm mb-25">
                                <div class="progress-bar m--bg-info" role="progressbar" style="width: 100%;"
                                    aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Widgets/Stats-->

    <!-- Today class routine start-->
    <div class="card my-4">
        <div class="card-header">Today's Class Routine</div>
        <div class="card-body">
            <div class="m-portlet  m-portlet--unair">
                <ul class="nav nav-tabs  m-tabs-line m-tabs-line--primary" role="tablist">
                    @foreach ($phases as $phaseId => $phase)
                        <li class="nav-item m-tabs__item">
                            <a class="nav-link m-tabs__link {{ $phaseId == $selectedPhaseId ? 'active' : '' }} routine-phase"
                                data-toggle="tab" data-phase-id="{{ $phaseId }}"
                                data-loaded="{{ $phaseId == 1 ? 1 : 0 }}" href="#routine-{{ $phaseId }}"
                                role="tab">{{ $phase }}</a>
                        </li>
                    @endforeach
                </ul>
                <div class="tab-content">
                    @foreach ($phases as $phaseId => $phase)
                        <div class="tab-pane {{ $phaseId == $selectedPhaseId ? 'active' : '' }}"
                            id="routine-{{ $phaseId }}" role="tabpanel">
                            <div class="table-responsive">
                                <table class="table table-bordered table-hover" id="routine-phase{{ $phaseId }}">
                                    <thead>
                                        <tr>
                                            <th class="uppercase">Subject</th>
                                            <th class="uppercase">Class Type</th>
                                            <th class="uppercase">Teacher</th>
                                            <th class="uppercase">Session</th>
                                            <th class="uppercase">Time</th>
                                            <th class="uppercase">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody></tbody>
                                </table>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
    <!-- Today class routine end-->

    <!-- Monthly class chart Stats-->
    <div class="card">
        <div class="card-header">Monthly Classes</div>
        <div class="card-body">
            <div class="row m-row--no-padding">
                <div id="has-Classdata-to-chart" class="col-12" style="min-height: 30rem;">
                    <figure class="highcharts-figure">
                        <div id="monthly-class-container"></div>
                    </figure>
                </div>
                <div id="has-Not-Classdata-to-chart" class="col-12 d-none">
                    <p class="text-center mb-0">No data found</p>
                </div>
            </div>
        </div>
    </div>
    <!-- Monthly class chart end-->

    <!-- Daily attendance  Stats-->
    <div class="card my-4">
        <div class="card-header">Daily Attendance</div>
        <div class="card-body">
            <div class="m-portlet  m-portlet--unair">
                <ul class="nav nav-tabs  m-tabs-line m-tabs-line--primary" role="tablist">
                    @foreach ($phases as $phaseId => $phase)
                        <li class="nav-item m-tabs__item">
                            <a class="nav-link m-tabs__link {{ $phaseId == $selectedPhaseId ? 'active' : '' }} attendance-phase"
                                data-toggle="tab" data-phase-id="{{ $phaseId }}"
                                data-loaded="{{ $phaseId == 1 ? 1 : 0 }}" href="#attendance-{{ $phaseId }}"
                                role="tab">{{ $phase }}</a>
                        </li>
                    @endforeach
                </ul>
                {{-- <div class="tab-content">
                     @foreach ($phases as $phaseId => $phase)
                         <div class="tab-pane {{($phaseId == $selectedPhaseId) ? 'active' : ''}}" id="attendance-{{$phaseId}}" role="tabpanel" style="min-height: 250px">
                             <div class="row" id="attendance-{{$phaseId}}-subjects"></div>
                         </div>
                     @endforeach
                 </div> --}}
                <div class="tab-content">
                    @foreach ($phases as $phaseId => $phase)
                        <div class="tab-pane {{ $phaseId == 1 ? 'active' : '' }}" id="attendance-{{ $phaseId }}"
                            role="tabpanel" style="min-height: 250px">
                            <div class="row" id="attendance-{{ $phaseId }}-todaysClasses"></div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
    <!-- Daily attendance  end-->

    <!-- latest 5 notice start-->
    <div class="m-portlet  m-portlet--unair">
        <div class="m-portlet__body  m-portlet__body--no-padding">
            <div class="row m-row--no-padding">
                <div class="col-12 my-2">
                    <h5>Latest Notices</h5>
                </div>
                <div class="col-12">
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th scope="col">Sr. No</th>
                                    <th scope="col">Title</th>
                                    <th scope="col">Published Date</th>
                                    <th scope="col">Notice File</th>
                                    <th scope="col">Status</th>
                                    <th scope="col">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if ($latestNotices->isNotEmpty())
                                    @foreach ($latestNotices as $key => $notice)
                                        <tr>
                                            <td>{{ $key + 1 }}</td>
                                            <td>{{ $notice->title }}</td>
                                            <td>{{ !empty($notice->published_date) ? $notice->published_date : '--' }}</td>
                                            <td>
                                                @if (isset($notice->file_path))
                                                    <a href="{{ asset('nemc_files/noticeBoard/' . $notice->file_path) }}"
                                                        class=" btn m-btn m-btn--hover-brand m-btn--icon m-btn--icon-only m-btn--pill"
                                                        target="_blank" title="Download " download><i
                                                            class="fa fa-download"></i>
                                                    </a>
                                                @else
                                                    <span>--</span>
                                                @endif
                                            </td>
                                            <td>
                                                @if (!empty($notice->published_date))
                                                    {!! setNoticeBoardStatus($notice->status = 2) !!}
                                                @else
                                                    {!! setNoticeBoardStatus($notice->status) !!}
                                                @endif
                                            </td>
                                            <td>
                                                <a href="{{ route(customRoute('notice_board.show'), $notice->id) }}"
                                                    target="_blank"
                                                    class="m-portlet__nav-link btn m-btn m-btn--hover-brand m-btn--icon m-btn--icon-only m-btn--pill"
                                                    title="View"><i class="flaticon-eye"></i>
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                @else
                                    <tr>
                                        <td colspan="6">
                                            <p class="text-center mb-0">No data found</p>
                                        </td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- latest 5 notice end-->

    <!-- Next One week holidays start-->
    <div class="m-portlet  m-portlet--unair">
        <div class="m-portlet__body  m-portlet__body--no-padding">
            <div class="row m-row--no-padding">
                <div class="col-12 my-2">
                    <h5>Next One week holidays</h5>
                </div>
                <div class="col-12">
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th scope="col">Sr. No</th>
                                    <th scope="col">Title</th>
                                    <th scope="col">From Date</th>
                                    <th scope="col">To Date</th>
                                    <th scope="col">Session</th>
                                    <th scope="col">Batch Type</th>
                                    <th scope="col">Status</th>
                                    <th scope="col">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if ($nextOneWeekHolidays->isNotEmpty())
                                    @foreach ($nextOneWeekHolidays as $key => $holiday)
                                        <tr>
                                            <td>{{ $key + 1 }}</td>
                                            <td>{{ $holiday->title }}</td>
                                            <td>{{ $holiday->from_date }}</td>
                                            <td>{{ $holiday->to_date }}</td>
                                            <td>{{ !empty($holiday->session) ? $holiday->session->title : 'All' }}</td>
                                            <td>{{ !empty($holiday->batchType) ? $holiday->batchType->title : 'All' }}
                                            </td>
                                            <td>{!! setHolidayStatus($holiday->status) !!}</td>
                                            <td>
                                                <a href="{{ route(customRoute('holiday.show'), $holiday->id) }}"
                                                    target="_blank"
                                                    class="m-portlet__nav-link btn m-btn m-btn--hover-brand m-btn--icon m-btn--icon-only m-btn--pill"
                                                    title="View"><i class="flaticon-eye"></i>
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                @else
                                    <tr>
                                        <td colspan="8">
                                            <p class="text-center mb-0">No data found</p>
                                        </td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Next One week holidays end-->

    <div class="card mt-4">
        <div class="card-header">Attendance (Month)</div>
        <div class="card-body">
            <div class="m-portlet  m-portlet--unair">
                <ul class="nav nav-tabs  m-tabs-line m-tabs-line--primary" role="tablist">
                    @foreach ($phases as $phaseId => $phase)
                        <li class="nav-item m-tabs__item">
                            <a class="nav-link m-tabs__link {{ $phaseId == $selectedPhaseId ? 'active' : '' }} attendance-month-phase"
                                data-toggle="tab" data-phase-id="{{ $phaseId }}"
                                data-loaded="{{ $phaseId == $selectedPhaseId ? 1 : 0 }}" href="#attendance-month-{{ $phaseId }}"
                                role="tab">{{ $phase }}</a>
                        </li>
                    @endforeach
                </ul>
                <div class="tab-content">
                    @foreach ($phases as $phaseId => $phase)
                        <div class="tab-pane {{ $phaseId == $selectedPhaseId ? 'active' : '' }}"
                            id="attendance-month-{{ $phaseId }}" role="tabpanel" style="min-height: 250px">
                            <div class="row" id="attendance-month-{{ $phaseId }}-subjects"></div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    {{--    Card Items & Subjects--}}
    <div class="card mt-4">
        <div class="card-header">Items & Card</div>
        <div class="card-body">
            <div class="m-portlet  m-portlet--unair">
                <ul class="nav nav-tabs  m-tabs-line m-tabs-line--primary" role="tablist">
                    @foreach ($phases as $phaseId => $phase)
                        <li class="nav-item m-tabs__item">
                            <a class="nav-link m-tabs__link {{ $phaseId == 1 ? 'active' : '' }} item-card-phase"
                                data-toggle="tab" data-phase-id="{{ $phaseId }}"
                                data-loaded="{{ $phaseId == 1 ? 1 : 0 }}" href="#item-card-{{ $phaseId }}"
                                role="tab">{{ $phase }}</a>
                        </li>
                    @endforeach
                </ul>
                <div class="tab-content">
                    @foreach ($phases as $phaseId => $phase)
                        <div class="tab-pane {{ $phaseId == 1 ? 'active' : '' }}" id="item-card-{{ $phaseId }}"
                            role="tabpanel" style="min-height: 250px">
                            <div class="row" id="card-items-{{ $phaseId }}-subjects"></div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

@endsection


@push('scripts')
    <script src="//cdnjs.cloudflare.com/ajax/libs/handlebars.js/4.1.0/handlebars.min.js"></script>
    <script src="https://code.highcharts.com/highcharts.js"></script>
    <script src="{{ asset('assets/global/plugins/datatables/datatables.bundle.js') }}" type="text/javascript"></script>
    <script src="{{ asset('assets/global/scripts/charts.js') }}"></script>

    {{-- <script id="phase-attendance" type="text/x-handlebars-template">
        @{{#each subjects}}
        <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4 col-xl-4">
            <div id='attendance-phase@{{ phaseId }}-subject@{{ id }}' style="height: 250px"></div>
        </div>
        @{{/each}}
    </script> --}}
    <script id="phase-attendance" type="text/x-handlebars-template">
        @{{#each todaysClasses}}
        <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4 col-xl-4 mb-4">
            <div id='attendance-phase@{{ phaseId }}-todayClass@{{ id }}' style="height: 250px"></div>
        </div>
        @{{else}}
        <div class="col-12">
            <p class="text-center mb-0"> No data found</p>
        </div>
        @{{/each}}
    </script>

    <script id="phase-attendance-month" type="text/x-handlebars-template">
        @{{#each subjects}}
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
            <div id='attendance-month-phase@{{ phaseId }}-subject@{{ id }}' style="height: 250px"></div>
        </div>
        @{{else}}
        <div class="col-12">
            <p class="text-center mb-0"> No data found</p>
        </div>
        @{{/each}}
    </script>

    <script id="phase-cards" type="text/x-handlebars-template">
        @{{#each subjects}}
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
            <div class="card">
                <div class="card-header">@{{ title }}</div>
                <div class="card-body">
                    <div class="row">
                        @{{#each cardItems}}
                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
                            <div id='phase@{{ phaseId }}-subject@{{ subjectId }}-card@{{ id }}'
                                 style="height: 250px"></div>
                        </div>
                        @{{else}}
                        <div class="col-12">
                            <p class="text-center mb-0"> No data found</p>
                        </div>
                        @{{/each}}
                    </div>
                </div>
            </div>
        </div>
        @{{/each}}
    </script>

    <script>
        var courseId = '{{ $courseId }}';
        var phaseId = '{{ $selectedPhaseId }}';
        var sessionId = '{{ $sessionId }}';

        function loadDailyAttendance(phase_id, courseId) {
            attendenceId = 'attendance-' + phase_id + '-todaysClasses';

            mApp.block('#' + attendenceId, {
                overlayColor: "#000000",
                type: "loader",
                state: "primary",
                message: "Please wait..."
            });

            $.get(baseUrl + 'admin/dashboard/get-today-attendance', {
                phase_id: phase_id,
                course_id: courseId,
                session_id: sessionId
            }, function(response) {

                attemdanceTemplate = $('#phase-attendance').html();
                attemdanceTemplateData = Handlebars.compile(attemdanceTemplate);
                $("#" + attendenceId).html(attemdanceTemplateData(response));

                for (i in response.todaysClasses) {
                    todayClass = response.todaysClasses[i];
                    subjectTitle = todayClass.id + ' - ' + todayClass.subject.title;
                    classTypeTitle = todayClass.class_type.title;
                    todayClassId = 'attendance-phase' + todayClass.phaseId + '-todayClass' + todayClass.id;

                    generatePieChart(todayClassId, subjectTitle, classTypeTitle, false, 'count', 'Attendance',
                        todayClass.chardData);
                }
                mApp.unblock('#' + attendenceId);
            });
        }

        function loadAttendanceByMonth(phase_id, courseId) {
            monthlyAttendance = 'attendance-month-' + phase_id + '-subjects';

            mApp.block('#' + monthlyAttendance, {
                overlayColor: "#000000",
                type: "loader",
                state: "primary",
                message: "Please wait..."
            });

            $.get(baseUrl + 'admin/dashboard/get-monthly-attendance', {
                phase_id: phase_id,
                course_id: courseId
            }, function(response) {

                attendanceByMonthTemplate = $('#phase-attendance-month').html();
                attendanceByMonthTemplateData = Handlebars.compile(attendanceByMonthTemplate);
                $("#" + monthlyAttendance).html(attendanceByMonthTemplateData(response));

                for (i in response.subjects) {
                    subject = response.subjects[i];
                    attendanceId = 'attendance-month-phase' + subject.phaseId + '-subject' + subject.id;

                    generateBarChart(attendanceId, subject.title, subject.classDates, 'Students', subject.seriesData)

                }
                mApp.unblock('#' + monthlyAttendance);
            });
        }

        function loadCardItems(phase_id, courseId) {
            cardItemId = 'card-items-' + phase_id + '-subjects';

            mApp.block('#' + cardItemId, {
                overlayColor: "#000000",
                type: "loader",
                state: "primary",
                message: "Please wait..."
            });

            $.get(baseUrl + 'admin/dashboard/card-items', {
                phase_id: phase_id,
                course_id: courseId,
                session_id: sessionId
            }, function(response) {

                cardItemsTemplate = $('#phase-cards').html();
                cardItemsTemplateData = Handlebars.compile(cardItemsTemplate);
                $("#" + cardItemId).html(cardItemsTemplateData(response));

                for (i in response.subjects) {
                    subject = response.subjects[i];
                    for (j in subject.cardItems) {
                        card = subject.cardItems[j];
                        cardRow = 'phase' + card.phaseId + '-subject' + subject.id + '-card' + card.id;

                        generateBarChart(cardRow, card.title, card.cardItems, 'Students', card.seriesData)

                    }

                }
                mApp.unblock('#' + cardItemId);
            });
        }

        function loadDailyClassRoutine(phase_id, courseId) {
            var classRoutineTableColumns = [{
                    "data": "subject_id",
                    "name": "subject_id"
                },
                {
                    "data": "class_type_id",
                    "name": "class_type_id"
                },
                {
                    "data": "teacher_id",
                    "name": "teacher_id"
                },
                {
                    "data": "session_id",
                    "name": "session_id"
                },
                {
                    "data": "class_time",
                    "name": "class_time"
                },
                {
                    "data": "action",
                    "name": "action"
                }
            ];

            classRoutineId = 'routine-phase' + phase_id;

            generateDatatable(classRoutineId, classRoutineTableColumns,
                baseUrl + 'admin/dashboard/get-today-routine?session_id='+sessionId+'&course_id=' + courseId + '&phase_id=' + phase_id, 3, 'asc');
        }

        function loadDashboardModules() {
            loadMonthlyClass();
            loadDailyAttendance(phaseId, courseId);
            loadAttendanceByMonth(phaseId, courseId);
            loadCardItems(phaseId, courseId);
            loadDailyClassRoutine(phaseId, courseId);
        }

        loadDashboardModules();

        function loadMonthlyClass() {
            var classRoutineInfo = '{{ $monthlyClasses }}';
            //remove "&quot"
            var classInfo = JSON.parse(classRoutineInfo.replace(/&quot;/g, '"'));
            // class dates
            var dates = classInfo.classDates;
            //class number count
            var classNumbers = classInfo.classRoutine;
            if (dates.length === 0) {
                $('#has-Classdata-to-chart').addClass('d-none')
                $('#has-Not-Classdata-to-chart').removeClass('d-none')
            }
            generateMonthlyClassLineChart(dates, classNumbers)

        }

        $('.attendance-phase').click(function(e) {
            var selected = $(this);
            var phaseId = $(this).data('phase-id');

            if ($(this).attr('data-loaded') == 0) {
                loadDailyAttendance(phaseId, courseId);
                selected.attr('data-loaded', 1);
            }
        });

        $('.attendance-month-phase').click(function(e) {
            var selected = $(this);
            var phaseId = $(this).data('phase-id');


            if ($(this).attr('data-loaded') == 0) {
                loadAttendanceByMonth(phaseId, courseId);
                selected.attr('data-loaded', 1);
            }
        });

        $('.item-card-phase').click(function(e) {
            var selected = $(this);
            var phaseId = $(this).data('phase-id');

            if ($(this).attr('data-loaded') == 0) {
                loadCardItems(phaseId, courseId);
                selected.attr('data-loaded', 1);
            }
        });

        $('.routine-phase').click(function(e) {
            var selected = $(this);
            var phaseId = $(this).data('phase-id');

            if ($(this).attr('data-loaded') == 0) {
                loadDailyClassRoutine(phaseId, courseId);
                selected.attr('data-loaded', 1);
            }
        });
    </script>
@endpush
