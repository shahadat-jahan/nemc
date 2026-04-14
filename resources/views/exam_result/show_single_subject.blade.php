@extends('layouts.default')
@section('pageTitle', $pageTitle)
@push('style')
    <style>
        #all-students .form-control[type=text] {
            width: 4rem;
        }

        table.floatThead-table {
            border-top: none;
            border-bottom: none;
            background-color: #fff;
        }
    </style>
@endpush
@section('content')

    <div class="m-portlet m-portlet--tab">
        <div class="m-portlet__head">
            <div class="m-portlet__head-caption">
                <div class="m-portlet__head-title">
                    <h3 class="m-portlet__head-text"><i class="far fa-plus-square pr-2"></i>{{$pageTitle}}</h3>
                </div>
            </div>
            <div class="m-portlet__head-tools">
                @if (hasPermission('result/edit'))
                    @php
                        if (Auth::guard('web')->check()) {
                            $user = Auth::guard('web')->user();
                            $examSubjectMarks = $examInfo->examMarks->where('subject_id', $subject->id)->first();
                            $examSubject = $examInfo->examSubjects->where('subject_id', $subject->id)->first();
                            $hod = $subject->department->teacher;
                            $statusIcon = $examSubject->hod_edit_permission ? 'fa fa-toggle-on' : 'fa fa-toggle-off';
                            $statusTitle = $examSubject->hod_edit_permission ? 'Close edit permission' : 'Get edit permission';
                            $proof = DB::table('result_edit_request')
                                ->where('exam_id', $examSubject->exam_id)
                                ->where('subject_id', $examSubject->subject_id)
                                ->where('user_id', $hod->user_id)
                                ->orderByDesc('id')
                                ->first();

                            $showToggleButton = $user->user_group_id == 1
                                && $proof
                                && !empty($examSubject->result_published)
                                && !empty($examSubjectMarks->total_marks)
                                && !empty($examSubjectMarks->result->toArray());
                        }
                    @endphp

                    @if (!empty($showToggleButton))
                        <button
                            data-exam-id="{{ $examSubject->exam_id }}"
                            data-subject-id="{{ $examSubject->subject_id }}"
                            class="btn btn-primary m-btn m-btn--icon mr-2 toggle-edit-permission">
                            <i class="{{ $statusIcon }}"></i>
                            {{ $statusTitle }}
                        </button>
                    @endif
                @endif

                <a href="{{ route('result.index') }}" class="btn btn-primary m-btn m-btn--icon"><i
                        class="far fa-list-alt pr-2"></i>Exam Results</a>
            </div>
        </div>
        <div class="m-portlet__body">
            <div class="m-section__content">
                <div class="card">
                    <div class="card-header">
                        Common Information
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-12">
                                <div class="">
                                    <p><b>Exam Title : </b> {{$examInfo->title}}</p>
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                                <div class="card">
                                    <ul class="list-group list-group-flush">
                                        <li class="list-group-item">
                                            <div class="row">
                                                <div class="col-md-4">Session :</div>
                                                <div class="col-md-8">{{$examInfo->session->title}}</div>
                                            </div>
                                        </li>
                                        <li class="list-group-item">
                                            <div class="row">
                                                <div class="col-md-4">Course :</div>
                                                <div class="col-md-8">{{$examInfo->course->title}}</div>
                                            </div>
                                        </li>
                                        <li class="list-group-item">
                                            <div class="row">
                                                <div class="col-md-4">Phase :</div>
                                                <div class="col-md-8">{{$examInfo->phase->title}}</div>
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
                                                <div class="col-md-4">Term :</div>
                                                <div class="col-md-8">{{$examInfo->term->title}}</div>
                                            </div>
                                        </li>
                                        <li class="list-group-item">
                                            <div class="row">
                                                <div class="col-md-4">Subject :</div>
                                                <div class="col-md-8">{{$subject->title}}</div>
                                            </div>
                                        </li>
                                        <li class="list-group-item">
                                            <div class="row">
                                                <div class="col-md-4">Exam Category :</div>
                                                <div class="col-md-8">{{$examInfo->examCategory->title}}</div>
                                            </div>
                                        </li>

                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @php
                    $passPercentage = Setting::getSiteSetting()->pass_mark;
                    $examSubjectMarks = $examInfo->examMarks->where('subject_id', $subject->id)->first();
                    $examTotalMarks = 0;
                    $examTypeMarksArr = [];
                    $examSubjectMarkIds = [];

                    foreach ($examTypeSubType as $type) {
                        $examTypeMarks = 0;
                        foreach ($type->examSubTypes as $subType) {
                            foreach ($subType->examSubjectMark as $mark) {
                                $examTypeMarks += $mark->total_marks;
                                $examSubjectMarkIds[] = $mark->id;
                            }
                        }
                        $examTypeMarksArr[$type->id] = $examTypeMarks;
                        $examTotalMarks += $examTypeMarks;
                    }
                @endphp

                <div class="card mt-3">
                    <div class="card-header">Students Results</div>
                    <div class="card-body">
                        @if (!empty($examSubjectMarks->total_marks) && !$examResult->isEmpty())
                            <div class="row">
                                <div class="table m-table table-responsive">
                                    <table class="table table-bordered table-hover sticky-header" id="exam-results">
                                        <thead class="text-center">
                                        <tr>
                                            <th rowspan="2" class="align-middle">Roll No</th>
                                            <th rowspan="2" class="align-middle">Student Name</th>
                                            @foreach ($examTypeSubType as $type)
                                                <th colspan="{{ $type->examSubTypes->count() }}" class="align-middle">
                                                    {{ $type->title }} ({{ $examTypeMarksArr[$type->id] }})
                                                </th>
                                            @endforeach
                                            <th rowspan="2" class="align-middle">Result</th>
                                            <th rowspan="2" class="align-middle">Date</th>
                                            <th rowspan="2" class="align-middle">Comment</th>
                                            <th rowspan="2" class="align-middle">Action</th>
                                        </tr>
                                        <tr>
                                            @foreach ($examTypeSubType as $type)
                                                @foreach ($type->examSubTypes as $subType)
                                                    @php
                                                        $subTypeTotalMarks = $subType->examSubjectMark->sum('total_marks');
                                                    @endphp
                                                    <th class="align-middle">{{ $subType->title }}
                                                        ({{ $subTypeTotalMarks }})
                                                    </th>
                                                @endforeach
                                            @endforeach

                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach ($examResult->groupBy('student_id') as $studentId => $studentResults)
                                            @if (empty($selectedStudentId) || ($selectedStudentId == $studentId))
                                                @php
                                                    $firstResult = $studentResults->first();
                                                    $student = $firstResult->student;
                                                    $totalMarksByExamType = [];
                                                    $totalGrace = 0;
                                                    $failCount = 0;
                                                    $absent = 0;
                                                    $grace = 0;
                                                    $special = 0;
                                                @endphp
                                                <tr>
                                                    <td class="text-center align-middle">{{ $student->roll_no }}</td>
                                                    <td class="align-middle">
                                                        <a href="{{ route('students.show', $student->id) }}">{{ $student->full_name_en }}</a>
                                                    </td>

                                                    @foreach ($studentResults->sortBy('id') as $result)
                                                        @php
                                                            $examTypeId = $result->examSubjectMark->examSubType->examType->id;
                                                            $marks = $result->marks;
                                                            $grace_marks = $result->grace_marks;
                                                            $totalMark = $marks + $grace_marks;
                                                            $totalGrace += $grace_marks;
                                                            $totalMarksByExamType[$examTypeId] = ($totalMarksByExamType[$examTypeId] ?? 0) + $totalMark;

                                                            if ($result->pass_status === 4) {
                                                                $absent++;
                                                            }
                                                            if ($result->grace_marks !== null) {
                                                                $grace++;
                                                            }
                                                            if ($result->special_status !== null) {
                                                                $special++;
                                                            }
                                                        @endphp
                                                        <td class="text-center align-middle">{{ $result->pass_status == 4 ? '-' : $totalMark }}</td>
                                                    @endforeach

                                                    @php
                                                        foreach ($examTypeMarksArr as $key => $typeTotalMark) {
                                                            $typeMark = $totalMarksByExamType[$key] ?? 0;
                                                            $checkPercentage = ($typeMark * 100) / $typeTotalMark;
                                                            if ($passPercentage > $checkPercentage) {
                                                                $failCount++;
                                                            }
                                                        }

                                                        if ($special < 1) {
                                                            if ($absent > 0) {
                                                                $resultStatus = 'Absent';
                                                                $textColor = 'text-warning';
                                                            } elseif ($failCount > 0) {
                                                                $resultStatus = 'Fail';
                                                                $textColor = 'text-danger';
                                                            } elseif ($failCount == 0 && $grace > 0) {
                                                                $resultStatus = "Pass(Grace - $totalGrace)";
                                                                $textColor = 'text-info';
                                                            } else {
                                                                $resultStatus = 'Pass';
                                                                $textColor = 'text-success';
                                                            }
                                                        }else{
                                                            $isSpecialPass = $studentResults->where('special_status', 1)->count() > 0;
                                                            $resultStatus = $isSpecialPass ? 'Pass(SC)' : 'Fail(SC)';
                                                            $textColor = '';
                                                        }
                                                    @endphp

                                                    <td class="text-center align-middle">
                                                        <span class="{{ $textColor}}">{{ $resultStatus }}</span>
                                                    </td>
                                                    <td class="text-center align-middle">
                                                        {{ $firstResult->result_date ?? formatDate($firstResult->created_at, 'd/m/Y') }}
                                                    </td>
                                                    <td class="text-center align-middle">{{ $firstResult->remarks ?: '--' }}</td>
                                                    <td class="text-center align-middle">
                                                        @php    $authUser = Auth::guard('web')->user();
                                                                $examSubject = $examInfo->examSubjects->where('subject_id', $subject->id)->first();
                                                                $isPublish = $examSubject ? $examSubject->result_published : 0;
                                                                $hasHodApproval = $examSubject->hod_edit_permission;
                                                        @endphp
                                                        @if (hasPermission('result/edit'))
                                                            @if ($isPublish == 0 && ($authUser->adminUser || $authUser->teacher))
                                                                <a href="#" class="m-portlet__nav-link btn m-btn m-btn--hover-brand m-btn--icon m-btn--icon-only m-btn--pill modal-student-result"
                                                                   data-exam-id="{{ $examInfo->id }}"
                                                                   data-subject-id="{{ $subject->id }}"
                                                                   data-student-id="{{ $student->id }}" title="Edit">
                                                                    <i class="flaticon-edit"></i>
                                                                </a>
                                                            @elseif (($isPublish == 1 && in_array($authUser->user_group_id, [1, 12]) && $examInfo->exam_category_id == 1) || $hasHodApproval)
                                                                <a href="#" class="m-portlet__nav-link btn m-btn m-btn--hover-brand m-btn--icon m-btn--icon-only m-btn--pill modal-student-result"
                                                                   data-exam-id="{{ $examInfo->id }}"
                                                                   data-subject-id="{{ $subject->id }}"
                                                                   data-student-id="{{ $student->id }}" title="Edit">
                                                                    <i class="flaticon-edit"></i>
                                                                </a>
                                                            @else
                                                                <span>--</span>
                                                            @endif
                                                        @else
                                                            <span>--</span>
                                                        @endif
                                                    </td>
                                                </tr>
                                            @endif
                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        @else
                            <h5 class="text-center text-danger">
                                Please first <a href="{{ route('exams.mark.setup', [$examInfo->id]) }}">setup marks</a>
                                then <a href="{{ route('result.create') }}">publish result!</a>
                            </h5>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>


    <div class="modal fade" id="edit-student-result" role="dialog">
        <div class="modal-dialog modal-lg" role="document">
            <form class="m-form m-form--fit m-form--label-align-right form-validation" action="" method="post"
                  enctype="multipart/form-data" id="update-student-result-form">
                @csrf
                <input type="hidden" name="exam_id" id="exam-id">
                <input type="hidden" name="subject_id" id="subject-id">
                <input type="hidden" name="student_id" id="student-id">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Edit Exam Result</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body pt-2" id="edit-result-modal-body"></div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-brand" data-dismiss="modal"><i
                                    class="fa fa-times"></i> Close
                        </button>
                        <button type="submit" class="btn btn-success update-student-result"><i class="fa fa-save"></i>
                            Save
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection


