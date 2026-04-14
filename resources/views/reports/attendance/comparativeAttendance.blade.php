@php use App\Models\Subject; @endphp
@extends('layouts.default')
@section('pageTitle', 'Comparative Attendance Report')

@push('style')
    <style>
        /* Highlight row */
        .yellow-row {
            background-color: #fdeebc;
        }

        /* Table cell styling */
        .table td {
            height: 40px;
            padding: 0.6rem !important;
            vertical-align: top;
            border-top: 1px solid #f4f5f8;
        }

        .table td.align-middle,
        .table th.align-middle {
            vertical-align: middle !important;
        }

        table.floatThead-table {
            border-top: none;
            border-bottom: none;
            background: #fff;
        }

        /* Notify button */
        #selectedNotifyBtn {
            z-index: 1000;
            width: auto;
            height: auto;
            padding: 10px 20px;
            border-radius: 25px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2);
        }

        /* Checkbox styling */
        .individual-notify-checkbox {
            display: inline-block;
            margin-right: 10px;
        }

        .m-checkbox {
            min-height: 18px;
            padding-left: 18px;
            margin: 0 0 0 0;
        }

        .m-checkbox > span {
            width: 16px;
            height: 16px;
            top: 50%;
            transform: translateY(-50%);
            background: transparent;
            border: 1px solid #303030;
        }

        .m-checkbox > span:after {
            width: 5px;
            height: 8px;
            left: 7px;
            top: 8px;
            border-color: #716aca !important;
        }

        .m-checkbox.m-checkbox--solid > span,
        .m-checkbox.m-checkbox--brand > span,
        .m-checkbox > input:checked ~ span,
        .m-checkbox.m-checkbox--solid > input:checked ~ span,
        .m-checkbox.m-checkbox--brand > input:checked ~ span {
            background: #d8d8d8 !important;
        }

        .m-checkbox:hover > span {
            border-color: #716aca;
        }

        /* Select all checkbox in th */
        th .m-checkbox {
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
        }

        /* Selected count */
        .selected-count {
            font-weight: bold;
            margin-left: 3px;
        }
    </style>
