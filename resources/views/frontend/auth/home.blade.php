@extends('layouts.login')

    <style>
        .title{
            color: #ed3a3f !important;
            font-weight: bold;
        }
        .login-btn-color{
            font-size: 13.2px !important;
            padding: .75rem 1.15rem !important;
        }
    </style>

@section('content')
    <div class="logo">
       {{-- <img src="{{ asset('images/login-logo.png') }}" alt="Logo" />--}}
    </div>
    <div class="content">
        <div class="login-form">
            <div class="card border-0">

                <div class="logo-container">

                    <img src="{{asset('assets/global/img/logo.jpg')}}" class="card-img-top" alt="...">
                </div>
                <hr style="margin-top: 16px"/>
                <div class="card-body field-container">
                    <div class="row mb-4">
                        <div class="col-12">
                            <h4 class="text-center text-uppercase title">Welcome To NEMC</h4>
                        </div>
                    </div>
                    <div class="row mt-3 mb-4">
                        <div class="col-sm-2">
                            <div class="field-icon">
                                <span class="fa-stack fa-2x">
                                  <i class="fas fa-circle fa-stack-2x"></i>
                                  <i class="fas fa-user-friends fa-stack-1x fa-inverse"></i>
                                </span>
                            </div>
                        </div>
                        <div class="col-sm-10">
                            <a href="/login" role="button" class="btn btn-block rounded-field login-btn-color text-white">Log In As Student/Parent</a>
                        </div>
                    </div>
                    <div class="row mt-3 mb-5">
                        <div class="col-sm-2">
                            <div class="field-icon">
                                <span class="fa-stack fa-2x">
                                  <i class="fas fa-circle fa-stack-2x"></i>
                                  <i class="fas fa-user-tie fa-stack-1x fa-inverse"></i>
                                </span>
                            </div>
                        </div>
                        <div class="col-sm-10">
                            <a href="/admin/login" role="button" class="btn btn-block rounded-field login-btn-color text-white">Log In As Admin/Teacher/Staff</a>
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
        </div>
    </div>

   {{-- <div class="copyright"> 2018 &copy; Vivacom Solutions Ltd. </div>--}}

@endsection
