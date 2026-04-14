@extends('layouts.print')
@push('style')
    <link href="{{asset('assets/global/css/style.bundle.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{asset('css/custom.css')}}" rel="stylesheet" type="text/css" />
    <link href="https://fonts.googleapis.com/css?family=Pinyon+Script" rel="stylesheet">
    <script src="https://ajax.googleapis.com/ajax/libs/webfont/1.6.16/webfont.js"></script>
    <script>
        WebFont.load({
            google: {"families":["Poppins:300,400,500,600,700","Roboto:300,400,500,600,700"]},
            active: function() {
                sessionStorage.fonts = true;
            }
        });
    </script>

    <style type="text/css" media="print">
        @page {
            size: A4 portrait;
        }
    </style>
@endpush
<?php
$allSessions = [];
if (!empty(app()->request->session_id)){
    foreach (app()->request->session_id as $x => $session){
        $allSessions[$x] = collect($sessionData)->filter(function ($item) use($session){
            return ($item->id == $session);
        })->first();
    }
}else{
    app()->request->session_id = 1;
}
$allSessions = empty($allSessions) ? [$sessionData[0]] : $allSessions;
$courseId = !empty(app()->request->course_id) ? app()->request->course_id : 1;
?>
@section('content')
<div class="m-portlet__body">
    <div class="m-section__content m-5">
        <div class="row">
            <div class="col-md-12">
                <div class="">
                    <div class="table m-table table-responsive">
                        <table class="table table-bordered table-hover" id="dataTable">
                            <thead>
                            <tr>
                                <th class="uppercase" rowspan="2">Days</th>
                                <th class="uppercase" rowspan="2">Year</th>
                                <th class="uppercase text-center" colspan="{{count($allTimes)}}">Time</th>
                            </tr>
                            <tr>
                                @foreach($allTimes as $ctime)
                                <th class="uppercase">{{$ctime->class_time}}</th>
                                    @endforeach
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($classDays as $cday)
                                @foreach($allSessions as $classSession)
                                    <?php
                                    $year = $classSession->start_year - date('Y') + 1;
                                    ?>
                            <tr>
                                <td rowspan="{{count($allSessions)}}">{{$cday}}</td>
                                <td>{{ordinalNumber($year)}}</td>
                                @foreach($allTimes as $ctime)
                                    <td>
                                    @if(!empty($allClasses->where('session_id', $classSession->id)->where('course_id', $courseId)->where('day_name', $cday)->where('class_time', $ctime->class_time)->toArray()))
                                        <?php
                                        $classSchedules = $allClasses->where('session_id', $classSession->id)->where('course_id', $courseId)->where('day_name', $cday)->where('class_time', $ctime->class_time);
                                        ?>
                                        @foreach($classSchedules as $classSchedule)
                                            <div>
                                                <?php
                                                if ($classSchedule['class_type_id'] == 1 || $classSchedule['class_type_id'] == 9){
                                                    $classInfo= '<br>'.$classSchedule['subject']['title'];
                                                }else{
                                                    $classInfo= '<br>'.$classSchedule['subject']['title'].' '.$classSchedule['classType']['title'];
                                                }

                                                $classInfo.= isset($classSchedule['hall']) ? ' - '.$classSchedule['hall']['room_number'] : '';

                                                if ($classSchedule['class_type_id'] == 1 || $classSchedule['class_type_id'] == 9){
                                                    $classInfo.= isset($classSchedule['teacher']) ? '<br>'.$classSchedule['teacher']['full_name'] : '';
                                                }else{
                                                    if (!empty($classSchedule['studentGroup'])){
                                                        $classInfo.='<br>';
                                                        foreach ($classSchedule['studentGroup'] as $key => $group) {
                                                            $classInfo.= $group->group_name.'-'.$classSchedule['studentGroupTeacher'][$key]['full_name'].', ';
                                                        }
                                                    }
                                                }
                                                ?>

                                                {!! $classInfo !!}
                                            </div>
                                        @endforeach
                                    @endif
                                    </td>
                                @endforeach
                            </tr>
                                @endforeach
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection