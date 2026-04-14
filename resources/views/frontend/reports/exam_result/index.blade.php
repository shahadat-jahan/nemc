@extends('frontend.layouts.default')
@section('pageTitle', $pageTitle)

@push('style')
    <style>
        .m-stack--demo.m-stack--ver .m-stack__item, .m-stack--demo.m-stack--hor .m-stack__demo-item {
            padding: 29px;
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
                            <h3 class="m-portlet__head-text"><i class="fas fa-list-ul fa-md pr-2"></i>{{$pageTitle}}
                            </h3>
                        </div>
                    </div>
                </div>

                <div class="m-portlet__body">
                    <div class="m-section__content">
                        <form id="searchForm" role="form" method="get">
                            <div class="row">
                                <div class="col-xs-12 col-sm-6 col-md-3 col-lg-3 col-xl-3">
                                    <div class="form-group">
                                        <select class="form-control" name="session_id" id="session_id">
                                            <option value="">---- Select Session ----</option>
                                            {!! select($sessions, app()->request->session_id) !!}
                                        </select>
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-6 col-md-3 col-lg-3 col-xl-3">
                                    <div class="form-group">
                                        <select class="form-control" name="course_id" id="course_id">
                                            <option value="">---- Select Course ----</option>
                                            {!! select($courses, app()->request->course_id) !!}
                                        </select>
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-6 col-md-3 col-lg-3 col-xl-3">
                                    <div class="form-group">
                                        <select class="form-control" name="phase_id" id="phase_id">
                                            <option value="">---- Select Phase ----</option>
                                            {!! select($phases, app()->request->phase_id) !!}
                                        </select>
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-6 col-md-3 col-lg-3 col-xl-3">
                                    <select class="form-control" name="term_id" id="term_id">
                                        <option value="">---- Select Term ----</option>
                                        {!! select($terms, app()->request->term_id) !!}
                                    </select>
                                </div>
                                <div class="col-xs-12 col-sm-6 col-md-3 col-lg-3 col-xl-3">
                                    <select class="form-control" name="subject_id"
                                            id="subject_id" data-live-search="true">
                                        <option value="">---- Select Subject ----</option>
                                    </select>
                                </div>
                                <div class="col-xs-12 col-sm-6 col-md-3 col-lg-3 col-xl-3">
                                    <select class="form-control" name="exam_category_id" id="exam_category_id">
                                        <option value="">---- Select Exam Category ----</option>
                                        {!! select($examCategories, app()->request->exam_category_id) !!}
                                    </select>
                                </div>
                                <div class="col-xs-12 col-sm-6 col-md-3 col-lg-3 col-xl-3">
                                    <select class="form-control" name="exam_id" id="exam_id">
                                        <option value="">---- Select Exam ----</option>
                                    </select>
                                </div>
                            </div>
                            <div class="row mt-4">
                                <div class="col-xs-12 col-sm-6 col-md-12 col-lg-12 col-xl-12">
                                    <div class="pull-right search-action-btn">
                                        @if(!empty($examResult))
                                            <a target="_blank" href="{{route(customRoute('report.exam_result.category.pdf'), [
                                        'session_id' => app()->request->session_id,
                                        'course_id' => app()->request->course_id,
                                        'phase_id' => app()->request->phase_id,
                                        'term_id' => app()->request->term_id,
                                        'exam_id' => app()->request->exam_id,
                                        'exam_category_id' => app()->request->exam_category_id,
                                        'subject_id' => app()->request->subject_id,
                                    ])}}" class="btn btn-primary m-btn m-btn--icon"><i class="fa fa-file-pdf"></i>
                                                PDF</a>
                                            <a href="{{route(customRoute('report.exam_result.category.excel'), [
                                        'session_id' => app()->request->session_id,
                                        'course_id' => app()->request->course_id,
                                        'phase_id' => app()->request->phase_id,
                                        'term_id' => app()->request->term_id,
                                        'exam_id' => app()->request->exam_id,
                                        'exam_category_id' => app()->request->exam_category_id,
                                        'subject_id' => app()->request->subject_id,
                                    ])}}" class="btn btn-primary m-btn m-btn--icon"><i class="fa fa-file-export"></i>
                                                Export</a>
                                        @endif
                                        <button class="btn btn-primary m-btn m-btn--icon search-result"><i
                                                class="fa fa-search"></i> Search
                                        </button>
                                        <a class="btn btn-default m-btn m-btn--icon"
                                           href="{{url('nemc/report_exam_result')}}">
                                            <i class="fas fa-sync-alt search-reset"></i> Reset
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </form>

                    </div>

                    @if(!empty($examResult))
                        <div class="row mt-4">
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
                                <div class="m-separator m-separator--dashed m-separator--lg"></div>
                                <div class="row">
                                    <div class=" col-md-4 m-stack m-stack--ver m-stack--general m-stack--demo">
                                        <div class="m-stack__item m-stack__item--center">
                                            Exam Category: {{$examCategories[app()->request->exam_category_id]}}
                                        </div>
                                    </div>
                                    <div class=" col-md-4 m-stack m-stack--ver m-stack--general m-stack--demo">
                                        <div class="m-stack__item m-stack__item--center">
                                            Exam Name: {{$exam->title}}
                                        </div>
                                    </div>
                                    <div class=" col-md-4 m-stack m-stack--ver m-stack--general m-stack--demo">
                                        <div class="m-stack__item m-stack__item--center">
                                            Subject : {{$subject->title}}
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                        @php
                            $passPercentage = Setting::getSiteSetting()->pass_mark;
                            $examSubjectMarkIds = [];
                        @endphp
                        <div class="row mt-4">
                            <div class="table m-table table-responsive">
                                <table class="table table-bordered table-hover sticky-header" id="exam-results">
                                    <thead class="text-center">
                                    <tr>
                                        <th class="align-middle" rowspan="2">Roll No</th>
                                        <th class="align-middle" rowspan="2">Name</th>
                                        @php
                                            $examTotalMarks = 0;
                                            $examTypeMarksArr = [];
                                        @endphp
                                        @foreach($examTypeSubType as $type)
                                            @php
                                                $examTypeMarks = 0;
                                                $colspan = count($type->examSubTypes) + 1;
                                            @endphp
                                            @foreach($type->examSubTypes as $subType)
                                                @foreach($subType->examSubjectMark as $mark)
                                                    @php
                                                        $examTypeMarks               += $mark->total_marks;
                                                        $examTypeMarksArr[$type->id] = $examTypeMarks;
                                                    @endphp
                                                @endforeach
                                            @endforeach
                                            <th class="align-middle" colspan="{{$colspan}}">{{$type->title}}
                                                ({{$examTypeMarks}})
                                            </th>
                                            @php
                                                $examTotalMarks += $examTypeMarks;
                                            @endphp
                                        @endforeach
                                        <th class="align-middle" rowspan="2">Result</th>
                                        <th class="align-middle" rowspan="2">Comment</th>
                                    </tr>
                                    <tr>
                                        @foreach($examTypeSubType as $type)
                                            @foreach($type->examSubTypes->sortBy('id') as $subType)
                                                @foreach($subType->examSubjectMark as $mark)
                                                    @php
                                                        $examSubjectMarkIds[] = $mark->id;
                                                    @endphp
                                                    <th class="align-middle">{{$subType->title}}
                                                        <br>({{$mark->total_marks}})
                                                    </th>
                                                @endforeach
                                            @endforeach
                                            <th class="align-middle">Total</th>
                                        @endforeach
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($examResult->groupBy('student_id') as $studentId => $studentResult)
                                        <tr>
                                            <td class="text-center align-middle">{{$studentResult->first()->student->roll_no}}</td>
                                            <td class="align-middle">
                                                {{$studentResult->first()->student->full_name_en}}
                                            </td>
                                            @php
                                                $totalMarksByExamType = [];
                                                $totalGrace = 0;
                                            @endphp
                                            @foreach($studentResult->sortBy('id')->groupBy('examSubjectMark.examSubType.exam_type_id')->sortBy('id') as $results)
                                                @php
                                                    $total = 0;
                                                    $totalMark = 0;
                                                @endphp
                                                @foreach($results as $result)
                                                    @php
                                                        $examType     = $result->examSubjectMark->examSubType->examType;
                                                        $examTypeId   = $examType->id;
                                                        $resultStatus = 'Pass';
                                                        $colour       = '';
                                                        $marks        = $result->marks;
                                                        $grace_marks  = $result->grace_marks;
                                                        $totalMark    = $marks + $grace_marks;
                                                        $total       += $totalMark;
                                                        $totalGrace  += $grace_marks;

                                                        if (!isset($totalMarksByExamType[$examTypeId])) {
                                                            $totalMarksByExamType[$examTypeId] = 0;
                                                        }
                                                        $totalMarksByExamType[$examTypeId] += $totalMark;

                                                        $special = $result->whereIn('exam_subject_mark_id', $examSubjectMarkIds)->whereNotNull('special_status')->where('student_id', $studentId)->count();
                                                        $absent  = $result->whereIn('exam_subject_mark_id', $examSubjectMarkIds)->where('pass_status', 4)->where('student_id', $studentId)->count();
                                                        $grace   = $result->whereIn('exam_subject_mark_id', $examSubjectMarkIds)->whereIn('exam_subject_mark_id', $examSubjectMarkIds)->where('pass_status', 3)->where('student_id', $studentId)->count();

                                                        if ($special > 0) {
                                                            $resultStatus = $result->whereIn('exam_subject_mark_id', $examSubjectMarkIds)->where('special_status', 1)->where('student_id', $studentId)->count() > 0 ? 'Pass' : 'Fail';
                                                            $colour = $result->whereIn('exam_subject_mark_id', $examSubjectMarkIds)->where('special_status', 1)->where('student_id', $studentId)->count() > 0 ? 'text-success' : 'text-warning';
                                                        }
                                                    @endphp
                                                    <td class="text-center align-middle">{{$result->pass_status === 4 ? '-' : $totalMark}}</td>
                                                @endforeach
                                                <td class="text-center align-middle">{{$total ?: '-'}}</td>
                                            @endforeach
                                            <td class="text-center align-middle">
                                                @php
                                                    $failCount = 0;
                                                    $passCount = 0;

                                                    foreach ($examTypeMarksArr as $key => $typeTotalMark)
                                                    {
                                                        $typeMark        = $totalMarksByExamType[$key];
                                                        $checkPercentage = ($typeMark * 100) / $typeTotalMark;

                                                        if ($passPercentage > $checkPercentage){
                                                                ++$failCount;
                                                        }else{
                                                            ++$passCount;
                                                        }
                                                    }

                                                    if ($special < 1){
                                                        if ($absent > 0) {
                                                            // Case: Only absent, no pass or fail
                                                            $resultStatus = 'Absent';
                                                        } elseif ($absent == 0 && $failCount > 0) {
                                                            // Case: Fail if there's a fail count & no absences
                                                            $resultStatus = 'Fail';
                                                        } elseif ($absent == 0 && $failCount == 0 && $grace > 0) {
                                                            // Case: Pass with grace if no absences or fails, but grace is applied
                                                            $resultStatus = 'Pass(Grace - '. $totalGrace .')';
                                                        }
                                                    }
                                                @endphp
                                                <span class="{{$colour}}">{{$resultStatus}}</span>
                                            </td>
                                            <td class="text-center align-middle">{{ $result->remarks ?: '--'}}</td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    @endif

                </div>

            </div>
        </div>
    </div>

