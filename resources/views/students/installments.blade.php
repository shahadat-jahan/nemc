@extends('layouts.default')
@section('pageTitle', 'Installments')

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
            <div class="m-portlet">
                <div class="m-portlet__head">
                    <div class="m-portlet__head-caption">
                        <div class="m-portlet__head-title">
                            <h3 class="m-portlet__head-text"><i class="fas fa-list-ul fa-md pr-2"></i>{{$pageTitle}}</h3>
                        </div>
                    </div>
                    <div class="m-portlet__head-tools">
                        @if (hasPermission('students/installment'))
                            @if(empty($installments->toArray()))
                                @if(empty($totalInstallmentFee))
                                <a href="{{ route('students.installment', [$student->id]) }}" class="btn btn-primary m-btn m-btn--icon" title="Create Installment"><i class="fa fa-plus"></i> Create Installment</a>
                                @else
                                    <a href="{{ route('students.installment.edit', [$student->id]) }}" class="btn btn-primary m-btn m-btn--icon" title="Edit Installment"><i class="fa fa-edit"></i> Edit Installment</a>
                                @endif
                            @endif
                        @endif
                    </div>
                </div>

                <div class="m-portlet__body">
                    <div class="m-section__content">
                        <div class="row">
                            <div class="col-md-12">
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
@endsection