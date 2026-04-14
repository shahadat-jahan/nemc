@php use Carbon\Carbon; @endphp
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
            background-color: #fff;
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

        .text-black {
            color: #000 !important;
        }

        table {
            border-collapse: collapse;
            margin: 10px auto;
        }

        table thead tr {
            border: 1px solid #dee2e6;
            font-size: 15px;
        }

        table td {
            font-size: 13px;
            /*vertical-align: middle !important;*/
            /*text-align: center;*/
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
            text-transform: uppercase !important;
        }

        .text-center {
            text-align: center !important;
        }

        .text-left {
            text-align: left !important;
        }

        .text-right {
            text-align: end !important;
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


        /* Wrapper for summary and signature sections */
        .bottom-section {
            display: flex; /* Flexbox layout */
            justify-content: space-between; /* Place items at opposite ends */
            align-items: flex-end; /* Align items at the top */
            /*gap: 20px; !* Add spacing between items *!*/
            margin-top: 20px;
        }

        /* Styling for the summary section */
        .summary-section {
            padding-left: 50px !important;
            /*min-width: 10%; !* Ensure it has some minimum width *!*/
        }

        /* Styling for the signature section */
        .signature-section {
            min-width: 15%; /* Ensure it has some minimum width */
            /*margin-right: 30px;*/
        }

        /* Responsive adjustments for smaller screens */
        @media (max-width: 768px) {
            .bottom-section {
                flex-direction: column; /* Stack sections vertically */
                align-items: center; /* Center align content */
                text-align: center;
            }

            .summary-section,
            .signature-section {
                width: 100%; /* Full width on small screens */
                text-align: center; /* Center text */
            }
        }

        @page {
            footer: page-footer;
            margin: 30px 10px;
            margin-footer: 10px;
        }
    </style>
</head>
<body>
<div class="container">
    <div class="brand-section">
        <span>
            <img class="logo" src="{{ asset('assets/global/img/logo.jpg') }}"/>
        </span>
        <div style="margin-top: -45px" class="text-center">
            <h2>North East Medical College, Sylhet</h2>
            <br>
            <h3>
                <span> Department Of {{$subject->department->title}} </span>
            </h3>

            <br>
            @php
                $student = $examResult->first()->first()->student;
                $batch = $exam->session->sessionDetails->where('course_id', $exam->course_id)->first()->batch_number;
            @endphp
            <h4>
                <span>Student: {{$student->full_name_en}}(Roll No-{{$student->roll_no}})</span>
            </h4>
            <p>Result: {{$exam->title}}</p>
            <p>Session: {{$exam->session->title}} ({{$exam->course->title}} {{getOrdinal($batch)}} Batch)</p>
            <p>Month of
                Exam: {{Carbon::createFromFormat('d/m/Y', $exam->examSubjects->first()->exam_date)->format('F Y')}}</p>
        </div>
    </div>
    <br/>
    @php
        $passPercentage = Setting::getSiteSetting()->pass_mark;
        $examSubjectMarkIds = [];
    @endphp
    <table width="100%" class="table table-bordered table-hover">
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
                    $totalGrace = 0;
            @endphp
            @foreach($examResult as $studentResult)
                @php
                    $total = 0;
                    $totalMark = 0;
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
                        $grace   = $result->whereIn('exam_subject_mark_id', $examSubjectMarkIds)->whereNotNull('grace_marks')->where('student_id', $result->student_id)->count();

                        if ($special > 0) {
                            $resultStatus = $result->whereIn('exam_subject_mark_id', $examSubjectMarkIds)->where('special_status', 1)->where('student_id', $result->student_id)->count() > 0 ? 'Pass' : 'Fail';
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

                    if ($special < 1) {
                        if ($absent > 0) {
                            $resultStatus = 'Absent';
                        } elseif ($failCount > 0) {
                            $resultStatus = 'Fail';
                        } elseif ($failCount == 0 && $grace > 0) {
                            $resultStatus = "Pass(Grace - " .$totalGrace.")";
                        } else {
                            $resultStatus = 'Pass';
                        }
                    }
                @endphp
                <span>{{$resultStatus}}</span>
            </td>
            <td class="text-center align-middle">{{ $result->remarks ?: '--'}}</td>
        </tr>
        </tbody>
    </table>
</div>
<table width="100%" style="padding-top: 10px;">
        <tr>
            <td width="20%" style="font-size: 12px; vertical-align: top;"></td>
            <td width="50%"></td>
            <td width="30%" style="text-align: center; vertical-align: bottom; font-size: 12px;">
                <div>
                    _________________________
                </div>
                <p>Date: {{ \Carbon\Carbon::now()->format('d-M-Y') }}</p>
                <p>
                    <strong>{{ $subject->department->teacher->fullName ?? 'N/A' }}</strong>
                </p>
                <h5 style="font-size: 14px; margin: 5px 0;">Head of
                    Department {{$subject->department->title ?? 'N/A'}}</h5>
            </td>
        </tr>
    </table>
<htmlpagefooter name="page-footer">
    <div style="text-align: center; font-size: 10px;">
        Page {PAGENO} of {nbpg}
    </div>
</htmlpagefooter>
</body>
</html>
