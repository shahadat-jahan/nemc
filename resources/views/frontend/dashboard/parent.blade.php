@extends('frontend.layouts.default')
@section('pageTitle', 'Dashboard')
@push('style')
    <link href="{{ asset('assets/global/plugins/datatables/datatables.bundle.css') }}" rel="stylesheet" type="text/css" />
    <style>
        .m-widget24 .m-widget24__item .m-widget24__stats {
            float: right;
            font-size: 1.3rem !important;
        }

        .badge-danger {
            color: #eb7d8f !important;
            background-color: #ffffff !important;
        }

        .badge-success {
            color: #34bfa3 !important;
            background-color: #ffffff !important;
        }
    </style>
@endpush
@section('content')
    <div class="m-portlet">
        <div class="m-portlet__head">
            <div class="m-portlet__head-caption">
                <div class="m-portlet__head-title">
                    <h3 class="m-portlet__head-text">
                        Parent Dashboard : Welcome, {{ Auth::guard('student_parent')->user()->parent->father_name }} !
                    </h3>
                </div>
            </div>
        </div>
        <div class="m-portlet__body">

            @if (!empty($students))
                <ul class="nav nav-tabs  m-tabs-line m-tabs-line--primary" role="tablist">
                    @foreach ($students as $student)
                        <li class="nav-item m-tabs__item">
                            <a class="nav-link m-tabs__link {{ $loop->first ? 'active' : '' }} load-student-data"
                                data-toggle="tab" data-student-id="{{ $student->id }}"
                                data-loaded="{{ $loop->first ? 1 : 0 }}" href="#student-{{ $student->id }}"
                                role="tab">{{ $student->full_name_en }}</a>
                        </li>
                    @endforeach
                </ul>
                <div class="tab-content">
                    @foreach ($students as $student)
                        <div class="tab-pane {{ $loop->first ? 'active' : '' }}" id="student-{{ $student->id }}"
                            role="tabpanel">
                            <!--begin:: Widgets/Stats-->
                            <!--card block start-->
                            <div class="m-portlet  m-portlet--unair">
                                <div class="m-portlet__body  m-portlet__body--no-padding p-0" style="padding: 0!important;">
                                    <div class="row m-row--no-padding m-row--col-separator-xl"
                                        style="margin-left: -15px; margin-right: 15px;"
                                        id="student{{ $student->id }}-card-blocks"></div>
                                </div>
                            </div>
                            <!--card block end-->
                            <!--attendance by phase start-->
                            <h5 class="text-center mb-4"><span class="border-bottom"> Subject Wise Attendance</span></h5>
                            <div class="row" id="attendance-summary-{{ $student->id }}-subjects"></div>
                            <!--attendance by phase end-->

                            <!--Today's class routine start-->
                            <div class="m-separator m-separator--dashed"></div>
                            <h5 class="text-center mb-4"><span class="border-bottom"> Today's Class Routine</span></h5>
                            <div class="m-portlet__body" style="padding: 5px !important;">
                                <div class="table-responsive">
                                    <table class="table table-bordered"
                                        id="student-class-routine-today-{{ $student->id }}">
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
                                        <tbody>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <!--Today's class routine end-->

                            <!-- latest 5 notice start-->
                            <div class="m-separator m-separator--dashed"></div>
                            <h5 class="text-center mb-4"><span class="border-bottom">Latest Notices</span></h5>
                            <div class="m-portlet__body" style="padding: 5px !important;">
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
                                                        <td>{{ !empty($notice->published_date) ? $notice->published_date : '--' }}
                                                        </td>
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
                            <!-- latest 5 notice end-->

                            <!-- next 1 week holidays start-->
                            <div class="m-separator m-separator--dashed"></div>
                            <h5 class="text-center mb-4"><span class="border-bottom">Next One week holidays</span></h5>
                            <div class="m-portlet__body" style="padding: 5px !important;">
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
                                                        <td>{{ !empty($holiday->session) ? $holiday->session->title : 'All' }}
                                                        </td>
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
                            <!-- next 1 week holidays end-->

                            <!--Upcoming Exam start-->
                            <div class="m-separator m-separator--dashed"></div>
                            <h5 class="text-center mb-4"><span class="border-bottom"> Upcoming Exam (Next 1 Month)</span>
                            </h5>
                            <div class="m-portlet__body" style="padding: 5px !important;">
                                <div class="table-responsive">
                                    <table class="table table-bordered table-hover"
                                        id="student-{{ $student->id }}-next-month-exams">
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
                            <!--Upcoming Exam end-->

                            <!--Card Exam by Phase start-->
                            <div class="m-separator m-separator--dashed"></div>
                            <h5 class="text-center mb-4"><span class="border-bottom">Card Item Exam</span></h5>
                            <div class="m-portlet__body" style="padding: 5px !important;">
                                <div class="row" id="student-card-items-{{ $student->id }}-subjects">

                                </div>
                            </div>
                            <!--Card Exam by Phase end-->

                            <!--end:: Widgets/Stats-->
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>


