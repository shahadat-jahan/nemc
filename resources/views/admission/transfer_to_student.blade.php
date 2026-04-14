@extends('layouts.default')
@section('pageTitle', $pageTitle)

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="m-portlet view-page">
                <div class="m-portlet__head">
                    <div class="m-portlet__head-caption">
                        <div class="m-portlet__head-title">
                            <h3 class="m-portlet__head-text"><i class="fas fa-list-ul fa-md pr-2"></i>Transfer Applicant's Information</h3>
                        </div>
                    </div>
                    <div class="m-portlet__head-tools">
                        <a href="{{ route('admission.index') }}" class="btn btn-primary m-btn m-btn--icon" title="Applicants"><i class="fa fa-list"></i> Applicants</a>
                    </div>
                </div>

                <div class="m-portlet__body">

                    <div class="m-section__content">
                        <div class="row">
                            <div class="col-md-12">
                                <h5 class="text-center">Applicant's Information</h5>
                                <hr>
                            </div>
                            <div class="col-md-12">
                                <div class="card mb-3 m-auto" style="max-width: 540px;">
                                    <div class="row no-gutters">
                                        <div class="col-md-4">
                                            @php $imagePath = !empty($applicant->photo) ? $applicant->photo : getAvatar($applicant->gender); @endphp
                                            <img src="{{asset($imagePath)}}" class="card-img" alt="...">
                                        </div>
                                        <div class="col-md-8">
                                            <div class="card-body">
                                                <h5 class="card-title">Name : {{$applicant->full_name_en}}</h5>
                                                <p class="card-text mb-1">Session: {{$applicant->session->title}}</p>
                                                <p class="card-text mb-1">Course: {{$applicant->course->title}}</p>
                                                <p class="card-text mb-1">Phone & Mobile: {{!empty($applicant->phone) ? $applicant->phone.', ' : ''}}  {{$applicant->mobile}}</p>
                                                <p class="card-text mb-1">Email: <a href="mailto:{{$applicant->email}}">{{!empty($applicant->email) ? $applicant->email : 'n/a'}} </a></p>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                {{--<div class="m-list-search">
                                    <div class="m-list-search__results">
                                        <div class="m-list-search__result-category"> <i class="fa fa-user"></i> Applicant's Information</div>
                                        <div class="row">
                                            <div class="col-md-3">
                                                <div class="m-list-search__result-item text-center">
                                                    @php
                                                    $imagePath = !empty($applicant->photo) ? $applicant->photo : 'assets/global/img/male_avater.png';
                                                    @endphp
                                                    <img src="{{asset($imagePath)}}" class="img-fluid" style="max-width: 6.5rem;" alt="Applicant Image">
                                                    <h6>Name : {{$applicant->full_name_en}}</h6>
                                                </div>
                                            </div>
                                            <div class="col-md-9">
                                                <div class="m-list-search__result-item">
                                                    <span class="m-list-search__result-item-text">Session: {{$applicant->session->title}} </span>
                                                </div>
                                                <div class="m-list-search__result-item">
                                                    <span class="m-list-search__result-item-text">Course: {{$applicant->course->title}} </span>
                                                </div>
                                                <div class="m-list-search__result-item">
                                                    <span class="m-list-search__result-item-text">Phone & Mobile: {{!empty($applicant->phone) ? $applicant->phone.', ' : ''}}  {{$applicant->mobile}}</span>
                                                </div>
                                                <div class="m-list-search__result-item">
                                                    <span class="m-list-search__result-item-text">Email: <a href="mailto:{{$applicant->email}}">{{!empty($applicant->email) ? $applicant->email : 'n/a'}}</a> </span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>--}}
                            </div>
                        </div>
                    </div>

                    <div class="m-section__content">
                        <div class="m-separator m-separator--dashed m-separator--lg"></div>
                        <div class="m-form__heading">
                            <h5 class="m-form__heading-title">Student Information</h5>
                        </div>

                        <form class="m-form m-form--fit m-form--label-align-right" id="nemc-general-form" action="{{ route('admission.transfer.student', [$applicant->id]) }}" method="post">
                            @csrf
                            <input type="hidden" name="session_id" value="{{$applicant->session_id}}">
                            <input type="hidden" name="course_id" value="{{$applicant->course_id}}">
                            <input type="hidden" name="student_category_id" value="{{$applicant->student_category_id}}">
                            <div class="row">
                                <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                                    <div class="form-group  m-form__group {{ $errors->has('student_id') ? 'has-danger' : '' }}">
                                        <label class="form-control-label"><span class="text-danger">*</span> Student ID </label>
                                        <input type="text" class="form-control m-input" name="student_id" value="{{old('student_id', $studentID)}}" placeholder="Student ID" readonly/>
                                        @if ($errors->has('student_id'))
                                            <div class="form-control-feedback">{{ $errors->first('student_id') }}</div>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                                    <div class="form-group  m-form__group {{ $errors->has('roll_no') ? 'has-danger' : '' }}">
                                        <label class="form-control-label"><span class="text-danger">*</span> Roll No </label>
                                        <input type="text" class="form-control m-input" name="roll_no" value="{{old('roll_no', ($studentRoll + 1))}}" placeholder="Roll number" readonly/>
                                        @if ($errors->has('roll_no'))
                                            <div class="form-control-feedback">{{ $errors->first('roll_no') }}</div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                                    <div class="form-group  m-form__group {{ $errors->has('mobile') ? 'has-danger' : '' }}">
                                        <label class="form-control-label"><span class="text-danger">*</span> Mobile </label>
                                        <input type="text" class="form-control m-input" name="mobile" id="mobile" value="{{old('mobile', $applicant->mobile)}}" placeholder="Mobile"/>
                                        @if ($errors->has('mobile'))
                                            <div class="form-control-feedback">{{ $errors->first('mobile') }}</div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                                    <div class="form-group  m-form__group {{ $errors->has('user_id') ? 'has-danger' : '' }}">
                                        <label class="form-control-label"><span class="text-danger">*</span> User ID </label>
                                        <input type="text" class="form-control m-input" name="user_id" value="{{old('user_id', $studentID)}}" placeholder="Student ID" readonly/>
                                        @if ($errors->has('user_id'))
                                            <div class="form-control-feedback">{{ $errors->first('user_id') }}</div>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                                    <div class="form-group  m-form__group {{ $errors->has('password') ? 'has-danger' : '' }}">
                                        <label class="form-control-label"><span class="text-danger">*</span> Password </label>
                                        <input type="password" class="form-control m-input" name="password" placeholder="Password" value="{{old('password', '123456')}}"/>
                                        <span class="m-form__help">Default password: 123456</span>
                                        @if ($errors->has('password'))
                                            <div class="form-control-feedback">{{ $errors->first('password') }}</div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="m-portlet__foot m-portlet__foot--fit">
                                <div class="m-form__actions text-center">
                                    <a href="{{ url('admin/admission') }}" class="btn btn-outline-brand"><i class="fa fa-times"></i> Cancel</a>
                                    <button type="submit" class="btn btn-success"><i class="fa fa-save"></i> Save</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

