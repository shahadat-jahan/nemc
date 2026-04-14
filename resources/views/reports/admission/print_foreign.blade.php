@extends('layouts.print')
@push('style')
    <style type="text/css" media="print">
        @page {
            /*size: landscape;*/
            size: A3 landscape;
        }
        .table-bordered th, .table-bordered td {
            border: 1px solid #000;
        }
        .column-rotate{
            transform: rotate(270deg);
        }
    </style>
@endpush

@section('content')
    <?php
    $courseText = !empty($courseId) ? $courses[$courseId] : 'MBBS & BDS';
    $sessionText = !empty($sessionId) ? $sessions[$sessionId] : '**';
    ?>

    <div style="text-align: center">
        Statement showing the particular of the candidates applied for admission i the 1st year {{$courseText}} course
        (Foreign Quota) of North East Medical College in the session {{$sessionText}}
    </div>
    <br>

    <table class="table table-bordered table-hover" id="dataTable"  style="box-sizing:border-box;border-collapse:collapse;border-width:1px;border-style:solid;border-color:#f4f5f8;width:100%;margin-bottom:0 !important;background-color:rgba(0,0,0,0);">
        <thead>
        <tr style="box-sizing:border-box;">
            <th rowspan="2" style="border-bottom-width: 2px;vertical-align: bottom;border-bottom: 2px solid #dee2e6;border: 1px solid #f4f5f8;padding: .75rem;">SL#</th>
            <th rowspan="2" style="border-bottom-width: 2px;vertical-align: bottom;border-bottom: 2px solid #dee2e6;border: 1px solid #f4f5f8;padding: .75rem;">Name & parents name of the candidates</th>
            <th rowspan="2" style="border-bottom-width: 2px;vertical-align: bottom;border-bottom: 2px solid #dee2e6;border: 1px solid #f4f5f8;padding: .75rem;">Permanent Address</th>
            <th rowspan="2" style="border-bottom-width: 2px;vertical-align: bottom;border-bottom: 2px solid #dee2e6;border: 1px solid #f4f5f8;padding: .75rem;">Nationality</th>
            <th rowspan="2" style="border-bottom-width: 2px;vertical-align: bottom;border-bottom: 2px solid #dee2e6;border: 1px solid #f4f5f8;padding: .75rem;">Visa Duration</th>
            <th colspan="3" style="border-bottom-width: 2px;vertical-align: bottom;border-bottom: 2px solid #dee2e6;border: 1px solid #f4f5f8;padding: .75rem;">A Level / Similar</th>
            <th colspan="4" style="border-bottom-width: 2px;vertical-align: bottom;border-bottom: 2px solid #dee2e6;border: 1px solid #f4f5f8;padding: .75rem;">O Level / Similar</th>
            <th rowspan="2" style="border-bottom-width: 2px;vertical-align: bottom;border-bottom: 2px solid #dee2e6;border: 1px solid #f4f5f8;padding: .75rem;">A Level & O Level total GPA</th>
            <th rowspan="2" style="border-bottom-width: 2px;vertical-align: bottom;border-bottom: 2px solid #dee2e6;border: 1px solid #f4f5f8;padding: .75rem;">Total GPA converted to marks (15+25)</th>
            <th colspan="4" style="border-bottom-width: 2px;vertical-align: bottom;border-bottom: 2px solid #dee2e6;border: 1px solid #f4f5f8;padding: .75rem;">Particulars of Admission Test</th>
            <th rowspan="2" style="border-bottom-width: 2px;vertical-align: bottom;border-bottom: 2px solid #dee2e6;border: 1px solid #f4f5f8;padding: .75rem;">Remarks</th>
        </tr>
        <tr style="box-sizing:border-box;">
            <th style="border-bottom-width: 2px;vertical-align: bottom;border-bottom: 2px solid #dee2e6;border: 1px solid #f4f5f8;padding: .75rem;">Year</th>
            <th style="border-bottom-width: 2px;vertical-align: bottom;border-bottom: 2px solid #dee2e6;border: 1px solid #f4f5f8;padding: .75rem;">GPA<br>(WOS)</th>
            <th style="border-bottom-width: 2px;vertical-align: bottom;border-bottom: 2px solid #dee2e6;border: 1px solid #f4f5f8;padding: .75rem;">Total * 15</th>
            <th style="border-bottom-width: 2px;vertical-align: bottom;border-bottom: 2px solid #dee2e6;border: 1px solid #f4f5f8;padding: .75rem;">Year</th>
            <th style="border-bottom-width: 2px;vertical-align: bottom;border-bottom: 2px solid #dee2e6;border: 1px solid #f4f5f8;padding: .75rem;">GPA<br>(WOS)</th>
            <th style="border-bottom-width: 2px;vertical-align: bottom;border-bottom: 2px solid #dee2e6;border: 1px solid #f4f5f8;padding: .75rem;">Total GPA * 25</th>
            <th style="border-bottom-width: 2px;vertical-align: bottom;border-bottom: 2px solid #dee2e6;border: 1px solid #f4f5f8;padding: .75rem;">Biology</th>
            <th style="border-bottom-width: 2px;vertical-align: bottom;border-bottom: 2px solid #dee2e6;border: 1px solid #f4f5f8;padding: .75rem;">Roll No</th>
            <th style="border-bottom-width: 2px;vertical-align: bottom;border-bottom: 2px solid #dee2e6;border: 1px solid #f4f5f8;padding: .75rem;">Test Score</th>
            <th style="border-bottom-width: 2px;vertical-align: bottom;border-bottom: 2px solid #dee2e6;border: 1px solid #f4f5f8;padding: .75rem;">Merit Score</th>
            <th style="border-bottom-width: 2px;vertical-align: bottom;border-bottom: 2px solid #dee2e6;border: 1px solid #f4f5f8;padding: .75rem;">Merit Position</th>
        </tr>
        @if(isset($searchResult))
            <tr style="box-sizing:border-box;">
                <td style="box-sizing:border-box;border-width:1px;border-style:solid;border-color:#f4f5f8;padding-top:.2rem !important;padding-bottom:.2rem !important;padding-right:.75rem;padding-left:.75rem;vertical-align:top;border-top-width:1px;border-top-style:solid;border-top-color:#f4f5f8;">A</td>
                <td style="box-sizing:border-box;border-width:1px;border-style:solid;border-color:#f4f5f8;padding-top:.2rem !important;padding-bottom:.2rem !important;padding-right:.75rem;padding-left:.75rem;vertical-align:top;border-top-width:1px;border-top-style:solid;border-top-color:#f4f5f8;">B</td>
                <td style="box-sizing:border-box;border-width:1px;border-style:solid;border-color:#f4f5f8;padding-top:.2rem !important;padding-bottom:.2rem !important;padding-right:.75rem;padding-left:.75rem;vertical-align:top;border-top-width:1px;border-top-style:solid;border-top-color:#f4f5f8;">C</td>
                <td style="box-sizing:border-box;border-width:1px;border-style:solid;border-color:#f4f5f8;padding-top:.2rem !important;padding-bottom:.2rem !important;padding-right:.75rem;padding-left:.75rem;vertical-align:top;border-top-width:1px;border-top-style:solid;border-top-color:#f4f5f8;">D</td>
                <td style="box-sizing:border-box;border-width:1px;border-style:solid;border-color:#f4f5f8;padding-top:.2rem !important;padding-bottom:.2rem !important;padding-right:.75rem;padding-left:.75rem;vertical-align:top;border-top-width:1px;border-top-style:solid;border-top-color:#f4f5f8;">E</td>
                <td style="box-sizing:border-box;border-width:1px;border-style:solid;border-color:#f4f5f8;padding-top:.2rem !important;padding-bottom:.2rem !important;padding-right:.75rem;padding-left:.75rem;vertical-align:top;border-top-width:1px;border-top-style:solid;border-top-color:#f4f5f8;">F</td>
                <td style="box-sizing:border-box;border-width:1px;border-style:solid;border-color:#f4f5f8;padding-top:.2rem !important;padding-bottom:.2rem !important;padding-right:.75rem;padding-left:.75rem;vertical-align:top;border-top-width:1px;border-top-style:solid;border-top-color:#f4f5f8;">G</td>
                <td style="box-sizing:border-box;border-width:1px;border-style:solid;border-color:#f4f5f8;padding-top:.2rem !important;padding-bottom:.2rem !important;padding-right:.75rem;padding-left:.75rem;vertical-align:top;border-top-width:1px;border-top-style:solid;border-top-color:#f4f5f8;">H</td>
                <td style="box-sizing:border-box;border-width:1px;border-style:solid;border-color:#f4f5f8;padding-top:.2rem !important;padding-bottom:.2rem !important;padding-right:.75rem;padding-left:.75rem;vertical-align:top;border-top-width:1px;border-top-style:solid;border-top-color:#f4f5f8;">I</td>
                <td style="box-sizing:border-box;border-width:1px;border-style:solid;border-color:#f4f5f8;padding-top:.2rem !important;padding-bottom:.2rem !important;padding-right:.75rem;padding-left:.75rem;vertical-align:top;border-top-width:1px;border-top-style:solid;border-top-color:#f4f5f8;">J</td>
                <td style="box-sizing:border-box;border-width:1px;border-style:solid;border-color:#f4f5f8;padding-top:.2rem !important;padding-bottom:.2rem !important;padding-right:.75rem;padding-left:.75rem;vertical-align:top;border-top-width:1px;border-top-style:solid;border-top-color:#f4f5f8;">K</td>
                <td style="box-sizing:border-box;border-width:1px;border-style:solid;border-color:#f4f5f8;padding-top:.2rem !important;padding-bottom:.2rem !important;padding-right:.75rem;padding-left:.75rem;vertical-align:top;border-top-width:1px;border-top-style:solid;border-top-color:#f4f5f8;">L</td>
                <td style="box-sizing:border-box;border-width:1px;border-style:solid;border-color:#f4f5f8;padding-top:.2rem !important;padding-bottom:.2rem !important;padding-right:.75rem;padding-left:.75rem;vertical-align:top;border-top-width:1px;border-top-style:solid;border-top-color:#f4f5f8;">M</td>
                <td style="box-sizing:border-box;border-width:1px;border-style:solid;border-color:#f4f5f8;padding-top:.2rem !important;padding-bottom:.2rem !important;padding-right:.75rem;padding-left:.75rem;vertical-align:top;border-top-width:1px;border-top-style:solid;border-top-color:#f4f5f8;">N</td>
                <td style="box-sizing:border-box;border-width:1px;border-style:solid;border-color:#f4f5f8;padding-top:.2rem !important;padding-bottom:.2rem !important;padding-right:.75rem;padding-left:.75rem;vertical-align:top;border-top-width:1px;border-top-style:solid;border-top-color:#f4f5f8;">O</td>
                <td style="box-sizing:border-box;border-width:1px;border-style:solid;border-color:#f4f5f8;padding-top:.2rem !important;padding-bottom:.2rem !important;padding-right:.75rem;padding-left:.75rem;vertical-align:top;border-top-width:1px;border-top-style:solid;border-top-color:#f4f5f8;">P</td>
                <td style="box-sizing:border-box;border-width:1px;border-style:solid;border-color:#f4f5f8;padding-top:.2rem !important;padding-bottom:.2rem !important;padding-right:.75rem;padding-left:.75rem;vertical-align:top;border-top-width:1px;border-top-style:solid;border-top-color:#f4f5f8;">Q</td>
                <td style="box-sizing:border-box;border-width:1px;border-style:solid;border-color:#f4f5f8;padding-top:.2rem !important;padding-bottom:.2rem !important;padding-right:.75rem;padding-left:.75rem;vertical-align:top;border-top-width:1px;border-top-style:solid;border-top-color:#f4f5f8;">R</td>
                <td style="box-sizing:border-box;border-width:1px;border-style:solid;border-color:#f4f5f8;padding-top:.2rem !important;padding-bottom:.2rem !important;padding-right:.75rem;padding-left:.75rem;vertical-align:top;border-top-width:1px;border-top-style:solid;border-top-color:#f4f5f8;">S</td>
            </tr>
        @endif
        </thead>
        <tbody>
        @if(isset($searchResult))
            @if(!empty($searchResult))
                <?php $i = 1; ?>
                @foreach($searchResult as $student)
                    <?php
                    $aLevel = $student->admissionEducationHistories->first();
                    $oLevel = $student->admissionEducationHistories->last();
                    ?>
                    <tr style="box-sizing:border-box;">
                        <td style="box-sizing:border-box;border-width:1px;border-style:solid;border-color:#f4f5f8;padding-top:.2rem !important;padding-bottom:.2rem !important;padding-right:.75rem;padding-left:.75rem;vertical-align:top;border-top-width:1px;border-top-style:solid;border-top-color:#f4f5f8;">{{$i}}</td>
                        <td style="box-sizing:border-box;border-width:1px;border-style:solid;border-color:#f4f5f8;padding-top:.2rem !important;padding-bottom:.2rem !important;padding-right:.75rem;padding-left:.75rem;vertical-align:top;border-top-width:1px;border-top-style:solid;border-top-color:#f4f5f8;">{!! $student->full_name_en.'<br>'.$student->admissionParent->father_name.'<br>'.$student->admissionParent->mother_name !!}</td>
                        <td style="box-sizing:border-box;border-width:1px;border-style:solid;border-color:#f4f5f8;padding-top:.2rem !important;padding-bottom:.2rem !important;padding-right:.75rem;padding-left:.75rem;vertical-align:top;border-top-width:1px;border-top-style:solid;border-top-color:#f4f5f8;">{{$student->permanent_address}}</td>
                        <td style="box-sizing:border-box;border-width:1px;border-style:solid;border-color:#f4f5f8;padding-top:.2rem !important;padding-bottom:.2rem !important;padding-right:.75rem;padding-left:.75rem;vertical-align:top;border-top-width:1px;border-top-style:solid;border-top-color:#f4f5f8;">{{$student->country->name}}</td>
                        <td style="box-sizing:border-box;border-width:1px;border-style:solid;border-color:#f4f5f8;padding-top:.2rem !important;padding-bottom:.2rem !important;padding-right:.75rem;padding-left:.75rem;vertical-align:top;border-top-width:1px;border-top-style:solid;border-top-color:#f4f5f8;">{{$student->visa_duration}}</td>
                        <td style="box-sizing:border-box;border-width:1px;border-style:solid;border-color:#f4f5f8;padding-top:.2rem !important;padding-bottom:.2rem !important;padding-right:.75rem;padding-left:.75rem;vertical-align:top;border-top-width:1px;border-top-style:solid;border-top-color:#f4f5f8;">{{$aLevel->pass_year}}</td>
                        <td style="box-sizing:border-box;border-width:1px;border-style:solid;border-color:#f4f5f8;padding-top:.2rem !important;padding-bottom:.2rem !important;padding-right:.75rem;padding-left:.75rem;vertical-align:top;border-top-width:1px;border-top-style:solid;border-top-color:#f4f5f8;">{{$aLevel->gpa}}</td>
                        <td style="box-sizing:border-box;border-width:1px;border-style:solid;border-color:#f4f5f8;padding-top:.2rem !important;padding-bottom:.2rem !important;padding-right:.75rem;padding-left:.75rem;vertical-align:top;border-top-width:1px;border-top-style:solid;border-top-color:#f4f5f8;">{{$aLevel->gpa * 15}}</td>
                        <td style="box-sizing:border-box;border-width:1px;border-style:solid;border-color:#f4f5f8;padding-top:.2rem !important;padding-bottom:.2rem !important;padding-right:.75rem;padding-left:.75rem;vertical-align:top;border-top-width:1px;border-top-style:solid;border-top-color:#f4f5f8;">{{$oLevel->pass_year}}</td>
                        <td style="box-sizing:border-box;border-width:1px;border-style:solid;border-color:#f4f5f8;padding-top:.2rem !important;padding-bottom:.2rem !important;padding-right:.75rem;padding-left:.75rem;vertical-align:top;border-top-width:1px;border-top-style:solid;border-top-color:#f4f5f8;">{{$oLevel->gpa}}</td>
                        <td style="box-sizing:border-box;border-width:1px;border-style:solid;border-color:#f4f5f8;padding-top:.2rem !important;padding-bottom:.2rem !important;padding-right:.75rem;padding-left:.75rem;vertical-align:top;border-top-width:1px;border-top-style:solid;border-top-color:#f4f5f8;">{{$oLevel->gpa * 25}}</td>
                        <td style="box-sizing:border-box;border-width:1px;border-style:solid;border-color:#f4f5f8;padding-top:.2rem !important;padding-bottom:.2rem !important;padding-right:.75rem;padding-left:.75rem;vertical-align:top;border-top-width:1px;border-top-style:solid;border-top-color:#f4f5f8;">{{$oLevel->gpa_biology}}</td>
                        <td style="box-sizing:border-box;border-width:1px;border-style:solid;border-color:#f4f5f8;padding-top:.2rem !important;padding-bottom:.2rem !important;padding-right:.75rem;padding-left:.75rem;vertical-align:top;border-top-width:1px;border-top-style:solid;border-top-color:#f4f5f8;">{{$aLevel->gpa + $oLevel->gpa}}</td>
                        <td style="box-sizing:border-box;border-width:1px;border-style:solid;border-color:#f4f5f8;padding-top:.2rem !important;padding-bottom:.2rem !important;padding-right:.75rem;padding-left:.75rem;vertical-align:top;border-top-width:1px;border-top-style:solid;border-top-color:#f4f5f8;">{{($aLevel->gpa * 15) + ($oLevel->gpa * 25)}}</td>
                        <td style="box-sizing:border-box;border-width:1px;border-style:solid;border-color:#f4f5f8;padding-top:.2rem !important;padding-bottom:.2rem !important;padding-right:.75rem;padding-left:.75rem;vertical-align:top;border-top-width:1px;border-top-style:solid;border-top-color:#f4f5f8;">{{$student->admission_roll_no}}</td>
                        <td style="box-sizing:border-box;border-width:1px;border-style:solid;border-color:#f4f5f8;padding-top:.2rem !important;padding-bottom:.2rem !important;padding-right:.75rem;padding-left:.75rem;vertical-align:top;border-top-width:1px;border-top-style:solid;border-top-color:#f4f5f8;">{{$student->test_score}}</td>
                        <td style="box-sizing:border-box;border-width:1px;border-style:solid;border-color:#f4f5f8;padding-top:.2rem !important;padding-bottom:.2rem !important;padding-right:.75rem;padding-left:.75rem;vertical-align:top;border-top-width:1px;border-top-style:solid;border-top-color:#f4f5f8;">{{$student->merit_score}}</td>
                        <td style="box-sizing:border-box;border-width:1px;border-style:solid;border-color:#f4f5f8;padding-top:.2rem !important;padding-bottom:.2rem !important;padding-right:.75rem;padding-left:.75rem;vertical-align:top;border-top-width:1px;border-top-style:solid;border-top-color:#f4f5f8;">{{$student->merit_position}}</td>
                        <td style="box-sizing:border-box;border-width:1px;border-style:solid;border-color:#f4f5f8;padding-top:.2rem !important;padding-bottom:.2rem !important;padding-right:.75rem;padding-left:.75rem;vertical-align:top;border-top-width:1px;border-top-style:solid;border-top-color:#f4f5f8;">{{$student->remarks}}</td>
                    </tr>
                    <?php $i++; ?>
                @endforeach
            @else
                <tr style="box-sizing:border-box;"><td colspan="15" align="center">No data found</td></tr>
            @endif
        @endif
        </tbody>
    </table>


@endsection
