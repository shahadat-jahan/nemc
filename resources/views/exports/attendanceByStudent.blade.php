<div class="col-md-12" style="position:relative;width:100%;padding-right:15px;padding-left:15px;-ms-flex:0 0 100%;flex:0 0 100%;max-width:100%;">
    <div class="text-center" style="text-align:center; margin-left: 500px;">
        <h4 class="font-bold text-uppercase" style="font-size:1.5rem;margin-bottom:.5rem;line-height:1.2;margin-top:0;font-weight:bold;text-transform:uppercase;">North East Medical College, Sylhet</h4>
        <h5 class="font-bold" style="font-size:1.2rem;margin-bottom:.5rem;line-height:1.2;margin-top:0;font-weight:bold;">
            <span> Department of {{$department}} </span>
        </h5>
        <h5>
            <span>Student: {{$student->full_name_en}}(Roll No-{{$student->roll_no}})</span>
        </h5>
        <h5 class="font-bold" style="font-size:1.2rem;margin-bottom:.5rem;line-height:1.2;margin-top:0;font-weight:bold;">
            <span>Session : {{$sessionInfo}} </span>, <span>Course : {{$course}} </span>,  <span>Phase : {{$phase}} </span>
        </h5>
        @if(isset($start_date))
            <span>Date : {{$start_date}} - {{$end_date ?? 'Today'}}</span>
            <br>
        @endif
    </div>
</div>
<br/>
<h4 class="font-bold text-uppercase" style="font-size:1.5rem;margin-bottom:.5rem;line-height:1.2;margin-top:0;font-weight:bold;text-transform:uppercase;">Attendance Summary</h4>
<table class="table table-bordered">
    <thead>
    <tr>
        @if($showAllClassTypes)
            {{-- Show single column header for all class types combined --}}
            <th scope="col" style="vertical-align: middle; text-align: center">All Class Types</th>
        @else
            {{-- Show separate column header for each selected class type --}}
            <th scope="col" style="vertical-align: middle; text-align: center">
                @foreach($selectedClassTypes as $index => $classType)
                    {{ $classType->title }}@if($index < count($selectedClassTypes) - 1), @endif
                @endforeach
            </th>
        @endif
        <th scope="col" style="vertical-align: middle; text-align: center">Attend</th>
        <th scope="col" style="vertical-align: middle; text-align: center">Absent</th>
        <th scope="col" style="vertical-align: middle; text-align: center">Attendance Percentage(%)</th>
    </tr>
    </thead>
    <tbody>
    <tr>
        <td class="text-center">{{$totalClass > 0 ? $totalClass : '-'}}</td>
        <td class="text-center">{{$totalClass > 0 ? $totalAttendance : '-'}}</td>
        <td class="text-center">{{$totalClass > 0 ? $totalClass - $totalAttendance : '-'}}</td>
        <td class="text-center">{{$totalClass > 0 ? round(($totalAttendance * 100) / ($totalClass > 0 ? $totalClass : 1)).'%' : '-'}}</td>
    </tr>
    </tbody>
</table>
<br>
<h4 class="font-bold text-uppercase" style="font-size:1.5rem;margin-bottom:.5rem;line-height:1.2;margin-top:0;font-weight:bold;text-transform:uppercase;">Attendance Detail</h4>
<table class="table table-bordered">
    <thead>
    <tr>
        <th scope="col" style="vertical-align: middle;">Date</th>
        <th scope="col" style="vertical-align: middle;">Subject</th>
        <th scope="col" style="vertical-align: middle;">Class Type</th>
        <th scope="col" style="vertical-align: middle;">Attendance(Present)</th>
    </tr>
    </thead>
    <tbody>
    @foreach($attendanceData as $attendance)
        <tr>
            <td scope="col" style="vertical-align: middle;">{{\Carbon\Carbon::parse($attendance->classRoutine->class_date)->format('d-F-Y')}}</td>
            <td scope="col" style="vertical-align: middle;">{{$attendance->classRoutine->subject->title}}</td>
            <td scope="col" style="vertical-align: middle;">{{$attendance->classRoutine->classType->title}}</td>
            <td scope="col" style="vertical-align: middle;">@if($attendance->attendance == 1) Yes @else No @endif</td>
        </tr>
    @endforeach
    </tbody>
</table>