@push('scripts')
    <script>
        // Add custom validation method for student mobile number
        $.validator.addMethod("validMobile", function(value, element) {
            // Check for at least one non-zero digit and a minimum length of 11 digits
            // Check the student category (you need to replace 'isStudentNormal' with your actual check)
            var isStudentNormal = $('input[name="student_category_id"]').val();  // Replace this with your actual logic to determine the category
            // Define regular expressions based on the student category
            var normalCategoryRegex = /^(?=.*[1-9])[0-9]{11}$/;
            var otherCategoryRegex = /^\+(?:\d{1,3}[-.\s])?\(?\d{1,4}\)?[-.\s]?\d{1,6}[-.\s]?\d{1,10}$/;  // Replace this with your other regex
            // Use the appropriate regex based on the student category
            var regexToUse = isStudentNormal != 2 ? normalCategoryRegex : otherCategoryRegex;
            // Test the value against the selected regex
            return regexToUse.test(value);
        }, "Please enter a valid mobile number.");

        $("#nemc-general-form").validate({
            rules:{
                session_id: {
                    required: true,
                    min: 1
                },
                course_id: {
                    required: true,
                    min: 1
                },
                student_id: {
                    required: true,
                    number:true,
                    remote: {
                        url: "{{route('admission.student_info.unique')}}",
                        type: "post",
                        data: {
                            student_id: function() {
                                return $("#student_id").val();
                            },
                            session_id: function() {
                                return $("#session_id").val();
                            },
                            course_id: function() {
                                return $("#course_id").val();
                            },
                            _token: "{{ csrf_token() }}",
                        }
                    }
                },
                roll_no: {
                    required: true,
                    number:true,
                    remote: {
                        url: "{{route('admission.student_info.unique')}}",
                        type: "post",
                        data: {
                            roll_no: function() {
                                return $("#roll_no").val();
                            },
                            session_id: function() {
                                return $("#session_id").val();
                            },
                            course_id: function() {
                                return $("#course_id").val();
                            },
                            _token: "{{ csrf_token() }}",
                        }
                    }
                },
                user_id: {
                    required: true,
                    remote: {
                        url: "{{route('check.userId.exist')}}",
                        type: "post",
                        data: {
                            user_id: function() {
                                return $("#user_id").val();
                            },
                            _token: "{{ csrf_token() }}",
                        }
                    }
                },
                mobile: {
                    validMobile: true,
                    required: true,
                    noSpace: true,
                    remote: {
                        url: "{{route('student.mobile.unique')}}",
                        type: "post",
                        data: {
                            mobile: function() {
                                return $( "#mobile" ).val();
                            },
                            _token: "{{ csrf_token() }}",
                        }
                    }
                },
            },
            messages: {
                student_id:{
                    remote : 'Value must be unique',
                },
                roll_no:{
                    remote : 'Value must be unique',
                },
                user_id:{
                    remote : 'Value must be unique',
                },
                email:{
                    remote : 'Value must be unique',
                },
                mobile:{
                    remote : 'Mobile must be unique, this mobile number already has been taken',
                },
            },
        })
    </script>
@endpush
