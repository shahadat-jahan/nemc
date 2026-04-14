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
                        <a href="{{ url()->previous() }}" class="btn btn-primary m-btn m-btn--icon" title="Class Absent Fee"><i class="fas fa-undo"></i> back</a>
                    </div>
                </div>

                 <form class="m-form m-form--fit m-form--label-align-right" id="nemc-general-form" action="{{ route('development.installment-fee.single.update', $studentInstallmentFee->id) }}" method="post"  enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="m-portlet__body">

                        <div class="row">
                            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                                <div class="form-group m-form__group">
                                    <label class="form-control-label">Student</label>
                                    <input type="text" class="form-control" name="student_fee_id" value="{{$studentInstallmentFee->fee->student->full_name_en . ' (Roll No-'.$studentInstallmentFee->fee->student->roll_no. ')'}}" id="student_fee_id" disabled>
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                                <div class="form-group m-form__group">
                                    <label class="form-control-label">Fee Title</label>
                                    <input type="text" class="form-control" name="payment_type_id" value="{{$studentInstallmentFee->paymentType->title}}" id="payment_type_id" disabled>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                                <div class="form-group m-form__group">
                                    <label class="form-control-label">Total Amount</label>
                                    <input type="number" class="form-control" name="total_amount" value="{{$studentInstallmentFee->total_amount}}" id="total_amount" placeholder="Total Amount" disabled>
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                                <div class="form-group m-form__group">
                                    <label class="form-control-label">Payable Amount</label>
                                    <input type="number" class="form-control" name="payable_amount" value="{{$studentInstallmentFee->payable_amount}}" id="payable_amount" disabled>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                                <div class="form-group m-form__group ">
                                    <label class="form-control-label">Due Amount</label>
                                    <input type="number" class="form-control" name="due_amount" value="{{$studentInstallmentFee->due_amount}}" id="due_amount" placeholder="Total Amount" disabled>
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                                <div class="form-group m-form__group">
                                    <label class="form-control-label"><span class="text-danger">*</span> Discount Amount</label>
                                    <input type="number" max="{{abs($studentInstallmentFee->payable_amount)}}"  class="form-control" name="request_discount_amount" value="{{old('request_discount_amount', $studentInstallmentFee->request_discount_amount)}}" id="request_discount_amount">
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                                <div class="form-group m-form__group ">
                                    <label class="form-control-label"><span class="text-danger">*</span> Discount Application File</label>
                                    <input type="file" class="form-control-file" name="discount_application_file" id="discount_application_file">
                                    <small id="emailHelp" class="form-text text-muted">Excepted file formats-jpeg,jpg,png,pdf,doc,docx and max file size 2 MB</small>
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                                <div class="form-group m-form__group {{ $errors->has('last_date_of_payment') ? 'has-danger' : '' }}">
                                    <label class="form-control-label"><span class="text-danger">*</span> Last Payment Date</label>
                                    <input type="text" class="form-control m_datepicker_1" value="{{$studentInstallmentFee->last_date_of_payment}}" name="last_date_of_payment"  id="last_date_of_payment">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
                                <div class="form-group m-form__group ">
                                    <label class="form-control-label">Comment on Discount</label>
                                    <textarea class="form-control" name="remarks" id="remarks" rows="3" placeholder="Comment About Discount"></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="m-portlet__foot m-portlet__foot--fit">
                        <div class="m-form__actions text-center">
                            <a href="{{ url()->previous() }}" class="btn btn-outline-brand"><i class="fa fa-times"></i> Cancel</a>
                            <button type="submit" class="btn btn-success"><i class="fa fa-save"></i> Save</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

@endsection

@push('scripts')

    <script src="//cdnjs.cloudflare.com/ajax/libs/lodash.js/4.17.11/lodash.min.js" type="text/javascript"></script>

    <script>

        //modal form validation
        $.validator.addMethod('filesize', function (value, element, param) {
            if (element.files.length > 0){
                var fileSize = (element.files[0].size / 1024) / 1024;
                return this.optional(element) || (fileSize <= param)
            }else{
                return true;
            }
        }, 'File size must be less than {0} MB');


        $('#nemc-general-form').validate({
            rules:{
                discount_application_file: {
                    required: true,
                    extension: "jpeg|jpg|png|pdf|doc|docx",
                    filesize: 2
                },
                request_discount_amount: {
                    required: true
                },
                last_date_of_payment: {
                    required: true
                },
            },
        });

        $(document).ready(function() {
            $(".m_datepicker_1").datepicker( {
                todayHighlight: !0,
                orientation: "bottom left",
                format: 'dd/mm/yyyy',
            });

        });

    </script>
@endpush