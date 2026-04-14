@php use Carbon\Carbon; @endphp
    <!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
</head>
<body>
<div
    style="box-sizing:border-box;width:90%;max-width:1140px;padding-right:15px;padding-left:15px;margin-right:auto;margin-left:auto;">
    <div
        style="box-sizing:border-box;display:flex;-ms-flex-wrap:wrap;flex-wrap:wrap;margin-right:-15px;margin-left:-15px;">
        <div
            style="box-sizing:border-box;position:relative;width:100%;padding-right:15px;padding-left:15px;-ms-flex:0 0 100%;flex:0 0 100%;max-width:100%;">
            <div style="box-sizing:border-box;text-align:center;">
                <p style="font-size:2rem;margin-bottom:0; text-align:center;">North East Medical College</p>
                <h5 style="box-sizing:border-box;font-size:1.25rem;margin-bottom:.5rem;line-height:1.2;margin-top:0;font-weight:bold;">
                    Department Of {{$subject->department->title}}</h5>
                <p style="box-sizing:border-box;margin-top:0;font-size:1.4rem;margin-bottom:0;">Result: {{$exam->title}}
                    Examination, {{Carbon::createFromFormat('d/m/Y', $exam->examSubjects->first()->exam_date)->format('F Y')}}</p>
                {{--<p style="box-sizing:border-box;margin-top:0;font-size:1.4rem;margin-bottom:0;" >Result: {{$exam->title}} Examination, {{\Carbon\Carbon::parse($exam->examSubjects->first()->exam_date)->format('F Y')}}</p>--}}
                @php
                    $batch = $exam->session->sessionDetails->where('course_id', $exam->course_id)->first()->batch_number;
                @endphp
                <h6 style="box-sizing:border-box;font-size:1rem;margin-bottom:.5rem;line-height:1.2;margin-top:0;font-weight:bold;">
                    Session: {{$exam->session->title}} ({{$exam->course->title}} {{getOrdinal($batch)}} Batch)</h6>
                {{--<h6 style="box-sizing:border-box;font-size:1rem;margin-bottom:.5rem;line-height:1.2;margin-top:0;font-weight:bold;" >Session: {{$exam->session->title}} ({{$exam->course->title}} {{getOrdinal($batch)}} Batch)</h6>--}}
                @php
                    $student = $examResult->first()->first()->student;
                @endphp
                <h6 style="box-sizing:border-box;font-size:1rem;margin-bottom:.5rem;line-height:1.2;margin-top:0;font-weight:bold;">
                    Name: {{$student->full_name_en}}, Roll: {{$student->roll_no}}</h6>
            </div>
        </div>
        <br/>
        @php
            $passPercentage = Setting::getSiteSetting()->pass_mark;
            $examSubjectMarkIds = [];
        @endphp
        <div
            style="box-sizing:border-box;position:relative;width:100%;padding-right:15px;padding-left:15px;-ms-flex:0 0 100%;flex:0 0 100%;max-width:100%;">
            <div
                style="box-sizing:border-box;display:block;width:100%;overflow-x:auto;-webkit-overflow-scrolling:touch;">
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
                        <th class="align-middle" rowspan="2">Remark</th>
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
                                    $grace   = $result->whereIn('exam_subject_mark_id', $examSubjectMarkIds)->where('pass_status', 3)->where('student_id', $result->student_id)->count();

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
        </div>
    </div>
</div>
</body>
</html>
