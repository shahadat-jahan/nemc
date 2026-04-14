@extends('layouts.default')
@section('pageTitle', $pageTitle)

@section('content')

    <div class="m-portlet m-portlet--tab">
        <div class="m-portlet__head">
            <div class="m-portlet__head-caption">
                <div class="m-portlet__head-title">
                    <h3 class="m-portlet__head-text"><i class="far fa-plus-square pr-2"></i>Collect payment</h3>
                </div>
            </div>
        </div>

        <!--begin::Form-->
        <form class="m-form m-form--fit m-form--label-align-right" id="nemc-general-form"  action="{{route('receive.student.payment.save', [$studentFeeDetailId])}}" method="post" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="student_id" value="{{ $studentId }}"/>
            <input type="hidden" name="student_fee_id" value="{{ $studentFeeId }}"/>
            <input type="hidden" name="student_fee_detail_id" value="{{ $studentFeeDetailId }}"/>
            <div class="m-portlet__body">
                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                        <div class="form-group  m-form__group">
                            <label class="form-control-label"><span class="text-danger">*</span> Amount </label>
                            <input type="text" class="form-control m-input" name="amount" value="{{ old('amount', $payableAmount) }}" placeholder="Amount" required/>
                        </div>
                    </div>

                    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                        <div class="form-group  m-form__group">
                            <label class="form-control-label">Discount </label>
                            <input type="text" class="form-control m-input" name="discount" id="discount" value="{{ old('discount') }}" placeholder="Discount on amount"/>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                        <div class="form-group  m-form__group ">
                            <label class="form-control-label"><span class="text-danger">*</span> Payment date</label>
                            <input type="text" class="form-control m-input m_datepicker_1" name="payment_date" value="{{ old('payment_date') }}" placeholder="Payment date" autocomplete="off"/>
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                        <div class="form-group  m-form__group ">
                            <label class="form-control-label">Discount Application file </label>
                            <input type="file" class="form-control-file" name="discount_application" id="discount_application" value="{{old('discount_application')}}"/>
                        </div>

                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                        <div class="form-group  m-form__group ">
                            <label class="form-control-label">Bank Slip Number</label>
                            <input type="text" class="form-control m-input" name="bank_slip_number" id="bank_slip_number" value="{{ old('bank_slip_number') }}" placeholder="Bank slip Number"/>
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                        <div class="form-group  m-form__group">
                            <label class="form-control-label"> Bank Pay Slip(file)</label>
                            <input type="hidden" class="form-control-file" name="attachment_id" id="attachment_id" value=""/>
                            <input type="file" class="form-control-file" name="bank_slip" value="{{old('bank_slip')}}"/>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
                        <div class="form-group  m-form__group">
                            <label class="form-control-label">Remarks </label>
                            <textarea class="form-control m-input" name="remarks" value="{{ old('remarks') }}" rows="3" placeholder="Remarks"></textarea>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
                        <div class="m-form__group form-group">
                            <label for="">Mark this payment as clear</label>
                            <div class="m-checkbox-list">
                                <label class="m-checkbox">
                                    <input type="checkbox" name="payment_paid" value="1"> Clear ?
                                    <span></span>
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="m-portlet__foot m-portlet__foot--fit">
                <div class="m-form__actions text-center">
                    <a href="{{ URL::previous() }}" class="btn btn-outline-brand"><i class="fa fa-times"></i> Cancel</a>
                    <button type="submit" class="btn btn-success"><i class="fa fa-save"></i> Save</button>
                </div>
            </div>
        </form>

        <!--end::Form-->
    </div>
@endsection

@push('scripts')
    <script src="//cdnjs.cloudflare.com/ajax/libs/lodash.js/4.17.11/lodash.min.js" type="text/javascript"></script>
    <script>

       $('#bank_slip_number').focusout(function(){
           bankSlipNumber = $(this).val();
           var studentId = '{{$studentId}}';

           if (bankSlipNumber != ''){
               mApp.blockPage({
                   overlayColor: "#000000",
                   type: "loader",
                   state: "primary",
                   message: "Please wait..."
               });
               $.get('{{route('collect.fee.attachment')}}', {student_id:  studentId, bankSlipNumber: bankSlipNumber}, function (data) {
                  if (data){
                      $("#attachment_id").val(data.id);
                  }
                  mApp.unblockPage();
               });
           }

       });


       $('#nemc-general-form').validate({
           rules:{
               amount: {
                   required: true,
               },

               bank_slip: {
                   required: function(element){
                       return (($("#attachment_id").val() == '') || ($("#attachment_id").val() == 0));
                   },
               },

               discount_application: {
                   required: function(element){
                       return (($("#discount").val() != ''));
                   },
               },
               discount: {
                   required: function(element){
                       return (($("#discount_application").val() != ''));
                   },
               },
               payment_date: {
                   required: true,
               },
               bank_slip_number: {
                   required: true,
               },

           },
           /*messages: {
               bank_slip:{
                   remote_check_1: 'AAAA',
                   remote: ''
               },
           }*/
       });



        $(document).ready(function() {
            $(".m_datepicker_1").datepicker( {
                todayHighlight: !0,
                orientation: "bottom left",
                format: 'yyyy-mm-dd',
                autoClose: true,
            });

        });
    </script>
@endpush


