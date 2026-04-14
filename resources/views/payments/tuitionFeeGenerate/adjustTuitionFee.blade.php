@extends('layouts.default')
@section('pageTitle', $pageTitle)

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="m-portlet">
                <div class="m-portlet__head">
                    <div class="m-portlet__head-caption">
                        <div class="m-portlet__head-title">
                            <h3 class="m-portlet__head-text"><i class="fas fa-list-ul fa-md pr-2"></i>{{$pageTitle}}
                            </h3>
                        </div>
                    </div>
                    <div class="m-portlet__head-tools">
                        <a href="{{ route('student.tuition.fee.list') }}" class="btn btn-primary m-btn m-btn--icon"
                           title="Class Absent Fee"><i class="far fa-credit-card"></i> Student Tuition Fee</a>
                    </div>
                </div>

                <form class="m-form m-form--fit m-form--label-align-right" id="nemc-general-form"
                      action="{{ route('student.tuition.fee.adjust.update', $studentFeeInfo->id) }}" method="post"
                      enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="m-portlet__body">

                        <div class="row">
                            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                                <div class="form-group m-form__group">
                                    <label class="form-control-label">Student</label>
                                    <input type="text" class="form-control" name="student_id"
                                           value="{{$studentFeeInfo->student->full_name_en . ' (Roll No-'.$studentFeeInfo->student->roll_no. ')'}}"
                                           id="student_id" disabled>
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                                <div class="form-group m-form__group">
                                    <label class="form-control-label">Fee Title</label>
                                    <input type="text" class="form-control" name="title"
                                           value="{{$studentFeeInfo->title}}" id="title" disabled>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                                <div class="form-group m-form__group">
                                    <label class="form-control-label">Total Amount</label>
                                    <input type="number" class="form-control" name="total_amount"
                                           value="{{$studentFeeInfo->total_amount}}" id="total_amount"
                                           placeholder="Total Amount" disabled>
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                                <div class="form-group m-form__group">
                                    <label class="form-control-label">Payable Amount</label>
                                    <input type="number" class="form-control" name="payable_amount"
                                           value="{{$studentFeeInfo->payable_amount}}" id="payable_amount" disabled>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                                <div class="form-group m-form__group">
                                    <label class="form-control-label">Due Amount</label>
                                    <input type="number" class="form-control" name="due_amount"
                                           value="{{$studentFeeInfo->due_amount}}" id="due_amount"
                                           placeholder="Total Amount" disabled>
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                                <div class="form-group m-form__group">
                                    <label class="form-control-label">Adjust Payment Type</label>
                                    <select class="form-control m-bootstrap-select m_selectpicker"
                                            name="payment_type_id[]"
                                            id="payment_type_id" multiple>
                                        {!! select($paymentTypes) !!}
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                                <div class="form-group m-form__group">
                                    <label class="form-control-label">Adjust Amount</label>
                                    <input type="number" max="{{abs($studentFeeInfo->payable_amount)}}"
                                           class="form-control" name="request_adjust_amount"
                                           id="request_adjust_amount" readonly>
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                                <div class="form-group m-form__group ">
                                    <label class="form-control-label">Adjustment Application File</label>
                                    <input type="file" class="form-control-file" name="adjustment_application_file"
                                           id="adjustment_application_file">
                                    <small class="form-text text-muted">Accepted file formats: jpeg, jpg, png, pdf, doc,
                                        docx. Max file size: 1 MB.</small>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
                                <div class="form-group m-form__group ">
                                    <label class="form-control-label">Comment on Adjustment</label>
                                    <textarea class="form-control" name="remarks" id="remarks" rows="3"
                                              placeholder="Comment About Discount">{{$studentFeeInfo->remarks}}</textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="m-portlet__foot m-portlet__foot--fit">
                        <div class="m-form__actions text-center">
                            <a href="{{ route('student.tuition.fee.list') }}" class="btn btn-outline-brand"><i
                                    class="fa fa-times"></i> Cancel</a>
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
        var baseUrl = '{!! url('/') !!}/';
        const feeDetails = {!! json_encode($studentFeeInfo->feeDetails) !!};

        function updateDueAmount(paymentTypeIds = []) {
            let totalDue = 0;

            if (paymentTypeIds.length > 0) {
                const feeDetail = $.grep(feeDetails, function (item) {
                    return paymentTypeIds.includes(String(item.payment_type_id));
                });

                totalDue = feeDetail.reduce(function (sum, item) {
                    return sum + parseFloat(item.due_amount);
                }, 0);
            } else {
                const feeDetail = $.grep(feeDetails, function (item) {
                    return item.payment_type_id != 3;
                });

                totalDue = feeDetail.reduce(function (sum, item) {
                    return sum + parseFloat(item.due_amount);
                }, 0);
            }

            $('#request_adjust_amount').val(totalDue.toFixed(2));
        }

        $('#payment_type_id').change(function () {
            const paymentTypeIds = $(this).val() || []; // multiselect returns array
            updateDueAmount(paymentTypeIds);
        });

        $(document).ready(function () {
            const selected = $('#payment_type_id').val() || [];
            updateDueAmount(selected);
        });

        // Custom filesize validation
        $.validator.addMethod('filesize', function (value, element, param) {
            if (element.files.length === 0) return true;
            return (element.files[0].size <= param * 1024 * 1024);
        }, 'File size must not be greater than {0} MB');

        // jQuery Validation Init
        $('#nemc-general-form').validate({
            rules: {
                request_adjust_amount: {
                    required: true
                },
                'payment_type_id[]': {
                    required: true
                },
                adjustment_application_file: {
                    extension: "jpeg|jpg|png|pdf|doc|docx",
                    filesize: 1 // In MB
                },
                remarks: {
                    required: true
                }
            },
            messages: {
                adjustment_application_file: {
                    extension: 'Invalid file format. Accepted formats: jpeg, jpg, png, pdf, doc, docx.'
                }
            },
            errorPlacement: function (error, element) {
                if (element.hasClass('m-bootstrap-select')) {
                    error.insertAfter('.m-bootstrap-select.m_');
                } else {
                    error.insertAfter(element);
                }
            }
        });

    </script>
@endpush
