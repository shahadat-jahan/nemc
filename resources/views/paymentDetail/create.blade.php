@extends('layouts.default')
@section('pageTitle', $pageTitle)

@section('content')

    <div class="m-portlet m-portlet--tab">
        <div class="m-portlet__head">
            <div class="m-portlet__head-caption">
                <div class="m-portlet__head-title">
                    <h3 class="m-portlet__head-text"><i class="far fa-plus-square pr-2"></i>Create Payment Detail</h3>
                </div>
            </div>
            <div class="m-portlet__head-tools">
                    <a href="{{ url('admin/payment_detail') }}" class="btn btn-primary m-btn m-btn--icon"><i class="far fa-credit-card pr-2"></i>Payment Details</a>
            </div>
        </div>

        <!--begin::Form-->
        <form class="m-form m-form--fit m-form--label-align-right"  action="{{ url('admin/payment_detail') }}" method="post">
            @csrf
            <div class="m-portlet__body">
                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                        <div class="form-group  m-form__group {{ $errors->has('payment_type_id') ? 'has-danger' : '' }}">
                            <label class="form-control-label"><span class="text-danger">*</span> Payment Type </label>
                            <select class="form-control m-input m-bootstrap-select m_selectpicker" name="payment_type_id" id="payment_type_id" data-live-search="true">
                                <option value=" "> --Select Payment Type-- </option>
                                @foreach($paymentTypes as $paymentType)
                                    <option value="{{$paymentType->id}}" {{ old('payment_type_id') == $paymentType->id ? 'selected' : '' }}>{{$paymentType->title}}</option>
                                @endforeach
                            </select>
                            @if ($errors->has('payment_type_id'))
                                <div class="form-control-feedback">{{ $errors->first('payment_type_id') }}</div>
                            @endif
                        </div>
                    </div>

                    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                        <div class="form-group  m-form__group {{ $errors->has('student_category_id') ? 'has-danger' : '' }}">
                            <label class="form-control-label"><span class="text-danger">*</span> Student Category </label>
                            <select class="form-control m-input m-bootstrap-select m_selectpicker" name="student_category_id" id="student_category_id" data-live-search="true">
                                <option value=" "> --Select Student Category-- </option>
                                @foreach($studentCategories as $studentCategory)
                                    <option value="{{$studentCategory->id}}" {{ old('student_category_id') == $studentCategory->id ? 'selected' : '' }}>{{$studentCategory->title}}</option>
                                @endforeach
                            </select>
                            @if ($errors->has('student_category_id'))
                                <div class="form-control-feedback">{{ $errors->first('student_category_id') }}</div>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                        <div class="form-group  m-form__group {{ $errors->has('session_id') ? 'has-danger' : '' }}">
                            <label class="form-control-label">Session </label>
                            <select class="form-control m-input m-bootstrap-select m_selectpicker" name="session_id" data-live-search="true">
                                <option value=" ">---- Select Session ----</option>
                                @foreach($sessions as $session)
                                    <option value="{{$session->id}}" {{ old('session_id') == $session->id ? 'selected' : '' }}>{{$session->title}}</option>
                                @endforeach
                            </select>
                            @if ($errors->has('session_id'))
                                <div class="form-control-feedback">{{ $errors->first('session_id') }}</div>
                            @endif
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                        <div class="form-group  m-form__group {{ $errors->has('course_id') ? 'has-danger' : '' }}">
                            <label class="form-control-label"><span class="text-danger">*</span> Course </label>
                            <select class="form-control m-input m-bootstrap-select m_selectpicker" name="course_id" id="course_id" data-live-search="true">
                                <option value=" "> --Select Course-- </option>
                                @foreach($courses as $course)
                                    <option value="{{$course->id}}" {{ old('course_id') == $course->id ? 'selected' : '' }}>{{$course->title}}</option>
                                @endforeach
                            </select>
                            @if ($errors->has('course_id'))
                                <div class="form-control-feedback">{{ $errors->first('course_id') }}</div>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                        <div class="form-group  m-form__group {{ $errors->has('amount') ? 'has-danger' : '' }}">
                            <label class="form-control-label"><span class="text-danger">*</span> Amount </label>
                            <input type="text" class="form-control m-input" name="amount" value="{{ old('amount') }}" placeholder="Enter amount"/>
                            @if ($errors->has('amount'))
                                <div class="form-control-feedback">{{ $errors->first('amount') }}</div>
                            @endif
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                        <div class="form-group  m-form__group {{ $errors->has('currency_code') ? 'has-danger' : '' }}">
                            <label class="form-control-label"><span class="text-danger">*</span> Currency :</label>
                            <select class="form-control m-input" name="currency_code">
                                <option value="TK">TK</option>
                                <option value="USD">USD</option>
                            </select>
                            @if ($errors->has('currency_code'))
                                <div class="form-control-feedback">{{ $errors->first('currency_code') }}</div>
                            @endif
                        </div>
                    </div>
                </div>

            </div>


            <div class="m-portlet__foot m-portlet__foot--fit">
                <div class="m-form__actions text-center">
                    <a href="{{ url('admin/payment_detail') }}" class="btn btn-outline-brand"><i class="fa fa-times"></i> Cancel</a>
                    <button type="submit" class="btn btn-success"><i class="fa fa-save"></i> Save</button>
                </div>
            </div>
        </form>

        <!--end::Form-->
    </div>
@endsection
