@extends('layouts.default')
@section('pageTitle', $pageTitle)
@PUSH('style')
    <style>
        .dropdown-menu {
            width: inherit;
            overflow-y: auto;
        }
    </style>
@endpush
@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="m-portlet">
                <div class="m-portlet__head">
                    <div class="m-portlet__head-caption">
                        <div class="m-portlet__head-title">
                            <h3 class="m-portlet__head-text"><i class="fas fa-clipboard pr-2"></i>{{ $pageTitle }}</h3>
                        </div>
                    </div>
                    @if (isset($topic))
                        <div class="m-portlet__head-tools">
                            @if (hasPermission('lesson_plan/create'))
                                <a href="{{ route('topic.lesson.plan.create', $topic->id) }}"
                                    class="btn btn-primary m-btn m-btn--icon">
                                    <i class="fa fa-plus pr-2"></i>Create New Lesson Plan
                                </a>
                            @endif
                            @if (hasPermission('topic/index'))
                                <a href="{{ route('topic.index') }}" class="btn btn-primary m-btn m-btn--icon ml-2">
                                    <i class="fas fa-list-ul pr-2"></i>Back to Topics
                                </a>
                            @endif
                        </div>
                    @endif
                </div>

                <div class="m-portlet__body">
                    <form id="searchForm" role="form" method="post">
                        <div class="form-body">
                            <div class="row">
                                <div class="col-xs-12 col-sm-6 col-md-4 col-lg-4 col-xl-4">
                                    <div class="form-group">
                                        <select class="form-control m-bootstrap-select m_selectpicker" name="course_id"
                                            id="course_id" data-live-search="true">
                                            <option value="">---- Select Course ----</option>
                                            {!! select($courses, Auth::user()->teacher->course_id ?? '') !!}
                                        </select>
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-6 col-md-4 col-lg-4 col-xl-4">
                                    <div class="form-group">
                                        <select class="form-control m-bootstrap-select m_selectpicker"
                                            name="subject_group_id" id="subject_group_id" data-live-search="true">
                                            <option value="">---- Select Subject Group ----</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-6 col-md-4 col-lg-4 col-xl-4">
                                    <div class="form-group">
                                        <select class="form-control m-bootstrap-select m_selectpicker" name="subject_id"
                                            id="subject_id" data-live-search="true">
                                            <option value="">---- Select Subject ----</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-xs-12 col-sm-6 col-md-4 col-lg-4 col-xl-4">
                                    <div class="form-group">
                                        <select class="form-control m-bootstrap-select m_selectpicker" name="topic_id"
                                            id="topic_id" data-live-search="true">
                                            <option value="">---- Select Topic ----</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-6 col-md-4 col-lg-4 col-xl-4">
                                    <div class="form-group">
                                        <select class="form-control m-bootstrap-select m_selectpicker" name="speaker_id"
                                            id="speaker_id" data-live-search="true">
                                            <option value="">---- Select Speaker ----</option>
                                            @if (isset($teachers))
                                                @foreach ($teachers as $id => $name)
                                                    <option value="{{ $id }}">{{ $name }}</option>
                                                @endforeach
                                            @endif
                                        </select>
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-6 col-md-4 col-lg-4 col-xl-4">
                                    <div class="form-group">
                                        <input type="text" class="form-control m-input" name="title"
                                            placeholder="Lesson Plan Title" autocomplete="off" />
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="pull-right search-action-btn">
                                        <button class="btn btn-primary m-btn m-btn--icon"><i class="fa fa-search"></i>
                                            Search
                                        </button>
                                        <button type="reset" class="btn btn-default reset"><i
                                                class="fas fa-sync-alt search-reset"></i> Reset
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>

                    <div class="m-section__content">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="">
                                    <div class="table m-table table-responsive">
                                        @include('common.datatable')
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
@push('scripts')
    <script>
        let courseId = $('#course_id').val();
        $(document).on('click', '.delete-lesson-plan', function(e) {
            e.preventDefault();
            var url = $(this).data('url');
            Swal.fire({
                title: 'Are you sure?',
                text: "Are you sure you want to delete this lesson plan?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!',
            }).then((result) => {
                if (result.value) {
                    window.location.href = url;
                }
            });
        });

        // Cascading dropdowns
        $(document).ready(function() {
            function refreshSelectpicker(selector) {
                if ($.fn.selectpicker) {
                    $(selector).selectpicker('refresh');
                }
            }

            // Pre-select course and trigger change if teacher has a course
            let courseId = $('#course_id').val();
            refreshSelectpicker('#course_id');
            if (courseId) {
                // Wait for selectpicker to finish rendering, then trigger change
                setTimeout(function() {
                    $('#course_id').trigger('change');
                }, 200);
            }

            $('#course_id').on('change', function() {
                courseId = $(this).val();
                $('#subject_group_id').html('<option value="">---- Select Subject Group ----</option>');
                $('#subject_id').html('<option value="">---- Select Subject ----</option>');
                $('#topic_id').html('<option value="">---- Select Topic ----</option>');
                refreshSelectpicker('#subject_group_id');
                refreshSelectpicker('#subject_id');
                refreshSelectpicker('#topic_id');
                if (courseId) {
                    $.ajax({
                        url: '/admin/subject_group/list-by-course',
                        data: {
                            courseId: courseId
                        },
                        success: function(response) {
                            if (response.status && response.data.length > 0) {
                                var options =
                                    '<option value="">---- Select Subject Group ----</option>';
                                $.each(response.data, function(i, group) {
                                    options += '<option value="' + group.id + '">' +
                                        group.title + '</option>';
                                });
                                $('#subject_group_id').html(options);
                            }
                            refreshSelectpicker('#subject_group_id');
                        }
                    });
                }
            });

            $('#subject_group_id').on('change', function() {
                var groupId = $(this).val();
                var courseId = $('#course_id').val();
                $('#subject_id').html('<option value="">---- Select Subject ----</option>');
                $('#topic_id').html('<option value="">---- Select Topic ----</option>');
                refreshSelectpicker('#subject_id');
                refreshSelectpicker('#topic_id');
                if (groupId && courseId) {
                    $.ajax({
                        url: '/admin/subject/list-by-course-group',
                        data: {
                            courseId: courseId,
                            subjectGroupId: groupId
                        },
                        success: function(response) {
                            if (response.status && response.data.length > 0) {
                                var options =
                                    '<option value="">---- Select Subject ----</option>';
                                $.each(response.data, function(i, subject) {
                                    options += '<option value="' + subject.id + '">' +
                                        subject.title + '</option>';
                                });
                                $('#subject_id').html(options);
                            }
                            refreshSelectpicker('#subject_id');
                        }
                    });
                }
            });

            $('#subject_id').on('change', function() {
                var subjectId = $(this).val();
                $('#topic_id').html('<option value="">---- Select Topic ----</option>');
                refreshSelectpicker('#topic_id');
                if (subjectId) {
                    $.ajax({
                        url: '/admin/topic/list-by-subject',
                        data: {
                            subjectId: subjectId
                        },
                        success: function(response) {
                            if (response.status && response.data.length > 0) {
                                var options =
                                    '<option value="">---- Select Topic ----</option>';
                                $.each(response.data, function(i, topic) {
                                    options += '<option value="' + topic.id + '">' +
                                        topic.title + '</option>';
                                });
                                $('#topic_id').html(options);
                            }
                            refreshSelectpicker('#topic_id');
                        }
                    });
                }
                // Load teachers for subject
                if (subjectId) {
                    $.ajax({
                        url: '/admin/teacher/subject',
                        data: {
                            subjectId: subjectId
                        },
                        success: function(response) {
                            var options = '<option value="">---- Select Speaker ----</option>';
                            if (response.status && response.data.length > 0) {
                                $.each(response.data, function(i, teacher) {
                                    options += '<option value="' + teacher.id + '">' +
                                        teacher.full_name + '</option>';
                                });
                            }
                            $('#speaker_id').html(options);
                            refreshSelectpicker('#speaker_id');
                        }
                    });
                } else {
                    $('#speaker_id').html('<option value="">---- Select Speaker ----</option>');
                    refreshSelectpicker('#speaker_id');
                }
            });

            // Reset button handler
            $(document).on('click', 'button[type="reset"], .btn.reset', function(e) {
                // Reset all dropdowns to default
                $('#course_id').val('').selectpicker('val', '').selectpicker('refresh');
                $('#subject_group_id').html('<option value="">---- Select Subject Group ----</option>');
                $('#subject_group_id').selectpicker('val', '').selectpicker('refresh');
                $('#subject_id').html('<option value="">---- Select Subject ----</option>');
                $('#subject_id').selectpicker('val', '').selectpicker('refresh');
                $('#topic_id').html('<option value="">---- Select Topic ----</option>');
                $('#topic_id').selectpicker('val', '').selectpicker('refresh');
                $('#speaker_id').html('<option value="">---- Select Speaker ----</option>');
                $('#speaker_id').selectpicker('val', '').selectpicker('refresh');
                // Reset all text inputs
                $('#searchForm').find('input[type="text"]').val('');
            });
        });

        $(".m_datepicker").datepicker({
            todayHighlight: 1,
            orientation: "bottom left",
            format: 'yyyy/mm/dd',
            autoclose: true,
        });
    </script>
@endpush
