<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Exam Result</title>
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
            /*margin: 10px auto;*/
            width: 100%;
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

        .report-meta {
            width: 100%;
            margin: 6px 0 10px;
            font-size: 12px;
            text-align: center;
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
            <h2>
                North East Medical College, Sylhet
            </h2>
            <br>
            <h3>
                <span> Department of {{$subject->department->title}} </span>
            </h3>
            @php
                $batch = $exam->session->sessionDetails->where('course_id', $exam->course_id)->first()->batch_number;
                $subjectExam = $exam->examSubjects->where('subject_id', $subject->id)->first();
                $printedDate = \Carbon\Carbon::now()->format('d M, Y');
                $resultPublishDate = !empty($subjectExam) && !empty($subjectExam->result_publish_date)
                    ? \Carbon\Carbon::createFromFormat('d/m/Y', $subjectExam->result_publish_date)->format('d M, Y')
                    : 'N/A';
            @endphp

            <p>Result: {{$exam->title}}</p>
            <p>Session: {{$exam->session->title}} ({{$exam->course->title}} {{getOrdinal($batch)}} Batch)</p>
            <p>Month of
                Exam: {{\Carbon\Carbon::createFromFormat('d/m/Y', $exam->examSubjects->first()->exam_date)->format('F Y')}}</p>
        </div>
        <div class="report-meta">
            <strong>Result Publish Date:</strong> {{$resultPublishDate}} | <strong>Printed Date:</strong> {{$printedDate}}
        </div>
    </div>
    <br/>
    @php
        $totalStudents = $examResult->groupBy('student_id')->count();
        $failCounter = 0;
        $absentCounter = 0;
        $graceCounter = 0;
        $passPercentage = Setting::getSiteSetting()->pass_mark;
        $examSubjectMarkIds = [];
    @endphp
    <div class="row mt-4">
        <div class="table m-table table-responsive">
            <table class="table table-bordered table-hover sticky-header" id="exam-results">
                <thead class="text-center">
                <tr>
                    <th class="align-middle" rowspan="2">Roll No</th>
                    <th class="align-middle" rowspan="2">Name</th>
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
                    <th class="align-middle" rowspan="2">Comment</th>
                </tr>
                <tr>
                    @foreach($examTypeSubType as $type)
                        @foreach($type->examSubTypes as $subType)
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
        @foreach ($examResult->groupBy('student_id') as $studentId => $studentResults)
            @if (empty($selectedStudentId) || ($selectedStudentId == $studentId))
                @php
                    $firstResult = $studentResults->first();
                    $student = $firstResult->student;
                    $totalMarksByExamType = [];
                    $totalGrace = 0;
                    $failCount = 0;
                    $absent = 0;
                    $grace = 0;
                    $special = 0;
                @endphp
                <tr>
                    <td class="text-center align-middle">{{ $student->roll_no }}</td>
                    <td class="align-middle">
                        {{ $student->full_name_en }}
                    </td>

                    @foreach ($studentResults->sortBy('id')->groupBy('examSubjectMark.examSubType.exam_type_id')->sortBy('id') as $results)
                        @php
                            $total = 0;
                        @endphp
                        @foreach($results as $result)

                            @php
                                $examTypeId = $result->examSubjectMark->examSubType->examType->id;
                                $marks = $result->marks;
                                $grace_marks = $result->grace_marks;
                                $totalMark = $marks + $grace_marks;
                                $total += $totalMark;
                                $totalGrace += $grace_marks;
                                $totalMarksByExamType[$examTypeId] = ($totalMarksByExamType[$examTypeId] ?? 0) + $totalMark;

                                if ($result->pass_status === 4) {
                                    $absent++;
                                }
                                if ($result->grace_marks !== null) {
                                    $grace++;
                                }
                                if ($result->special_status !== null) {
                                    $special++;
                                }
                            @endphp
                            <td class="text-center align-middle">{{ $result->pass_status == 4 ? '-' : $totalMark }}</td>
                        @endforeach
                        <td class="text-center align-middle">{{ $total ?: '-' }}</td>
                    @endforeach
                    @php
                        foreach ($examTypeMarksArr as $key => $typeTotalMark) {
                            $typeMark = $totalMarksByExamType[$key] ?? 0;
                            $checkPercentage = ($typeMark * 100) / $typeTotalMark;
                            if ($passPercentage > $checkPercentage) {
                                $failCount++;
                            }
                        }

                        if ($special < 1) {
                            if ($absent > 0) {
                                $absentCounter++;
                                $resultStatus = 'Absent';
                                $textColor = 'text-warning';
                            } elseif ($failCount > 0) {
                                $failCounter++;
                                $resultStatus = 'Fail';
                                $textColor = 'text-danger';
                            } elseif ($failCount == 0 && $grace > 0) {
                                $graceCounter++;
                                $resultStatus = "Pass(Grace - $totalGrace)";
                                $textColor = 'text-info';
                            } else {
                                $resultStatus = 'Pass';
                                $textColor = 'text-success';
                            }
                        }else{
                            $isSpecialPass = $studentResults->where('special_status', 1)->count() > 0;
                            $resultStatus = $isSpecialPass ? 'Pass(SC)' : 'Fail(SC)';
                            $textColor = '';
                        }
                    @endphp

                    <td class="text-center align-middle">
                        <span class="{{ $textColor }}">{{ $resultStatus }}</span>
                    </td>
                    <td class="text-center align-middle">{{ $firstResult->remarks ?: '--' }}</td>
                </tr>
            @endif
        @endforeach
        </tbody>
    </table>
</div>
<table width="100%" style="padding-top: 10px;">
    <tr>
        <!-- Summary Section -->
        <td width="20%" style="font-size: 12px; vertical-align: top;">
            <h5 style="font-size: 16px; margin-bottom: 5px;">Summary:</h5>
            <p>Total Students: {{$totalStudents}}</p>
            <p>Pass: {{$totalStudents - ($failCounter + $absentCounter + $graceCounter)}}</p>
            <p>Grace Pass: {{$graceCounter}}</p>
            <p>Fail: {{$failCounter}}</p>
            <p>Absent: {{$absentCounter}}</p>
        </td>

        <!-- Page Number Section -->
        <td width="50%"></td>

        <!-- Signature Section -->
        <td width="30%" style="text-align: center; vertical-align: bottom; font-size: 12px;">
            <div>
                _________________________
            </div>
            <p>
                <strong>{{ $subject->department->teacher->fullName ?? 'N/A' }}</strong>
            </p>
            <h5 style="font-size: 14px; margin: 5px 0;">Head of
                Department {{$subject->department->title ?? 'N/A'}}</h5>
        </td>
    </tr>
</table>
<htmlpagefooter name="page-footer">
    <div style="text-align: center; font-size: 12px; vertical-align: bottom;">Page {PAGENO} of {nbpg}</div>
</htmlpagefooter>

</body>
</html>
