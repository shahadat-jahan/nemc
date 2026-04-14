<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Exam Result by Category</title>
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
            text-transform: uppercase!important;
        }

        .text-center {
            text-align: center!important;
        }

        .text-left {
            text-align: left!important;
        }

        .text-right {
            text-align: end!important;
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
    </style>
</head>
<body>
<div class="container">
    <div class="brand-section">
        <span>
            <img class="logo" src="{{asset('assets/global/img/logo.jpg')}}"/>
        </span>
        <div style="margin-top: -45px" class="text-center">
            <h2>
                North East Medical College, Sylhet
            </h2>
            <br>
            <h3>
                <span> Department of {{$subject->department->title}} </span>
            </h3>
            <br>
            <?php
            $batch = $exam->session->sessionDetails->where('course_id', $exam->course_id)->first()->batch_number;
            ?>
            <span>Result: {{$exam->title}} Examination, {{\Carbon\Carbon::createFromFormat('d/m/Y', $exam->examSubjects->first()->exam_date)->format('F Y')}}</span>
            <br>
            <span>Session: {{$exam->session->title}} ({{$exam->course->title}} {{getOrdinal($batch)}} Batch)</span>
        </div>
    </div>
    <br/>
    <table class="table table-bordered table-hover">
        <thead class="text-center">
        <tr>
            <th class="align-middle" rowspan="2">Roll No</th>
            <th rowspan="2">Name</th>
            @php
                $examTotalMarks = 0;
                $examSubjectMarkIds = [];
            @endphp
            @foreach($examTypeSubType as $type)
                    <?php
                    $examTypeMarks = 0;
                    $colspan = count($type->examSubTypes) + 1;
                    ?>
                @foreach($type->examSubTypes as $subType)
                    @foreach($subType->examSubjectMark as $mark)
                            <?php $examTypeMarks += $mark->total_marks ?>
                    @endforeach
                @endforeach
                <th class="align-middle" colspan="{{$colspan}}">{{$type->title}}
                    ({{$examTypeMarks}})
                </th>
                @php
                    $examTotalMarks += $examTypeMarks;
                @endphp
            @endforeach
            <th class="align-middle" rowspan="2">Remark</th>
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
        @foreach($examResult->groupBy('student_id') as $studentId => $studentResult)
                <?php $studentExamStatus = $studentResult->first()->pass_status; ?>
                <?php $remark = $studentResult->first()->remark; ?>
            <tr>
                <td class="text-center align-middle">{{$studentResult->first()->student->roll_no}}</td>
                <td style="text-align: left">
                    {{$studentResult->first()->student->full_name_en}}
                </td>
                @php
                    $grandTotal = 0;
                @endphp
                @foreach($studentResult->sortBy('id')->groupBy('examSubjectMark.examSubType.exam_type_id')->sortBy('id') as $results)
                        <?php
                        $total = 0;
                        $resultStatus = 'Pass';
                        $colour = '';
                        ?>
                    @foreach($results as $result)
                            <?php
                            $total += $result->marks + $result->grace_marks;
                            $special = $result->whereIn('exam_subject_mark_id', $examSubjectMarkIds)->whereNotNull('special_status')->where('student_id', $studentId)->count();
                            $pass = $result->whereIn('exam_subject_mark_id', $examSubjectMarkIds)->where('pass_status', 1)->where('student_id', $studentId)->count();
                            $fail = $result->whereIn('exam_subject_mark_id', $examSubjectMarkIds)->where('pass_status', 2)->where('student_id', $studentId)->count();
                            $absent = $result->whereIn('exam_subject_mark_id', $examSubjectMarkIds)->where('pass_status', 4)->where('student_id', $studentId)->count();
                            $grace = $result->whereIn('exam_subject_mark_id', $examSubjectMarkIds)->where('pass_status', 3)->where('student_id', $studentId)->count();
                            if ($special > 0) {
                                $resultStatus = $result->whereIn('exam_subject_mark_id', $examSubjectMarkIds)->where('special_status', 1)->where('student_id', $studentId)->count() > 0 ? 'Pass' : 'Fail';
                                $colour = $result->whereIn('exam_subject_mark_id', $examSubjectMarkIds)->where('special_status', 1)->where('student_id', $studentId)->count() > 0 ? 'text-success' : 'text-warning';
                            }
                            ?>
                        <td class="text-center align-middle">{{$result->pass_status === 4 ? '-' : $result->marks + $result->grace_marks}}</td>
                    @endforeach
                    <td class="text-center align-middle">{{$total}}</td>
                    @php
                        $grandTotal += $total;
                    @endphp
                @endforeach
                <td class="text-center align-middle">
                    @php
                        $passPercentage = \Setting::getSiteSetting()->pass_mark;
                        $grandTotal = $grandTotal ?? 0;
                        $checkPercentage = ($grandTotal * 100) / $examTotalMarks;

                        if ($special < 1) {
                            if ($absent > 0 && $pass == 0) {
                                $resultStatus = 'Absent';
                            } elseif ($passPercentage <= $checkPercentage) {
                                if ($grace < 1) {
                                    $resultStatus = 'Pass';
                                    $colour = '';
                                } else {
                                    $resultStatus = 'Pass(Grace)';
                                }
                            } elseif ($fail > 0) {
                                $resultStatus = 'Fail';
                            }
                        }
                    @endphp
                    <span class="{{$colour}}">{{$resultStatus}}</span>
                </td>
                <td class="text-center align-middle">{{ $result->remarks ?: '--'}}</td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>
</body>
</html>
