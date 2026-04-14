@extends('layouts.default')
@section('pageTitle', 'Change Password')

@section('content')
    <div class="m-portlet m-portlet--tab">
        <div class="m-portlet__head">
            <div class="m-portlet__head-caption">
                <div class="m-portlet__head-title">
                    <h3 class="m-portlet__head-text"><i class="far fa-edit pr-2"></i>Change Password</h3>
                </div>
            </div>
        </div>

        <!--begin::Form-->
        <form class="m-form m-form--fit m-form--label-align-right"  action="{{ route('student.password-change', $studentId) }}" id="nemc-general-form" method="post">
            @csrf
            <div class="m-portlet__body">

                <div class="row pl-4 pr-4">
                    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                        <div class="form-group  m-form__group {{ $errors->has('new_password') ? 'has-danger' : '' }}">
                            <label class="form-control-label"><span class="text-danger">*</span> New Password </label>
                            <input type="password" class="form-control m-input" name="new_password" id="new_password" placeholder="New Password"/>
                            @if ($errors->has('new_password'))
                                <div class="form-control-feedback">{{ $errors->first('new_password') }}</div>
                            @endif
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                        <div class="form-group  m-form__group {{ $errors->has('confirm_password') ? 'has-danger' : '' }}">
                            <label class="form-control-label"><span class="text-danger">*</span> Confirm Password </label>
                            <input type="password" class="form-control m-input" name="confirm_password"  placeholder="Confirm Password"/>
                            @if ($errors->has('confirm_password'))
                                <div class="form-control-feedback">{{ $errors->first('confirm_password') }}</div>
                            @endif
                        </div>
                    </div>
                </div>

            </div>
            <div class="m-portlet__foot m-portlet__foot--fit">
                <div class="m-form__actions text-center">
                    <a href="{{ url('admin/students') }}" class="btn btn-outline-brand"><i class="fa fa-times"></i> Cancel</a>
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