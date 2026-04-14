@extends('layouts.print')
@push('style')
    <style type="text/css" media="print">
        @page {
            /*size: landscape;*/
            size: A3 landscape;
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
        Statement showing the particular of the candidates applied for admission in the 1st year {{$courseText}} course
        of North East Medical College in the session {{$sessionText}}
        <p style="text-decoration: underline">Insolvent & Meritorious Quota</p>
        <p style="text-decoration: underline">Sort by Insolvement Gradation of Column "V"</p>
    </div>
    <table class="table table-bordered table-hover" id="dataTable"  style="box-sizing:border-box;border-collapse:collapse;border-width:1px;border-style:solid;border-color:#f4f5f8;width:100%;margin-bottom:0 !important;background-color:rgba(0,0,0,0);">
        <thead>
        <tr style="box-sizing:border-box;">
            <th rowspan="2" style="border-bottom-width: 2px;vertical-align: bottom;border-bottom: 2px solid #dee2e6;border: 1px solid #f4f5f8;padding: .75rem;">SL#</th>
            <th rowspan="2" style="border-bottom-width: 2px;vertical-align: bottom;border-bottom: 2px solid #dee2e6;border: 1px solid #f4f5f8;padding: .75rem;"><div style="width: 150px">Name & parents name of the candidates</div></th>
            <th rowspan="2" style="border-bottom-width: 2px;vertical-align: bottom;border-bottom: 2px solid #dee2e6;border: 1px solid #f4f5f8;padding: .75rem;"><div style="width: 130px">Permanent Address</div></th>
            <th colspan="3" style="border-bottom-width: 2px;vertical-align: bottom;border-bottom: 2px solid #dee2e6;border: 1px solid #f4f5f8;padding: .75rem;">SSC</th>
            <th colspan="4" style="border-bottom-width: 2px;vertical-align: bottom;border-bottom: 2px solid #dee2e6;border: 1px solid #f4f5f8;padding: .75rem;">HSC</th>
            <th colspan="4" style="border-bottom-width: 2px;vertical-align: bottom;border-bottom: 2px solid #dee2e6;border: 1px solid #f4f5f8;padding: .75rem;">Particulars of Admission Test</th>
            <th rowspan="2" style="border-bottom-width: 2px;vertical-align: bottom;border-bottom: 2px solid #dee2e6;border: 1px solid #f4f5f8;padding: .75rem;">Annual Income</th>
            <th rowspan="2" class="column-rotate" style="border-bottom-width: 2px;vertical-align: bottom;border-bottom: 2px solid #dee2e6;border: 1px solid #f4f5f8;padding: .75rem;">Insolvent Gradation(11)</th>
            <th rowspan="2" style="border-bottom-width: 2px;vertical-align: bottom;border-bottom: 2px solid #dee2e6;border: 1px solid #f4f5f8;padding: .75rem;">Immovable Assets</th>
            <th rowspan="2" class="column-rotate" style="border-bottom-width: 2px;vertical-align: bottom;border-bottom: 2px solid #dee2e6;border: 1px solid #f4f5f8;padding: .75rem;">Insolvent Gradation(9)</th>
            <th rowspan="2" style="border-bottom-width: 2px;vertical-align: bottom;border-bottom: 2px solid #dee2e6;border: 1px solid #f4f5f8;padding: .75rem;">Movable Assets</th>
            <th rowspan="2" class="column-rotate" style="border-bottom-width: 2px;vertical-align: bottom;border-bottom: 2px solid #dee2e6;border: 1px solid #f4f5f8;padding: .75rem;">Insolvent Gradation(9)</th>
            <th rowspan="2" style="border-bottom-width: 2px;vertical-align: bottom;border-bottom: 2px solid #dee2e6;border: 1px solid #f4f5f8;padding: .75rem;">Total Assets</th>
            <th rowspan="2" class="column-rotate" style="border-bottom-width: 2px;vertical-align: bottom;border-bottom: 2px solid #dee2e6;border: 1px solid #f4f5f8;padding: .75rem;">Total Insolvent Gradation(9)</th>
            <th rowspan="2" style="border-bottom-width: 2px;vertical-align: bottom;border-bottom: 2px solid #dee2e6;border: 1px solid #f4f5f8;padding: .75rem;">Total Point from Merit Score & insolvement gradation</th>
            <th rowspan="2" style="border-bottom-width: 2px;vertical-align: bottom;border-bottom: 2px solid #dee2e6;border: 1px solid #f4f5f8;padding: .75rem;">Affidifit Verify</th>
            <th rowspan="2" style="border-bottom-width: 2px;vertical-align: bottom;border-bottom: 2px solid #dee2e6;border: 1px solid #f4f5f8;padding: .75rem;">Remarks</th>
        </tr>
        <tr style="box-sizing:border-box;">
            <th class="txt-center" style="border-bottom-width: 2px;vertical-align: bottom;border-bottom: 2px solid #dee2e6;border: 1px solid #f4f5f8;padding: .75rem;">Year</th>
            <th class="txt-center" style="border-bottom-width: 2px;vertical-align: bottom;border-bottom: 2px solid #dee2e6;border: 1px solid #f4f5f8;padding: .75rem;">GPA<br>(WOS)</th>
            <th class="txt-center" style="border-bottom-width: 2px;vertical-align: bottom;border-bottom: 2px solid #dee2e6;border: 1px solid #f4f5f8;padding: .75rem;">Total<br>GPA</th>
            <th class="txt-center" style="border-bottom-width: 2px;vertical-align: bottom;border-bottom: 2px solid #dee2e6;border: 1px solid #f4f5f8;padding: .75rem;">Year</th>
            <th class="txt-center" style="border-bottom-width: 2px;vertical-align: bottom;border-bottom: 2px solid #dee2e6;border: 1px solid #f4f5f8;padding: .75rem;">GPA<br>(WOS)</th>
            <th class="txt-center" style="border-bottom-width: 2px;vertical-align: bottom;border-bottom: 2px solid #dee2e6;border: 1px solid #f4f5f8;padding: .75rem;">Total<br>GPA</th>
            <th class="txt-center" style="border-bottom-width: 2px;vertical-align: bottom;border-bottom: 2px solid #dee2e6;border: 1px solid #f4f5f8;padding: .75rem;">Biology</th>
            <th class="txt-center" style="border-bottom-width: 2px;vertical-align: bottom;border-bottom: 2px solid #dee2e6;border: 1px solid #f4f5f8;padding: .75rem;">Roll No</th>
            <th class="txt-center" style="border-bottom-width: 2px;vertical-align: bottom;border-bottom: 2px solid #dee2e6;border: 1px solid #f4f5f8;padding: .75rem;">Test Score</th>
            <th class="txt-center" style="border-bottom-width: 2px;vertical-align: bottom;border-bottom: 2px solid #dee2e6;border: 1px solid #f4f5f8;padding: .75rem;">Merit Score</th>
            <th class="txt-center" style="border-bottom-width: 2px;vertical-align: bottom;border-bottom: 2px solid #dee2e6;border: 1px solid #f4f5f8;padding: .75rem;">Merit Position</th>
        </tr>
        @if(isset($searchResult))
            <tr style="box-sizing:border-box;">
                <td class="txt-center"  style="box-sizing:border-box;border-width:1px;border-style:solid;border-color:#f4f5f8;padding-top:.2rem !important;padding-bottom:.2rem !important;padding-right:.75rem;padding-left:.75rem;vertical-align:top;border-top-width:1px;border-top-style:solid;border-top-color:#f4f5f8;">A</td>
                <td class="txt-center"  style="box-sizing:border-box;border-width:1px;border-style:solid;border-color:#f4f5f8;padding-top:.2rem !important;padding-bottom:.2rem !important;padding-right:.75rem;padding-left:.75rem;vertical-align:top;border-top-width:1px;border-top-style:solid;border-top-color:#f4f5f8;">B</td>
                <td class="txt-center"  style="box-sizing:border-box;border-width:1px;border-style:solid;border-color:#f4f5f8;padding-top:.2rem !important;padding-bottom:.2rem !important;padding-right:.75rem;padding-left:.75rem;vertical-align:top;border-top-width:1px;border-top-style:solid;border-top-color:#f4f5f8;">C</td>
                <td class="txt-center"  style="box-sizing:border-box;border-width:1px;border-style:solid;border-color:#f4f5f8;padding-top:.2rem !important;padding-bottom:.2rem !important;padding-right:.75rem;padding-left:.75rem;vertical-align:top;border-top-width:1px;border-top-style:solid;border-top-color:#f4f5f8;">D</td>
                <td class="txt-center"  style="box-sizing:border-box;border-width:1px;border-style:solid;border-color:#f4f5f8;padding-top:.2rem !important;padding-bottom:.2rem !important;padding-right:.75rem;padding-left:.75rem;vertical-align:top;border-top-width:1px;border-top-style:solid;border-top-color:#f4f5f8;">E</td>
                <td class="txt-center"  style="box-sizing:border-box;border-width:1px;border-style:solid;border-color:#f4f5f8;padding-top:.2rem !important;padding-bottom:.2rem !important;padding-right:.75rem;padding-left:.75rem;vertical-align:top;border-top-width:1px;border-top-style:solid;border-top-color:#f4f5f8;">F</td>
                <td class="txt-center"  style="box-sizing:border-box;border-width:1px;border-style:solid;border-color:#f4f5f8;padding-top:.2rem !important;padding-bottom:.2rem !important;padding-right:.75rem;padding-left:.75rem;vertical-align:top;border-top-width:1px;border-top-style:solid;border-top-color:#f4f5f8;">G</td>
                <td class="txt-center"  style="box-sizing:border-box;border-width:1px;border-style:solid;border-color:#f4f5f8;padding-top:.2rem !important;padding-bottom:.2rem !important;padding-right:.75rem;padding-left:.75rem;vertical-align:top;border-top-width:1px;border-top-style:solid;border-top-color:#f4f5f8;">H</td>
                <td class="txt-center"  style="box-sizing:border-box;border-width:1px;border-style:solid;border-color:#f4f5f8;padding-top:.2rem !important;padding-bottom:.2rem !important;padding-right:.75rem;padding-left:.75rem;vertical-align:top;border-top-width:1px;border-top-style:solid;border-top-color:#f4f5f8;">I</td>
                <td class="txt-center"  style="box-sizing:border-box;border-width:1px;border-style:solid;border-color:#f4f5f8;padding-top:.2rem !important;padding-bottom:.2rem !important;padding-right:.75rem;padding-left:.75rem;vertical-align:top;border-top-width:1px;border-top-style:solid;border-top-color:#f4f5f8;">J</td>
                <td class="txt-center"  style="box-sizing:border-box;border-width:1px;border-style:solid;border-color:#f4f5f8;padding-top:.2rem !important;padding-bottom:.2rem !important;padding-right:.75rem;padding-left:.75rem;vertical-align:top;border-top-width:1px;border-top-style:solid;border-top-color:#f4f5f8;">K</td>
                <td class="txt-center"  style="box-sizing:border-box;border-width:1px;border-style:solid;border-color:#f4f5f8;padding-top:.2rem !important;padding-bottom:.2rem !important;padding-right:.75rem;padding-left:.75rem;vertical-align:top;border-top-width:1px;border-top-style:solid;border-top-color:#f4f5f8;">L</td>
                <td class="txt-center"  style="box-sizing:border-box;border-width:1px;border-style:solid;border-color:#f4f5f8;padding-top:.2rem !important;padding-bottom:.2rem !important;padding-right:.75rem;padding-left:.75rem;vertical-align:top;border-top-width:1px;border-top-style:solid;border-top-color:#f4f5f8;">M</td>
                <td class="txt-center"  style="box-sizing:border-box;border-width:1px;border-style:solid;border-color:#f4f5f8;padding-top:.2rem !important;padding-bottom:.2rem !important;padding-right:.75rem;padding-left:.75rem;vertical-align:top;border-top-width:1px;border-top-style:solid;border-top-color:#f4f5f8;">N</td>
                <td class="txt-center"  style="box-sizing:border-box;border-width:1px;border-style:solid;border-color:#f4f5f8;padding-top:.2rem !important;padding-bottom:.2rem !important;padding-right:.75rem;padding-left:.75rem;vertical-align:top;border-top-width:1px;border-top-style:solid;border-top-color:#f4f5f8;">O</td>
                <td class="txt-center"  style="box-sizing:border-box;border-width:1px;border-style:solid;border-color:#f4f5f8;padding-top:.2rem !important;padding-bottom:.2rem !important;padding-right:.75rem;padding-left:.75rem;vertical-align:top;border-top-width:1px;border-top-style:solid;border-top-color:#f4f5f8;">P</td>
                <td class="txt-center"  style="box-sizing:border-box;border-width:1px;border-style:solid;border-color:#f4f5f8;padding-top:.2rem !important;padding-bottom:.2rem !important;padding-right:.75rem;padding-left:.75rem;vertical-align:top;border-top-width:1px;border-top-style:solid;border-top-color:#f4f5f8;">Q</td>
                <td class="txt-center"  style="box-sizing:border-box;border-width:1px;border-style:solid;border-color:#f4f5f8;padding-top:.2rem !important;padding-bottom:.2rem !important;padding-right:.75rem;padding-left:.75rem;vertical-align:top;border-top-width:1px;border-top-style:solid;border-top-color:#f4f5f8;">R</td>
                <td class="txt-center"  style="box-sizing:border-box;border-width:1px;border-style:solid;border-color:#f4f5f8;padding-top:.2rem !important;padding-bottom:.2rem !important;padding-right:.75rem;padding-left:.75rem;vertical-align:top;border-top-width:1px;border-top-style:solid;border-top-color:#f4f5f8;">S</td>
                <td class="txt-center"  style="box-sizing:border-box;border-width:1px;border-style:solid;border-color:#f4f5f8;padding-top:.2rem !important;padding-bottom:.2rem !important;padding-right:.75rem;padding-left:.75rem;vertical-align:top;border-top-width:1px;border-top-style:solid;border-top-color:#f4f5f8;">T</td>
                <td  style="box-sizing:border-box;border-width:1px;border-style:solid;border-color:#f4f5f8;padding-top:.2rem !important;padding-bottom:.2rem !important;padding-right:.75rem;padding-left:.75rem;vertical-align:top;border-top-width:1px;border-top-style:solid;border-top-color:#f4f5f8;">U=(O+Q+ class="txt-center" S)</td>
                <td  style="box-sizing:border-box;border-width:1px;border-style:solid;border-color:#f4f5f8;padding-top:.2rem !important;padding-bottom:.2rem !important;padding-right:.75rem;padding-left:.75rem;vertical-align:top;border-top-width:1px;border-top-style:solid;border-top-color:#f4f5f8;">V=(P+R+ class="txt-center" T)</td>
                <td  style="box-sizing:border-box;border-width:1px;border-style:solid;border-color:#f4f5f8;padding-top:.2rem !important;padding-bottom:.2rem !important;padding-right:.75rem;padding-left:.75rem;vertical-align:top;border-top-width:1px;border-top-style:solid;border-top-color:#f4f5f8;">W=(M+ class="txt-center" V)</td>
                <td class="txt-center"  style="box-sizing:border-box;border-width:1px;border-style:solid;border-color:#f4f5f8;padding-top:.2rem !important;padding-bottom:.2rem !important;padding-right:.75rem;padding-left:.75rem;vertical-align:top;border-top-width:1px;border-top-style:solid;border-top-color:#f4f5f8;">X</td>
                <td class="txt-center"  style="box-sizing:border-box;border-width:1px;border-style:solid;border-color:#f4f5f8;padding-top:.2rem !important;padding-bottom:.2rem !important;padding-right:.75rem;padding-left:.75rem;vertical-align:top;border-top-width:1px;border-top-style:solid;border-top-color:#f4f5f8;">Y</td>
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
                    <tr style="box-sizing:border-box;">
                        <td  style="box-sizing:border-box;border-width:1px;border-style:solid;border-color:#f4f5f8;padding-top:.2rem !important;padding-bottom:.2rem !important;padding-right:.75rem;padding-left:.75rem;vertical-align:top;border-top-width:1px;border-top-style:solid;border-top-color:#f4f5f8;">{{$i}}</td>
                        <td  style="box-sizing:border-box;border-width:1px;border-style:solid;border-color:#f4f5f8;padding-top:.2rem !important;padding-bottom:.2rem !important;padding-right:.75rem;padding-left:.75rem;vertical-align:top;border-top-width:1px;border-top-style:solid;border-top-color:#f4f5f8;">{!! $student->full_name_en.'<br>'.$student->admissionParent->father_name.'<br>'.$student->admissionParent->mother_name !!}</td>
                        <td  style="box-sizing:border-box;border-width:1px;border-style:solid;border-color:#f4f5f8;padding-top:.2rem !important;padding-bottom:.2rem !important;padding-right:.75rem;padding-left:.75rem;vertical-align:top;border-top-width:1px;border-top-style:solid;border-top-color:#f4f5f8;">{{$student->permanent_address}}</td>
                        <td  style="box-sizing:border-box;border-width:1px;border-style:solid;border-color:#f4f5f8;padding-top:.2rem !important;padding-bottom:.2rem !important;padding-right:.75rem;padding-left:.75rem;vertical-align:top;border-top-width:1px;border-top-style:solid;border-top-color:#f4f5f8;">{{$sscInfo->pass_year}}</td>
                        <td  style="box-sizing:border-box;border-width:1px;border-style:solid;border-color:#f4f5f8;padding-top:.2rem !important;padding-bottom:.2rem !important;padding-right:.75rem;padding-left:.75rem;vertical-align:top;border-top-width:1px;border-top-style:solid;border-top-color:#f4f5f8;">{{$sscInfo->gpa}}</td>
                        <td  style="box-sizing:border-box;border-width:1px;border-style:solid;border-color:#f4f5f8;padding-top:.2rem !important;padding-bottom:.2rem !important;padding-right:.75rem;padding-left:.75rem;vertical-align:top;border-top-width:1px;border-top-style:solid;border-top-color:#f4f5f8;">{{$sscInfo->gpa * 15}}</td>
                        <td  style="box-sizing:border-box;border-width:1px;border-style:solid;border-color:#f4f5f8;padding-top:.2rem !important;padding-bottom:.2rem !important;padding-right:.75rem;padding-left:.75rem;vertical-align:top;border-top-width:1px;border-top-style:solid;border-top-color:#f4f5f8;">{{$hscInfo->pass_year}}</td>
                        <td  style="box-sizing:border-box;border-width:1px;border-style:solid;border-color:#f4f5f8;padding-top:.2rem !important;padding-bottom:.2rem !important;padding-right:.75rem;padding-left:.75rem;vertical-align:top;border-top-width:1px;border-top-style:solid;border-top-color:#f4f5f8;">{{$hscInfo->gpa}}</td>
                        <td  style="box-sizing:border-box;border-width:1px;border-style:solid;border-color:#f4f5f8;padding-top:.2rem !important;padding-bottom:.2rem !important;padding-right:.75rem;padding-left:.75rem;vertical-align:top;border-top-width:1px;border-top-style:solid;border-top-color:#f4f5f8;">{{$hscInfo->gpa * 25}}</td>
                        <td  style="box-sizing:border-box;border-width:1px;border-style:solid;border-color:#f4f5f8;padding-top:.2rem !important;padding-bottom:.2rem !important;padding-right:.75rem;padding-left:.75rem;vertical-align:top;border-top-width:1px;border-top-style:solid;border-top-color:#f4f5f8;">{{$hscInfo->gpa_biology}}</td>
                        <td  style="box-sizing:border-box;border-width:1px;border-style:solid;border-color:#f4f5f8;padding-top:.2rem !important;padding-bottom:.2rem !important;padding-right:.75rem;padding-left:.75rem;vertical-align:top;border-top-width:1px;border-top-style:solid;border-top-color:#f4f5f8;">{{$student->admission_roll_no}}</td>
                        <td  style="box-sizing:border-box;border-width:1px;border-style:solid;border-color:#f4f5f8;padding-top:.2rem !important;padding-bottom:.2rem !important;padding-right:.75rem;padding-left:.75rem;vertical-align:top;border-top-width:1px;border-top-style:solid;border-top-color:#f4f5f8;">{{$student->test_score}}</td>
                        <td  style="box-sizing:border-box;border-width:1px;border-style:solid;border-color:#f4f5f8;padding-top:.2rem !important;padding-bottom:.2rem !important;padding-right:.75rem;padding-left:.75rem;vertical-align:top;border-top-width:1px;border-top-style:solid;border-top-color:#f4f5f8;">{{$student->merit_score}}</td>
                        <td  style="box-sizing:border-box;border-width:1px;border-style:solid;border-color:#f4f5f8;padding-top:.2rem !important;padding-bottom:.2rem !important;padding-right:.75rem;padding-left:.75rem;vertical-align:top;border-top-width:1px;border-top-style:solid;border-top-color:#f4f5f8;">{{$student->merit_position}}</td>
                        <td  style="box-sizing:border-box;border-width:1px;border-style:solid;border-color:#f4f5f8;padding-top:.2rem !important;padding-bottom:.2rem !important;padding-right:.75rem;padding-left:.75rem;vertical-align:top;border-top-width:1px;border-top-style:solid;border-top-color:#f4f5f8;">{{formatAmount($student->admissionParent->annual_income, 0)}}</td>
                        <td  style="box-sizing:border-box;border-width:1px;border-style:solid;border-color:#f4f5f8;padding-top:.2rem !important;padding-bottom:.2rem !important;padding-right:.75rem;padding-left:.75rem;vertical-align:top;border-top-width:1px;border-top-style:solid;border-top-color:#f4f5f8;">{{$student->admissionParent->annual_income_grade}}</td>
                        <td  style="box-sizing:border-box;border-width:1px;border-style:solid;border-color:#f4f5f8;padding-top:.2rem !important;padding-bottom:.2rem !important;padding-right:.75rem;padding-left:.75rem;vertical-align:top;border-top-width:1px;border-top-style:solid;border-top-color:#f4f5f8;">{{formatAmount($student->admissionParent->immovable_property, 0)}}</td>
                        <td  style="box-sizing:border-box;border-width:1px;border-style:solid;border-color:#f4f5f8;padding-top:.2rem !important;padding-bottom:.2rem !important;padding-right:.75rem;padding-left:.75rem;vertical-align:top;border-top-width:1px;border-top-style:solid;border-top-color:#f4f5f8;">{{$student->admissionParent->immovable_property_grade}}</td>
                        <td  style="box-sizing:border-box;border-width:1px;border-style:solid;border-color:#f4f5f8;padding-top:.2rem !important;padding-bottom:.2rem !important;padding-right:.75rem;padding-left:.75rem;vertical-align:top;border-top-width:1px;border-top-style:solid;border-top-color:#f4f5f8;">{{formatAmount($student->admissionParent->movable_property, 2)}}</td>
                        <td  style="box-sizing:border-box;border-width:1px;border-style:solid;border-color:#f4f5f8;padding-top:.2rem !important;padding-bottom:.2rem !important;padding-right:.75rem;padding-left:.75rem;vertical-align:top;border-top-width:1px;border-top-style:solid;border-top-color:#f4f5f8;">{{$student->admissionParent->movable_property_grade}}</td>
                        <td  style="box-sizing:border-box;border-width:1px;border-style:solid;border-color:#f4f5f8;padding-top:.2rem !important;padding-bottom:.2rem !important;padding-right:.75rem;padding-left:.75rem;vertical-align:top;border-top-width:1px;border-top-style:solid;border-top-color:#f4f5f8;">{{formatAmount($student->admissionParent->total_asset, 2)}}</td>
                        <td  style="box-sizing:border-box;border-width:1px;border-style:solid;border-color:#f4f5f8;padding-top:.2rem !important;padding-bottom:.2rem !important;padding-right:.75rem;padding-left:.75rem;vertical-align:top;border-top-width:1px;border-top-style:solid;border-top-color:#f4f5f8;">{{$student->admissionParent->total_asset_grade}}</td>
                        <td  style="box-sizing:border-box;border-width:1px;border-style:solid;border-color:#f4f5f8;padding-top:.2rem !important;padding-bottom:.2rem !important;padding-right:.75rem;padding-left:.75rem;vertical-align:top;border-top-width:1px;border-top-style:solid;border-top-color:#f4f5f8;">{{$student->merit_score + $student->admissionParent->total_asset_grade}}</td>
                        <td  style="box-sizing:border-box;border-width:1px;border-style:solid;border-color:#f4f5f8;padding-top:.2rem !important;padding-bottom:.2rem !important;padding-right:.75rem;padding-left:.75rem;vertical-align:top;border-top-width:1px;border-top-style:solid;border-top-color:#f4f5f8;"></td>
                        <td  style="box-sizing:border-box;border-width:1px;border-style:solid;border-color:#f4f5f8;padding-top:.2rem !important;padding-bottom:.2rem !important;padding-right:.75rem;padding-left:.75rem;vertical-align:top;border-top-width:1px;border-top-style:solid;border-top-color:#f4f5f8;">{{$student->remarks}}</td>
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
