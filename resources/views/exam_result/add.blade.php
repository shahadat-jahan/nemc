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
                <a href="{{ route('result.index') }}" class="btn btn-primary m-btn m-btn--icon"><i
                        class="far fa-list-alt pr-2"></i>Exams</a>
            </div>
        </div>

        <!--begin::Form-->
        <form class="m-form m-form--fit m-form--label-align-right" action="{{ route('result.store') }}" method="post"
              id="nemc-general-form"
              enctype="multipart/form-data">
            @csrf
            <div class="m-portlet__body">
                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                        <div class="form-group  m-form__group {{ $errors->has('session_id') ? 'has-danger' : '' }}">
                            <label class="form-control-label"><span class="text-danger">*</span> Session </label>
                            <select class="form-control m-input" name="session_id" id="session_id">
                                <option value="">-- Select Session --</option>
                                {!! select($sessions) !!}
                            </select>
                            @if ($errors->has('session_id'))
                                <div class="form-control-feedback">{{ $errors->first('session_id') }}</div>
                            @endif
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                        <div class="form-group  m-form__group {{ $errors->has('course_id') ? 'has-danger' : '' }}">
                            <label class="form-control-label"><span class="text-danger">*</span> Course </label>
                            <select class="form-control m-input" name="course_id" id="course_id">
                                <option value="">-- Select Course --</option>
                                {!! select($courses, Auth::user()->teacher->course_id ?? '') !!}
                            </select>
                            @if ($errors->has('course_id'))
                                <div class="form-control-feedback">{{ $errors->first('course_id') }}</div>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                        <div class="form-group  m-form__group {{ $errors->has('phase_id') ? 'has-danger' : '' }}">
                            <label class="form-control-label"><span class="text-danger">*</span> Phase </label>
                            <select class="form-control m-input" name="phase_id" id="phase_id">
                                <option value="">-- Select Phase --</option>
                                {!! select($phases) !!}
                            </select>
                            @if ($errors->has('phase_id'))
                                <div class="form-control-feedback">{{ $errors->first('phase_id') }}</div>
                            @endif
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                        <div class="form-group  m-form__group {{ $errors->has('term_id') ? 'has-danger' : '' }}">
                            <label class="form-control-label"><span class="text-danger">*</span> Term </label>
                            <select class="form-control m-input" name="term_id" id="term_id">
                                <option value="">-- Select Term --</option>
                            </select>
                            @if ($errors->has('term_id'))
                                <div class="form-control-feedback">{{ $errors->first('term_id') }}</div>
                            @endif
                        </div>
                    </div>
                    <!--                    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                        <div class="form-group  m-form__group {{ $errors->has('term_id') ? 'has-danger' : '' }}">
                            <label class="form-control-label"><span class="text-danger">*</span> Term </label>
                            <select class="form-control m-input" name="term_id" id="term_id">
                                <option value="">-- Select Term --</option>
                                {!! select($terms) !!}
                    </select>
{{--                    @if ($errors->has('term_id'))--}}
                    <div class="form-control-feedback">{{ $errors->first('term_id') }}</div>


