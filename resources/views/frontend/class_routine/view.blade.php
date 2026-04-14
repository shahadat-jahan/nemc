@extends('frontend.layouts.default')
@section('pageTitle', $pageTitle)
@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="m-portlet view-page">
                <div class="m-portlet__head">
                    <div class="m-portlet__head-caption">
                        <div class="m-portlet__head-title">
                            <h3 class="m-portlet__head-text"><i class="fa fa-clock fa-md pr-2"></i>Class Routine Detail</h3>
                        </div>
                    </div>
                    <div class="m-portlet__head-tools">
                        <a href="{{ route('frontend.class_routine.index') }}" class="btn btn-primary m-btn m-btn--icon" title="Applicants"><i class="fa fa-clock"></i> Class Routines</a>
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
                                                        <div class="col-md-8">{{$classRoutine->session->title}}</div>
                                                    </div>
                                                </li>
                                                <li class="list-group-item">
                                                    <div class="row">
                                                        <div class="col-md-4">Phase :</div>
                                                        <div class="col-md-8">{{$classRoutine->phase->title}}</div>
                                                    </div>
                                                </li>
                                                <li class="list-group-item">
                                                    <div class="row">
                                                        <div class="col-md-4">Start Date :</div>
                                                        <div class="col-md-8">{{date('d/m/Y', strtotime($min_max_date->min_date))}}</div>
                                                    </div>
                                                </li>
                                                <li class="list-group-item">
                                                    <div class="row">
                                                        <div class="col-md-4">Class Type :</div>
                                                        <div class="col-md-8">{{$classRoutine->classType->title}}</div>
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
                                                        <div class="col-md-4">Subject :</div>
                                                        <div class="col-md-8">{{$classRoutine->subject->title}}</div>
                                                    </div>
                                                </li>
                                                <li class="list-group-item">
                                                    <div class="row">
                                                        <div class="col-md-4">Day :</div>
                                                        <div class="col-md-8">{{getDayName($classRoutine->class_date)}}</div>
                                                    </div>
                                                </li>
                                                <li class="list-group-item">
                                                    <div class="row">
                                                        <div class="col-md-4">End Date :</div>
                                                        <div class="col-md-8">{{date('d/m/Y', strtotime($min_max_date->max_date))}}</div>
                                                    </div>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="card mt-3">
                            <div class="card-header">All Classes</div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
                                        <div class="">
                                            <div class="table m-table table-responsive">
                                                @include('common/datatable')
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

@endsection
