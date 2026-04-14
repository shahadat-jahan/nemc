<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Class routine</title>
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

        table {
            width: 100%;
            border-collapse: collapse;
        }

        table thead th {
            border: 1px solid #dee2e6;
            vertical-align: middle;
        }

        table th, table td {
            padding: 5px;
        }

        .table-bordered {
            box-shadow: 0 0 5px 1px gray;
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


    </style>
</head>
<body>
<div>
    <div class="brand-section">
        <span>
            <img class="logo" src="{{asset('assets/global/img/logo.jpg')}}"/>
        </span>
        <div style="margin-top: -45px" class="text-center">
            <h2>North East Medical College</h2>
            <span>{{Setting::getSiteSetting()->address}}</span>
            <br>
            <span>{{Setting::getSiteSetting()->phone}}</span>
            <h3>
                <span> Department of {{$department}} </span>
            </h3>
            <br>
            <h3>
                <span>{{$classType}} Attendance</span>
            </h3>
            <span>Class ID: {{$classRoutine->id}}</span>
            <br>
            <span>Session : {{$session}},</span> <span>Course : {{$course}},</span> <span>Phase : {{$phase}}</span>
            <br>
            <span>Batch: {{$batch}},</span> <span>Date: {{date('d M,  Y', strtotime($classRoutine->class_date))}}</span>
            <br>
            <span>Teacher: {{$teacherName}}</span>
            <br>
            <span>{{$topicInfo ? 'Topic: '. $topicInfo->title : ''}}</span>
        </div>
    </div>
    <span class="m-badge m-badge--success">Total Present: {{$totalPresent}}</span>
    <br/>
    <span class="m-badge m-badge--danger">Total Absent: {{$totalAbsent}}</span>
    <br>
    <br>
    <table class="table table-bordered table-hover">
        <thead>
        <tr>
            <th class="text-center">Roll</th>
            <th>Student Name</th>
            <th>Attendance</th>
            <th>Remarks</th>
        </tr>
        </thead>
        <tbody>
        @foreach($attendanceData as $item)
            <tr>
                <td class="text-center">{{$item->student->roll_no}}</td>
                <td>{{$item->student->full_name_en}}</td>
                <td>{!!$item->attendance_status!!}</td>
                <td>SMS: {{$item->send_sms ? 'Yes' :'No'}}</td>
            </tr>

        @endforeach
        </tbody>
    </table>
</div>
</body>
</html>
