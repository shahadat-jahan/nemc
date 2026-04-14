@extends('layouts.default')
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
                    <h3 class="m-portlet__head-text"><i class="fas fa-info-circle pr-2"></i>Student Fee Details</h3>
                </div>
            </div>
            <div class="m-portlet__head-tools">
                <a href="{{url()->previous()}}" class="btn btn-primary m-btn m-btn--icon"><i class="fas fa-undo pr-2"></i>Back</a>
            </div>
        </div>

        <div class="m-portlet__body">
            <div class="m-section__content">
                <div class="row">
                    <div class="col-md-6">
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item"><b>Student Name</b> : {{$studentPaymentInfo->student->full_name_en}}</li>
                            <li class="list-group-item">Payment Type : {{$studentPaymentInfo->paymentType->title}}</li>
                            <li class="list-group-item">Payment Method : {{$studentPaymentInfo->paymentMethod->title}}</li>
                            <li class="list-group-item">Bank : {{!empty($studentPaymentInfo->bank->title) ? $studentPaymentInfo->bank->title : 'n/a'}}</li>
                            <!--<li class="list-group-item">Amount : {{$studentPaymentInfo->amount}}</li>-->
                        </ul>
                    </div>
                    <div class="col-md-6">
                        <ul class="list-group list-group-flush">
                            <!--<li class="list-group-item">Available Amount : {{$studentPaymentInfo->available_amount}}</li>-->
                            <li class="list-group-item">Payment date : {{!empty($studentPaymentInfo->payment_date) ? $studentPaymentInfo->payment_date : 'n/a'}}</li>
                            <li class="list-group-item">Download Bank Copy :
                                @if(!empty($studentPaymentInfo->bank_copy))
                                <a href="{{$studentPaymentInfo->bank_copy}}" download><i class="fas fa-download"></i></a>
                                    @else
                                    <span>n/a</span>
                                @endif
                            </li>
                            <li class="list-group-item">Status : {!! paymentStatus($studentPaymentInfo->status) !!}</li>
                            <li class="list-group-item">Remarks : {{!empty($studentPaymentInfo->remarks) ? $studentPaymentInfo->remarks : 'n/a'}}</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

