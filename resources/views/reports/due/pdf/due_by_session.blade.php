<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Students Due by Session</title>
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
            width: 100%;
            border-collapse: collapse;
        }

        table thead th {
            border: 1px solid #dee2e6;
            vertical-align: middle !important;
        }

        table td {
            vertical-align: middle !important;
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

        .summary-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
            font-family: sans-serif;
            border: 1px solid #000;
        }

        .summary-table th,
        .summary-table td {
            width: 50%;
            padding: 8px 10px;
            text-align: right;
            border: 1px solid #000;
        }

        .summary-table th {
            text-align: left;
        }

        .currency-header {
            text-align: center;
            font-weight: bold;
            padding: 8px;
        }

        .total-due {
            font-weight: bold;
        }

        @page {
            footer: page-footer;
        }
    </style>
</head>
<body>
<div class="container">
    <div class="brand-section">
        <span>
            <img class="logo" src="{{asset('assets/global/img/logo.jpg')}}"/>
        </span>
        <div style="margin-top: -45px" class="text-center">
            <h2>North East Medical College, Sylhet</h2>
            <br>
            <span>Students Due by Session: {{$sessionInfo->title}} {{!empty($courseInfo) ? '- Course: '.$courseInfo->title : ''}}</span>
        </div>
    </div>
    <br/>
    <div class="row">
        <div class="col-md-12 no-padding">
            <h3 class="text-center text-decoration-underline mb-4">Due Summary</h3>
            <div class="row">
                <?php
                $currencyGroups = collect($studentsDue)->groupBy('currency')->sortKeys();
                ?>

                @foreach($currencyGroups as $currency => $group)
                    @php
                        $payable = $group->sum('total_payable');
                        $discount = $group->sum('total_discount');
                        $paid = $group->sum('total_paid');
                        $due = $group->sum('total_due');
                    @endphp

                    <div style="margin-bottom: 10px;">
                        <div class="currency-header">Currency: {!! $currency !!}</div>
                        <table class="summary-table">
                            <tr>
                                <th>Total Payable</th>
                                <td>{{ formatAmount($payable) }} {!! $currency !!}</td>
                            </tr>
                            <tr>
                                <th>Total Discount</th>
                                <td>{{ formatAmount($discount) }} {!! $currency !!}</td>
                            </tr>
                            <tr>
                                <th>Total Paid</th>
                                <td>{{ formatAmount($paid) }} {!! $currency !!}</td>
                            </tr>
                            <tr>
                                <th class="total-due">Total Due</th>
                                <td class="total-due">{{ formatAmount($due) }} {!! $currency !!}</td>
                            </tr>
                        </table>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
    <hr>
    <h3 class="text-center" style="padding-bottom: 16px">Due Details</h3>
    <table class="table table-bordered">
        <thead>
        <tr>
            <th class="text-center">Student ID</th>
            <th class="text-left">Name</th>
            <th class="text-right">Total Payable</th>
            <th class="text-right">Total Discount</th>
            <th class="text-right">Total Paid</th>
            <th class="text-right">Total Due</th>
        </tr>
        </thead>
        <tbody>
        @foreach($studentsDue as $student)
            <tr>
                <td class="text-center">{{  $student['student_id'] }}</td>
                <td>{{ $student['full_name'] }}</td>
                <td class="text-right">{!! formatAmount($student['total_payable']) .' <b>'. $student['currency'] .'</b>'!!}</td>
                <td class="text-right">{!! formatAmount($student['total_discount']) .' <b>'. $student['currency'] .'</b>' !!}</td>
                <td class="text-right">{!! formatAmount($student['total_paid']) .' <b>'. $student['currency'] .'</b>' !!}</td>
                <td class="text-right text-danger">{!! formatAmount($student['total_due']) .' <b>'. $student['currency'] .'</b>' !!}</td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>
<htmlpagefooter name="page-footer">
    <div style="text-align: center; font-size: 12px; vertical-align: bottom;">Page {PAGENO} of {nbpg}</div>
</htmlpagefooter>
</body>
</html>
