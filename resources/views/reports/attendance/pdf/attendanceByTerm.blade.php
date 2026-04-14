<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Attendance by Term</title>
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

        .text-white {
            color: #000 !important;
        }

        .company-details {
            float: right;
            text-align: right;
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

        table thead th {
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

        .table-bordered {
            box-shadow: 0px 0px 5px 0.5px gray;
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
            text-align: start;
        }

        .text-right {
            text-align: end;
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

        .text-white {
            color: #130101 !important;
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
            <span>Session : {{$sessionInfo}} </span>, <span>Course : {{$course}} </span>,
            <span>Phase : {{$phase}} </span>, <span>Term : {{$term}}</span>
            @if(isset($start_date))
                <br>
                <span>Date : {{$start_date}} - {{$end_date ?? 'Today'}}</span>
            @endif
        </div>
    </div>
    <br/>
    <table class="table table-bordered table-hover">
        <thead>
        <tr>
            <th rowspan="2">Roll No</th>
            <th rowspan="2">Student Name</th>
            <th colspan="4">Lecture</th>
            <th colspan="4">Tutorial & Other</th>
            <th rowspan="2">Remarks</th>
        </tr>
        <tr>
            <th>Class Held</th>
            <th>Present</th>
            <th>Absent</th>
            <th>Present(%)</th>
            <th>Class Held</th>
            <th>Present</th>
            <th>Absent</th>
            <th>Present(%)</th>
        </tr>
        </thead>
        <tbody>
        @if(!empty($attendanceReport))
            @foreach($attendanceReport as $attendance)
                @php
                    $total_exam_held_exclude_lec=0;
                    if($attendance->total_exam_held_exclude_lec != 0) {
                        $total_exam_held_exclude_lec=round(($attendance->practical_present * 100) / $attendance->total_exam_held_exclude_lec);
                     }
                    $total_lecture_present=0;
                    if($totalLectureClass != 0) {
                        $total_lecture_present=round(($attendance->lecture_present * 100) / $totalLectureClass);
                     }
                @endphp
                <tr>
                    <th>{{$attendance->student->roll_no}}</th>
                    <td>{{$attendance->student->full_name_en}}</td>
                    <td class="text-center">{{$totalLectureClass > 0 ? $totalLectureClass : '-'}}</td>
                    <td class="text-center">{{$totalLectureClass > 0 ? $attendance->lecture_present : '-'}}</td>
                    <td class="text-center">{{$totalLectureClass > 0 ? $totalLectureClass-$attendance->lecture_present : '-'}}</td>
                    <td class="text-center">{{$totalLectureClass > 0 ? $total_lecture_present.'%' : '-'}}</td>

                    <td class="text-center">{{$attendance->total_exam_held_exclude_lec > 0 ? $attendance->total_exam_held_exclude_lec : '-'}}</td>
                    <td class="text-center">{{$attendance->total_exam_held_exclude_lec > 0 ? $attendance->practical_present : '-'}}</td>
                    <td class="text-center">{{$attendance->total_exam_held_exclude_lec > 0 ? $attendance->total_exam_held_exclude_lec-$attendance->practical_present : '-'}}</td>
                    <td class="text-center">{{$attendance->total_exam_held_exclude_lec > 0 ? $total_exam_held_exclude_lec.'%' : '-'}}</td>
                    <td></td>
                </tr>
            @endforeach
        @endif
        </tbody>
    </table>
</div>
</body>
</html>
