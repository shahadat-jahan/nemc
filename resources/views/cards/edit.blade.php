@extends('layouts.default')
@section('pageTitle', $pageTitle)

@section('content')
    <div class="m-portlet m-portlet--tab">
        <div class="m-portlet__head">
            <div class="m-portlet__head-caption">
                <div class="m-portlet__head-title">
                    <h3 class="m-portlet__head-text"><i class="far fa-plus-square pr-2"></i>Edit A Card</h3>
                </div>
            </div>
        </div>

        <!--begin::Form-->
        <form class="m-form m-form--fit m-form--label-align-right"  action="{{ route('cards.update', [$card->id]) }}" id="nemc-general-form" method="post">
            @csrf
            @method('put')
            <div class="m-portlet__body">

                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                        <div class="form-group  m-form__group {{ $errors->has('card_name') ? 'has-danger' : '' }}">
                            <label class="form-control-label"><span class="text-danger">*</span>Card name </label>
                            <input type="text" class="form-control m-input" name="card_name" id="card_name" value="{{old('card_name', $card->title)}}" placeholder="Card name"/>
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
                                @foreach($courses as $course)
                                    <option value="{{$course->id}}" {{($course->id == $card->subject->subjectGroup->course_id) ? 'selected' : ''}}>{{$course->title}}</option>
                                @endforeach
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
                                {!! select($phases, old('phase_id', $card->phase_id)) !!}
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
                                {!! select($terms, old('term_id', $card->term_id)) !!}
                            </select>
                            @if ($errors->has('term_id'))
                                <div class="form-control-feedback">{{ $errors->first('term_id') }}</div>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                        <div class="form-group  m-form__group">
                            <label class="form-control-label"> Select Status </label>
                            <select class="form-control m-input " name="status">
                                <option value="1" {{ $card->status == 1  ? 'selected' : '' }}>Active</option>
                                <option value="0" {{ $card->status == 0  ? 'selected' : '' }}>Inactive</option>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
                        <div class="form-group  m-form__group {{ $errors->has('description') ? 'has-danger' : '' }}">
                            <label class="form-control-label">Description </label>
                            <textarea class="form-control m-input summernote" name="description" id="description" rows="3" placeholder="Description">{{old('description', $card->description)}}</textarea>
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

<script src="//cdnjs.cloudflare.com/ajax/libs/lodash.js/4.17.11/lodash.min.js" type="text/javascript"></script>

<script>
    var subjectGroupId = '{{$card->subject->subject_group_id}}';
    var subjectId = '{{$card->subject_id}}';

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

    if (subjectGroupId > 0 && subjectId > 0){
        mApp.blockPage({
            overlayColor: "#000000",
            type: "loader",
            state: "primary",
            message: "Please wait..."
        });

        var ajax1 = $.get('{{route('SubjectGroup.course')}}', {courseId: $('#course_id').val()}, function (response) {
                if (response.data){
                    $('#subject_group_id').html('<option value="">---- Select ----</option>');
                    for (i in response.data){
                        subjectGroup = response.data[i];
                        selected = (subjectGroupId == subjectGroup.id) ? 'selected' : '';
                        $('#subject_group_id').append('<option value="'+subjectGroup.id+'" '+ selected +'>'+subjectGroup.title+'</option>')
                    }

                }
            }),
            ajax2 = $.get('{{route('subjects.course.group')}}', {courseId: $('#course_id').val(), subjectGroupId:  subjectGroupId}, function (response) {
                if (response.data){
                    $('#subject_id').html('<option value="">---- Select ----</option>');
                    for (i in response.data){
                        subject = response.data[i];

                        selected = (subjectId == subject.id) ? 'selected' : '';
                        $('#subject_id').append('<option value="'+subject.id+'" '+ selected +'>'+subject.title+'</option>')
                    }

                }

                mApp.unblockPage()
            });

        $.when(ajax1, ajax2).done(function(req1, req2) {});
    }

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

                        selected = (subjectId == subject.id) ? 'selected' : '';
                        $('#subject_id').append('<option value="'+subject.id+'" '+ selected +'>'+subject.title+'</option>')
                    }

                }

                mApp.unblockPage()
            })
        }

    });

    $('#nemc-general-form').validate({
        rules:{
            title: {
                required: true
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

    $('.summernote').summernote({height: 200});
</script>
@endpush