@extends('layouts.default')
@section('pageTitle', $pageTitle)

@section('content')
    <div class="m-portlet m-portlet--tab">
        <div class="m-portlet__head">
            <div class="m-portlet__head-caption">
                <div class="m-portlet__head-title">
                    <h3 class="m-portlet__head-text"><i class="fas fa-info-circle pr-2"></i>{{$pageTitle}}</h3>
                </div>
            </div>
            <div class="m-portlet__head-tools">
                <a href="{{ url('admin/holiday') }}" class="btn btn-primary m-btn m-btn--icon"><i class="fas fa-list-alt pr-2"></i>Holidays</a>
            </div>
        </div>

        <div class="m-section__content">
            <div class="m-grid__item m-grid__item--fluid m-wrapper">
                <div class="m-content">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="card">
                                <div class="card-body">
                                    <p>Title : {{$holiday->title}}</p>
                                    <p>Holiday Start Date : {{$holiday->from_date}}</p>
                                    <p>Holiday End Date : {{ !empty($holiday->to_date) ? $holiday->to_date : 'N/A' }}</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="card">
                                <div class="card-body">
                                    <p>Session : {{ !empty($holiday->session->title) ? $holiday->session->title : 'All Session' }}</p>
                                    <p>Batch Type  : {{ !empty($holiday->batchType->title) ? $holiday->batchType->title : 'All batch' }}</p>
                                    <p>Status  : @if($holiday->status == 1) Active @else Canceled @endif </p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row pt-2">
                        {{--<div class="col" style="display: inline-flex;"><span class="pr-1">Descriptions :</span> {!!  !empty($holiday->description)  ? $holiday->description : 'N/A' !!}</div>--}}
                        <div class="col">
                            <span class="pr-1"><b>Descriptions</b> :</span>
                            {{strip_tags(!empty($holiday->description)  ? $holiday->description : 'N/A')}}
                        </div>
                    </div>

                </div>
            </div>

        </div>
    </div>
@endsection

