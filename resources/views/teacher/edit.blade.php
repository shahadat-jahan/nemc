@extends('layouts.default')
@section('pageTitle', $pageTitle)

@push('style')
    <style>
        .img-fluid {
            max-height: 278px;
        }
    </style>
@endpush

@section('content')
    <div class="m-portlet m-portlet--tab">
        <div class="m-portlet__head">
            <div class="m-portlet__head-caption">
                <div class="m-portlet__head-title">
                    <h3 class="m-portlet__head-text"><i class="far fa-edit pr-2"></i>Edit Teacher</h3>
                </div>
            </div>
            <div class="m-portlet__head-tools">
                    <a href="{{ url('admin/teacher') }}" class="btn btn-primary m-btn m-btn--icon"><i class="fas fa-user-tie pr-2"></i>Teachers</a>
            </div>
        </div>

        <!--begin::Form-->
        <form class="m-form m-form--fit m-form--label-align-right" id="nemc-general-form" action="{{ url('admin/teacher/' .$teacher->id) }}" method="post">
            @csrf
            @method('PUT')
            <div class="m-portlet__body">
                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                        <div class="form-group  m-form__group {{ $errors->has('first_name') ? 'has-danger' : '' }}">
                            <label class="form-control-label"><span class="text-danger">*</span> First Name </label>
                            <input type="text" class="form-control m-input" name="first_name" value="{{ old('first_name', $teacher->first_name) }}" placeholder="First Name"/>
                            @if ($errors->has('first_name'))
                                <div class="form-control-feedback">{{ $errors->first('first_name') }}</div>
                            @endif
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                        <div class="form-group  m-form__group {{ $errors->has('last_name') ? 'has-danger' : '' }}">
                            <label class="form-control-label"><span class="text-danger">*</span> Last Name </label>
                            <input type="text" class="form-control m-input" name="last_name" value="{{ old('last_name', $teacher->last_name) }}" placeholder="Last Name"/>
                            @if ($errors->has('last_name'))
                                <div class="form-control-feedback">{{ $errors->first('last_name') }}</div>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                        <div class="form-group  m-form__group {{ $errors->has('user_id') ? 'has-danger' : '' }}">
                            <label class="form-control-label"><span class="text-danger">*</span> Username </label>
                            <input type="text" class="form-control m-input" name="user_id" id="user_id" value="{{ $teacher->user->user_id }}" placeholder="Username"/>
                            @if ($errors->has('user_id'))
                                <div class="form-control-feedback">{{ $errors->first('user_id') }}</div>
                            @endif
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                        <div class="form-group  m-form__group">
                            <label class="form-control-label">Current User Group </label>
                            <input type="text" class="form-control m-input" value="{{ $teacher->user->userGroup->group_name }}" placeholder="User Group Nmae" disabled/>
                        </div>
                    </div>
                </div>
                @php
                $groupId = Auth::guard('web')->user()->user_group_id;
                @endphp

                @if($groupId == 1 or $groupId == 2 or $groupId == 12)
                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
                        <div class="form-group m-form__group {{ $errors->has('user_group_id') ? 'has-danger' : '' }}">
                            <label class="form-control-label"><span class="text-danger">*</span> User Group </label>
                            <select class="form-control m-input {{ $errors->has('user_group_id') ? ' is-invalid' : '' }}" name="user_group_id">
                                <option value="">---- Select ----</option>
                                @foreach($userGroups as $userGroup)
                                    <option value="{{$userGroup->id}}" {{$userGroup->id == $teacher->user->user_group_id ? 'selected' : ''}}>{{$userGroup->group_name}}</option>
                                @endforeach
                            </select>
                            @if ($errors->has('user_group_id'))
                                <div class="form-control-feedback">{{ $errors->first('user_group_id') }}</div>
                            @endif
                        </div>
                    </div>
                </div>
                @endif

               {{-- <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                        <div class="form-group  m-form__group {{ $errors->has('user_id') ? 'has-danger' : '' }}">
                            <label class="form-control-label"><span class="text-danger">*</span> Username </label>
                            <input type="text" class="form-control m-input" name="user_id" value="{{ $teacher->user->user_id }}" placeholder="Username"/>
                            @if ($errors->has('user_id'))
                                <div class="form-control-feedback">{{ $errors->first('user_id') }}</div>
                            @endif
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                        <div class="form-group  m-form__group {{ $errors->has('password') ? 'has-danger' : '' }}">
                            <label class="form-control-label"><span class="text-danger">*</span> Password </label>
                            <input type="password" class="form-control m-input" name="password" placeholder="Password" readonly/>
                            @if ($errors->has('password'))
                                <div class="form-control-feedback">{{ $errors->first('password') }}</div>
                            @endif
                        </div>
                    </div>
                </div>--}}
                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                        <div class="form-group  m-form__group {{ $errors->has('department_id') ? 'has-danger' : ''}}">
                            <label class="form-control-label"><span class="text-danger">*</span> Department </label>
                            <select class="form-control m-input m-bootstrap-select m_selectpicker" name="department_id" data-live-search="true">
                                <option value=" ">---- Select Department ----</option>
                                @foreach($departments as $department)
                                    <option value="{{$department->id}}" {{$department->id == $teacher->department_id ? 'selected' : ' '}}>{{$department->title}}</option>
                                @endforeach
                            </select>
                            @if ($errors->has('department_id'))
                                <div class="form-control-feedback">{{ $errors->first('department_id') }}</div>
                            @endif
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                        <div class="form-group  m-form__group {{ $errors->has('designation_id') ? 'has-danger' : ''}}">
                            <label class="form-control-label"><span class="text-danger">*</span> Designation </label>
                            <select class="form-control m-input m-bootstrap-select m_selectpicker" name="designation_id" data-live-search="true">
                                <option value=" ">---- Select Designation ----</option>
                                @foreach($designations as $designation)
                                    {{--<option value="{{$designation->id}}" {{ old('designation_id') == $designation->id ? 'selected' : '' }}>{{$designation->title}}</option>--}}
                                    <option value="{{$designation->id}}" {{$designation->id == $teacher->designation_id ? 'selected' : ' '}}>{{$designation->title}}</option>
                                @endforeach
                            </select>
                            @if ($errors->has('designation_id'))
                                <div class="form-control-feedback">{{ $errors->first('designation_id') }}</div>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                        <div class="form-group  m-form__group {{ $errors->has('dob') ? 'has-danger' : '' }}">
                            <label class="form-control-label"><span class="text-danger">*</span> Date of birth </label>
                            <input type="text" class="form-control m-input m_datepicker_1" name="dob" value="{{ old('dob', $teacher->dob) }}" placeholder="Date of Birth">
                            @if ($errors->has('dob'))
                                <div class="form-control-feedback">{{ $errors->first('dob') }}</div>
                            @endif
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                        <div class="form-group  m-form__group {{ $errors->has('gender') ? 'has-danger' : '' }}">
                            <label class="form-control-label"><span class="text-danger">*</span> Gender </label>
                            <div class="m-radio-inline">
                                <label class="m-radio">
                                    <input type="radio" name="gender" value="male" {{ $teacher->gender == 'male'  ? 'checked' : '' }}> Male
                                    {{--<option value="1" {{ $subject->status == 1  ? 'selected' : '' }}>Active</option>--}}
                                    <span></span>
                                </label>
                                <label class="m-radio">
                                    <input type="radio" name="gender" value="female" {{ $teacher->gender == 'female'  ? 'checked' : '' }}> Female
                                    <span></span>
                                </label>
                                @if ($errors->has('gender'))
                                    <div class="form-control-feedback">{{ $errors->first('gender') }}</div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                        <div class="form-group  m-form__group {{ $errors->has('phone') ? 'has-danger' : '' }}">
                            <label class="form-control-label"><span class="text-danger">*</span> Phone Number </label>
                            <input type="text" class="form-control m-input" name="phone" id="phone" value="{{ old('phone', $teacher->phone) }}" placeholder="Phone Number"/>
                            @if ($errors->has('phone'))
                                <div class="form-control-feedback">{{ $errors->first('phone') }}</div>
                            @endif
                        </div>
                    </div>

                    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                        <div class="m-form__group form-group ">
                            <label for="">Share Phone Number</label>
                            <div class="m-checkbox-list">
                                <label class="m-checkbox">
                                    <input type="checkbox" name="share_phone" value="1" {{ $teacher->share_phone == 1  ? 'checked' : '' }}> Want to share your phone number ?
                                    <span></span>
                                </label>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                        <div class="form-group  m-form__group {{ $errors->has('email') ? 'has-danger' : '' }}">
                            <label class="form-control-label"><span class="text-danger">*</span> Email </label>
                            <input type="text" class="form-control m-input" name="email" id="email" value="{{ old('email', $teacher->email) }}" placeholder="Email Address"/>
                            @if ($errors->has('email'))
                                <div class="form-control-feedback">{{ $errors->first('email') }}</div>
                            @endif
                        </div>
                    </div>

                    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                        <div class="m-form__group form-group ">
                            <label for="">Share Email</label>
                            <div class="m-checkbox-list">
                                <label class="m-checkbox">
                                    <input type="checkbox" name="share_email" value="1" {{ $teacher->share_email == 1  ? 'checked' : '' }}> Want to share your email address ?
                                    <span></span>
                                </label>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
                        <div class="form-group  m-form__group">
                            <label class="form-control-label"> Address </label>
                            <textarea class="form-control m-input" name="address" placeholder="Your Address">{{ old('address', $teacher->address) }}</textarea>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                        <div class="form-group  m-form__group">
                            <label class="form-control-label">Course </label>
                            <select class="form-control m-input" name="course_id">
                                <option value="">---- Select Course----</option>
                                @foreach($courses as $course)
                                    <option value="{{$course->id}}" {{$course->id == $teacher->course_id ? 'selected' : ' '}}>{{$course->title}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                        <div class="form-group  m-form__group">
                            <label class="form-control-label">Select Status </label>
                            <select class="form-control m-input " name="status">
                                <option value="1" {{ $teacher->status == 1  ? 'selected' : '' }}>Active</option>
                                <option value="0" {{ $teacher->status == 0  ? 'selected' : '' }}>Inactive</option>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="m-separator m-separator--dashed m-separator--lg"></div>
                <div class="m-form__heading">
                    <h3 class="m-form__heading-title">Profile Image</h3>
                </div>
                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                        <label class="form-control-label"> Drag n drop file or manually select a file </label>
                        <div class="dropzone" id="attach-image" style="height: 280px"></div>
                        <span class="m-form__help">accepted: jpeg, gif, png</span>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                        <label class="form-control-label"> Preview </label><br>
                        <img id="teacher-image" class="img-fluid" src="{{asset($teacher->photo)}}" alt="">
                        <input type="hidden" name="photo" id="teacher-profile-pic">
                    </div>
                </div>

            </div>
            <div class="m-portlet__foot m-portlet__foot--fit">
                <div class="m-form__actions text-center">
                    <a href="{{ url('admin/teacher') }}" class="btn btn-outline-brand"><i class="fa fa-times"></i> Cancel</a>
                    <button type="submit" class="btn btn-success"><i class="fa fa-save"></i> Save</button>
                </div>
            </div>
        </form>

        <!--end::Form-->
    </div>
@endsection

@push('scripts')
<script>

    $(document).ready(function() {
        $(".m_datepicker_1").datepicker( {
            todayHighlight: !0,
            orientation: "bottom left",
            format: 'dd/mm/yyyy',
            autoClose: true,
        });

    });

    var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
    var baseUrl = '{!! url('/') !!}/';
    Dropzone.autoDiscover = false;


    $("#attach-image").dropzone({
        paramName: "file",
        params:{type: 'teacher.photo'},
        createImageThumbnails: false,
        maxFiles: 1,
        previewTemplate: '<div style="display:none"></div>',
        maxFilesize: 2, // MB
        init: function() {
            this.on("error", function(file, message) {
                alert(message);
                this.removeFile(file);
            });
            this.on("totaluploadprogress", function (progress) {
                $('.progress-row').removeClass('hide');
                $('.img-progress').html(progress + '%');
                // $(".image-upload-bar").width(progress + '%');
            });
        },
        url: "{{route('attachment.upload')}}",
        acceptedFiles: 'image/*',
        headers: {
            'x-csrf-token': CSRF_TOKEN,
        },
        success: function (file, response) {
            this.removeFile(file);

            $('#teacher-image').attr('src', baseUrl+response.full_path);
            $('#teacher-profile-pic').val(response.full_path);

            /*$('#user-image').imgAreaSelect({
                handles: true,
                aspectRatio: "4:3",
                onSelectEnd: function (img, selection) {
                    $('#img-height').val(selection.height);
                    $('#img-width').val(selection.width);
                    $('#img-x1').val(selection.x1);
                    $('#img-x2').val(selection.x2);
                    $('#img-y1').val(selection.y1);
                    $('#img-y2').val(selection.y2);
                    console.log(selection);
                }
            });*/

            sweetAlert('Profile image has been uploaded');

        },
        complete: function (file, response) {
            // $('.progress-row').addClass('hide');
            // $('.img-progress').html('');
            /*$('.progress').fadeOut('3000');
            setTimeout(function () {
                $(".image-upload-bar").width(0 + '%');
            }, 4000);*/

        },
        error: function (file, response) {
            file.previewElement.classList.add("dz-error");
            html = '';
            if(response.errors){
                for(i in response.errors.file){
                    html+= '<li class="error">'+ response.errors.file[i] +'</li>';
                }
            }

            $('#image-errors').html(html);
        }
    });

    $.validator.addMethod("alphanumeric_special", function(value, element) {
        return this.optional(element) || /^[a-zA-Z][a-zA-Z0-9._-]*$/.test(value);
    }, "Letters, numbers, dots, hyphen & underscores only please.");

    //form validation
    $('#nemc-general-form').validate({
        rules:{
            user_id: {
                // required: true,
                alphanumeric_special : true,
                remote: {
                    url: "{{route('teacher.username.unique')}}",
                    type: "post",
                    data: {
                        user_id: function() {
                            return $( "#user_id" ).val();
                        },
                        _token: "{{ csrf_token() }}",
                        id: "{{ $teacher->id }}",
                    }
                }
            },
            phone: {
                // required: true,
                remote: {
                    url: "{{route('teacher.phone.unique')}}",
                    type: "post",
                    data: {
                        phone: function() {
                            return $( "#phone" ).val();
                        },
                        _token: "{{ csrf_token() }}",
                        id: "{{ $teacher->id }}",
                    }
                }
            },
            email: {
                // required: true,
                remote: {
                    url: "{{route('teacher.email.unique')}}",
                    type: "post",
                    data: {
                        email: function() {
                            return $( "#email" ).val();
                        },
                        _token: "{{ csrf_token() }}",
                        id: "{{ $teacher->id }}",
                    }
                }
            },
        },

        messages: {
            user_id:{
                remote: 'Username must be unique and this Username already taken'
            },
            phone:{
                remote: 'Phone must be unique and this phone number already taken'
            },
            email:{
                remote: 'Email must be unique and this email already taken'
            },
        }
    });
</script>
@endpush

