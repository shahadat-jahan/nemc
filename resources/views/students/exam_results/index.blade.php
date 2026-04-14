@php use Illuminate\Support\Str; @endphp
@extends('layouts.default')
@section('pageTitle', $pageTitle)
@push('style')
    <style>
        .pl0 {
            padding-left: 0;
        }

        .plr0 {
            padding-left: 0;
            padding-right: 0;
        }

        .active-link {
            background-color: #f7f8fa;
        }

        .active-link .m-nav__link-icon,
        .active-link .m-nav__link-text {
            color: #716aca !important;
        }

        .dropdown-toggle::after,
        .btn.dropdown-toggle::after {
            content: "" !important;
        }
    </style>
@endpush
<?php
$categoryId = !empty(app()->request->cat_id) ? app()->request->cat_id : 3;
?>
@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="m-portlet view-page">
                <div class="m-portlet__head">
                    <div class="m-portlet__head-caption">
                        <div class="m-portlet__head-title">
                            <h3 class="m-portlet__head-text"><i class="fas fa-list-ul fa-md pr-2"></i>Student:
                                {{ $student->full_name_en }}</h3>
                        </div>
                    </div>
                    <div class="m-portlet__head-tools">
                        <a href="{{ route('students.index') }}" class="btn btn-primary m-btn m-btn--icon"
                            title="Applicants"><i class="fa fa-list"></i> Students</a>
                    </div>
                </div>

                <div class="m-portlet__body" style="padding: 1.2rem 1.3rem !important;">

                    <div class="row">
                        <div class="col-xl-3 col-lg-4 pl0">
                            <div class="m-portlet m-portlet--full-height  ">
                                <div class="m-portlet__body">
                                    <div class="m-card-profile">
                                        <div class="m-card-profile__title m--hide">
                                            Your Profile
                                        </div>
                                        <div class="m-card-profile__pic">
                                            <div class="m-card-profile__pic-wrapper">

                                                @if ($student->photo)
                                                    <img src="{{ asset($student->photo) }}" alt="Applicant image">
                                                @else
                                                    <img src="{{ asset('assets/global/img/male_avater.png') }}"
                                                        alt="Applicant image">
                                                @endif
                                            </div>
                                        </div>
                                        <div class="m-card-profile__details">
                                            <span class="m-card-profile__name">{{ $student->full_name_en }}</span>
                                            <a href=""
                                                class="m-card-profile__email m-link">{{ !empty($student->email) ? $student->email : 'N/A' }}</a>
                                        </div>
                                    </div>
                                    <ul class="m-nav m-nav--hover-bg m-portlet-fit--sides">
                                        <li class="m-nav__separator m-nav__separator--fit"></li>
                                        <li class="m-nav__section m--hide">
                                            <span class="m-nav__section-text">Section</span>
                                        </li>
                                        <li class="m-nav__item">
                                            <div class="m-nav__link">
                                                <i class="m-nav__link-icon fas fa-calendar-alt"></i>
                                                <span class="m-nav__link-text">ID : {{ $student->student_id }}</span>
                                            </div>
                                        </li>
                                        <li class="m-nav__item">
                                            <div class="m-nav__link">
                                                <i class="m-nav__link-icon fas fa-mobile-alt"></i>
                                                <span
                                                    class="m-nav__link-text">{{ !empty($student->mobile) ? $student->mobile : 'N/A' }}</span>
                                            </div>
                                        </li>
                                        <li class="m-nav__item">
                                            <div class="m-nav__link">
                                                <i class="m-nav__link-icon flaticon-calendar-2"></i>
                                                <span class="m-nav__link-text">Session:
                                                    {{ $student->session->title }}</span>
                                            </div>
                                        </li>
                                        <li class="m-nav__item">
                                            <div class="m-nav__link">
                                                <i class="m-nav__link-icon far fa-check-square"></i>
                                                <span class="m-nav__link-text">Status:
                                                    {{ $studentStatus[$student->status] }}</span>
                                            </div>
                                        </li>
                                        <li class="m-nav__item ">
                                            <a class="m-nav__link"
                                                href="{{ route('students.attendance', [$student->id]) }}">
                                                <i class="m-nav__link-icon fa fa-user-tag"></i>
                                                <span class="m-nav__link-text">Attendance</span>
                                            </a>
                                        </li>
                                        <li class="m-nav__item">
                                            <a class="m-nav__link"
                                                href="{{ route('students.card-item', [$student->id]) }}">
                                                <i class="m-nav__link-icon fa fa-clipboard-list"></i>
                                                <span class="m-nav__link-text">Card Items</span>
                                            </a>
                                        </li>
                                        <li class="m-nav__item">
                                            <a class="m-nav__link active-link"
                                                href="{{ route('students.exam-result', [$student->id]) }}">
                                                <i class="m-nav__link-icon fa fa-puzzle-piece"></i>
                                                <span class="m-nav__link-text">Exam Results</span>
                                            </a>
                                        </li>
                                        <li class="m-nav__item">
                                            <a class="m-nav__link" href="{{ route('students.idCard', [$student->id]) }}">
                                                <i class="m-nav__link-icon fas fa-id-card-alt"></i>
                                                <span class="m-nav__link-text">Print ID Card</span>
                                            </a>
                                        </li>
                                        @if ($student->status == 5)
                                            <li class="m-nav__item">
                                                <a class="m-nav__link"
                                                    href="{{ route('students.testimonial', [$student->id]) }}">
                                                    <i class="m-nav__link-icon far fa-id-card"></i>
                                                    <span class="m-nav__link-text">Print Testimonial</span>
                                                </a>
                                            </li>
                                        @endif
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-9 col-lg-8 plr0">
                            <div class="m-portlet m-portlet--full-height m-portlet--tabs">
                                <div class="m-portlet__head">
                                    <div class="row w-100 m-0 p-0">
                                        <div class="col-xs-12 col-sm-12 col-md-8 col-lg-8 col-xl-8">
                                            <div class="m-portlet__head-tools">
                                                <ul class="nav nav-tabs m-tabs m-tabs-line m-tabs-line--left m-tabs-line--primary"
                                                    role="tablist">
                                                    @foreach ($sessionPhases as $phase)
                                                        {{-- @if ($phase->phase_id <= $student->phase_id) --}}
                                                        <li class="nav-item m-tabs__item">
                                                            <a class="nav-link m-tabs__link phase-results {{ $phase->phase_id == $student->phase_id ? 'active show' : '' }}"
                                                                data-toggle="tab" href="#phaseId-{{ $phase->phase_id }}"
                                                                role="tab" aria-selected="true"
                                                                data-phase-id="{{ $phase->phase_id }}"
                                                                data-loaded="{{ $phase->phase_id == $student->phase_id ? 1 : 0 }}">
                                                                <i class="flaticon-share m--hide"></i>
                                                                {{ $phase->phase->title }}
                                                            </a>
                                                        </li>
                                                        {{-- @endif --}}
                                                    @endforeach
                                                </ul>
                                            </div>
                                        </div>
                                        <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4 col-xl-4 m-0 p-0 text-right">
                                            <div class="m-dropdown m-dropdown--inline  m-dropdown--arrow"
                                                m-dropdown-toggle="click">
                                                <a href="#"
                                                    class="m-dropdown__toggle btn btn-success dropdown-toggle">
                                                    Exam Category: {{ $examCategories[$categoryId] }}
                                                </a>
                                                <div class="m-dropdown__wrapper">
                                                    <span class="m-dropdown__arrow m-dropdown__arrow--left"></span>
                                                    <div class="m-dropdown__inner">
                                                        <div class="m-dropdown__body">
                                                            <div class="m-dropdown__content">
                                                                <ul class="m-nav">
                                                                    <li class="m-nav__section m-nav__section--first">
                                                                        <span class="m-nav__section-text">Select Exam
                                                                            Category</span>
                                                                    </li>
                                                                    @foreach ($examCategories as $key => $category)
                                                                        <li
                                                                            class="m-nav__item {{ $categoryId == $key ? 'active-link' : '' }}">
                                                                            {{--                                                                            <a href="{{url('admin/students/'.$student->id.'/exam-result?cat_id='.$key)}}" --}}
                                                                            {{--                                                                               class="m-nav__link"> --}}
                                                                            <a href="#"
                                                                                class="m-nav__link change-category"
                                                                                data-exam-category-id="{{ $key }}">
                                                                                <i
                                                                                    class="m-nav__link-icon far fa-list-alt"></i>
                                                                                <span
                                                                                    class="m-nav__link-text">{{ $category }}</span>
                                                                            </a>
                                                                        </li>
                                                                    @endforeach
                                                                </ul>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <br>
                                <div class="tab-content">
                                    @foreach ($sessionPhases as $phase)
                                        <div class="tab-pane {{ $phase->phase_id == $student->phase_id ? 'active show' : '' }}"
                                            id="phaseId-{{ $phase->phase_id }}">
                                            @if ($phase->phase_id == $student->phase_id)
                                                @foreach ($subjects as $subject)
                                                    <div class="card">
                                                        <div class="card-header d-flex justify-content-between">
                                                            <div class="pt-2">{{ $subject->title }}</div>
                                                            <div>
                                                                <button class="btn btn-success btn-sm" type="button"
                                                                    data-toggle="collapse"
                                                                    data-target="#collapseStudentExamResult-{{ Str::slug($subject->title, '-') }}"
                                                                    aria-expanded="false"
                                                                    aria-controls="collapseStudentExamResult-{{ Str::slug($subject->title, '-') }}">
                                                                    Show All <i class="fas fa-chevron-down pt-1"></i>
                                                                </button>
                                                            </div>
                                                        </div>
                                                        <div class="collapse"
                                                            id="collapseStudentExamResult-{{ Str::slug($subject->title, '-') }}">
                                                            <div class="card-body">
                                                                <div class="row">
                                                                    <div
                                                                        class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 table-responsive">
                                                                        <table class="table table-bordered table-hover"
                                                                            id="phase{{ $phase->phase_id }}-subject-{{ $subject->id }}">
                                                                            <thead>
                                                                                <tr>
                                                                                    <th class="uppercase">Exam</th>
                                                                                    <th class="uppercase">Term</th>
                                                                                    <th class="uppercase">Total Marks</th>
                                                                                    <th class="uppercase">Result</th>
                                                                                    <th class="uppercase">Comment</th>
                                                                                </tr>
                                                                            </thead>
                                                                            <tbody>
                                                                                @foreach ($examSubjects[$subject->id] as $examSubject)
                                                                                    <tr>
                                                                                        <th>
                                                                                            <a
                                                                                                href="{{ route('exam.subject.result.show', [$examSubject->exam->id, $examSubject->subject_id, $student->id]) }}">
                                                                                                {{ $examSubject->exam->title }}
                                                                                            </a>
                                                                                        </th>
                                                                                        <td>{{ $examSubject->exam->term->title }}
                                                                                        </td>
                                                                                        <td>
                                                                                            @if (!empty($examSubject->exam->examMarks->toArray()))
                                                                                                {{ $examSubject->exam->examMarks->sum('total_marks') }}
                                                                                                /
                                                                                                @if (!empty($examSubject->exam->examMarks->first()->result->toArray()))
                                                                                                    @php
                                                                                                        $total = 0;
                                                                                                        $examTotalMarks = 0;
                                                                                                        $examTypeMarks = 0;
                                                                                                        $examTypeMarksArr = [];
                                                                                                        $totalMarksByExamType = [];

                                                                                                        foreach (
                                                                                                            $examSubject
                                                                                                                ->exam
                                                                                                                ->examMarks
                                                                                                            as $examMark
                                                                                                        ) {
                                                                                                            $examTypeId =
                                                                                                                $examMark
                                                                                                                    ->examSubType
                                                                                                                    ->examType
                                                                                                                    ->id ??
                                                                                                                null;
                                                                                                            if (
                                                                                                                $examTypeId &&
                                                                                                                !isset(
                                                                                                                    $totalMarksByExamType[
                                                                                                                        $examTypeId
                                                                                                                    ],
                                                                                                                )
                                                                                                            ) {
                                                                                                                $totalMarksByExamType[
                                                                                                                    $examTypeId
                                                                                                                ] = 0;
                                                                                                            }
                                                                                                            foreach (
                                                                                                                $examMark->result
                                                                                                                as $result
                                                                                                            ) {
                                                                                                                $marks =
                                                                                                                    $result->marks +
                                                                                                                    $result->grace_marks;
                                                                                                                $total += $marks;
                                                                                                                if (
                                                                                                                    $examTypeId
                                                                                                                ) {
                                                                                                                    $totalMarksByExamType[
                                                                                                                        $examTypeId
                                                                                                                    ] += $marks;
                                                                                                                }
                                                                                                            }

                                                                                                            if (
                                                                                                                $examTypeId
                                                                                                            ) {
                                                                                                                $examTypeMarksArr[
                                                                                                                    $examTypeId
                                                                                                                ] = isset(
                                                                                                                    $examTypeMarksArr[
                                                                                                                        $examTypeId
                                                                                                                    ],
                                                                                                                )
                                                                                                                    ? $examTypeMarksArr[
                                                                                                                            $examTypeId
                                                                                                                        ] +
                                                                                                                        $examMark->total_marks
                                                                                                                    : $examMark->total_marks;
                                                                                                            }
                                                                                                        }
                                                                                                    @endphp
                                                                                                @endif
                                                                                                {{ $total }}
                                                                                            @endif
                                                                                        </td>
                                                                                        <td>
                                                                                            @php
                                                                                                $passPercentage = Setting::getSiteSetting()
                                                                                                    ->pass_mark;
                                                                                                $examMarks =
                                                                                                    $examSubject->exam
                                                                                                        ->examMarks;

                                                                                                // Calculate all status counts and totals once
                                                                                                $resultStatus = '';
                                                                                                $textColor = '';
                                                                                                $special = $examMarks
                                                                                                    ->first()
                                                                                                    ->result->whereNotNull(
                                                                                                        'special_status',
                                                                                                    )
                                                                                                    ->count();
                                                                                                $absent = $examMarks
                                                                                                    ->first()
                                                                                                    ->result->where(
                                                                                                        'pass_status',
                                                                                                        4,
                                                                                                    )
                                                                                                    ->count();
                                                                                                $grace = $examMarks
                                                                                                    ->first()
                                                                                                    ->result->whereNotNull(
                                                                                                        'grace_marks',
                                                                                                    )
                                                                                                    ->count();
                                                                                                $totalGrace = $examMarks
                                                                                                    ->first()
                                                                                                    ->result->sum(
                                                                                                        'grace_marks',
                                                                                                    );
                                                                                                $failCount = 0;

                                                                                                // Handle special cases first
                                                                                                if ($special > 0) {
                                                                                                    $isSpecialPass =
                                                                                                        $examMarks
                                                                                                            ->first()
                                                                                                            ->result->where(
                                                                                                                'special_status',
                                                                                                                1,
                                                                                                            )
                                                                                                            ->count() >
                                                                                                        0;
                                                                                                    $resultStatus = $isSpecialPass
                                                                                                        ? 'Pass(SC)'
                                                                                                        : 'Fail(SC)';
                                                                                                    $textColor = $isSpecialPass
                                                                                                        ? 'text-info'
                                                                                                        : 'text-danger';
                                                                                                } else {
                                                                                                    // Calculate pass/fail based on percentages - only needed if not special case
                                                                                                    foreach (
                                                                                                        $examTypeMarksArr
                                                                                                        as $key =>
                                                                                                            $totalPossibleMarks
                                                                                                    ) {
                                                                                                        if (
                                                                                                            $totalPossibleMarks >
                                                                                                            0
                                                                                                        ) {
                                                                                                            $actualMarks =
                                                                                                                $totalMarksByExamType[
                                                                                                                    $key
                                                                                                                ] ?? 0;
                                                                                                            $percentage =
                                                                                                                ($actualMarks *
                                                                                                                    100) /
                                                                                                                $totalPossibleMarks;

                                                                                                            if (
                                                                                                                $passPercentage >
                                                                                                                $percentage
                                                                                                            ) {
                                                                                                                $failCount++;
                                                                                                                break; // Exit early if we find a failure
                                                                                                            }
                                                                                                        }
                                                                                                    }

                                                                                                    // Determine final status
                                                                                                    if ($absent > 0) {
                                                                                                        $resultStatus =
                                                                                                            'Absent';
                                                                                                        $textColor =
                                                                                                            'text-warning';
                                                                                                    } elseif (
                                                                                                        $failCount > 0
                                                                                                    ) {
                                                                                                        $resultStatus =
                                                                                                            'Fail';
                                                                                                        $textColor =
                                                                                                            'text-danger';
                                                                                                    } elseif (
                                                                                                        $grace > 0
                                                                                                    ) {
                                                                                                        $resultStatus = "Pass(Grace - $totalGrace)";
                                                                                                        $textColor =
                                                                                                            'text-info';
                                                                                                    } else {
                                                                                                        $resultStatus =
                                                                                                            'Pass';
                                                                                                        $textColor =
                                                                                                            'text-success';
                                                                                                    }
                                                                                                }
                                                                                            @endphp
                                                                                            <span
                                                                                                class="{{ $textColor }}">{{ $resultStatus }}</span>
                                                                                        </td>
                                                                                        <td>
                                                                                            @if (!empty($examSubject->exam->examMarks->first()->result->toArray()))
                                                                                                {{ $examSubject->exam->examMarks->first()->result->first()->remarks }}
                                                                                            @endif
                                                                                        </td>
                                                                                    </tr>
                                                                                @endforeach
                                                                            </tbody>
                                                                        </table>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <br>
                                                @endforeach
                                            @endif
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="//cdnjs.cloudflare.com/ajax/libs/handlebars.js/4.1.0/handlebars.min.js"></script>

    <script id="exam-results" type="text/x-handlebars-template">
        @verbatim
        {{#each subjects}}
        <div class="card">
            <div class="card-header d-flex justify-content-between">
                <div class="pt-2">{{ title }}</div>
                <div>
                    <button class="btn btn-success btn-sm" type="button" data-toggle="collapse"
                            data-target="#collapseStudentExamResult{{ id }}" aria-expanded="false"
                            aria-controls="collapseStudentExamResult{{ title }}">
                        Show All <i class="fas fa-chevron-down pt-1"></i>
                    </button>
                </div>
            </div>
            <div class="collapse" id="collapseStudentExamResult{{ id }}">
                <div class="card-body">
                    <div class="row">
                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 table-responsive">
                            <table class="table table-bordered table-hover" id='phase{{ phase_id }}-subject-{{ id }}'>
                                <thead>
                                <tr>
                                    <th class="uppercase">Exam</th>
                                    <th class="uppercase">Term</th>
                                    <th class="uppercase">Total Marks</th>
                                    <th class="uppercase">Result</th>
                                    <th class="uppercase">Comment</th>
                                    <th class="uppercase">Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                {{#each examSubjects}}
                                <tr>
                                    <th><a href='{{ result_url }}'>{{ title }}</a></th>
                                    <td>{{ term }}</td>
                                    <td>{{ total_marks }}</td>
                                    <td><span class='{{ textColor }}'>{{ resultStatus }}</span></td>
                                    <td>{{ remark }}</td>
                                    <td>{{ action }}</td>
                                </tr>
                                {{/each}}
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <br>
        {{/each}}
        @endverbatim
    </script>
    <script>
        var studentId = '{{ $student->id }}';
        var examCategoryId = '{{ $categoryId }}';

        Handlebars.registerHelper('ifCond', function(v1, operator, v2, options) {

            switch (operator) {
                case '==':
                    return (v1 == v2) ? options.fn(this) : options.inverse(this);
                case '===':
                    return (v1 === v2) ? options.fn(this) : options.inverse(this);
                case '!=':
                    return (v1 != v2) ? options.fn(this) : options.inverse(this);
                case '!==':
                    return (v1 !== v2) ? options.fn(this) : options.inverse(this);
                case '<':
                    return (v1 < v2) ? options.fn(this) : options.inverse(this);
                case '<=':
                    return (v1 <= v2) ? options.fn(this) : options.inverse(this);
                case '>':
                    return (v1 > v2) ? options.fn(this) : options.inverse(this);
                case '>=':
                    return (v1 >= v2) ? options.fn(this) : options.inverse(this);
                case '&&':
                    return (v1 && v2) ? options.fn(this) : options.inverse(this);
                case '||':
                    return (v1 || v2) ? options.fn(this) : options.inverse(this);
                default:
                    return options.inverse(this);
            }
        });

        $('.phase-results').click(function(e) {
            e.preventDefault();

            var selected = $(this);
            var divId = $(e.target).attr('href').substr(1);
            var phaseId = $(this).data('phase-id');
            var categoryId = $('.m-nav__item.active-link .change-category').data('exam-category-id');

            if ($(this).attr('data-loaded') == 0) {

                mApp.blockPage({
                    overlayColor: "#000000",
                    type: "loader",
                    state: "primary",
                    message: "Please wait..."
                });

                $.get('{{ route('students.xam-result.phase', $student->id) }}', {
                    phaseId: phaseId,
                    cat_id: categoryId
                }, function(response) {
                    template = $('#exam-results').html();
                    templateData = Handlebars.compile(template);
                    $("#" + divId).html(templateData(response));

                    mApp.unblockPage()
                });

                selected.attr('data-loaded', 1);
            }
        });

        $('.change-category').click(function(e) {
            e.preventDefault();

            $(this).parent('li').siblings('.active-link').removeClass('active-link');
            $(this).parent('li').addClass('active-link');

            examCategory = $(this).find('span').text();
            divId = $(".nav-item .active").attr("href");
            phaseId = $(".nav-item .active").data('phase-id');
            categoryId = $(this).data('exam-category-id');
            $('.dropdown-toggle').text('Exam Category: ' + examCategory);

            mApp.blockPage({
                overlayColor: "#000000",
                type: "loader",
                state: "primary",
                message: "Please wait..."
            });

            $.get('{{ route('students.xam-result.phase', $student->id) }}', {
                phaseId: phaseId,
                cat_id: categoryId
            }, function(response) {
                template = $('#exam-results').html();
                templateData = Handlebars.compile(template);
                $(divId).html(templateData(response));

                mApp.unblockPage()
            });

        });
    </script>
@endpush
