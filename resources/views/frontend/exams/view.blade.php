@extends('frontend.layouts.default')
@section('pageTitle', $pageTitle)

@push('style')
    <style>
        .table td {
            padding-top: 0.6rem !important;
            padding-bottom: .6rem !important;
            vertical-align: top;
            border-top: 1px solid #f4f5f8;
        }
    </style>
@endpush

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="m-portlet view-page">
                <div class="m-portlet__head">
                    <div class="m-portlet__head-caption">
                        <div class="m-portlet__head-title pr-4">
                            <h3 class="m-portlet__head-text"><i class="fa fa-clock fa-md pr-2"></i>Exam Detail: {{$examInfo->title}}</h3>
                        </div>
                    </div>
                    <div class="m-portlet__head-tools">
                        <a href="{{ route('frontend.exams.list') }}" class="btn btn-primary m-btn m-btn--icon" title="Applicants"><i class="fas fa-archway"></i> Exams</a>
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
                                                        <div class="col-md-4">Course :</div>
                                                        <div class="col-md-8">{{$examInfo->course->title}}</div>
                                                    </div>
                                                </li>
                                                <li class="list-group-item">
                                                    <div class="row">
                                                        <div class="col-md-4">Term :</div>
                                                        <div class="col-md-8">{{$examInfo->term->title}}</div>
                                                    </div>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        @if(!empty($writtenExams->toArray()))
                        <div class="card mt-3">
                            <div class="card-header">
                                Written
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
                                        <div class="">
                                            <div class="table m-table table-responsive">
                                                <table class="table table-bordered table-hover" id="dataTable">
                                                    <thead>
                                                    <tr>
                                                        <th>Date</th>
                                                        <th>Subject</th>
                                                        <th>Time</th>
                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach($writtenExams as $wExam)
                                                            @if(!empty($wExam->examSubTypes->toArray()))
                                                                @foreach($wExam->examSubTypes as $subType)
                                                                    <tr>
                                                                        <td>{{$subType->pivot->exam_date}}</td>
                                                                        <td>{{$wExam->subjectGroup->title .'-'. $subType->title}}</td>
                                                                        <td>{{parseClassTimeInTwelveHours($subType->pivot->exam_time)}}</td>
                                                                    </tr>
                                                                @endforeach
                                                            @else
                                                            <tr>
                                                                <td>{{$wExam->exam_date}}</td>
                                                                <td>{{$wExam->subjectGroup->title}}</td>
                                                                <td>{{!empty($wExam->exam_time) ? parseClassTimeInTwelveHours($wExam->exam_time) : '-'}}</td>
                                                            </tr>
                                                            @endif
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                        @endif

                        @if(!empty($practicalExams->toArray()))
                        <div class="card mt-3">
                            <div class="card-header">Viva & Practical</div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
                                        <div class="">
                                            <div class="table m-table table-responsive">
                                                <table class="table table-bordered table-hover" id="dataTable">
                                                    <thead>
                                                    <tr>
                                                        <th>Date</th>
                                                        <th>Subject</th>
                                                        <th>Subject Group</th>
                                                        <th>Student Group</th>
                                                        <th>Time</th>
                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach($practicalExams as $pExam)
                                                            @if(!empty($pExam->studentGroups->toArray()))
                                                                @foreach($pExam->studentGroups as $key => $group)
                                                                    <tr>
                                                                        <td>{{date('d/m/Y', strtotime($group->pivot->exam_date))}}</td>
                                                                        <td>{{$pExam->subjectGroup->title}}</td>
                                                                        <td>{{isset($pExam->examSubTypes[$key]) ? $pExam->examSubTypes[$key]->title : ''}}</td>
                                                                        <td>{{$group->group_name}}</td>
                                                                        <td>{{parseClassTimeInTwelveHours($group->pivot->exam_time)}}</td>
                                                                    </tr>
                                                                @endforeach
                                                            @else
                                                            <tr>
                                                                <td>{{$pExam->exam_date}}</td>
                                                                <td>{{$pExam->subjectGroup->title}}</td>
                                                                <td>-</td>
                                                                <td>All</td>
                                                                <td>{{parseClassTimeInTwelveHours($pExam->exam_time)}}</td>
                                                            </tr>
                                                            @endif
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                        @endif




                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
