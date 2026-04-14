<!DOCTYPE html>
<html>
<head>
    <title>Comparative Attendance Report</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <style>
        .text-center { text-align: center; }
        .font-bold { font-weight: bold; }
        .yellow-bg { background-color: #fdeebc; }
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

    <table>
        <tr>
            <td colspan="20" align="center">
                <strong>North East Medical College, Sylhet</strong>
            </td>
        </tr>
        <tr>
            <td colspan="20" align="center">
                <h3>Comparative Attendance Report of {{ ucfirst($subject->title) }}</h3>
            </td>
        </tr>
        <tr>
            <td colspan="20" align="center">
                <h3>Session: {{$session->title}}, {{$phase->title}}</h3>
            </td>
        </tr>
        <tr>
            <td colspan="20" align="center">
                <h4>From {{$startDate}} to {{$endDate}}</h4>
            </td>
        </tr>
        <tr>
            <td colspan="20" align="center">
               Generated on: {{ \Carbon\Carbon::today()->format('d/m/Y') }}
            </td>
        </tr>
    </table>

    <table border="1">
        <thead>
            <tr>
                <th rowspan="3" align="center" valign="middle">Roll No</th>
                <th rowspan="3" align="center" valign="middle">Student Name</th>
                @foreach ($reportData['periods'] as $periodKey => $periodName)
                    <th colspan="6" align="center">{{ htmlspecialchars($periodName) }}</th>
                @endforeach
                <th colspan="7" align="center">Total</th>
            </tr>
            <tr>
                @foreach ($reportData['periods'] as $period)
                    <th colspan="3" align="center">Lecture</th>
                    <th colspan="3" align="center">Tutorial &amp; Other</th>
                @endforeach
                <th colspan="3" align="center">Lecture</th>
                <th colspan="3" align="center">Tutorial &amp; Other</th>
                <th rowspan="2" align="center" valign="middle">Avg(%)</th>
            </tr>
            <tr>
                @foreach ($reportData['periods'] as $period)
                    <th align="center">Held</th>
                    <th align="center">Attd</th>
                    <th align="center">Per(%)</th>
                    <th align="center">Held</th>
                    <th align="center">Attd</th>
                    <th align="center">Per(%)</th>
                @endforeach
                <th align="center">Held</th>
                <th align="center">Attd</th>
                <th align="center">Per(%)</th>
                <th align="center">Held</th>
                <th align="center">Attd</th>
                <th align="center">Per(%)</th>
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
                @endphp
                <tr>
                    <td align="center">{{ $student['roll_no'] }}</td>
                    <td>{{ htmlspecialchars($student['student_name']) }}</td>
                    @foreach ($reportData['periods'] as $periodKey => $periodName)
                        @php $monthData = $student['monthly_data'][$periodKey] ?? null; @endphp
                        <td align="center">{{ $monthData['lecture_held'] ?? 0 }}</td>
                        <td align="center">{{ $monthData['lecture_attended'] ?? 0 }}</td>
                        <td align="center">{{ $monthData['lecture_percentage'] ?? 0 }}%</td>
                        <td align="center">{{ $monthData['tutorial_held'] ?? 0 }}</td>
                        <td align="center">{{ $monthData['tutorial_attended'] ?? 0 }}</td>
                        <td align="center">{{ $monthData['tutorial_percentage'] ?? 0 }}%</td>
                    @endforeach
                    <td align="center">{{ $student['total']['lecture_held'] }}</td>
                    <td align="center">{{ $student['total']['lecture_attended'] }}</td>
                    <td align="center">{{ $student['total']['lecture_percentage'] }}%</td>
                    <td align="center">{{ $student['total']['tutorial_held'] }}</td>
                    <td align="center">{{ $student['total']['tutorial_attended'] }}</td>
                    <td align="center">{{ $student['total']['tutorial_percentage'] }}%</td>
                    <td align="center">{{ $student['total']['average_percentage'] }}%</td>
                </tr>
            @endforeach
        </tbody>
    </table>
    <table>
        <tr>
            <td colspan="20" style="padding-top: 20px;">
                <strong>Note:</strong> There are {{ $studentsBelow }} students have below {{ $percentage }}% attendance
                {{ $percentageType == 'average' ? 'on average' : 'in ' . htmlspecialchars($percentageType) }} in
                {{ htmlspecialchars(ucfirst($subject->title)) }} subject out of total {{ $totalStudents }} students.
            </td>
        </tr>
    </table>
</body>
</html>
