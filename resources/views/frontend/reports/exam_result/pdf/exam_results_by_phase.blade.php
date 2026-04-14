<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Exam Result by Phase</title>
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

        table thead tr {
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
                <span> Phase: {{$phase->title}} </span>
            </h3>
            <br>
            <?php
            $batch = $session->sessionDetails->where('course_id', $exams->first()->course_id)->first()->batch_number;
            ?>
            <span>Session: {{$session->title}} ({{$exams->first()->course->title}} {{getOrdinal($batch)}} Batch)</span>
        </div>
    </div>
    <br/>
    <table class="table table-bordered table-hover">
            <thead>
            <tr>
                <th rowspan="2">Roll No</th>
                <th rowspan="2">Name</th>
                @foreach($examSubjects as $subject)
                    <th colspan="{{count($exams)}}">{{$subject->subjectGroup->title}}</th>
                @endforeach
                <th rowspan="2">Remark</th>
            </tr>
            <tr>
                @foreach($examSubjects as $subject)
                    @foreach($exams as $exam)
                        <th>{{$exam->title}}</th>
                    @endforeach
                @endforeach
            </tr>

            </thead>
            <tbody>
            @foreach($examResults->groupBy('student_id') as $studentId => $studentResult)
                    <?php $studentExamStatus = $studentResult->first()->pass_status; ?>
                    <?php $remark = $studentResult->first()->remark; ?>
                <tr>
                    <td>{{$studentResult->first()->student->roll_no}}</td>
                    <td>{{$studentResult->first()->student->full_name_en}}</td>
                    @foreach($studentResult->groupBy('subject_id') as $subjectId => $examSubject)
                        @foreach($examSubject as $exam)
                            <td>{{$exam->total}}</td>
                        @endforeach
                    @endforeach
                    <td></td>
                </tr>

            @endforeach
            </tbody>
    </table>
</div>
</body>
</html>
