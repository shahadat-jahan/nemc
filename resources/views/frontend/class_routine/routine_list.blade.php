@extends('frontend.layouts.default')
@section('pageTitle', $pageTitle)

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="m-portlet">
                <div class="m-portlet__head">
                    <div class="m-portlet__head-caption">
                        <div class="m-portlet__head-title">
                            <h3 class="m-portlet__head-text"><i class="fas fa-list-ul fa-md pr-2"></i>Class Routine List
                            </h3>
                        </div>
                    </div>
                    <div class="m-portlet__head-tools">

                    </div>
                </div>

                <div class="m-portlet__body">
                    <form id="searchForm" role="form" method="get">
                        <div class="form-body">
                            <div class="row">
                                <div class="col-xs-12 col-sm-6 col-md-4 col-lg-4 col-xl-4">
                                    <div class="form-group">
                                        <select class="form-control" name="session_id" id="session_id">
                                            <option value="">---- Select Session ----</option>
                                            {!! select($sessions, app()->request->session_id) !!}
                                        </select>
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-6 col-md-4 col-lg-4 col-xl-4">
                                    <div class="form-group">
                                        <select class="form-control" name="course_id" id="course_id">
                                            <option value="">---- Select Course ----</option>
                                            {!! select($courses, app()->request->course_id) !!}
                                        </select>
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-6 col-md-4 col-lg-4 col-xl-4">
                                    <div class="form-group">
                                        <select class="form-control" name="phase_id" id="phase_id">
                                            <option value="">---- Select Phase ----</option>
                                            {!! select($phases, app()->request->phase_id) !!}
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-xs-12 col-sm-6 col-md-4 col-lg-4 col-xl-4">
                                    <div class="form-group">
                                        <select class="form-control" name="term_id">
                                            <option value="">---- Select Term ----</option>
                                            {!! select($terms, app()->request->term_id) !!}
                                        </select>
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-6 col-md-4 col-lg-4 col-xl-4">
                                    <div class="form-group">
                                        <select class="form-control m-input" name="subject_id" id="subject_id">
                                            <option value="">---- Select Subject ----</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-6 col-md-4 col-lg-4 col-xl-4">
                                    <div class="form-group">
                                        <select class="form-control m-bootstrap-select m_selectpicker" name="teacher_id"
                                                id="teacher_id_filter" data-live-search="true">
                                            <option value="">---- Select Teacher ----</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-xs-12 col-sm-6 col-md-4 col-lg-4 col-xl-4">
                                    <div class="form-group">
                                        <select class="form-control" name="class_type_id">
                                            <option value="">---- Select Class Types ----</option>
                                            {!! select($classTypes, app()->request->class_type_id) !!}
                                        </select>
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-6 col-md-4 col-lg-4 col-xl-4">
                                    <div class="form-group">
                                        <input type="text" class="form-control m-input m_datepicker_1" name="start_date"
                                               placeholder="Start Date" autocomplete="off" value="{{app()->request->start_date}}"/>
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-6 col-md-4 col-lg-4 col-xl-4">
                                    <div class="form-group">
                                        <input type="text" class="form-control m-input m_datepicker_1" name="end_date"
                                               placeholder="End Date" autocomplete="off" value="{{app()->request->end_date}}"/>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-xs-12 col-sm-6 col-md-4 col-lg-4 col-xl-4">
                                    <div class="form-group">
                                        <select class="form-control" name="year">
                                            <option value="">---- Select Year ----</option>
                                            {!! select($years, (app()->request->year ?? date('Y'))) !!}
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="pull-right search-action-btn">
                                        @if(!empty($routines) && $routines->isNotEmpty())
                                            <a target="_blank" href="{{route(customRoute('class_routine.list.pdf'), [
                                        'session_id' => app()->request->session_id,
                                        'course_id' => app()->request->course_id,
                                        'phase_id' => app()->request->phase_id,
                                        'term_id' => app()->request->term_id,
                                        'subject_id' => app()->request->subject_id,
                                        'teacher_id' => app()->request->teacher_id,
                                        'class_type_id' => app()->request->class_type_id,
                                        'start_date' => app()->request->start_date,
                                        'end_date' => app()->request->end_date,
                                        'year' => app()->request->year,
                                    ])}}" class="btn btn-primary m-btn m-btn--icon"><i class="fa fa-file-pdf"></i>
                                                PDF</a>
                                        @endif
                                        <button class="btn btn-primary m-btn m-btn--icon search-result"><i
                                                class="fa fa-search"></i> Search
                                        </button>
                                        <a class="btn btn-default m-btn m-btn--icon"
                                           href="{{url('nemc/class_routine/list')}}"><i
                                                class="fas fa-sync-alt search-reset"></i> Reset</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>

                    @if(!empty($routines) && $routines->isNotEmpty())
                        <div class="row mt-3">
                            <div class="col-md-12">
                                <div class="m-table table-responsive">
                                    <table class="table table-bordered table-hover">
                                        <thead>
                                        <tr>
                                            <th class="align-middle text-center">ID</th>
                                            <th class="align-middle text-center">Session</th>
                                            <th class="align-middle text-center">Course</th>
                                            <th class="align-middle text-center">Phase</th>
                                            <th class="align-middle text-center">Term</th>
                                            <th class="align-middle">Subject</th>
                                            <th class="align-middle">Class Type</th>
                                            <th class="align-middle">Teacher</th>
                                            <th class="align-middle text-center">Date</th>
                                            <th class="align-middle text-center">Time</th>
                                            <th class="align-middle">Class Room</th>
                                        </tr>
                                        </thead>
                                        <tbody>

                                        @foreach($routines as $routine)
                                            <tr>
                                                <th class="align-middle text-center">{{$routine->id}}</th>
                                                <td class="align-middle text-center">{{$routine->session->title}}</td>
                                                <td class="align-middle text-center">{{$routine->course->title}}</td>
                                                <td class="align-middle text-center">{{$routine->phase->title}}</td>
                                                <td class="align-middle text-center">{{$routine->term->title}}</td>
                                                <td class="align-middle">{{$routine->subject->title}}</td>
                                                <td class="align-middle">{{$routine->classType->title}}</td>
                                                <td class="align-middle">{{isset($routine->teacher) ? $routine->teacher->full_name : '--'}}</td>
                                                <td class="align-middle text-center">{{date('d M, Y', strtotime($routine->class_date))}}</td>
                                                <td class="align-middle text-center">{{$routine->class_time}}</td>
                                                <td class="align-middle">{{isset($routine->hall) ? $routine->hall->title : '--'}}</td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