@endpush
@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="m-portlet">
                <div class="m-portlet__head">
                    <div class="m-portlet__head-caption">
                        <div class="m-portlet__head-title">
                            <h3 class="m-portlet__head-text"><i class="fas fa-list-ul fa-md pr-2"></i>{{ $pageTitle }}
                            </h3>
                        </div>
                    </div>
                </div>
                <div class="m-portlet__body">
                    <div class="m-section__content">
                        <form id="nemc-general-form" role="form" method="get"
                              action="{{ url('admin/report_comparative_attendance') }}">
                            <div class="row">
                                <div class="col-xs-12 col-sm-6 col-md-4 col-lg-4 col-xl-4">
                                    <div class="form-group">
                                        <select class="form-control" name="session_id" id="session_id">
                                            <option value="">---- Select Session ----</option>
                                            {!! select($sessions, app('request')->input('session_id')) !!}
                                        </select>
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-6 col-md-4 col-lg-4 col-xl-4">
                                    <div class="form-group">
                                        <select class="form-control" name="course_id" id="course_id">
                                            <option value="">---- Select Course ----</option>
                                            {!! select($courses, Auth::user()->teacher->course_id ?? app('request')->input('course_id')) !!}
                                        </select>
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-6 col-md-4 col-lg-4 col-xl-4">
                                    <div class="form-group">
                                        <select class="form-control" name="phase_id" id="phase_id">
                                            <option value="">---- Select Phase ----</option>
                                            {!! select($phases, app('request')->input('phase_id')) !!}
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-xs-12 col-sm-6 col-md-4 col-lg-4 col-xl-4">
                                    <select class="form-control m-bootstrap-select m_selectpicker"
                                            name="subject_group_id"
                                            id="subject_group_id" data-live-search="true">
                                        <option value="">---- Select Subject Group ----</option>
                                    </select>
                                </div>
                                <div class="col-xs-12 col-sm-6 col-md-4 col-lg-4 col-xl-4">
                                    <select class="form-control m-bootstrap-select m_selectpicker" name="subject_id"
                                            id="subject_id" data-live-search="true">
                                        <option value="">---- Select Subject ----</option>
                                    </select>
                                </div>
                                <div class="col-xs-12 col-sm-6 col-md-4 col-lg-4 col-xl-4">
                                    <div class="form-group">
                                        <select class="form-control" name="student_category_id"
                                                id="student_category_id">
                                            <option value="">---- Select Student Category ----</option>
                                            @foreach ($studentCategories ?? [] as $id => $title)
                                                <option value="{{ $id }}"
                                                        {{ request('student_category_id') == $id ? 'selected' : '' }}>
                                                    {{ $title }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-xs-12 col-sm-6 col-md-4 col-lg-4 col-xl-4">
                                    <input type="text" class="form-control m-input m_datepicker" name="start_date"
                                           value="{!! app('request')->input('start_date') !!}" id="start_date"
                                           placeholder="Start Date"
                                           autocomplete="off" readonly>
                                </div>
                                <div class="col-xs-12 col-sm-6 col-md-4 col-lg-4 col-xl-4">
                                    <input type="text" class="form-control m-input m_datepicker" name="end_date"
                                           value="{!! app('request')->input('end_date') !!}" id="end_date"
                                           placeholder="End Date"
                                           autocomplete="off" readonly>
                                </div>
                                <div class="col-xs-12 col-sm-6 col-md-4 col-lg-4 col-xl-4">
                                    <div class="form-group">
                                        <select class="form-control" name="percentage_filter" id="percentage_filter">
                                            <option value="75"
                                                    {{ request('percentage_filter') == '75' ? 'selected' : '' }}>Below
                                                75%
                                            </option>
                                            <option value="60"
                                                    {{ request('percentage_filter') == '60' ? 'selected' : '' }}>Below
                                                60%
                                            </option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-xs-12 col-sm-6 col-md-4 col-lg-4 col-xl-4">
                                    <div class="form-group">
                                        <select class="form-control" name="percentage_type" id="percentage_type">
                                            <option value="average"
                                                    {{ request('percentage_type') == 'average' || !request()->has('percentage_type') ? 'selected' : '' }}>
                                                By Average %
                                            </option>
                                            <option value="lecture"
                                                    {{ request('percentage_type') == 'lecture' ? 'selected' : '' }}>By
                                                Lecture %
                                            </option>
                                            <option value="tutorial"
                                                    {{ request('percentage_type') == 'tutorial' ? 'selected' : '' }}>By
                                                Tutorial
                                                & Other %
                                            </option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row my-3">
                                <div class="col-xs-12 col-sm-6 col-md-12 col-lg-12 col-xl-12">
                                    <div class="pull-right search-action-btn">
                                        @if (!empty($reportData['students']))
                                            <div class="btn-group" data-hover="dropdown">
                                                <button type="button"
                                                        class="btn btn-primary m-btn m-btn--icon pdf-dropdown-btn"
                                                        data-toggle="dropdown" data-trigger="hover" aria-haspopup="true"
                                                        aria-expanded="false">
                                                    <i class="fa fa-file-pdf"></i> PDF Download <i
                                                            class="pt-1 fa fa-angle-down angle-icon"></i>
                                                </button>
                                                <div class="dropdown-menu dropdown-menu-right w-100">
                                                    <a class="dropdown-item"
                                                       href="{{ route('report.comparative_attendance.pdf', array_merge(request()->all(), ['page_layout' => 'A4-landscape'])) }}"
                                                       target="_blank">
                                                        <i class="fas fa-arrows-alt-h"></i> Landscape
                                                    </a>
                                                    <a class="dropdown-item"
                                                       href="{{ route('report.comparative_attendance.pdf', array_merge(request()->all(), ['page_layout' => 'A4-portrait'])) }}"
                                                       target="_blank">
                                                        <i class="fas fa-arrows-alt-v"></i> Portrait
                                                    </a>
                                                </div>
                                            </div>
                                            <a href="{{ route('report.comparative_attendance.excel', request()->all()) }}"
                                               class="btn btn-primary m-btn m-btn--icon"><i
                                                        class="fa fa-file-export"></i> Export</a>
                                        @endif
                                        <button class="btn btn-primary m-btn m-btn--icon search-result">
                                            <i class="fa fa-search"></i> Search
                                        </button>
                                        <a class="btn btn-default m-btn m-btn--icon"
                                           href="{{ url('admin/report_comparative_attendance') }}">
                                            <i class="fas fa-sync-alt search-reset"></i> Reset
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </form>

                        @if (!empty($reportData['students']))
                            @php
                                $totalStudents = count($reportData['students']);
                                $studentsBelow = 0;
                                $percentage = $percentage_filter ?? 75;
                                $percentageType = $percentage_type ?? 'average';
                                $subject = Subject::find(request('subject_id'));
                                $subjectName = $subject ? $subject->title : '';

                                foreach ($reportData['students'] as $student) {
                                    $percentage_to_check = 0;
                                    if ($percentageType == 'lecture') {
                                        $percentage_to_check = $student['total']['lecture_percentage'] ?? 0;
                                    } elseif ($percentageType == 'tutorial') {
                                        $percentage_to_check = $student['total']['tutorial_percentage'] ?? 0;
                                    } else {
                                        $percentage_to_check = $student['total']['average_percentage'] ?? 0;
                                    }

                                    if ($percentage_to_check < $percentage) {
                                        $studentsBelow++;
                                    }
                                }
                            @endphp
                            <div class="row mb-3">
                                <div class="col-md-12">
                                    <div class="alert alert-info">
                                        <strong>Note:</strong> There are {{ $studentsBelow }} students have below
                                        {{ $percentage }}% attendance
                                        {{ $percentageType == 'average' ? 'on average' : 'in ' . ucfirst($percentageType) }}
                                        in {{ ucfirst($subjectName) }} subject out of total {{ $totalStudents }}
                                        students.
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="m-table table-responsive">
                                        <table class="table table-bordered sticky-header">
                                            <thead>
                                            <tr>
                                                <th rowspan="3" class="text-center align-middle">
                                                    <div class="d-flex flex-column align-items-center">
                                                        <div class="d-flex justify-content-left mr-3 mb-2">
                                                            <label
                                                                    class="m-checkbox m-checkbox--solid m-checkbox--brand mb-0"
                                                                    style="display: flex; align-items: center; justify-content: center;">
                                                                <input type="checkbox" id="selectAllStudents">
                                                                <span></span>
                                                            </label>
                                                        </div>
                                                        Roll No
                                                    </div>
                                                </th>
                                                <th rowspan="3" class="text-center align-middle">Student Name</th>
                                                @foreach ($reportData['periods'] as $periodKey => $periodName)
                                                    <th colspan="6" class="text-center">{{ $periodName }}</th>
                                                @endforeach
                                                <th colspan="7" class="text-center">Total</th>
                                            </tr>
                                            <tr>
                                                @foreach ($reportData['periods'] as $period)
                                                    <th colspan="3" class="text-center">Lecture</th>
                                                    <th colspan="3" class="text-center">Tutorial & Other</th>
                                                @endforeach
                                                <th colspan="3" class="text-center">Lecture</th>
                                                <th colspan="3" class="text-center">Tutorial & Other</th>
                                                <th rowspan="2" class="text-center align-middle">Avg(%)</th>
                                            </tr>
                                            <tr>
                                                @foreach ($reportData['periods'] as $period)
                                                    <th class="text-center">Held</th>
                                                    <th class="text-center">Attd</th>
                                                    <th class="text-center">Per(%)</th>
                                                    <th class="text-center">Held</th>
                                                    <th class="text-center">Attd</th>
                                                    <th class="text-center">Per(%)</th>
                                                @endforeach
                                                <th class="text-center">Held</th>
                                                <th class="text-center">Attd</th>
                                                <th class="text-center">Per(%)</th>
                                                <th class="text-center">Held</th>
                                                <th class="text-center">Attd</th>
                                                <th class="text-center">Per(%)</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            @foreach ($reportData['students'] as $student)
                                                @php
                                                    $percentage = $percentage_filter ?? 0;
                                                    $percentage_to_check = 0;

                                                    if (($percentage_type ?? 'average') == 'lecture') {
                                                        $percentage_to_check =
                                                            $student['total']['lecture_percentage'] ?? 0;
                                                    } elseif (($percentage_type ?? 'average') == 'tutorial') {
                                                        $percentage_to_check =
                                                            $student['total']['tutorial_percentage'] ?? 0;
                                                    } else {
                                                        // 'average' or default
                                                        $percentage_to_check =
                                                            $student['total']['average_percentage'] ?? 0;
                                                    }

                                                    $shouldHighlight =
                                                        $percentage > 0 && $percentage_to_check < $percentage;
                                                @endphp
                                                <tr class="{{ $shouldHighlight ? 'yellow-row' : '' }}">
                                                    <td class="text-center align-middle">
                                                        <div class="d-flex align-items-center justify-content-center">
                                                            @if ($shouldHighlight)
                                                                <div class="individual-notify-checkbox mr-2">
                                                                    <label
                                                                            class="m-checkbox m-checkbox--solid m-checkbox--brand mb-0">
                                                                        <input type="checkbox"
                                                                               class="student-checkbox"
                                                                               data-student-id="{{ $student['id'] }}"
                                                                               data-student-name="{{ $student['student_name'] }}"
                                                                               data-roll-no="{{ $student['roll_no'] }}"
                                                                               data-percentage="{{ $percentage_to_check }}">
                                                                        <span></span>
                                                                    </label>
                                                                </div>
                                                            @endif
                                                            {{ $student['roll_no'] }}
                                                        </div>
                                                    </td>
                                                    <td>{{ $student['student_name'] }}</td>
                                                    @foreach ($reportData['periods'] as $periodKey => $periodName)
                                                        @php $monthData = $student['monthly_data'][$periodKey] ?? null; @endphp
                                                        <td class="text-center">{{ $monthData['lecture_held'] ?? 0 }}
                                                        </td>
                                                        <td class="text-center">
                                                            {{ $monthData['lecture_attended'] ?? 0 }}</td>
                                                        <td class="text-center">
                                                            {{ $monthData['lecture_percentage'] ?? 0 }}%
                                                        </td>
                                                        <td class="text-center">{{ $monthData['tutorial_held'] ?? 0 }}
                                                        </td>
                                                        <td class="text-center">
                                                            {{ $monthData['tutorial_attended'] ?? 0 }}</td>
                                                        <td class="text-center">
                                                            {{ $monthData['tutorial_percentage'] ?? 0 }}%
                                                        </td>
                                                    @endforeach
                                                    <!-- Total columns -->
                                                    <td class="text-center">{{ $student['total']['lecture_held'] }}
                                                    </td>
                                                    <td class="text-center">
                                                        {{ $student['total']['lecture_attended'] }}</td>
                                                    <td class="text-center">
                                                        {{ $student['total']['lecture_percentage'] }}%
                                                    </td>
                                                    <td class="text-center">{{ $student['total']['tutorial_held'] }}
                                                    </td>
                                                    <td class="text-center">
                                                        {{ $student['total']['tutorial_attended'] }}</td>
                                                    <td class="text-center">
                                                        {{ $student['total']['tutorial_percentage'] }}%
                                                    </td>
                                                    <td class="text-center">
                                                        {{ $student['total']['average_percentage'] }}%
                                                    </td>
                                                </tr>
                                            @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        @elseif(isset($reportData['students']) && empty($reportData['students']))
                            <span class="d-flex alert alert-danger justify-content-center align-items-center">
                                <i class="fas fa-exclamation-triangle mr-2"></i>
                                <strong>Note:</strong>&nbsp;No data found for the selected criteria.
                            </span>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
    <button id="selectedNotifyBtn" style="position: fixed; bottom: 20px; right: 20px; display: none;"
            class="btn btn-warning btn-circle btn-lg">
        <i class="fa fa-bell"></i> Notify selected student's parents(<span class="selected-count">0</span>)
    </button>
@endsection
@push('scripts')
    <script src="//cdnjs.cloudflare.com/ajax/libs/lodash.js/4.17.11/lodash.min.js" type="text/javascript"></script>
    <script>
        !function (a) {
            function b(a, b, c) {
                if (8 == g) {
                    var d = j.width(),
                        e = f.debounce(function () {
                            var a = j.width();
                            d != a && (d = a, c())
                        }, a);
                    j.on(b, e)
                } else j.on(b, f.debounce(c, a))
            }

            function c(a) {
                window.console && window.console && window.console.log && window.console.log(a)
            }

            function d() {
                var b = a(
                    '<div style="width:50px;height:50px;overflow-y:scroll;position:absolute;top:-200px;left:-200px;"><div style="height:100px;width:100%"></div>'
                );
                a("body").append(b);
                var c = b.innerWidth(),
                    d = a("div", b).innerWidth();
                return b.remove(), c - d
            }

            function e(a) {
                if (a.dataTableSettings)
                    for (var b = 0; b < a.dataTableSettings.length; b++) {
                        var c = a.dataTableSettings[b].nTable;
                        if (a[0] == c) return !0
                    }
                return !1
            }

            a.floatThead = a.floatThead || {}, a.floatThead.defaults = {
                cellTag: null,
                headerCellSelector: "tr:first>th:visible",
                zIndex: 98,
                debounceResizeMs: 10,
                useAbsolutePositioning: !0,
                scrollingTop: 0,
                scrollingBottom: 0,
                scrollContainer: function () {
                    return a([])
                },
                getSizingRow: function (a) {
                    return a.find("tbody tr:visible:first>*")
                },
                floatTableClass: "floatThead-table",
                floatWrapperClass: "floatThead-wrapper",
                floatContainerClass: "floatThead-container",
                copyTableClass: !0,
                debug: !1
            };
            var f = window._,
                g = function () {
                    for (var a = 3, b = document.createElement("b"), c = b.all || []; a = 1 + a, b.innerHTML =
                        "<!--[if gt IE " + a + "]><i><![endif]-->", c[0];) ;
                    return a > 4 ? a : document.documentMode
                }(),
                h = null,
                i = function () {
                    if (g) return !1;
                    var b = a("<table><colgroup><col></colgroup><tbody><tr><td style='width:10px'></td></tbody></table>");
                    a("body").append(b);
                    var c = b.find("col").width();
                    return b.remove(), 0 == c
                },
                j = a(window),
                k = 0;
            a.fn.floatThead = function (l) {
                if (l = l || {}, !f && (f = window._ || a.floatThead._, !f)) throw new Error(
                    "jquery.floatThead-slim.js requires underscore. You should use the non-lite version since you do not have underscore."
                );
                if (8 > g) return this;
                if (null == h && (h = i(), h && (document.createElement("fthtr"), document.createElement("fthtd"),
                    document.createElement("fthfoot"))), f.isString(l)) {
                    var m = l,
                        n = this;
                    return this.filter("table").each(function () {
                        var b = a(this).data("floatThead-attached");
                        if (b && f.isFunction(b[m])) {
                            var c = b[m]();
                            "undefined" != typeof c && (n = c)
                        }
                    }), n
                }
                var o = a.extend({}, a.floatThead.defaults || {}, l);
                return a.each(l, function (b) {
                    b in a.floatThead.defaults || !o.debug || c("jQuery.floatThead: used [" + b +
                        "] key to init plugin, but that param is not an option for the plugin. Valid options are: " +
                        f.keys(a.floatThead.defaults).join(", "))
                }), this.filter(":not(." + o.floatTableClass + ")").each(function () {
                    function c(a) {
                        return a + ".fth-" + y + ".floatTHead"
                    }

                    function i() {
                        var b = 0;
                        A.find("tr:visible").each(function () {
                            b += a(this).outerHeight(!0)
                        }), Z.outerHeight(b), $.outerHeight(b)
                    }

                    function l() {
                        var a = z.outerWidth(),
                            b = I.width() || a;
                        if (X.width(b - F.vertical), O) {
                            var c = 100 * a / (b - F.vertical);
                            S.css("width", c + "%")
                        } else S.outerWidth(a)
                    }

                    function m() {
                        C = (f.isFunction(o.scrollingTop) ? o.scrollingTop(z) : o.scrollingTop) || 0, D = (f
                            .isFunction(o.scrollingBottom) ? o.scrollingBottom(z) : o.scrollingBottom) || 0
                    }

                    function n() {
                        var b, c;
                        if (V) b = U.find("col").length;
                        else {
                            var d;
                            d = null == o.cellTag && o.headerCellSelector ? o.headerCellSelector : "tr:first>" +
                                o.cellTag, c = A.find(d), b = 0, c.each(function () {
                                b += parseInt(a(this).attr("colspan") || 1, 10)
                            })
                        }
                        if (b != H) {
                            H = b;
                            for (var e = [], f = [], g = [], i = 0; b > i; i++) e.push(
                                '<th class="floatThead-col"/>'), f.push("<col/>"), g.push(
                                "<fthtd style='display:table-cell;height:0;width:auto;'/>");
                            f = f.join(""), e = e.join(""), h && (g = g.join(""), W.html(g), bb = W.find(
                                "fthtd")), Z.html(e), $ = Z.find("th"), V || U.html(f), _ = U.find("col"), T
                                .html(f), ab = T.find("col")
                        }
                        return b
                    }

                    function p() {
                        if (!E) {
                            if (E = !0, J) {
                                var a = z.width(),
                                    b = Q.width();
                                a > b && z.css("minWidth", a)
                            }
                            z.css(db), S.css(db), S.append(A), B.before(Y), i()
                        }
                    }

                    function q() {
                        E && (E = !1, J && z.width(fb), Y.detach(), z.prepend(A), z.css(eb), S.css(eb))
                    }

                    function r(a) {
                        J != a && (J = a, X.css({
                            position: J ? "absolute" : "fixed"
                        }))
                    }

                    function s(a, b, c, d) {
                        return h ? c : d ? o.getSizingRow(a, b, c) : b
                    }

                    function t() {
                        var a, b = n();
                        return function () {
                            var c = s(z, _, bb, g);
                            if (c.length == b && b > 0) {
                                if (!V)
                                    for (a = 0; b > a; a++) _.eq(a).css("width", "");
                                q();
                                var d = [];
                                for (a = 0; b > a; a++) d[a] = c.get(a).offsetWidth;
                                for (a = 0; b > a; a++) ab.eq(a).width(d[a]), _.eq(a).width(d[a]);
                                p()
                            } else S.append(A), z.css(eb), S.css(eb), i()
                        }
                    }

                    function u(a) {
                        var b = I.css("border-" + a + "-width"),
                            c = 0;
                        return b && ~b.indexOf("px") && (c = parseInt(b, 10)), c
                    }

                    function v() {
                        var a, b = I.scrollTop(),
                            c = 0,
                            d = L ? K.outerHeight(!0) : 0,
                            e = M ? d : -d,
                            f = X.height(),
                            g = z.offset(),
                            i = 0;
                        if (O) {
                            var k = I.offset();
                            c = g.top - k.top + b, L && M && (c += d), c -= u("top"), i = u("left")
                        } else a = g.top - C - f + D + F.horizontal;
                        var l = j.scrollTop(),
                            m = j.scrollLeft(),
                            n = I.scrollLeft();
                        return b = I.scrollTop(),
                            function (k) {
                                if ("windowScroll" == k ? (l = j.scrollTop(), m = j.scrollLeft()) :
                                    "containerScroll" == k ? (b = I.scrollTop(), n = I.scrollLeft()) : "init" !=
                                        k && (l = j.scrollTop(), m = j.scrollLeft(), b = I.scrollTop(), n = I
                                            .scrollLeft()), !h || !(0 > l || 0 > m)) {
                                    if (R) r("windowScrollDone" == k ? !0 : !1);
                                    else if ("windowScrollDone" == k) return null;
                                    g = z.offset(), L && M && (g.top += d);
                                    var o, s, t = z.outerHeight();
                                    if (O && J) {
                                        if (c >= b) {
                                            var u = c - b;
                                            o = u > 0 ? u : 0
                                        } else o = P ? 0 : b;
                                        s = i
                                    } else !O && J ? (l > a + t + e ? o = t - f + e : g.top > l + C ? (o = 0,
                                        q()) : (o = C + l - g.top + c + (M ? d : 0), p()), s = 0) : O && !
                                        J ? (
                                        c > b || b - c > t ? (o = g.top - l, q()) : (o = g.top + b - l - c,
                                            p()), s = g.left + n - m) : O || J || (l > a + t + e ? o = t +
                                        C - l + a + e : g.top > l + C ? (o = g.top - l, p()) : o = C, s = g
                                        .left - m);
                                    return {
                                        top: o,
                                        left: s
                                    }
                                }
                            }
                    }

                    function w() {
                        var a = null,
                            b = null,
                            c = null;
                        return function (d, e, f) {
                            null == d || a == d.top && b == d.left || (X.css({
                                top: d.top,
                                left: d.left
                            }), a = d.top, b = d.left), e && l(), f && i();
                            var g = I.scrollLeft();
                            J && c == g || (X.scrollLeft(g), c = g)
                        }
                    }

                    function x() {
                        if (I.length) {
                            var a = I.width(),
                                b = I.height(),
                                c = z.height(),
                                d = z.width(),
                                e = d > a ? G : 0,
                                f = c > b ? G : 0;
                            F.horizontal = d > a - f ? G : 0, F.vertical = c > b - e ? G : 0
                        }
                    }

                    var y = k,
                        z = a(this);
                    if (z.data("floatThead-attached")) return !0;
                    if (!z.is("table")) throw new Error(
                        'jQuery.floatThead must be run on a table element. ex: $("table").floatThead();'
                    );
                    var A = z.find("thead:first"),
                        B = z.find("tbody:first");
                    if (0 == A.length) throw new Error(
                        "jQuery.floatThead must be run on a table that contains a <thead> element");
                    var C, D, E = !1,
                        F = {
                            vertical: 0,
                            horizontal: 0
                        },
                        G = d(),
                        H = 0,
                        I = o.scrollContainer(z) || a([]),
                        J = o.useAbsolutePositioning;
                    null == J && (J = o.scrollContainer(z).length);
                    var K = z.find("caption"),
                        L = 1 == K.length;
                    if (L) var M = "top" === (K.css("caption-side") || K.attr("align") || "top");
                    var N = a('<fthfoot style="display:table-footer-group;"/>'),
                        O = I.length > 0,
                        P = !1,
                        Q = a([]),
                        R = 9 >= g && !O && J,
                        S = a("<table/>"),
                        T = a("<colgroup/>"),
                        U = z.find("colgroup:first"),
                        V = !0;
                    0 == U.length && (U = a("<colgroup/>"), V = !1);
                    var W = a('<fthrow style="display:table-row;height:0;"/>'),
                        X = a('<div style="overflow: hidden;"></div>'),
                        Y = a("<thead/>"),
                        Z = a('<tr class="size-row"/>'),
                        $ = a([]),
                        _ = a([]),
                        ab = a([]),
                        bb = a([]);
                    if (Y.append(Z), z.prepend(U), h && (N.append(W), z.append(N)), S.append(T), X.append(S), o
                        .copyTableClass && S.attr("class", z.attr("class")), S.attr({
                        cellpadding: z.attr("cellpadding"),
                        cellspacing: z.attr("cellspacing"),
                        border: z.attr("border")
                    }), S.css({
                        borderCollapse: z.css("borderCollapse"),
                        border: z.css("border")
                    }), S.addClass(o.floatTableClass).css("margin", 0), J) {
                        var cb = function (a, b) {
                            var c = a.css("position"),
                                d = "relative" == c || "absolute" == c;
                            if (!d || b) {
                                var e = {
                                    paddingLeft: a.css("paddingLeft"),
                                    paddingRight: a.css("paddingRight")
                                };
                                X.css(e), a = a.wrap("<div class='" + o.floatWrapperClass +
                                    "' style='position: relative; clear:both;'></div>").parent(), P = !0
                            }
                            return a
                        };
                        O ? (Q = cb(I, !0), Q.append(X)) : (Q = cb(z), z.after(X))
                    } else z.after(X);
                    X.css({
                        position: J ? "absolute" : "fixed",
                        marginTop: 0,
                        top: J ? 0 : "auto",
                        zIndex: o.zIndex
                    }), X.addClass(o.floatContainerClass), m();
                    var db = {
                            "table-layout": "auto"
                        },
                        eb = {
                            "table-layout": z.css("tableLayout") || "auto"
                        },
                        fb = z[0].style.width || "";
                    x();
                    var gb, hb = function () {
                        (gb = t())()
                    };
                    hb();
                    var ib = v(),
                        jb = w();
                    jb(ib("init"), !0);
                    var kb = f.debounce(function () {
                            jb(ib("windowScrollDone"), !1)
                        }, 300),
                        lb = function () {
                            jb(ib("windowScroll"), !1), kb()
                        },
                        mb = function () {
                            jb(ib("containerScroll"), !1)
                        },
                        nb = function () {
                            m(), x(), hb(), ib = v(), (jb = w())(ib("resize"), !0, !0)
                        },
                        ob = f.debounce(function () {
                            x(), m(), hb(), ib = v(), jb(ib("reflow"), !0)
                        }, 1);
                    O ? J ? I.on(c("scroll"), mb) : (I.on(c("scroll"), mb), j.on(c("scroll"), lb)) : j.on(c(
                        "scroll"), lb), j.on(c("load"), ob), b(o.debounceResizeMs, c("resize"), nb), z.on(
                        "reflow", ob), e(z) && z.on("filter", ob).on("sort", ob).on("page", ob), z.data(
                        "floatThead-attached", {
                            destroy: function () {
                                var a = ".fth-" + y;
                                q(), z.css(eb), U.remove(), h && N.remove(), Y.parent().length && Y
                                    .replaceWith(A), z.off("reflow"), I.off(a), P && (I.length ? I
                                    .unwrap() : z.unwrap()), J && z.css("minWidth", ""), X.remove(),
                                    z.data("floatThead-attached", !1), j.off(a)
                            },
                            reflow: function () {
                                ob()
                            },
                            setHeaderHeight: function () {
                                i()
                            },
                            getFloatContainer: function () {
                                return X
                            },
                            getRowGroups: function () {
                                return E ? X.find("thead").add(z.find("tbody,tfoot")) : z.find(
                                    "thead,tbody,tfoot")
                            }
                        }), k++
                }), this
            }
        }(jQuery),
            function (a) {
                a.floatThead = a.floatThead || {}, a.floatThead._ = window._ || function () {
                    var b = {},
                        c = Object.prototype.hasOwnProperty,
                        d = ["Arguments", "Function", "String", "Number", "Date", "RegExp"];
                    return b.has = function (a, b) {
                        return c.call(a, b)
                    }, b.keys = function (a) {
                        if (a !== Object(a)) throw new TypeError("Invalid object");
                        var c = [];
                        for (var d in a) b.has(a, d) && c.push(d);
                        return c
                    }, a.each(d, function () {
                        var a = this;
                        b["is" + a] = function (b) {
                            return Object.prototype.toString.call(b) == "[object " + a + "]"
                        }
                    }), b.debounce = function (a, b, c) {
                        var d, e, f, g, h;
                        return function () {
                            f = this, e = arguments, g = new Date;
                            var i = function () {
                                    var j = new Date - g;
                                    b > j ? d = setTimeout(i, b - j) : (d = null, c || (h = a.apply(f, e)))
                                },
                                j = c && !d;
                            return d || (d = setTimeout(i, b)), j && (h = a.apply(f, e)), h
                        }
                    }, b
                }()
            }(jQuery);

        $(".sticky-header").floatThead({
            scrollingTop: 70
        });

        $(".m_datepicker").datepicker({
            todayHighlight: !0,
            orientation: "bottom left",
            format: 'dd/mm/yyyy',
            autoclose: true,
        });

        //search form dropdown validation
        $('.search-result').click(function () {
            var requiredFields = [
                'session_id',
                'course_id',
                'phase_id',
                'subject_group_id',
                'subject_id',
                'start_date',
                'end_date'
            ];

            var isValid = true;
            for (var i = 0; i < requiredFields.length; i++) {
                if ($('#' + requiredFields[i]).val() === '') {
                    isValid = false;
                    break;
                }
            }

            if (!isValid) {
                sweetAlert(
                    'All required fields (Session, Course, Phase, Subject, and Dates) must be filled to generate the report.',
                    'error');
                return false;
            }

            $('#nemc-general-form').submit();
            mApp.blockPage({
                overlayColor: "#000000",
                type: "loader",
                state: "primary",
                message: "Please wait..."
            });
        });

        // Get initial values from request to handle re-population after submission
        var initialPhaseId = '{{ app()->request->phase_id }}';
        var initialSubjectGroupId = '{{ app('request')->input('subject_group_id') }}';
        var initialSubjectId = '{{ app('request')->input('subject_id') }}';

        $('#phase_id').on('change', function () {
            var sessionId = $('#session_id').val();
            var courseId = $('#course_id').val();
            var phaseId = $(this).val();

            var subjectGroupSelect = $('#subject_group_id');
            var subjectSelect = $('#subject_id');

            subjectGroupSelect.html('<option value="">---- Select Subject Group ----</option>').selectpicker(
                'refresh');
            subjectSelect.html('<option value="">---- Select Subject ----</option>').selectpicker('refresh');

            if (!phaseId) return;

            mApp.blockPage({
                message: "Loading groups..."
            });
            $.get('{{ route('SubjectGroup.session.course.phase') }}', {
                sessionId: sessionId,
                courseId: courseId,
                phaseId: phaseId
            }, function (response) {
                var options = '<option value="">---- Select Subject Group ----</option>';
                if (response.data) {
                    response.data.forEach(function (group) {
                        options += '<option value="' + group.id + '">' + group.title + '</option>';
                    });
                }
                subjectGroupSelect.html(options);

                if (initialSubjectGroupId) {
                    subjectGroupSelect.val(initialSubjectGroupId);
                }

                subjectGroupSelect.selectpicker('refresh');
                mApp.unblockPage();

                if (initialSubjectGroupId) {
                    subjectGroupSelect.trigger('change');
                    initialSubjectGroupId = null;
                }
            });
        });

        $('#subject_group_id').on('change', function () {
            var sessionId = $('#session_id').val();
            var courseId = $('#course_id').val();
            var subjectGroupId = $(this).val();

            var subjectSelect = $('#subject_id');
            subjectSelect.html('<option value="">---- Select Subject ----</option>').selectpicker('refresh');

            if (!subjectGroupId) return;

            mApp.blockPage({
                message: "Loading subjects..."
            });
            $.get('{{ route('subjects.group') }}', {
                sessionId: sessionId,
                courseId: courseId,
                subjectGroupId: subjectGroupId
            }, function (response) {
                var options = '<option value="">---- Select Subject ----</option>';
                if (response.data) {
                    response.data.forEach(function (subject) {
                        options += '<option value="' + subject.id + '">' + subject.title +
                            '</option>';
                    });
                }
                subjectSelect.html(options);

                if (initialSubjectId) {
                    subjectSelect.val(initialSubjectId);
                    initialSubjectId = null;
                }

                subjectSelect.selectpicker('refresh');
                mApp.unblockPage();
            });
        });

        if (initialPhaseId) {
            $('#phase_id').trigger('change');
        }

        $(document).ready(function () {
            $('.btn-group[data-hover="dropdown"]').hover(
                function () {
                    $(this).find('.dropdown-menu').stop(true, true).delay(100).fadeIn(200);
                },
                function () {
                    $(this).find('.dropdown-menu').stop(true, true).delay(100).fadeOut(200);
                }
            );

            $('.btn-group[data-hover="dropdown"]').hover(
                function () {
                    $(this).find('.angle-icon').removeClass('fa-angle-down').addClass('fa-angle-up');
                },
                function () {
                    $(this).find('.angle-icon').removeClass('fa-angle-up').addClass('fa-angle-down');
                }
            );

            // Remove the toggle functionality since checkboxes are always visible
            $('#toggleIndividualNotify').remove();

            // Update the checkbox change handler to show count
            $(document).on('change', '.student-checkbox', function () {
                var checkedCount = $('.student-checkbox:checked').length;
                $('.selected-count').text(checkedCount);
                if (checkedCount > 0) {
                    $('#selectedNotifyBtn').show();
                } else {
                    $('#selectedNotifyBtn').hide();
                }
            });

            // Select all functionality
            $('#selectAllStudents').change(function () {
                var isChecked = $(this).prop('checked');
                $('.student-checkbox').prop('checked', isChecked);
                updateSelectedCount();
            });

            // Update select all state when individual checkboxes change
            $(document).on('change', '.student-checkbox', function () {
                updateSelectedCount();
                updateSelectAllState();
            });

            function updateSelectAllState() {
                var totalCheckboxes = $('.student-checkbox').length;
                var checkedCheckboxes = $('.student-checkbox:checked').length;

                $('#selectAllStudents').prop({
                    'checked': checkedCheckboxes > 0,
                    'indeterminate': checkedCheckboxes > 0 && checkedCheckboxes < totalCheckboxes
                });
            }

            function updateSelectedCount() {
                var checkedCount = $('.student-checkbox:checked').length;
                $('.selected-count').text(checkedCount);
                if (checkedCount > 0) {
                    $('#selectedNotifyBtn').show();
                } else {
                    $('#selectedNotifyBtn').hide();
                }
            }

            $(document).on('click', '#selectedNotifyBtn', function () {
                var selectedStudents = [];
                $('.student-checkbox:checked').each(function () {
                    selectedStudents.push({
                        id: $(this).data('student-id'),
                        name: $(this).data('student-name'),
                        rollNo: $(this).data('roll-no'),
                        percentage: $(this).data('percentage')
                    });
                });

                if (selectedStudents.length > 0) {
                    swal({
                        title: "Are you sure?",
                        text: "Do you want to send notifications to the selected students parents?",
                        type: "warning",
                        showCancelButton: true,
                        confirmButtonColor: "#3085d6",
                        cancelButtonColor: "#d33",
                        confirmButtonText: "Yes, send it!",
                        cancelButtonText: "Cancel"
                    }).then(function (result) {
                        if (result.value) {
                            sendNotifications(selectedStudents);
                        }
                    });
                } else {
                    swal({
                        title: "No students selected",
                        text: "Please select at least one student.",
                        type: "warning"
                    });
                }
            });

            function sendNotifications(selectedStudents = null) {
                var data = {
                    subject_id: $('#subject_id').val(),
                    percentage_type: $('#percentage_type').val(),
                    percentage_filter: $('#percentage_filter').val(),
                    start_date: $('#start_date').val(),
                    end_date: $('#end_date').val(),
                    selected_students: selectedStudents
                };

                mApp.blockPage({
                    overlayColor: "#000000",
                    type: "loader",
                    state: "primary",
                    message: "Please wait..."
                });

                $.ajax({
                    url: '{{ route('attendance.send.notification.parents') }}',
                    type: 'POST',
                    data: data,
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function (response) {
                        mApp.unblockPage();
                        if (response.success) {
                            swal({
                                title: "Success!",
                                text: response.message,
                                type: "success"
                            });
                        } else {
                            swal({
                                title: "Error!",
                                text: response.message,
                                type: "error"
                            });
                        }
                    },
                    error: function () {
                        mApp.unblockPage();
                        swal({
                            title: "Error!",
                            text: "An error occurred while sending notifications.",
                            type: "error"
                        });
                    }
                });
            }
        });
    </script>
@endpush
