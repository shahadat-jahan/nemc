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
$sessionId = (isset(app()->request->session_id) && !empty(app()->request->session_id)) ? app()->request->session_id : '';
$courseId  = (isset(app()->request->course_id) && !empty(app()->request->course_id)) ? app()->request->course_id : '';
$phaseId   = (isset(app()->request->phase_id) && !empty(app()->request->phase_id)) ? app()->request->phase_id : '';
$termId    = (isset(app()->request->term_id) && !empty(app()->request->term_id)) ? app()->request->term_id : '';
$subjectId = (isset(app()->request->subject_id) && !empty(app()->request->subject_id)) ? app()->request->subject_id : '';
$classTypeId = (isset(app()->request->class_type_id) && !empty(app()->request->class_type_id)) ? app()->request->class_type_id : '';
$fromDate  = (isset(app()->request->from_date) && !empty(app()->request->from_date)) ? app()->request->from_date : '';
$toDate    = (isset(app()->request->to_date) && !empty(app()->request->to_date)) ? app()->request->to_date : '';
$assign    = $teacherWiseClass['assign'];
?>
<div style="box-sizing:border-box;width:90%;max-width:1140px;padding-right:15px;padding-left:15px;margin-right:auto;margin-left:auto;" >
    <div style="box-sizing:border-box;display:flex;-ms-flex-wrap:wrap;flex-wrap:wrap;margin-right:-15px;margin-left:-15px;" >
        <div style="box-sizing:border-box;position:relative;width:100%;padding-right:15px;padding-left:15px;-ms-flex:0 0 100%;flex:0 0 100%;max-width:100%;" >
            <div style="box-sizing:border-box;text-align:center;" >
                <p style="font-size:2rem;margin-bottom:0; text-align:center;">North East Medical College</p>
                <h6 style="box-sizing:border-box;font-size:1rem;margin-bottom:.5rem;line-height:1.2;margin-top:0;font-weight:bold;" >Session: {{$session}}</h6>
            </div>
        </div>
        <br/>
        <div class="row">
            <div class="col-md-12">
                <h4 class="text-center">Teacher Wise Class (Assign)</h4>
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead>
                        <tr>
                            <th scope="col">SL</th>
                            <th scope="col">Teacher Name</th>
                            <th scope="col">Total Class</th>
                            <th scope="col">Taken Class</th>
                        </tr>
                        </thead>
                        <tbody>
                        @if(!empty($assign))
                            @php $sl=1; @endphp
                            @foreach($assign as $key=>$value)
                                <tr>
                                    <td rowspan="2">{{$sl}}</td>
                                    <td rowspan="2">
                                        @php
                                            $teacher_id=$key;
                                            $teachers=getTeacherNameByTeacherId($teacher_id);
                                            $first_name=!empty($teachers->first_name) ? $teachers->first_name :' ';
                                            $last_name=!empty($teachers->last_name) ? $teachers->last_name :' ';
                                            $full_name=$first_name.' '.$last_name
                                        @endphp
                                        {{!empty($full_name) ? $full_name :'---'}}
                                    </td>
                                    <td rowspan="2">{{$value}}</td>
                                    <td rowspan="2">
                                        {{getTotalClass($teacher_id,$sessionId,$phaseId,$termId,$subjectId,$classTypeId,false,$fromDate,$toDate,$courseId)}}
                                    </td>
                                <tr/>
                                @php $sl++; @endphp
                            @endforeach
                        @else
                            <tr>
                                <td>-</td>
                                <td>-</td>
                                <td>-</td>
                                <td>-</td>
                            </tr>
                        @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>
