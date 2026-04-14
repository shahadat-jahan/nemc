@extends('layouts.default')
@section('pageTitle', $pageTitle)

@section('content')
    <div class="m-portlet m-portlet--tab">
        <div class="m-portlet__head">
            <div class="m-portlet__head-caption">
                <div class="m-portlet__head-title">
                    <h3 class="m-portlet__head-text"><i class="far fa-plus-square pr-2"></i>Edit Card Item</h3>
                </div>
            </div>
        </div>

        <!--begin::Form-->
        <form class="m-form m-form--fit m-form--label-align-right"  action="{{ route('cardItems.update', $cardItem->id) }}" id="nemc-general-form" method="post">
            @csrf
            <div class="m-portlet__body">

                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-9 col-lg-9 col-xl-9">
                        <div class="form-group  m-form__group">
                            <label class="form-control-label"><span class="text-danger">*</span> Item Title </label>
                            <input type="text" class="form-control m-input item-title" name="title" value="{{$cardItem->title}}" placeholder="Item Title"/>
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3 col-xl-3">
                        <div class="form-group  m-form__group">
                            <label class="form-control-label"><span class="text-danger">*</span> Item Serial Number </label>
                            <input type="number" class="form-control m-input item-title" name="serial_number" id="serial_number" value="{{$cardItem->serial_number}}" placeholder="Item Title"/>
                        </div>
                    </div>

                </div>
                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                        <div class="form-group  m-form__group {{ $errors->has('course_id') ? 'has-danger' : '' }}">
                            <label class="form-control-label"><span class="text-danger">*</span> Course </label>
                            <select class="form-control" name="course_id" id="course_id">
                                <option value=" ">---- Select Course ----</option>
                                @foreach($courses as $course)
                                    {{--<option value="{{$course->id}}">{{$course->title}}</option>--}}
                                    <option value="{{$course->id}}" {{($course->id == $cardItem->card->subject->subjectGroup->course_id) ? 'selected' : ''}}>{{$course->title}}</option>
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
                    {{--<div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                        <div class="form-group  m-form__group {{ $errors->has('subject_id') ? 'has-danger' : '' }}">
                            <label class="form-control-label"><span class="text-danger">*</span> Subject </label>
                            <select class="form-control m-bootstrap-select m_selectpicker" data-live-search="true" name="subject_id" id="subject_id">
                                <option value="">---- Select ----</option>
                                {!! select($subjects, old('subject_id', $cardItem->card->subject_id)) !!}
                            </select>
                            @if ($errors->has('subject_id'))
                                <div class="form-control-feedback">{{ $errors->first('subject_id') }}</div>
                            @endif
                        </div>
                    </div>--}}
                    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                        <div class="form-group  m-form__group {{ $errors->has('subject_id') ? 'has-danger' : '' }}">
                            <label class="form-control-label"><span class="text-danger">*</span> Subject </label>
                            <select class="form-control m-input" name="subject_id" id="subject_id">
                                <option value=" ">---- Select Subject ----</option>
                            </select>
                        </div>
                    </div>

                    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                        <div class="form-group  m-form__group {{ $errors->has('card_id') ? 'has-danger' : '' }}">
                            <label class="form-control-label"><span class="text-danger">*</span> Card </label>
                            <select class="form-control" name="card_id" id="card_id">
                                <option value="-1">---- Select ----</option>
                            </select>
                            @if ($errors->has('card_id'))
                                <div class="form-control-feedback">{{ $errors->first('card_id') }}</div>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                        <div class="form-group  m-form__group">
                            <label class="form-control-label"> Select Status </label>
                            <select class="form-control m-input " name="status">
                                <option value="1" {{ $cardItem->status == 1  ? 'selected' : '' }}>Active</option>
                                <option value="0" {{ $cardItem->status == 0  ? 'selected' : '' }}>Inactive</option>
                            </select>
                        </div>
                    </div>
                </div>

            </div>
            <div class="m-portlet__foot m-portlet__foot--fit">
                <div class="m-form__actions text-center">
                    <a href="{{ route('cardItems.index') }}" class="btn btn-outline-brand"><i class="fa fa-times"></i> Cancel</a>
                    <button type="submit" class="btn btn-success"><i class="fa fa-save"></i> Save</button>
                </div>
            </div>
        </form>

        <!--end::Form-->
    </div>
@endsection

@push('scripts')
    <script>

        var baseUrl = '{!! url('/') !!}/';
        var subjectGroupId = '{{$cardItem->card->subject->subject_group_id}}';
        var subjectId = '{{$cardItem->card->subject_id}}';

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
                        //var subjectId = '{{$cardItem->card->subject_id}}';
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


        //get item by subject id
        var selectedCard = '{{$cardItem->card_id}}';


        $('#subject_id').change(function (e) {
            e.preventDefault();

            if ($.trim($(this).val()).length != 0){
                selectedSubject = $(this).val()
            } else{
                selectedSubject = subjectId;
            }

            $.get(baseUrl+'admin/cards/subjects/'+selectedSubject,{},function (response) {
                $("#card_id").html('<option value="">--Select Card--</option>');
                if (response.data.length > 0){
                    for (i in response.data){
                        card = response.data[i];
                        selected = (selectedCard == card.id) ? 'selected' : '';
                        $("#card_id").append('<option value="' + card.id + '" '+selected+'>' + card.title + '</option>');
                    }
                }
                $('.m_selectpicker').selectpicker('refresh');
            })
        });

        if (subjectId > 0){
            $('#subject_id').trigger('change');
        }


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
                },
                card_id: {
                    required: true,
                    min: 1
                },
                'title': {
                    required: true,
                },
                serial_number: {
                    required: true,
                    remote: {
                        url: "{{route('check.ItemSerialNumber.exist')}}",
                        type: "post",
                        data: {
                            serial_number: function() {
                                return $( "#serial_number" ).val();
                            },
                            _token: "{{ csrf_token() }}",
                            id: "{{ $cardItem->id }}",
                            cardId: "{{ $cardItem->card_id }}",
                        }
                    }
                }
            },
            messages: {
                serial_number:{
                    remote: 'Item serial number must be unique under a card'
                }
            }
        });

    </script>
@endpush
