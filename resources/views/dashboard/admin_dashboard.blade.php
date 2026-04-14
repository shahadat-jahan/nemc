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

        .table td {
            padding-top: 0.6rem !important;
            padding-bottom: .2rem !important;
            vertical-align: top;
            border-top: 1px solid #f4f5f8;
        }
    </style>
@endpush

@section('content')
    <?php
    $courseId = app()->request->course_id ?? (Auth::guard('web')->user()->adminUser->course_id ?? 1);
    $sessionId = isset(app()->request->session_id) && !empty(app()->request->session_id) ? app()->request->session_id : $currentSessionId;
    ?>
    <!-- BEGIN: Subheader -->
    <div class="m-subheader">
        <div class="d-flex flex-column flex-md-row align-items-md-center justify-content-between flex-wrap gap-2">
            <div class="mr-auto mb-3 mb-md-0">
                <h3 class="m-subheader__title">Dashboard</h3>
            </div>

            @if (Auth::guard('web')->user()->user_group_id == 1 || Auth::guard('web')->user()->user_group_id == 2)
                <div class="d-flex flex-column flex-md-row flex-wrap gap-2 justify-content-md-end">

                    {{-- Student View Form --}}
                    @if (hasPermission('students/view'))
                        <form method="post" action="{{ route('students.profile') }}"
                            class="d-flex flex-row flex-nowrap mb-2 mb-md-0" style="max-width: 20rem;">
                            @csrf
                            <input type="number" name="student_user_id" class="form-control border-success"
                                placeholder="Student ID" required>
                            <button type="submit" class="btn btn-success mr-2">View Student</button>
                        </form>
                    @endif

                    {{-- Class View Form --}}
                    @if (hasPermission('class_routine/view'))
                        <form method="get" action="{{ route('class.single') }}"
                            class="d-flex flex-row flex-nowrap mb-2 mb-md-0" style="max-width: 15rem;">
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

                        <select name="course_id" class="form-control border-success mr-2 mb-2 mb-md-0">
                            <option value="">--- Course ---</option>
                            {!! select($courses, request()->course_id ?? $courseId) !!}
                        </select>

                        <button type="submit" class="btn btn-success mr-2 mb-2 mb-md-0" title="Search">
                            <i class="fas fa-search"></i>
                        </button>
                        <a href="{{ route('dashboard') }}" class="btn btn-success mb-2 mb-md-0" title="Reset">
                            <i class="fas fa-sync-alt"></i>
                        </a>
                    </form>
                </div>
            @endif
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
                            <h4 class="m-widget24__title">Batch Number</h4><br>
                            <span class="m-widget24__desc">{{ $courses[$courseId] }}</span>
                            <span class="m-widget24__stats m--font-brand">{{ $batchNumber }}</span>
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
                            <h4 class="m-widget24__title">Total Students</h4><br>
                            <span class="m-widget24__desc">{{ $courses[$courseId] }}</span>
                            <span class="m-widget24__stats m--font-accent">{{ $totalStudents }}</span>
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
                            <h4 class="m-widget24__title">Total Teachers</h4><br>
                            <span class="m-widget24__desc">{{ $courses[$courseId] }}</span>
                            <span class="m-widget24__stats m--font-success">{{ $totalTeachers }}</span>
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
                            <h4 class="m-widget24__title">Total Subjects</h4><br>
                            <span class="m-widget24__desc">{{ $courses[$courseId] }}</span>
                            <span class="m-widget24__stats m--font-info">{{ $totalSubjects }}</span>
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

    <!--end:: Widgets/Stats-->

    <!--daily attendance chart start-->
    <div class="card mb-4">
        <div class="card-header">Daily Attendance</div>
        <div class="card-body">
            <div class="m-portlet  m-portlet--unair">
                <ul class="nav nav-tabs  m-tabs-line m-tabs-line--primary" role="tablist">

                    @foreach ($phases as $phaseId => $phase)
                        <li class="nav-item m-tabs__item">
                            <a class="nav-link m-tabs__link {{ $phaseId == 1 ? 'active' : '' }} attendance-phase"
                                data-toggle="tab" data-phase-id="{{ $phaseId }}"
                                data-loaded="{{ $phaseId == 1 ? 1 : 0 }}" href="#attendance-{{ $phaseId }}"
                                role="tab">{{ $phase }}</a>
                        </li>
                    @endforeach
                </ul>
                {{-- <div class="tab-content">
                    @foreach ($phases as $phaseId => $phase)
                        <div class="tab-pane {{($phaseId == 1) ? 'active' : ''}}" id="attendance-{{$phaseId}}" role="tabpanel" style="min-height: 250px">
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
    <!--daily attendance chart end-->

    <!--Student fee start-->
    <div class="m-portlet  m-portlet--unair">
        <div class="m-portlet__body  m-portlet__body--no-padding">
            <!--Student fee for BD start-->
            <div class="row m-row--no-padding">
                <div class="col-12" style="min-height: 30rem;">
                    <figure class="highcharts-figure">
                        <div id="bd-student-fee-container"></div>
                        <p class="highcharts-description"><b>NB. Amount currency is BDT(Tk)</b></p>
                    </figure>
                </div>
            </div>
            <!--Student fee for BD end-->

            <div class="m-separator m-separator--dashed"></div>
            <!--Student fee for foreign start-->
            <div class="row m-row--no-padding">
                <div class="col-12" style="min-height: 30rem;">
                    <figure class="highcharts-figure">
                        <div id="foreign-student-fee-container"></div>
                        <p class="highcharts-description"><b>NB. Amount currency is USD($)</b></p>
                    </figure>
                </div>
            </div>
            <!--Student fee for foreign end-->
        </div>
    </div>
    <!--Student fee end-->

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
                                                @if (hasPermission('notice_board/edit'))
                                                    <a href="{{ route('notice_board.edit', [$notice->id]) }}"
                                                        class="m-portlet__nav-link btn m-btn m-btn--hover-brand m-btn--icon m-btn--icon-only m-btn--pill"
                                                        title="Edit"><i class="flaticon-edit"></i></a>
                                                @endif
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
    <!-- latest 5 notice start-->
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
                                                @if (hasPermission('holiday/edit'))
                                                    <a href="{{ route('holiday.edit', [$holiday->id]) }}"
                                                        class="m-portlet__nav-link btn m-btn m-btn--hover-brand m-btn--icon m-btn--icon-only m-btn--pill"
                                                        title="Edit"><i class="flaticon-edit"></i></a>
                                                @endif
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
    <!-- latest 5 notice end-->

    <!-- today's class routine start -->
    <div class="card mt-4">
        <div class="card-header d-flex justify-content-between">
            <div class="pt-2">Today's Class Routine</div>
            <div>
                <button class="btn btn-success btn-sm" type="button" data-toggle="collapse"
                    data-target="#collapseTodayClassRoutine" aria-expanded="false"
                    aria-controls="collapseTodayClassRoutine">
                    Show All <i class="fas fa-chevron-down pt-1"></i>
                </button>
            </div>
        </div>
        <div class="collapse" id="collapseTodayClassRoutine">
            <div class="card-body">
                <div class="m-portlet  m-portlet--unair">
                    <ul class="nav nav-tabs  m-tabs-line m-tabs-line--primary" role="tablist">
                        @foreach ($phases as $phaseId => $phase)
                            <li class="nav-item m-tabs__item">
                                <a class="nav-link m-tabs__link {{ $phaseId == 1 ? 'active' : '' }} routine-phase"
                                    data-toggle="tab" data-phase-id="{{ $phaseId }}"
                                    data-loaded="{{ $phaseId == 1 ? 1 : 0 }}" href="#routine-{{ $phaseId }}"
                                    role="tab">{{ $phase }}</a>
                            </li>
                        @endforeach
                    </ul>
                    <div class="tab-content">
                        @foreach ($phases as $phaseId => $phase)
                            <div class="tab-pane {{ $phaseId == 1 ? 'active' : '' }}" id="routine-{{ $phaseId }}"
                                role="tabpanel">
                                <div class="table-responsive">
                                    <table class="table table-bordered table-hover"
                                        id="routine-phase{{ $phaseId }}">
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
    </div>
    <!-- today's class routine end -->

    <!-- last 1 week class routine start -->
    <div class="card mt-4">
        <div class="card-header d-flex justify-content-between">
            <div class="pt-2">Last 1 week Class Routine</div>
            <div>
                <button class="btn btn-success btn-sm" type="button" data-toggle="collapse"
                    data-target="#collapseLastOneWeekClassRoutine" aria-expanded="false"
                    aria-controls="collapseLastOneWeekClassRoutine">
                    Show All <i class="fas fa-chevron-down pt-1"></i>
                </button>
            </div>
        </div>
        <div class="collapse" id="collapseLastOneWeekClassRoutine">
            <div class="card-body">
                <div class="row">
                    <div class="col-sm-12 col-md-6">
                        <div class="media">
                            <img src="{{ asset('assets/global/img/not-taken.png') }}" class="mr-3 img-thumbnail"
                                alt="...">
                            <div class="media-body">
                                <p class="mt-2 pt-1">Class don't taken/ attendance not provided by teacher</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-12 col-md-6">
                        <div class="media">
                            <img src="{{ asset('assets/global/img/taken.png') }}" class="mr-3 img-thumbnail"
                                alt="...">
                            <div class="media-body">
                                <p class="mt-2 pt-1">Class is taken/ attendance is provided by teacher</p>
                            </div>
                        </div>
                    </div>
                </div>
                <hr>
                <div class="m-portlet  m-portlet--unair">
                    <ul class="nav nav-tabs  m-tabs-line m-tabs-line--primary" role="tablist">
                        @foreach ($phases as $phaseId => $phase)
                            <li class="nav-item m-tabs__item">
                                <a class="nav-link m-tabs__link {{ $phaseId == 1 ? 'active' : '' }} routine-phase-last-week"
                                    data-toggle="tab" data-phase-id="{{ $phaseId }}"
                                    data-loaded="{{ $phaseId == 1 ? 1 : 0 }}"
                                    href="#routine-last-week-{{ $phaseId }}" role="tab">{{ $phase }}</a>
                            </li>
                        @endforeach
                    </ul>
                    <div class="tab-content">
                        @foreach ($phases as $phaseId => $phase)
                            <div class="tab-pane {{ $phaseId == 1 ? 'active' : '' }}"
                                id="routine-last-week-{{ $phaseId }}" role="tabpanel">
                                <div class="table-responsive">
                                    <table class="table table-bordered table-hover"
                                        id="routine-phase-last-week{{ $phaseId }}">
                                        <thead>
                                            <tr>
                                                <th class="uppercase">Subject</th>
                                                <th class="uppercase">Class Type</th>
                                                <th class="uppercase">Teacher</th>
                                                <th class="uppercase">Session</th>
                                                <th class="uppercase">Date</th>
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
    </div>
    <!-- last 1 week class routine end -->

    <!-- Upcoming Exams (Next 1 Month) start -->
    <div class="card mt-4">
        <div class="card-header d-flex justify-content-between">
            <div class="pt-2">Upcoming Exams (Next 1 Month)</div>
            <div>
                <button class="btn btn-success btn-sm" type="button" data-toggle="collapse"
                    data-target="#collapseUpCommingExam" aria-expanded="false" aria-controls="collapseUpCommingExam">
                    Show All <i class="fas fa-chevron-down pt-1"></i>
                </button>
            </div>
        </div>
        <div class="collapse" id="collapseUpCommingExam">
            <div class="card-body">
                <div class="m-portlet  m-portlet--unair">
                    <ul class="nav nav-tabs  m-tabs-line m-tabs-line--primary" role="tablist">
                        @foreach ($phases as $phaseId => $phase)
                            <li class="nav-item m-tabs__item">
                                <a class="nav-link m-tabs__link {{ $phaseId == 1 ? 'active' : '' }} exam-phase"
                                    data-toggle="tab" data-phase-id="{{ $phaseId }}"
                                    data-loaded="{{ $phaseId == 1 ? 1 : 0 }}" href="#exams-{{ $phaseId }}"
                                    role="tab">{{ $phase }}</a>
                            </li>
                        @endforeach
                    </ul>
                    <div class="tab-content">
                        @foreach ($phases as $phaseId => $phase)
                            <div class="tab-pane {{ $phaseId == 1 ? 'active' : '' }}" id="exams-{{ $phaseId }}"
                                role="tabpanel">
                                <div class="table-responsive">
                                    <table class="table table-bordered table-hover" id="exams-phase{{ $phaseId }}">
                                        <thead>
                                            <tr>
                                                <th class="uppercase">Title</th>
                                                <th class="uppercase">Subject</th>
                                                <th class="uppercase">Phase</th>
                                                <th class="uppercase">Term</th>
                                                <th class="uppercase">Session</th>
                                                <th class="uppercase">Date</th>
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
    </div>
    <!-- Upcoming Exams (Next 1 Month) end -->

    <div class="card mt-4">
        <div class="card-header d-flex justify-content-between">
            <div class="pt-2">Items & Card</div>
            <div>
                <button class="btn btn-success btn-sm" type="button" data-toggle="collapse"
                    data-target="#collapseItemCard" aria-expanded="false" aria-controls="collapseItemCard">
                    Show All <i class="fas fa-chevron-down pt-1"></i>
                </button>
            </div>
        </div>
        <div class="collapse" id="collapseItemCard">
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
    </div>

@endsection


@push('scripts')
    <script src="//cdnjs.cloudflare.com/ajax/libs/handlebars.js/4.1.0/handlebars.min.js"></script>
    <script src="https://code.highcharts.com/highcharts.js"></script>
    <script src="{{ asset('assets/global/plugins/datatables/datatables.bundle.js') }}" type="text/javascript"></script>
    <script src="{{ asset('assets/global/scripts/charts.js') }}"></script>

    {{-- <script id="phase-attendance" type="text/x-handlebars-template">
        <div class="col-12"><h3 class="text-center">Lecture Class</h3>
            <hr></div>
        @{{#each subjects}}
        <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4 col-xl-4">
            <div id='attendance-phase@{{ phaseId }}-subject@{{ id }}' style="height: 250px"></div>
        </div>
        @{{/each}}
    </script> --}}

    <!-- today's class routine start -->
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
    <!-- today's class routine end -->

    <!-- last week class routine start -->
    <script id="phase-attendance-last-week" type="text/x-handlebars-template">
        @{{#each lastWeekClasses}}
        <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4 col-xl-4 mb-4">
            <div id='attendance-phase@{{ phaseId }}-lastWeekClass@{{ id }}' style="height: 250px"></div>
        </div>
        @{{/each}}
    </script>
    <!-- last week class routine end -->

    <!-- Items & Card start -->
    <script id="phase-cards" type="text/x-handlebars-template">
        @{{#each subjects}}
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
            <div class="card mb-3">
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
    <!-- Items & Card end -->

    <script>
        var courseId = '{{ $courseId }}';
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

                /*for(i in response.subjects){
                    subject = response.subjects[i];
                    subjectId = 'attendance-phase'+subject.phaseId+'-subject'+subject.id;

                    generatePieChart(subjectId, subject.title, false, 'count', 'Attendance',subject.chardData);
                }*/

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

        function loadDailyClassRoutine(sessionId, phase_id, courseId) {
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
                baseUrl + 'admin/dashboard/get-today-routine?session_id=' + sessionId + '&course_id=' + courseId +
                '&phase_id=' + phase_id, 3, 'asc');
        }

        function loadLastWeekClassRoutine(sessionId, phase_id, courseId) {
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
                    "data": "class_date",
                    "name": "class_date"
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

            classRoutineId = 'routine-phase-last-week' + phase_id;

            generateDatatable(classRoutineId, classRoutineTableColumns,
                baseUrl + 'admin/dashboard/get-last-week-routine?session_id=' + sessionId + '&course_id=' + courseId +
                '&phase_id=' + phase_id, 3, 'asc');
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

        function loadUpcomingExams(phase_id, courseId) {
            var examTableColumns = [{
                    "data": "title",
                    "name": "title"
                },
                {
                    "data": "subject_id",
                    "name": "subject_id"
                },
                {
                    "data": "phase_id",
                    "name": "phase_id"
                },
                {
                    "data": "term_id",
                    "name": "term_id"
                },
                {
                    "data": "session_id",
                    "name": "session_id"
                },
                {
                    "data": "exam_date",
                    "name": "exam_date"
                },
                {
                    "data": "exam_time",
                    "name": "exam_time"
                },
                {
                    "data": "action",
                    "name": "action"
                }
            ];

            examRoutineId = 'exams-phase' + phase_id;

            generateDatatable(examRoutineId, examTableColumns,
                baseUrl + 'admin/dashboard/upcoming-exams?course_id=' + courseId + '&phase_id=' + phase_id +
                '&session_id=' + sessionId, 5, 'asc');
        }

        function loadDashboardModules() {
            loadDailyAttendance(1, courseId);
            loadFeeChart();
            loadCardItems(1, courseId);
            loadDailyClassRoutine(sessionId, 1, courseId);
            loadLastWeekClassRoutine(sessionId, 1, courseId);
            loadUpcomingExams(1, courseId);
        }

        loadDashboardModules();

        $('.attendance-phase').click(function(e) {
            var selected = $(this);
            var phaseId = $(this).data('phase-id');

            if ($(this).attr('data-loaded') == 0) {
                loadDailyAttendance(phaseId, courseId);
                selected.attr('data-loaded', 1);
            }
        })

        $('.routine-phase').click(function(e) {
            var selected = $(this);
            var phaseId = $(this).data('phase-id');
            if ($(this).attr('data-loaded') == 0) {
                loadDailyClassRoutine(sessionId, phaseId, courseId);
                selected.attr('data-loaded', 1);
            }
        });

        $('.routine-phase-last-week').click(function(e) {
            var selected = $(this);
            var phaseId = $(this).data('phase-id');

            if ($(this).attr('data-loaded') == 0) {
                loadLastWeekClassRoutine(sessionId, phaseId, courseId);
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

        $('.exam-phase').click(function(e) {
            var selected = $(this);
            var phaseId = $(this).data('phase-id');

            if ($(this).attr('data-loaded') == 0) {
                loadUpcomingExams(phaseId, courseId);
                selected.attr('data-loaded', 1);
            }
        });

        function loadFeeChart() {
            var feeNames = @json($feeNames);
        //    BD Student fees start
            var mbbsFeeAmounts = '{{ $mbbsFeeAmounts }}';
            var mbbsFeeAmounts = [mbbsFeeAmounts.replace(/((\[\s*)|(\s*\]))/g, "")]; //remove "[]" bracket
            var mbbsFeeAmounts = JSON.parse("[" + mbbsFeeAmounts + "]"); //convert to array(add "[]")

            var bdsFeeAmounts = '{{ $bdsFeeAmounts }}';
            var bdsFeeAmounts = [bdsFeeAmounts.replace(/((\[\s*)|(\s*\]))/g, "")]; //remove "[]" bracket
            var bdsFeeAmounts = JSON.parse("[" + bdsFeeAmounts + "]"); //convert to array(add "[]")

            // BD Student fees end

        //    Foreign Student fees start
            var foreignMbbsFeeAmounts = '{{ $foreignMbbsFeeAmounts }}';
            var foreignMbbsFeeAmounts = [foreignMbbsFeeAmounts.replace(/((\[\s*)|(\s*\]))/g, "")]; //remove "[]" bracket
            var foreignMbbsFeeAmounts = JSON.parse("[" + foreignMbbsFeeAmounts + "]"); //convert to array(add "[]")

            var foreignBdsFeeAmounts = '{{ $foreignBdsFeeAmounts }}';
            var foreignBdsFeeAmounts = [foreignBdsFeeAmounts.replace(/((\[\s*)|(\s*\]))/g, "")]; //remove "[]" bracket
            var foreignBdsFeeAmounts = JSON.parse("[" + foreignBdsFeeAmounts + "]"); //convert to array(add "[]")

            // Foreign Student fees end
            allBdStudentsFeesLineChart(feeNames, mbbsFeeAmounts, bdsFeeAmounts)
            allForeignStudentsFeesLineChart(feeNames, foreignMbbsFeeAmounts, foreignBdsFeeAmounts)
        }
    </script>
@endpush
