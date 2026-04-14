@extends('layouts.default')
@section('pageTitle', $pageTitle)

@push('style')
    <style>
        .m-stack--demo.m-stack--ver .m-stack__item, .m-stack--demo.m-stack--hor .m-stack__demo-item {
            padding: 29px;
        }

        th.custom-border, td.custom-border {
            border-left-width: 6px;
            border-left-color: #f4f5f8;
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
                            <h3 class="m-portlet__head-text"><i class="fas fa-list-ul fa-md pr-2"></i>{{$pageTitle}}
                            </h3>
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
                                    <select class="form-control m-bootstrap-select m_selectpicker" name="student_id"
                                            id="student_id" data-live-search="true">
                                        <option value="">---- Select Student----</option>
                                    </select>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4 col-xl-4">
                                    <div class="form-group">
                                        <input type="text" class="form-control m-input" name="student_user_id"
                                               id="student-user-id"
                                               value="{{app()->request->student_user_id}}" placeholder="Student ID"/>
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-6 col-md-4 col-lg-4 col-xl-4">
                                    <div class="form-group  m-form__group">
                                        <input type="text" class="form-control m-input m_datepicker" name="from_date"
                                               value="{{app()->request->from_date}}" id="from_date"
                                               placeholder="Date From" autocomplete="off"/>
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-6 col-md-4 col-lg-4 col-xl-4">
                                    <div class="form-group  m-form__group">
                                        <input type="text" class="form-control m-input m_datepicker" name="to_date"
                                               value="{{app()->request->to_date}}" id="to_date" placeholder="Date To"
                                               autocomplete="off"/>
                                    </div>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-xs-12 col-sm-6 col-md-12 col-lg-12 col-xl-12">
                                    <div class="pull-right search-action-btn">
                                        @if(!empty($studentInstallments->toArray()) || !empty($studentPayments->toArray()))
                                            <a target="_blank" href="{{route('report.payment.student.pdf', [
                                        'session_id' => app()->request->session_id,
                                        'course_id' => app()->request->course_id,
                                        'student_id' => app()->request->student_id,
                                        'from_date' => app()->request->from_date,
                                        'to_date' => app()->request->to_date,
                                    ])}}" class="btn btn-primary m-btn m-btn--icon"><i class="fa fa-file-pdf"></i>
                                                PDF</a>
                                            <a href="{{route('report.payment.student.excel', [
                                        'session_id' => app()->request->session_id,
                                        'course_id' => app()->request->course_id,
                                        'student_id' => app()->request->student_id,
                                        'from_date' => app()->request->from_date,
                                        'to_date' => app()->request->to_date,
                                    ])}}" class="btn btn-primary m-btn m-btn--icon"><i class="fa fa-file-export"></i>
                                                Export</a>
                                        @endif
                                        <button class="btn btn-primary m-btn m-btn--icon search-result"><i
                                                class="fa fa-search"></i> Search
                                        </button>
                                        <button type="reset" class="btn btn-default reset"><i
                                                class="fas fa-sync-alt search-reset"></i> Reset
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </form>

                        @if((isset($studentInstallments) && !empty($studentInstallments->toArray())) || (isset($studentPayments) && !empty($studentPayments->toArray())))
                            <div class="row">
                                <div class="col-md-12">
                                    <h4 class="text-center">Summary</h4>
                                    <div class="table-responsive">
                                        <table class="table table-bordered">
                                            <thead>
                                            <tr>
                                                <th>Item Name</th>
                                                <th>Total Amount</th>
                                                <th>Total Discount</th>
                                                <th>Total Payable</th>
                                                <th>Total Paid</th>
                                                <th>Total Due</th>
                                                <th>Total Balance</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <tr>
                                                <td>Development Fee</td>
                                                <td> {{ formatAmount($studentInstallments->sum('total_amount')) }}</td>
                                                <td> {{ formatAmount($studentInstallments->sum('discount_amount')) }}</td>
                                                <td> {{ formatAmount($studentInstallments->sum('payable_amount')) }}</td>
                                                <td> {{ formatAmount($studentInstallments->sum('payable_amount') - $studentInstallments->sum('due_amount')) }}</td>
                                                <td> {{ formatAmount($studentInstallments->sum('due_amount')) }}</td>
                                                <td> {{ formatAmount($totalDevelopmentAvailableAmount) }}</td>
                                            </tr>
                                            <tr>
                                                <td>Tuition Fee & Others Fee</td>
                                                <td> {{ formatAmount($studentPayments->sum('total_amount')) }}</td>
                                                <td> {{ formatAmount($studentPayments->sum('discount_amount')) }}</td>
                                                <td> {{ formatAmount($studentPayments->sum('payable_amount')) }}</td>
                                                <td> {{ formatAmount($studentPayments->sum('paid_amount')) }}</td>
                                                <td> {{ formatAmount($studentPayments->sum('due_amount')) }}</td>
                                                <td> {{ formatAmount($totalTuitionAvailableAmount) }}</td>
                                            </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        @endif

                        @if(isset($studentInstallments) && !empty($studentInstallments->toArray()))
                            <div class="row">
                                <div class="col-md-12">
                                    <h4 class="text-center">Development Fee</h4>
                                    <div class="table-responsive">
                                        <table class="table table-bordered">
                                            <thead>
                                            <tr>
                                                <th scope="col">Title</th>
                                                <th scope="col">Total Amount</th>
                                                <th scope="col">Payable Amount</th>
                                                <th scope="col">Total Discount</th>
                                                <th scope="col">Total Due</th>
                                                <th scope="col">Last Payment Date</th>
                                                <th class="custom-border" scope="col">Amount</th>
                                                <th scope="col">Payment Method</th>
                                                <th scope="col">Payment Date</th>
                                                <th scope="col">Entry By - DateTime</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            @foreach($studentInstallments as $installment)
                                                    <?php
                                                    $rowSpan = !empty(count($installment->studentPaymentDetails)) ? count($installment->studentPaymentDetails) + 1 : 2;
                                                    $discount = $installment->discount_amount;
                                                    ?>
                                                <tr>
                                                    <td rowspan="{{$rowSpan}}">{{$installment->paymentType->title}}</td>
                                                    <td rowspan="{{$rowSpan}}">{{formatAmount($installment->total_amount)}}</td>
                                                    <td rowspan="{{$rowSpan}}">{{formatAmount($installment->payable_amount)}}</td>
                                                    <td rowspan="{{$rowSpan}}">{{formatAmount($discount) ?? '0.00'}}</td>
                                                    <td rowspan="{{$rowSpan}}">{{ formatAmount($installment->due_amount) }}</td>
                                                    <td rowspan="{{$rowSpan}}">{{$installment->last_date_of_payment}}</td>
                                                </tr>
                                                @if(!empty($installment->studentPaymentDetails->toArray()))
                                                    @foreach($installment->studentPaymentDetails as $payment)
                                                            <?php
                                                            $paymentDiscount = $payment->studentPayment->discount_amount;
                                                            $feeDetailsDiscount = $installment->find($payment->student_fee_detail_id)->discount_amount;
                                                            $feeDetailsId = $payment->student_fee_detail_id;
                                                            $paymentDetailsCount = $installment->studentPaymentDetails->where('student_fee_detail_id', $feeDetailsId)->count();
                                                            $paymentDetailsCount > 1 ? $singleDiscount = $paymentDiscount : $singleDiscount = $feeDetailsDiscount;
                                                            ?>
                                                        <tr>
                                                            <td class="custom-border">{{formatAmount($payment->amount)}}</td>
                                                            <td>{{optional($payment->studentPayment->paymentMethod)->title}}</td>
                                                            <td>{{$payment->studentPayment->payment_date}}</td>
                                                            <td>By- {{$payment->studentPayment->user->first_name ?? ''}}
                                                                <br>
                                                                At- {{\Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $payment->studentPayment->created_at)->format('d-m-y/h:i:s A')}}
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                @else
                                                    <tr>
                                                        <td class="custom-border">-</td>
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
                                                <th scope="col">Detail</th>
                                                <th scope="col">Payable Amount</th>
                                                <th scope="col">Total Discount</th>
                                                <th scope="col">Total Due</th>
                                                <th scope="col">Last Payment Date</th>
                                                <th scope="col" class="custom-border">Amount</th>
                                                <th scope="col">Payment Method</th>
                                                <th scope="col">Payment Date</th>
                                                <th scope="col">Bill For</th>
                                                <th scope="col">Entry By - DateTime</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            @foreach($studentPayments as $studentPayment)
                                                    <?php
                                                    $rowSpan2 = !empty(count($studentPayment->studentPaymentDetails)) ? count($studentPayment->studentPaymentDetails) + 1 : 2;
                                                    $billYear = $studentPayment->feeDetails->first()->bill_year;
                                                    $billMonth = \Carbon\Carbon::createFromFormat('!m', $studentPayment->feeDetails->first()->bill_month);
                                                    $discount2 = 0;
                                                    foreach ($studentPayment->feeDetails as $studentFeeDetails) {
                                                        $discount2 = ($discount2 + $studentFeeDetails->discount_amount) ?? 0;
                                                    }
                                                    ?>
                                                <tr>
                                                    <td rowspan="{{$rowSpan2}}">{{$studentPayment->title}}</td>
                                                    <td rowspan="{{$rowSpan2}}">
                                                        @foreach($studentPayment->feeDetails as $fee)
                                                            <div style="width: 200px">{{$fee->paymentType->title}}
                                                                - {{formatAmount($fee->total_amount)}}</div>
                                                        @endforeach
                                                    </td>
                                                    <td rowspan="{{$rowSpan2}}">{{formatAmount($studentPayment->payable_amount)}}</td>
                                                    <td rowspan="{{$rowSpan2}}">{{formatAmount($discount2) ?? '0.00'}}</td>
                                                    <td rowspan="{{$rowSpan2}}">{{formatAmount($studentPayment->due_amount) }}</td>
                                                    <td rowspan="{{$rowSpan2}}">{{$studentPayment->feeDetails->first()->last_date_of_payment}}</td>

                                                </tr>
                                                @if(!empty($studentPayment->studentPaymentDetails->toArray()))
                                                    @foreach($studentPayment->studentPaymentDetails as $payment2)
                                                            <?php
                                                            $paymentDiscount = $payment2->studentPayment->discount_amount;
                                                            $feeDetailsDiscount = $studentPayment->feeDetails->find($payment2->student_fee_detail_id)->discount_amount;
                                                            $feeDetailsId = $payment2->student_fee_detail_id;
                                                            $paymentDetailsCount = $studentPayment->studentPaymentDetails->where('student_fee_detail_id', $feeDetailsId)->count();
                                                            $paymentDetailsCount > 1 ? $singleDiscount2 = $paymentDiscount : $singleDiscount2 = $feeDetailsDiscount;
                                                            ?>
                                                        <tr>
                                                            <td class="custom-border">{{formatAmount($payment2->amount)}}</td>
                                                            <td>{{optional($payment2->studentPayment->paymentMethod)->title}}</td>
                                                            <td>{{$payment2->studentPayment->payment_date}}</td>
                                                            <td>{{$billMonth->format('F')}}, {{$billYear}}</td>
                                                            <td>
                                                                By- {{$payment2->studentPayment->user->first_name ?? ''}}
                                                                <br>
                                                                At- {{\Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $payment2->studentPayment->created_at)->format('d-m-y/h:i:s A')}}
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                @else
                                                    <tr>
                                                        <td class="custom-border">-</td>
                                                        <td>-</td>
                                                        <td>-</td>
                                                        <td>{{$billMonth->format('F')}}, {{$billYear}}</td>
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
                if (($("#student-user-id").val() == '')) {
                    valid = false;
                }
            });

            if (valid == false) {
                sweetAlert('Session, course, student & date from fields are required to search', 'error');
                return false;
            } else if ($('#from_date').val() == '') {
                sweetAlert('Date from fields are required to search', 'error');
                return false;
            } else {
                $('#nemc-general-form').submit();
            }
        });

        $(".m_datepicker").datepicker({
            todayHighlight: !0,
            orientation: "bottom left",
            format: 'dd/mm/yyyy',
            autoclose: true,
        });

        var studentId = '<?php echo app()->request->student_id; ?>';
        var studentUserId = '<?php echo app()->request->student_user_id; ?>';

        //get student by session and course id
        function makeStudentIdAndUserId(sessionId, courseId) {
            if (courseId > 0 && sessionId > 0) {
                mApp.blockPage({
                    overlayColor: "#000000",
                    type: "loader",
                    state: "primary",
                    message: "Please wait..."
                });

                $.get('<?php echo e(route('student.info.session.course')); ?>', {
                    courseId: courseId,
                    sessionId: sessionId,
                    _token: "<?php echo e(csrf_token()); ?>"
                }, function (response) {
                    $("#student_id").html('<option value="">---- Select Student ----</option>');
                    $("#student-user-id").val('');
                    for (var i = 0; i < response.length; i++) {
                        selected = (studentId == response[i].id) ? 'selected' : '';
                        $("#student_id").append('<option data-user-id="' + response[i].user.user_id + '" value="' + response[i].id + '" ' + selected + '>' + response[i].full_name_en + ' (' + 'Roll No-' + response[i].roll_no + ')' + '</option>');
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

        $('#student_id').change(function (e) {
            e.preventDefault();

            studentUserId = $('#student_id option:selected').attr('data-user-id');
            $('#student-user-id').val(studentUserId);
        });

        $('#student-user-id').keyup(function (e) {
            e.preventDefault();

            $("#student_id").val('');
            $('.m_selectpicker').selectpicker('refresh');
        });

        if (studentId > 0 && studentUserId == 0) {
            $('#session_id, #course_id').trigger('change');
        } else {
            $('#session_id, #course_id').val('');
        }

    </script>
@endpush
