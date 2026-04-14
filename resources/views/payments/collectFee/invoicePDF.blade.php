<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice NEMC</title>
    <style>
        h1, h2, h3, h4, h5, h6 {
            margin: 0;
            padding: 0;
        }

        p {
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
            width: 50%;
        }

        .row {
            display: flex;
            flex-wrap: wrap;
        }

        .col-6 {
            width: 50%;
            flex: 0 0 auto;
        }

        .body-section {
            padding: 16px;
            border: 1px solid gray;
        }

        .heading {
            font-size: 20px;
            margin-bottom: 08px;
        }

        .sub-heading {
            color: #262626;
            margin-bottom: 05px;
        }

        table {
            background-color: #fff;
            width: 100%;
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
            padding-top: 08px;
            padding-bottom: 08px;
        }

        .logo {
            margin-left: -30px;
        }

        .table-bordered {
            box-shadow: 0 0 5px 0.5px gray;
        }

        .table-bordered td, .table-bordered th {
            border: 1px solid #dee2e6;
        }

        .text-right {
            text-align: right;
        }

        .text-center {
            text-align: center;
        }

        .text-decoration-none {
            text-decoration: none;
        }

        .w-20 {
            width: 20%;
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

        .text-white {
            color: #fff !important;
        }

    </style>
</head>
<body>

<?php
$studentInfo = $paymentInvoice['studentInfo'];
$invoices = $paymentInvoice['invoice'];
?>

<div class="container">
    <div class="brand-section">
        <div class="row">
            <div style="padding: 10px" class="col-12">
                <img class="logo" src="{{asset('assets/global/img/logo.jpg')}}" style="width: 12rem;"/>
                <h2 style="margin-top: -35px" class="text-center">
                    North East Medical College, Sylhet
                </h2>
            </div>
            <!--                <div class="col-6">
                                <div class="company-details">
                                    <p class="text-white">assdad asd  asda asdad a sd</p>
                                    <p class="text-white">assdad asd asd</p>
                                    <p class="text-white">+91 888555XXXX</p>
                                </div>
                            </div>-->
        </div>
    </div>

    <div class="body-section">
        <div class="row info">
            <div class="col-6 info_one">
                <h2 class="heading">Invoice No.: {{$studentInfo->invoice_no}}</h2>
                <p class="sub-heading">Payment Date: {{$studentInfo->payment_date}} </p>
                <p class="sub-heading">Payment Method:
                    {{ \App\Models\PaymentMethod::where(['id' => $studentInfo->payment_method_id])->pluck('title')->first() }}
                </p>
                <p class="sub-heading">Bank Name:
                    {{ \App\Models\Bank::where(['id' => $studentInfo->bank_id])->pluck('title')->first() }}
                </p>
            </div>
            <div class="col-6 info_two">
                <p class="sub-heading">Student Name: {{ $studentInfo->student->full_name_en }}</p>
                <p class="sub-heading">Student Roll: {{ $studentInfo->student->roll_no }}</p>
                <p class="sub-heading">Session:{{$studentInfo->student->session->title}}  </p>
                <p class="sub-heading">Course:{{$studentInfo->student->course->title}}  </p>
            </div>
        </div>
    </div>

    <div class="body-section">
        <h3 class="heading">Collect Fees</h3>
        <br>
        <table class="table-bordered">
            <thead>
            <tr>
                <th class="w-20">Payment Type</th>
                <th class="w-20">Due Amount</th>
                <th class="w-20">Discount Amount</th>
                <th class="w-20">Payable Amount</th>
                <th class="w-20">Paid Amount</th>
                <th class="w-20">Total Due</th>
                <th class="w-20">Advance Amount</th>
            </tr>
            </thead>
            <tbody>
            <?php
            $total_amount = [];
            $total_discount_amount = [];
            $total_pay_amount = [];
            $total_payable = [];
            $total_due = [];
            $total_advance = [];
            $remarks = '';

            if (!empty($invoices)) {
            foreach ($invoices as $invoice) {
                $discount_amount = !empty($invoice->discount_amount) ? $invoice->discount_amount : 0;
                $total = !empty($invoice->due_amount) ? $invoice->due_amount : 0;
                $paidAmount = !empty($invoice->amount) ? $invoice->amount : 0;
                $payable = $total - $discount_amount;
                $due = $payable > $paidAmount ? $payable - $paidAmount : 0;
                $advance = $payable < $paidAmount ? $paidAmount - $payable : 0;
                $total_discount_amount[] = !empty($invoice->discount_amount) ? $invoice->discount_amount++ : 0;
                $total_amount[] = !empty($invoice->amount) ? $invoice->amount++ : 0;
                $total_pay_amount[] = !empty($invoice->due_amount) ? $invoice->due_amount++ : 0;
                $total_payable[] = $payable++;
                $total_due[] = $due++;
                $total_advance[] = $advance++;
                $remarks = !empty($invoice->remarks) ? $invoice->remarks : '';
                ?>
            <tr>
                <td>{{ \App\Models\PaymentType::where(['id' => $invoice->payment_type_id])->pluck('title')->first() }}</td>
                <td>{{$total}}</td>
                <td>{{$discount_amount}}</td>
                <td>{{$payable - 1}}</td>
                <td>{{$paidAmount}}</td>
                <td>{{$due - 1}}</td>
                <td>{{$advance - 1}}</td>
            </tr>
            <?php }
            } ?>
            <tr>
                <th class="w-20">Total Amount</th>
                <th class="w-20">{{array_sum($total_pay_amount)}}</th>
                <th class="w-20">{{array_sum($total_discount_amount)}}</th>
                <th class="w-20">{{array_sum($total_payable)}}</th>
                <th class="w-20">{{array_sum($total_amount)}}</th>
                <th class="w-20">{{array_sum($total_due)}}</th>
                <th class="w-20">{{array_sum( $total_advance)}}</th>
            </tr>
            <tr>
                <td class="text-right">Remarks</td>
                <td colspan="6"> {{$remarks}}</td>
            </tr>
            <!--                    <tr>
                        <td colspan="3" class="text-right">Sub Total</td>
                        <td> {{array_sum($total_amount)}}</td>
                    </tr>
                    <tr>
                        <td colspan="3" class="text-right">Tax Total(%)</td>
                        <td> 0</td>
                    </tr>
                    <tr>
                        <td colspan="3" class="text-right">Grand Total</td>
                        <td>{{array_sum($total_amount)}} </td>
                    </tr>-->
            </tbody>
        </table>
        <br>
        <h3 class="heading">Payment Status: Paid</h3>
        <!--            <h3 class="heading">Payment Mode: Cash on Delivery</h3>-->
    </div>
    <div class="body-section">
        <p>&copy; Copyright {{date('Y')}} - <a href="https://www.vivasoftltd.com/" class="text-decoration-none">Vivasoft
                Ltd.</a>
            All
            rights reserved.

        </p>
    </div>
</div>
</body>
</html>
