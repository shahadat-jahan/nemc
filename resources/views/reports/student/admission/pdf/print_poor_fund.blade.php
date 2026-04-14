<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Poor Fund Students Admission Report</title>
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

        .text-center {
            text-align: center;
        }

        .text-right {
            text-align: right;
        }

        .text-left {
            text-align: left;
        }
        
        @page {
            footer: page-footer;
            margin: 10px;
            margin-footer: 10px;
        }
    </style>
</head>

<body>
@php
    $courseText = !empty($courseId) ? $courses[$courseId] : 'MBBS & BDS';
    $sessionText = !empty($sessionId) ? $sessions[$sessionId] : '**';
@endphp

<div class="container">
    <div class="brand-section">
        <span>
            <img class="logo" src="{{ asset('assets/global/img/logo.jpg') }}"/>
        </span>
        <div style="margin-top: -40px" class="text-center">
            <h2>North East Medical College, Sylhet</h2>
            <h3>Poor Fund Students Admission Report</h3>
            <p>Statement showing the particular of the candidates applied for admission in the 1st year {{$courseText}} course <br> (Poor Fund Quota) of North East Medical College in the session {{$sessionText}}</p>
            <p>Sort by Insolvement Gradation of Column "V"</p>
            <p class="text-right" style="padding-right: -30px"><strong>Generated on:</strong>
                {{ \Carbon\Carbon::today()->format('d/m/Y') }}</p>
        </div>
    </div>

    <table class="table">
        <thead>
        <tr>
            <th rowspan="2">SL#</th>
            <th rowspan="2">Name & parents name of the candidates</th>
            <th rowspan="2">Permanent Address</th>
            <th rowspan="2">Date of birth</th>
            <th rowspan="2">Nationality</th>
            <th rowspan="2">Class Roll</th>
            <th colspan="4">SSC</th>
            <th colspan="5">HSC</th>
            <th colspan="4">Particulars of Admission Test</th>
            <th rowspan="2">Annual Income</th>
            <th rowspan="2" class="column-rotate">Insolvent Gradation(11)</th>
            <th rowspan="2">Immovable Assets</th>
            <th rowspan="2" class="column-rotate">Insolvent Gradation(9)</th>
            <th rowspan="2">Movable Assets</th>
            <th rowspan="2" class="column-rotate">Insolvent Gradation(9)</th>
            <th rowspan="2">Total Assets</th>
            <th rowspan="2" class="column-rotate">Total Insolvent Gradation(9)</th>
            <th rowspan="2">Total Point from Merit Score & insolvement gradation</th>
            <th rowspan="2">Affidifit Verify</th>
            <th rowspan="2">Admission Date</th>
            <th rowspan="2">Remarks</th>
        </tr>
        <tr>
            <th>Board</th>
            <th>Year</th>
            <th>GPA<br>(WOS)</th>
            <th>Total<br>GPA</th>
            <th>Board</th>
            <th>Year</th>
            <th>GPA<br>(WOS)</th>
            <th>Total<br>GPA</th>
            <th>Biology</th>
            <th>Roll No</th>
            <th>Test Score</th>
            <th>Merit Score</th>
            <th>Merit Position</th>
        </tr>
        </thead>
        <tbody>
        @if(isset($searchResult))
            @if(!empty($searchResult))
                <?php $i = 1; ?>
                @foreach($searchResult as $student)
                    <?php
                    $ssc = $student->educations->first();
                    $hsc = $student->educations->last();
                    ?>
                    <tr>
                        <td>{{$i}}</td>
                        <td class="text-left">{!! $student->full_name_en.'<br>'.$student->parent->father_name.'<br>'.$student->parent->mother_name !!}</td>
                        <td class="text-left">{{$student->permanent_address}}</td>
                        <td>{{$student->date_of_birth}}</td>
                        <td>{{$student->country->name}}</td>
                        <td>{{$student->roll_no}}</td>
                        <td>{{$ssc->educationBoard->title}}</td>
                        <td>{{$ssc->pass_year}}</td>
                        <td>{{$ssc->gpa}}</td>
                        <td>{{$ssc->gpa}}</td>
                        <td>{{$hsc->educationBoard->title}}</td>
                        <td>{{$hsc->pass_year}}</td>
                        <td>{{$hsc->gpa}}</td>
                        <td>{{$hsc->gpa}}</td>
                        <td>{{$hsc->gpa_biology}}</td>
                        <td>{{$student->admission_roll_no}}</td>
                        <td>{{$student->test_score}}</td>
                        <td>{{$student->merit_score}}</td>
                        <td>{{$student->merit_position}}</td>
                        <td>{{$student->annual_income ?? '--'}}</td>
                        <td>{{$student->insolvent_gradation_income ?? '--'}}</td>
                        <td>{{$student->immovable_assets ?? '--'}}</td>
                        <td>{{$student->insolvent_gradation_immovable ?? '--'}}</td>
                        <td>{{$student->movable_assets ?? '--'}}</td>
                        <td>{{$student->insolvent_gradation_movable ?? '--'}}</td>
                        <td>{{($student->immovable_assets ?? 0) + ($student->movable_assets ?? 0)}}</td>
                        <td>{{($student->insolvent_gradation_immovable ?? 0) + ($student->insolvent_gradation_movable ?? 0)}}</td>
                        <td>{{($student->merit_score ?? 0) + (($student->insolvent_gradation_immovable ?? 0) + ($student->insolvent_gradation_movable ?? 0))}}</td>
                        <td>{{$student->affidavit_verified ? 'Yes' : 'No'}}</td>
                        <td>{{$student->form_fillup_date ? $student->form_fillup_date : '--'}}</td>
                        <td class="text-left">{{$student->remarks}}</td>
                    </tr>
                    <?php $i++; ?>
                @endforeach
            @else
                <tr><td colspan="30" align="center">No data found</td></tr>
            @endif
        @endif
        </tbody>
    </table>
</div>
<htmlpagefooter name="page-footer">
    <div style="text-align: center; font-size: 12px; vertical-align: bottom;">Page {PAGENO} of {nbpg}</div>
</htmlpagefooter>
</body>
</html> 