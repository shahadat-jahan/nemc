@extends('layouts.default')
@section('pageTitle', $pageTitle)

@section('content')
    <div class="m-portlet m-portlet--tab">
        <div class="m-portlet__head">
            <div class="m-portlet__head-caption">
                <div class="m-portlet__head-title">
                    <h3 class="m-portlet__head-text"><i class="fas fa-info-circle pr-2"></i>Topic Detail</h3>
                </div>
            </div>
            <div class="m-portlet__head-tools">
                <a href="{{ route('topic.index') }}" class="btn btn-primary m-btn m-btn--icon"><i class="fas fa-list-alt pr-2"></i>Topics</a>
            </div>
        </div>

        <!--begin::Form-->
        <div class="m-form m-form--fit m-form--label-align-right">
            <div class="m-portlet__body">

                <div class="card">
                    <h5 class="card-header">Topic Info.</h5>
                    <div class="card-body">
                        <blockquote class="blockquote mb-0">
                            <p>Title : {{$topic->title}}</p>
                            <p>Serial No: {{$topic->serial_number}}</p>
                            <p>Head : {{$topic->topicHead->title}}</p>
                            @if(!empty($topic->description))
                            <p>Description : {{$topic->description}}</p>
                            @endif
                            <p>Status : {{$topic->status == 1 ? 'Active' : 'Inactive'}}</p>
                        </blockquote>
                    </div>
                </div>

            </div>
        </div>

        <!--end::Form-->
    </div>
@endsection

