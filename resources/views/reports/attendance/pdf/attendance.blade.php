<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Attendance</title>
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
            background-color: #ffffff;
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

        table {
            border-collapse: collapse;
        }

        table thead th {
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
            text-transform: uppercase;
        }

        .text-center {
            text-align: center;
        }

        .text-left {
            text-align: left;
        }

        .text-right {
            text-align: right;
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

    </style>
</head>
<body>
<div class="container">
    <div class="brand-section">
       <span>
            <img class="logo" src="{{asset('assets/global/img/logo.jpg')}}"/>
        </span>
        <div style="margin-top: -45px" class="text-center">
            <h2>North East Medical College, Sylhet</h2>
            <br>
            <h3>
                <span> Department of {{$department}} </span>
            </h3>
            <br>
            <span>Session : {{$session}} </span>, <span>Course : {{$course}} </span>,
            <span>Phase : {{$phase}} </span>,
            @if(isset($start_date))
                <br>
                <span>Date : {{$start_date}} - {{$end_date ?? 'Today'}}</span>
            @endif
        </div>
    </div>
    <br/>
    <table class="table table-bordered table-hover">
        <thead>
        <tr>
            <th rowspan="2" class="align-middle text-center">Roll No</th>
            <th rowspan="2" class="align-middle text-center">Student Name</th>

            @if($showAllClassTypes)
                {{-- Show single column header for all class types combined --}}
                <th colspan="4" class="text-center">All Class Types</th>
            @else
                {{-- Show separate column header for each selected class type --}}
                @foreach($selectedClassTypes as $classType)
                    <th colspan="4" class="text-center">{{ $classType->title }}</th>
                @endforeach
            @endif

            <th rowspan="2" class="align-middle text-center">Remarks</th>
        </tr>
        <tr>
            @if($showAllClassTypes)
                {{-- Single set of sub-headers for combined data --}}
                <th class="text-center">Class Held</th>
                <th class="text-center">Present</th>
                <th class="text-center">Absent</th>
                <th class="text-center">Present(%)</th>
            @else
                {{-- Sub-headers for each selected class type --}}
                @foreach($selectedClassTypes as $classType)
                    <th class="text-center">Class Held</th>
                    <th class="text-center">Present</th>
                    <th class="text-center">Absent</th>
                    <th class="text-center">Present(%)</th>
                @endforeach
            @endif
        </tr>
        </thead>
        <tbody>
        @foreach($attendanceReport as $student)
            <tr>
                <th class="text-center">{{ $student->roll_no }}</th>
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

                    <td class="text-center">{{ $totalCount > 0 ? $totalCount : '-' }}</td>
                    <td class="text-center">{{ $totalCount > 0 ? $presentCount : '-' }}</td>
                    <td class="text-center">{{ $totalCount > 0 ? $absentCount : '-' }}</td>
                    <td class="text-center">{{ $totalCount > 0 ? $percentage.'%' : '-' }}</td>
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

                        <td class="text-center">{{ $totalCount > 0 ? $totalCount : '-' }}</td>
                        <td class="text-center">{{ $totalCount > 0 ? $presentCount : '-' }}</td>
                        <td class="text-center">{{ $totalCount > 0 ? $absentCount : '-' }}</td>
                        <td class="text-center">{{ $totalCount > 0 ? $percentage.'%' : '-' }}</td>
                    @endforeach
                @endif
                <td></td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>
</body>
</html>
