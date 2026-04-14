<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Comparative Attendance Report</title>
    <style>
        body {
            background-color: #F6F6F6;
            margin: 0;
            padding: 0;
            font-size: 11px;
        }

        h1, h2, h3, h4, h5, h6 {
            margin: 0;
            padding: 0;
        }

        .container {
            width: 100%;
            margin-right: auto;
            margin-left: auto;
        }

        .brand-section {
            background-color: #ffffff;
            padding: 10px 40px -10px;
        }

        .logo {
            width: 150px;
            margin-left: -30px;
        }

        .table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 1rem;
        }

        .table th,
        .table td {
            border: 1px solid #000;
            padding: 5px;
            text-align: center;
        }

        .table th {
            background-color: #f5f5f5;
        }

        .yellow-row {
            background-color: #fdeebc;
        }

        .text-center {
            text-align: center;
        }
        .text-right {
            text-align: right;
        }

        .summary {
            margin-bottom: 20px;
        }
    </style>
</head>

<body>
@php
    $totalStudents = count($reportData['students']);
    $studentsBelow = 0;
    $percentage = $percentage_filter ?? 75;
    $percentageType = $percentage_type ?? 'average';

    foreach ($reportData['students'] as $student) {
        $percentage_to_check = 0;
        if ($percentageType == 'lecture') {
            $percentage_to_check = $student['total']['lecture_percentage'] ?? 0;
        } elseif ($percentageType == 'tutorial') {
            $percentage_to_check = $student['total']['tutorial_percentage'] ?? 0;
        } else {
            $percentage_to_check = $student['total']['average_percentage'] ?? 0;
        }

        if ($percentage_to_check < $percentage) {
            $studentsBelow++;
        }
    }
@endphp
<div class="container">
    <div class="brand-section">
            <span>
                <img class="logo" src="{{ asset('assets/global/img/logo.jpg') }}"/>
            </span>
        <div style="margin-top: -40px" class="text-center">
            <h2>North East Medical College, Sylhet</h2>
            <h3>Comparative Attendance Report of {{ ucfirst($subject->title) }}</h3>
            <h3>Session: {{$session->title}}, {{$phase->title}}</h3>
            <h4>From {{$start_date}} to {{$end_date}}</h4>
        </div>
        <p class="text-right" style="padding-right: -30px"><strong>Generated on:</strong> {{\Carbon\Carbon::today()->format('d/m/Y')}}</p>
    </div>
    <br/>
    <table class="table">
        <thead>
        <tr>
            <th rowspan="3" class="text-center">Roll No</th>
            <th rowspan="3" class="text-center">Student Name</th>
            @foreach ($reportData['periods'] as $periodKey => $periodName)
                <th colspan="6" class="text-center">{{ $periodName }}</th>
            @endforeach
            <th colspan="7" class="text-center">Total</th>
        </tr>
        <tr>
            @foreach ($reportData['periods'] as $period)
                <th colspan="3" class="text-center">Lecture</th>
                <th colspan="3" class="text-center">Tutorial & Other</th>
            @endforeach
            <th colspan="3" class="text-center">Lecture</th>
            <th colspan="3" class="text-center">Tutorial & Other</th>
            <th rowspan="2" class="text-center">Avg(%)</th>
        </tr>
        <tr>
            @foreach ($reportData['periods'] as $period)
                <th class="text-center">Held</th>
                <th class="text-center">Attd</th>
                <th class="text-center">Per(%)</th>
                <th class="text-center">Held</th>
                <th class="text-center">Attd</th>
                <th class="text-center">Per(%)</th>
            @endforeach
            <th class="text-center">Held</th>
            <th class="text-center">Attd</th>
            <th class="text-center">Per(%)</th>
            <th class="text-center">Held</th>
            <th class="text-center">Attd</th>
            <th class="text-center">Per(%)</th>
        </tr>
        </thead>
        <tbody>
        @foreach ($reportData['students'] as $student)
            @php
                $percentage_to_check = 0;
                if ($percentageType == 'lecture') {
                    $percentage_to_check = $student['total']['lecture_percentage'] ?? 0;
                } elseif ($percentageType == 'tutorial') {
                    $percentage_to_check = $student['total']['tutorial_percentage'] ?? 0;
                } else {
                    $percentage_to_check = $student['total']['average_percentage'] ?? 0;
                }

                $shouldHighlight = $percentage > 0 && $percentage_to_check < $percentage;
            @endphp
            <tr class="{{ $shouldHighlight ? 'yellow-row' : '' }}">
                <td class="text-center">{{ $student['roll_no'] }}</td>
                <td>{{ $student['student_name'] }}</td>
                @foreach ($reportData['periods'] as $periodKey => $periodName)
                    @php $monthData = $student['monthly_data'][$periodKey] ?? null; @endphp
                    <td class="text-center">{{ $monthData['lecture_held'] ?? 0 }}</td>
                    <td class="text-center">{{ $monthData['lecture_attended'] ?? 0 }}</td>
                    <td class="text-center">{{ $monthData['lecture_percentage'] ?? 0 }}%</td>
                    <td class="text-center">{{ $monthData['tutorial_held'] ?? 0 }}</td>
                    <td class="text-center">{{ $monthData['tutorial_attended'] ?? 0 }}</td>
                    <td class="text-center">{{ $monthData['tutorial_percentage'] ?? 0 }}%</td>
                @endforeach
                <td class="text-center">{{ $student['total']['lecture_held'] }}</td>
                <td class="text-center">{{ $student['total']['lecture_attended'] }}</td>
                <td class="text-center">{{ $student['total']['lecture_percentage'] }}%</td>
                <td class="text-center">{{ $student['total']['tutorial_held'] }}</td>
                <td class="text-center">{{ $student['total']['tutorial_attended'] }}</td>
                <td class="text-center">{{ $student['total']['tutorial_percentage'] }}%</td>
                <td class="text-center">{{ $student['total']['average_percentage'] }}%</td>
            </tr>
        @endforeach
        </tbody>
    </table>
    <div class="summary">
        <p><strong>Note:</strong> There are {{ $studentsBelow }} students have below {{ $percentage }}%
            attendance {{ $percentageType == 'average' ? 'on average' : 'in ' . $percentageType }} in
            {{ ucfirst($subject->title) }} subject out of total {{ $totalStudents }} students.</p>
    </div>
</div>
</body>

</html>
