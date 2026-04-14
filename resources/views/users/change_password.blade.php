@extends('layouts.single-page')

@push('style')
    <style>
        .img-fluid {
            max-height: 278px;
            max-height: 23rem;
        }
        @media (min-width: 1025px){
            .m-stack.m-stack--desktop.m-stack--ver>.m-stack__item.m-stack__item--middle {
                text-align: center;
            }
        }
    </style>
@endpush

@section('content')

    <div class="m-portlet m-portlet--tab">
        <div class="m-portlet__head">
            <div class="m-portlet__head-caption">
                <div class="m-portlet__head-title">
                    <h3 class="m-portlet__head-text">
                        Update Password
                    </h3>
                </div>
            </div>
        </div>




        <!--begin::Form-->

        <br>
        <div class="row">
            <div class="col-sm-6 offset-sm-3">
                <div class="card text-center">
                    <div class="card-body">
                        <form class="m-form m-form--fit m-form--label-align-right"  action="{{ route('user.change-password.post') }}" id="nemc-general-form" method="post">
                            @csrf
                            <div class="m-portlet__body">
                                <div class="row">
                                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
                                        <div class="text-left form-group m-form__group {{ $errors->has('password') ? 'has-danger' : '' }}">
                                            <label class="form-control-label"><span class="text-danger">*</span> Password </label>
                                            <input type="password" class="form-control md-input" name="password" id="password" placeholder="Password" autocomplete="new-password"/>
                                            @if ($errors->has('password'))
                                                <div class="form-control-feedback">{{ $errors->first('password') }}</div>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
                                        <div class="text-left form-group  m-form__group {{ $errors->has('password_confirmation') ? 'has-danger' : '' }}">
                                            <label class="form-control-label"><span class="text-danger">*</span> Confirm Password </label>
                                            <input type="password" class="form-control  m-input" name="password_confirmation" placeholder="Confirm Password"/>
                                            @if ($errors->has('password_confirmation'))
                                                <div class="form-control-feedback">{{ $errors->first('password_confirmation') }}</div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="m-portlet__foot m-portlet__foot--fit">
                                <div class="m-form__actions text-center">
                                    <a href="{{ route('user.cancel-password') }}" class="btn btn-secondary"><i class="fa fa-times"></i> Cancel</a>
                                    <button type="submit" class="btn btn-success"><i class="fa fa-save"></i> Save</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <br>
        <br>
        <!--end::Form-->
    </div>
@endsection

@push('scripts')
    <script>

        $('#nemc-general-form').validate({
            rules:{
                password: {
                    required: true,
                },
                password_confirmation: {
                    required: true,
                    equalTo: "#password"
                }
            }
        });

    </script>
@endpush

