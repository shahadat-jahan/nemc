@extends('layouts.default')
@section('pageTitle', 'Installments')

@section('content')
    <div class="m-portlet m-portlet--tab">
        <div class="m-portlet__head">
            <div class="m-portlet__head-caption">
                <div class="m-portlet__head-title">
                    <h3 class="m-portlet__head-text"><i class="far fa-edit pr-2"></i>Installments for {{$student->full_name_en}}</h3>
                </div>
            </div>
        </div>

        <div class="row installment-row plan-row m--hide">
            <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4 col-xl-4">
                <div class="form-group  m-form__group">
                    {{--<label class="form-control-label"><span class="text-danger">*</span> Title </label>--}}
                    {{--<input type="text" class="form-control m-input installment-title" name="title[]" placeholder="Title">--}}
                    <span class="installment-title"></span>
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4 col-xl-4">
                <div class="form-group  m-form__group">
                    <label class="form-control-label"><span class="text-danger">*</span>  Amount </label>
                    <input type="number" class="form-control m-input installment-amount" name="amount[]" min="1" placeholder="Amount"/>
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3 col-xl-3">
                <div class="form-group  m-form__group">
                    <label class="form-control-label"> Last date of payment </label>
                    <input type="text" class="form-control m-input last-date-payment m_datepicker_1" name="last_date_of_payment[]" placeholder="Last date of payment" autocomplete="off"/>
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-1 col-lg-1 col-xl-1">
                <a href="#" class="btn btn-sm btn-danger mt-5 remove-row"><i class="fa fa-trash-alt"></i></a>
            </div>
        </div>

        <!--begin::Form-->
        <form class="m-form m-form--fit m-form--label-align-right"  action="{{ route('students.installment.post', $student->id) }}" id="nemc-general-form" method="post">
            @csrf
            <input type="hidden" name="payment_type_id" value="1">
            <div class="m-portlet__body">
                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                        <div class="form-group  m-form__group {{ $errors->has('session_id') ? 'has-danger' : '' }}">
                            <label class="form-control-label">Session </label>
                            <input type="text" class="form-control m-input" name="session_id" value="{{$student->session->title}}" disabled/>
                            @if ($errors->has('session_id'))
                                <div class="form-control-feedback">{{ $errors->first('session_id') }}</div>
                            @endif
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                        <div class="form-group  m-form__group {{ $errors->has('course_id') ? 'has-danger' : '' }}">
                            <label class="form-control-label">Course </label>
                            <input type="text" class="form-control m-input" name="course_id" value="{{$student->course->title}}" disabled/>
                            @if ($errors->has('course_id'))
                                <div class="form-control-feedback">{{ $errors->first('course_id') }}</div>
                            @endif
                        </div>
                    </div>

                </div>
                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                        <div class="form-group  m-form__group {{ $errors->has('total_development_fee') ? 'has-danger' : '' }}">
                            <label class="form-control-label"><span class="text-danger">*</span>Total Development Fee</label>
                            <input type="hidden" id="total_development_fee" value="{{$developmentFee}}" placeholder="Total Development Fee" required/>
                            <input type="text" class="form-control m-input" name="total_development_fee" value="{{formatAmount($developmentFee)}}" placeholder="Total Development Fee" readonly/>
                            <span class="help-text">Field not editable</span>
                            @if ($errors->has('total_development_fee'))
                                <div class="form-control-feedback">{{ $errors->first('total_development_fee') }}</div>
                            @endif
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                        <div class="form-group  m-form__group {{ $errors->has('total_payable_amount') ? 'has-danger' : '' }}">
                            <label class="form-control-label"><span class="text-danger">*</span>Total Development Fee (Payable Amount)</label>
                            <input type="hidden" id="total_payable_amount" value="{{$developmentFee}}" placeholder="Total Development Fee" required/>
                            <input type="text" class="form-control m-input" id="total_payable_value" max="{{formatAmount($developmentFee)}}" name="total_payable_amount" value="{{formatAmount($developmentFee)}}" placeholder="Total Development Fee" readonly/>
                            @if ($errors->has('total_payable_amount'))
                                <div class="form-control-feedback">{{ $errors->first('total_payable_amount') }}</div>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                        <div class="form-group  m-form__group {{ $errors->has('total_installment') ? 'has-danger' : '' }}">
                            <label class="form-control-label"><span class="text-danger">*</span>How Many Installments? </label>
                            <select class="form-control m-input" name="total_installment" id="total_installment">
                                <option value="">---- Select ----</option>
                                @for ($i = 1; $i <= 20; $i++)
                                    <option value="{{$i}}">{{$i}}</option>
                                @endfor
                            </select>
                            @if ($errors->has('total_installment'))
                                <div class="form-control-feedback">{{ $errors->first('total_installment') }}</div>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="m-separator m-separator--dashed m-separator--lg"></div>
                <div class="row ins-plan m--hide">
                    <div class="m-form__heading" style="padding-left: 20px">
                        <h3 class="m-form__heading-title">Installment Plans</h3>
                    </div>
                </div>

                <div id="all-installments"></div>

            </div>
            <div class="m-portlet__foot m-portlet__foot--fit">
                <div class="m-form__actions text-center">
                    <a href="{{ url('admin/students') }}" class="btn btn-outline-brand"><i class="fa fa-times"></i> Cancel</a>
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
        $(document).ready(function() {

            /*$(".m_datepicker_1").datepicker( {
                todayHighlight: !0,
                orientation: "bottom left",
                format: 'yyyy-mm-dd',
            });*/

            function setupInstallments(totalInstallment){
                for (var i=1; i<=totalInstallment; i++){
                    installment = $('.installment-row');
                    installmentRow = installment.clone(true);
                    installmentRow = installmentRow.removeClass('installment-row');
                    installmentRow.find('.installment-title').text('Installment '+ i);
                    installmentRow.find('.m_datepicker_1').datepicker( {
                        todayHighlight: !0,
                        orientation: "bottom left",
                        format: 'dd/mm/yyyy',
                    });
                    $('#all-installments').append(installmentRow.removeClass('m--hide'));
                }

                // $(".m_datepicker_1").datepicker('destroy'); //detach


                // $('.m_datepicker_1').datepicker('update');


                $('.ins-plan').removeClass('m--hide');
            }

            $('#total_installment').change(function () {

                installments= $(this).val();

                if ($('#all-installments').html().length > 0 ){
                    Swal.fire({
                        title: 'Are you sure?',
                        text: "Do you want to re-generate installments",
                        type: 'warning',
                        showCancelButton: true,
                        confirmButtonText: 'Yes'
                    }).then((result) => {
                        if (result.value) {
                            $('#all-installments').html('');
                            setupInstallments(installments);

                        }else if (result.dismiss === Swal.DismissReason.cancel){
                            $('#total_installment').val($('#all-installments > .row').length);
                            return false;
                        }
                    })

                }else{
                    setupInstallments(installments);
                }
            });

            $('.remove-row').click(function (e) {
                e.preventDefault()
                current = $(this);

                Swal.fire({
                    title: 'Are you sure?',
                    text: "Do you want to delete this phase",
                    type: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Yes'
                }).then((result) => {
                    if (result.value) {
                        $(this).parents('.plan-row').remove();
                        $('#total_installment').val($('#total_installment').val() - 1);

                    }else if (result.dismiss === Swal.DismissReason.cancel){
                        return false;
                    }
                })
            });

            $('#total_payable_value').keypress(_.debounce(function(){
                $('#total_payable_amount').val($(this).val().replace(/,/g, ''));
            }, 500));

            $.validator.addMethod("installment_amount", function (value, element) {
                var flag = true;
                $("#all-installments [name^=amount]").each(function (i, j) {
                    if ($.trim($(this).val()) == '') {
                        flag = false;
                        $(this).parents('.form-group').addClass('has-danger');
                    }else{
                        $(this).parents('.form-group').removeClass('has-danger');
                    }
                });
                return flag;

            }, "");

            $.validator.addMethod("payment_date", function (value, element) {
                var flag = true;
                $("#all-installments [name^=last_date_of_payment]").each(function (i, j) {
                    if ($.trim($(this).val()) == '') {
                        flag = false;
                        $(this).parents('.form-group').addClass('has-danger');
                    }else{
                        $(this).parents('.form-group').removeClass('has-danger');
                    }
                });
                return flag;

            }, "");

            $.validator.addMethod("payment_sum", function (value, element, params) {
                    var sumOfVals = 0;
                    payableAmount = parseInt($('#total_payable_amount').val());
                    $("#all-installments [name^=amount]").each(function () {
                        sumOfVals = sumOfVals + parseInt($(this).val(), 10);
                    });
                    if (sumOfVals == payableAmount) return true;
                    return false;
                }, "Amount sum must be equal to development fee (payable amount)");


            $('#nemc-general-form').validate({
                rules:{
                    total_payable_amount: {
                        required: true,
                        number: true
                    },
                    total_installment: {
                        required: true,
                        min: 1
                    },
                    /*'amount[]': {
                        installment_amount: true,
                        payment_sum: parseInt($('#total_payable_amount').val()),
                    },*/
                    'amount[]': {
                        installment_amount: true,
                        payment_sum: true,
                    },
                    'last_date_of_payment[]': {
                        payment_date: true,
                    },
                }
            });


        });
    </script>
@endpush
