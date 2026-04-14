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
                <p style="font-size:30px;margin-bottom:0; text-align:center;">North East Medical College</p>
                <p style="box-sizing:border-box;margin-top:0;font-size:1.4rem;margin-bottom:0;" >{{$phase->title}}</p>
                <?php
                $batch = $session->sessionDetails->where('course_id', $exams->first()->course_id)->first()->batch_number;
                ?>
                <h6 style="box-sizing:border-box;font-size:1rem;margin-bottom:.5rem;line-height:1.2;margin-top:0;font-weight:bold;" >Session: {{$session->title}} ({{$exams->first()->course->title}} {{getOrdinal($batch)}} Batch)</h6>
            </div>
        </div>
        <br/>
        <div style="box-sizing:border-box;position:relative;width:100%;padding-right:15px;padding-left:15px;-ms-flex:0 0 100%;flex:0 0 100%;max-width:100%;" >
            <div style="box-sizing:border-box;display:block;width:100%;overflow-x:auto;-webkit-overflow-scrolling:touch;" >
                <table>
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
        </div>
    </div>
</div>

</body>
</html>
