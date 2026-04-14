<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
</head>
<body>
<div style="box-sizing:border-box;width:90%;max-width:1140px;padding-right:15px;padding-left:15px;margin-right:auto;margin-left:auto;" >
    <div style="box-sizing:border-box;display:flex;-ms-flex-wrap:wrap;flex-wrap:wrap;margin-right:-15px;margin-left:-15px;" >
        <div style="box-sizing:border-box;position:relative;width:100%;padding-right:15px;padding-left:15px;-ms-flex:0 0 100%;flex:0 0 100%;max-width:100%;" >
            <div style="box-sizing:border-box;text-align:center;" >
                <p style="font-size:2rem;margin-bottom:0; text-align:center;">North East Medical College</p>
                <h5 style="box-sizing:border-box;font-size:1.25rem;margin-bottom:.5rem;line-height:1.2;margin-top:0;font-weight:bold;" >Department Of {{$subject->department->title}}</h5>
                <p style="box-sizing:border-box;margin-top:0;font-size:1.4rem;margin-bottom:0;" >Result: {{$exam->title}} Examination, {{date('F Y')}}</p>
                <?php
                $batch = $exam->session->sessionDetails->where('course_id', $exam->course_id)->first()->batch_number;
                ?>
                <h6 style="box-sizing:border-box;font-size:1rem;margin-bottom:.5rem;line-height:1.2;margin-top:0;font-weight:bold;" >Session: {{$exam->session->title}} ({{$exam->course->title}} {{getOrdinal($batch)}} Batch)</h6>
            </div>
        </div>
        <br/>
        @php
            $passPercentage = Setting::getSiteSetting()->pass_mark;
            $examSubjectMarkIds = [];
            $examSubjectMarks = $exam->examMarks->where('subject_id', $subject->id)->first();
        @endphp
        <div style="box-sizing:border-box;position:relative;width:100%;padding-right:15px;padding-left:15px;-ms-flex:0 0 100%;flex:0 0 100%;max-width:100%;" >
            <div style="box-sizing:border-box;display:block;width:100%;overflow-x:auto;-webkit-overflow-scrolling:touch;" >
                <table class="table table-bordered table-hover">
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
                                            $resultStatus = 'Absent';
                                            $textColor = 'text-warning';
                                        } elseif ($failCount > 0) {
                                            $resultStatus = 'Fail';
                                            $textColor = 'text-danger';
                                        } elseif ($failCount == 0 && $grace > 0) {
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
        </div>
    </div>
</div>







</body>
</html>
