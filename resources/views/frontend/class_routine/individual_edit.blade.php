@extends('frontend.layouts.default')
@section('pageTitle', $pageTitle)

@section('content')
<?php
$oldSession = isset($classRoutine->session) ? $classRoutine->session->filter(function ($item){
    return $item->pivot->batch_type_id == 2;
})->first() : [];
$dayName = getDayName($min_max_date->min_date);
?>
    <div class="m-portlet m-portlet--tab">
        <div class="m-portlet__head">
            <div class="m-portlet__head-caption">
                <div class="m-portlet__head-title">
                    <h3 class="m-portlet__head-text"><i class="far fa-plus-square pr-2"></i>Edit Class Routine Schedule</h3>
                </div>
            </div>
            <div class="m-portlet__head-tools">
                    <a href="{{ url('class_routine.index') }}" class="btn btn-primary m-btn m-btn--icon"><i class="fa fa-clock pr-2"></i>Class Routine</a>
            </div>
        </div>

        <!--begin::Form-->
        <form class="m-form m-form--fit m-form--label-align-right"  action="{{ route('class_routine.update.single', [$classRoutine->id]) }}" method="post" id="nemc-general-form">
            @csrf
            @method('PUT')
            <div class="m-portlet__body">
                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                        <div class="form-group  m-form__group {{ $errors->has('session_id') ? 'has-danger' : '' }}">
                            <label class="form-control-label"><span class="text-danger">*</span> Session </label>
                            <select class="form-control m-input" name="session_id" id="session_id">
                                <option value="">---- Select ----</option>
                                {!! select($sessions, $classRoutine->session_id) !!}
                            </select>
                            @if ($errors->has('session_id'))
                                <div class="form-control-feedback">{{ $errors->first('session_id') }}</div>
                            @endif
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                        <div class="form-group  m-form__group {{ $errors->has('course_id') ? 'has-danger' : '' }}">
                            <label class="form-control-label"><span class="text-danger">*</span> Course </label>
                            <select class="form-control m-input" name="course_id" id="course_id">
                                <option value="">---- Select ----</option>
                                {!! select($courses, $phaseDetail->sessionDetail->course_id) !!}
                            </select>
                            @if ($errors->has('course_id'))
                                <div class="form-control-feedback">{{ $errors->first('course_id') }}</div>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                        <div class="form-group  m-form__group {{ $errors->has('phase_id') ? 'has-danger' : '' }}">
                            <label class="form-control-label"><span class="text-danger">*</span> Phase </label>
                            <select class="form-control m-input" name="phase_id" id="phase_id">
                                <option value="">---- Select ----</option>
                            </select>
                            @if ($errors->has('phase_id'))
                                <div class="form-control-feedback">{{ $errors->first('phase_id') }}</div>
                            @endif
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                        <div class="form-group  m-form__group {{ $errors->has('term_id') ? 'has-danger' : '' }}">
                            <label class="form-control-label"><span class="text-danger">*</span> Term </label>
                            <select class="form-control m-input" name="term_id" id="term_id">
                                <option value="">---- Select ----</option>
                            </select>
                            @if ($errors->has('term_id'))
                                <div class="form-control-feedback">{{ $errors->first('term_id') }}</div>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                        <div class="form-group  m-form__group {{ $errors->has('subject_id') ? 'has-danger' : '' }}">
                            <label class="form-control-label"><span class="text-danger">*</span> Subject </label>
                            <select class="form-control m-input" name="subject_id" id="subject_id">
                                <option value="">---- Select ----</option>
                            </select>
                            @if ($errors->has('subject_id'))
                                <div class="form-control-feedback">{{ $errors->first('subject_id') }}</div>
                            @endif
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                        <div class="form-group  m-form__group {{ $errors->has('teacher_id') ? 'has-danger' : '' }}">
                            <label class="form-control-label"><span class="text-danger">*</span> Teacher </label>
                            <select class="form-control m-input" name="teacher_id" id="teacher_id">
                                <option value="">---- Select ----</option>
                            </select>
                            @if ($errors->has('teacher_id'))
                                <div class="form-control-feedback">{{ $errors->first('teacher_id') }}</div>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                        <div class="form-group  m-form__group {{ $errors->has('class_type_id') ? 'has-danger' : '' }}">
                            <label class="form-control-label"><span class="text-danger">*</span> Class Type </label>
                            <select class="form-control m-input" name="class_type_id" id="class_type_id">
                                <option value="">---- Select ----</option>
                                {!! select($classTypes, $classRoutine->class_type_id) !!}
                            </select>
                            @if ($errors->has('class_type_id'))
                                <div class="form-control-feedback">{{ $errors->first('class_type_id') }}</div>
                            @endif
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                        <div class="form-group  m-form__group {{ $errors->has('batch_type_id') ? 'has-danger' : '' }}">
                            <label class="form-control-label"><span class="text-danger">*</span> Batch Type </label>
                            <select class="form-control m-input" name="batch_type_id" id="batch_type_id">
                                <option value="">---- Select ----</option>
                                {!! select($batchTypes, $classRoutine->batch_type_id) !!}
                            </select>
                            @if ($errors->has('batch_type_id'))
                                <div class="form-control-feedback">{{ $errors->first('batch_type_id') }}</div>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                        <div class="form-group  m-form__group {{ $errors->has('class_date') ? 'has-danger' : '' }}">
                            <label class="form-control-label"><span class="text-danger">*</span> Start Date </label>
                            <input type="text" class="form-control m-input m_datepicker" name="class_date" id="class_date" value="{{$classRoutine->class_date}}" placeholder="Start Date" autocomplete="off"/>
                            @if ($errors->has('class_date'))
                                <div class="form-control-feedback">{{ $errors->first('class_date') }}</div>
                            @endif
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                        <div class="form-group  m-form__group {{ $errors->has('hall_id') ? 'has-danger' : '' }}">
                            <label class="form-control-label"><span class="text-danger">*</span> Class Room </label>
                            <select class="form-control m-input" name="hall_id" id="hall_id">
                                <option value="">---- Select ----</option>
                                {!! select($classRooms, $classRoutine->hall_id) !!}
                            </select>
                            @if ($errors->has('hall_id'))
                                <div class="form-control-feedback">{{ $errors->first('hall_id') }}</div>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                        <div class="form-group  m-form__group {{ $errors->has('start_time') ? 'has-danger' : '' }}">
                            <label class="form-control-label"><span class="text-danger">*</span> Start Time </label>
                            <input type="text" class="form-control m-input m_datetimepicker" name="start_time" id="start_time" value="{{date('Y-m-d').' '.parseClassTime($classRoutine->start_from)}}" data-date-format="hh:ii" placeholder="Start Time" autocomplete="off" readonly/>
                            @if ($errors->has('start_time'))
                                <div class="form-control-feedback">{{ $errors->first('start_time') }}</div>
                            @endif
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                        <div class="form-group  m-form__group {{ $errors->has('end_time') ? 'has-danger' : '' }}">
                            <label class="form-control-label"><span class="text-danger">*</span> End Time </label>
                            <input type="text" class="form-control m-input m_datetimepicker" name="end_time" value="{{date('Y-m-d').' '.parseClassTime($classRoutine->end_at)}}" id="end_time" placeholder="End Time" autocomplete="off" readonly/>
                            @if ($errors->has('end_time'))
                                <div class="form-control-feedback">{{ $errors->first('end_time') }}</div>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="row">

                    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                        <div class="form-group  m-form__group {{ $errors->has('days') ? 'has-danger' : '' }}">
                            <label class="form-control-label">Have Old Students? </label>
                            <div class="m-checkbox-inline">
                                <label class="m-checkbox">
                                    <input type="checkbox" name="is_old_studnets" class="is_old_students" value="1" {{!empty($oldSession) ? 'checked' : ''}}> Yes
                                    <span></span>
                                </label>
                            </div>
                            @if ($errors->has('days'))
                                <div class="form-control-feedback">{{ $errors->first('days') }}</div>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
                        <div class="form-group  m-form__group {{ $errors->has('days') ? 'has-danger' : '' }}">
                            <label class="form-control-label"><span class="text-danger">*</span> Days </label>
                            <div class="m-checkbox-inline">
                                @foreach($classDays as $key => $day)
                                    <?php $selected = ($dayName == $day) ? 'checked' : ''; ?>
                                    <label class="m-checkbox">
                                        <input type="checkbox" name="days[]" class="days" value="{{$key}}" {{$selected}}> {{$day}}
                                        <span></span>
                                    </label>
                                @endforeach
                            </div>
                            @if ($errors->has('days'))
                                <div class="form-control-feedback">{{ $errors->first('days') }}</div>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6 group-row {{empty($classRoutine->student_group_id) ? 'm--hide' : ''}}">
                        <div class="form-group  m-form__group {{ $errors->has('student_group_id') ? 'has-danger' : '' }}">
                            <label class="form-control-label"><span class="text-danger">*</span> Student Group </label>
                            <select class="form-control m-input" name="student_group_id" id="student_group_id">
                                <option value="">---- Select ----</option>
                            </select>
                            @if ($errors->has('student_group_id'))
                                <div class="form-control-feedback">{{ $errors->first('student_group_id') }}</div>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6 old-std-row {{empty($oldSession) ? 'm--hide' : ''}}">
                        <div class="form-group  m-form__group {{ $errors->has('old_student_session') ? 'has-danger' : '' }}">
                            <label class="form-control-label"><span class="text-danger">*</span> Session </label>
                            <select class="form-control m-input" name="old_student_session" id="old_student_session">
                                <option value="">---- Select ----</option>
                                {!! select($sessions, (isset($oldSession) ? $oldSession->id : '') ) !!}
                            </select>
                            @if ($errors->has('old_student_session'))
                                <div class="form-control-feedback">{{ $errors->first('old_students') }}</div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>


            <div class="m-portlet__foot m-portlet__foot--fit" style="margin-left: 6px;" >
                <div class="m-form__actions text-center">
                    <a href="{{ route('student_group.index') }}" class="btn btn-outline-brand"><i class="fa fa-times"></i> Cancel</a>
                    <button type="submit" class="btn btn-success"><i class="fa fa-save"></i> Save</button>
                </div>
            </div>
        </form>

        <!--end::Form-->
    </div>
