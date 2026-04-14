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
                            <a href="{{ route('get.student.fee') }}" class="btn btn-primary m-btn m-btn--icon" title="Add New Applicant"><i class="far fa-credit-card"></i> Payment Collect</a>
                    </div>
                </div>

                <div class="m-portlet__body">
                    <div class="m-section__content">
                        <div class="row">
                            <div class="col-md-12">
                               <div class="table-responsive">
                                 @php $devFeeCheck = $studentFeeDetails->where('payment_type_id', 1)->toArray(); @endphp
                                   <table class="table">
                                       <thead>
                                       <tr>
                                           <th scope="col">Id</th>
                                           <th scope="col">Fee Title</th>
                                           <th scope="col">Payment Type</th>
                                           <th scope="col">Payable Amount</th>
                                           <th scope="col">Last Date of Payment</th>
                                           <th scope="col">Status</th>
                                           @if(!empty($devFeeCheck))
                                           <th scope="col">Action</th>
                                           @endif
                                       </tr>
                                       </thead>
                                       <tbody>
                                       @foreach($studentFeeDetails as $studentFeeDetail)
                                       <tr>
                                           <th scope="row">{{$studentFeeDetail->id}}</th>
                                           <td>{{$studentFeeDetail->fee->title}}</td>
                                           <td>{{$studentFeeDetail->paymentType->title}}</td>
                                           <td>{{$studentFeeDetail->payable_amount}}</td>
                                           <td>{{$studentFeeDetail->last_date_of_payment}}</td>
                                           <td>@if($studentFeeDetail->status == 1)
                                                   <span class="badge badge-success">Paid</span>
                                               @elseif($studentFeeDetail->status == 2)
                                                   <span class="badge badge-info">Partial Paid</span>
                                               @else
                                                   <span class="badge badge-danger">Not Paid</span>
                                               @endif
                                           </td>
                                           @if(!empty($devFeeCheck))
                                           <td>
                                               @if($studentFeeDetail->payment_type_id == 1)
                                               <a href="{{route('student.fee.collect.form', [$studentFeeDetail->student_fee_id, $studentFeeDetail->id])}}" class="m-portlet__nav-link btn m-btn m-btn--hover-brand m-btn--icon m-btn--icon-only m-btn--pill" title="Collect payment" ><i class="fas fa-money-bill-alt"></i></a>
                                               @endif
                                           </td>
                                           @endif
                                       </tr>
                                           @endforeach
                                       </tbody>
                                   </table>
                               </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