@endsection

@push('scripts')
    <script src="//cdnjs.cloudflare.com/ajax/libs/lodash.js/4.17.11/lodash.min.js" type="text/javascript"></script>
    <script>
        !function (a) {
            function b(a, b, c) {
                if (8 == g) {
                    var d = j.width(), e = f.debounce(function () {
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
                var b = a('<div style="width:50px;height:50px;overflow-y:scroll;position:absolute;top:-200px;left:-200px;"><div style="height:100px;width:100%"></div>');
                a("body").append(b);
                var c = b.innerWidth(), d = a("div", b).innerWidth();
                return b.remove(), c - d
            }

            function e(a) {
                if (a.dataTableSettings) for (var b = 0; b < a.dataTableSettings.length; b++) {
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
            var f = window._, g = function () {
                for (var a = 3, b = document.createElement("b"), c = b.all || []; a = 1 + a, b.innerHTML = "<!--[if gt IE " + a + "]><i><![endif]-->", c[0];) ;
                return a > 4 ? a : document.documentMode
            }(), h = null, i = function () {
                if (g) return !1;
                var b = a("<table><colgroup><col></colgroup><tbody><tr><td style='width:10px'></td></tbody></table>");
                a("body").append(b);
                var c = b.find("col").width();
                return b.remove(), 0 == c
            }, j = a(window), k = 0;
            a.fn.floatThead = function (l) {
                if (l = l || {}, !f && (f = window._ || a.floatThead._, !f)) throw new Error("jquery.floatThead-slim.js requires underscore. You should use the non-lite version since you do not have underscore.");
                if (8 > g) return this;
                if (null == h && (h = i(), h && (document.createElement("fthtr"), document.createElement("fthtd"), document.createElement("fthfoot"))), f.isString(l)) {
                    var m = l, n = this;
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
                    b in a.floatThead.defaults || !o.debug || c("jQuery.floatThead: used [" + b + "] key to init plugin, but that param is not an option for the plugin. Valid options are: " + f.keys(a.floatThead.defaults).join(", "))
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
                        var a = z.outerWidth(), b = I.width() || a;
                        if (X.width(b - F.vertical), O) {
                            var c = 100 * a / (b - F.vertical);
                            S.css("width", c + "%")
                        } else S.outerWidth(a)
                    }

                    function m() {
                        C = (f.isFunction(o.scrollingTop) ? o.scrollingTop(z) : o.scrollingTop) || 0, D = (f.isFunction(o.scrollingBottom) ? o.scrollingBottom(z) : o.scrollingBottom) || 0
                    }

                    function n() {
                        var b, c;
                        if (V) b = U.find("col").length; else {
                            var d;
                            d = null == o.cellTag && o.headerCellSelector ? o.headerCellSelector : "tr:first>" + o.cellTag, c = A.find(d), b = 0, c.each(function () {
                                b += parseInt(a(this).attr("colspan") || 1, 10)
                            })
                        }
                        if (b != H) {
                            H = b;
                            for (var e = [], f = [], g = [], i = 0; b > i; i++) e.push('<th class="floatThead-col"/>'), f.push("<col/>"), g.push("<fthtd style='display:table-cell;height:0;width:auto;'/>");
                            f = f.join(""), e = e.join(""), h && (g = g.join(""), W.html(g), bb = W.find("fthtd")), Z.html(e), $ = Z.find("th"), V || U.html(f), _ = U.find("col"), T.html(f), ab = T.find("col")
                        }
                        return b
                    }

                    function p() {
                        if (!E) {
                            if (E = !0, J) {
                                var a = z.width(), b = Q.width();
                                a > b && z.css("minWidth", a)
                            }
                            z.css(db), S.css(db), S.append(A), B.before(Y), i()
                        }
                    }

                    function q() {
                        E && (E = !1, J && z.width(fb), Y.detach(), z.prepend(A), z.css(eb), S.css(eb))
                    }

                    function r(a) {
                        J != a && (J = a, X.css({position: J ? "absolute" : "fixed"}))
                    }

                    function s(a, b, c, d) {
                        return h ? c : d ? o.getSizingRow(a, b, c) : b
                    }

                    function t() {
                        var a, b = n();
                        return function () {
                            var c = s(z, _, bb, g);
                            if (c.length == b && b > 0) {
                                if (!V) for (a = 0; b > a; a++) _.eq(a).css("width", "");
                                q();
                                var d = [];
                                for (a = 0; b > a; a++) d[a] = c.get(a).offsetWidth;
                                for (a = 0; b > a; a++) ab.eq(a).width(d[a]), _.eq(a).width(d[a]);
                                p()
                            } else S.append(A), z.css(eb), S.css(eb), i()
                        }
                    }

                    function u(a) {
                        var b = I.css("border-" + a + "-width"), c = 0;
                        return b && ~b.indexOf("px") && (c = parseInt(b, 10)), c
                    }

                    function v() {
                        var a, b = I.scrollTop(), c = 0, d = L ? K.outerHeight(!0) : 0, e = M ? d : -d, f = X.height(),
                            g = z.offset(), i = 0;
                        if (O) {
                            var k = I.offset();
                            c = g.top - k.top + b, L && M && (c += d), c -= u("top"), i = u("left")
                        } else a = g.top - C - f + D + F.horizontal;
                        var l = j.scrollTop(), m = j.scrollLeft(), n = I.scrollLeft();
                        return b = I.scrollTop(), function (k) {
                            if ("windowScroll" == k ? (l = j.scrollTop(), m = j.scrollLeft()) : "containerScroll" == k ? (b = I.scrollTop(), n = I.scrollLeft()) : "init" != k && (l = j.scrollTop(), m = j.scrollLeft(), b = I.scrollTop(), n = I.scrollLeft()), !h || !(0 > l || 0 > m)) {
                                if (R) r("windowScrollDone" == k ? !0 : !1); else if ("windowScrollDone" == k) return null;
                                g = z.offset(), L && M && (g.top += d);
                                var o, s, t = z.outerHeight();
                                if (O && J) {
                                    if (c >= b) {
                                        var u = c - b;
                                        o = u > 0 ? u : 0
                                    } else o = P ? 0 : b;
                                    s = i
                                } else !O && J ? (l > a + t + e ? o = t - f + e : g.top > l + C ? (o = 0, q()) : (o = C + l - g.top + c + (M ? d : 0), p()), s = 0) : O && !J ? (c > b || b - c > t ? (o = g.top - l, q()) : (o = g.top + b - l - c, p()), s = g.left + n - m) : O || J || (l > a + t + e ? o = t + C - l + a + e : g.top > l + C ? (o = g.top - l, p()) : o = C, s = g.left - m);
                                return {top: o, left: s}
                            }
                        }
                    }

                    function w() {
                        var a = null, b = null, c = null;
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
                            var a = I.width(), b = I.height(), c = z.height(), d = z.width(), e = d > a ? G : 0,
                                f = c > b ? G : 0;
                            F.horizontal = d > a - f ? G : 0, F.vertical = c > b - e ? G : 0
                        }
                    }

                    var y = k, z = a(this);
                    if (z.data("floatThead-attached")) return !0;
                    if (!z.is("table")) throw new Error('jQuery.floatThead must be run on a table element. ex: $("table").floatThead();');
                    var A = z.find("thead:first"), B = z.find("tbody:first");
                    if (0 == A.length) throw new Error("jQuery.floatThead must be run on a table that contains a <thead> element");
                    var C, D, E = !1, F = {vertical: 0, horizontal: 0}, G = d(), H = 0,
                        I = o.scrollContainer(z) || a([]), J = o.useAbsolutePositioning;
                    null == J && (J = o.scrollContainer(z).length);
                    var K = z.find("caption"), L = 1 == K.length;
                    if (L) var M = "top" === (K.css("caption-side") || K.attr("align") || "top");
                    var N = a('<fthfoot style="display:table-footer-group;"/>'), O = I.length > 0, P = !1, Q = a([]),
                        R = 9 >= g && !O && J, S = a("<table/>"), T = a("<colgroup/>"), U = z.find("colgroup:first"),
                        V = !0;
                    0 == U.length && (U = a("<colgroup/>"), V = !1);
                    var W = a('<fthrow style="display:table-row;height:0;"/>'),
                        X = a('<div style="overflow: hidden;"></div>'), Y = a("<thead/>"),
                        Z = a('<tr class="size-row"/>'), $ = a([]), _ = a([]), ab = a([]), bb = a([]);
                    if (Y.append(Z), z.prepend(U), h && (N.append(W), z.append(N)), S.append(T), X.append(S), o.copyTableClass && S.attr("class", z.attr("class")), S.attr({
                        cellpadding: z.attr("cellpadding"),
                        cellspacing: z.attr("cellspacing"),
                        border: z.attr("border")
                    }), S.css({
                        borderCollapse: z.css("borderCollapse"),
                        border: z.css("border")
                    }), S.addClass(o.floatTableClass).css("margin", 0), J) {
                        var cb = function (a, b) {
                            var c = a.css("position"), d = "relative" == c || "absolute" == c;
                            if (!d || b) {
                                var e = {paddingLeft: a.css("paddingLeft"), paddingRight: a.css("paddingRight")};
                                X.css(e), a = a.wrap("<div class='" + o.floatWrapperClass + "' style='position: relative; clear:both;'></div>").parent(), P = !0
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
                    var db = {"table-layout": "auto"}, eb = {"table-layout": z.css("tableLayout") || "auto"},
                        fb = z[0].style.width || "";
                    x();
                    var gb, hb = function () {
                        (gb = t())()
                    };
                    hb();
                    var ib = v(), jb = w();
                    jb(ib("init"), !0);
                    var kb = f.debounce(function () {
                        jb(ib("windowScrollDone"), !1)
                    }, 300), lb = function () {
                        jb(ib("windowScroll"), !1), kb()
                    }, mb = function () {
                        jb(ib("containerScroll"), !1)
                    }, nb = function () {
                        m(), x(), hb(), ib = v(), (jb = w())(ib("resize"), !0, !0)
                    }, ob = f.debounce(function () {
                        x(), m(), hb(), ib = v(), jb(ib("reflow"), !0)
                    }, 1);
                    O ? J ? I.on(c("scroll"), mb) : (I.on(c("scroll"), mb), j.on(c("scroll"), lb)) : j.on(c("scroll"), lb), j.on(c("load"), ob), b(o.debounceResizeMs, c("resize"), nb), z.on("reflow", ob), e(z) && z.on("filter", ob).on("sort", ob).on("page", ob), z.data("floatThead-attached", {
                        destroy: function () {
                            var a = ".fth-" + y;
                            q(), z.css(eb), U.remove(), h && N.remove(), Y.parent().length && Y.replaceWith(A), z.off("reflow"), I.off(a), P && (I.length ? I.unwrap() : z.unwrap()), J && z.css("minWidth", ""), X.remove(), z.data("floatThead-attached", !1), j.off(a)
                        }, reflow: function () {
                            ob()
                        }, setHeaderHeight: function () {
                            i()
                        }, getFloatContainer: function () {
                            return X
                        }, getRowGroups: function () {
                            return E ? X.find("thead").add(z.find("tbody,tfoot")) : z.find("thead,tbody,tfoot")
                        }
                    }), k++
                }), this
            }
        }(jQuery), function (a) {
            a.floatThead = a.floatThead || {}, a.floatThead._ = window._ || function () {
                var b = {}, c = Object.prototype.hasOwnProperty,
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
                        }, j = c && !d;
                        return d || (d = setTimeout(i, b)), j && (h = a.apply(f, e)), h
                    }
                }, b
            }()
        }(jQuery);

        $(".sticky-header").floatThead({scrollingTop: 70});

        var sessionId = '{{ app()->request->session_id }}';
        var courseId = '{{ app()->request->course_id }}';
        var phaseId = '{{ app()->request->phase_id }}';
        var termId = '{{ app()->request->term_id }}';
        var subjectId = '{{ app()->request->subject_id }}';
        var examCategoryId = '{{ app()->request->exam_category_id }}';
        var examId = '{{app()->request->exam_id}}';

        $('.search-result').click(function () {
            valid = true;
            $('#searchForm select').each(function () {
                if (($(this).val() == '')) {
                    valid = false;
                }
            });

            if (valid == false) {
                sweetAlert('All fields are required to search', 'error');
                return false;
            } else {
                $('#searchForm').submit();
            }
        });

        $('#course_id, #session_id').change(function () {
            courseId = $('#course_id').val();
            sessionId = $('#session_id').val();
            $.get('{{route(customRoute('phase.term.list'))}}', {sessionId: sessionId, courseId: courseId}, function (response) {
                if (response.data) {
                    phaseInfo = response.data;
                }
            })
        });

        $('#phase_id').change(function () {
            phaseId = $(this).val();
            courseId = $('#course_id').val();
            sessionId = $('#session_id').val();
            mApp.blockPage({
                overlayColor: "#000000",
                type: "loader",
                state: "primary",
                message: "Please wait..."
            });

            // load subjects
            $.get('{{route(customRoute('subjects.session.course.phase'))}}', {
                sessionId: sessionId,
                courseId: courseId,
                phaseId: phaseId
            }, function (response) {
                if (response.data) {
                    $('#subject_id').html('<option value="">---- Select Subject ----</option>');
                    for (i in response.data) {
                        subject = response.data[i];
                        selected = (subjectId == subject.id) ? 'selected' : '';
                        $('#subject_id').append('<option value="' + subject.id + '" ' + selected + '>' + subject.title + '</option>')
                    }

                }
                mApp.unblockPage();
            })
        });

        $('#session_id, #course_id, #phase_id, #term_id, #subject_id, #exam_category_id').change(function () {
            sessionId = $('#session_id').val();
            courseId = $('#course_id').val();
            phaseId = $('#phase_id').val();
            termId = $('#term_id').val();
            subjectId = $('#subject_id').val();
            examCategoryId = $('#exam_category_id').val();

            if (sessionId > 0 && courseId > 0 && phaseId > 0 && termId > 0 && subjectId > 0 && examCategoryId > 0) {
                mApp.blockPage({
                    overlayColor: "#000000",
                    type: "loader",
                    state: "primary",
                    message: "Please wait..."
                });

                // load exam
                $.get('{{route(customRoute('exam.list.session.course.phase.term.subject'))}}', {
                    sessionId: sessionId,
                    courseId: courseId,
                    phaseId: phaseId,
                    termId: termId,
                    subjectId: subjectId,
                    examCategoryId: examCategoryId
                }, function (response) {
                    if (response.exams) {
                        $('#exam_id').html('<option value="">---- Select Exam ----</option>');
                        for (i in response.exams) {
                            exam = response.exams[i];
                            selected = (exam.id == examId) ? 'selected' : '';
                            $('#exam_id').append('<option value="' + exam.id + '" ' + selected + '>' + exam.title + '</option>')
                        }
                    }
                    mApp.unblockPage()
                });
            }
        });

        {{--$('#exam_id').change(function () {--}}
            {{--    if ($(this).val() > 0) {--}}
            {{--        mApp.blockPage({--}}
            {{--            overlayColor: "#000000",--}}
            {{--            type: "loader",--}}
            {{--            state: "primary",--}}
            {{--            message: "Please wait..."--}}
            {{--        });--}}


            {{--        $.get('{{route('subjects.list.examId')}}', {examId: $(this).val()}, function (response) {--}}
            {{--            if (response.subjects) {--}}
            {{--                $('#subject_id').html('<option value="">---- Select Subject ----</option>');--}}
            {{--                for (i in response.subjects) {--}}
            {{--                    subject = response.subjects[i];--}}
            {{--                    selected = (subjectId == subject.id) ? 'selected' : '';--}}
            {{--                    $('#subject_id').append('<option value="' + subject.id + '" ' + selected + '>' + subject.title + '</option>')--}}
            {{--                }--}}
            {{--            }--}}
            {{--            $('.m_selectpicker').selectpicker('refresh');--}}
            {{--            mApp.unblockPage();--}}
            {{--        });--}}
            {{--    }--}}
            {{--});--}}


        if (examId > 0) {
            // load subjects
            $.get('{{route(customRoute('subjects.session.course.phase'))}}', {
                sessionId: sessionId,
                courseId: courseId,
                phaseId: phaseId
            }, function (response) {
                if (response.data) {
                    $('#subject_id').html('<option value="">---- Select Subject ----</option>');
                    for (i in response.data) {
                        subject = response.data[i];
                        selected = (subjectId == subject.id) ? 'selected' : '';
                        $('#subject_id').append('<option value="' + subject.id + '" ' + selected + '>' + subject.title + '</option>')
                    }
                    console.log(selected +' '+ subjectId )
                }
            })

            // load exam
            $.get('{{route(customRoute('exam.list.session.course.phase.term.subject'))}}', {
                sessionId: sessionId,
                courseId: courseId,
                phaseId: phaseId,
                termId: termId,
                subjectId: subjectId,
                examCategoryId: examCategoryId
            }, function (response) {
                if (response.exams) {
                    $('#exam_id').html('<option value="">---- Select Exam ----</option>');
                    for (i in response.exams) {
                        exam = response.exams[i];
                        selected = (exam.id == examId) ? 'selected' : '';
                        $('#exam_id').append('<option value="' + exam.id + '" ' + selected + '>' + exam.title + '</option>')
                    }
                }
            });
        }
    </script>
@endpush
