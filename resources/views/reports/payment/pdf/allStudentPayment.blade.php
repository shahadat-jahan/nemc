<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>All Student Payment Report</title>
    <style>
        body {
            background-color: #F6F6F6;
            margin: 0;
            padding: 0;
            font-size: 11px;
        }

        h1, h2, h3, h4, h5, h6 {
            margin: 0;
            padding: 0;
        }

        .container {
            width: 100%;
            margin-right: auto;
            margin-left: auto;
        }

        .brand-section {
            background-color: #ffffff;
            padding: 10px 40px;
        }

        .logo {
            width: 150px;
            margin-left: -30px;
        }

        .table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 1rem;
        }

        .table th,
        .table td {
            border: 1px solid #000;
            padding: 5px;
            text-align: center;
        }

        .table th {
            background-color: #f5f5f5;
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

        .custom-border {
            border-left-width: 6px;
            border-left-color: #f4f5f8;
        }

        .summary {
            margin-bottom: 20px;
        }
    </style>
</head>

<body>
<div class="container">
    <div class="brand-section">
        <span>
            <img class="logo" src="{{ asset('assets/global/img/logo.jpg') }}"/>
        </span>
        <div style="margin-top: -40px" class="text-center">
            <h2>North East Medical College, Sylhet</h2>
            <h3>All Student Payment Report</h3>
            <h4>Session: {{$session}}, Course: {{$course}}</h4>
            <h4>Payment Type: {{$paymentTypeTitle}}</h4>
            @if(isset($from_date) && isset($to_date))
                <h4>From {{$from_date}} to {{$to_date}}</h4>
            @endif
        </div>
        <p class="text-right" style="padding-right: -30px"><strong>Generated on:</strong> {{\Carbon\Carbon::today()->format('d/m/Y')}}</p>
    </div>
    <br/>

    @if (is_array($studentInstallments) && !empty($studentInstallments))
        <table class="table">
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
            @foreach($studentInstallments as $installment)
                @php
                    $rowSpan = !empty(count($installment->studentPaymentDetails)) ? count($installment->studentPaymentDetails) + 1 : 2;
                @endphp
                <tr>
                    <td rowspan="{{$rowSpan}}" class="text-left">{{$installment->fee->student->full_name_en .' (Roll No-'.$installment->fee->student->roll_no .')'}}</td>
                    <td rowspan="{{$rowSpan}}">{{$installment->paymentType->title}}</td>
                    <td rowspan="{{$rowSpan}}">{{formatAmount($installment->payable_amount)}}</td>
                    <td rowspan="{{$rowSpan}}">{{$installment->discount_amount ?? '0.00'}}</td>
                    <td rowspan="{{$rowSpan}}">{{\Carbon\Carbon::createFromFormat('d/m/Y', $installment->last_date_of_payment)->format('d-F-Y')}}</td>
                </tr>
                @if(!empty($installment->studentPaymentDetails->toArray()))
                    @foreach($installment->studentPaymentDetails as $payment)
                        <tr>
                            <td class="custom-border">{{formatAmount($payment->amount)}}</td>
                            <td>{{optional($payment->studentPayment->paymentMethod)->title}}</td>
                            <td>{{\Carbon\Carbon::createFromFormat('d/m/Y', $payment->studentPayment->payment_date)->format('d-F-Y')}}</td>
                            <td>By- {{$payment->studentPayment->user->first_name ?? ''}} At- {{\Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $payment->studentPayment->created_at)->format('d-m-y/h:i:s A')}}</td>
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
    @endif

    @if (isset($studentFeeDetails) && !empty($studentFeeDetails) && app()->request->paymentType_id > 1)
        <div class="page-break"></div>
        <table class="table">
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
            @foreach($studentFeeDetails as $feeDetails)
                @php
                    $rowSpan2 = count($feeDetails['payments']) > 0 ? count($feeDetails['payments']) : 1;
                    $billYear = $feeDetails['bill_year'];
                    $billMonth = \Carbon\Carbon::createFromFormat('!m', $feeDetails['bill_month']);
                @endphp
                <tr>
                    <td rowspan="{{$rowSpan2}}" class="text-left">
                        {{$feeDetails['name'] .' (Roll No-'.$feeDetails['roll'] .')'}}
                    </td>
                    <td rowspan="{{$rowSpan2}}">{{$paymentTypeTitle}}</td>
                    <td rowspan="{{$rowSpan2}}">{{formatAmount($feeDetails['payable_amount'])}}</td>
                    <td rowspan="{{$rowSpan2}}">{{$feeDetails['discount_amount'] ?? '0.00'}}</td>
                    <td rowspan="{{$rowSpan2}}">{{\Carbon\Carbon::createFromFormat('Y-m-d', $feeDetails['last_date_of_payment'])->format('d-F-Y')}}</td>
                    @if(count($feeDetails['payments']))
                        @foreach($feeDetails['payments'] as $payment)
                            @if($loop->index>0)
                            <tr>
                            @endif
                                <td class="custom-border">{{formatAmount($payment->payment_amount)}}</td>
                                <td>{{$payment->payment_method}}</td>
                                <td>{{\Carbon\Carbon::createFromFormat('Y-m-d',$payment->payment_date)->format('d-F-Y')}}</td>
                                <td>{{$billMonth->format('F')}}, {{$billYear}}</td>
                                <td>By- {{$payment->user_name ??''}} At- {{\Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $payment->created_at)->format('d-m-y/h:i:s A')}}</td>
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

    <div class="summary">
        <p><strong>Note:</strong> This report shows all student payment details for the selected criteria.</p>
    </div>
</div>
</body>
</html>
