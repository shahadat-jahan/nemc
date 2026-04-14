@extends('frontend.layouts.default')
@section('pageTitle', $pageTitle)

@push('style')
    <style>
        .m-stack--demo.m-stack--ver .m-stack__item, .m-stack--demo.m-stack--hor .m-stack__demo-item{
            padding: 29px;
        }
        th.custom-border, td.custom-border {
            border-left-width: 6px;
            border-left-color: #f4f5f8;
        }
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
                </div>

                <div class="m-portlet__body">
                    <div class="m-section__content">
                        <form id="nemc-general-form" role="form" method="get">
                        <div class="row">
                            <div class="col-xs-12 col-sm-6 col-md-4 col-lg-4 col-xl-4">
                                <div class="form-group">
                                    <select class="form-control" name="session_id" id="session_id">
                                        <option value="">---- Select Session ----</option>
                                        {!! select($sessions, app()->request->session_id) !!}
                                    </select>
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-6 col-md-4 col-lg-4 col-xl-4">
                                <div class="form-group">
                                    <select class="form-control" name="course_id" id="course_id">
                                        <option value="">---- Select Course ----</option>
                                        {!! select($courses, app()->request->course_id) !!}
                                    </select>
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-6 col-md-4 col-lg-4 col-xl-4">
                                <select class="form-control m-bootstrap-select m_selectpicker" name="student_id" id="student_id" data-live-search="true">
                                    <option value="">---- Select Student----</option>
                                </select>
                            </div>

                        </div>
                            <div class="row">
                                <div class="col-xs-12 col-sm-6 col-md-4 col-lg-4 col-xl-4">
                                    <div class="form-group  m-form__group">
                                        <input type="text" class="form-control m-input m_datepicker" name="from_date" value="{{app()->request->from_date}}" id="from_date" placeholder="Date From" autocomplete="off"/>
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-6 col-md-4 col-lg-4 col-xl-4">
                                    <div class="form-group  m-form__group">
                                        <input type="text" class="form-control m-input m_datepicker" name="to_date" value="{{app()->request->to_date}}" id="to_date" placeholder="Date To" autocomplete="off"/>
                                    </div>
                                </div>
                            </div>
                        <div class="row mb-3">
                            <div class="col-xs-12 col-sm-6 col-md-12 col-lg-12 col-xl-12">
                                <div class="pull-right search-action-btn">
                                    @if(!empty($studentInstallments->toArray()) || !empty($studentPayments->toArray()))
                                        <a href="{{route(customRoute('report.paymnet.student.excel'), [
                                        'session_id' => app()->request->session_id,
                                        'course_id' => app()->request->course_id,
                                        'student_id' => app()->request->student_id,
                                        'from_date' => app()->request->from_date,
                                        'to_date' => app()->request->to_date,
                                    ])}}" class="btn btn-primary m-btn m-btn--icon"><i class="fa fa-file-export"></i> Export</a>
                                    @endif
                                    <button class="btn btn-primary m-btn m-btn--icon search-result"><i class="fa fa-search"></i> Search</button>
                                    <button type="reset" class="btn btn-default reset"><i class="fas fa-sync-alt search-reset"></i> Reset</button>
                                </div>
                            </div>
                        </div>
                        </form>

                        @if(isset($studentInstallments) && !empty($studentInstallments->toArray()))
                        <div class="row">
                            <div class="col-md-12">
                                <h4 class="text-center">Development Fee</h4>
                                <div class="table-responsive">
                                    <table class="table table-bordered">
                                        <thead>
                                        <tr>
                                            <th scope="col">Title</th>
                                            <th scope="col">Payable Amount </th>
                                            <th scope="col">Discount</th>
                                            <th scope="col">Last Payment Date</th>
                                            <th scope="col">Amount</th>
                                            <th scope="col">Payment Method</th>
                                            <th scope="col">Payment Date</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($studentInstallments as $installment)
                                            <?php
                                            $colSpan = !empty(count($installment->studentPaymentDetails)) ? count($installment->studentPaymentDetails) + 1 : 2;
                                            ?>
                                            <tr>
                                                <td rowspan="{{$colSpan}}">{{$installment->paymentType->title}}</td>
                                                <td rowspan="{{$colSpan}}">{{formatAmount($installment->payable_amount)}}</td>
                                                <td rowspan="{{$colSpan}}">{{$installment->discount_amount}}</td>
                                                <td rowspan="{{$colSpan}}">{{$installment->last_date_of_payment}}</td>
                                                <td colspan="5"></td>
                                            </tr>
                                            @if(!empty($installment->studentPaymentDetails->toArray()))
                                                @foreach($installment->studentPaymentDetails as $payment)
                                                    <tr>
                                                        <td>{{formatAmount($payment->amount)}}</td>
                                                        <td>{{optional($payment->studentPayment->paymentMethod)->title}}</td>
                                                        <td>{{$payment->studentPayment->payment_date}}</td>
                                                    </tr>
                                                @endforeach
                                            @else
                                                <tr>
                                                    <td>-</td>
                                                    <td>-</td>
                                                    <td>-</td>
                                                </tr>
                                            @endif
                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        @endif

                        @if(isset($studentPayments) && !empty($studentPayments->toArray()))
                        <div class="row">
                            <div class="col-md-12">
                                <h4 class="text-center">Tuition Fees & Other Fees</h4>
                                <div class="table-responsive">
                                    <table class="table table-bordered">
                                        <thead>
                                        <tr>
                                            <th scope="col">Title</th>
                                            <th scope="col">Payable Amount </th>
                                            <th scope="col">Discount</th>
                                            <th scope="col">Detail</th>
                                            <th scope="col">Last Payment Date</th>
                                            <th scope="col" class="custom-border">Amount</th>
                                            <th scope="col">Payment Method</th>
                                            <th scope="col">Payment Date</th>
                                            <th scope="col">Bill For</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($studentPayments as $studentPayment)
                                            <?php
                                            $colSpan2 = !empty(count($studentPayment->studentPaymentDetails)) ? count($studentPayment->studentPaymentDetails) + 1 : 2;
                                            $billYear = $studentPayment->feeDetails->first()->bill_year;
                                            $billMonth = \Carbon\Carbon::createFromFormat('!m', $studentPayment->feeDetails->first()->bill_month);
                                            ?>
                                            <tr>
                                                <td rowspan="{{$colSpan2}}">{{$studentPayment->title}}</td>
                                                <td rowspan="{{$colSpan2}}">{{formatAmount($studentPayment->payable_amount)}}</td>
                                                <td rowspan="{{$colSpan2}}">{{$studentPayment->discount_amount}}</td>
                                                <td rowspan="{{$colSpan2}}">
                                                    @foreach($studentPayment->feeDetails as $fee)
                                                        <div style="width: 200px">{{$fee->paymentType->title}} - {{formatAmount($fee->payable_amount)}}</div>
                                                    @endforeach
                                                </td>
                                                <td rowspan="{{$colSpan2}}">{{$studentPayment->feeDetails->first()->last_date_of_payment}}</td>
                                                <td colspan="5"></td>
                                            </tr>
                                            @if(!empty($studentPayment->studentPaymentDetails->toArray()))
                                                @foreach($studentPayment->studentPaymentDetails as $payment2)
                                                    <tr>
                                                        <td class="custom-border">{{formatAmount($payment2->amount)}}</td>
                                                        <td>{{optional($payment2->studentPayment->paymentMethod)->title}}</td>
                                                        <td>{{$payment2->studentPayment->payment_date}}</td>
                                                        <td>{{$billMonth->format('F')}}, {{$billYear}}</td>
                                                    </tr>
                                                @endforeach
                                            @else
                                                <tr>
                                                    <td class="custom-border">-</td>
                                                    <td>-</td>
                                                    <td>-</td>
                                                    <td>{{$billMonth->format('F')}}, {{$billYear}}</td>
                                                </tr>
                                            @endif
                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        @endif

                    </div>
                </div>

            </div>
        </div>
    </div>

