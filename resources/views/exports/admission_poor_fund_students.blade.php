<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
</head>
<body>
<?php
$courseText = !empty($courseId) ? $courses[$courseId] : 'MBBS & BDS';
$sessionText = !empty($sessionId) ? $sessions[$sessionId] : '**';
?>
<div style="box-sizing:border-box;position:relative;width:100%;padding-right:15px;padding-left:15px;-ms-flex:0 0 100%;flex:0 0 100%;max-width:100%;" >
    <div style="box-sizing:border-box;text-align:center;" >
        <h1 align="center">North East Medical College</h1>
        <h3 align="center">Sylhet</h3>
        <br>
        <div style="text-align: center">
            Statement showing the particular of the candidates applied for admission in the 1st year {{$courseText}}
            course of North East Medical College in the session {{$sessionText}}
            <p style="text-decoration: underline">Insolvent &#x26; Meritorious Quota</p>
            <p style="text-decoration: underline">Sort by Insolvement Gradation of Column "V"</p>
        </div>
    </div>
</div>
<br>
<table class="table table-bordered table-hover" id="dataTable">
    <thead>
    <tr>
        <th rowspan="2" class="txt-center">SL#</th>
        <th rowspan="2" class="txt-center"><div style="width: 150px">Name &#x26; parents name of the candidates</div></th>
        <th rowspan="2" class="txt-center"><div style="width: 130px">Permanent Address</div></th>
        <th colspan="3" class="txt-center">SSC</th>
        <th colspan="4" class="txt-center">HSC</th>
        <th colspan="4" class="txt-center">Particulars of Admission Test</th>
        <th rowspan="2" class="txt-center">Annual Income</th>
        <th rowspan="2" class="txt-center">Insolvent Gradation(11)</th>
        <th rowspan="2" class="txt-center">Immovable Assets</th>
        <th rowspan="2" class="txt-center">Insolvent Gradation(9)</th>
        <th rowspan="2" class="txt-center">Movable Assets</th>
        <th rowspan="2" class="txt-center">Insolvent Gradation(9)</th>
        <th rowspan="2" class="txt-center">Total Assets</th>
        <th rowspan="2" class="txt-center">Total Insolvent Gradation(9)</th>
        <th rowspan="2" class="txt-center">Total Point from Merit Score &#x26; insolvement gradation</th>
        <th rowspan="2" class="txt-center">Affidavit Verify</th>
        <th rowspan="2" class="txt-center">Remarks</th>
    </tr>
    <tr>
        <th class="txt-center">Year</th>
        <th class="txt-center">GPA<br>(WOS)</th>
        <th class="txt-center">Total<br>GPA</th>
        <th class="txt-center">Year</th>
        <th class="txt-center">GPA<br>(WOS)</th>
        <th class="txt-center">Total<br>GPA</th>
        <th class="txt-center">Biology</th>
        <th class="txt-center">Roll No</th>
        <th class="txt-center">Test Score</th>
        <th class="txt-center">Merit Score</th>
        <th class="txt-center">Merit Position</th>
    </tr>
    @if(isset($searchResult))
        <tr>
            <td class="txt-center">A</td>
            <td class="txt-center">B</td>
            <td class="txt-center">C</td>
            <td class="txt-center">D</td>
            <td class="txt-center">E</td>
            <td class="txt-center">F</td>
            <td class="txt-center">G</td>
            <td class="txt-center">H</td>
            <td class="txt-center">I</td>
            <td class="txt-center">J</td>
            <td class="txt-center">K</td>
            <td class="txt-center">L</td>
            <td class="txt-center">M</td>
            <td class="txt-center">N</td>
            <td class="txt-center">O</td>
            <td class="txt-center">P</td>
            <td class="txt-center">Q</td>
            <td class="txt-center">R</td>
            <td class="txt-center">S</td>
            <td class="txt-center">T</td>
            <td>U=(O+Q+ class="txt-center" S)</td>
            <td>V=(P+R+ class="txt-center" T)</td>
            <td>W=(M+ class="txt-center" V)</td>
            <td class="txt-center">X</td>
            <td class="txt-center">Y</td>
        </tr>
    @endif
    </thead>
    <tbody>
    @if(isset($searchResult))
        @if(!empty($searchResult))
            <?php $i = 1; ?>
            @foreach($searchResult->sortBy('total_asset_grade') as $student)
                <?php
                $sscInfo = $student->admissionEducationHistories->first();
                $hscInfo = $student->admissionEducationHistories->last();
                ?>
                <tr>
                    <td>{{$i}}</td>
                    <td>{!! 'Name: '.$student->full_name_en.'<br> Father: '.$student->admissionParent->father_name.'<br> Mother: '.$student->admissionParent->mother_name !!}</td>
                    <td>{{$student->permanent_address}}</td>
                    <td>{{$sscInfo->pass_year}}</td>
                    <td>{{$sscInfo->gpa}}</td>
                    <td>{{$sscInfo->gpa * 15}}</td>
                    <td>{{$hscInfo->pass_year}}</td>
                    <td>{{$hscInfo->gpa}}</td>
                    <td>{{$hscInfo->gpa * 25}}</td>
                    <td>{{$hscInfo->gpa_biology}}</td>
                    <td>{{$student->admission_roll_no}}</td>
                    <td>{{$student->test_score}}</td>
                    <td>{{$student->merit_score}}</td>
                    <td>{{$student->merit_position}}</td>
                    <td>{{formatAmount($student->admissionParent->annual_income, 0)}}</td>
                    <td>{{$student->admissionParent->annual_income_grade}}</td>
                    <td>{{formatAmount($student->admissionParent->immovable_property, 0)}}</td>
                    <td>{{$student->admissionParent->immovable_property_grade}}</td>
                    <td>{{formatAmount($student->admissionParent->movable_property, 2)}}</td>
                    <td>{{$student->admissionParent->movable_property_grade}}</td>
                    <td>{{formatAmount($student->admissionParent->total_asset, 2)}}</td>
                    <td>{{$student->admissionParent->total_asset_grade}}</td>
                    <td>{{$student->merit_score + $student->admissionParent->total_asset_grade}}</td>
                    <td></td>
                    <td>{{$student->remarks}}</td>
                </tr>
                <?php $i++; ?>
            @endforeach
        @else
            <tr><td colspan="15" align="center">No data found</td></tr>
        @endif
    @endif
    </tbody>
</table>

</body>
</html>
