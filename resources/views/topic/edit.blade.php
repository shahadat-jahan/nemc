@extends('layouts.default')
@section('pageTitle', 'Designation')
<?php
    $teacherId = !empty($topic->teachers->toArray()) ? $topic->teachers->first()->id : '';
?>
@section('content')
    <div class="m-portlet m-portlet--tab">
        <div class="m-portlet__head">
            <div class="m-portlet__head-caption">
                <div class="m-portlet__head-title">
                    <h3 class="m-portlet__head-text"><i class="far fa-edit pr-2"></i>Edit Topic</h3>
                </div>
            </div>
            <div class="m-portlet__head-tools">
                    <a href="{{ url('admin/topic') }}" class="btn btn-primary m-btn m-btn--icon"><i class="fas fa-list pr-2"></i>Topics</a>
            </div>
        </div>

        <!--begin::Form-->
        <form class="m-form m-form--fit m-form--label-align-right" id="nemc-general-form"  action="{{ url('admin/topic/' .$topic->id) }}" method="post">
            @csrf
            @method('PUT')
            <div class="m-portlet__body">

                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                        <div class="form-group  m-form__group {{ $errors->has('title') ? 'has-danger' : '' }}">
                            <label class="form-control-label"><span class="text-danger">*</span> Topic Name </label>
                            <input type="text" class="form-control m-input" name="title" value="{{ old('title', $topic->title) }}" placeholder="Topic Name"/>
                            @if ($errors->has('title'))
                                <div class="form-control-feedback">{{ $errors->first('title') }}</div>
                            @endif
                        </div>
                    </div>

                    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                        <div class="form-group  m-form__group {{ $errors->has('serial_number') ? 'has-danger' : '' }}">
                            <label class="form-control-label"><span class="text-danger">*</span> Topic Serial No </label>
                            <input type="text" class="form-control m-input" name="serial_number" value="{{ old('serial_number', $topic->serial_number) }}" placeholder="Topic Serial Number"/>
                            @if ($errors->has('serial_number'))
                                <div class="form-control-feedback">{{ $errors->first('serial_number') }}</div>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                        <div class="form-group m-form__group">
                            <label class="form-control-label"><span class="text-danger">*</span> Course </label>
                            <select class="form-control" name="course_id" id="course_id">
                                <option value=" ">---- Select Course ----</option>
                                @foreach($courses as $course)
                                    @if(!empty($topic->topicHead->subject->subjectGroup->course_id))
                                        <option value="{{$course->id}}" {{($topic->topicHead->subject->subjectGroup->course_id == $course->id) ? 'selected' : ''}}>{{$course->title}}</option>
                                    @else
                                        <option value="{{$course->id}}">{{$course->title}}</option>
                                    @endif
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                        <div class="form-group  m-form__group {{ $errors->has('subject_group_id') ? 'has-danger' : '' }}">
                            <label class="form-control-label"><span class="text-danger">*</span> Subject Group </label>
                            <select class="form-control m-input" name="subject_group_id" id="subject_group_id">
                                <option value=" ">---- Select Subject Group ----</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                        <div class="form-group  m-form__group">
                            <label class="form-control-label"><span class="text-danger">*</span> Subject </label>
                            <select class="form-control m-input m-bootstrap-select m_selectpicker" name="subject_id" id="subject_id" data-live-search="true">
                                <option value=" ">---- Select Subject ----</option>
                                @foreach($subjects as $subject)
                                    @if (!empty($topic->topicHead->subject->id))
                                        <option value="{{$subject->id}}" {{$subject->id == $topic->topicHead->subject->id ? 'selected' : ' '}}>{{$subject->title}}</option>
                                    @else
                                        <option value="{{$subject->id}}">{{$subject->title}}</option>
                                    @endif
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                        <div class="form-group  m-form__group">
                            <label class="form-control-label"><span class="text-danger">*</span> Topic Head </label>
                            <select class="form-control m-input m-bootstrap-select m_selectpicker" name="topic_head_id" id="topic_head_id" data-live-search="true">
                                <option value=" ">---- Select Topic Head ----</option>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                        <div class="form-group  m-form__group {{ $errors->has('teacher_id') ? 'has-danger' : '' }}">
                            <label class="form-control-label"> Select Teacher </label>
                            <select class="form-control m-input m-bootstrap-select m_selectpicker" name="teacher_id" id="teacher-id" data-live-search="true">
                                <option>--Select Teacher--</option>
                            </select>
                            @if ($errors->has('teacher_id'))
                                <div class="form-control-feedback">{{ $errors->first('teacher_id') }}</div>
                            @endif
                        </div>
                    </div>

                    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                        <div class="form-group  m-form__group">
                            <label class="form-control-label">Select Status </label>
                            <select class="form-control m-input " name="status">
                                <option value="1" {{ $topic->status == 1  ? 'selected' : '' }}>Active</option>
                                <option value="0" {{ $topic->status == 0  ? 'selected' : '' }}>Inactive</option>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
                        <div class="form-group  m-form__group">
                            <label class="form-control-label">Topic Description </label>
                            <textarea class="form-control m-input summernote" name="description" placeholder="Topic Description">{{ old('description', $topic->description) }}</textarea>
                        </div>
                    </div>
                </div>
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

        var subjectGroupId = '{{$topic->topicHead->subject->subject_group_id ?? ''}}';
        //get subject group by course id
        $('#course_id').change(function (e) {
            courseId = $(this).val();
            // load subject group
            if (courseId > 0){
                mApp.blockPage({
                    overlayColor: "#000000",
                    type: "loader",
                    state: "primary",
                    message: "Please wait..."
                });

                $.get('{{route('SubjectGroup.course')}}', {courseId: courseId}, function (response) {
                    if (response.data){
                        $('#subject_group_id').html('<option value="">---- Select ----</option>');
                        for (i in response.data){
                            subjectGroup = response.data[i];
                            selected = (subjectGroupId == subjectGroup.id) ? 'selected' : '';
                            $('#subject_group_id').append('<option value="'+subjectGroup.id+'" '+ selected +'>'+subjectGroup.title+'</option>')
                        }

                    }
                    mApp.unblockPage()
                })
            }

        });

        //get subject by course id and subject group id
        $('#subject_group_id').change(function (e) {
            courseId = $('#course_id').val();
            subjectGroupId = $('#subject_group_id').val();
            // load subject
            if (courseId > 0 && subjectGroupId > 0){
                mApp.blockPage({
                    overlayColor: "#000000",
                    type: "loader",
                    state: "primary",
                    message: "Please wait..."
                });

                $.get('{{route('subjects.course.group')}}', {courseId: courseId, subjectGroupId: subjectGroupId}, function (response) {
                    if (response.data){
                        $('#subject_id').html('<option value="">---- Select ----</option>');
                        for (i in response.data){
                            subject = response.data[i];
                            $('#subject_id').append('<option value="'+subject.id+'">'+subject.title+'</option>')
                        }

                        $('#subject_id').selectpicker('refresh');
                    }
                    mApp.unblockPage()
                })
            }

        });

        $('#subject_id').on('change', function(){
            subjectId = $(this).val();
            optionHtml = '';
            topicHead = '{{$topic->topic_head_id}}';
            teacherId = '{{$teacherId}}';

            if(subjectId != 0 || subjectId != ''){
                getTopicHead = $.get('{{route('topic_head.subject_id')}}', {subject_id: subjectId}, function (data) {
                    if(data.length > 0){
                        optionHtml= optionHtml + '<option value="">--Please Select--</option>';
                        for(i in data){
                            selected = (topicHead == data[i].id) ? 'selected' : '';
                            optionHtml= optionHtml + '<option value="'+data[i].id+'" '+selected+'>'+data[i].title+'</option>';
                        }
                    }else{
                        optionHtml= optionHtml + '<option value="">Topic head not found</option>';
                    }

                    $('#topic_head_id').html(optionHtml);
                    $('#topic_head_id').selectpicker('refresh');
                });

                getTopicHead.then(
                    getTeachers = $.get('{{route('teacher.list.subject')}}', {subjectId: subjectId}, function(response){
                        $("#teacher-id").html('<option value="">--Select Teacher--</option>');
                        if (response.data.length > 0){
                            for (i in response.data){
                                item = response.data[i];
                                teacherSelected = (teacherId == item.id) ? 'selected' : '';
                                $("#teacher-id").append('<option value="' + item.id + '" '+ teacherSelected +'>' + item.full_name + '</option>');
                            }
                        }
                        $("#teacher-id").selectpicker('refresh');
                    })
                );
            }
        });

        $('#course_id').trigger('change');
        $('#subject_id').trigger('change');



        $(".summernote").summernote({height:150})

        //form validation
        $('#nemc-general-form').validate({
            rules:{
                title: {
                    required: true,
                },
                serial_number: {
                    required: true,
                },
                course_id: {
                    required: true,
                    min: 1
                },
                subject_group_id: {
                    required: true,
                    min: 1
                },
                subject_id: {
                    required: true,
                    min: 1
                },
                topic_head_id: {
                    required: true,
                    min: 1
                }
            }
        });

    </script>
@endpush

