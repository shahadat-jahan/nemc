@php use Illuminate\Support\Str; @endphp
@extends('frontend.layouts.default')
@section('pageTitle', $pageTitle)
@push('style')
    <style>
        .pl0 {
            padding-left: 0;
        }
        .plr0{
            padding-left: 0;
            padding-right: 0;
        }
        .active-link{
            background-color: #f7f8fa;
        }
        .active-link .m-nav__link-icon, .active-link .m-nav__link-text{
            color: #716aca !important;
        }
        .m-separator.m-separator--lg {
            margin: 10px 0 20px;
        }
        .m-widget29 a:hover{
            text-decoration: none;
        }
    </style>
@endpush
@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="m-portlet view-page">
                <div class="m-portlet__head">
                    <div class="m-portlet__head-caption">
                        <div class="m-portlet__head-title">
                            <h3 class="m-portlet__head-text"><i class="fas fa-list-ul fa-md pr-2"></i>Student: {{$student->full_name_en}}</h3>
                        </div>
                    </div>
                    <div class="m-portlet__head-tools">
                        <a href="{{ route('frontend.students.show', $student->id) }}"
                           class="btn btn-primary m-btn m-btn--icon"><i class="fa fa-list"></i> Student</a>
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

                                                @if($student->photo)
                                                    <img src="{{asset($student->photo)}}" alt="Student image">
                                                @else
                                                    <img src="{{asset('assets/global/img/male_avater.png')}}"
                                                         alt="Student image">
                                                @endif
                                            </div>
                                        </div>
                                        <div class="m-card-profile__details">
                                            <span class="m-card-profile__name">{{$student->full_name_en}}</span>
                                            <a href="" class="m-card-profile__email m-link">{{!empty($student->email) ? $student->email : 'N/A'}}</a>
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
                                                <span class="m-nav__link-text">ID : {{$student->student_id}}</span>
                                            </div>
                                        </li>
                                        <li class="m-nav__item">
                                            <div class="m-nav__link">
                                                <i class="m-nav__link-icon fas fa-mobile-alt"></i>
                                                <span
                                                    class="m-nav__link-text">{{!empty($student->mobile) ? $student->mobile : 'N/A'}}</span>
                                            </div>
                                        </li>
                                        <li class="m-nav__item">
                                            <div class="m-nav__link">
                                                <i class="m-nav__link-icon flaticon-calendar-2"></i>
                                                <span class="m-nav__link-text">Session: {{$student->session->title}}</span>
                                            </div>
                                        </li>
                                        <li class="m-nav__item">
                                            <div class="m-nav__link">
                                                <i class="m-nav__link-icon far fa-check-square"></i>
                                                <span class="m-nav__link-text">Status: {{$studentStatus[$student->status]}}</span>
                                            </div>
                                        </li>
                                        <li class="m-nav__item">
                                            <a class="m-nav__link" href="{{route('frontend.students.attendance', [$student->id])}}">
                                                <i class="m-nav__link-icon fa fa-user-tag"></i>
                                                <span class="m-nav__link-text">Attendance</span>
                                            </a>
                                        </li>
                                        <li class="m-nav__item">
                                            <a class="m-nav__link active-link"
                                               href="{{route('frontend.students.card-item', [$student->id])}}">
                                                <i class="m-nav__link-icon fa fa-clipboard-list"></i>
                                                <span class="m-nav__link-text">Card Items</span>
                                            </a>
                                        </li>
                                        <li class="m-nav__item">
                                            <a class="m-nav__link" href="{{route('frontend.students.exam-result', [$student->id])}}">
                                                <i class="m-nav__link-icon fa fa-puzzle-piece"></i>
                                                <span class="m-nav__link-text">Exam Results</span>
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-9 col-lg-8 plr0">
                            <div class="m-portlet m-portlet--full-height m-portlet--tabs ">
                                <div class="m-portlet__head">
                                    <div class="m-portlet__head-tools">
                                        <ul class="nav nav-tabs m-tabs m-tabs-line m-tabs-line--left m-tabs-line--primary" role="tablist">
                                            @foreach($sessionPhases as $phase)
                                            @if($phase->phase_id <= $student->phase_id)
                                            <li class="nav-item m-tabs__item">
                                                <a class="nav-link m-tabs__link phase-cards {{($phase->phase_id == $student->phase_id) ? 'active show' : ''}}" data-toggle="tab" href="#phaseid-{{$phase->phase_id}}"
                                                   role="tab" aria-selected="true" data-phase-id="{{$phase->phase_id}}" data-loaded="{{($phase->phase_id == $student->phase_id) ? 1 : 0}}">
                                                    <i class="flaticon-share m--hide"></i>
                                                    {{$phase->phase->title}}
                                                </a>
                                            </li>
                                            @endif
                                            @endforeach
                                        </ul>
                                    </div>
                                </div>
                                <br>
                                <div class="tab-content">
                                    @foreach($sessionPhases as $phase)
                                        @if($phase->phase_id <= $student->phase_id)
                                        <div class="tab-pane {{($phase->phase_id == $student->phase_id) ? 'active show' : ''}}" id="phaseid-{{$phase->phase_id}}">
                                            @if($phase->phase_id == $student->phase_id)
                                                @foreach($subjects as $subject)
                                                    <div class="card">
                                                        <div class="card-header d-flex justify-content-between">
                                                            <div class="pt-2">{{$subject->title}}</div>
                                                            <div>
                                                                <button class="btn btn-success btn-sm" type="button" data-toggle="collapse"
                                                                        data-target="#collapseStudentCardItems-{{Str::slug($subject->title,'-')}}" aria-expanded="false"
                                                                        aria-controls="collapseStudentCardItems-{{Str::slug($subject->title,'-')}}">
                                                                    Show All
                                                                    <i class="fas fa-chevron-down pt-1"></i>
                                                                </button>
                                                            </div>
                                                        </div>
                                                        <div class="collapse" id="collapseStudentCardItems-{{Str::slug($subject->title,'-')}}">
                                                            <div class="card-body">
                                                                   @foreach($cardItems[$subject->id]->groupBy('term_id')->sortKeys() as $termId => $cards)
                                                                    <div class="row">
                                                                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
                                                                            <div class="row pl-4 pr-4 seperator-title">
                                                                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
                                                                                    <h5 class="m-form__heading-title" style="margin-left: -22px">Term {{$termId}}</h5>
                                                                                </div>
                                                                            </div>
                                                                            <div class="m-separator m-separator--dashed m-separator--lg"></div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="row mb-4">
                                                                    @foreach($cards as $card)
                                                                        <?php
                                                                        $totalItem = $card->cardItems->count();
                                                                        $itemPass = 0;
                                                                        $itemDone = 0;
                                                                        foreach ($card->cardItems as $item){
                                                                            if (!empty($item->examSubjects->count())){
                                                                                if (!empty($item->examSubjects->first()->exam->examMarks->count())){
                                                                                    if (!empty($item->examSubjects->first()->exam->examMarks->first()->result->count())){
                                                                                        $itemDone++;
                                                                                        if ($item->examSubjects->first()->exam->examMarks->first()->result->first()->result_status == 'Pass'){
                                                                                            $itemPass++;
                                                                                        }
                                                                                    }

                                                                                }
                                                                            }
                                                                        }
                                                                        $percentage = !empty($itemDone) ? number_format((($itemPass * 100)/$itemDone), 2) : 0;
                                                                        ?>
                                                                    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                                                                        <div class="m-widget29 border">
                                                                            <a href="{{route(customRoute('students.card-item-detail'), [$student->id, $card->id])}}">
                                                                                <div class="m-widget_content">
                                                                                    <h3 class="m-widget_content-title">{{$card->title}}</h3>
                                                                                    <div class="m-widget_content-items">
                                                                                        <div class="m-widget_content-item">
                                                                                            <span class="text-center">Items</span>
                                                                                            <span class="m--font-brand text-center" style="font-size: 1.3rem;">{{$totalItem}}</span>
                                                                                        </div>
                                                                                        <div class="m-widget_content-item">
                                                                                            <span class="text-center">Taken</span>
                                                                                            <span class="text-center" style="font-size: 1.3rem;">{{$itemDone}}</span>
                                                                                        </div>
                                                                                        <div class="m-widget_content-item">
                                                                                            <span class="text-center">Completed</span>
                                                                                            <span class="text-center" style="font-size: 1.3rem;">{{$itemPass}}</span>
                                                                                        </div>

                                                                                        <div class="m-widget_content-item">
                                                                                            <span>Percent</span>
                                                                                            <span class=" {{($percentage >= 75) ? 'm--font-accent' : 'm--font-danger'}}" style="font-size: 1.3rem;">{{$percentage}}%</span>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="text-center">
                                                                                    <a class="btn btn-success btn-sm btn-block" target="_blank"
                                                                                       href="{{route(customRoute('students.card-item-detail'), [$student->id, $card->id])}}">
                                                                                        Show Items result
                                                                                    </a>
                                                                                </div>
                                                                            </a>

                                                                        </div>
                                                                    </div>
                                                                    @endforeach
                                                                    </div>
                                                                @endforeach
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <br>
                                                @endforeach
                                            @endif
                                        </div>
                                        @endif
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

    <script id="subject-cards" type="text/x-handlebars-template">
        @{{#each subjects}}
        <div class="card">
            <div class="card-header">@{{ title }}</div>
            <div class="card-body">
                @{{#each terms}}
                    <div class="row">
                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
                            <div class="row pl-4 pr-4 seperator-title">
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
                                    <h5 class="m-form__heading-title" style="margin-left: -22px">Term @{{term_id}}</h5>
                                </div>
                            </div>
                            <div class="m-separator m-separator--dashed m-separator--lg"></div>
                        </div>
                    </div>
                    <div class="row mb-4">
                        @{{#each cards}}
                            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                                <div class="m-widget29 border">
                                    <div class="m-widget_content">
                                        <h3 class="m-widget_content-title">@{{ title }}</h3>
                                        <div class="m-widget_content-items">
                                            <div class="m-widget_content-item">
                                                <span>Items</span>
                                                <span class="m--font-brand">@{{ total_items }}</span>
                                            </div>
                                            <div class="m-widget_content-item">
                                                <span>Completed</span>
                                                <span>@{{ item_cleared }}</span>
                                            </div>
                                            <div class="m-widget_content-item">
                                                <span>Percent</span>
                                                <span class="m--font-accent">@{{ percentage }}%</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @{{/each}}
                    </div>
                @{{/each}}

            </div>
        </div>
        <br>
        @{{/each}}
    </script>
    <script>
        var studentId = '{{$student->id}}';

        Handlebars.registerHelper('ifCond', function (v1, operator, v2, options) {

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

        $('.phase-cards').click(function (e) {
            var selected = $(this);
            var divid = $( e.target).attr('href').substr(1);
            var phaseId = $(this).data('phase-id');

            if ($(this).attr('data-loaded') == 0){

                mApp.blockPage({
                    overlayColor: "#000000",
                    type: "loader",
                    state: "primary",
                    message: "Please wait..."
                });

                $.get('{{route('students.card-item.phase', $student->id)}}', {phaseId: phaseId}, function (response) {
                    template   = $('#subject-cards').html();
                    templateData = Handlebars.compile(template);
                    $("#"+divid).html(templateData(response));

                    mApp.unblockPage()
                });


                selected.attr('data-loaded', 1);

            }

        })
    </script>
@endpush
