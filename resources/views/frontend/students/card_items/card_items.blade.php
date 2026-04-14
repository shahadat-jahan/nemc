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
                        <a href="{{ URL::previous() }}" class="btn btn-primary m-btn m-btn--icon" title="Applicants"><i class="fa fa-undo-alt"></i> Back</a>
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
                                                <span class="m-nav__link-text">Status: {{$student->status == 1 ? 'Active' : 'Inactive'}}</span>
                                            </div>
                                        </li>
                                        <li class="m-nav__item ">
                                            <a class="m-nav__link" href="{{route('frontend.students.attendance', [$student->id])}}">
                                                <i class="m-nav__link-icon fa fa-user-tag"></i>
                                                <span class="m-nav__link-text">Attendance</span>
                                            </a>
                                        </li>
                                        <li class="m-nav__item">
                                            <a class="m-nav__link active-link" href="{{route('frontend.students.card-item', [$student->id])}}">
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
                            <div class="card">
                                <div class="card-header">{{$cardItems->first()->card->subject->title.' - '.$cardItems->first()->card->title}}</div>
                                <div class="card-body">
                                    <table class="table table-bordered table-hover">
                                        <thead>
                                        <tr>
                                            <th>Sl No</th>
                                            <th>Items Topic</th>
                                            <th>Date of Examination</th>
                                            <th>Marks Obtained</th>
                                            <th>Remarks</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($cardItems as $key => $item)
                                            {{--{{dd($item->examSubjects->first()->exam->examMarks->first()->result->firstWhere('student_id', $student->id))}}--}}
                                            <tr>
                                                <th>{{$key+1}}</th>
                                                <td>{{$item->title}}</td>
                                                @if(isset($item->examSubjects->first()->exam) && isset($item->examSubjects->first()->exam->examMarks->first()->result->firstWhere('student_id', $student->id)->result_date))
                                                <td>
                                                    {{$item->examSubjects->first()->exam->examMarks->first()->result->firstWhere('student_id', $student->id)->result_date}}
                                                </td>
                                                @else
                                                <td>--</td>
                                                @endif

                                                @if(isset($item->examSubjects->first()->exam) && isset($item->examSubjects->first()->exam->examMarks->first()->result->firstWhere('student_id', $student->id)->marks))
                                                <td>
                                                    {{$item->examSubjects->first()->exam->examMarks->first()->result->firstWhere('student_id', $student->id)->marks}}
                                                </td>
                                                @else
                                                <td>--</td>
                                                @endif

                                                @if(isset($item->examSubjects->first()->exam) && isset($item->examSubjects->first()->exam->examMarks->first()->result->firstWhere('student_id', $student->id)->result_status))
                                                    <td>
                                                        {{$item->examSubjects->first()->exam->examMarks->first()->result->firstWhere('student_id', $student->id)->result_status}}
                                                    </td>
                                                @else
                                                    <td>--</td>
                                                @endif
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>

@endsection
