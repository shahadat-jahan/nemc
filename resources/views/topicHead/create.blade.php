@extends('layouts.default')
@section('pageTitle', $pageTitle)

@section('content')

    <div class="m-portlet m-portlet--tab">
        <div class="m-portlet__head">
            <div class="m-portlet__head-caption">
                <div class="m-portlet__head-title">
                    <h3 class="m-portlet__head-text"><i class="far fa-plus-square pr-2"></i>Create Topic Head</h3>
                </div>
            </div>
            <div class="m-portlet__head-tools">
                    <a href="{{ url('admin/topic_head') }}" class="btn btn-primary m-btn m-btn--icon"><i class="fas fa-book-reader pr-2"></i>Topic Heads</a>
            </div>
        </div>

        <!--begin::Form-->
        <form class="m-form m-form--fit m-form--label-align-right"  action="{{ url('admin/topic_head') }}" id="nemc-general-form" method="post">
            @csrf
            <div class="m-portlet__body">
                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                        <div class="form-group  m-form__group {{ $errors->has('title') ? 'has-danger' : '' }}">
                            <label class="form-control-label"><span class="text-danger">*</span> Topic Head Title </label>
                            <input type="text" class="form-control m-input" name="title" value="{{ old('title') }}" placeholder="Topic Head Name"/>
                            @if ($errors->has('title'))
                                <div class="form-control-feedback">{{ $errors->first('title') }}</div>
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
            </div>


            <div class="m-portlet__foot m-portlet__foot--fit">
                <div class="m-form__actions text-center">
                    <a href="{{ url('admin/topic_head') }}" class="btn btn-outline-brand"><i class="fa fa-times"></i> Cancel</a>
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

         let courseId = $('#course_id').val();
         if (courseId > 0) {
             $('#course_id').trigger('change');
         }

         $('#nemc-general-form').validate({
             rules:{
                 title: {
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
                 }

             }
         });
     </script>
@endpush

