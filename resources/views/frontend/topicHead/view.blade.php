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
    <div class="m-portlet m-portlet--tab">
        <div class="m-portlet__head">
            <div class="m-portlet__head-caption">
                <div class="m-portlet__head-title">
                    <h3 class="m-portlet__head-text"><i class="fas fa-info-circle pr-2"></i>Topic Head Detail</h3>
                </div>
            </div>
            <div class="m-portlet__head-tools">
                <a href="{{ route('frontend.topic_head.index') }}" class="btn btn-primary m-btn m-btn--icon"><i class="fas fa-list-alt pr-2"></i>Topic Heads</a>
            </div>
        </div>
        <div class="m-portlet__body">

            <div class="m-section__content">

                <div class="card">
                    <div class="card-header">
                        Topic Head Title : {{$topicHead->title}}
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                                <div class="card">
                                    <ul class="list-group list-group-flush">
                                        <li class="list-group-item">
                                            <div class="row">
                                                <div class="col-md-4">Topic Head Title :</div>
                                                <div class="col-md-8">{{$topicHead->title}}</div>
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
                                                <div class="col-md-4">Subject Name:</div>
                                                <div class="col-md-8">{{$topicHead->subject->title}}</div>
                                            </div>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <div class="col-12">
                                <h4 class="text-center">All Topics of Topic head : {{$topicHead->title}}</h4>
                            </div>
                            <div class="col-12">
                                <div class="table-responsive">
                                    <table class="table table-bordered">
                                        <thead>
                                        <tr>
                                            <th scope="col" style="width: 7rem;">Serial No.</th>
                                            <th scope="col">Topic Title</th>
                                            <th scope="col">Description</th>
                                            <th scope="col">Status</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @if($topicHead->topics)
                                            @foreach($topicHead->topics as $key => $topic)
                                                <tr>
                                                    <td>{{$key + 1}}</td>
                                                    <td>{{$topic->title}}</td>
                                                    <td>{{!empty($topic->description) ? $topic->description : '--'}}</td>
                                                    <td>{{$topic->status == 1 ? "Active" : "InActive"}}</td>
                                                </tr>
                                            @endforeach
                                        @endif
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

