@extends('layouts.default')
@section('pageTitle', $pageTitle)
@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="m-portlet">
                <div class="m-portlet__head">
                    <div class="m-portlet__head-caption">
                        <div class="m-portlet__head-title">
                            <h3 class="m-portlet__head-text"><i class="fas fa-list-ul fa-md pr-2"></i>{{$pageTitle}}
                            </h3>
                        </div>
                    </div>
                    <div class="m-portlet__head-tools">
                        @if (hasPermission('result/create'))
                            <a href="{{ route('result.create') }}" class="btn btn-primary m-btn m-btn--icon"><i
                                    class="fa fa-plus pr-2"></i>Publish Exam Result</a>
                        @endif
                    </div>
                </div>
                <div class="m-portlet__body">
                    <div class="m-section__content">
                        <form id="searchForm" role="form" method="get">
                            <div class="row">
                                <div class="col-xs-12 col-sm-6 col-md-3 col-lg-3 col-xl-3">
                                    <div class="form-group">
                                        <select class="form-control" name="session_id" id="session_id">
                                            <option value="">---- Select Session ----</option>
                                            {!! select($sessions, app()->request->session_id) !!}
                                        </select>
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-6 col-md-3 col-lg-3 col-xl-3">
                                    <div class="form-group">
                                        <select class="form-control" name="course_id" id="course_id">
                                            <option value="">---- Select Course ----</option>
                                            {!! select($courses, Auth::user()->teacher->course_id ?? app()->request->course_id) !!}
                                        </select>
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-6 col-md-3 col-lg-3 col-xl-3">
                                    <div class="form-group">
                                        <select class="form-control" name="phase_id" id="phase_id">
                                            <option value="">---- Select Phase ----</option>
                                            {!! select($phases, app()->request->phase_id) !!}
                                        </select>
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-6 col-md-3 col-lg-3 col-xl-3">
                                    <select class="form-control" name="term_id" id="term_id">
                                        <option value="">---- Select Term----</option>
                                    </select>
                                </div>

                                <div class="col-xs-12 col-sm-6 col-md-3 col-lg-3 col-xl-3">
                                    <div class="form-group">
                                        <select class="form-control" name="exam_category_id" id="exam_category_id">
                                            <option value="">---- Select Exam Category ----</option>
                                            {!! select($examCategories, app()->request->exam_category_id) !!}
                                        </select>
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-6 col-md-3 col-lg-3 col-xl-3">
                                    <div class="form-group">
                                        <select class="form-control m-input" name="subject_id" id="subject_id">
                                            <option value="">---- Select Subject ----</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-6 col-md-3 col-lg-3 col-xl-3">
                                    <div class="form-group">
                                        <input type="text" class="form-control m-input m_datepicker" name="date_from"
                                               placeholder="Result Publish From Date"
                                               value="{!! app()->request->date_from !!}" autocomplete="off"/>
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-6 col-md-3 col-lg-3 col-xl-3">
                                    <div class="form-group">
                                        <input type="text" class="form-control m-input m_datepicker" name="date_to"
                                               placeholder="Result Publish To Date"
                                               value="{!! app()->request->date_to !!}" autocomplete="off"/>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-xs-12 col-sm-6 col-md-3 col-lg-3 col-xl-3">
                                    <div class="form-group">
                                        <select class="form-control" name="result_publish_status" id="result_publish_status">
                                                <option value="">---- Select Status ----</option>
                                                <option value="0">Not yet published</option>
                                                <option value="1">Published</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-xs-12 col-sm-6 col-md-12 col-lg-12 col-xl-12">
                                        <div class="pull-right search-action-btn">
                                            <button class="btn btn-primary result-search m-btn m-btn--icon"><i
                                                    class="fa fa-search"></i> Search
                                            </button>
                                            <a href="{{route('result.index')}}" class="btn btn-default reset"><i
                                                    class="fas fa-sync-alt search-reset"></i> Reset</a>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="m-section__content mt-3">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="table-responsive">
                                        @include('common/datatable')
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    @include('common.resultPublishModal')
    @include('common.resultEditRequestModal')

    @endsection

    @push('scripts')
        <script src="//cdnjs.cloudflare.com/ajax/libs/lodash.js/4.17.11/lodash.min.js" type="text/javascript"></script>
        <script>
            var phaseInfo = [];
            var total_terms = '';
            var selectedPhase = '';

            $(document).on('click', '.btn-edit-request', function () {
                const examId = $(this).data('exam-id');
                const subjectId = $(this).data('subject-id');

                $('#request_exam_id').val(examId);
                $('#request_subject_id').val(subjectId);
                $('#editRequestModal').modal('show');
            });

            $('#edit-request-form').on('submit', function (e) {
                e.preventDefault();
                let formData = new FormData(this);

                $.ajax({
                    url: '{{ route('result.edit.request.submit') }}',
                    method: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function (res) {
                        $('#editRequestModal').modal('hide');
                        toastr.success(res.message || 'Submitted!');
                        $('#dataTable').DataTable().ajax.reload();
                    },
                    error: function (xhr) {
                        toastr.error(xhr.responseJSON.message || 'Something went wrong!');
                    }
                });
            });

            $(document).on('click', '.toggle-edit-permission', function () {
                const examId = $(this).data('exam-id');
                const subjectId = $(this).data('subject-id');

                $.ajax({
                    url: 'result/toggle-edit-permission',
                    method: 'POST',
                    data: {
                        _token: $('meta[name="csrf-token"]').attr('content'),
                        examId: examId,
                        subjectId: subjectId,
                    },
                    success: function (response) {
                        if (response.success) {
                            toastr.success(response.message);
                            $('#dataTable').DataTable().ajax.reload();
                        } else {
                            toastr.error(response.message);
                        }
                    },
                    error: function (xhr) {
                        toastr.error(xhr.responseJSON.message || 'Something went wrong!');
                    }
                });
            });

            $('#course_id, #session_id').change(function () {
                courseId = $('#course_id').val();
                sessionId = $('#session_id').val();
                $.get('{{route('phase.term.list')}}', {sessionId: sessionId, courseId: courseId}, function (response) {
                    if (response.data) {
                        phaseInfo = response.data;
                        console.log(phaseInfo);
                    }
                })
            });

            $('.result-search').click(function () {
                if (($('#session_id').val() < 1) || ($('#course_id').val() < 1)) {
                    sweetAlert('Session & course is required', 'error');
                    return false;
                } else {
                    $('#searchForm').submit();
                }
            })

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

                selectedPhase = _.find(phaseInfo, function (o) {
                    return o.phase.id == phaseId;
                });

                if (selectedPhase) {
                    console.log(`x === undefined`)
                    totalTerms = selectedPhase.total_terms;
                } else {
                    console.log(`x !== undefined`)
                    totalTerms = ''
                }

                $('#term_id').html('<option value="">---- Select ----</option>');
                for (var i = 1; i <= totalTerms; i++) {
                    $('#term_id').append('<option value="' + i + '"> Term ' + i + '</option>')
                }
                get_subject_by_phase(phaseId, courseId, sessionId);
            });

            $(".m_datepicker").datepicker({
                todayHighlight: !0,
                orientation: "bottom left",
                format: 'dd/mm/yyyy',
                autoclose: true,
            });
            <?php
            if (app()->request->phase_id && app()->request->session_id && app()->request->course_id){ ?>
            get_subject_by_phase('<?php echo app()->request->phase_id; ?>', '<?php echo app()->request->course_id; ?>', '<?php echo app()->request->session_id; ?>');
            <?php } ?>
            function get_subject_by_phase(phaseId, courseId, sessionId) {
                $.get('{{route('subjects.session.course.phase')}}', {
                    sessionId: sessionId,
                    courseId: courseId,
                    phaseId: phaseId
                }, function (response) {
                    if (response.data) {
                        $('#subject_id').html('<option value="">---- Select ----</option>');
                        for (i in response.data) {
                            subject = response.data[i];
                            $('#subject_id').append('<option value="' + subject.id + '">' + subject.title + '</option>')
                        }

                    }
                    mApp.unblockPage();
                })
            }
        </script>

    @endpush
