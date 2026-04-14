<div style="position:relative;width:100%;padding-right:5px;padding-left:5px;-ms-flex:0 0 100%;flex:0 0 100%;">
    <div class="text-center" style="text-align:center; margin-left: 500px;">
        <h4 class="font-bold text-uppercase" style="font-size:1.5rem;margin-bottom:.5rem;line-height:1.2;margin-top:0;font-weight:bold;text-transform:uppercase;">North East Medical College, Sylhet</h4>
        <h5 class="font-bold" style="font-size:1.2rem;margin-bottom:.5rem;line-height:1.2;margin-top:0;font-weight:bold;">
            <span> Department of {{$subjectInfo->department->title}}, </span>
        </h5>
        <h5 class="font-bold" style="font-size:1.2rem;margin-bottom:.5rem;line-height:1.2;margin-top:0;font-weight:bold;">
            <span>Session : {{$sessionInfo->title}} </span>, <span>Course : {{$courseInfo->title}} </span>,  <span>Phase : {{$phaseInfo->title}} </span>
        </h5>
        @if(isset($start_date))
            <span>Date : {{$start_date}} - {{$end_date ?? 'Today'}}</span>
            <br>
        @endif
    </div>
</div>
<br/>
<table class="table table-bordered table-hover">
    <thead>
    <tr>
        <th rowspan="2" style="vertical-align: middle; text-align: center">Roll No</th>
        <th rowspan="2" style="vertical-align: middle; text-align: center">Student Name</th>

        @if($showAllClassTypes)
            {{-- Show single column header for all class types combined --}}
            <th colspan="4" style="text-align: center">All Class Types</th>
        @else
            {{-- Show separate column header for each selected class type --}}
            @foreach($selectedClassTypes as $classType)
                <th colspan="4" style="text-align: center">{{ $classType->title }}</th>
            @endforeach
        @endif

        <th rowspan="2" style="vertical-align: middle; text-align: center">Remarks</th>
    </tr>
    <tr>
        @if($showAllClassTypes)
            {{-- Single set of sub-headers for combined data --}}
            <th style="vertical-align: middle; text-align: center">Class Held</th>
            <th style="vertical-align: middle; text-align: center">Present</th>
            <th style="vertical-align: middle; text-align: center">Absent</th>
            <th style="vertical-align: middle; text-align: center">Present(%)</th>
        @else
            {{-- Sub-headers for each selected class type --}}
            @foreach($selectedClassTypes as $classType)
                <th style="vertical-align: middle; text-align: center">Class Held</th>
                <th style="vertical-align: middle; text-align: center">Present</th>
                <th style="vertical-align: middle; text-align: center">Absent</th>
                <th style="vertical-align: middle; text-align: center">Present(%)</th>
            @endforeach
        @endif
    </tr>
    </thead>
    <tbody>
    @foreach($attendanceReport as $student)
        <tr>
            <th style="vertical-align: middle; text-align: center">{{ $student->roll_no }}</th>
            <td>{{ $student->full_name_en }}</td>

            @if($showAllClassTypes)
                {{-- Show combined totals across all class types --}}
                @php
                    $totalCount = 0;
                    $presentCount = 0;
                    if (isset($student->classTypeData) && is_array($student->classTypeData)) {
                        foreach ($student->classTypeData as $data) {
                            $totalCount += $data['total_count'] ?? 0;
                            $presentCount += $data['present_count'] ?? 0;
                        }
                    }
                    $absentCount = $totalCount - $presentCount;
                    $percentage = $totalCount > 0 ? round(($presentCount * 100) / $totalCount) : 0;
                @endphp

                <td style="vertical-align: middle; text-align: center">{{ $totalCount > 0 ? $totalCount : '-' }}</td>
                <td style="vertical-align: middle; text-align: center">{{ $totalCount > 0 ? $presentCount : '-' }}</td>
                <td style="vertical-align: middle; text-align: center">{{ $totalCount > 0 ? $absentCount : '-' }}</td>
                <td style="vertical-align: middle; text-align: center">{{ $totalCount > 0 ? $percentage.'%' : '-' }}</td>
            @else
                {{-- Show separate data for each selected class type --}}
                @foreach($selectedClassTypes as $classType)
                    @php
                        $classTypeData = $student->classTypeData[$classType->id] ?? null;
                        $totalCount = $classTypeData['total_count'] ?? 0;
                        $presentCount = $classTypeData['present_count'] ?? 0;
                        $absentCount = $totalCount - $presentCount;
                        $percentage = $totalCount > 0 ? round(($presentCount * 100) / $totalCount) : 0;
                    @endphp

                    <td style="vertical-align: middle; text-align: center">{{ $totalCount > 0 ? $totalCount : '-' }}</td>
                    <td style="vertical-align: middle; text-align: center">{{ $totalCount > 0 ? $presentCount : '-' }}</td>
                    <td style="vertical-align: middle; text-align: center">{{ $totalCount > 0 ? $absentCount : '-' }}</td>
                    <td style="vertical-align: middle; text-align: center">{{ $totalCount > 0 ? $percentage.'%' : '-' }}</td>
                @endforeach
            @endif
            <td></td>
        </tr>
    @endforeach
    </tbody>
</table>
