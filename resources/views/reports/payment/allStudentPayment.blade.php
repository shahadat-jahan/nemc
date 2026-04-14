@extends('layouts.default')
@section('pageTitle', $pageTitle)

@push('style')
    <style>
        .m-stack--demo.m-stack--ver .m-stack__item,
        .m-stack--demo.m-stack--hor .m-stack__demo-item {
            padding: 29px;
        }

        th.custom-border,
        td.custom-border {
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
                            <h3 class="m-portlet__head-text"><i class="fas fa-list-ul fa-md pr-2"></i>{{ $pageTitle }}
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
                                    <div class="form-group">
                                        <select class="form-control" name="paymentType_id" id="paymentType_id">
                                            <option value="">---- Select Payment Type ----</option>
                                            {!! select($paymentType, app()->request->paymentType_id) !!}
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-xs-12 col-sm-6 col-md-4 col-lg-4 col-xl-4">
                                    <div class="form-group  m-form__group">
                                        <input type="text" class="form-control m-input m_datepicker" name="from_date"
                                            value="{{ app()->request->from_date }}" id="from_date" placeholder="Date From"
                                            autocomplete="off" />
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-6 col-md-4 col-lg-4 col-xl-4">
                                    <div class="form-group  m-form__group">
                                        <input type="text" class="form-control m-input m_datepicker" name="to_date"
                                            value="{{ app()->request->to_date }}" id="to_date" placeholder="Date To"
                                            autocomplete="off" />
                                    </div>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-xs-12 col-sm-6 col-md-12 col-lg-12 col-xl-12">
                                    <div class="pull-right search-action-btn">
                                        @if ((is_array($studentInstallments) && !empty($studentInstallments)) || !empty($studentFeeDetails))
                                            <div class="btn-group" data-hover="dropdown">
                                                <button type="button"
                                                    class="btn btn-primary m-btn m-btn--icon pdf-dropdown-btn"
                                                    data-toggle="dropdown" data-trigger="hover" aria-haspopup="true"
                                                    aria-expanded="false">
                                                    <i class="fa fa-file-pdf"></i> PDF Download <i
                                                        class="pt-1 fa fa-angle-down angle-icon"></i>
                                                </button>
                                                <div class="dropdown-menu dropdown-menu-right w-100">
                                                    <a class="dropdown-item"
                                                        href="{{ route('report.payment.all.student.pdf', array_merge(request()->all(), ['page_layout' => 'A4-landscape'])) }}"
                                                        target="_blank">
                                                        <i class="fas fa-arrows-alt-h"></i> Landscape
                                                    </a>
                                                    <a class="dropdown-item"
                                                        href="{{ route('report.payment.all.student.pdf', array_merge(request()->all(), ['page_layout' => 'A4-portrait'])) }}"
                                                        target="_blank">
                                                        <i class="fas fa-arrows-alt-v"></i> Portrait
                                                    </a>
                                                </div>
                                            </div>
                                            <a href="{{ route('report.payment.all.student.excel', [
                                                'session_id' => app()->request->session_id,
                                                'course_id' => app()->request->course_id,
                                                'paymentType_id' => app()->request->paymentType_id,
                                                'from_date' => app()->request->from_date,
                                                'to_date' => app()->request->to_date,
                                            ]) }}"
                                                class="btn btn-primary m-btn m-btn--icon"><i class="fa fa-file-export"></i>
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
                        @if (is_array($studentInstallments) && !empty($studentInstallments))
                            <div class="row">
                                <div class="col-md-12">
                                    <h4 class="text-center">{{ $paymentType[app()->request->paymentType_id] }} Report</h4>
                                    <div class="table-responsive">
                                        <table class="table table-bordered">
                                            <thead>
                                                <tr>
                                                    <th scope="col">Student Name</th>
                                                    <th scope="col">Title</th>
                                                    <th scope="col">Payable Amount</th>
                                                    <th scope="col">Discount</th>
                                                    <th scope="col">Last Payment Date</th>
                                                    <th scope="col" class="custom-border">Amount</th>
                                                    <th scope="col">Payment Method</th>
                                                    <th scope="col">Payment Date</th>
                                                    <th scope="col">Entry By - DateTime</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($studentInstallments as $installment)
                                                    <?php
                                                    $rowSpan = !empty(count($installment->studentPaymentDetails)) ? count($installment->studentPaymentDetails) + 1 : 2;
                                                    ?>
                                                    <tr>
                                                        <td rowspan="{{ $rowSpan }}"><a
                                                                href="{{ route('students.show', $installment->fee->student->id) }}"
                                                                target="_blank">{{ $installment->fee->student->full_name_en . ' (Roll No-' . $installment->fee->student->roll_no . ')' }}</a>
                                                        </td>
                                                        <td rowspan="{{ $rowSpan }}">
                                                            {{ $installment->paymentType->title }}</td>
                                                        <td rowspan="{{ $rowSpan }}">
                                                            {{ formatAmount($installment->payable_amount) }}</td>
                                                        <td rowspan="{{ $rowSpan }}">
                                                            {{ $installment->discount_amount ?? '0.00' }}</td>
                                                        <td rowspan="{{ $rowSpan }}">
                                                            {{ \Carbon\Carbon::createFromFormat('d/m/Y', $installment->last_date_of_payment)->format('d-F-Y') }}
                                                        </td>
                                                    </tr>
                                                    @if (!empty($installment->studentPaymentDetails))
                                                        @foreach ($installment->studentPaymentDetails as $payment)
                                                            <tr>
                                                                <td class="custom-border">
                                                                    {{ formatAmount($payment->amount) }}</td>
                                                                <td>{{ optional($payment->studentPayment->paymentMethod)->title }}
                                                                </td>
                                                                <td>{{ \Carbon\Carbon::createFromFormat('d/m/Y', $payment->studentPayment->payment_date)->format('d-F-Y') }}
                                                                </td>
                                                                <td>By-
                                                                    {{ $payment->studentPayment->user->first_name ?? '' }}
                                                                    At-
                                                                    {{ \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $payment->studentPayment->created_at)->format('d-m-y/h:i:s A') }}
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
                        @if (isset($studentFeeDetails) && !empty($studentFeeDetails) && app()->request->paymentType_id > 1)
                            <div class="row">
                                <div class="col-md-12">
                                    <h4 class="text-center">{{ $paymentType[app()->request->paymentType_id] }} Report</h4>
                                    <div class="table-responsive">
                                        <table class="table table-bordered">
                                            <thead>
                                                <tr>
                                                    <th scope="col">Student Name</th>
                                                    <th scope="col">Title</th>
                                                    <th scope="col">Payable Amount</th>
                                                    <th scope="col">Discount</th>
                                                    <th scope="col">Last Payment Date</th>
                                                    <th scope="col" class="custom-border">Amount</th>
                                                    <th scope="col">Payment Method</th>
                                                    <th scope="col">Payment Date</th>
                                                    <th scope="col">Bill For</th>
                                                    <th scope="col">Entry By - DateTime</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($studentFeeDetails as $feeDetails)
                                                    <?php
                                                    $rowSpan2 = count($feeDetails['payments']) > 0 ? count($feeDetails['payments']) : 1;
                                                    $billYear = $feeDetails['bill_year'];
                                                    $billMonth = \Carbon\Carbon::createFromFormat('!m', $feeDetails['bill_month']);
                                                    ?>
                                                    <tr>
                                                        <td rowspan=" {{ $rowSpan2 }}">
                                                            <a href="{{ route('students.show', $feeDetails['student_id']) }}"
                                                                target="_blank">{{ $feeDetails['name'] . ' (Roll No-' . $feeDetails['roll'] . ')' }}</a>
                                                        </td>
                                                        <td rowspan=" {{ $rowSpan2 }}">
                                                            {{ $paymentType[$feeDetails['fee_payment_type_id']] }}</td>
                                                        <td rowspan=" {{ $rowSpan2 }}">
                                                            {{ formatAmount($feeDetails['payable_amount']) }}</td>
                                                        <td rowspan=" {{ $rowSpan2 }}">
                                                            {{ $feeDetails['discount_amount'] ?? '0.00' }}</td>
                                                        <td rowspan=" {{ $rowSpan2 }}">
                                                            {{ \Carbon\Carbon::createFromFormat('Y-m-d', $feeDetails['last_date_of_payment'])->format('d-F-Y') }}
                                                        </td>
                                                        @if (count($feeDetails['payments']))
                                                            @foreach ($feeDetails['payments'] as $payment)
                                                                @if ($loop->index > 0)
                                                    <tr>
                                                @endif
                                                <td class="custom-border">{{ formatAmount($payment->payment_amount) }}
                                                </td>
                                                <td>{{ $payment->payment_method }}</td>
                                                <td>{{ \Carbon\Carbon::createFromFormat('Y-m-d', $payment->payment_date)->format('d-F-Y') }}
                                                </td>
                                                <td>{{ $billMonth->format('F') }}, {{ $billYear }}</td>
                                                <td>By- {{ $payment->user_name ?? '' }} At-
                                                    {{ \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $payment->created_at)->format('d-m-y/h:i:s A') }}
                                                </td>
                                                @if (count($feeDetails['payments']) == $loop->index)
                                                    </tr>
                                                @endif
                        @endforeach
                    @else
                        <td class="custom-border">-</td>
                        <td>-</td>
                        <td>-</td>
                        <td>{{ $billMonth->format('F') }}, {{ $billYear }}</td>
                        <td>-</td>
                        @endif
                        </tr>
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
        $('.search-result').click(function() {
            valid = true;
            $('#nemc-general-form select').each(function() {
                if (($(this).val() == '')) {
                    valid = false;
                }
            });

            if (valid == false) {
                sweetAlert('Session, course, payment type & date from fields are required to search', 'error');
                return false;
            } else if ($('#from_date').val() == '') {
                sweetAlert('Session, course, payment type & date from fields are required to search', 'error');
                return false;
            } else {
                $('#nemc-general-form').submit();
            }
        });

        $(document).ready(function() {
            // Enable dropdown on hover for PDF button
            $('.btn-group[data-hover="dropdown"]').hover(
                function () {
                    $(this).find('.dropdown-menu').stop(true, true).delay(100).fadeIn(200);
                },
                function () {
                    $(this).find('.dropdown-menu').stop(true, true).delay(100).fadeOut(200);
                }
            );

            $('.btn-group[data-hover="dropdown"]').hover(
                function () {
                    $(this).find('.angle-icon').removeClass('fa-angle-down').addClass('fa-angle-up');
                },
                function () {
                    $(this).find('.angle-icon').removeClass('fa-angle-up').addClass('fa-angle-down');
                }
            );

        });

        $(".m_datepicker").datepicker({
            todayHighlight: !0,
            orientation: "bottom left",
            format: 'dd/mm/yyyy',
            autoclose: true,
        });
    </script>
@endpush
