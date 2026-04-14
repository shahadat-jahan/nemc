@extends('layouts.default')
@section('pageTitle', $pageTitle)

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
                        <a href="{{ route('get.student.development.fee') }}" class="btn btn-primary m-btn m-btn--icon" title="Add New Applicant"><i class="far fa-credit-card"></i> Collect Fees</a>
                    </div>
                </div>

                <div class="m-portlet__body">
                    <div class="m-section__content">
                        <div class="row">
                            <div class="col-md-12">
                                @if(!empty($studentFees))
                                    @if ($studentFees->isNotEmpty())
                                        <h4 class="text-center mt-4">Fee Info of Student - <b>{{$studentFees->first()->student->full_name_en}}</b> , Roll No. - <b>{{$studentFees->first()->student->roll_no}}</b></h4>
                                    @else
                                        <h4 class="text-center mt-4">Student Fee Info</h4>
                                    @endif
                                     <br>

                                <div class="table m-table table-responsive">
                                    <table class="table table-bordered table-hover" id="dataTable">
                                        <thead>
                                        <tr>
                                            <th class="uppercase">Fee Title</th>
                                            <th class="uppercase">Total Amount</th>
                                            <th class="uppercase">Discount Amount</th>
                                            <th class="uppercase">Payable Amount</th>
                                            <th class="uppercase">Paid Amount</th>
                                            <th class="uppercase">Due Amount</th>
                                            <th class="uppercase">Discount Application</th>
                                            <th class="uppercase">Date</th>
                                            <th class="uppercase">Status</th>
                                            <th class="uppercase">Action</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @php
                                        $sortedStudentFees = $studentFees->sortByDesc(function ($item, $key) {
                                            return $item->feeDetails->first()->bill_year.$item->feeDetails->first()->bill_month;
                                        });
                                       @endphp
                                        @foreach($sortedStudentFees as $studentFee)
                                        <tr>
                                           {{-- <td>{{$studentFeeDetail->fee->title}}</td>--}}
                                            <td>{{$studentFee->title}}</td>
                                            <td>{{formatAmount($studentFee->total_amount)}}</td>
                                            <td>{{formatAmount($studentFee->discount_amount)}}</td>
                                            <td>{{formatAmount($studentFee->payable_amount)}}</td>
                                            <td>{{formatAmount($studentFee->paid_amount)}}</td>
                                            <td>{{formatAmount($studentFee->due_amount)}}</td>
                                            <td>
                                                @if(!empty($studentFee->discount_application))
                                                    <a href="{{asset('nemc_files/payment/'.$studentFee->discount_application)}}" title="Download Discount Application" download><i class="fas fa-download"></i></a>
                                                @else
                                                    <span>--</span>
                                                @endif
                                            </td>
                                            <td>
                                                @if(!empty($studentFee->feeDetails->first()->bill_month) and !empty( $studentFee->feeDetails->first()->bill_year))
                                                    {{date("F", mktime(0, 0, 0, $studentFee->feeDetails->first()->bill_month, 1)) .','. $studentFee->feeDetails->first()->bill_year}},
                                                @else
                                                    <span>--</span>
                                                @endif
                                            </td>
                                            <td>{!! paymentStatus($studentFee->status) !!}</td>
                                            <td>
                                                <a href="{{route('student.fee.single.view', $studentFee->id)}}" class="m-portlet__nav-link btn m-btn m-btn--hover-brand m-btn--icon m-btn--icon-only m-btn--pill" title="View"><i class="flaticon-eye"></i></a>
                                            </td>
                                        </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>
                                @endif
                            </div>

                           {{-- @if($studentPayments->toArray()->isNotEmpty())--}}
                            @if(!empty($studentPayments))
                            <div class="col-md-12">
                                <h4 class="text-center mt-4">Student Payment Info</h4>
                                <div class="table-responsive">
                                    <table class="table table-bordered">
                                        <thead>
                                        <tr>
                                            <th scope="col">Payment Method</th>
                                            <th scope="col">Bank</th>
                                            <th scope="col">Bank Copy</th>
                                            <th scope="col">Amount</th>
                                            <th scope="col">Payment Date</th>
                                            <th scope="col">Remarks</th>
                                            <th scope="col">Status</th>
                                            <th scope="col">Action</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($studentPayments as $studentPayment)
                                        <tr>
                                            <td>{{$studentPayment->paymentMethod->title}}</td>
                                            <td>{{!empty($studentPayment->bank->title) ? $studentPayment->bank->title : 'n/a'}}</td>
                                            <td>
                                                @if($studentPayment->bank_copy)
                                                <a href="{{asset('nemc_files/payment/'.$studentPayment->bank_copy)}}" target="_blank" download><i class="fas fa-file-download"></i></a>
                                                @endif
                                            </td>
                                            <td>{{formatAmount($studentPayment->amount)}}</td>
                                            <td>{{!empty($studentPayment->payment_date) ? $studentPayment->payment_date : 'n/a'}}</td>
                                            <td>{{!empty($studentPayment->remarks)? $studentPayment->remarks : 'n/a'}}</td>
                                            <td>{!! paymentStatus($studentPayment->status) !!}</td>
                                            <td>
                                                <a href="{{route('student.payment.edit', $studentPayment->id)}}" class="m-portlet__nav-link btn m-btn m-btn--hover-brand m-btn--icon m-btn--icon-only m-btn--pill" title="Edit"><i class="flaticon-edit"></i></a>
                                            </td>
                                        </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