{{--                    @endif--}}
                    </div>
                </div>-->
                </div>
                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                        <div
                            class="form-group  m-form__group {{ $errors->has('exam_category_id') ? 'has-danger' : '' }}">
                            <label class="form-control-label"><span class="text-danger">*</span> Exam Category </label>
                            <select class="form-control m-input" name="exam_category_id" id="exam_category_id">
                                <option value="">-- Select Exam Category --</option>
                                {!! select($examCategories) !!}
                            </select>
                            @if ($errors->has('exam_category_id'))
                                <div class="form-control-feedback">{{ $errors->first('exam_category_id') }}</div>
                            @endif
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                        <div class="form-group  m-form__group {{ $errors->has('exam_id') ? 'has-danger' : '' }}">
                            <label class="form-control-label"><span class="text-danger">*</span> Exam
                            </label>
                            <select class="form-control m-input" name="exam_id" id="exam_id">
                                <option value="">-- Select Exam --</option>

                            </select>
                            @if ($errors->has('exam_id'))
                                <div class="form-control-feedback">{{ $errors->first('exam_id') }}</div>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                        <div class="form-group  m-form__group {{ $errors->has('subject_id') ? 'has-danger' : '' }}">
                            <label class="form-control-label"><span class="text-danger">*</span> Subject </label>
                            <select class="form-control m-input" name="subject_id" id="subject_id">
                                <option value="">-- Select Subject --</option>
                            </select>
                            @if ($errors->has('subject_id'))
                                <div class="form-control-feedback">{{ $errors->first('subject_id') }}</div>
                            @endif
                        </div>
                    </div>
                    @if(Auth::guard('web')->user()->user_group_id != 4)
                        <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                            <div class="form-group  m-form__group {{ $errors->has('teacher_id') ? 'has-danger' : '' }}">
                                <label class="form-control-label"><span class="text-danger">*</span> Teacher </label>
                                <select class="form-control m-input m-bootstrap-select m_selectpicker" name="teacher_id"
                                        id="teacher_id" data-live-search="true">
                                    <option value="">---- Select Teacher ----</option>
                                </select>
                                @if ($errors->has('teacher_id'))
                                    <div class="form-control-feedback">{{ $errors->first('teacher_id') }}</div>
                                @endif
                            </div>
                        </div>
                    @else
                        <input type="hidden" name="teacher_id" value="{{Auth::guard('web')->user()->teacher->id}}">
                    @endif
                </div>
                <!-- For admins and department head -->
                <div class="row">
                    @php $authUser = Auth::guard('web')->user(); @endphp
                    @if($authUser->adminUser || $authUser->user_group_id == 12)
                        <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                            <div class="form-group  m-form__group {{ $errors->has('subject_id') ? 'has-danger' : '' }}">
                                <div class="m-checkbox-inline">
                                    <label class="m-checkbox">
                                        <input type="checkbox" name="publish_result" value="1"> Publish result for this
                                        subject?
                                        <span></span>
                                    </label>
                                </div>
                                <small class="text-danger">Once published, result is no longer editable.</small>
                                @if ($errors->has('subject_id'))
                                    <div class="form-control-feedback">{{ $errors->first('subject_id') }}</div>
                                @endif
                            </div>
                        </div>
                    @endif
                    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                        <div class="form-group m-form__group {{ $errors->has('subject_id') ? 'has-danger' : '' }}">
                            <label class="form-control-label" for="sheet">Select file (Excel)</label>
                            <input class="form-control m-input" type="file" name="sheet" id="sheet"
                                   accept=".xls,.xlsx,application/vnd.ms-excel,application/vnd.openxmlformats-officedocument.spreadsheetml.sheet">
                            <button id="download-excel-btn" class="btn btn-primary mt-2 d-none">
                                Download Excel
                            </button>
                        </div>
                    </div>
                </div>

                {{--<div class="m-separator m-separator--dashed m-separator--lg" style="width: 100%"></div>--}}
                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
                        <div class="m-separator m-separator--dashed m-separator--lg"></div>
                        <div class="row pl-4 pr-4 seperator-title">
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
                                <h4 class="m-form__heading-title" style="margin-left: -22px">Students</h4>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row" id="all-students">
                    <div class="m-table table-responsive">
                        <table class="table table-bordered table-hover sticky-header" id="exam-results">
                            <thead class="text-center"></thead>
                            <tbody></tbody>
                        </table>
                    </div>
                </div>

            </div>
            <div class="m-form__actions text-center">
                <div class="m-form__actions">
                    <a href="{{ route('result.index') }}" class="btn btn-outline-brand"><i class="fa fa-times"></i>
                        Cancel</a>
                    <button id="saveButton" type="submit" class="btn btn-success"><i class="fa fa-save"></i> Save
                    </button>
                </div>
            </div>
        </form>

        <!--end::Form-->
    </div>
@endsection

