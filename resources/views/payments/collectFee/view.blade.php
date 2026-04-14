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
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead>
                        <tr>
                            <th scope="col">Payment Type</th>
                            <th scope="col">Total Amount</th>
                            <th scope="col">Discount Amount</th>
                            <th scope="col">Payable Amount</th>
                            <th scope="col">Due Amount</th>
                            <th scope="col">Discount Application</th>
                            <th scope="col">Last Payment Date</th>
                            <th scope="col">Bill For</th>
                            <th scope="col"style="width: 100px;">Status</th>
                        </tr>
                        </thead>
                        @if(!empty($studentFeeInfo->feeDetails))
                            <tbody>
                            @foreach ($studentFeeInfo->feeDetails as $studentFeeDetail)
                                <tr>
                                    <td>{{$studentFeeDetail->paymentType->title}}</td>
                                    <td>{{formatAmount($studentFeeDetail->total_amount)}}</td>
                                    <td>{{!empty($studentFeeDetail->discount_amount) ? $studentFeeDetail->discount_amount : 'n/a'}}</td>
                                    <td>{{$studentFeeDetail->payable_amount}}</td>
                                    <td>{{!empty($studentFeeDetail->due_amount) ? $studentFeeDetail->due_amount : 'n/a'}}</td>
                                    <td>
                                        @if($studentFeeDetail->discount_application)
                                            <a href="{{asset('nemc_files/payment/'.$studentFeeDetail->discount_application)}}" target="_blank" download><i class="fas fa-file-download"></i></a>
                                        @else
                                            <span>--</span>
                                        @endif
                                    </td>
                                    <td>{{!empty($studentFeeDetail->last_date_of_payment) ? $studentFeeDetail->last_date_of_payment : 'n/a'}}</td>
                                    <td>
                                        @if(!empty( $studentFeeDetail->bill_month) and !empty( $studentFeeDetail->bill_month))
                                            {{date("F", mktime(0, 0, 0, $studentFeeDetail->bill_month, 1)) .','.$studentFeeDetail->bill_year}}
                                            @else
                                            <span>--</span>
                                        @endif
                                    </td>
                                    <td>{!! paymentStatus($studentFeeDetail->status) !!}</td>
                                </tr>
                            @endforeach
                            </tbody>
                        @endif
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection

