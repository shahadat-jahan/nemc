@extends('frontend.layouts.default')
@section('pageTitle', $pageTitle)
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
    <div class="row">
        <div class="col-md-12">
            <div class="m-portlet">
                <div class="m-portlet__head">
                    <div class="m-portlet__head-caption">
                        <div class="m-portlet__head-title">
                            <h3 class="m-portlet__head-text"><i class="fas fa-list-ul fa-md pr-2"></i>{{$pageTitle}}</h3>
                        </div>
                    </div>
                    {{--<div class="m-portlet__head-tools">
                        <a href="{{ route('class_routine.print') }}" class="btn btn-primary m-btn m-btn--icon"><i class="fa fa-plus pr-2"></i>Print</a>
                    </div>--}}
                </div>

                <div class="m-portlet__body">
                    <form id="searchForm" role="form" method="get">
                        <div class="form-body">
                            <div class="row">
                                <div class="col-xs-12 col-sm-6 col-md-5 col-lg-5 col-xl-5">
                                    <div class="form-group">
                                        <select class="form-control m-bootstrap-select m_selectpicker" name="session_id[]" id="session_id" multiple>
                                            <option value="">---- Select Session ----</option>
                                            {!! select($sessions, app()->request->session_id) !!}
                                        </select>
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-6 col-md-5 col-lg-5 col-xl-5">
                                    <div class="form-group">
                                        <select class="form-control" name="course_id" id="course_id">
                                            <option value="">---- Select Course ----</option>
                                            {!! select($courses, $courseId) !!}
                                        </select>
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-6 col-md-2 col-lg-2 col-xl-2">
                                    <div class="pull-right search-action-btn">
                                        <button class="btn btn-primary m-btn m-btn--icon"><i class="fa fa-search"></i> Search</button>
                                        {{--<button type="reset" class="btn btn-default reset"><i class="fas fa-sync-alt search-reset"></i> Reset</button>--}}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                    <br>
                    <div class="m-section__content">
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
                                                    @if(!empty($allClasses->filter(function ($item) use($cday, $ctime, $classSession, $courseId){
                                                        if ( ($item->session_id == $classSession->id) && ($item->course_id == $courseId) && ($item->day_name == $cday) && ($item->class_time == $ctime->class_time) ){
                                                            return $item;
                                                        }
                                                    })->first()))
                                                    <?php
                                                        $year = $classSession->start_year - date('Y') + 1;
                                                    ?>
                                            <tr>
                                                <td rowspan="{{count($allSessions)}}">{{$cday}}</td>
                                                <td>{{ordinalNumber($year)}}</td>
                                                    @foreach($allTimes as $ctime)
                                                <td>
                                                    <?php
                                                    $classSchedules = $allClasses->filter(function ($item) use($cday, $ctime, $classSession, $courseId){
                                                        if ( ($item->session_id == $classSession->id) && ($item->course_id == $courseId) && ($item->day_name == $cday) && ($item->class_time == $ctime->class_time) ){
                                                            return $item;
                                                        }
                                                    });
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
                                                </td>
                                                    @endforeach
                                            </tr>
                                                    @endif
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
            </div>
        </div>
    </div>

@endsection