@extends('layouts.default')

@push('style')
    <style>
        .img-fluid {
            max-height: 278px;
            max-height: 23rem;
        }
    </style>
@endpush

@section('content')
    <div class="m-portlet m-portlet--tab">
        <div class="m-portlet__head">
            <div class="m-portlet__head-caption">
                <div class="m-portlet__head-title">
                    <h3 class="m-portlet__head-text">
                        Edit User
                    </h3>
                </div>
            </div>
            <div class="m-portlet__head-tools">
                    <a href="{{ url('admin/users') }}" class="btn btn-primary m-btn m-btn--icon"><i class="fa fa-users pr-2"></i>Users</a>
            </div>
        </div>

        <!--begin::Form-->
        <form class="m-form m-form--fit m-form--label-align-right" id="nemc-general-form" action="{{ url('admin/users/'.$user->id) }}" method="post">
            @csrf
            @method('PUT')
            <input type="hidden" name="id" value="{{ $user->id }}"/>
            <div class="m-portlet__body">
                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                        <div class="form-group  m-form__group {{ $errors->has('first_name') ? 'has-danger' : '' }}">
                            <label class="form-control-label"><span class="text-danger">*</span> First Name </label>
                            <input type="text" class="form-control m-input" name="first_name" value="{{ old('first_name', $user->first_name) }}" placeholder="First Name"/>
                            @if ($errors->has('first_name'))
                                <div class="form-control-feedback">{{ $errors->first('first_name') }}</div>
                            @endif
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                        <div class="form-group  m-form__group">
                            <label class="form-control-label">Last Name </label>
                            <input type="text" class="form-control m-input" name="last_name" value="{{ old('last_name', $user->last_name) }}" placeholder="Last Name"/>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                        <div class="form-group m-form__group {{ $errors->has('user_group_id') ? 'has-danger' : '' }}">
                            <label class="form-control-label"><span class="text-danger">*</span> User Group </label>
                            <select class="form-control m-input {{ $errors->has('user_group_id') ? ' is-invalid' : '' }}" name="user_group_id">
                                <option value="">---- Select ----</option>
                                {!! select($userGroups, old('user_group_id', $user->user_group_id)) !!}
                            </select>
                            @if ($errors->has('user_group_id'))
                                <div class="form-control-feedback">{{ $errors->first('user_group_id') }}</div>
                            @endif
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                        <div class="form-group m-form__group {{ $errors->has('user_id') ? 'has-danger' : '' }}">
                            <label class="form-control-label"><span class="text-danger">*</span> User ID </label>
                            <input type="text" class="form-control md-input" name="user_id" id="user_id" value="{{ old('user_id', $user->user_id) }}" placeholder="User ID" />
                            @if ($errors->has('user_id'))
                                <div class="form-control-feedback">{{ $errors->first('user_id') }}</div>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                        <div class="form-group m-form__group {{ $errors->has('department_id') ? 'has-danger' : '' }}">
                            <label class="form-control-label"><span class="text-danger">*</span> Department </label>
                            <select class="form-control m-input m-bootstrap-select m_selectpicker" name="department_id" data-live-search="true">
                                <option value="">---- Select ----</option>
                                @if(!empty($user->adminUser))
                                    {!! select($departments, old('department_id', $user->adminUser->department_id)) !!}
                                    @else
                                    {!! select($departments, old('department_id')) !!}
                                @endif
                            </select>
                            @if ($errors->has('department_id'))
                                <div class="form-control-feedback">{{ $errors->first('department_id') }}</div>
                            @endif
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                        <div class="form-group m-form__group {{ $errors->has('designation_id') ? 'has-danger' : '' }}">
                            <label class="form-control-label"><span class="text-danger">*</span> Designaation </label>
                            <select class="form-control m-input m-bootstrap-select m_selectpicker" name="designation_id" data-live-search="true">
                                <option value="">---- Select ----</option>
                                @if(!empty($user->adminUser))
                                    {!! select($designations, old('designation_id', $user->adminUser->designation_id)) !!}
                                @else
                                    {!! select($designations, old('designation_id')) !!}
                                @endif

                            </select>
                            @if ($errors->has('designation_id'))
                                <div class="form-control-feedback">{{ $errors->first('designation_id') }}</div>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                        <div class="form-group m-form__group">
                            <label class="form-control-label">Email </label>
                            <input type="text" class="form-control md-input" name="email" id="email" value="{{ old('email', $user->email) }}" placeholder="Email"/>
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                        <div class="form-group m-form__group">
                            <label class="form-control-label"> Phone </label>
                            @if($user->adminUser)
                                <input type="number" class="form-control md-input" name="phone_number" value="{{ old('phone_number', $user->adminUser->phone) }}" placeholder="Phone"/>
                            @else
                                <input type="number" class="form-control md-input" name="phone_number" value="{{old('phone_number')}}" placeholder="Phone"/>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                        <div class="form-group m-form__group {{ $errors->has('password') ? 'has-danger' : '' }}">
                            <label class="form-control-label">Password </label>
                            <input type="password" class="form-control md-input" name="password" placeholder="Password" autocomplete="new-password"/>
                            @if ($errors->has('password'))
                                <div class="form-control-feedback">{{ $errors->first('password') }}</div>
                            @endif
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                        <div class="form-group  m-form__group {{ $errors->has('password_confirmation') ? 'has-danger' : '' }}">
                            <label class="form-control-label">Confirm Password </label>
                            <input type="password" class="form-control  m-input" name="password_confirmation" placeholder="Confirm Password"/>
                            @if ($errors->has('password_confirmation'))
                                <div class="form-control-feedback">{{ $errors->first('password_confirmation') }}</div>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                        <div class="form-group m-form__group">
                            <label class="form-control-label">Course Name</label>
                            <select class="form-control m-input" name="course_id">
                                <option value="">---- Select Course----</option>
                                @foreach($courses as $course)
                                    @if($user->adminUser)
                                        <option value="{{$course->id}}" {{$course->id == $user->adminUser->course_id ? 'selected' : ' '}}>{{$course->title}}</option>
                                    @else
                                        <option value="{{$course->id}}">{{$course->title}}</option>
                                    @endif
                                @endforeach

                            </select>
                        </div>

                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                        <div class="form-group  m-form__group">
                            <label class="form-control-label">Select Status </label>
                            <select class="form-control m-input " name="status">
                                <option value="1" {{ $user->status == 1  ? 'selected' : '' }}>Active</option>
                                <option value="0" {{ $user->status == 0  ? 'selected' : '' }}>Inactive</option>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
                        <div class="form-group  m-form__group">
                            <label class="form-control-label">Address </label>
                            @if($user->adminUser)
                                <textarea class="form-control  m-input" name="address" id="address" cols="30" rows="3" placeholder="Address">{{ old('address', $user->adminUser->address) }}</textarea>
                            @else
                                <textarea class="form-control  m-input" name="address" id="address" cols="30" rows="3" placeholder="Address">{{ old('address')}}</textarea>
                            @endif

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
                        @php $userPhoto = !empty($user->adminUser->photo) ? $user->adminUser->photo : 'assets/global/img/import_placeholder.png'; @endphp
                        <img id="user-image" class="img-fluid" src="{{asset($userPhoto)}}" alt="">
                        <input type="hidden" name="photo" id="user-profile-pic">
                    </div>
                </div>
            </div>
            <div class="m-portlet__foot m-portlet__foot--fit">
                <div class="m-form__actions text-center">
                    <a href="{{ url()->previous() }}" class="btn btn-secondary"><i class="fa fa-times"></i> Cancel</a>
                    <button type="submit" class="btn btn-success"><i class="fa fa-save"></i> Save</button>
                </div>
            </div>
        </form>

        <!--end::Form-->
    </div>
@endsection

@push('scripts')
    <script>

        var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
        var baseUrl = '{!! url('/') !!}/';
        Dropzone.autoDiscover = false;


        $("#attach-image").dropzone({
            paramName: "file",
            params:{type: 'user.photo'},
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

                $('#user-image').attr('src', baseUrl+response.full_path);
                $('#user-profile-pic').val(response.full_path);

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
                    required: true,
                    alphanumeric_special : true,
                    remote: {
                        url: "{{route('check.userId.exist')}}",
                        type: "post",
                        data: {
                            user_id: function() {
                                return $( "#user_id" ).val();
                            },
                            _token: "{{ csrf_token() }}",
                            id: "{{ $user->id }}",
                        }
                    }
                },
                email: {
                    email_not_required: true,
                    remote: {
                        url: "{{route('user.email.unique')}}",
                        type: "post",
                        data: {
                            email: function() {
                                return $( "#email" ).val();
                            },
                            _token: "{{ csrf_token() }}",
                            id: "{{ $user->id }}",
                        }
                    }
                },
            },

            messages: {
                user_id:{
                    remote: 'Username must be unique and this Username Already taken'
                },
                email:{
                    remote: 'Email must be unique and this email Already taken'
                },
            }
        });
    </script>
@endpush


