@extends('layouts.default')
@section('pageTitle', $pageTitle)

@push('style')
    <style>
        .m-stack--demo.m-stack--ver .m-stack__item, .m-stack--demo.m-stack--hor .m-stack__demo-item{
            padding: 29px;
        }
    </style>

@endpush

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="m-portlet">
                <div class="m-portlet__head">
                    <div class="m-portlet__head-caption">
                        <div class="m-portlet__head-title">
                            <h3 class="m-portlet__head-text"><i class="fas fa-list-ul fa-md pr-2"></i>{{$pageTitle}}</h3>
                        </div>
                    </div>
                    <div class="m-portlet__head-tools">
                        {{--@if (hasPermission('admission/create'))
                            <a href="{{ route('admission.create') }}" class="btn btn-primary m-btn m-btn--icon" title="Add New Applicant"><i class="fa fa-plus"></i> Add Applicant</a>
                        @endif--}}
                    </div>
                </div>

                <div class="m-portlet__body">


                    <div class="m-section__content">
                        <div class="row">
                            <div class="col-sm-6 col-md-3">
                                <a href="{{route('report.student.admission.type', [1])}}">
                                    <div class="m-stack m-stack--ver m-stack--general m-stack--demo">
                                        <div class="m-stack__item m-stack__item--center">General<br>Students</div>
                                    </div>
                                </a>

                            </div>
                            <div class="col-sm-6 col-md-3">
                                <a href="{{route('report.student.admission.type', [3])}}">
                                    <div class="m-stack m-stack--ver m-stack--general m-stack--demo">
                                        <div class="m-stack__item m-stack__item--center">Insolvent & Meritorious<br>Students</div>
                                    </div>
                                </a>

                            </div>
                            <div class="col-sm-6 col-md-3">
                                <a href="{{route('report.student.admission.type', [2])}}">
                                    <div class="m-stack m-stack--ver m-stack--general m-stack--demo">
                                        <div class="m-stack__item m-stack__item--center">Foreign<br>Students</div>
                                    </div>
                                </a>
                            </div>
                            <div class="col-sm-6 col-md-3">
                                <a href="{{route('report.student.admission.type', 'all')}}">
                                    <div class="m-stack m-stack--ver m-stack--general m-stack--demo">
                                        <div class="m-stack__item m-stack__item--center">All<br>Students</div>
                                    </div>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
