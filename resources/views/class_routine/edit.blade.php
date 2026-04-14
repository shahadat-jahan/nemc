@extends('layouts.default')
@section('pageTitle', $pageTitle)

@section('content')
    <div class="m-portlet m-portlet--tab">
        <div class="m-portlet__head">
            <div class="m-portlet__head-caption">
                <div class="m-portlet__head-title">
                    <h3 class="m-portlet__head-text"><i class="far fa-plus-square pr-2"></i>Edit Class Routine Schedule</h3>
                </div>
            </div>
            <div class="m-portlet__head-tools">
                <a href="{{ route('class_routine.index') }}" class="btn btn-primary m-btn m-btn--icon"><i
                        class="fa fa-clock pr-2"></i>Class Routine</a>
            </div>
        </div>

        <!--begin::Form-->
        <form class="m-form m-form--fit m-form--label-align-right"
            action="{{ route('class_routine.update', [$classRoutine->id]) }}" method="post" id="nemc-general-form">
            @csrf
            @method('PUT')
            <div class="m-portlet__body">
                <!-- Static Routine Section -->
                <div id="static-routine-section" class="m--hide">
                    <div class="m-alert m-alert--icon m-alert--air m-alert--square alert alert-info alert-dismissible fade show"
                        role="alert">
                        <div class="m-alert__icon">
                            <i class="fa fa-calendar-alt"></i>
                        </div>
                        <div class="m-alert__text">
                            <h5>Static Routine</h5>
                            <div id="static-routine-content">

                            </div>
                        </div>
                    </div>
                </div>
                <!-- End Static Calendar Section -->

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
                                {!! select($courses, $classRoutine->course_id) !!}
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
                        <div class="form-group m-form__group {{ $errors->has('teacher_id') ? 'has-danger' : '' }}">
                            <label class="form-control-label"><span class="text-danger">*</span> Teacher </label>
                            <select class="form-control m-input teacher_id" name="teacher_id" id="teacher_id">
                                <option value="">---- Select ----</option>
                            </select>
                            {{--                            <span class="m-form__help text-primary">Required for lecture & revised classes</span> --}}
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
                            <select class="form-control m_selectpicker" data-live-search="true" name="class_type_id"
                                id="class_type_id">
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
                        <div class="form-group  m-form__group {{ $errors->has('start_date') ? 'has-danger' : '' }}">
                            <label class="form-control-label"><span class="text-danger">*</span> Start Date </label>
                            <input type="text" class="form-control m-input m_datepicker" name="start_date"
                                id="start_date" value="{{ date('d/m/Y', strtotime($min_max_date->min_date)) }}"
                                placeholder="Start Date" autocomplete="off" />
                            @if ($errors->has('start_date'))
                                <div class="form-control-feedback">{{ $errors->first('start_date') }}</div>
                            @endif
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                        <div class="form-group  m-form__group {{ $errors->has('end_date') ? 'has-danger' : '' }}">
                            <label class="form-control-label"><span class="text-danger">*</span> End Date </label>
                            <input type="text" class="form-control m-input m_datepicker" name="end_date"
                                id="end_date" value="{{ date('d/m/Y', strtotime($min_max_date->max_date)) }}"
                                placeholder="End Date" autocomplete="off" /><span class="m-form__help text-warning">The end date must not be more than 40 days after the start date.</span>
                            @if ($errors->has('end_date'))
                                <div class="form-control-feedback">{{ $errors->first('end_date') }}</div>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                        <div class="form-group  m-form__group {{ $errors->has('start_time') ? 'has-danger' : '' }}">
                            <label class="form-control-label"><span class="text-danger">*</span> Start Time </label>
                            <input type="text" class="form-control m-input m_datetimepicker" name="start_time"
                                id="start_time"
                                value="{{ date('Y-m-d') . ' ' . parseClassTime($classRoutine->start_from) }}"
                                data-date-format="hh:ii" placeholder="Start Time" autocomplete="off" readonly />
                            @if ($errors->has('start_time'))
                                <div class="form-control-feedback">{{ $errors->first('start_time') }}</div>
                            @endif
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                        <div class="form-group  m-form__group {{ $errors->has('end_time') ? 'has-danger' : '' }}">
                            <label class="form-control-label"><span class="text-danger">*</span> End Time </label>
                            <input type="text" class="form-control m-input m_datetimepicker" name="end_time"
                                value="{{ date('Y-m-d') . ' ' . parseClassTime($classRoutine->end_at) }}"
                                data-date-format="hh:ii" id="end_time" placeholder="End Time" autocomplete="off"
                                readonly />
                            @if ($errors->has('end_time'))
                                <div class="form-control-feedback">{{ $errors->first('end_time') }}</div>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                        <div class="form-group  m-form__group {{ $errors->has('hall_id') ? 'has-danger' : '' }}">
                            <label class="form-control-label"><span class="text-danger">*</span> Class Room </label>
                            <select class="form-control m-input" name="hall_id" id="hall_id">
                                <option value="">---- Select ----</option>
                                {!! select($classRooms, $classRoutine->hall_id) !!}
                            </select>
                            <span class="m-form__help text-primary">Required for lecture, revised & integrated teaching
                                classes</span>
                            @if ($errors->has('hall_id'))
                                <div class="form-control-feedback">{{ $errors->first('hall_id') }}</div>
                            @endif
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                        <div class="form-group  m-form__group {{ $errors->has('is_old_studnets') ? 'has-danger' : '' }}">
                            <label class="form-control-label">Have Old Students? </label>
                            <div class="m-checkbox-inline">
                                <label class="m-checkbox {{ $classRoutine->batch_type_id == 2 ? 'not-allowed' : '' }}">
                                    <input type="checkbox" name="is_old_studnets" class="is_old_students" value="1"
                                        id="is_old_students" {{ $classRoutine->old_students == 1 ? 'checked' : '' }}
                                        {{ $classRoutine->batch_type_id == 2 ? 'disabled' : '' }}> Yes
                                    <span></span>
                                </label>
                            </div>
                            @if ($errors->has('is_old_studnets'))
                                <div class="form-control-feedback">{{ $errors->first('is_old_studnets') }}</div>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="row mt-3 totalClassCount {{ count(groupDatesByDay($classDates)) > 0 ? '' : 'd-none' }}">
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
                        <div class="alert alert-info" role="alert">
                            <span id="total-class"></span>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
                        <div class="form-group  m-form__group {{ $errors->has('days') ? 'has-danger' : '' }}">
                            <label class="form-control-label"><span class="text-danger">*</span> Days </label>
                            <div class="m-checkbox-inline">
                                @foreach ($classDays as $key => $day)
                                    <?php
                                    $days = groupDatesByDay($classDates);
                                    $selected = in_array($day, $days) ? 'checked' : '';
                                    ?>
                                    <label class="m-checkbox">
                                        {{-- <input type="checkbox" name="days[]" class="days" value="{{$key}}" {{$selected}}> {{$day}} --}}
                                        <input type="checkbox" name="days[]" class="days" id="weekly-selected-day"
                                            value="{{ $key }}" {{ $selected }}> {{ $day }}
                                        <span></span>
                                    </label>
                                @endforeach
                            </div>
                            <span class="m-form__help text-success">During edit you have to select days. Select
                                please.</span>
                            @if ($errors->has('days'))
                                <div class="form-control-feedback">{{ $errors->first('days') }}</div>
                            @endif
                        </div>
                    </div>
                </div>
                @foreach ($classRoutine->studentGroup as $key => $group)
                    <div class="row group-row-old">
                        <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                            <div
                                class="form-group  m-form__group {{ $errors->has('student_group_id') ? 'has-danger' : '' }}">
                                <label class="form-control-label"><span class="text-danger">*</span> Student Group
                                </label>
                                <select class="form-control m-input student_group_id" name="student_group_id[]"
                                    id="student_group_id">
                                    <option value="">---- Select Group ----</option>
                                    @foreach ($studentGroups as $listGroup)
                                        <option value="{{ $listGroup->id }}"
                                            {{ $group->id == $listGroup->id ? 'selected' : '' }}>
                                            {{ $listGroup->group_name }}{{ isset($listGroup->department) ? ' - ' . $listGroup->department->title : '' }}
                                        </option>
                                    @endforeach
                                </select>
                                @if ($errors->has('student_group_id'))
                                    <div class="form-control-feedback">{{ $errors->first('student_group_id') }}</div>
                                @endif
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                            <div
                                class="form-group  m-form__group {{ $errors->has('group_teachers') ? 'has-danger' : '' }}">
                                <label class="form-control-label"><span class="text-danger">*</span> Teacher </label>
                                <select class="form-control m-input group_teachers teacher_id" name="group_teachers[]">
                                    <option value="">---- Select Teacher ----</option>
                                    @foreach ($teachersList as $listTeacher)
                                        <option value="{{ $listTeacher->id }}"
                                            {{ $classRoutine->studentGroupTeacher[$key]->id == $listTeacher->id ? 'selected' : '' }}>
                                            {{ $listTeacher->full_name }}</option>
                                    @endforeach
                                </select>
                                @if ($errors->has('group_teachers'))
                                    <div class="form-control-feedback">{{ $errors->first('group_teachers') }}</div>
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
                <div class="row group-row-main group-row m--hide">
                    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                        <div class="form-group  m-form__group {{ $errors->has('student_group_id') ? 'has-danger' : '' }}">
                            <label class="form-control-label"><span class="text-danger">*</span> Student Group </label>
                            <select class="form-control m-input student_group_id" name="student_group_id[]"
                                    id="student_group_id">
                                <option value="">---- Select Student Group ----</option>
                            </select>
                            @if ($errors->has('student_group_id'))
                                <div class="form-control-feedback">{{ $errors->first('student_group_id') }}</div>
                            @endif
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                        <div class="form-group m-form__group {{ $errors->has('group_teachers') ? 'has-danger' : '' }}">
                            <label class="form-control-label"><span class="text-danger">*</span> Teacher </label>
                            <select class="form-control m-input group_teachers teacher_id" name="group_teachers[]">
                                <option value="">---- Select Teacher ----</option>
                            </select>
                            @if ($errors->has('group_teachers'))
                                <div class="form-control-feedback">{{ $errors->first('group_teachers') }}</div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>


            <div class="m-portlet__foot m-portlet__foot--fit" style="margin-left: 6px;">
                <div class="m-form__actions text-center">
                    <a href="{{ URL::previous() }}" class="btn btn-outline-brand"><i class="fa fa-times"></i> Cancel</a>
                    <button type="submit" id="submitButton" class="btn btn-success"><i class="fa fa-save"></i> Update
                    </button>
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
        var sessionId = '{{ $classRoutine->session_id }}';
        var courseId = '{{ $phaseDetail->sessionDetail->course_id }}';
        var phaseId = '{{ $classRoutine->phase_id }}';
        var termId = '{{ $classRoutine->term_id }}';
        var routineSubjectId = '{{ $classRoutine->subject_id }}';
        var teacherId = '{{ $classRoutine->teacher_id }}';

        $(".group_teachers").css("pointer-events", "none");

        $(".m_datepicker").datepicker({
            todayHighlight: !0,
            orientation: "bottom left",
            autoclose: true,
            format: 'dd/mm/yyyy',
        });

        $(".m_datetimepicker").datetimepicker({
            format: "hh:ii",
            showMeridian: !0,
            todayHighlight: !0,
            autoclose: true,
            startView: 1,
            minView: 0,
            maxView: 1,
            forceParse: 0,
        });

        splitStartTime = $('#start_time').val().split(' ');
        $('#start_time').val(splitStartTime[1]);
        splitEndTime = $('#end_time').val().split(' ');
        $('#end_time').val(splitEndTime[1]);

        function getPhases(sessionId, courseId) {
            if (sessionId != '' && courseId != '') {
                mApp.blockPage({
                    overlayColor: "#000000",
                    type: "loader",
                    state: "primary",
                    message: "Please wait..."
                });
                $.get('{{ route('phase.term.list') }}', {
                    sessionId: sessionId,
                    courseId: courseId
                }, function(response) {
                    if (response.data) {
                        $('#phase_id').html('<option value="">---- Select ----</option>');
                        $('#term_id').html('<option value="">---- Select ----</option>');
                        $('#subject_id').html('<option value="">---- Select ----</option>');
                        $("#teacher_id").html('<option value="">---- Select ----</option>');
                        phaseInfo = response.data;
                        for (i in phaseInfo) {
                            phaseSelected = (phaseId == phaseInfo[i].phase.id) ? 'selected' : '';
                            $('#phase_id').append('<option value="' + phaseInfo[i].phase.id + '" ' + phaseSelected +
                                '>' + phaseInfo[i].phase.title + '</option>')
                        }

                    }
                    mApp.unblockPage();
                });
            }
        }

        // Check for static routine
        function checkStaticRoutineFile() {
            if (sessionId && phaseId) {
                $.get('{{ route('static_routine.get_by_phase_session') }}', {
                    session_id: sessionId,
                    phase_id: phaseId
                }, function(response) {
                    if (response.status && response.data) {
                        let routineHtml = '';
                        let routine = response.data;
                        routineHtml += '<div class="mb-3">';
                        routineHtml += '<div class="mb-2">';
                        routineHtml += '<h6>' + routine.title + '</h6>';
                        if (routine.description) {
                            routineHtml += '<p>' + routine.description + '</p>';
                        }
                        routineHtml += '<a href="/' + routine.file_path +
                            '" target="_blank" class="btn btn-sm btn-primary">';
                        routineHtml += '<i class="fa fa-download"></i> View/Download Routine';
                        routineHtml += '</a>';
                        routineHtml += '</div>';
                        routineHtml += '</div>';
                        $('#static-routine-content').html(routineHtml);
                        $('#static-routine-section').removeClass('m--hide');
                    } else {
                        $('#static-routine-content').html(
                            '<p>No static routine found for the selected phase and session.</p>');
                        $('#static-routine-section').removeClass('m--hide');
                    }
                });
            } else {
                $('#static-routine-section').addClass('m--hide');
            }
        }

        $('#course_id, #session_id').change(function() {
            courseId = $('#course_id').val();
            sessionId = $('#session_id').val();
            getPhases(sessionId, courseId);
            // Check for static routine
            checkStaticRoutineFile();
        });

        $('#phase_id').change(function() {
            phaseId = $(this).val();
            courseId = $('#course_id').val();
            sessionId = $('#session_id').val();

            mApp.blockPage({
                overlayColor: "#000000",
                type: "loader",
                state: "primary",
                message: "Please wait..."
            });

            if (phaseId > 0) {
                selectedPhase = _.find(phaseInfo, function(o) {
                    return o.phase.id == phaseId;
                });

                $('#term_id').html('<option value="">---- Select Term ----</option>');
                for (var i = 1; i <= selectedPhase.total_terms; i++) {
                    $('#term_id').append('<option value="' + i + '"> Term ' + i + '</option>')
                }
            } else {
                $('#term_id').html('<option value="">---- Select Term ----</option>');
            }
            // Check for static routine
            checkStaticRoutineFile();
            // load subjects
            $.get('{{ route('subjects.session.course.phase') }}', {
                sessionId: sessionId,
                courseId: courseId,
                phaseId: phaseId
            }, function(response) {
                if (response.data) {
                    $('#subject_id').html('<option value="">---- Select ----</option>');
                    $("#teacher_id").html('<option value="">---- Select ----</option>');
                    for (i in response.data) {
                        subject = response.data[i];
                        // selectedSubject = (routineSubjectId == subject.id) ? 'selected' : '';
                        $('#subject_id').append('<option value="' + subject.id + '" ' + selectedSubject +
                            '>' + subject.title + '</option>')
                    }

                }
                mApp.unblockPage();
            })
        });

        $('#subject_id').change(function(e) {
            e.preventDefault();

            mApp.blockPage({
                overlayColor: "#000000",
                type: "loader",
                state: "primary",
                message: "Please wait..."
            });

            subjectId = $(this).val();

            $.get('{{ route('teacher.list.subject') }}', {
                subjectId: subjectId
            }, function(response) {
                $(".teacher_id").html('<option value="">---- Select ----</option>');
                if (response.data.length > 0) {
                    for (let i in response.data) {
                        let item = response.data[i];
                        selected = (teacherId == item.id) ? 'selected' : '';
                        let option = '<option value="' + item.id + '" ' + selected + '>' + item.full_name +
                            '</option>';
                        $(".teacher_id").append(option);
                    }
                }
                mApp.unblockPage();
            });
        });

        if (routineSubjectId > 0) {
            mApp.blockPage({
                overlayColor: "#000000",
                type: "loader",
                state: "primary",
                message: "Please wait..."
            });

            $.get('{{ route('teacher.list.subject') }}', {
                subjectId: routineSubjectId
            }, function(response) {
                $(".teacher_id").html('<option value="">---- Select ----</option>');
                if (response.data.length > 0) {
                    for (let i in response.data) {
                        let item = response.data[i];
                        selected = (teacherId == item.id) ? 'selected' : '';
                        let option = '<option value="' + item.id + '" ' + selected + '>' + item.full_name +
                            '</option>';
                        $(".teacher_id").append(option);
                    }
                }
                mApp.unblockPage();
            });
        }

        $(".teacher_id").change(function(e) {
            e.preventDefault();

            mApp.blockPage({
                overlayColor: "#000000",
                type: "loader",
                state: "primary",
                message: "Please wait..."
            });

            teacherId = $(this).val();

            $(".group_teachers").val(teacherId);

            mApp.unblockPage();
        });

        $('#class_type_id').change(function(e) {
            let classTypeId = $('#class_type_id').val();
            phaseId = $('#phase_id').val();
            courseId = $('#course_id').val();
            sessionId = $('#session_id').val();
            subjectId = $('#subject_id').val();

            mApp.blockPage({
                overlayColor: "#000000",
                type: "loader",
                state: "primary",
                message: "Please wait..."
            });

            $.ajax({
                type: "get",
                url: baseUrl + 'admin/student/group/list/' + phaseId + '/' + courseId + '/' + sessionId +
                    '/' + subjectId + '/' + classTypeId,
                async: false,
                success: function(response) {
                    selectedGroups = response;
                }
            });


            $('#student_group_id').html('<option value="">---- Select Group ----</option>');

            var department = "";
            for (i in selectedGroups) {
                if (selectedGroups[i].department_id) {
                    department = ' - ' + selectedGroups[i].department.title;
                }
                $('#student_group_id').append('<option value="' + selectedGroups[i].id + '">' + selectedGroups[i]
                    .group_name + department + '</option>');
            }

            if (classTypeId != 0 && classTypeId != 1 && classTypeId != 9) {
                $('.group-row').not(':first').remove();

                var firstGroupTeacherId = $('.group_teachers').val();
                var copyRow = $('.group-row-main');
                var select = $('.group-row');

                for (var x = 1; x <= (selectedGroups.length - 1); x++) {
                    var copydata = copyRow.clone(true);
                    var copydata = copydata.removeClass('group-row-main');

                    copydata.find('.group_teachers').val(firstGroupTeacherId);
                    select.after(copydata);
                }
                $('.group-row').removeClass('m--hide');
            } else {
                $('.group-row').addClass('m--hide');
            }
            mApp.unblockPage();
        });

        if (sessionId > 0 && courseId > 0) {
            mApp.blockPage({
                overlayColor: "#000000",
                type: "loader",
                state: "primary",
                message: "Please wait..."
            });

            $.get('{{ route('phase.term.list') }}', {
                sessionId: sessionId,
                courseId: courseId
            }, function(response) {
                if (response.data) {
                    $('#phase_id').html('<option value="">---- Select ----</option>');
                    phaseInfo = response.data;
                    for (i in phaseInfo) {
                        phaseSelected = (phaseId == phaseInfo[i].phase.id) ? 'selected' : '';
                        $('#phase_id').append('<option value="' + phaseInfo[i].phase.id + '" ' + phaseSelected +
                            '>' + phaseInfo[i].phase.title + '</option>')
                    }

                    phaseId = $('#phase_id').val();
                    courseId = $('#course_id').val();
                    sessionId = $('#session_id').val();

                    selectedPhase = _.find(phaseInfo, function(o) {
                        return o.phase.id == phaseId;
                    });
                    $('#term_id').html('<option value="">---- Select ----</option>');
                    for (var i = 1; i <= selectedPhase.total_terms; i++) {
                        selected = (termId == i) ? 'selected' : '';
                        $('#term_id').append('<option value="' + i + '" ' + selected + '> Term ' + i + '</option>')
                    }

                    // load subjects
                    $.get('{{ route('subjects.session.course.phase') }}', {
                        sessionId: sessionId,
                        courseId: courseId,
                        phaseId: phaseId
                    }, function(response) {
                        if (response.data) {
                            $('#subject_id').html('<option value="">---- Select ----</option>');
                            for (i in response.data) {
                                subject = response.data[i];
                                selectedSubject = (routineSubjectId == subject.id) ? 'selected' : '';
                                $('#subject_id').append('<option value="' + subject.id + '" ' +
                                    selectedSubject + '>' + subject.title + '</option>')
                            }
                            $('#subject_id').trigger('change');

                            mApp.unblockPage();

                        }
                    })

                }
            });
        }

        classStartDate = $('#start_date').val();
        classEndDate = $('#end_date').val();
        selectedClassDays = $('.days:checked').map(function(_, el) {
            return $(el).val();
        }).get();

        if (classStartDate != '' && classEndDate != '' && selectedClassDays != '') {
            $.get('{{ route('classRoutine.classDates.except.holiday') }}', {
                classStartDate: classStartDate,
                classEndDate: classEndDate,
                selectedClassDays: selectedClassDays
            }, function(response) {
                if (response.count > 0) {
                    $('#total-class').html('Total Class Number : <b>' + response.count + '</b>');
                } else if (response.status === false) {
                    $('#total-class').html('These days are <b>Holiday.</b>');
                } else {
                    $('#total-class').html('No valid class dates found in selected range.');
                }
            });
        } else {
            $('.totalClassCount').addClass('d-none');
        }

        //count valid class number from date range excluding holiday
        $('#start_date, #end_date, #weekly-selected-day').change(function() {
            classStartDate = $('#start_date').val();
            classEndDate = $('#end_date').val();
            selectedClassDays = $('.days:checked').map(function(_, el) {
                return $(el).val();
            }).get();

            mApp.blockPage({
                overlayColor: "#000000",
                type: "loader",
                state: "primary",
                message: "Please wait..."
            });

            if (classStartDate != '' && classEndDate != '' && selectedClassDays != '') {
                $.get('{{ route('classRoutine.classDates.except.holiday') }}', {
                    classStartDate: classStartDate,
                    classEndDate: classEndDate,
                    selectedClassDays: selectedClassDays
                }, function(response) {
                    $('.totalClassCount').removeClass('d-none');
                    if (response.count > 0) {
                        $('#total-class').html('Total Class Number : <b>' + response.count + '</b>');
                        $("#submitButton").prop("disabled", false).css('cursor', 'pointer');
                    } else if (response.status === false) {
                        $('#total-class').html('These days are <b>Holiday.</b>');
                        $("#submitButton").prop("disabled", true).css('cursor', 'not-allowed');
                    } else {
                        $('#total-class').html('No valid class dates found in selected range.');
                        $("#submitButton").prop("disabled", true).css('cursor', 'not-allowed');
                    }
                });
            } else {
                $('.totalClassCount').addClass('d-none');
                $("#submitButton").prop("disabled", false).css('cursor', 'pointer');
            }
            mApp.unblockPage();

        });

        $('#batch_type_id').change(function() {
            const batchType = $(this).val();
            if ($(this).val() == 2) {
                $('#is_old_students').prop('disabled', true);
                $('#is_old_students').prop('checked', false);
                $('#is_old_students').parent().addClass('not-allowed');
            } else {
                $('#is_old_students').removeAttr('disabled');
                $('#is_old_students').parent().removeClass('not-allowed');
            }
        });

        $('#start_time').change(function () {
            let startTime = $(this).val();
            let classType = $('#class_type_id');
            let isEveningClass = startTime >= '15:00';

            if (isEveningClass && parseInt(classType.val()) === 14) {
                classType.val(18); // Change to evening class
            }

            if (!isEveningClass && parseInt(classType.val()) === 18) {
                classType.val(14); // Change to morning class
            }

            classType.selectpicker('refresh');
        });

        $('#nemc-general-form').validate({
            onkeyup: false,
            onfocusout: false,
            onclick: false,
            rules: {
                session_id: {
                    required: true,
                    min: 1
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
                    min: 1,
                    remote: {
                        url: "{{ route('class_routine.schedule.check') }}",
                        type: "post",
                        data: {
                            days: function() {
                                var days = [];
                                $.each($(".days:checked"), function(){
                                    days.push($(this).val());
                                });
                                return days;
                            },
                            start_date: function() { return $("#start_date").val(); },
                            end_date: function() { return $("#end_date").val(); },
                            start_time: function() { return $("#start_time").val(); },
                            end_time: function() { return $("#end_time").val(); },
                            group_teachers: function() {
                                var group_teachers = [];
                                $(".group_teachers").each(function() {
                                    if (this.value !== '') {
                                        group_teachers.push($(this).val());
                                    }
                                });
                                return group_teachers;
                            },
                            onEvent: 'edit',
                            id: '{{ $classRoutine->id }}',
                            _token: "{{ csrf_token() }}",
                        },
                        dataFilter: function(response) {
                            var res = JSON.parse(response);
                            if(res.status === false && res.type === 'teacher') {
                                return "\"" + res.message + "\"";
                            }
                            return '"true"';
                        }
                    }
                },
                class_type_id: {
                    required: true,
                    min: 1
                },
                batch_type_id: {
                    required: true,
                    min: 1
                },
                start_date: {
                    required: true,
                },
                end_date: {
                    required: true,
                },
                start_time: {
                    required: true,
                },
                end_time: {
                    required: true,
                },
                hall_id: {
                    required: function() {
                        return [1,9,17].includes(parseInt($("#class_type_id").val()));
                    }
                },
                'days[]': {
                    required: true,
                    remote: {
                        url: "{{ route('class_routine.schedule.check') }}",
                        type: "post",
                        data: {
                            days: function() {
                                var days = [];
                                $.each($(".days:checked"), function(){
                                    days.push($(this).val());
                                });
                                return days;
                            },
                            session_id: function() { return $("#session_id").val();},
                            course_id: function () { return $("#course_id").val();},
                            phase_id: function() { return $("#phase_id").val(); },
                            subject_id: function() { return $("#subject_id").val(); },
                            start_date: function() { return $("#start_date").val(); },
                            end_date: function() { return $("#end_date").val(); },
                            start_time: function() { return $("#start_time").val(); },
                            end_time: function() { return $("#end_time").val(); },
                            student_groups: function() {
                                var student_groups = [];
                                $(".student_group_id").each(function() {
                                    if (this.value !== '') {
                                        student_groups.push($(this).val());
                                    }
                                });
                                return student_groups;
                            },
                            onEvent: 'edit',
                            id: '{{ $classRoutine->id }}',
                            _token: "{{ csrf_token() }}",
                        },
                        dataFilter: function(response) {
                            var res = JSON.parse(response);
                            if(res.status === false && res.type === 'students') {
                                return "\"" + res.message + "\"";
                            }
                            return '"true"';
                        }
                    }
                },
                'student_group_id[]': {
                    required: function(element) {
                        return $("#class_type_id").val() != 1 && $("#class_type_id").val() != 9 && $("#class_type_id").val() != 17;
                    }
                },
                'group_teachers[]': {
                    required: function(element) {
                        return $("#class_type_id").val() != 1 && $("#class_type_id").val() != 9 && $("#class_type_id").val() != 17;
                    }
                },
                old_students: {
                    required: function(element) {
                        return $(".is_old_studnets").is(':checked');
                    }
                }
            },
            errorPlacement: function(error, element) {
                if (element.hasClass('m-bootstrap-select')) {
                    error.insertAfter('.m-bootstrap-select.m_');
                } else {
                    error.insertAfter(element);
                }
            },
            submitHandler: function(form) {
                $("#submitButton").prop("disabled", true).text("Processing...").css('cursor', 'not-allowed');
                form.submit();
            },
            invalidHandler: function() {
                // If validation fails, re-enable the button
                $("#submitButton").prop("disabled", false).html('<i class="fa fa-save"></i> Update').css('cursor', 'pointer');
            }
        });
    </script>
@endpush
