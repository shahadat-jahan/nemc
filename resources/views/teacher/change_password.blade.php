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
                    <h3 class="m-portlet__head-text"><i class="fa fa-key pr-2"></i>Change Password </h3>
                </div>
            </div>
            <div class="m-portlet__head-tools">
                    <a href="{{ url('admin/teacher') }}" class="btn btn-primary m-btn m-btn--icon"><i class="fas fa-user-tie pr-2"></i>Teachers</a>
            </div>
        </div>

        <!--begin::Form-->
        <form class="m-form m-form--fit m-form--label-align-right"  action="{{ route('teacher.password-change', $teacherId) }}" id="nemc-general-form" method="post">
            @csrf
            <div class="m-portlet__body">
               {{-- <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                        <div class="form-group  m-form__group {{ $errors->has('first_name') ? 'has-danger' : '' }}">
                            <label class="form-control-label"><span class="text-danger">*</span> First Name </label>
                            <input type="text" class="form-control m-input" name="first_name" value="{{ old('first_name') }}" placeholder="First Name"/>
                                @if ($errors->has('first_name'))
                                    <div class="form-control-feedback">{{ $errors->first('first_name') }}</div>
                                @endif
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                        <div class="form-group  m-form__group {{ $errors->has('last_name') ? 'has-danger' : '' }}">
                            <label class="form-control-label"><span class="text-danger">*</span> Last Name </label>
                            <input type="text" class="form-control m-input" name="last_name" value="{{ old('last_name') }}" placeholder="Last Name"/>
                                @if ($errors->has('last_name'))
                                    <div class="form-control-feedback">{{ $errors->first('last_name') }}</div>
                                @endif
                        </div>
                    </div>
                </div>--}}

                <div class="row pl-4 pr-4">
                    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                        <div class="form-group  m-form__group {{ $errors->has('new_password') ? 'has-danger' : '' }}">
                            <label class="form-control-label"><span class="text-danger">*</span> New Password </label>
                            <input type="password" class="form-control m-input" name="new_password" id="new_password" placeholder="Enter New Password"/>
                            @if ($errors->has('new_password'))
                                <div class="form-control-feedback">{{ $errors->first('new_password') }}</div>
                            @endif
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                        <div class="form-group  m-form__group {{ $errors->has('confirm_password') ? 'has-danger' : '' }}">
                            <label class="form-control-label"><span class="text-danger">*</span> Confirm Password </label>
                            <input type="password" class="form-control m-input" name="confirm_password"  placeholder="Confirm New Password"/>
                            @if ($errors->has('confirm_password'))
                                <div class="form-control-feedback">{{ $errors->first('confirm_password') }}</div>
                            @endif
                        </div>
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

            $('#nemc-general-form').validate({
                rules:{
                    new_password: {
                        required: true,
                    },
                    confirm_password: {
                        required: true,
                        equalTo: $('#new_password')
                    }
                }
            });

        });
    </script>
@endpush

