<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        h1, h2, h3, h4, h5, h6 {
            margin: 0;
            padding: 0;
        }

        p {
            margin: 0;
            padding: 0;
        }

        .brand-section {
            padding: 10px 40px;
        }

        .logo {
            width: 150px;
            margin-left: -30px;
        }

        .row {
            display: flex;
            flex-wrap: wrap;
        }

        .col-6 {
            width: 50%;
            flex: 0 0 auto;
        }

        table {
            border-collapse: collapse;
        }

        table thead tr {
            border: 1px solid #dee2e6;
        }

        table td {
            vertical-align: middle !important;
            text-align: center;
        }

        table th, table td {
            padding: 5px;
        }

        .table-bordered {
            box-shadow: 0 0 5px 0.5px gray;
        }

        .table-bordered td, .table-bordered th {
            border: 1px solid #dee2e6;
        }

        .text-uppercase {
            text-transform: uppercase;
        }

        .text-center {
            text-align: center;
        }

        .text-left {
            text-align: left;
        }

        .text-right {
            text-align: right;
        }

        .w-30 {
            width: 30%;
        }

        .w-70 {
            width: 70%;
        }

        .float-right {
            float: right;
        }

        .info {
            width: 100%;
        }

        .info_one {
            width: 50%;
            float: left;
        }
    </style>
</head>
<body>
<div class="container">
    <div class="brand-section">
        <span>
            <img class="logo" src="{{asset('assets/global/img/logo.jpg')}}" alt="logo"/>
        </span>
        <div style="margin-top: -45px" class="text-center">
            <h2>North East Medical College, Sylhet</h2>
            <br>
            <?php
            $batch = $student->session->sessionDetails->where('course_id', $student->course_id)->first()->batch_number;
            ?>
            <h6 style="box-sizing:border-box;font-size:1rem;margin-bottom:.5rem;line-height:1.2;margin-top:0;font-weight:bold;">
                Session: {{$student->session->title}} ({{$student->course->title}} {{getOrdinal($batch)}} Batch)</h6>
            <h6 style="box-sizing:border-box;font-size:1rem;margin-bottom:.5rem;line-height:1.2;margin-top:0;font-weight:bold;">
                Name: {{$student->full_name_en}}, Roll: {{$student->roll_no}}</h6>
            {{--            <span>Session : {{$student->session->title}} </span>, <span>Course : {{$student->course->title}} </span>,--}}
            {{--            <span>Phase : {{$student->phase->name}} </span>, <span>Term : {{$student->term->title}}</span>--}}
        </div>
    </div>
    <br/>
    <div class="row">
        <div class="col-md-12">
            <div class="m-portlet">
                <div class="m-portlet__body">
                    <div class="m-section__content">
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
                                                        <td class="custom-border text-center">-</td>
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
                                                            $feeDetailsId = $studentPayment->feeDetails->find($payment2->student_fee_detail_id)->id;
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
</div>
</body>
</html>
