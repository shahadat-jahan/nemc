<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
</head>
<body>
<div style="box-sizing:border-box;width:90%;max-width:1140px;padding-right:15px;padding-left:15px;margin-right:auto;margin-left:auto;" >
    <div style="box-sizing:border-box;display:flex;-ms-flex-wrap:wrap;flex-wrap:wrap;margin-right:-15px;margin-left:-15px;" >
        <div style="box-sizing:border-box;position:relative;width:100%;padding-right:15px;padding-left:15px;-ms-flex:0 0 100%;flex:0 0 100%;max-width:100%;" >
            <div style="box-sizing:border-box;text-align:center;" >
                <p style="font-size:2rem;margin-bottom:0; text-align:center;">North East Medical College</p>
                <?php
                $batch = $student->session->sessionDetails->where('course_id', $student->course_id)->first()->batch_number;
                ?>
                <h6 style="box-sizing:border-box;font-size:1rem;margin-bottom:.5rem;line-height:1.2;margin-top:0;font-weight:bold;" >Session: {{$student->session->title}} ({{$student->course->title}} {{getOrdinal($batch)}} Batch)</h6>
                <h6 style="box-sizing:border-box;font-size:1rem;margin-bottom:.5rem;line-height:1.2;margin-top:0;font-weight:bold;" >Name: {{$student->full_name_en}}, Roll: {{$student->roll_no}}</h6>
            </div>
        </div>
        <br/>
        <div style="box-sizing:border-box;position:relative;width:100%;padding-right:15px;padding-left:15px;-ms-flex:0 0 100%;flex:0 0 100%;max-width:100%;" >
            <div style="box-sizing:border-box;display:block;width:100%;overflow-x:auto;-webkit-overflow-scrolling:touch;" >

                @if((isset($studentInstallments) && !empty($studentInstallments->toArray())) || (isset($studentPayments) && !empty($studentPayments->toArray())))
                    <div class="row">
                        <div class="col-md-12">
                            <h4 class="text-center">Summary</h4>
                            <div class="table-responsive">
                                <table class="table table-bordered">
                                    <thead>
                                    <tr>
                                        <th scope="col">Item Name</th>
                                        <th scope="col">Total Amount</th>
                                        <th scope="col">Total Discount</th>
                                        <th scope="col">Total Payable</th>
                                        <th scope="col">Total Paid</th>
                                        <th scope="col">Total Due</th>
                                        <th scope="col">Total Balance</th>
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
                                        <td>Tuition Fee and Others Fee</td>
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
                    <h4 class="text-center">Development Fee</h4>
                    <table>
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
                                    <td>-</td>
                                    <td>-</td>
                                    <td>-</td>
                                </tr>
                            @endif
                        @endforeach
                        </tbody>
                    </table>
                @endif

                @if(isset($studentPayments) && !empty($studentPayments->toArray()))
                    <h4 class="text-center">Tuition Fees And Other Fees</h4>
                        <table>
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
                @endif
            </div>
        </div>
    </div>
</div>
</body>
</html>