@push('scripts')

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
                zIndex: 1001,
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

        $(document).on('click', '.toggle-edit-permission', function () {
            const examId = $(this).data('exam-id');
            const subjectId = $(this).data('subject-id');

            $.ajax({
                url: baseUrl + 'admin/result/toggle-edit-permission',
                method: 'POST',
                data: {
                    _token: $('meta[name="csrf-token"]').attr('content'),
                    examId: examId,
                    subjectId: subjectId,
                },
                success: function (response) {
                    if (response.success) {
                        toastr.success(response.message);
                        window.location.reload();
                    } else {
                        toastr.error(response.message);
                    }
                },
                error: function () {
                    toastr.error('An error occurred. Please try again.');
                }
            });
        });

        $(document).on('click', '.modal-student-result', function (e) {
            e.preventDefault();
            examId = $(this).data('exam-id');
            subjectId = $(this).data('subject-id');
            studentId = $(this).data('student-id');

            mApp.blockPage({
                overlayColor: "#000000",
                type: "loader",
                state: "primary",
                message: "Please wait..."
            });

            $.get(baseUrl + 'admin/result/student/edit/' + examId + '/' + subjectId + '/' + studentId, {}, function (response) {
                $('#exam-id').val(examId);
                $('#subject-id').val(subjectId);
                $('#student-id').val(studentId);
                $('#edit-result-modal-body').html(response);
                $('#edit-student-result').modal('show');

                mApp.unblockPage();
            });
        });

        $.validator.addMethod("check_remarks", function (value, element) {
            var flag = true;
            remarkStatus = true;

            $('.exam-remark').each(function () {
                if ($(this).val() == '') {
                    remarkStatus = false;
                }
            });
            if (remarkStatus == false) {
                flag = false;
            }
            return flag;

        }, "Required");

        $.validator.addMethod("check_mark_empty", function (value, element) {
            var flag = true;
            rowStatus = true;

            $('.sub_type_mark').each(function () {
                if (($('.exam-remark').val() == 1) || ($('.exam-remark').val() == 2) || ($('.exam-remark').val() == 3)) {
                    if ($(this).val() == '') {
                        rowStatus = false;
                    }
                }
            });

            if (rowStatus == false) {
                flag = false;
            }
            return flag;

        }, "Required");

        $('.update-student-result').click(function () {

            $.validator.addClassRules('exam-remark', {check_remarks: true});
            $.validator.addClassRules('sub_type_mark', {
                check_mark_empty: function (value, element) {
                    return (($('.exam-remark').val() == 1) || ($('.exam-remark').val() == 2) || ($('.exam-remark').val() == 3))
                },
            });

            $('#update-student-result-form').validate({
                rules: {
                    // remark: {
                    //     required: true,
                    //     min: 1
                    // }
                },
                submitHandler: function (form) {
                    examId = $('#exam-id').val();
                    subjectId = $('#subject-id').val();
                    studentId = $('#student-id').val();

                    $.ajax({
                        type: "POST",
                        url: baseUrl + 'admin/result/student/edit/' + examId + '/' + subjectId + '/' + studentId,
                        data: $(form).serialize(),
                        success: function (response) {
                            if (response.status) {
                                window.location = response.redirect_url;
                            }
                        }
                    });
                    return false;
                }
            });
        });
    </script>
@endpush

