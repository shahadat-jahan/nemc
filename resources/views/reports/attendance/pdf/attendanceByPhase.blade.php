<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Attendance by Phase</title>
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

        table thead th {
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
            <img class="logo" src="{{asset('assets/global/img/logo.jpg')}}"/>
        </span>
        <div style="margin-top: -45px" class="text-center">
            <h2>North East Medical College, Sylhet</h2>
            <br>
            <h3>
                 <span>Phase : {{$phase}} </span>
            </h3>
            <br>
            <span>Session : {{$sessionInfo}} </span>, <span>Course : {{$course}} </span>,
            @if(isset($start_date))
                <br>
                <span>Date : {{$start_date}} - {{$end_date ?? 'Today'}}</span>
            @endif
        </div>
    </div>
    <br/>
    <table class="table table-bordered">
        <thead>
        <tr>
            <th rowspan="3" class="align-middle">Roll No</th>
            <th rowspan="3" class="text-center align-middle">Student Name</th>
            @foreach($subjects as $subject)
                <th colspan="7" class="text-center">{{$subject->title}}</th>
            @endforeach
            <th rowspan="3" class="text-center align-middle">Remarks</th>
        </tr>
        <tr>
            @foreach($subjects as $subject)
                <th rowspan="2" class="text-center align-middle">Total Per(%)</th>
                <th colspan="3" class="text-center">Lecture</th>
                <th colspan="3" class="text-center">Tutorial & Other</th>
            @endforeach
        </tr>
        <tr>
            @foreach($subjects as $subject)
                <th>Held</th>
                <th>Attend</th>
                <th>Per(%)</th>
                <th>Held</th>
                <th>Attend</th>
                <th>Per(%)</th>
            @endforeach
        </tr>
        </thead>
        <tbody>
        @foreach(($attendanceByStudent ?? collect()) as $rollNo => $studentInfo)
            <tr>
                <th>{{$rollNo}}</th>
                <td>{{$studentInfo['student_name'] ?? ''}}</td>
                @foreach($subjects as $subject)
                    @php
                        $subjectAttendanceMap = $studentInfo['subjects'] ?? collect();
                        $attendance = $subjectAttendanceMap->get($subject->id);

                        if ($attendance) {
                            $heldClasses = $attendance['total_class'] ?? 0;
                            $heldLectureClasses = $attendance['total_lecture_class'] ?? 0;
                            $heldTutorialClasses = $attendance['total_tutorial_class'] ?? 0;
                        } else {
                            $heldClasses = $heldLectureClasses = $heldTutorialClasses = '-';
                        }
                    @endphp
                    <td class="text-center">{{ ($attendance && $attendance['attendance_percentage'] !== null) ? $attendance['attendance_percentage'].'%' : '-' }}</td>
                    <td class="text-center">{{$heldLectureClasses > 0 ? $heldLectureClasses : '-'}}</td>
                    <td class="text-center">{{$heldLectureClasses > 0 ? ($attendance['lecture_class_present'] ?? '-') : '-'}}</td>
                    <td class="text-center">{{ ($attendance && $attendance['lecture_percentage'] !== null) ? $attendance['lecture_percentage'].'%' : '-' }}</td>
                    <td class="text-center">{{$heldTutorialClasses > 0 ? $heldTutorialClasses : '-'}}</td>
                    <td class="text-center">{{$heldTutorialClasses > 0 ? ($attendance['tutorial_class_present'] ?? '-') : '-'}}</td>
                    <td class="text-center">{{ ($attendance && $attendance['tutorial_percentage'] !== null) ? $attendance['tutorial_percentage'].'%' : '-' }}</td>
                @endforeach
                <td></td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>
</body>
</html>
