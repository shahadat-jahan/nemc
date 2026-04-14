@extends('layouts.default')
@section('pageTitle', $pageTitle)

@section('content')
    <div class="m-portlet m-portlet--tab">
        <div class="m-portlet__head">
            <div class="m-portlet__head-caption">
                <div class="m-portlet__head-title">
                    <h3 class="m-portlet__head-text"><i class="far fa-plus-square pr-2"></i>Add A Card</h3>
                </div>
            </div>
        </div>

        <!--begin::Form-->
        <form class="m-form m-form--fit m-form--label-align-right"  action="{{ route('cards.store') }}" id="nemc-general-form" method="post">
            @csrf
            <div class="m-portlet__body">
                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                        <div class="form-group  m-form__group {{ $errors->has('card_name') ? 'has-danger' : '' }}">
                            <label class="form-control-label"><span class="text-danger">*</span>Card name </label>
                            <input type="text" class="form-control m-input" name="card_name" id="card_name" value="{{old('card_name')}}" placeholder="Card name"/>
                            @if ($errors->has('card_name'))
                                <div class="form-control-feedback">{{ $errors->first('card_name') }}</div>
                            @endif
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                        <div class="form-group  m-form__group {{ $errors->has('course_id') ? 'has-danger' : '' }}">
                            <label class="form-control-label"><span class="text-danger">*</span> Course </label>
                            <select class="form-control" name="course_id" id="course_id">
                                <option value=" ">---- Select Course ----</option>
                                {!! select($courses, Auth::user()->teacher->course_id ?? '') !!}
                            </select>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                        <div class="form-group  m-form__group {{ $errors->has('subject_group_id') ? 'has-danger' : '' }}">
                            <label class="form-control-label"><span class="text-danger">*</span> Subject Group </label>
                            <select class="form-control m-input" name="subject_group_id" id="subject_group_id">
                                <option value=" ">---- Select Subject Group ----</option>
                            </select>
                        </div>
                    </div>

                    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                        <div class="form-group  m-form__group {{ $errors->has('subject_id') ? 'has-danger' : '' }}">
                            <label class="form-control-label"><span class="text-danger">*</span> Subject </label>
                            <select class="form-control m-input" name="subject_id" id="subject_id">
                                <option value=" ">---- Select Subject ----</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                        <div class="form-group  m-form__group {{ $errors->has('phase_id') ? 'has-danger' : '' }}">
                            <label class="form-control-label"><span class="text-danger">*</span> Phase </label>
                            <select class="form-control" name="phase_id" id="phase_id">
                                <option value="">---- Select ----</option>
                                {!! select($phases, old('phase_id')) !!}
                            </select>
                            @if ($errors->has('phase_id'))
                                <div class="form-control-feedback">{{ $errors->first('phase_id') }}</div>
                            @endif
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                        <div class="form-group  m-form__group {{ $errors->has('term_id') ? 'has-danger' : '' }}">
                            <label class="form-control-label"><span class="text-danger">*</span> Term </label>
                            <select class="form-control" name="term_id" id="term_id">
                                <option value="">---- Select ----</option>
                                {!! select($terms, old('term_id')) !!}
                            </select>
                            @if ($errors->has('term_id'))
                                <div class="form-control-feedback">{{ $errors->first('term_id') }}</div>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
                        <div class="form-group  m-form__group {{ $errors->has('description') ? 'has-danger' : '' }}">
                            <label class="form-control-label">Description </label>
                            <textarea class="form-control m-input summernote" name="description" id="description" rows="3" placeholder="Description">{{old('description')}}</textarea>
                            @if ($errors->has('description'))
                                <div class="form-control-feedback">{{ $errors->first('description') }}</div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            <div class="m-portlet__foot m-portlet__foot--fit">
                <div class="m-form__actions text-center">
                    <a href="{{ route('cards.index') }}" class="btn btn-outline-brand"><i class="fa fa-times"></i> Cancel</a>
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

            // load subject group
                mApp.blockPage({
                    overlayColor: "#000000",
                    type: "loader",
                    state: "primary",
                    message: "Please wait..."
                });

                $.get('{{route('SubjectGroup.course')}}', {courseId: courseId}, function (response) {
                    $('#subject_group_id').html('<option value="">---- Select Subject Group ----</option>');
                    if (response.data){
                        for (i in response.data){
                            subjectGroup = response.data[i];
                            $('#subject_group_id').append('<option value="'+subjectGroup.id+'">'+subjectGroup.title+'</option>')
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

                $.get('{{route('subjects.course.group')}}', {courseId: courseId, subjectGroupId: subjectGroupId}, function (response) {
                    $('#subject_id').html('<option value="">---- Select Subject ----</option>');
                    if (response.data){
                        for (i in response.data){
                            subject = response.data[i];
                            $('#subject_id').append('<option value="'+subject.id+'">'+subject.title+'</option>')
                        }
                    }
                    mApp.unblockPage()
                })
        });

        $('#nemc-general-form').validate({
            rules:{
                card_name: {
                    required: true,
                },
                course_id: {
                    required: true,
                    min: 1
                },
                subject_id: {
                    required: true,
                    min: 1
                },
                subject_group_id: {
                    required: true,
                    min: 1
                },
                phase_id: {
                    required: true,
                },
                term_id: {
                    required: true,
                }
            }
        });

        $('.summernote').summernote({height: 200});
    </script>
@endpush