@endsection

@push('scripts')

    <script src="//cdnjs.cloudflare.com/ajax/libs/lodash.js/4.17.11/lodash.min.js" type="text/javascript"></script>

    <script>

        var baseUrl = '{!! url('/') !!}/';
        var phaseInfo = [];

        var sessionId = '{{$classRoutine->session_id}}';
        var courseId = '{{$phaseDetail->sessionDetail->course_id}}';
        var phaseId = '{{$classRoutine->phase_id}}';
        var termId = '{{$classRoutine->term_id}}';
        var routineSubjectId = '{{$classRoutine->subject_id}}';
        var teacherId = '{{$classRoutine->teacher_id}}';

        $(".m_datepicker").datepicker( {
            todayHighlight: !0,
            orientation: "bottom left",
            format: 'yyyy-mm-dd',
            autoClose: true,
        });

        $(".m_datetimepicker").datetimepicker( {
            format: "hh:ii",
            showMeridian: !0,
            todayHighlight: !0,
            autoclose: !0,
            startView: 1,
            minView: 0,
            maxView: 1,
            forceParse: 0,
        });

        splitStartTime = $('#start_time').val().split(' ');
        $('#start_time').val(splitStartTime[1]);
        splitEndTime = $('#end_time').val().split(' ');
        $('#end_time').val(splitEndTime[1]);

        function getPhases(sessionId, courseId){
            if (sessionId != '' && courseId != ''){
                $.get('{{route('phase.term.list')}}', {sessionId: sessionId, courseId: courseId}, function (response) {
                    if (response.data){
                        $('#phase_id').html('<option value="">---- Select ----</option>');
                        phaseInfo = response.data;
                        for (i in phaseInfo){
                            phaseSelected = (phaseId == phaseInfo[i].phase.id) ? 'selected' : '';
                            $('#phase_id').append('<option value="'+phaseInfo[i].phase.id+'" '+phaseSelected+'>'+phaseInfo[i].phase.title+'</option>')
                        }

                    }
                });
            }
        }

        $('#course_id, #session_id').change(function () {
            courseId = $('#course_id').val();
            sessionId = $('#session_id').val();
            getPhases(sessionId, courseId);
        });

        $('#phase_id').change(function () {
            phaseId = $(this).val();
            courseId = $('#course_id').val();
            sessionId = $('#session_id').val();

            selectedPhase = _.find(phaseInfo, function(o) { return o.phase.id  == phaseId; });
            $('#term_id').html('<option value="">---- Select ----</option>');
            for (var i = 1; i <= selectedPhase.total_terms; i++){
                selected = (termId == i) ? 'selected' : '';
                $('#term_id').append('<option value="'+i+'" '+selected+'> Term '+i+'</option>')
            }

            // load subjects
            $.get('{{route('subjects.session.course.phase')}}', {sessionId: sessionId, courseId: courseId, phaseId: phaseId}, function (response) {
                if (response.data){
                    $('#subject_id').html('<option value="">---- Select ----</option>');
                    for (i in response.data){
                        subject = response.data[i];
                        selectedSubject = (routineSubjectId == subject.id) ? 'selected' : '';
                        $('#subject_id').append('<option value="'+subject.id+'" '+selectedSubject+'>'+subject.title+'</option>')
                    }

                }
            })
        });

        $('#subject_id').change(function(e){
            e.preventDefault();

            subjectId = $(this).val();

            $.get('{{route('teacher.list.subject')}}', {subjectId: subjectId}, function(response){
                $("#teacher_id").html('<option value="">--Select--</option>');
                if (response.data.length > 0){
                    for (i in response.data){
                        item = response.data[i];
                        selected = (teacherId == item.id) ? 'selected' : '';
                        $("#teacher_id").append('<option value="' + item.id + '" '+selected+'>' + item.full_name + '</option>');
                    }
                }
            });

        });

        $('#class_type_id').change(function (e) {
            if ($(this).val() > 1){
                $('.group-row').removeClass('m--hide');
            }else{
                $('.group-row').addClass('m--hide');
            }
        });

        $('.is_old_students').click(function () {
            $('.old-std-row').toggleClass('m--hide');
        });


        if (sessionId > 0 && courseId > 0){
            getPhases(sessionId, courseId);

            setTimeout(function(){
                $('#phase_id').trigger('change');
            }, 300);

            setTimeout(function(){
                $('#subject_id').trigger('change');
            }, 1000);
        }


        $('#nemc-general-form').validate({
            rules:{
                session_id: {
                    required: true,
                    min: 1,
                    remote: {
                        url: "{{route('class_routine.schedule.check')}}",
                        type: "post",
                        data: {
                            session_id: function() {
                                return $( "#session_id" ).val();
                            },
                            phase_id: function() {
                                return $( "#phase_id" ).val();
                            },
                            class_type_id: function() {
                                return $( "#class_type_id" ).val();
                            },
                            subject_id: function() {
                                return $( "#subject_id" ).val();
                            },
                            class_date: function() {
                                return $( "#class_date" ).val();
                            },
                            start_time: function() {
                                return $( "#start_time" ).val();
                            },
                            end_time: function() {
                                return $( "#end_time" ).val();
                            },
                            days: function() {
                                var days = [];
                                $.each($(".days:checked"), function(){
                                    days.push($(this).val());
                                });
                                return days;
                            },
                            onEvent: 'edit',
                            id: '{{$classRoutine->id}}',
                            _token: "{{ csrf_token() }}",
                        }
                    }
                },
                course_id: {
                    required: true,
                    min: 1
                },
                phase_id: {
                    required: true,
                    min: 1
                },
                term_id: {
                    required: true,
                    min: 1
                },
                subject_id: {
                    required: true,
                    min: 1
                },
                teacher_id: {
                    required: true,
                    min: 1
                },
                class_type_id: {
                    required: true,
                    min: 1
                },
                batch_type_id: {
                    required: true,
                    min: 1
                },
                class_date: {
                    required: true,
                },
                start_time: {
                    required: true,
                },
                end_time: {
                    required: true,
                },
                hall_id: {
                    required: true,
                },
                'days[]': {
                    required: true,
                    min: 1,
                    remote: {
                        url: "{{route('class_routine.schedule.check')}}",
                        type: "post",
                        data: {
                            session_id: function() {
                                return $( "#session_id" ).val();
                            },
                            phase_id: function() {
                                return $( "#phase_id" ).val();
                            },
                            class_type_id: function() {
                                return $( "#class_type_id" ).val();
                            },
                            subject_id: function() {
                                return $( "#subject_id" ).val();
                            },
                            class_date: function() {
                                return $( "#class_date" ).val();
                            },
                            start_time: function() {
                                return $( "#start_time" ).val();
                            },
                            end_time: function() {
                                return $( "#end_time" ).val();
                            },
                            days: function() {
                                var days = [];
                                $.each($(".days:checked"), function(){
                                    days.push($(this).val());
                                });
                                return days;
                            },
                            onEvent: 'edit',
                            id: '{{$classRoutine->id}}',
                            _token: "{{ csrf_token() }}",
                        }
                    }
                },
                student_group_id:{
                    required: function(element){
                        return $("#class_type_id").val() > 1;
                    }
                },
                old_students:{
                    required: function(element){
                        return $(".is_old_studnets").is(':checked');
                    }
                }
            },
            messages: {
                session_id:{
                    remote_check_1: 'AAAA',
                    remote: 'Class routine already configured in this day & time'
                },
                'days[]': {
                    remote: 'Class routine already configured in this day & time'
                }
            }
        });

    </script>
@endpush

