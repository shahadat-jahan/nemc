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



    </style>
</head>
<body>
<div>
    <div class="brand-section">
        <span>
            <img class="logo" src="{{asset('assets/global/img/logo.jpg')}}"/>
        </span>
        <div style="margin-top: -45px" class="text-center">
            <h2>North East Medical College, Sylhet</h2>
            <br>
            <h3>Class routine list of {{$year}}</h3>
            <span>Session : {{$sessionInfo}} </span>, <span>Course : {{$course}} </span>,
            <span>Phase : {{$phase}} </span>,
        </div>
    </div>
    <br/>
    {{--    @dd($routines)--}}
    <table class="table table-bordered table-hover">
        <thead>
            <tr>
                <th class="align-middle text-center">ID</th>
                <th class="align-middle text-center">Session</th>
                <th class="align-middle text-center">Course</th>
                <th class="align-middle text-center">Phase</th>
                <th class="align-middle text-center">Term</th>
                <th class="align-middle">Subject</th>
                <th class="align-middle">Class Type</th>
                <th class="align-middle">Teacher</th>
                <th class="align-middle text-center">Date</th>
                <th class="align-middle text-center">Time</th>
                <th class="align-middle">Class Room</th>
            </tr>
        </thead>
        <tbody>
        @foreach($routines as $routine)
            <tr>
                <th class="align-middle text-center">{{$routine->id}}</th>
                <td class="align-middle text-center">{{$routine->session->title}}</td>
                <td class="align-middle text-center">{{$routine->course->title}}</td>
                <td class="align-middle text-center">{{$routine->phase->title}}</td>
                <td class="align-middle text-center">{{$routine->term->title}}</td>
                <td class="align-middle">{{$routine->subject->title}}</td>
                <td class="align-middle">{{$routine->classType->title}}</td>
                <td class="align-middle">{{isset($routine->teacher) ? $routine->teacher->full_name : '--'}}</td>
                <td class="align-middle text-center">{{date('d M, Y', strtotime($routine->class_date))}}</td>
                <td class="align-middle text-center">{{$routine->class_time}}</td>
                <td class="align-middle">{{isset($routine->hall) ? $routine->hall->title : '--'}}</td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>
</body>
</html>
