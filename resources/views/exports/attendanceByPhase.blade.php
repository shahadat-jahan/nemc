<div class="col-md-12" style="position:relative;width:100%;padding-right:15px;padding-left:15px;-ms-flex:0 0 100%;flex:0 0 100%;max-width:100%;">
    <div class="text-center" style="text-align:center; margin-left: 500px;">
        <h4 class="font-bold text-uppercase" style="font-size:1.5rem;margin-bottom:.5rem;line-height:1.2;margin-top:0;font-weight:bold;text-transform:uppercase;">North East Medical College, Sylhet</h4>
        <h5 class="font-bold" style="font-size:1.2rem;margin-bottom:.5rem;line-height:1.2;margin-top:0;font-weight:bold;">
            <span>Phase: {{$phase}} </span>
        </h5>

        <h5 class="font-bold" style="font-size:1.2rem;margin-bottom:.5rem;line-height:1.2;margin-top:0;font-weight:bold;">
            <span>Session : {{$sessionInfo}}</span>, <span>Course: {{$course}}</span>
        </h5>
    </div>
</div>
<br/>
<table class="table table-bordered">
    <thead>
    <tr>
        <th rowspan="3" style="vertical-align: middle; text-align: center">Roll No</th>
        <th rowspan="3" style="vertical-align: middle; text-align: center">Student Name</th>
        @foreach($subjects as $subject)
            <th colspan="7" style="vertical-align: middle; text-align: center">{{$subject->title}}</th>
        @endforeach
        <th rowspan="3" style="vertical-align: middle; text-align: center">Remarks</th>
    </tr>
    <tr>
        @foreach($subjects as $subject)
            <th rowspan="2" style="vertical-align: middle; text-align: center">Total Per(%)</th>
            <th colspan="3" style="vertical-align: middle; text-align: center">Lecture</th>
            <th colspan="3" style="vertical-align: middle; text-align: center">Tutorial and Other</th>
        @endforeach
    </tr>
    <tr>
        @foreach($subjects as $subject)
            <th style="vertical-align: middle; text-align: center">Held</th>
            <th style="vertical-align: middle; text-align: center">Attend</th>
            <th style="vertical-align: middle; text-align: center">Per(%)</th>
            <th style="vertical-align: middle; text-align: center">Held</th>
            <th style="vertical-align: middle; text-align: center">Attend</th>
            <th style="vertical-align: middle; text-align: center">Per(%)</th>
        @endforeach
    </tr>
    </thead>
    <tbody>
    @foreach(($attendanceByStudent ?? collect()) as $rollNo => $studentInfo)
        <tr>
            <th style="vertical-align: middle; text-align: center">{{$rollNo}}</th>
            <td style="vertical-align: middle;">{{$studentInfo['student_name'] ?? ''}}</td>
            @foreach($subjects as $subject)
                @php
                    $subjectAttendanceMap = $studentInfo['subjects'] ?? collect();
                    $attendance = $subjectAttendanceMap->get($subject->id);

                    if ($attendance) {
                        $heldClasses = $attendance['total_class'] ?? 0;
                        $heldLectureClasses = $attendance['total_lecture_class'] ?? 0;
                        $heldTutorialClasses = $attendance['total_tutorial_class'] ?? 0;
                    } else {
                        $heldClasses = $heldLectureClasses = $heldTutorialClasses = '-';
                    }
                @endphp
                <td style="vertical-align: middle; text-align: center">{{ ($attendance && $attendance['attendance_percentage'] !== null) ? $attendance['attendance_percentage'].'%' : '-' }}</td>
                <td style="vertical-align: middle; text-align: center">{{$heldLectureClasses > 0 ? $heldLectureClasses : '-'}}</td>
                <td style="vertical-align: middle; text-align: center">{{$heldLectureClasses > 0 ? ($attendance['lecture_class_present'] ?? '-') : '-'}}</td>
                <td style="vertical-align: middle; text-align: center">{{ ($attendance && $attendance['lecture_percentage'] !== null) ? $attendance['lecture_percentage'].'%' : '-' }}</td>
                <td style="vertical-align: middle; text-align: center">{{$heldTutorialClasses > 0 ? $heldTutorialClasses : '-'}}</td>
                <td style="vertical-align: middle; text-align: center">{{$heldTutorialClasses > 0 ? ($attendance['tutorial_class_present'] ?? '-') : '-'}}</td>
                <td style="vertical-align: middle; text-align: center">{{ ($attendance && $attendance['tutorial_percentage'] !== null) ? $attendance['tutorial_percentage'].'%' : '-' }}</td>
            @endforeach
            <td></td>
        </tr>
    @endforeach
    </tbody>
</table>