@endsection

@push('scripts')
    <script>
        //search form dropdown validation
        $('.search-result').click(function () {
            valid = true;
            $('#nemc-general-form select').each(function () {
                if (($(this).val() == '')){
                    valid = false;
                }
            });

            if(valid == false){
                sweetAlert('Session, course, student & date from fields are required to search', 'error');
                return false;
            }else if($('#from_date').val() == ''){
                sweetAlert('Session, course, student & date from fields are required to search', 'error');
                return false;
            }else{
                $('#nemc-general-form').submit();
            }
        });

        $(".m_datepicker").datepicker( {
            todayHighlight: !0,
            orientation: "bottom left",
            format: 'dd/mm/yyyy',
            autoClose: true,
        });


        //get student by session and course id
        var studentId = '<?php echo app()->request->student_id; ?>';

        function makeStudentIdAndUserId(sessionId, courseId){
            if (courseId > 0 && sessionId > 0){
                mApp.blockPage({
                    overlayColor: "#000000",
                    type: "loader",
                    state: "primary",
                    message: "Please wait..."
                });

                $.get('<?php echo e(route(customRoute('student.info.session.course'))); ?>', {courseId: courseId, sessionId: sessionId, _token: "<?php echo e(csrf_token()); ?>"}, function (response) {
                    $("#student_id").html('<option value="">---- Select Student ----</option>');
                    for (var i = 0; i < response.length; i++) {
                        selected = (studentId == response[i].id) ? 'selected' : '';
                        $("#student_id").append('<option value="' + response[i].id + '" '+ selected +'>' + response[i].full_name_en + '</option>');
                    }
                    $('.m_selectpicker').selectpicker('refresh');
                    mApp.unblockPage();
                });
            }
        }


        $('#session_id, #course_id').change(function (e) {
            e.preventDefault();
            sessionId = $('#session_id').val();
            courseId = $('#course_id').val();
            makeStudentIdAndUserId(sessionId, courseId);
        });

        if (studentId > 0){
            makeStudentIdAndUserId($('#session_id').val(), $('#course_id').val())
        }

    </script>
@endpush
