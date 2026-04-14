<div class="col-md-12" style="position:relative;width:100%;padding-right:15px;padding-left:15px;-ms-flex:0 0 100%;flex:0 0 100%;max-width:100%;">
    <div class="text-center" style="text-align:center;">
        <h4 class="font-bold text-uppercase" style="font-size:1.5rem;margin-bottom:.5rem;line-height:1.2;margin-top:0;font-weight:bold;text-transform:uppercase!important;">North East Medical College, Sylhet</h4>
        <h5 class="font-bold" style="font-size:1.2rem;margin-bottom:.5rem;line-height:1.2;margin-top:0;font-weight:bold;">
            <span>Department of {{$department->title}},</span>
        </h5>
        <h5 class="font-bold" style="font-size:1.2rem;margin-bottom:.5rem;line-height:1.2;margin-top:0;font-weight:bold;">
            <span>Session : {{$sessionInfo}} </span>, <span>Course : {{$course}} </span>,  <span>Phase : {{$phase}} </span>,  <span>Term : {{$term}}</span>
        </h5>
    </div>
</div>
<br/>
<table class="table table-bordered table-hover">
    <thead>
    <tr>
        <th rowspan="2" style="vertical-align: middle; text-align: center">Roll No</th>
        <th rowspan="2" style="vertical-align: middle; text-align: center">Student Name</th>
        <th colspan="4" style="vertical-align: middle; text-align: center">Lecture</th>
        <th colspan="4" style="vertical-align: middle; text-align: center">Tutorial and Other</th>
        <th rowspan="2" style="vertical-align: middle; text-align: center">Remarks</th>
    </tr>
    <tr>
        <th style="vertical-align: middle; text-align: center">Class Held</th>
        <th style="vertical-align: middle; text-align: center">Present</th>
        <th style="vertical-align: middle; text-align: center">Absent</th>
        <th style="vertical-align: middle; text-align: center">Present(%)</th>
        <th style="vertical-align: middle; text-align: center">Class Held</th>
        <th style="vertical-align: middle; text-align: center">Present</th>
        <th style="vertical-align: middle; text-align: center">Absent</th>
        <th style="vertical-align: middle; text-align: center">Present(%)</th>
    </tr>
    </thead>
    <tbody>
    @if(!empty($attendanceReport))
        @foreach($attendanceReport as $attendance)
            @php
                $total_exam_held_exclude_lec=0;
                if($attendance->total_exam_held_exclude_lec != 0) {
                    $total_exam_held_exclude_lec=round(($attendance->practical_present * 100) / $attendance->total_exam_held_exclude_lec);
                 }
                $total_lecture_present=0;
                if($totalLectureClass != 0) {
                    $total_lecture_present=round(($attendance->lecture_present * 100) / $totalLectureClass);
                 }
            @endphp
            <tr>
                <td style="vertical-align: middle; text-align: center">{{$attendance->student->roll_no}}</td>
                <td style="vertical-align: middle;">{{$attendance->student->full_name_en}}</td>
                <td style="vertical-align: middle; text-align: center">{{$totalLectureClass > 0 ? $totalLectureClass : '-'}}</td>
                <td style="vertical-align: middle; text-align: center">{{$totalLectureClass > 0 ? $attendance->lecture_present : '-'}}</td>
                <td style="vertical-align: middle; text-align: center">{{$totalLectureClass > 0 ? $totalLectureClass-$attendance->lecture_present : '-'}}</td>
                <td style="vertical-align: middle; text-align: center">{{$totalLectureClass > 0 ? $total_lecture_present.'%' : '-'}}</td>
                <td style="vertical-align: middle; text-align: center">{{$attendance->total_exam_held_exclude_lec > 0 ? $attendance->total_exam_held_exclude_lec : '-'}}</td>
                <td style="vertical-align: middle; text-align: center">{{$attendance->total_exam_held_exclude_lec > 0 ? $attendance->practical_present : '-'}}</td>
                <td style="vertical-align: middle; text-align: center">{{$attendance->total_exam_held_exclude_lec > 0 ? $attendance->total_exam_held_exclude_lec-$attendance->practical_present : '-'}}</td>
                <td style="vertical-align: middle; text-align: center">{{$attendance->total_exam_held_exclude_lec > 0 ? $total_exam_held_exclude_lec.'%' : '-'}}</td>
                <td></td>
            </tr>
        @endforeach
    @endif
    </tbody>
</table>
