<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
</head>
<body>

{{-- Institute Title --}}
<div style="text-align: center;">
    <h4 style="text-transform: uppercase">North East Medical College, Sylhet</h4>
    <p>Students Due by
        Session: {{ $sessionInfo->title }} {{!empty($courseInfo) ? '- Course: '.$courseInfo->title : ''}}</p>
</div>
<br>
{{-- Summary Section --}}
<h3 style="text-align: center; font-weight: bold">Due Summary</h3>

@php
    $currencyGroups = collect($studentsDue)->groupBy('currency')->sortKeys();
@endphp

@foreach($currencyGroups as $currency => $group)
    @php
        $payable = $group->sum('total_payable');
        $discount = $group->sum('total_discount');
        $paid = $group->sum('total_paid');
        $due = $group->sum('total_due');
    @endphp

    <table>
        <tr>
            <th colspan="2" style="text-align: center; font-weight: bold">Currency: {!! $currency !!}</th>
        </tr>
        <tr>
            <th style="text-align: right">Total Payable</th>
            <td style="text-align: right">{{ number_format($payable, 2) }} {!! $currency !!}</td>
        </tr>
        <tr>
            <th style="text-align: right">Total Discount</th>
            <td style="text-align: right">{{ number_format($discount, 2) }} {!! $currency !!}</td>
        </tr>
        <tr>
            <th style="text-align: right">Total Paid</th>
            <td style="text-align: right">{{ number_format($paid, 2) }} {!! $currency !!}</td>
        </tr>
        <tr>
            <th style="text-align: right; color: red; font-weight: bold">Total Due</th>
            <td style="text-align: right; color:red; font-weight: bold">{{ number_format($due, 2) }} {!! $currency !!}</td>
        </tr>
    </table>
@endforeach
<br>
{{-- Details Section --}}
<h3 class="text-center section-title">Due Details</h3>

<table>
    <thead>
    <tr style="font-weight: bold">
        <th style="text-align: center">Student ID</th>
        <th style="text-align: left">Name</th>
        <th style="text-align: right">Total Payable</th>
        <th style="text-align: right">Total Discount</th>
        <th style="text-align: right">Total Paid</th>
        <th style="text-align: right">Total Due</th>
    </tr>
    </thead>
    <tbody>
    @foreach($studentsDue as $student)
        <tr>
            <td style="text-align: center">{{ $student['student_id'] }}</td>
            <td style="text-align: left">{{ $student['full_name'] }}</td>
            <td style="text-align: right">{{ number_format($student['total_payable'], 2) }} {{ $student['currency'] }}
            </td>
            <td style="text-align: right">{{ number_format($student['total_discount'], 2) }} {{ $student['currency'] }}
            </td>
            <td style="text-align: right">{{ number_format($student['total_paid'], 2) }} {{ $student['currency'] }}</td>
            <td style="text-align: right; color:red">{{ number_format($student['total_due'], 2) }}
                <b>{{ $student['currency'] }}</b></td>
        </tr>
    @endforeach
    </tbody>
</table>
</body>
</html>
