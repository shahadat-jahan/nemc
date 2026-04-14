@php use App\Models\Course; @endphp
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
            padding-bottom: .6rem !important;
            vertical-align: top;
            border-top: 1px solid #f4f5f8;
        }
    </style>
@endpush

@section('content')
    @php
        $authUser = Auth::guard('web')->user()->adminUser;
        $sessionId =
            isset(app()->request->session_id) && !empty(app()->request->session_id)
                ? app()->request->session_id
                : $currentSessionId;

        if (isset(app()->request->course_id)) {
            $courseTitle = Course::findOrFail(app()->request->course_id)->title;
            $courseId = app()->request->course_id;
        } elseif (isset($authUser->course_id)) {
            $courseTitle = $authUser->course->title;
            $courseId = $authUser->course_id;
        } else {
            $courseTitle = 'MBBS + BDS';
            $courseId = null;
        }
    @endphp


    <!-- BEGIN: Subheader -->
    <div class="m-subheader ">
        <div class="d-flex flex-wrap align-items-md-center justify-content-between gap-2">
            <div class="mr-auto mb-3">
                <h3 class="m-subheader__title">Dashboard</h3>
            </div>

            {{-- Student View Form --}}
            @if (hasPermission('students/view'))
                <form method="post" action="{{ route('students.profile') }}" class="d-flex flex-row flex-nowrap mb-2 mb-md-0"
                    style="max-width: 20rem;">
                    @csrf
                    <input type="number" name="student_user_id" class="form-control border-success"
                        placeholder="Student ID" required>
                    <button type="submit" class="btn btn-success mr-2">View Student</button>
                </form>
            @endif

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
            <form method="get" action="{{ route('dashboard') }}" class="d-flex flex-row align-items-center mb-2 mb-md-0"
                style="max-width: 100%;">
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
    </div>
    <!-- END: Subheader -->

    <!--begin:: Widgets/Stats-->
    <div class="m-portlet  m-portlet--unair">
        <div class="m-portlet__body  m-portlet__body--no-padding">
            <div class="row m-row--no-padding m-row--col-separator-xl">
                <div class="col-md-12 col-lg-6 col-xl-3">
                    <div class="m-widget24">
                        <div class="m-widget24__item">
                            <h4 class="m-widget24__title">Total Batches</h4><br>

                            <span
                                class="m-widget24__desc">{{ isset($courseId) ? $courses[$courseId] : $courseTitle }}</span>
                            <span class="m-widget24__stats m--font-brand">{{ $totalBatches }}</span>
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
                            <span
                                class="m-widget24__desc">{{ isset($courseId) ? $courses[$courseId] : $courseTitle }}</span>
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
                            <span
                                class="m-widget24__desc">{{ isset($courseId) ? $courses[$courseId] : $courseTitle }}</span>
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
                            <span
                                class="m-widget24__desc">{{ isset($courseId) ? $courses[$courseId] : $courseTitle }}</span>
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
@endsection

@push('scripts')
    <script src="https://code.highcharts.com/highcharts.js"></script>
    <script>
        // Build the chart
        Highcharts.chart('container', {
            chart: {
                plotBackgroundColor: null,
                plotBorderWidth: null,
                plotShadow: false,
                type: 'pie'
            },
            title: {
                text: 'Anatomy Card 1 (Sample data)'
            },
            tooltip: {
                pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
            },
            plotOptions: {
                pie: {
                    allowPointSelect: true,
                    cursor: 'pointer',
                    dataLabels: {
                        enabled: false
                    },
                    showInLegend: true
                }
            },
            series: [{
                name: 'Brands',
                colorByPoint: true,
                data: [{
                    name: 'Completed',
                    y: 70,
                    color: '#7CFC00',
                }, {
                    name: 'Not Yet Completed',
                    y: 30,
                    color: '#FF6666',
                }]
            }]
        });

        Highcharts.chart('container1', {
            chart: {
                type: 'column'
            },
            title: {
                text: 'Monthly Attendance - Anatomy (Sample Data)'
            },
            subtitle: {
                text: 'Source: WorldClimate.com'
            },
            xAxis: {
                categories: [
                    '1',
                    '2',
                    '3',
                    '4',
                    '5',
                    '6',
                    '7',
                    '8',
                    '9',
                    '10',
                    '11',
                    '12',
                    '13',
                    '14',
                    '15',
                    '16',
                    '17',
                    '18',
                    '19',
                    '20',
                    '21',
                    '22',
                    '23',
                    '25',
                    '26',
                    '27',
                    '28',
                    '29',
                    '30'
                ],
                crosshair: true
            },
            yAxis: {
                min: 0,
                title: {
                    text: 'Rainfall (mm)'
                }
            },
            tooltip: {
                headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
                pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
                    '<td style="padding:0"><b>{point.y:.1f} mm</b></td></tr>',
                footerFormat: '</table>',
                shared: true,
                useHTML: true
            },
            plotOptions: {
                column: {
                    pointPadding: 0.2,
                    borderWidth: 0
                }
            },
            series: [{
                name: 'Present',
                data: [50, 20, 30, 50, 50, 60, 30, 80, 90, 200, 110, 120, 70, 50, 80, 30, 10, 90, 110, 80,
                    30, 120, 50, 60, 40, 55, 33, 60, 20, 5
                ]

            }, {
                name: 'Absent',
                data: [10, 20, 20, 50, 50, 60, 30, 150, 90, 200, 10, 20, 20, 5, 40, 30, 10, 90, 18, 30, 20,
                    10, 50, 60, 40, 55, 33, 60, 20, 5
                ]

            }, ]
        });
    </script>
@endpush