@push('scripts')

    <script src="//cdnjs.cloudflare.com/ajax/libs/lodash.js/4.17.11/lodash.min.js" type="text/javascript"></script>

    <script>
        var csrf_token = $('meta[name="csrf-token"]').attr('content');
        var phaseInfo = [];
        var total_terms = '';
        var selectedPhase = '';

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

        function toggleSaveButton() {
            let hasMark = false;

            // Check if any mark field is filled
            $('.sub_type_mark').each(function () {
                if ($(this).val().trim() !== '') {
                    hasMark = true;
                }
            });

            // Check if a file is uploaded
            let hasFile = $('#sheet').get(0).files.length > 0;

            // Enable button if either mark or file is present
            if (hasMark || hasFile) {
                $('#saveButton').prop('disabled', false).css('cursor', 'pointer');
            } else {
                $('#saveButton').prop('disabled', true).css('cursor', 'not-allowed');
            }
        }

        // Trigger toggle on input change
        $(document).on('input', '.sub_type_mark', function () {
            toggleSaveButton();
        });

        // Trigger toggle on file change
        $(document).on('change', '#sheet', function () {
            toggleSaveButton();
        });

        // Initial check on a page load
        $(document).ready(function () {
            toggleSaveButton();
        });

        $('#course_id, #session_id').change(function () {
            courseId = $('#course_id').val();
            sessionId = $('#session_id').val();
            $.get('{{route('phase.term.list')}}', {sessionId: sessionId, courseId: courseId}, function (response) {
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

            selectedPhase = _.find(phaseInfo, function (o) {
                return o.phase.id == phaseId;
            });

            console.log(selectedPhase);
            if (selectedPhase) {
                console.log(`x === undefined`)
                totalTerms = selectedPhase.total_terms;
            } else {
                console.log(`x !== undefined`)
                totalTerms = ''
            }

            $('#term_id').html('<option value="">-- Select Term --</option>');
            for (var i = 1; i <= totalTerms; i++) {
                $('#term_id').append('<option value="' + i + '"> Term ' + i + '</option>')
            }
            mApp.unblockPage();
        });

        $('#session_id, #course_id, #phase_id, #term_id, #exam_category_id').change(function () {
            sessionId = $('#session_id').val();
            courseId = $('#course_id').val();
            phaseId = $('#phase_id').val();
            termId = $('#term_id').val();
            examCategoryId = $('#exam_category_id').val();

            if (sessionId > 0 && courseId > 0 && phaseId > 0 && termId > 0 && examCategoryId > 0) {
                mApp.blockPage({
                    overlayColor: "#000000",
                    type: "loader",
                    state: "primary",
                    message: "Please wait..."
                });

                $.get('{{route('exam.list.session.course.phase.term.type')}}', {
                    sessionId: sessionId,
                    courseId: courseId,
                    phaseId: phaseId,
                    termId: termId,
                    examCategoryId: examCategoryId,
                    type: 'result',
                }, function (response) {
                    $('#exam_id_error').remove();
                    // Clear the existing options and add the default one
                    $('#exam_id').html('<option value="">-- Select Exam --</option>');
                    if (response.exams && response.exams.length > 0) {
                        // Append exams to the select dropdown
                        response.exams.forEach(function (exam) {
                            $('#exam_id').append('<option value="' + exam.id + '">' + exam.title + '</option>');
                        });
                    } else {
                        if ($('#exam_id').parent().find('#exam_id_error').length === 0) {
                            $('#exam_id').parent().append('<span id="exam_id_error" class="text-danger">No unpublished exams found.</span>');
                        }
                    }
                    mApp.unblockPage()
                });
            }
        });

        $('#exam_id').change(function () {
            if ($(this).val() > 0) {
                mApp.blockPage({
                    overlayColor: "#000000",
                    type: "loader",
                    state: "primary",
                    message: "Please wait..."
                });

                $.get('{{route('subjects.list.examId')}}', {examId: $(this).val()}, function (response) {
                    if (response.subjects) {
                        $('#subject_id').html('<option value="">-- Select Subject --</option>');
                        for (i in response.subjects) {
                            subject = response.subjects[i];
                            $('#subject_id').append('<option value="' + subject.id + '">' + subject.title + '</option>')
                        }
                    }
                    mApp.unblockPage()
                });
            }
        });

        $('#subject_id').change(function () {
            if ($(this).val() > 0) {
                var subjectId = $(this).val();
                mApp.blockPage({
                    overlayColor: "#000000",
                    type: "loader",
                    state: "primary",
                    message: "Please wait..."
                });
                // get teachers of this subject
                $.get('{{route('teacher.list.subject')}}', {subjectId: subjectId}, function (response) {
                    if (response.data) {
                        $("#teacher_id").html('<option value="">----Select Teacher----</option>');
                        if (response.data.length > 0) {
                            for (i in response.data) {
                                teacher = response.data[i];
                                $("#teacher_id").append('<option value="' + teacher.id + '">' + teacher.full_name + '</option>');
                            }
                        }
                        $("#teacher_id").selectpicker('refresh');
                    }
                })

                // get subject marks
                var ajax1 = $.get('{{route('exam-types-subtypes.list.examId.subjectId')}}', {
                        examId: $('#exam_id').val(),
                        subjectId: $(this).val()
                    }, function (response) {
                        if (response.data) {
                            tableHead = '<tr>';
                            tableHead += '<th rowspan="2" class="align-middle">Roll No</th>';
                            tableHead += '<th rowspan="2" class="align-middle">Student Name</th>';

                            for (i in response.data) {
                                row = response.data[i];
                                colspan = (row.exam_sub_types.length > 0) ? parseInt(row.exam_sub_types.length) : ''
                                examTypeMarks = 0;
                                if ((row.exam_sub_types.length > 0)) {
                                    for (j in row.exam_sub_types) {
                                        if (row.exam_sub_types[j].exam_subject_mark.length > 0) {
                                            for (k in row.exam_sub_types[j].exam_subject_mark) {
                                                examTypeMarks = parseInt(examTypeMarks) + parseInt(row.exam_sub_types[j].exam_subject_mark[k].total_marks);
                                            }
                                        }
                                    }
                                }
                                tableHead += '<th colspan="' + colspan + '" class="align-middle">' + row.title + ' (' + examTypeMarks + ')</th>';
                            }
                            // tableHead += '<th rowspan="2">Grand Total</th><th rowspan="2">Remark</th>';
                            tableHead += '<th rowspan="2" class="align-middle">Comment</th>';
                            tableHead += '</tr>';

                            tableHead2 = '<tr>';

                            for (i in response.data) {
                                row = response.data[i];
                                colspan = (row.exam_sub_types.length > 0) ? row.exam_sub_types.length : '';
                                examTypeMarks = 0;
                                if ((row.exam_sub_types.length > 0)) {
                                    for (j in row.exam_sub_types) {
                                        subType = row.exam_sub_types[j];
                                        subTypeMark = 0;
                                        if (subType.exam_subject_mark.length > 0) {
                                            for (k in subType.exam_subject_mark) {
                                                subTypeMark = parseInt(subTypeMark) + parseInt(subType.exam_subject_mark[k].total_marks);
                                            }
                                        }

                                        tableHead2 += '<th class="align-middle">' + subType.title + ' (' + subTypeMark + ')</th>';
                                    }
                                    // tableHead2 += '<th>Total</th>';
                                }

                            }

                            tableHead2 += '</tr>';
                        }

                        $('#exam-results thead').html(tableHead);
                        $('#exam-results thead').append(tableHead2);

                    }),

                    ajax2 = $.get('{{route('students.list.session.course.phase.term')}}',
                        {
                            sessionId: $('#session_id').val(),
                            courseId: $('#course_id').val(),
                            phaseId: $('#phase_id').val(),
                            examId: $('#exam_id').val(),
                            subjectId: $('#subject_id').val()
                        },
                        function (response) {
                            mApp.unblockPage();
                        });

                $.when(ajax1, ajax2).done(function (req1, req2) {
                    $('#downloadExcel').prop('disabled', false).removeClass('not-allowed');
                    examMarkStatus = true;
                    for (x in req1[0].data) {
                        examType = req1[0].data[x];
                        if ((examType.exam_sub_types.length > 0)) {
                            if (examType.exam_sub_types[0].exam_subject_mark.length == 0) {
                                examMarkStatus = false;
                            }
                        }
                    }

                    if (examMarkStatus == false) {
                        sweetAlert('Please setup exam marks of this subject first', 'error');
                        return false;
                    }

                    if (req2[0].students) {
                        studentHtml = '';
                        for (i in req2[0].students) {
                            student = req2[0].students[i];

                            studentId = student.id;
                            studentRoute = '{{ route("students.show", ":id") }}';
                            studentRoute = studentRoute.replace(':id', studentId);
                            studentHtml += '<tr>';
                            studentHtml += '<td class="text-center align-middle">' + student.roll_no + '<input type="hidden" class="form-control m-input" name="student_id[' + student.id + ']" value="' + student.id + '"/></td>';
                            studentHtml += '<td class="align-middle"><a href="' + studentRoute + '" target="_blank">' + student.full_name_en + ' </a></td>';

                            for (k in req1[0].data) {
                                row = req1[0].data[k];
                                if ((row.exam_sub_types.length > 0)) {
                                    for (j in row.exam_sub_types) {
                                        subType = row.exam_sub_types[j];
                                        if (subType.exam_subject_mark.length > 0) {
                                            for (l in subType.exam_subject_mark) {
                                                markRow = subType.exam_subject_mark[l];
                                                studentHtml += '<td><div class="form-group m-form__group"><input type="number" class="form-control m-input sub_type_mark" min="0" max="' + markRow.total_marks + '" name="sub_type_mark[' + student.id + '][' + markRow.id + ']" autocomplete="off"/></div></td>';
                                            }
                                        }
                                    }
                                }
                            }
                            studentHtml += '<td><div class="form-group  m-form__group"><input type="text" class="form-control m-input w-100 comment" name="comment[' + student.id + ']"/></div></td>';

                            studentHtml += '</tr>';
                        }
                        $('#exam-results tbody').html(studentHtml);
                        $(".sticky-header").floatThead({scrollingTop: 70});
                        $('#download-excel-btn').removeClass('d-none');
                    }
                });
                mApp.unblockPage();
            } else {
                $('#download-excel-btn').addClass('d-none');
            }
        });

        $('#download-excel-btn').click(function () {
            let button = $(this);
            let examTitle = $("#exam_id option:selected").text();
            let subjectTitle = $("#subject_id option:selected").text();
            button.prop('disabled', true).addClass('not-allowed').text('Downloading...');
            $.ajax({
                url: '{{ route("export.exam.results") }}',
                method: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    sessionId: sessionId,
                    courseId: courseId,
                    phaseId: phaseId,
                    termId: termId,
                    examCategoryId: examCategoryId,
                    examId: $('#exam_id').val(),
                    subjectId: $('#subject_id').val()
                },
                xhrFields: {
                    responseType: 'blob' // This ensures the response is handled as a file (blob)
                },
                success: function (response, status, xhr) {
                    // Create a link element
                    var a = document.createElement('a');
                    var blob = response;
                    var url = window.URL.createObjectURL(blob);
                    a.href = url;
                    a.download = examTitle + ' - ' + subjectTitle + ' Results.xlsx'; // Set the download file name
                    document.body.appendChild(a);
                    a.click(); // Trigger the download
                    document.body.removeChild(a); // Clean up by removing the link element
                    window.URL.revokeObjectURL(url); // Release the object URL
                },
                error: function (xhr) {
                    console.error('Error:', xhr.responseJSON.message);
                },
                complete: function () {
                    button.prop('disabled', false).removeClass('not-allowed').text('Download Excel');
                }
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

            $('.exam-remark').each(function () {
                if (($(this).val() == 1) || ($(this).val() == 2) || ($(this).val() == 3)) {
                    tableRow = $(this).parents('tr');
                    tableRow.find('.sub_type_mark').each(function () {
                        if ($(this).val() == '') {
                            rowStatus = false;
                        }
                    })
                }
            });

            if (rowStatus == false) {
                flag = false;
            }
            return flag;

        }, "Required");

        $.validator.addClassRules('exam-remark', {check_remarks: true});
        $.validator.addClassRules('sub_type_mark', {
            check_mark_empty: function (value, element) {
                return (($(value).parents('tr').find('.exam-remark').val() == 1) || ($(value).parents('tr').find('.exam-remark').val() == 2) || ($(value).parents('tr').find('.exam-remark').val() == 3))
            },
        });

        $('#nemc-general-form').validate({
            rules: {
                session_id: {
                    required: true,
                    min: 1
                },
                course_id: {
                    required: true,
                    min: 1
                },
                phase_id: {
                    required: true,
                    min: 1
                },
                term_id: {
                    required: true,
                    min: 1
                },
                exam_category_id: {
                    required: true,
                    min: 1
                },
                exam_id: {
                    required: true,
                    min: 1
                },
                subject_id: {
                    required: true,
                    min: 1,
                    remote: {
                        url: "{{route('result.publish.check')}}",
                        type: "post",
                        data: {
                            exam_id: function () {
                                return $("#exam_id").val();
                            },
                            subject_id: function () {
                                return $("#subject_id").val();
                            },
                            _token: "{{ csrf_token() }}",
                        }
                    }
                },
                teacher_id: {
                    required: true,
                    min: 1
                }
            },
            messages: {
                subject_id: {
                    remote: 'Marks already provided for this subject\'s exam'
                }
            },
            submitHandler: function (form) {
                $("#saveButton")
                    .prop("disabled", true)
                    .html('<i class="fa fa-spinner fa-spin"></i> Processing...')
                    .css('cursor', 'not-allowed');
                form.submit();
            },
            invalidHandler: function () {
                // If validation fails, re-enable the button
                $("#saveButton")
                    .prop("disabled", false)
                    .html('<i class="fa fa-save"></i> Save')
                    .css('cursor', 'pointer');
            }
        });

        //count total marks of a student for a table row
        $(document).on('change', 'table input[type=number]', function () {
            var $tr = $(this).closest('tr');
            var tot = 0;

            $('input[type=number]', $tr).each(function () {
                tot += Number($(this).val()) || 0;
            });
            console.log(tot);
        }).trigger('input[type=number]');
    </script>
@endpush
