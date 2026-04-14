@extends('layouts.default')
@section('pageTitle', $pageTitle)

@section('content')
    <div class="m-portlet m-portlet--tab">
        <div class="m-portlet__head">
            <div class="m-portlet__head-caption">
                <div class="m-portlet__head-title">
                    <h3 class="m-portlet__head-text"><i class="fas fa-info-circle pr-2"></i>Designation Detail</h3>
                </div>
            </div>
            <div class="m-portlet__head-tools">
                <a href="{{ url('admin/designation') }}" class="btn btn-primary m-btn m-btn--icon"><i class="fa fa-users pr-2"></i>Designations</a>
            </div>
        </div>

        <!--begin::Form-->
        <div class="m-form m-form--fit m-form--label-align-right">
            <div class="m-portlet__body">
                <div class="row">
                    <div class="col-md-12">
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item">Designation Title : {{$designation->title}}</li>
                            <li class="list-group-item">Organization Order : {{$designation->org_order}}</li>
                            <li class="list-group-item">Status : @if($designation->status == 1) Active @else Inactive @endif </li>
                            <li class="list-group-item">Description : {{$designation->description}}</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        <!--end::Form-->
    </div>
@endsection