@endsection

@push('scripts')

    <script src="//cdnjs.cloudflare.com/ajax/libs/lodash.js/4.17.11/lodash.min.js" type="text/javascript"></script>


    <script>
        var phaseInfo = [];
        var total_terms = '';
        var selectedPhase = '';

        //search form dropdown validation
        $('.search-result').click(function () {
            valid = true;
            $('#searchForm select').each(function () {
                var name = $(this).attr('name');
                if (name == 'session_id' || name == 'course_id' || name == 'phase_id') {
                    if (($(this).val() == '')) {
                        valid = false;
                    }
                }
            });

            if (valid == false) {
                sweetAlert('Session, Course & Phase fields are required to search', 'error');
                return false;
            } else {
                $('#searchForm').submit();

                mApp.blockPage({
                    overlayColor: "#000000",
                    type: "loader",
                    state: "primary",
                    message: "Please wait..."
                });
            }
        });

        $('#course_id, #session_id').change(function () {
            courseId = $('#course_id').val();
            sessionId = $('#session_id').val();
            $.get('{{route(customRoute('phase.term.list'))}}', {sessionId: sessionId, courseId: courseId}, function (response) {
                if (response.data) {
                    phaseInfo = response.data;
                    // console.log(phaseInfo);
                }
            })
        });

        var subjectId = '{{ app()->request->subject_id }}';

        $('#phase_id').change(function () {
            phaseId = $(this).val();
            courseId = $('#course_id').val();
            sessionId = $('#session_id').val();
            mApp.blockPage({
                overlayColor: "#000000",
                type: "loader",
                state: "primary",
                message: "Please wait..."
            });

            // load subjects
            $.get('{{route(customRoute('subjects.session.course.phase'))}}', {
                sessionId: sessionId,
                courseId: courseId,
                phaseId: phaseId
            }, function (response) {
                if (response.data) {
                    $('#subject_id').html('<option value="">---- Select Subject ----</option>');
                    for (i in response.data) {
                        subject = response.data[i];
                        selected = (subjectId == subject.id) ? 'selected' : '';
                        $('#subject_id').append('<option value="' + subject.id + '" ' + selected + '>' + subject.title + '</option>')
                    }

                }
                $('.m_selectpicker').selectpicker('refresh');
                mApp.unblockPage();
            })
        });

        var teacherId = '{{ app()->request->teacher_id }}';

        $('#subject_id').change(function (e) {
            e.preventDefault();
            mApp.blockPage({
                overlayColor: "#000000",
                type: "loader",
                state: "primary",
                message: "Please wait..."
            });

            subjectId = $(this).val();

            $.get('{{route(customRoute('teacher.list.subject'))}}', {subjectId: subjectId}, function (response) {
                $("#teacher_id_filter").html('<option value="">---- Select Teacher ----</option>');
                if (response.data.length > 0) {
                    for (i in response.data) {
                        item = response.data[i];
                        teacher = response.data[i];
                        selected = (teacherId == teacher.id) ? 'selected' : '';
                        $("#teacher_id_filter").append('<option value="' + teacher.id+ '" ' + selected + '>'  + teacher.full_name + '</option>');
                    }
                }
                $('.m_selectpicker').selectpicker('refresh');
            });
                mApp.unblockPage();
        });

        if (subjectId > 0) {
            $('#phase_id').trigger('change');

            $.get('{{route(customRoute('subjects.session.course.phase'))}}', {
                sessionId: sessionId,
                courseId: courseId,
                phaseId: phaseId
            }, function (response) {
                if (response.data) {
                    $('#subject_id').html('<option value="">---- Select Subject ----</option>');
                    for (i in response.data) {
                        subject = response.data[i];
                        selected = (subjectId == subject.id) ? 'selected' : '';
                        $('#subject_id').append('<option value="' + subject.id + '" ' + selected + '>' + subject.title + '</option>')
                    }
                }
                // $('.m_selectpicker').selectpicker('refresh');
            });

            $.get('{{route(customRoute('teacher.list.subject'))}}', {subjectId: subjectId}, function (response) {
                $("#teacher_id_filter").html('<option value="">---- Select Teacher ----</option>');
                if (response.data.length > 0) {
                    for (i in response.data) {
                        item = response.data[i];
                        teacher = response.data[i];
                        selected = (teacherId == teacher.id) ? 'selected' : '';
                        $("#teacher_id_filter").append('<option value="' + teacher.id+ '" ' + selected + '>'  + teacher.full_name + '</option>');
                    }
                }
                $('.m_selectpicker').selectpicker('refresh');
            });
        }

        $(".m_datepicker_1").datepicker({
            todayHighlight: !0,
            orientation: "bottom left",
            format: 'dd/mm/yyyy',
            autoclose: true,
        });
    </script>
@endpush
