@extends('layouts.default')
@section('pageTitle', $pageTitle)

@section('content')

    <div class="m-portlet m-portlet--tab">
        <div class="m-portlet__head">
            <div class="m-portlet__head-caption">
                <div class="m-portlet__head-title">
                    <h3 class="m-portlet__head-text"><i class="far fa-plus-square pr-2"></i>Create Topic</h3>
                </div>
            </div>
            <div class="m-portlet__head-tools">
                    <a href="{{ url('admin/topic') }}" class="btn btn-primary m-btn m-btn--icon"><i class="fas fa-address-book pr-2"></i>Topics</a>
            </div>
        </div>

        <!--begin::Form-->
        <form class="m-form m-form--fit m-form--label-align-right" id="nemc-general-form"  action="{{ url('admin/topic') }}" method="post">
            @csrf
            <div class="m-portlet__body">
                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                        <div class="form-group  m-form__group {{ $errors->has('title') ? 'has-danger' : '' }}">
                            <label class="form-control-label"><span class="text-danger">*</span> Topic Name </label>
                            <input type="text" class="form-control m-input" name="title" value="{{ old('title') }}" placeholder="Topic Name"/>
                            @if ($errors->has('title'))
                                <div class="form-control-feedback">{{ $errors->first('title') }}</div>
                            @endif
                        </div>
                    </div>

                    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                        <div class="form-group  m-form__group {{ $errors->has('serial_number') ? 'has-danger' : '' }}">
                            <label class="form-control-label"><span class="text-danger">*</span> Topic Serial Number </label>
                            <input type="text" class="form-control m-input" name="serial_number" value="{{ old('serial_number') }}" placeholder="Topic Serial Number"/>
                            @if ($errors->has('serial_number'))
                                <div class="form-control-feedback">{{ $errors->first('serial_number') }}</div>
                            @endif
                        </div>
                    </div>

                    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                        <div class="form-group m-form__group">
                            <label class="form-control-label"><span class="text-danger">*</span> Course </label>
                            <select class="form-control" name="course_id" id="course_id">
                                <option value=" ">---- Select Course ----</option>
                                {!! select($courses, Auth::user()->teacher->course_id ?? '') !!}
                            </select>
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                        <div class="form-group m-form__group">
                            <label class="form-control-label"><span class="text-danger">*</span> Subject Group</label>
                            <select class="form-control" name="subject_group_id" id="subject_group_id">
                                <option value=" ">---- Select Subject Group ----</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                        <div class="form-group m-form__group {{ $errors->has('subject_id') ? 'has-danger' : '' }}">
                            <label class="form-control-label"><span class="text-danger">*</span> Subject</label>
                            <select class="form-control" name="subject_id" id="subject_id">
                                <option value=" ">---- Select Subject ----</option>
                            </select>
                            @if ($errors->has('subject_id'))
                                <div class="form-control-feedback">{{ $errors->first('subject_id') }}</div>
                            @endif
                        </div>
                    </div>


                       {{-- <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                            <div class="form-group  m-form__group {{ $errors->has('subject_id') ? 'has-danger' : '' }}">
                                <label class="form-control-label"><span class="text-danger">*</span> Subject </label>
                                <select class="form-control m-input m-bootstrap-select m_selectpicker" name="subject_id" id="subject_id" data-live-search="true">
                                    <option value=" ">---- Select Subject ----</option>
                                    @foreach($subjects as $subject)
                                        <option value="{{$subject->id}}" {{ old('subject_id') == $subject->id ? 'selected' : '' }}>{{$subject->title}}</option>
                                    @endforeach
                                </select>
                                @if ($errors->has('subject_id'))
                                    <div class="form-control-feedback">{{ $errors->first('subject_id') }}</div>
                                @endif
                            </div>
                        </div>--}}

                    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                        <div class="form-group  m-form__group">
                            <label class="form-control-label"><span class="text-danger">*</span> Topic Head</label>
                            <select class="form-control m-input" name="topic_head_id" id="topic_head_id">
                                <option value=" ">---- Select Topic Head ----</option>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
                        <div class="form-group  m-form__group">
                            <label class="form-control-label">Topic Description </label>
                            {{--<textarea class="form-control m-input" name="description" placeholder="Topic Description"> {{ old('description') }}</textarea>--}}
                            <textarea class="form-control m-input summernote" name="description" placeholder="Topic Description"> {{ old('description') }}</textarea>
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
        //get subject group by course id
        $('#course_id').change(function (e) {
            courseId = $(this).val();
            if (courseId > 0){
                mApp.blockPage({
                    overlayColor: "#000000",
                    type: "loader",
                    state: "primary",
                    message: "Please wait..."
                });

                $.get('{{route('SubjectGroup.course')}}', {courseId: courseId}, function (response) {
                    if (response.data){
                        $('#subject_group_id').html('<option value="">---- Select Subject Group ----</option>');
                        for (i in response.data){
                            subjectGroup = response.data[i];
                            $('#subject_group_id').append('<option value="'+subjectGroup.id+'">'+subjectGroup.title+'</option>')
                        }

                    }
                    mApp.unblockPage()
                })
            }

        });

        //get subject by course id and subject group id
        $('#course_id, #subject_group_id').change(function (e) {
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
                        $('#subject_id').html('<option value="">---- Select Subject ----</option>');
                        for (i in response.data){
                            subject = response.data[i];
                            $('#subject_id').append('<option value="'+subject.id+'">'+subject.title+'</option>')
                        }

                    }
                    mApp.unblockPage()
                })
            }

        });

        $('#subject_id').on('change', function(){
            subjectId = $(this).val();
            optionHtml = '';
            if(subjectId != 0 || subjectId != ''){
                $.get('{{route('topic_head.subject_id')}}', {subject_id: subjectId}, function (data) {
                    if(data.length > 0){
                        optionHtml= optionHtml + '<option value="">---- Please Select ----</option>';
                        for(i in data){
                            optionHtml= optionHtml + '<option value="'+data[i].id+'">'+data[i].title+'</option>';
                        }
                    }else{
                        optionHtml= optionHtml + '<option value="">Topic Head Not Found</option>';
                    }

                    $('#topic_head_id').html(optionHtml);
                });
            }
        });

        $(".summernote").summernote({height:150})

        let courseId = $('#course_id').val();
        if (courseId > 0) {
            $('#course_id').trigger('change');
        }

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
