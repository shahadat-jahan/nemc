@extends('layouts.default')
@section('pageTitle', $pageTitle)

@section('content')
    <div class="m-portlet m-portlet--tab">
        <div class="m-portlet__head">
            <div class="m-portlet__head-caption">
                <div class="m-portlet__head-title">
                    <h3 class="m-portlet__head-text"><i class="fas fa-info-circle pr-2"></i>Lecture Material Detail</h3>
                </div>
            </div>
            <div class="m-portlet__head-tools">
                <a href="{{ URL::previous() }}" class="btn btn-primary m-btn m-btn--icon"><i class="fas fa-undo pr-2"></i>Back</a>
            </div>
        </div>

        <div class="m-section__content">
            <div class="m-grid__item m-grid__item--fluid m-wrapper">
                <div class="m-content">
                    <div class="card">
                        <h5 class="card-header">Lecture Material Details</h5>
                        <div class="card-body">
                            <h5 class="card-title">Class Info Content</h5>
                            <div class="row">
                                <div class="col-md-3">
                                    @if(isset($lectureMaterial->classRoutine->subject->title))
                                        <p>Subject : {{$lectureMaterial->classRoutine->subject->title}}</p>
                                    @endif
                                </div>
                                <div class="col-md-3">
                                    @if(isset($lectureMaterial->classRoutine->teacher->full_name))
                                        <p>Teacher : {{$lectureMaterial->classRoutine->teacher->full_name}}</p>
                                    @endif
                                </div>
                                <div class="col-md-3">
                                    @if(isset($lectureMaterial->classRoutine->topic->title))
                                        <p>Topic : {{$lectureMaterial->classRoutine->topic->title}}</p>
                                    @endif
                                </div>
                                <div class="col-md-3">
                                    @if(isset($lectureMaterial->classRoutine->classSession->title))
                                        <p> Session : {{$lectureMaterial->classRoutine->classSession->title}}</p>
                                    @endif
                                </div>
                            </div>
                            <hr>

                            <h5 class="card-title">Material Content</h5>
                            <p class="card-text">{!! !empty($lectureMaterial->content) ? $lectureMaterial->content : 'n/a' !!}</p>
                            <hr>
                            <h5 class="card-title">Resource URLs</h5>
                            <p class="card-text">{{!empty($lectureMaterial->resource_url) ? $lectureMaterial->resource_url : 'n/a'}}</p>
                            <hr>
                            <div>
                                @if(!empty($lectureMaterial->attachment))
                                    <h5 class="card-title">Attachment</h5>
                                    <p>Download Attachment :  <a class="btn btn-info" href="{{asset('nemc_files/lecture_material/'.$lectureMaterial->attachment)}}" target="_blank" download>Download<i class="fa fa-download pl-2"></i></a></p>
                                 @endif
                            </div>
                            <p>Status  : @if($lectureMaterial->status == 1) Active @else Inactive @endif </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

