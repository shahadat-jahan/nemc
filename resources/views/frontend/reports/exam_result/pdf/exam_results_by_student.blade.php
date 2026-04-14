<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Exam Result by Student</title>
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
            margin: 10px auto;
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

        .text-white {
            color: #fff !important;
        }

        @page {
            header: page-header;
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
            <h3>
                <span> Department Of {{$subject->department->title}} </span>
            </h3>

            <br>
            <?php
            $student = $examResult->first()->first()->student;
            $batch = $exam->session->sessionDetails->where('course_id', $exam->course_id)->first()->batch_number;
            ?>
            <h4>
                <span>Student: {{$student->full_name_en}}(Roll No-{{$student->roll_no}})</span>
            </h4>
            <span>Result: {{$exam->title}} Examination, {{\Carbon\Carbon::createFromFormat('d/m/Y', $exam->examSubjects->first()->exam_date)->format('F Y')}}</span>
            <br>
            <span>Session: {{$exam->session->title}} ({{$exam->course->title}} {{getOrdinal($batch)}} Batch)</span>
        </div>
    </div>

    <br/>
    @php
        $passPercentage = Setting::getSiteSetting()->pass_mark;
        $examSubjectMarkIds = [];
    @endphp
    <table class="table table-bordered table-hover">
        <thead class="text-center">
        <tr>
            @php
                $examTotalMarks = 0;
                $examTypeMarksArr = [];
            @endphp
            @foreach($examTypeSubType as $type)
                @php
                    $examTypeMarks = 0;
                    $colspan = count($type->examSubTypes) + 1;
                @endphp
                @foreach($type->examSubTypes as $subType)
                    @foreach($subType->examSubjectMark as $mark)
                        @php
                            $examTypeMarks               += $mark->total_marks;
                            $examTypeMarksArr[$type->id] = $examTypeMarks;
                        @endphp
                    @endforeach
                @endforeach
                <th class="align-middle" colspan="{{$colspan}}">{{$type->title}}
                    ({{$examTypeMarks}})
                </th>
                @php
                    $examTotalMarks += $examTypeMarks;
                @endphp
            @endforeach
            <th class="align-middle" rowspan="2">Result</th>
            <th rowspan="2" class="align-middle">Comment</th>
        </tr>
        <tr>
            @foreach($examTypeSubType as $type)
                @foreach($type->examSubTypes->sortBy('id') as $subType)
                    @foreach($subType->examSubjectMark as $mark)
                        @php
                            $examSubjectMarkIds[] = $mark->id;
                        @endphp
                        <th class="align-middle">{{$subType->title}}
                            <br>({{$mark->total_marks}})
                        </th>
                    @endforeach
                @endforeach
                <th class="align-middle">Total</th>
            @endforeach
        </tr>
        </thead>
        <tbody>
        <tr>
            @php
                $totalMarksByExamType = [];
            @endphp
            @foreach($examResult as $studentResult)
                @php
                    $total = 0;
                    $totalMark = 0;
                    $totalGrace = 0;
                @endphp
                @foreach($studentResult->sortBy('id') as $result)
                    @php
                        $examType     = $result->examSubjectMark->examSubType->examType;
                        $examTypeId   = $examType->id;
                        $resultStatus = 'Pass';
                        $colour       = '';
                        $marks        = $result->marks;
                        $grace_marks  = $result->grace_marks;
                        $totalMark    = $marks + $grace_marks;
                        $total       += $totalMark;
                        $totalGrace  += $grace_marks;

                        if (!isset($totalMarksByExamType[$examTypeId])) {
                            $totalMarksByExamType[$examTypeId] = 0; // Initialize total if not already set
                        }
                        $totalMarksByExamType[$examTypeId] += $totalMark;

                        $special = $result->whereIn('exam_subject_mark_id', $examSubjectMarkIds)->whereNotNull('special_status')->where('student_id', $result->student_id)->count();
                        $absent  = $result->whereIn('exam_subject_mark_id', $examSubjectMarkIds)->where('pass_status', 4)->where('student_id', $result->student_id)->count();
                        $grace   = $result->whereIn('exam_subject_mark_id', $examSubjectMarkIds)->whereIn('exam_subject_mark_id', $examSubjectMarkIds)->where('pass_status', 3)->where('student_id', $result->student_id)->count();

                        if ($special > 0) {
                            $resultStatus = $result->whereIn('exam_subject_mark_id', $examSubjectMarkIds)->where('special_status', 1)->where('student_id', $result->student_id)->count() > 0 ? 'Pass' : 'Fail';
                            $colour = $result->whereIn('exam_subject_mark_id', $examSubjectMarkIds)->where('special_status', 1)->where('student_id', $result->student_id)->count() > 0 ? 'text-success' : 'text-warning';
                        }
                    @endphp
                    <td class="text-center align-middle">{{$result->pass_status === 4 ? '-' : $totalMark}}</td>
                @endforeach
                <td class="text-center align-middle">{{$total}}</td>
            @endforeach
            <td class="text-center align-middle">
                @php
                    $failCount = 0;
                    $passCount = 0;

                    foreach ($examTypeMarksArr as $key => $typeTotalMark)
                    {
                        $typeMark        = $totalMarksByExamType[$key];
                        $checkPercentage = ($typeMark * 100) / $typeTotalMark;

                        if ($passPercentage > $checkPercentage){
                                ++$failCount;
                        }else{
                            ++$passCount;
                        }
                    }

                    if ($special < 1){
                        if ($absent > 0) {
                            // Case: Only absent, no pass or fail
                            $resultStatus = 'Absent';
                        } elseif ($absent == 0 && $failCount > 0) {
                            // Case: Fail if there's a fail count & no absences
                            $resultStatus = 'Fail';
                        } elseif ($absent == 0 && $failCount == 0 && $grace > 0) {
                            // Case: Pass with grace if no absences or fails, but grace is applied
                            $resultStatus = 'Pass(Grace)';
                        }
                    }
                @endphp
                <span class="{{$colour}}">{{$resultStatus}}</span>
            </td>
            <td class="text-center align-middle">{{ $result->remarks ?: '--'}}</td>
        </tr>
        </tbody>
    </table>
    <table style="margin: 30px auto; display: flex; vertical-align: bottom">
        <tr>
            <td width="20%"></td>
            <td width="50%"></td>
            <td width="30%" style="vertical-align: bottom; text-align: center">
                _________________________
                <br>
                Date: {{\Carbon\Carbon::now()->format('d-M-Y')}}
                <h5 style="font-size: 16px">Head of Department</h5>
            </td>
        </tr>
    </table>
</div>
</body>
</html>
