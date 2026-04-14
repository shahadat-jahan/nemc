@extends('layouts.default')
@section('pageTitle', $pageTitle)
@push('style')
    <style>
        .m-form.m-form--label-align-right .m-form__group > label {
            text-align: left;
        }
    </style>
@endpush
@section('content')

    <div class="m-portlet m-portlet--tab">
        <div class="m-portlet__head">
            <div class="m-portlet__head-caption">
                <div class="m-portlet__head-title">
                    <h3 class="m-portlet__head-text"><i class="far fa-plus-square pr-2"></i>Assign Topic to Teacher</h3>
                </div>
            </div>
            <div class="m-portlet__head-tools">
                <a href="{{ url('admin/topic') }}" class="btn btn-primary m-btn m-btn--icon"><i
                        class="fas fa-address-book pr-2"></i>Topics</a>
            </div>
        </div>

        <!--begin::Form-->
        <form class="m-form m-form--fit m-form--label-align-right" id="nemc-general-form"
              action="{{ route('assign.topic.save') }}" method="post">
            @csrf
            <div class="m-portlet__body">
                <div class="row">

                    <div class="col-xs-12 col-sm-6 col-md-3 col-lg-3 col-xl-3">
                        <div class="form-group">
                            <select class="form-control" name="course_id" id="course_id">
                                <option value=" ">---- Select Course ----</option>
                                {!! select($courses, Auth::user()->teacher->course_id ?? '') !!}
                            </select>
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-6 col-md-3 col-lg-3 col-xl-3">
                        <div class="form-group">
                            <select class="form-control" name="subject_group_id" id="subject_group_id">
                                <option value=" ">---- Select Subject Group ----</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-6 col-md-3 col-lg-3 col-xl-3">
                        <div class="form-group">
                            <select class="form-control" name="subject_id" id="subject_id">
                                <option value=" ">---- Select Subject ----</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-6 col-md-3 col-lg-3 col-xl-3">
                        <div class="form-group {{ $errors->has('teacher_id') ? 'has-danger' : '' }}">
                            {{--  <label class="form-control-label"><span class="text-danger">*</span> Select Teacher </label>--}}
                            <select class="form-control m-bootstrap-select m_selectpicker" name="teacher_id"
                                    id="teacher-id" data-live-search="true">
                                <option>---- Select Teacher ----</option>
                            </select>
                            @if ($errors->has('teacher_id'))
                                <div class="form-control-feedback">{{ $errors->first('teacher_id') }}</div>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="m-separator m-separator--dashed m-separator--lg"></div>
                <div class="row pl-4 pr-4 topic-title m--hide">
                    <div class="m-form__heading">
                        <h3 class="m-form__heading-title">Topics</h3>
                    </div>
                </div>

                <div class="row" id="all-topics"></div>

            </div>


            <div class="m-portlet__foot m-portlet__foot--fit">
                <div class="m-form__actions text-center">
                    <a href="{{ url('admin/topic') }}" class="btn btn-outline-brand"><i class="fa fa-times"></i> Cancel</a>
                    <button type="submit" class="btn btn-success"><i class="fa fa-save"></i> Save</button>
                </div>
            </div>
        </form>

        <!--end::Form-->
    </div>
@endsection

@push('scripts')
    <script>
        $(function () {

            //get subject group by course id
            $('#course_id').change(function (e) {
                courseId = $(this).val();

                // load subject group
                mApp.blockPage({
                    overlayColor: "#000000",
                    type: "loader",
                    state: "primary",
                    message: "Please wait..."
                });

                $.get('{{route('SubjectGroup.course')}}', {courseId: courseId}, function (response) {
                    $('#subject_group_id').html('<option value="">---- Select Subject Group ----</option>');
                    if (response.data) {
                        for (i in response.data) {
                            subjectGroup = response.data[i];
                            $('#subject_group_id').append('<option value="' + subjectGroup.id + '">' + subjectGroup.title + '</option>')
                        }

                    }
                    mApp.unblockPage()
                })
            });

            let courseId = $('#course_id').val();

            if (courseId > 0) {
                mApp.blockPage({
                    overlayColor: "#000000",
                    type: "loader",
                    state: "primary",
                    message: "Please wait..."
                });

                $.get('{{route('SubjectGroup.course')}}', {courseId: courseId}, function (response) {
                    $('#subject_group_id').html('<option value="">---- Select Subject Group ----</option>');
                    if (response.data) {
                        for (i in response.data) {
                            subjectGroup = response.data[i];
                            $('#subject_group_id').append('<option value="' + subjectGroup.id + '">' + subjectGroup.title + '</option>')
                        }

                    }
                    mApp.unblockPage()
                })
            }

            //get subject by course id and subject group id
            $('#course_id, #subject_group_id').change(function (e) {
                courseId = $('#course_id').val();
                subjectGroupId = $('#subject_group_id').val();

                // load subject
                mApp.blockPage({
                    overlayColor: "#000000",
                    type: "loader",
                    state: "primary",
                    message: "Please wait..."
                });

                $.get('{{route('subjects.course.group')}}', {
                    courseId: courseId,
                    subjectGroupId: subjectGroupId
                }, function (response) {
                    if (response.data) {
                        $('#subject_id').html('<option value="">---- Select Subject ----</option>');
                        for (i in response.data) {
                            subject = response.data[i];
                            $('#subject_id').append('<option value="' + subject.id + '">' + subject.title + '</option>')
                        }
                    }
                    mApp.unblockPage()
                })
            });

            //get topic by subject
            function getTopics(subjectId) {
                subjectId = $('#subject_id').val();
                $.get('{{route('topic.subjects')}}', {subjectId: subjectId}, function (response) {
                    customHtml = '';
                    if (response.data) {
                        $('.topic-title').removeClass('m--hide');
                        $('#all-topics').html('');
                        if (response.data.length > 0) {
                            for (i in response.data) {
                                item = response.data[i];
                                customHtml += '<label class="col-5 col-form-label">' + item.title + '</label>';
                                customHtml += '<div class="col-1"><label class="m-checkbox"><input type="checkbox" class="subject-topic" name="topic[]" value="' + item.id + '"><span class="mt-4"></span></label></div>';

                            }
                        }

                        $('#all-topics').html(customHtml);
                    }
                });
            }

            //get teacher by subject
            $('#subject_id').change(function (e) {
                e.preventDefault();
                subjectId = $(this).val();
                getTeachers = $.get('{{route('teacher.list.subject')}}', {subjectId: subjectId}, function (response) {
                    $("#teacher-id").html('<option value="">---- Select Teacher ----</option>');
                    if (response.data.length > 0) {
                        for (i in response.data) {
                            item = response.data[i];
                            $("#teacher-id").append('<option value="' + item.id + '">' + item.full_name + '</option>');
                        }
                    }
                    $('.m_selectpicker').selectpicker('refresh');
                });

                getTeachers.then(getTopics(subjectId));

            });

            $.validator.addMethod("assign_topic", function (value, element) {
                var flag = true;
                if ($(".subject-topic:checkbox:checked").length == 0) {
                    flag = false;
                    alert('Atleast one topic need to assign')
                } else {
                    flag = true;
                }

                return flag;

            }, "");

            $('#nemc-general-form').validate({
                rules: {
                    subject_id: {
                        required: true,
                        min: 1
                    },
                    teacher_id: {
                        required: true,
                        min: 1
                    },
                    'topic[]': {
                        assign_topic: true,
                    },
                }
            });

        });
    </script>
@endpush
