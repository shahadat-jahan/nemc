@extends('layouts.default')
@section('pageTitle', 'Dashboard')

@push('style')
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

        .row.m-row--col-separator-xl>div {
            border-bottom: 3px solid #f2f3f8 !important;
        }

        .m-widget24 .m-widget24__item .m-widget24__title {
            margin-bottom: 20px;
        }

        .m-widget24 .m-widget24__item .m-widget24__stats {
            font-size: 1.3rem;
        }
    </style>
@endpush

@section('content')
    @php
        $authUser = Auth::guard('web')->user()->adminUser;
        $authUserGroupId = Auth::guard('web')->user()->user_group_id;
        $sessionId =
            isset(app()->request->session_id) && !empty(app()->request->session_id)
                ? app()->request->session_id
                : $currentSessionId;

        //$courseId = (isset(app()->request->course_id) && !empty(app()->request->course_id)) ? app()->request->course_id : 1;
        if (isset(app()->request->course_id)) {
            $courseTitle = \App\Models\Course::findOrFail(app()->request->course_id)->title;
            $courseId = app()->request->course_id;
        } elseif (isset($authUser->course_id)) {
            $courseTitle = $authUser->course->title;
            $courseId = $authUser->course_id;
        } elseif ($authUserGroupId == 14) {
            $courseTitle = 'BDS';
            $courseId = 2;
        } elseif ($authUserGroupId == 15) {
            $courseTitle = 'MBBS';
            $courseId = 1;
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
                    <input type="number" name="student_user_id" class="form-control border-success" placeholder="Student ID"
                        required>
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
            @if ($authUserGroupId == 7)
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
            @endif
            @if ($authUserGroupId == 14 or $authUserGroupId == 15 or $authUserGroupId == 16)
                <div style="width: 27rem;">
                    <form class="m-form m-form--fit m-form--label-align-right" action="{{ route('dashboard') }}"
                        method="get">
                        @csrf
                        <div class="row">
                            <div class="{{ $authUserGroupId == 16 ? 'col-5' : 'col-9' }} px-1">
                                <select class="form-control m-input border-success" name="session_id" id="session_id">
                                    <option value=""> --- Session ---</option>
                                    {!! select($sessions, app()->request->session_id) !!}
                                </select>
                            </div>
                            @if ($authUserGroupId == 16)
                                <div class="col-4 px-1">
                                    <select class="form-control m-input border-success" name="course_id" id="course_id">
                                        <option value=""> --- Course ---</option>
                                        {!! select($courses, app()->request->course_id) !!}
                                    </select>
                                </div>
                            @endif
                            <div class="col-3 px-1">
                                <button type="submit" class="btn btn-success d-inline" title="Search">
                                    <i class="fas fa-search"></i></button>
                                <a href="{{ route('dashboard') }}" class="btn btn-success d-inline" title="Reset">
                                    <i class="fas fa-sync-alt"></i>
                                </a>
                            </div>
                        </div>
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
                <div class="col-md-12 col-lg-6 col-xl-4">
                    <div class="m-widget24">
                        <div class="m-widget24__item">
                            <h4 class="m-widget24__title">Total Development Fee (BD)</h4><br>
                            <span class="m-widget24__desc">{{ $courseTitle }}</span>
                            <span
                                class="m-widget24__stats m--font-brand">{{ number_format($totalDevelopmentFeeOfBdStudent, 2) }}/TK</span>
                            <div class="m--space-10"></div>
                            <div class="progress m-progress--sm mb-25">
                                <div class="progress-bar m--bg-brand" role="progressbar" style="width: 100%;"
                                    aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-12 col-lg-6 col-xl-4">
                    <div class="m-widget24">
                        <div class="m-widget24__item">
                            <h4 class="m-widget24__title">Total Development Fee (Foreign)</h4><br>
                            <span class="m-widget24__desc">{{ $courseTitle }}</span>
                            <span
                                class="m-widget24__stats m--font-brand">{{ number_format($totalDevelopmentFeeOfForeignStudent, 2) }}/
                                USD</span>
                            <div class="m--space-10"></div>
                            <div class="progress m-progress--sm mb-25">
                                <div class="progress-bar m--bg-accent" role="progressbar" style="width: 100%;"
                                    aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-12 col-lg-6 col-xl-4">
                    <div class="m-widget24">
                        <div class="m-widget24__item">
                            <h4 class="m-widget24__title">Total Tuition Fee (BD)</h4><br>
                            <span class="m-widget24__desc">{{ $courseTitle }}</span>
                            <span
                                class="m-widget24__stats m--font-success">{{ number_format($totalTuitionOfBdStudent, 2) }}/TK</span>
                            <div class="m--space-10"></div>
                            <div class="progress m-progress--sm mb-25">
                                <div class="progress-bar m--bg-success" role="progressbar" style="width: 100%;"
                                    aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-12 col-lg-6 col-xl-4">
                    <div class="m-widget24">
                        <div class="m-widget24__item">
                            <h4 class="m-widget24__title">Total Tuition Fee (Foreign)</h4><br>
                            <span class="m-widget24__desc">{{ $courseTitle }}</span>
                            <span
                                class="m-widget24__stats m--font-info">{{ number_format($totalTuitionOfForeignStudent, 2) }}/USD</span>
                            <div class="m--space-10"></div>
                            <div class="progress m-progress--sm mb-25">
                                <div class="progress-bar m--bg-info" role="progressbar" style="width: 100%;"
                                    aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-12 col-lg-6 col-xl-4">
                    <div class="m-widget24">
                        <div class="m-widget24__item">
                            <h4 class="m-widget24__title">Total Re-Admission Fee (BD)</h4><br>
                            <span class="m-widget24__desc">{{ $courseTitle }}</span>
                            <span
                                class="m-widget24__stats m--font-success">{{ number_format($totalReadmissionOfBdStudent, 2) }}/TK</span>
                            <div class="m--space-10"></div>
                            <div class="progress m-progress--sm mb-25">
                                <div class="progress-bar m--bg-success" role="progressbar" style="width: 100%;"
                                    aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-12 col-lg-6 col-xl-4">
                    <div class="m-widget24">
                        <div class="m-widget24__item">
                            <h4 class="m-widget24__title">Total Re-Admission Fee (Foreign)</h4><br>
                            <span class="m-widget24__desc">{{ $courseTitle }}</span>
                            <span
                                class="m-widget24__stats m--font-info">{{ number_format($totalReadmissionOfForeignStudent, 2) }}/USD</span>
                            <div class="m--space-10"></div>
                            <div class="progress m-progress--sm mb-25">
                                <div class="progress-bar m--bg-info" role="progressbar" style="width: 100%;"
                                    aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-12 col-lg-6 col-xl-4">
                    <div class="m-widget24">
                        <div class="m-widget24__item">
                            <h4 class="m-widget24__title">Total Absent Fee (BD)</h4><br>
                            <span class="m-widget24__desc">{{ $courseTitle }}</span>
                            <span
                                class="m-widget24__stats m--font-success">{{ number_format($totalAbsentOfBdStudent, 2) }}/TK</span>
                            <div class="m--space-10"></div>
                            <div class="progress m-progress--sm mb-25">
                                <div class="progress-bar m--bg-success" role="progressbar" style="width: 100%;"
                                    aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-12 col-lg-6 col-xl-4">
                    <div class="m-widget24">
                        <div class="m-widget24__item">
                            <h4 class="m-widget24__title">Total Absent Fee (Foreign)</h4><br>
                            <span class="m-widget24__desc">{{ $courseTitle }}</span>
                            <span
                                class="m-widget24__stats m--font-info">{{ number_format($totalAbsentOfForeignStudent, 2) }}/USD</span>
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
    <!-- latest 5 notice end-->

    <!--Phase wise fee and payment start (BD student)-->
    <div class="card">
        <div class="card-header d-flex justify-content-between">
            <div class="pt-2">Phase Wise Fee and Payment Info (BD)</div>
            <div>
                <button class="btn btn-success btn-sm" type="button" data-toggle="collapse"
                    data-target="#collapsePaymentBd" aria-expanded="false" aria-controls="collapsePaymentBd">
                    Show All <i class="fas fa-chevron-down pt-1"></i>
                </button>
            </div>
        </div>
        <div class="collapse" id="collapsePaymentBd">
            <div class="card-body">
                <div class="m-portlet  m-portlet--unair">
                    <ul class="nav nav-tabs  m-tabs-line m-tabs-line--primary" role="tablist">
                        @foreach ($phases as $phaseId => $phase)
                            <li class="nav-item m-tabs__item">
                                <a class="nav-link m-tabs__link {{ $phaseId == 1 ? 'active' : '' }} fee-and-payment-phase"
                                    data-toggle="tab" data-phase-id="{{ $phaseId }}"
                                    data-loaded="{{ $phaseId == 1 ? 1 : 0 }}" href="#feePayment-{{ $phaseId }}"
                                    role="tab">{{ $phase }}</a>
                            </li>
                        @endforeach
                    </ul>
                </div>
                <div class="tab-content">
                    @foreach ($phases as $phaseId => $phase)
                        <div class="tab-pane {{ $phaseId == 1 ? 'active' : '' }}" id="feePayment-{{ $phaseId }}"
                            role="tabpanel" style="min-height: 250px">
                            <div class="row" id="feePayment-{{ $phaseId }}-feeTypes"></div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
    <!--Phase wise fee and payment end (BD student)-->

    <!--Phase wise fee and payment start (Foreign student)-->
    <br>
    <div class="card">
        <div class="card-header d-flex justify-content-between">
            <div class="pt-2">Phase Wise Fee and Payment Info (Foreign)</div>
            <div>
                <button class="btn btn-success btn-sm" type="button" data-toggle="collapse"
                    data-target="#collapsePaymentForeign" aria-expanded="false" aria-controls="collapsePaymentForeign">
                    Show All <i class="fas fa-chevron-down pt-1"></i>
                </button>
            </div>
        </div>
        <div class="collapse" id="collapsePaymentForeign">
            <div class="card-body">
                <div class="m-portlet  m-portlet--unair">
                    <ul class="nav nav-tabs  m-tabs-line m-tabs-line--primary" role="tablist">
                        @foreach ($phases as $phaseId => $phase)
                            <li class="nav-item m-tabs__item">
                                <a class="nav-link m-tabs__link {{ $phaseId == 1 ? 'active' : '' }} foreign-fee-and-payment-phase"
                                    data-toggle="tab" data-phase-id="{{ $phaseId }}"
                                    data-loaded="{{ $phaseId == 1 ? 1 : 0 }}"
                                    href="#foreignFeePayment-{{ $phaseId }}" role="tab">{{ $phase }}</a>
                            </li>
                        @endforeach
                    </ul>
                    <div class="tab-content">
                        @foreach ($phases as $phaseId => $phase)
                            <div class="tab-pane {{ $phaseId == 1 ? 'active' : '' }}"
                                id="foreignFeePayment-{{ $phaseId }}" role="tabpanel" style="min-height: 250px">
                                <div class="row" id="foreignFeePayment-{{ $phaseId }}-foreignFeeTypes"></div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--Phase wise fee and payment end (Foreign student)-->
@endsection

@push('scripts')
    <script src="//cdnjs.cloudflare.com/ajax/libs/handlebars.js/4.1.0/handlebars.min.js"></script>
    <script src="https://code.highcharts.com/highcharts.js"></script>
    <script src="{{ asset('assets/global/plugins/datatables/datatables.bundle.js') }}" type="text/javascript"></script>
    <script src="{{ asset('assets/global/scripts/charts.js') }}"></script>

    <!-- Fees and payments info start (BD student)-->
    <script id="phase-fee-payment-bd" type="text/x-handlebars-template">
        @{{#each feeTypes}}
        <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4 col-xl-4 mb-4">
            <div id='fee-and-payment-phase@{{ phaseId }}-feePayment@{{ id }}' style="height: 250px"></div>
        </div>
        @{{/each}}
    </script>
    <!-- Fees and payments info end (BD student)-->

    <!-- Fees and payments info start (Foreign student)-->
    <script id="phase-fee-payment-foreign" type="text/x-handlebars-template">
        @{{#each foreignFeeTypes}}
        <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4 col-xl-4 mb-4">
            <div id='foreign-fee-and-payment-phase@{{ phaseId }}-feePayment@{{ id }}' style="height: 250px"></div>
        </div>
        @{{/each}}
    </script>
    <!-- Fees and payments info end (Foreign student)-->



    <script>
        var courseId = '{{ $courseId }}';
        var sessionId = '{{ isset(app()->request->session_id) ? app()->request->session_id : 2 }}'

        function loadPhaseFees(session_id, courseId, phase_id) {
            feePaymentId = 'feePayment-' + phase_id + '-feeTypes';


            mApp.block('#' + feePaymentId, {
                overlayColor: "#000000",
                type: "loader",
                state: "primary",
                message: "Please wait..."
            });

            //get fee and payment by ids
            $.get('{{ route('fees.payments.course.phase') }}', {
                session_id: sessionId,
                course_id: courseId,
                phase_id: phase_id
            }, function(response) {
                feePaymentTemplate = $('#phase-fee-payment-bd').html();
                feePaymentTemplateData = Handlebars.compile(feePaymentTemplate);
                $("#" + feePaymentId).html(feePaymentTemplateData(response));

                for (i in response.feeTypes) {
                    feePayment = response.feeTypes[i];
                    feePaymentId = 'fee-and-payment-phase' + feePayment.phaseId + '-feePayment' + feePayment.id;
                    //generate chart
                    var chartTitle = 'Fees and Payments';
                    if (feePayment.chardData[0].name == 'Fee not generated') {
                        chartTitle = 'No Fees and Payments, Free';
                    }
                    generateFeeAndPaymentPieChart(feePaymentId, feePayment.title, false, 'count', chartTitle,
                        feePayment.chardData);
                }
                mApp.unblock('#' + feePaymentId);
            });
        }
        //Foreign
        function loadPhaseFeesForForeign(session_id, courseId, phase_id) {
            foreignFeePaymentId = 'foreignFeePayment-' + phase_id + '-foreignFeeTypes';

            mApp.block('#' + foreignFeePaymentId, {
                overlayColor: "#000000",
                type: "loader",
                state: "primary",
                message: "Please wait..."
            });

            //get fee and payment by ids
            $.get('{{ route('foreign.fees.payments.course.phase') }}', {
                session_id: sessionId,
                course_id: courseId,
                phase_id: phase_id
            }, function(response) {
                ForeignFeePaymentTemplate = $('#phase-fee-payment-foreign').html();
                ForeignFeePaymentTemplateData = Handlebars.compile(ForeignFeePaymentTemplate);
                $("#" + foreignFeePaymentId).html(ForeignFeePaymentTemplateData(response));

                for (i in response.foreignFeeTypes) {
                    foreignFeePayment = response.foreignFeeTypes[i];
                    foreignFeePaymentId = 'foreign-fee-and-payment-phase' + foreignFeePayment.phaseId +
                        '-feePayment' + foreignFeePayment.id;
                    //generate chart
                    var chartTitle = 'Foreign Fees and Payment';
                    if (foreignFeePayment.chardData[0].name == 'Fee not generated') {
                        chartTitle = 'No Fees and Payments, Free';
                    }
                    generateFeeAndPaymentPieChart(foreignFeePaymentId, foreignFeePayment.title, false, 'count',
                        chartTitle, foreignFeePayment.chardData);
                }
                mApp.unblock('#' + foreignFeePaymentId);
            });
        }

        //list of modules load in dashboard
        function loadDashboardModules() {
            loadPhaseFees(sessionId, courseId, 1);
            loadPhaseFeesForForeign(sessionId, courseId, 1);
        }

        loadDashboardModules();
        //BD
        $('.fee-and-payment-phase').click(function(e) {
            var selected = $(this);
            var phaseId = $(this).data('phase-id');

            if ($(this).attr('data-loaded') == 0) {
                loadPhaseFees(sessionId, courseId, phaseId);
                selected.attr('data-loaded', 1);
            }
        })

        //Foreign
        $('.foreign-fee-and-payment-phase').click(function(e) {
            var selected = $(this);
            var phaseId = $(this).data('phase-id');

            if ($(this).attr('data-loaded') == 0) {
                loadPhaseFeesForForeign(sessionId, courseId, phaseId);
                selected.attr('data-loaded', 1);
            }
        })
    </script>
@endpush
