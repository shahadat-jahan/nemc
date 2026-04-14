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
        .widget24__title{
            margin-top: 0;
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
                        <a href="{{ route('frontend.students.view', $student->id) }}"
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
                                            <a class="m-nav__link active-link"
                                               href="{{route('frontend.students.attendance', [$student->id])}}">
                                                <i class="m-nav__link-icon fa fa-user-tag"></i>
                                                <span class="m-nav__link-text">Attendance</span>
                                            </a>
                                        </li>
                                        <li class="m-nav__item">
                                            <a class="m-nav__link" href="{{route('frontend.students.card-item', [$student->id])}}">
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
                                                <a class="nav-link m-tabs__link phase-attendance {{($phase->phase_id == $student->phase_id) ? 'active show' : ''}}" data-toggle="tab" href="#phaseid-{{$phase->phase_id}}"
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
                                                    <?php
                                                    $hideClass = '';
                                                    $percentLecture = 0;
                                                    $percentTutorial = 0;
                                                    $percentTotal = 0;
                                                    if (!empty($totalLectureClass[$subject->id])){
                                                        $percentLecture = round((($totalLectureClassAttend[$subject->id] * 100) / $totalLectureClass[$subject->id]), 2);
                                                    }
                                                    if (!empty($totalTutorialClass[$subject->id])){
                                                        $percentTutorial = round((($totalTutorialClassAttend[$subject->id] * 100) / $totalTutorialClass[$subject->id]), 2);
                                                    }
                                                    if ( !empty($totalLectureClass[$subject->id]) || !empty($totalTutorialClass[$subject->id])){
                                                        $percentTotal = round(((($totalLectureClassAttend[$subject->id] + $totalTutorialClassAttend[$subject->id]) * 100) / ($totalLectureClass[$subject->id] + $totalTutorialClass[$subject->id])), 2);
                                                    }
                                                    ?>
                                                    <div class="card {{$hideClass}}">
                                                       {{-- <div class="card-header">{{$subject->title}}</div>--}}
                                                        <div class="card-header d-flex justify-content-between">
                                                            <div class="pt-2">{{$subject->title}}</div>
                                                            <div>
                                                                <button class="btn btn-success btn-sm" type="button" data-toggle="collapse" data-target="#collapseSubjectAttendance{{Str::slug($subject->title, '-')}}" aria-expanded="false" aria-controls="collapseSubjectAttendance{{Str::slug($subject->title, '-')}}">
                                                                    Show All <i class="fas fa-chevron-down pt-1"></i>
                                                                </button>
                                                            </div>
                                                        </div>
                                                        <div class="collapse" id="collapseSubjectAttendance{{Str::slug($subject->title, '-')}}">
                                                            <div class="card-body">
                                                            <div class="row">
                                                                <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                                                                    <div class="card">
                                                                        <div class="card-body">
                                                                            <div class="row">
                                                                                <h5 class="text-center w-100">Lecture Percentage</h5>
                                                                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
                                                                                    <div class="m-widget24 card">
                                                                                        <div class="m-widget24__item">
                                                                                            <h4 class="m-widget24__title">Total Lectures</h4><br>
                                                                                            <span class="m-widget24__desc">Lecture</span>
                                                                                            <span class="m-widget24__stats m--font-accent">{{$totalLectureClass[$subject->id]}}</span>
                                                                                            <div class="m--space-10"></div>
                                                                                            <div class="progress m-progress--sm mb-25">
                                                                                                <div class="progress-bar m--bg-accent" role="progressbar" style="width: 100%;" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 mt-3">
                                                                                    <div class="m-widget24 card">
                                                                                        <div class="m-widget24__item">
                                                                                            <h4 class="m-widget24__title">Attendance</h4><br>
                                                                                            <span class="m-widget24__desc">Lecture</span>
                                                                                            <span class="m-widget24__stats m--font-focus">{{$totalLectureClassAttend[$subject->id]}}</span>
                                                                                            <div class="m--space-10"></div>
                                                                                            <div class="progress m-progress--sm mb-25">
                                                                                                <div class="progress-bar m--bg-focus" role="progressbar" style="width: 100%;" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 mt-3">
                                                                                    <div class="m-widget24 card">
                                                                                        <div class="m-widget24__item">
                                                                                            <h4 class="m-widget24__title">Percentage</h4><br>
                                                                                            <span class="m-widget24__desc">Lecture</span>
                                                                                            <span class="m-widget24__stats {{($percentLecture >= 75) ? 'm--font-success' : 'm--font-danger'}}">{{$percentLecture}}%</span>
                                                                                            <div class="m--space-10"></div>
                                                                                            <div class="progress m-progress--sm mb-25">
                                                                                                <div class="progress-bar {{($percentLecture >= 75) ? 'm--bg-success' : 'm--bg-danger'}}" role="progressbar" style="width: {{$percentLecture}}%;" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                                                                    <div class="card">
                                                                        <div class="card-body">
                                                                            <div class="row">
                                                                                <h5 class="text-center w-100">Practical Percentage</h5>
                                                                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
                                                                                    <div class="m-widget24 card">
                                                                                        <div class="m-widget24__item">
                                                                                            <h4 class="m-widget24__title">Total Practicals</h4><br>
                                                                                            <span class="m-widget24__desc">Practical</span>
                                                                                            <span class="m-widget24__stats m--font-accent">{{$totalTutorialClass[$subject->id]}}</span>
                                                                                            <div class="m--space-10"></div>
                                                                                            <div class="progress m-progress--sm mb-25">
                                                                                                <div class="progress-bar m--bg-accent" role="progressbar" style="width: 100%;" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 mt-3">
                                                                                    <div class="m-widget24 card">
                                                                                        <div class="m-widget24__item">
                                                                                            <h4 class="m-widget24__title">Attendance</h4><br>
                                                                                            <span class="m-widget24__desc">Practical</span>
                                                                                            <span class="m-widget24__stats m--font-focus">{{$totalTutorialClassAttend[$subject->id]}}</span>
                                                                                            <div class="m--space-10"></div>
                                                                                            <div class="progress m-progress--sm mb-25">
                                                                                                <div class="progress-bar m--bg-focus" role="progressbar" style="width: 100%;" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 mt-3">
                                                                                    <div class="m-widget24 card">
                                                                                        <div class="m-widget24__item">
                                                                                            <h4 class="m-widget24__title">Percentage</h4><br>
                                                                                            <span class="m-widget24__desc">Practical</span>
                                                                                            <span class="m-widget24__stats {{($percentTutorial >= 75) ? 'm--font-success' : 'm--font-danger'}}">{{$percentTutorial}}%</span>
                                                                                            <div class="m--space-10"></div>
                                                                                            <div class="progress m-progress--sm mb-25">
                                                                                                <div class="progress-bar {{($percentTutorial >= 75) ? 'm--bg-success' : 'm--bg-danger'}}" role="progressbar" style="width: {{$percentTutorial}}%;" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <div class="row mt-3">
                                                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
                                                                    <div class="card">
                                                                        <div class="card-body">
                                                                            <div class="row">
                                                                                <h5 class="text-center w-100">Total Percentage</h5>
                                                                                <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4 col-xl-4">
                                                                                    <div class="m-widget24 card">
                                                                                        <div class="m-widget24__item">
                                                                                            <h4 class="m-widget24__title">Total Classes</h4><br>
                                                                                            <span class="m-widget24__desc">{{$subject->title}}</span>
                                                                                            <span class="m-widget24__stats m--font-accent">{{$totalLectureClass[$subject->id] + $totalTutorialClass[$subject->id]}}</span>
                                                                                            <div class="m--space-10"></div>
                                                                                            <div class="progress m-progress--sm mb-25">
                                                                                                <div class="progress-bar m--bg-accent" role="progressbar" style="width: 100%;" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4 col-xl-4">
                                                                                    <div class="m-widget24 card">
                                                                                        <div class="m-widget24__item">
                                                                                            <h4 class="m-widget24__title">Attendance</h4><br>
                                                                                            <span class="m-widget24__desc">{{$subject->title}}</span>
                                                                                            <span class="m-widget24__stats m--font-focus">{{$totalLectureClassAttend[$subject->id] + + $totalTutorialClassAttend[$subject->id]}}</span>
                                                                                            <div class="m--space-10"></div>
                                                                                            <div class="progress m-progress--sm mb-25">
                                                                                                <div class="progress-bar m--bg-focus" role="progressbar" style="width: 100%;" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4 col-xl-4">
                                                                                    <div class="m-widget24 card">
                                                                                        <div class="m-widget24__item">
                                                                                            <h4 class="m-widget24__title">Percentage</h4><br>
                                                                                            <span class="m-widget24__desc">{{$subject->title}}</span>
                                                                                            <span class="m-widget24__stats {{($percentTotal >= 75) ? 'm--font-success' : 'm--font-danger'}}">{{$percentTotal}}%</span>
                                                                                            <div class="m--space-10"></div>
                                                                                            <div class="progress m-progress--sm mb-25">
                                                                                                <div class="progress-bar {{($percentTotal >= 75) ? 'm--bg-success' : 'm--bg-danger'}}" role="progressbar" style="width: {{$percentTotal}}%;" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
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

    <script id="subject-attendance" type="text/x-handlebars-template">
        @{{#each subjects}}
        <div class="card">
            <div class="card-header">@{{title}}</div>
            <div class="card-body">
                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                        <div class="card">
                            <div class="card-body">
                                <div class="row">
                                    <h5 class="text-center w-100">Lecture Percentage</h5>
                                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
                                        <div class="m-widget24 card">
                                            <div class="m-widget24__item">
                                                <h4 class="m-widget24__title">Total Lectures</h4><br>
                                                <span class="m-widget24__desc">Lecture</span>
                                                <span class="m-widget24__stats m--font-accent">@{{ totalLectureClass }}</span>
                                                <div class="m--space-10"></div>
                                                <div class="progress m-progress--sm mb-25">
                                                    <div class="progress-bar m--bg-accent" role="progressbar" style="width: 100%;" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 mt-3">
                                        <div class="m-widget24 card">
                                            <div class="m-widget24__item">
                                                <h4 class="m-widget24__title">Attendance</h4><br>
                                                <span class="m-widget24__desc">Lecture</span>
                                                <span class="m-widget24__stats m--font-focus">@{{ totalLectureClassAttend }}</span>
                                                <div class="m--space-10"></div>
                                                <div class="progress m-progress--sm mb-25">
                                                    <div class="progress-bar m--bg-focus" role="progressbar" style="width: 100%;" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 mt-3">
                                        <div class="m-widget24 card">
                                            <div class="m-widget24__item">
                                                <h4 class="m-widget24__title">Percentage</h4><br>
                                                <span class="m-widget24__desc">Lecture</span>
                                                @{{#ifCond totalLecturePercent '>=' 75}}
                                                <span class="m-widget24__stats m--font-success">@{{ totalLecturePercent }}%</span>
                                                @{{ else }}
                                                <span class="m-widget24__stats m--font-danger">@{{ totalLecturePercent }}%</span>
                                                @{{/ifCond }}

                                                <div class="m--space-10"></div>
                                                <div class="progress m-progress--sm mb-25">
                                                    @{{#ifCond totalLecturePercent '>=' 75}}
                                                    <div class="progress-bar m--bg-success" role="progressbar" style='width: @{{ totalLecturePercent }}%;' aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
                                                    @{{ else }}
                                                    <div class="progress-bar m--bg-danger" role="progressbar" style='width: @{{ totalLecturePercent }}%;' aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
                                                    @{{/ifCond }}
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                        <div class="card">
                            <div class="card-body">
                                <div class="row">
                                    <h5 class="text-center w-100">Practical Percentage</h5>
                                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
                                        <div class="m-widget24 card">
                                            <div class="m-widget24__item">
                                                <h4 class="m-widget24__title">Total Practicals</h4><br>
                                                <span class="m-widget24__desc">Practical</span>
                                                <span class="m-widget24__stats m--font-accent">@{{ totalTutorialClass }}</span>
                                                <div class="m--space-10"></div>
                                                <div class="progress m-progress--sm mb-25">
                                                    <div class="progress-bar m--bg-accent" role="progressbar" style="width: 100%;" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 mt-3">
                                        <div class="m-widget24 card">
                                            <div class="m-widget24__item">
                                                <h4 class="m-widget24__title">Attendance</h4><br>
                                                <span class="m-widget24__desc">Practical</span>
                                                <span class="m-widget24__stats m--font-focus">@{{ totalTutorialClassAttend }}</span>
                                                <div class="m--space-10"></div>
                                                <div class="progress m-progress--sm mb-25">
                                                    <div class="progress-bar m--bg-focus" role="progressbar" style="width: 100%;" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 mt-3">
                                        <div class="m-widget24 card">
                                            <div class="m-widget24__item">
                                                <h4 class="m-widget24__title">Percentage</h4><br>
                                                <span class="m-widget24__desc">Practical</span>
                                                @{{#ifCond totalLecturePercent '>=' 75}}
                                                <span class="m-widget24__stats m--font-success">@{{ totalTutorialPercent }}%</span>
                                                @{{ else }}
                                                <span class="m-widget24__stats m--font-danger">@{{ totalTutorialPercent }}%</span>
                                                @{{/ifCond }}
                                                <div class="m--space-10"></div>
                                                <div class="progress m-progress--sm mb-25">
                                                    @{{#ifCond totalTutorialPercent '>=' 75}}
                                                    <div class="progress-bar m--bg-success" role="progressbar" style='width: @{{ totalTutorialPercent }}%;' aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
                                                    @{{ else }}
                                                    <div class="progress-bar m--bg-danger" role="progressbar" style='width: @{{ totalTutorialPercent }}%;' aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
                                                    @{{/ifCond }}
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row mt-3">
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="row">
                                    <h5 class="text-center w-100">Total Percentage</h5>
                                    <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4 col-xl-4">
                                        <div class="m-widget24 card">
                                            <div class="m-widget24__item">
                                                <h4 class="m-widget24__title">Total Classes</h4><br>
                                                <span class="m-widget24__desc">@{{title}}</span>
                                                <span class="m-widget24__stats m--font-accent">@{{ totalClass }}</span>
                                                <div class="m--space-10"></div>
                                                <div class="progress m-progress--sm mb-25">
                                                    <div class="progress-bar m--bg-accent" role="progressbar" style="width: 100%;" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4 col-xl-4">
                                        <div class="m-widget24 card">
                                            <div class="m-widget24__item">
                                                <h4 class="m-widget24__title">Attendance</h4><br>
                                                <span class="m-widget24__desc">@{{title}}</span>
                                                <span class="m-widget24__stats m--font-focus">@{{ totalAttend }}</span>
                                                <div class="m--space-10"></div>
                                                <div class="progress m-progress--sm mb-25">
                                                    <div class="progress-bar m--bg-focus" role="progressbar" style="width: 100%;" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4 col-xl-4">
                                        <div class="m-widget24 card">
                                            <div class="m-widget24__item">
                                                <h4 class="m-widget24__title">Percentage</h4><br>
                                                <span class="m-widget24__desc">@{{title}}</span>
                                                @{{#ifCond percentTotal '>=' 75}}
                                                <span class="m-widget24__stats m--font-success">@{{ percentTotal }}%</span>
                                                @{{ else }}
                                                <span class="m-widget24__stats m--font-danger">@{{ percentTotal }}%</span>
                                                @{{/ifCond }}
                                                <div class="m--space-10"></div>
                                                <div class="progress m-progress--sm mb-25">
                                                    @{{#ifCond percentTotal '>=' 75}}
                                                    <div class="progress-bar m--bg-success" role="progressbar" style='width: @{{ percentTotal }}%;' aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
                                                    @{{ else }}
                                                    <div class="progress-bar m--bg-danger" role="progressbar" style='width: @{{ percentTotal }}%;' aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
                                                    @{{/ifCond }}
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
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

        $('.phase-attendance').click(function (e) {
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

                $.get('{{route(customRoute('students.attendance.phase'), $student->id)}}', {phaseId: phaseId}, function (response) {
                    template   = $('#subject-attendance').html();
                    templateData = Handlebars.compile(template);
                    $("#"+divid).html(templateData(response));

                    mApp.unblockPage()
                });


                selected.attr('data-loaded', 1);


            }

        })
    </script>
@endpush
