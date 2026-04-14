<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
{{--    <title>Attendance of {{$student->full_name_en}}</title>--}}
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

        table thead tr {
            border: 1px solid #dee2e6;
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
            <img class="logo" src="{{asset('assets/global/img/logo.jpg')}}"/>
        </span>
        <div style="margin-top: -45px" class="text-center">
            <h2>North East Medical College, Sylhet</h2>
            <br>
            <h3>
                <span> Department of {{$department}} </span>
            </h3>
            <br>
            <h4>
                <span>Student : {{$student->full_name_en}}(Roll No-{{$student->roll_no}})</span>
            </h4>
            <span>Session : {{$sessionInfo}} </span>, <span>Course : {{$course}} </span>,
            <span>Phase : {{$phase}} </span>
            @if(isset($start_date))
                <br>
                <span>Date : {{$start_date}} - {{$end_date ?? 'Today'}}</span>
            @endif
        </div>
    </div>
    <br/>
    <h4 class="text-center text-uppercase">
        Attendance Summary
    </h4>
    <table class="table table-bordered">
        <thead>
        <tr>
            @if($showAllClassTypes)
                {{-- Show single column header for all class types combined --}}
                <th class="text-center">All Class Types</th>
            @else
                {{-- Show separate column header for each selected class type --}}
                <th class="text-center">
                    @foreach($selectedClassTypes as $index => $classType)
                        {{ $classType->title }}@if($index < count($selectedClassTypes) - 1), @endif
                    @endforeach
                </th>
            @endif
            <th class="text-center" scope="col">
                Attend
            </th>
            <th class="text-center" scope="col">
                Absent
            </th>
            <th class="text-center" scope="col">
                Attendance Percentage(%)
            </th>
        </tr>
        </thead>
        <tbody>
        <tr>
            <td class="text-center">{{$totalClass > 0 ? $totalClass : '-'}}</td>
            <td class="text-center">{{$totalClass > 0 ? $totalAttendance : '-'}}</td>
            <td class="text-center">{{$totalClass > 0 ? $totalClass - $totalAttendance : '-'}}</td>
            <td class="text-center">{{$totalClass > 0 ? round(($totalAttendance * 100) / ($totalClass > 0 ? $totalClass : 1)).'%' : '-'}}</td>
        </tr>
        </tbody>
    </table>
    <br>
    <h4 class="text-center text-uppercase">
        Attendance Detail</h4>
    <table class="table table-bordered">
        <thead>
        <tr>
            <th scope="col" class="text-left">Date</th>
            <th scope="col" class="text-left">Subject</th>
            <th scope="col" class="text-left">Class Type</th>
            <th scope="col" class="text-center">Attendance(Present)</th>
            <th scope="col" class="text-center">SMS / Email Send At</th>
        </tr>
        </thead>
        <tbody>
        @forelse($attendanceData as $attendance)
            <tr>
                <td scope="col" class="text-left">{{ formatDate($attendance->classRoutine->class_date, 'd-M-Y') }}</td>
                <td scope="col" class="text-left">{{$attendance->classRoutine->subject->title}}</td>
                <td scope="col" class="text-left">{{$attendance->classRoutine->classType->title}}</td>
                <td scope="col" class="text-center">@if($attendance->attendance == 1)
                        <span class="text-success">Yes</span>
                    @else
                        <span class="text-danger">No</span>
                    @endif
                </td>
                <td scope="col" class="text-center">
                    {{ ($attendance->smsEmailLog->last()) ? \Carbon\Carbon::parse($attendance->smsEmailLog->last()->created_at)->format('d-M-Y H:i A') : 'N/A' }}
                </td>
            </tr>
        @empty
            <tr>
                <td class="text-center" colspan="5">No Attendance Detail</td>
            </tr>
        @endforelse
        </tbody>
    </table>
</div>
</body>
</html>
