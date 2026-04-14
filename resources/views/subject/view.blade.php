@extends('layouts.default')
@section('pageTitle', 'Designation')

@push('style')
    <style>
        .form-control[disabled] {
            border-color: #f4f5f8 !important;
            color: #6f727d;
            background-color: #f4f5f8 !important;
        }
        .m-checkbox>input:disabled ~ span {
            opacity: 1 !important;
            filter: alpha(opacity=60);
        }
        .m-checkbox>input:checked ~ span {
            border: 1px solid #bdc3d4;
            background: #f4f5f8 !important;
        }
        select.form-control {
            -moz-appearance: none !important;
            -webkit-appearance: none !important;
            appearance: none !important;
        }
        .list-group-horizontal-sm {
            -ms-flex-direction: row;
            flex-direction: row;
        }
        .list-group-horizontal-sm .list-group-item {
            margin-right: -1px;
            margin-bottom: 0;
        }
    </style>
@endpush

@section('content')
    <div class="m-portlet m-portlet--tab">
        <div class="m-portlet__head">
            <div class="m-portlet__head-caption">
                <div class="m-portlet__head-title">
                    <h3 class="m-portlet__head-text"><i class="fas fa-lg fa-info-circle pr-2"></i>Subject Details</h3>
                </div>
            </div>
            <div class="m-portlet__head-tools">
                <a href="{{ url('admin/subject') }}" class="btn btn-primary m-btn m-btn--icon"><i class="fas fa-address-book pr-2"></i>Subjects</a>
            </div>
        </div>

        <div class="m-form m-form--fit m-form--label-align-right">
            <div class="m-portlet__body">

                <div class="m-portlet">
                    <div class="m-portlet__head">
                        <div class="m-portlet__head-caption">
                            <div class="m-portlet__head-title">
                                <h3 class="m-portlet__head-text">
                                   Subject Detail with Exam
                                </h3>
                            </div>
                        </div>
                    </div>
                    <div class="m-portlet__body">
                        <ul class="nav nav-tabs  m-tabs-line m-tabs-line--primary" role="tablist">
                            <li class="nav-item m-tabs__item">
                                <a class="nav-link m-tabs__link active" data-toggle="tab" href="#subject_info" role="tab">Basic Info</a>
                            </li>

                           {{-- <li class="nav-item m-tabs__item">
                                <a class="nav-link m-tabs__link" data-toggle="tab" href="#exam_category" role="tab">Exam Category</a>
                            </li>--}}
                            <li class="nav-item m-tabs__item">
                                <a class="nav-link m-tabs__link" data-toggle="tab" href="#exma_sub_type" role="tab">Exam Sub Types</a>
                            </li>
                        </ul>
                        <div class="tab-content">
                            <div class="tab-pane active" id="subject_info" role="tabpanel">
                                <p>Subject Title : {{ $subject->title}}</p>
                                <p>Subject Code : {{$subject->code}}</p>
                                <p>Subject Group : {{$subject->subjectGroup->title}}</p>
                                <p>Department : {{$subject->department->title}}</p>
                                <p>Status : @if($subject->status == 1) Active @else Inactive @endif</p>
                            </div>
                            {{--<div class="tab-pane" id="exam_category" role="tabpanel">
                                <div class="row">
                                    <div class="col-md-12">
                                        <ul class="list-group list-group-horizontal-sm">
                                            @forelse($subject->examCategories as $examCategory)
                                            <li class="list-group-item">{{$examCategory->title}}</li>
                                            @empty
                                                <p>No Exam Category</p>
                                             @endforelse
                                        </ul>
                                    </div>
                                </div>
                            </div>--}}
                            <div class="tab-pane" id="exma_sub_type" role="tabpanel">
                                <div class="row">
                                    <div class="col-md-12">
                                        <ul class="list-group list-group-horizontal-sm">
                                            @forelse($subject->examSubTypes as $examSubType)
                                                <li class="list-group-item">{{$examSubType->title}}</li>
                                                @empty
                                                <p>No Exam Sub Type</p>
                                            @endforelse
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

