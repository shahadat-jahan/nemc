@extends('layouts.login')

@push('style')
    <style>
        .content {
            -webkit-box-shadow: 0px 0px 14px 0px rgba(0,0,0,0.75);
            -moz-box-shadow: 0px 0px 14px 0px rgba(0,0,0,0.75);
            box-shadow: 0px 0px 14px 0px rgba(0,0,0,0.75);
        }
    </style>
@endpush

@section('content')
    <div class="logo">
    </div>
    <div class="content">
        <form class="login-form" action="{{ route('login') }}" method="post">
            @csrf
            <div class="card border-0">
                <div class="logo-container">
                    <img src="{{asset('assets/global/img/logo.jpg')}}" class="card-img-top" alt="...">
                </div>
                <hr style="margin-top: 16px"/>
                <div class="card-body field-container">
                    @if (Session::has('message'))
                        <div class="alert alert-danger text-center">{{ Session::get('message') }}</div>
                    @endif
                    <div class="row">
                        <div class="col-sm-2">
                            <div class="field-icon">
                                <span class="fa-stack fa-2x">
                                  <i class="fas fa-circle fa-stack-2x"></i>
                                  <i class="fas fa-user fa-stack-1x fa-inverse"></i>
                                </span>
                            </div>
                        </div>
                        <div class="col-sm-10">
                            <div class="form-group">
                                <input type="text" class="form-control rounded-field"  autocomplete="off" placeholder="Email / User ID" value="{{old('user_id')}}" name="user_id"/>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-2">
                            <div class="field-icon">
                                <span class="fa-stack fa-2x">
                                  <i class="fas fa-circle fa-stack-2x"></i>
                                  <i class="fas fa-lock fa-stack-1x fa-inverse"></i>
                                </span>
                            </div>
                        </div>
                        <div class="col-sm-10">
                            <div class="form-group">
                                <input type="password" class="form-control rounded-field" autocomplete="off" placeholder="Password" name="password" />
                            </div>
                        </div>
                    </div>
                        <a class="d-flex justify-content-end text-danger" href="{{route('password.request')}}">Forgot Password</a>

                    <div class="row mt-3 mb-4">
                        <div class="col-sm-2">
                            <div class="field-icon">
                                <span class="fa-stack fa-2x">
                                  <i class="fas fa-circle fa-stack-2x"></i>
                                  <i class="fas fa-sign-in-alt fa-stack-1x fa-inverse"></i>
                                </span>
                            </div>
                        </div>
                        <div class="col-sm-10">
                            <button class="btn btn-block rounded-field login-btn-color text-white">Log In</button>
                        </div>
                    </div>

                    <div class="row mt-3 mb-5">
                        <div class="col-sm-2">
                            <div class="field-icon">
                        <span class="fa-stack fa-2x">
                          <i class="fas fa-circle fa-stack-2x"></i>
                          <i class="fas fa-home fa-stack-1x fa-inverse"></i>
                        </span>
                            </div>
                        </div>
                        <div class="col-sm-10">
                            <a href="{{url('/home')}}" role="button" class="btn btn-block rounded-field login-btn-color text-white">Back To Home</a>
                        </div>
                    </div>
                    {{--<div class="row mt-3">
                        <div class="col-sm-2">
                            <div class="field-icon">
                                <img src="{{asset('assets/global/img/forgot-pass.jpg')}}" width="37">
                            </div>
                        </div>
                        <div class="col-sm-10">
                            <p class="mt-3"><span class="text-muted">Forgot password ? </span> <a href="" class="reset-password">Reset Now</a></p>
                        </div>
                    </div>--}}
                </div>
            </div>
        </form>
    </div>


@endsection
