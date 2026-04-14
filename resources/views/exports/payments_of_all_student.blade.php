<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
</head>
<body>
<div
    style="box-sizing:border-box;width:90%;max-width:1140px;padding-right:15px;padding-left:15px;margin-right:auto;margin-left:auto;">
    <div
        style="box-sizing:border-box;display:flex;-ms-flex-wrap:wrap;flex-wrap:wrap;margin-right:-15px;margin-left:-15px;">
        <div
            style="box-sizing:border-box;position:relative;width:100%;padding-right:15px;padding-left:15px;-ms-flex:0 0 100%;flex:0 0 100%;max-width:100%;">
            <div style="box-sizing:border-box;text-align:center;">
                <h4 style="margin-bottom:0; text-align:center;">North East Medical College</h4>
                <h5 style="box-sizing:border-box;;margin-bottom:.5rem;line-height:1.2;margin-top:0;font-weight:bold;">
                    Session: {{$session}}, Course: {{$course}}</h5>
            </div>
        </div>
        <br/>
        <div
            style="box-sizing:border-box;position:relative;width:100%;padding-right:15px;padding-left:15px;-ms-flex:0 0 100%;flex:0 0 100%;max-width:100%;">
            <div
                style="box-sizing:border-box;display:block;width:100%;overflow-x:auto;-webkit-overflow-scrolling:touch;">
                @if(isset($studentInstallments) && !empty($studentInstallments))
                    <h4 class="text-center">{{$paymentType[$paymentTypeId]}} Report</h4>
                    <table>
                        <thead>
                        <tr>
                            <th scope="col">Student Name</th>
                            <th scope="col">Title</th>
                            <th scope="col">Payable Amount</th>
                            <th scope="col">Discount</th>
                            <th scope="col">Last Payment Date</th>
                            <th scope="col">Amount</th>
                            <th scope="col">Payment Method</th>
                            <th scope="col">Payment Date</th>
                            <th scope="col">Entry By - DateTime</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($studentInstallments as $installment)
                                <?php
                                $rowSpan = !empty(count($installment->studentPaymentDetails)) ? count($installment->studentPaymentDetails) + 1 : 2;

                                ?>
                            <tr>
                                <td rowspan="{{$rowSpan}}"><a
                                        href="{{route('students.show', $installment->fee->student->id)}}"
                                        target="_blank">{{$installment->fee->student->full_name_en .' (Roll No-'.$installment->fee->student->roll_no .')'}}</a>
                                </td>
                                <td rowspan="{{$rowSpan}}">{{$installment->paymentType->title}}</td>
                                <td rowspan="{{$rowSpan}}">{{formatAmount($installment->payable_amount)}}</td>
                                <td rowspan="{{$rowSpan}}">{{$installment->discount_amount}}</td>
                                <td rowspan="{{$rowSpan}}">{{\Carbon\Carbon::createFromFormat('d/m/Y', $installment->last_date_of_payment)->format('d-F-Y')}}</td>

                            </tr>
                            @if(!empty($installment->studentPaymentDetails->toArray()))
                                @foreach($installment->studentPaymentDetails as $payment)
                                    <tr>
                                        <td>{{formatAmount($payment->amount)}}</td>
                                        <td>{{optional($payment->studentPayment->paymentMethod)->title}}</td>
                                        <td>{{\Carbon\Carbon::createFromFormat('d/m/Y', $payment->studentPayment->payment_date)->format('d-F-Y')}}</td>
                                        <td>By- {{$payment->studentPayment->user->first_name ?? ''}} At- {{\Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $payment->studentPayment->created_at)->format('d-m-y/h:i:s A')}}</td>
                                    </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td>-</td>
                                    <td>-</td>
                                    <td>-</td>
                                    <td>-</td>
                                </tr>
                            @endif
                        @endforeach
                        </tbody>
                    </table>
                @endif

                @if(isset($studentPayments) && !empty($studentPayments) && $paymentTypeId > 1)
                    <h4 class="text-center" style="text-align: center">{{$paymentType[$paymentTypeId]}} Report</h4>
                    <table>
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
                        @foreach($studentPayments as $feeDetails)
                                <?php
                                $rowSpan2 = count($feeDetails['payments']) > 0 ? count($feeDetails['payments']) : 1;
                                $billYear = $feeDetails['bill_year'];
                                $billMonth = \Carbon\Carbon::createFromFormat('!m', $feeDetails['bill_month']);
//                                ?>
                            <tr>
                                <td rowspan=" {{$rowSpan2}}">
                                    <a href="{{route('students.show',$feeDetails['student_id'])}}"
                                       target="_blank">{{$feeDetails['name'] .' (Roll No-'.$feeDetails['roll'] .')'}}</a>
                                </td>
                                <td rowspan=" {{$rowSpan2}}"> {{$paymentType[$feeDetails['fee_payment_type_id']]}}</td>
                                <td rowspan=" {{$rowSpan2}}">{{formatAmount($feeDetails['payable_amount'])}}</td>
                                <td rowspan=" {{$rowSpan2}}">{{$feeDetails['discount_amount']}}</td>
                                <td rowspan=" {{$rowSpan2}}">{{\Carbon\Carbon::createFromFormat('Y-m-d', $feeDetails['last_date_of_payment'])->format('d-F-Y')}}</td>

                                @if(count($feeDetails['payments']))

                                    @foreach($feeDetails['payments'] as $payment2)
                                        @if($loop->index>0)

                                            <tr>
                                        @endif
                                                <td class="custom-border">{{formatAmount($payment2->payment_amount)}}</td>
                                                <td>{{$payment2->payment_method}}</td>
                                                <td>{{\Carbon\Carbon::createFromFormat('Y-m-d',$payment2->payment_date)->format('d-F-Y')}}</td>
                                                <td>{{$billMonth->format('F')}}, {{$billYear}}</td>
                                                <td>By- {{$payment2->user_name ??''}} At- {{\Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $payment2->created_at)->format('d-m-y/h:i:s A')}}</td>
                                        @if(count($feeDetails['payments'])== ($loop->index))

                                            </tr>
                                        @endif
                                    @endforeach
                                @else
                                    <td class="custom-border">-</td>
                                    <td>-</td>
                                    <td>-</td>
                                    <td>{{$billMonth->format('F')}}, {{$billYear}}</td>
                                    <td>-</td>
                                @endif
                            </tr>
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
