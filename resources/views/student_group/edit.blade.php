@extends('layouts.default')
@section('pageTitle', $pageTitle)

@section('content')

    <div class="m-portlet m-portlet--tab">
        <div class="m-portlet__head">
            <div class="m-portlet__head-caption">
                <div class="m-portlet__head-title">
                    <h3 class="m-portlet__head-text"><i class="far fa-plus-square pr-2"></i>Edit Student Group</h3>
                </div>
            </div>
            <div class="m-portlet__head-tools">
                <a href="{{ route('student_group.index') }}" class="btn btn-primary m-btn m-btn--icon"><i
                        class="fas fa-user-graduate pr-2"></i>Student Groups</a>
            </div>
        </div>

        <!--begin::Form-->
        <form class="m-form m-form--fit m-form--label-align-right"
              action="{{ route('student_group.update', [$studentGroup->id]) }}" method="post" id="nemc-general-form">
            @csrf
            @method('PUT')
            <div class="m-portlet__body">
                <div class="row">

                    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                        <div class="form-group  m-form__group {{ $errors->has('session_id') ? 'has-danger' : '' }}">
                            <label class="form-control-label"><span class="text-danger">*</span> Session </label>
                            <select class="form-control m-input" name="session_id" id="session_id">
                                <option value="">---- Select Session----</option>
                                {!! select($sessions, $studentGroup->session_id) !!}
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
                                <option value="">---- Select Course----</option>
                                {!! select($courses, $studentGroup->course_id) !!}
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
                                <option value="">---- Select Phase----</option>
                                {!! select($phases, $studentGroup->phase_id) !!}
                            </select>
                            @if ($errors->has('phase_id'))
                                <div class="form-control-feedback">{{ $errors->first('phase_id') }}</div>
                            @endif
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                        <div class="form-group  m-form__group {{ $errors->has('department_id') ? 'has-danger' : '' }}">
                            <label class="form-control-label"><span class="text-danger">*</span> Department </label>
                            <select class="form-control department m-bootstrap-select m_selectpicker" name="department_id"
                                    id="department_id" data-live-search="true">
                                <option value="">---- Select Department ----</option>
                                @foreach($departments as $department)
                                    <option value="{{$department->id}}" {{ $studentGroup->department_id == $department->id ? 'selected' : '' }}>{{$department->title}}</option>
                                @endforeach
                            </select>
                            @if ($errors->has('department_id'))
                                <div class="form-control-feedback">{{ $errors->first('department_id') }}</div>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                        <div class="form-group  m-form__group {{ $errors->has('title') ? 'has-danger' : '' }}">
                            <label class="form-control-label"><span class="text-danger">*</span> Group name </label>
                            <input type="text" class="form-control m-input item-title" name="title"
                                   value="{{$studentGroup->group_name}}" placeholder="Group name"/>
                            @if ($errors->has('title'))
                                <div class="form-control-feedback">{{ $errors->first('title') }}</div>
                            @endif
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                        <div class="form-group  m-form__group {{ $errors->has('type') ? 'has-danger' : '' }}">
                            <label class="form-control-label"><span class="text-danger">*</span> Group Type </label>
                            <select class="form-control m-input" name="type" id="type">
                                <option value="">---- Select Group Type----</option>
                                {!! select($groupTypes, $studentGroup->type) !!}
                            </select>
                            @if ($errors->has('type'))
                                <div class="form-control-feedback">{{ $errors->first('type') }}</div>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                        <div class="form-group  m-form__group {{ $errors->has('roll_range') ? 'has-danger' : '' }}">
                            <label class="form-control-label">Roll range </label>
                            <div class="m-checkbox-inline">
                                <label class="m-checkbox">
                                    <input type="checkbox" name="roll_range" id="roll_range" value="1"> Yes
                                    <span></span>
                                </label>
                            </div>
                            @if ($errors->has('roll_range'))
                                <div class="form-control-feedback">{{ $errors->first('roll_range') }}</div>
                            @endif
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                        <div
                            class="form-group  m-form__group {{ $errors->has('is_old_students') ? 'has-danger' : '' }}">
                            <label class="form-control-label">Old Students? </label>
                            <div class="m-checkbox-inline">
                                <label class="m-checkbox old_students">
                                    <input type="checkbox" id="is_old_students" name="is_old_students" class="is_old_students"
                                           value="1" {{($studentGroup->old_student == 1) ? 'checked' : ''}}> Yes
                                    <span></span>
                                </label>
                            </div>
                            @if ($errors->has('is_old_students'))
                                <div class="form-control-feedback">{{ $errors->first('is_old_students') }}</div>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="row roll_range m--hide">
                    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                        <div class="form-group  m-form__group {{ $errors->has('roll_from') ? 'has-danger' : '' }}">
                            <label class="form-control-label"><span class="text-danger">*</span> Roll no (From) </label>
                            <input type="number" value="{{$studentGroup->roll_start}}"
                                   class="form-control m-input item-title roll_from"
                                   name="roll_from"
                                   id="roll_from" placeholder="Roll no (From)"/>
                            @if ($errors->has('roll_from'))
                                <div class="form-control-feedback">{{ $errors->first('roll_from') }}</div>
                            @endif
                            <small id="roll-from-message" class="form-text text-muted">"Roll no (From)" should be
                                greater than last given "Roll no (To)"</small>
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                        <div class="form-group  m-form__group {{ $errors->has('roll_to') ? 'has-danger' : '' }}">
                            <label class="form-control-label"><span class="text-danger">*</span> Roll no (To) </label>
                            <input type="number" value="{{$studentGroup->roll_end}}"
                                   class="form-control m-input roll_to"
                                   name="roll_to"
                                   placeholder="Roll no (To)"/>
                            @if ($errors->has('roll_to'))
                                <div class="form-control-feedback">{{ $errors->first('roll_to') }}</div>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="roll col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                        <div class="form-group m-form__group {{ $errors->has('rolls') ? 'has-danger' : '' }}">
                            <label class="form-control-label"><span class="text-danger">*</span> Rolls</label>
                            <select class="form-control rolls m-bootstrap-select m_selectpicker" id="roll" name="rolls[]"
                                    data-live-search="true" multiple>
                                @foreach($students as $roll)
                                    <option value="{{$roll}}" {{in_array($roll, $studentRoll) ? 'selected' : ''}}>{{$roll}}</option>
                                @endforeach
                            </select>
                            @if ($errors->has('rolls'))
                                <div class="form-control-feedback">{{ $errors->first('rolls') }}</div>
                            @endif
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                        <div class="form-group  m-form__group">
                            <label class="form-control-label">Status</label>
                            <select class="form-control m-input " name="status">
                                <option value="1" {{ $studentGroup->status == 1  ? 'selected' : '' }}>Active</option>
                                <option value="0" {{ $studentGroup->status == 0  ? 'selected' : '' }}>Inactive</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
            <div class="m-portlet__foot m-portlet__foot--fit" style="margin-left: 6px;">
                <div class="m-form__actions text-center">
                    <a href="{{ route('student_group.index') }}" class="btn btn-outline-brand"><i
                            class="fa fa-times"></i> Cancel</a>
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

        $('#session_id, #course_id, #phase_id').change(function () {
            $('#roll').empty();
            let oldStudents;
            sessionId = $('#session_id').val();
            courseId = $('#course_id').val();
            phaseId = $('#phase_id').val();
            if ($('#is_old_students').is(':checked')) {
                oldStudents = 1;
            }
            if (sessionId > 0 && courseId > 0 && phaseId > 0) {
                mApp.blockPage({
                    overlayColor: "#000000",
                    type: "loader",
                    state: "primary",
                    message: "Please wait..."
                });

                $.get('{{route('departments.list.session.course.phase')}}', {
                    sessionId: sessionId, courseId: courseId, phaseId: phaseId,
                }, function (response){
                    $('#department_id').html('<option value="">---- Select Department ----</option>');
                    if (response.departments){
                        console.log(response.departments)
                        for (i in response.departments) {
                            department = response.departments[i];
                            console.log(department)
                            $('#department_id').append('<option value="' + department.id + '">' + department.title + '</option>')
                        }
                        $('.m_selectpicker').selectpicker('refresh');
                    }
                });

                $.get('{{route('students.list.session.course.phase.term')}}', {
                    sessionId: sessionId, courseId: courseId, phaseId: phaseId, termId: null, oldStudents: oldStudents //This termId for this route but not effective for this query
                }, function (response) {
                    if (response.students) {
                        // $('#roll').html('<option value="">-- Select Roll--</option>');
                        for (i in response.students) {
                            student = response.students[i];
                            $('#roll').append('<option value="' + student.roll_no + '">' + student.full_name_en + ' - (' + student.roll_no + ')</option>')
                        }
                    }
                    $('.m_selectpicker').selectpicker('refresh');
                });
                mApp.unblockPage()
            }
        });

        $('#is_old_students').change(function () {
            $('#roll').empty();
            sessionId = $('#session_id').val();
            courseId = $('#course_id').val();
            phaseId = $('#phase_id').val();
            if (sessionId > 0 && courseId > 0 && phaseId > 0) {
                mApp.blockPage({
                    overlayColor: "#000000",
                    type: "loader",
                    state: "primary",
                    message: "Please wait..."
                });
                if ($('#is_old_students').is(':checked')) {
                    $.get('{{route('students.list.session.course.phase.term')}}', {
                        sessionId: sessionId, courseId: courseId, phaseId: phaseId, termId: null, oldStudents: 1 //This termId for this route but not effective for this query
                    }, function (response) {
                        if (response.students) {
                            // $('#roll').html('<option value="">-- Select Roll--</option>');
                            for (i in response.students) {
                                student = response.students[i];
                                $('#roll').append('<option value="' + student.roll_no + '">' + student.full_name_en + ' - (' + student.roll_no + ')</option>')
                            }
                        }
                        $('.m_selectpicker').selectpicker('refresh');
                        mApp.unblockPage()
                    });
                } else {
                    $.get('{{route('students.list.session.course.phase.term')}}', {
                        sessionId: sessionId, courseId: courseId, phaseId: phaseId, termId: null, //This termId for this route but not effective for this query
                    }, function (response) {
                        if (response.students) {
                            // $('#roll').html('<option value="">-- Select Roll--</option>');
                            for (i in response.students) {
                                student = response.students[i];
                                $('#roll').append('<option value="' + student.roll_no + '">' + student.full_name_en + ' - (' + student.roll_no + ')</option>')
                            }
                        }
                        $('.m_selectpicker').selectpicker('refresh');
                        mApp.unblockPage()
                    });
                }
            }
        });

        $('#roll_range').change(function () {
            if ($('#roll_range').is(':checked')) {
                $('.roll_range').toggleClass('m--hide');
                $('.roll').toggleClass('m--hide');
            } else {
                $('.roll_range').toggleClass('m--hide');
                $('.roll').toggleClass('m--hide');
            }
        });

        $.validator.setDefaults({
            /*OBSERVATION: note how the ignore option is placed in here*/
            // ignore: ':not(select:hidden, input:visible, textarea:visible)',
            errorPlacement: function (error, element) {
                if (element.hasClass('department', 'm-bootstrap-select')) {
                    error.insertAfter('.department.m-bootstrap-select.m_');
                } else if (element.hasClass('rolls', 'm-bootstrap-select')) {
                    error.insertAfter('.rolls.m-bootstrap-select.m_');
                } else if (element.hasClass('is_old_students')) {
                    error.insertAfter('.old_students');
                } else {
                    error.insertAfter(element);
                }
                /*Add other (if...else...) conditions depending on your
                * validation styling requirements*/
            }
        });

        $('#nemc-general-form').validate({
            rules: {
                session_id: {
                    required: true,
                    min: 1
                },
                phase_id: {
                    required: true,
                    min: 1
                },
                course_id: {
                    required: true,
                    min: 1
                },
                department_id: {
                    required: true,
                },
                'title': {
                    required: true,
                },
                'type': {
                    required: true,
                },
                'roll_from': {
                    required: function (element) {
                        return $('#roll_range').is(':checked');
                    }
                },
                'roll_to': {
                    required: function (element) {
                        return $('#roll_range').is(':checked');
                    }
                },
                'rolls[]': {
                    required: function (element) {
                        return !$('#roll_range').is(':checked');
                    }
                }
            },
            messages: {
                roll_from: {
                    required: 'This field is required when Roll range is checked'
                },
                roll_to: {
                    required: 'This field is required when Roll range is checked'
                },
                'rolls[]': {
                    required: 'This field is required when Roll range is unchecked'
                }
            }
        });

    </script>
@endpush

