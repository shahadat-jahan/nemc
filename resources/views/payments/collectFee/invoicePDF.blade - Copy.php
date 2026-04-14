<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fabcart</title>
    <style>
        body{
            background-color: #F6F6F6;
            margin: 0;
            padding: 0;
        }
        h1,h2,h3,h4,h5,h6{
            margin: 0;
            padding: 0;
        }
        p{
            margin: 0;
            padding: 0;
        }
        .container{
            width: 100%;
            margin-right: auto;
            margin-left: auto;
        }
        .brand-section{
           background-color: #ffffff;
           padding: 10px 40px;
        }
        .logo{
            width: 50%;
        }

        .row{
            display: flex;
            flex-wrap: wrap;
        }
        .col-6{
            width: 50%;
            flex: 0 0 auto;
        }
        .text-white{
            color: #000 !important;
        }
        .company-details{
            float: right;
            text-align: right;
        }
        .body-section{
            padding: 16px;
            border: 1px solid gray;
        }
        .heading{
            font-size: 20px;
            margin-bottom: 08px;
        }
        .sub-heading{
            color: #262626;
            margin-bottom: 05px;
        }
        table{
            background-color: #fff;
            width: 100%;
            border-collapse: collapse;
        }
        table thead tr{
            border: 1px solid #111;
            background-color: #f2f2f2;
        }
        table td {
            vertical-align: middle !important;
            text-align: center;
        }
        table th, table td {
            padding-top: 08px;
            padding-bottom: 08px;
        }
        .table-bordered{
            box-shadow: 0px 0px 5px 0.5px gray;
        }
        .table-bordered td, .table-bordered th {
            border: 1px solid #dee2e6;
        }
        .text-right{
            text-align: end;
        }
        .w-20{
            width: 20%;
        }
        .float-right{
            float: right;
        }

        .info{
            width:100%;
        }
        .info_one{
            width: 50%;
            float:left;
        }
        .text-white {
            color: #130101 !important;
        }

    </style>
</head>
<body>

<?php
      //dd($paymentInvoice);
    ?>

    <div class="container">
        <div class="brand-section">
            <div class="row">
                <div class="col-12">
                    <h2 class="text-white">
                        <img src="{{asset('assets/global/img/logo.jpg')}}" style="width: 12rem;"/>
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
                    <h2 class="heading">Invoice No.: {{$paymentInvoice->student_id.$paymentInvoice->id}}</h2>
                    <p class="sub-heading">Payment Date: {{$paymentInvoice->payment_date}} </p>
                    <p class="sub-heading">Payment Method: {{$paymentInvoice->paymentMethod->title}} </p>
                    <p class="sub-heading">Bank Name: {{$paymentInvoice->bank->title}} </p>
                </div>
                <div class="col-6 info_two">
                    <p class="sub-heading">Student Name:{{$paymentInvoice->student->full_name_en}}  </p>
                    <p class="sub-heading">Student Roll:{{$paymentInvoice->student->roll_no}} </p>
                    <p class="sub-heading">
                        Session:{{ \App\Models\Session::where(['id' => $paymentInvoice->student->session_id])->pluck('title')->first()
                        }}
                    </p>
                    <p class="sub-heading">
                        Course:{{ \App\Models\Course::where(['id' => $paymentInvoice->student->course_id])->pluck('title')->first()
                        }}
                    </p>
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
                        <th class="w-20">Amount</th>
                        <th class="w-20">Remarks</th>
                        <th class="w-20">Grand Total</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>{{$paymentInvoice->paymentType->title}}</td>
                        <td>{{$paymentInvoice->amount}}</td>
                        <td>{{$paymentInvoice->remarks}}</td>
                        <td>{{$paymentInvoice->amount}}</td>
                    </tr>
                    <tr>
                        <td colspan="3" class="text-right">Sub Total</td>
                        <td> {{$paymentInvoice->amount}}</td>
                    </tr>
                    <tr>
                        <td colspan="3" class="text-right">Tax Total(%)</td>
                        <td> 0</td>
                    </tr>
                    <tr>
                        <td colspan="3" class="text-right">Grand Total</td>
                        <td> {{$paymentInvoice->amount}}</td>
                    </tr>
                </tbody>
            </table>
            <br>
            <h3 class="heading">Payment Status: Paid</h3>
<!--            <h3 class="heading">Payment Mode: Cash on Delivery</h3>-->
        </div>

        <div class="body-section">
            <p>&copy; Copyright 2021 - Vivasoft. All rights reserved.
                <a href="https://www.vivasoftltd.com/" class="float-right">https://www.vivasoftltd.com/</a>
            </p>
        </div>
    </div>

</body>
</html>
