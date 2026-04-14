@extends('layouts.default')
@section('pageTitle', 'Payment Type')

@section('content')
    <div class="m-portlet m-portlet--tab">
        <div class="m-portlet__head">
            <div class="m-portlet__head-caption">
                <div class="m-portlet__head-title">
                    <h3 class="m-portlet__head-text"><i class="far fa-edit pr-2"></i>Edit Payment Type</h3>
                </div>
            </div>
            <div class="m-portlet__head-tools">
                    <a href="{{ url('admin/payment_type') }}" class="btn btn-primary m-btn m-btn--icon"><i class="far fa-credit-card pr-2"></i>Payment Types</a>
            </div>
        </div>

        <!--begin::Form-->
        <form class="m-form m-form--fit m-form--label-align-right"  action="{{ url('admin/payment_type/' .$paymentType->id) }}"  id="nemc-general-form" method="post">
            @csrf
            @method('PUT')
            <div class="m-portlet__body">

                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                        <div class="form-group  m-form__group {{ $errors->has('title') ? 'has-danger' : '' }}">
                            <label class="form-control-label"><span class="text-danger">*</span> Title </label>
                            <input type="text" class="form-control m-input" name="title" value="{{ old('title', $paymentType->title) }}" placeholder="Payment Type Title"/>
                            @if ($errors->has('title'))
                                <div class="form-control-feedback">{{ $errors->first('title') }}</div>
                            @endif
                        </div>
                    </div>

                    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                        <div class="form-group  m-form__group {{ $errors->has('code') ? 'has-danger' : '' }}">
                            <label class="form-control-label"><span class="text-danger">*</span> Code </label>
                            <input type="text" class="form-control m-input" name="code" value="{{ old('code', $paymentType->code) }}" placeholder="Code"/>
                            @if ($errors->has('code'))
                                <div class="form-control-feedback">{{ $errors->first('code') }}</div>
                            @endif
                        </div>
                    </div>
                </div>


                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                        <div class="form-group  m-form__group">
                            <label class="form-control-label">Select Status </label>
                            <select class="form-control m-input " name="status">
                                <option value="1" {{ $paymentType->status == 1  ? 'selected' : '' }}>Active</option>
                                <option value="0" {{ $paymentType->status == 0  ? 'selected' : '' }}>Inactive</option>
                            </select>
                        </div>
                    </div>
                </div>

            </div>
            <div class="m-portlet__foot m-portlet__foot--fit">
                <div class="m-form__actions text-center">
                    <a href="{{ url('admin/payment_type') }}" class="btn btn-outline-brand"><i class="fa fa-times"></i> Cancel</a>
                    <button type="submit" class="btn btn-success"><i class="fa fa-save"></i> Save</button>
                </div>
            </div>
        </form>

        <!--end::Form-->
    </div>
@endsection

@push('scripts')
    <script>
        ;(function($){

            var plusButton = $('.hide');

            // code for add
            $('.add-row').on('click',function(){
                var copyRow = $('.copy-data');
                var copydata = copyRow.clone(true);
                copyRow.removeClass('copy-data');
                // copydata.find('.student-category').removeClass('m-bootstrap-select').removeClass('m_selectpicker');
                // copydata.find('.student-category').removeAttr('data-live-search');
                $(this).parents('.row').after(copydata);
                $(this).parents('.payment-detail-row').find('.remove-row').removeClass('m--hide');
                $(this).parents('.row').find('.add-row').detach();
            });

            // code for remove
            $('.remove-row').on('click',function(){
                Swal.fire({
                    title: 'Are you sure?',
                    text: "Do you want to delete this",
                    type: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Yes'
                }).then((result) => {
                    if (result.value) {
                        if($('.payment-detail-row').length > 1){
                            $(this).parents('.payment-detail-row').prev('.row').addClass('copy-data')
                            $(this).parents('.payment-detail-row').prev('.row').find('.col-md-1:last').prepend(plusButton.removeClass('hide'));
                            $(this).parents('.payment-detail-row').detach();
                        }

                    }else if (result.dismiss === Swal.DismissReason.cancel){
                        return false;
                    }
                });

            });

            // code for old row remove
            $('.remove-old-row').on('click',function(){
                Swal.fire({
                    title: 'Are you sure?',
                    text: "Do you want to delete this",
                    type: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Yes'
                }).then((result) => {
                    if (result.value) {
                        if($('.payment-detail-old-row').length > 1){
                            /*$(this).parents('.payment-detail-old-row').prev('.row').addClass('copy-data')*/
                            $(this).parents('.payment-detail-old-row').prev('.row').find('.col-md-1:last').prepend(plusButton.removeClass('hide'));
                            $(this).parents('.payment-detail-old-row').detach();
                        }

                    }else if (result.dismiss === Swal.DismissReason.cancel){
                        return false;
                    }
                });

            });


            // js validation
            $.validator.addMethod("student_category", function (value, element) {
                var flag = true;
                $(".payment-detail-row [name^=student_category_id], .payment-detail-old-row [name^=student_category_id]").each(function (i, j) {
                    if ($.trim($(this).val()) == '') {
                        flag = false;
                        $(this).parents('.form-group').addClass('has-danger');
                    }else{
                        $(this).parents('.form-group').removeClass('has-danger');
                    }
                });
                return flag;

            }, "");

            $.validator.addMethod("course", function (value, element) {
                var flag = true;
                $(".payment-detail-row [name^=course_id], .payment-detail-old-row [name^=course_id]").each(function (i, j) {
                    if ($.trim($(this).val()) == '') {
                        flag = false;
                        $(this).parents('.form-group').addClass('has-danger');
                    }else{
                        $(this).parents('.form-group').removeClass('has-danger');
                    }
                });
                return flag;

            }, "");

            $.validator.addMethod("amount", function (value, element) {
                var flag = true;
                $(".payment-detail-row [name^=amount], .payment-detail-old-row [name^=amount]").each(function (i, j) {
                    if ($.trim($(this).val()) == '') {
                        flag = false;
                        $(this).parents('.form-group').addClass('has-danger');
                    }else{
                        $(this).parents('.form-group').removeClass('has-danger');
                    }
                });
                return flag;

            }, "");


            $('#nemc-general-form').validate({
                rules:{

                    title: {
                        required: true,
                    },

                    code: {
                        required: true,
                    },

                    "student_category_id[]": {
                        student_category: true,
                    },

                    "course_id[]": {
                        course: true,
                    },

                    "amount[]": {
                        amount: true,
                    },

                }
            });

        })(jQuery);
    </script>
@endpush