@endsection

@push('scripts')
    <script src="//cdnjs.cloudflare.com/ajax/libs/handlebars.js/4.1.0/handlebars.min.js"></script>
    <script src="https://code.highcharts.com/highcharts.js"></script>
    <script src="{{ asset('assets/global/plugins/datatables/datatables.bundle.js') }}" type="text/javascript"></script>
    <script src="{{ asset('assets/global/scripts/charts.js') }}"></script>

    <script id="students-card-blocks" type="text/x-handlebars-template">
        @{{#each cardBlocks}}
        <div class="col-md-12 col-lg-6 col-xl-3">
            <div class="m-widget24">
                <div class="m-widget24__item">
                    <h4 class="m-widget24__title">@{{ title }}</h4><br>
                    <span class="m-widget24__desc">@{{ course }}</span>
                    <span class="m-widget24__stats m--font-brand">@{{ value }}</span>
                    <div class="m--space-10"></div>
                    <div class="progress m-progress--sm mb-25">
                        <div class='progress-bar @{{ className }}' role="progressbar" style="width: 100%;" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                </div>
            </div>
        </div>
        @{{/each}}
    </script>

    <script id="student-attendance-summary" type="text/x-handlebars-template">
        @{{#each allClasses}}
        <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4 col-xl-4">
            <div class="mb-2" id='student@{{ studentId }}-subject@{{id}}' style="height: 250px"></div>
        </div>

        @{{/each}}
    </script>

    <script id="student-card-items" type="text/x-handlebars-template">
        @{{#each subjects}}
        <div class="col-md-12">
            <div class="card my-2">
                <div class="card-header d-flex justify-content-between">
                    <div class="pt-2">Subject : @{{ title }}</div>
                    <div>
                        <button class="btn btn-success btn-sm" type="button" data-toggle="collapse" data-target="#collapseSubjectCardExamSubject@{{ id }}" aria-expanded="false" aria-controls="collapseSubjectCardExamSubject@{{ id }}">
                            Show All <i class="fas fa-chevron-down pt-1"></i>
                        </button>
                    </div>
                </div>
                <div class="collapse" id="collapseSubjectCardExamSubject@{{ id }}">
                <div class="card-body">
                    <div class="row">
                        @{{#each cardItems}}
                        <div class="col-md-6">
                            <div class="card my-2" id='student-@{{ studentId }}-subject-@{{ subjectId }}-card-@{{ id }}'>
                                <div class="card-header">Card : @{{ title }}</div>
                                <ul class="list-group">
                                    @{{#each items}}
                                    <li class="list-group-item d-flex justify-content-between align-items-center">
                                        @{{ title }}
                                        @{{#if passStatus}}
                                        <span class="badge badge-success badge-pill" title="Clear"><i class="fas fa-check"></i></span>
                                        @{{else}}
                                        <span class="badge badge-danger badge-pill" title="Not Clear"><i class="fas fa-times"></i></span>
                                        @{{/if}}
                                    </li>
                                    @{{/each}}
                                </ul>
                            </div>
                        </div>
                        @{{/each}}
                    </div>
                </div>
                </div>
            </div>
        </div>
        @{{/each}}
    </script>

    <script>
        var studentId = '{{ optional($students->first())->id }}';

        function loadStudentCardBlocks(studentId) {
            divid = 'student' + studentId + '-card-blocks';

            mApp.block('#' + divid, {
                overlayColor: "#000000",
                type: "loader",
                state: "primary",
                message: "Please wait..."
            });

            $.get(baseUrl + 'nemc/dashboard/student-card-blocks', {
                studentId: studentId
            }, function(response) {

                cardBlocksTemplate = $('#students-card-blocks').html();
                cardBlocksTemplateData = Handlebars.compile(cardBlocksTemplate);
                $("#" + divid).html(cardBlocksTemplateData(response));

                mApp.unblock('#' + divid);
            });
        }

        //subject wise attendance summary
        function loadSubjectAttendanceSummary(studentId) {
            attendanceDivId = 'attendance-summary-' + studentId + '-subjects';

            mApp.block('#' + attendanceDivId, {
                overlayColor: "#000000",
                type: "loader",
                state: "primary",
                message: "Please wait..."
            });

            $.get(baseUrl + 'nemc/dashboard/student-attendance-summary', {
                studentId: studentId
            }, function(response) {

                attemdanceSummaryTemplate = $('#student-attendance-summary').html();
                attemdanceSummaryTemplateData = Handlebars.compile(attemdanceSummaryTemplate);
                $("#" + attendanceDivId).html(attemdanceSummaryTemplateData(response));

                for (i in response.allClasses) {
                    //subjectRow = response.singleClass[i];
                    //subjectRowId = 'student'+ studentId +'-subject'+subjectRow.id;

                    singleClass = response.allClasses[i];
                    totalClass = singleClass.chardData[0].count + singleClass.chardData[1].count;
                    subjectTitle = singleClass.subject.title;
                    classTypeTitle = singleClass.class_type.title;
                    subjectRowId = 'student' + singleClass.studentId + '-subject' + singleClass.id;
                    generateStudentPieChart(subjectRowId, subjectTitle, classTypeTitle, totalClass, false, 'count',
                        'Attendance', singleClass.chardData);
                    //generateStudentPieChart(subjectRowId, subjectRow.title, false, 'count', 'Attendance',subjectRow.chardData);
                }
                mApp.unblock('#' + attendanceDivId);
            });
        }

        //today's class routine for student
        function loadTodayClassRoutine(studentId) {
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

            classRoutineId = 'student-class-routine-today-' + studentId;

            generateDatatable(classRoutineId, classRoutineTableColumns,
                baseUrl + 'nemc/dashboard/get-today-class-routine?student_id=' + studentId);
        }
        //student subject wise card item
        function loadStudentCardItems(studentId) {
            cardItemId = 'student-card-items-' + studentId + '-subjects';

            mApp.block('#' + cardItemId, {
                overlayColor: "#000000",
                type: "loader",
                state: "primary",
                message: "Please wait..."
            });

            $.get(baseUrl + 'nemc/dashboard/student-card-items', {
                studentId: studentId
            }, function(response) {

                cardItemsTemplate = $('#student-card-items').html();
                cardItemsTemplateData = Handlebars.compile(cardItemsTemplate);
                $("#" + cardItemId).html(cardItemsTemplateData(response));
                mApp.unblock('#' + cardItemId);
            });
        }
        //load next one month exam
        function loadStudentUpcomingExams(studentId) {
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
            examRoutineId = 'student-' + studentId + '-next-month-exams';
            generateDatatable(examRoutineId, examTableColumns,
                baseUrl + 'nemc/dashboard/student-upcoming-exams?student_id=' + studentId);
        }



        function loadDashboardModules() {
            loadStudentCardBlocks(studentId);
            loadSubjectAttendanceSummary(studentId);
            loadTodayClassRoutine(studentId);
            loadStudentCardItems(studentId);
            loadStudentUpcomingExams(studentId)
        }

        loadDashboardModules();




        $('.load-student-data').click(function(e) {
            var selected = $(this);
            var studentId = $(this).data('student-id');

            if ($(this).attr('data-loaded') == 0) {
                //load card blocks
                loadStudentCardBlocks(studentId);
                // load attendance summary
                loadSubjectAttendanceSummary(studentId);
                //load today's class routine
                loadTodayClassRoutine(studentId);
                //load studend card item
                loadStudentCardItems(studentId)
                loadStudentUpcomingExams(studentId)

                selected.attr('data-loaded', 1);
            }

        })
    </script>
@endpush
