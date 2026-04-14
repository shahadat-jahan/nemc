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
        <p style="box-sizing:border-box;font-size:1rem;margin-bottom:.5rem;line-height:1.2;margin-top:0;font-weight:bold;" >
            Statement showing the particular of the candidates applied for admission in the 1st year {{$courseText}}
            course (Foreign Quota) of North East Medical College in the session {{$sessionText}}
        </p>
    </div>
</div>
<br>
<table class="table table-bordered table-hover" id="dataTable">
    <thead>
    <tr>
        <th rowspan="2">SL#</th>
        <th rowspan="2">Name &#x26; parents name of the candidates</th>
        <th rowspan="2">Permanent Address</th>
        <th rowspan="2">Date of birth</th>
        <th rowspan="2">Nationality</th>
        <th rowspan="2">Class Roll</th>
        <th rowspan="2">Visa Duration</th>
        <th colspan="4">A Level / Similar</th>
        <th colspan="5">O Level / Similar</th>
        <th rowspan="2">A Level &#x26; O Level total GPA</th>
        <th rowspan="2">Total GPA converted to marks (15+25)</th>
        <th colspan="4">Particulars of Admission Test</th>
        <th rowspan="2">Admission Date</th>
        <th rowspan="2">Remarks</th>
    </tr>
    <tr>
        <th>Board</th>
        <th>Year</th>
        <th>GPA<br>(WOS)</th>
        <th>Total * 15</th>
        <th>Board</th>
        <th>Year</th>
        <th>GPA<br>(WOS)</th>
        <th>Total GPA * 25</th>
        <th>Biology</th>
        <th>Roll No</th>
        <th>Test Score</th>
        <th>Merit Score</th>
        <th>Merit Position</th>
    </tr>
    @if(isset($searchResult))
        <tr>
            <td>A</td>
            <td>B</td>
            <td>C</td>
            <td>D</td>
            <td>E</td>
            <td>F</td>
            <td>G</td>
            <td>H</td>
            <td>I</td>
            <td>J</td>
            <td>K</td>
            <td>L</td>
            <td>M</td>
            <td>N</td>
            <td>O</td>
            <td>P</td>
            <td>Q</td>
            <td>R</td>
            <td>S</td>
            <td>T</td>
            <td>U</td>
            <td>V</td>
            <td>W</td>
            <td>X</td>
        </tr>
    @endif
    </thead>
    <tbody>
    @if(isset($searchResult))
        @if(!empty($searchResult))
            <?php $i = 1; ?>
            @foreach($searchResult as $student)
                <?php
                $aLevel = $student->educations->first();
                $oLevel = $student->educations->last();
                ?>
                <tr>
                    <td>{{$i}}</td>
                    <td>{!! 'Name: '.$student->full_name_en.'<br> Father: '.$student->parent->father_name.'<br> Mother: '.$student->parent->mother_name !!}</td>
                    <td>{{$student->permanent_address}}</td>
                    <td>{{$student->date_of_birth}}</td>
                    <td>{{$student->country->name}}</td>
                    <td>{{$student->roll_no}}</td>
                    <td>{{$student->visa_duration}}</td>
                    <td>{{$aLevel->educationBoard->title}}</td>
                    <td>{{$aLevel->pass_year}}</td>
                    <td>{{$aLevel->gpa}}</td>
                    <td>{{$aLevel->gpa * 15}}</td>
                    <td>{{$oLevel->educationBoard->title}}</td>
                    <td>{{$oLevel->pass_year}}</td>
                    <td>{{$oLevel->gpa}}</td>
                    <td>{{$oLevel->gpa * 25}}</td>
                    <td>{{$oLevel->gpa_biology}}</td>
                    <td>{{$aLevel->gpa + $oLevel->gpa}}</td>
                    <td>{{($aLevel->gpa * 15) + ($oLevel->gpa * 25)}}</td>
                    <td>{{$student->admission_roll_no}}</td>
                    <td>{{$student->test_score}}</td>
                    <td>{{$student->merit_score}}</td>
                    <td>{{$student->merit_position}}</td>
                    <td>{{$student->form_fillup_date ? $student->form_fillup_date : '--'}}</td>
                    <td>{{$student->remarks}}</td>
                </tr>
                <?php $i++; ?>
            @endforeach
        @else
            <tr><td colspan="15" align="center">No data found</td></tr>
        @endif
    @endif
    </tbody>
    <tfoot>
    <tr>
        <th colspan="14" rowspan="4">
            <div style="text-decoration: underline;font-weight: bold;font-size: 14px"><b>Criterion For Admission Of Foreign Students </b></div><br>
            i) S.S.C and H.S.C with minimum G.P.A(S.S.C + H.S.C) 7.00 (Not less than G.P.A 3.00 in any examination) <br>
            ii) Equivalance Certificate (on Marks S.S.C and HSC) issued by DGHS <br>

        </th>

    </tr>
    </tfoot>
</table>

</body>
</html>
