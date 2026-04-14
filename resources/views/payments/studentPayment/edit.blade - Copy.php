@extends('layouts.default')
@section('pageTitle', $pageTitle)

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="m-portlet">
                <div class="m-portlet__head">
                    <div class="m-portlet__head-caption">
                        <div class="m-portlet__head-title">
                            <h3 class="m-portlet__head-text"><i class="fas fa-list-ul fa-md pr-2"></i>{{$pageTitle}}</h3>
                        </div>
                    </div>
                    <div class="m-portlet__head-tools">
                        <a href="{{url()->previous()}}" class="btn btn-primary m-btn m-btn--icon" title="Add New Applicant"><i class="fas fa-undo"></i> Back</a>
                    </div>
                </div>

                <form class="m-form m-form--fit m-form--label-align-right"  action="{{ route('student.payment.update', $studentPayment->id) }}" method="post"
                      id="nemc-general-form" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="m-portlet__body">

                        <div class="row">
                            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                                <div class="form-group  m-form__group {{ $errors->has('session_id') ? 'has-danger' : '' }}">
                                    <label class="form-control-label"><span class="text-danger">*</span> Session </label>
                                    <select class="form-control m-input" name="session_id" id="session_id" disabled>
                                        <option value="">---- Select Session ----</option>
                                        {!! select($sessions, $studentPayment->student->session->id) !!}
                                    </select>
                                    @if ($errors->has('session_id'))
                                        <div class="form-control-feedback">{{ $errors->first('session_id') }}</div>
                                    @endif
                                </div>
                            </div>
                            {{--<div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                                <div class="form-group  m-form__group {{ $errors->has('course_id') ? 'has-danger' : '' }}">
                                    <label class="form-control-label"><span class="text-danger">*</span> Course </label>
                                    <select class="form-control m-input" name="course_id" id="course_id" disabled>
                                        <option value="">---- Select Course ----</option>
                                        {!! select($courses, $studentPayment->student->course->id) !!}
                                    </select>
                                    @if ($errors->has('course_id'))
                                        <div class="form-control-feedback">{{ $errors->first('course_id') }}</div>
                                    @endif
                                </div>
                            </div>--}}

                            @php $authUser = Auth::guard('web')->user(); @endphp
                            @if($authUser->user_group_id == 7)
                                <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 col-xl-6">
                                    <div class="form-group  m-form__group {{ $errors->has('course_id') ? 'has-danger' : '' }}">
                                        <label class="form-control-label"><span class="text-danger">*</span> Course </label>
                                        <!-- Staff - Accounts (MBBS)-->
                                        @if($authUser->adminUser->course_id == 1)
                                            <select class="form-control m-input" name="course_id" id="course_id">
                                                <option value="">---- Select Course ----</option>
                                                <option value="1" {{ $studentPayment->student->course->id == 1 ? 'selected' : ''}}> MBBS </option>
                                            </select>
                                            @if ($errors->has('course_id'))
                                                <div class="form-control-feedback">{{ $errors->first('course_id') }}</div>
                                            @endif
                                            <!-- Staff - Accounts (BDS)-->
                                        @elseif($authUser->adminUser->course_id == 2)
                                            <select class="form-control m-input" name="course_id" id="course_id">
                                                <option value="">---- Select Course ----</option>
                                                <option value="2" {{ $studentPayment->student->course->id == 2 ? 'selected' : ''}}> BDS </option>
                                            </select>
                                            @if ($errors->has('course_id'))
                                                <div class="form-control-feedback">{{ $errors->first('course_id') }}</div>
                                            @endif
                                            <!-- Staff - Accounts (when no course with user(MBBS and BDS))-->
                                        @else
                                            <select class="form-control m-input" name="course_id" id="course_id">
                                                <option value="">---- Select Course ----</option>
                                                {!! select($courses, $studentPayment->student->course->id) !!}
                                            </select>
                                            @if ($errors->has('course_id'))
                                                <div class="form-control-feedback">{{ $errors->first('course_id') }}</div>
                                            @endif

                                        @endif
                                    </div>
                                </div>
                            @else
                                <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                                    <div class="form-group  m-form__group {{ $errors->has('course_id') ? 'has-danger' : '' }}">
                                        <label class="form-control-label"><span class="text-danger">*</span> Course </label>
                                        <select class="form-control m-input" name="course_id" id="course_id" disabled>
                                            <option value="">---- Select Course ----</option>
                                            {!! select($courses, $studentPayment->student->course->id) !!}
                                        </select>
                                        @if ($errors->has('course_id'))
                                            <div class="form-control-feedback">{{ $errors->first('course_id') }}</div>
                                        @endif
                                    </div>
                                </div>
                            @endif
                        </div>
                        <div class="row">
                            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                                <div class="form-group  m-form__group {{ $errors->has('student_id') ? 'has-danger' : '' }}">
                                    <label class="form-control-label"><span class="text-danger">*</span> Student </label>
                                    <input type="text" class="form-control m-input" name="student_id" value="{{ $studentPayment->student->full_name_en }}" disabled/>
                                    @if ($errors->has('student_id'))
                                        <div class="form-control-feedback">{{ $errors->first('student_id') }}</div>
                                    @endif
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                                <div class="form-group  m-form__group {{ $errors->has('payment_type_id') ? 'has-danger' : '' }}">
                                    <label class="form-control-label"><span class="text-danger">*</span> Payment Type </label>
                                    <select class="form-control m-input" name="payment_type_id" id="payment_type_id" disabled>
                                        <option value="">---- Select Payment Type ----</option>
                                        @foreach($paymentTypes as $key => $type)
                                            @if(in_array($key, [1, 3, 4]))
                                                @php
                                                    $paymentTypeId = $studentPayment->studentPaymentDetails->first()->studentFeeDetail->payment_type_id;
                                                @endphp
                                                <option value="{{$key}}" {{($paymentTypeId == $key) ? 'selected' : ''}}>{{$type}}</option>
                                            @endif
                                        @endforeach
                                    </select>


                                    @if ($errors->has('payment_type_id'))
                                        <div class="form-control-feedback">{{ $errors->first('payment_type_id') }}</div>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                                <div class="form-group  m-form__group {{ $errors->has('payment_method_id') ? 'has-danger' : '' }}">
                                    <label class="form-control-label"><span class="text-danger">*</span> Payment Method </label>
                                    <select class="form-control m-input" name="payment_method_id" id="payment_method_id">
                                        <option value="">---- Select Payment Method ----</option>
                                        {!! select($paymentMethods, $studentPayment->paymentMethod->id) !!}
                                    </select>

                                    @if ($errors->has('payment_method_id'))
                                        <div class="form-control-feedback">{{ $errors->first('payment_method_id') }}</div>
                                    @endif
                                </div>
                            </div>

                            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                                <div class="form-group  m-form__group">
                                    <label class="form-control-label">Select Bank</label>
                                    <select class="form-control m-input m-bootstrap-select m_selectpicker" name="bank_id" id="bank_id" data-live-search="true">
                                        <option value="">---- Select Bank ----</option>
                                        @if($studentPayment->bank)
                                        {!! select($banks, $studentPayment->bank->id) !!}
                                        @else
                                        {!! select($banks) !!}
                                        @endif
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                                <div class="form-group m-form__group">
                                    <label for="bankCopy">Bank Copy</label>
                                    <input type="file" class="form-control-file" name="bank_copy_file" id="bankCopy">
                                    <small id="emailHelp" class="form-text text-muted">Excepted file formats-jpeg,jpg,png,pdf,doc,docx and max file size 2 MB</small>
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                                <div class="form-group  m-form__group {{ $errors->has('amount') ? 'has-danger' : '' }}">
                                    <label class="form-control-label"><span class="text-danger">*</span> Amount </label>
                                    
                                    
                                        @if(Auth::guard('web')->check())
                                        @php $authUser = Auth::guard('web')->user(); @endphp
                                            @if($authUser->user_group_id==1 || $authUser->user_group_id==2)
                                                  <input type="number" min="1" class="form-control m-input" name="amount" value="{{ old('amount', $studentPayment->amount) }}"/>
                                                @else
                                                  <input type="number" min="1" class="form-control m-input" name="amount" value="{{ old('amount', $studentPayment->amount) }}" disabled/>
                                            @endif
                                        @endif
                                    
                                    @if ($errors->has('amount'))
                                        <div class="form-control-feedback">{{ $errors->first('amount') }}</div>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                                <div class="form-group  m-form__group">
                                    <label class="form-control-label"><span class="text-danger">*</span> Payment Date </label>
                                    <input type="text" class="form-control m-input m_datepicker_1" name="payment_date" value="{{ old('payment_date', $studentPayment->payment_date) }}" placeholder="Payment Date" readonly/>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
                                <div class="form-group  m-form__group">
                                    <label class="form-control-label">Remarks</label>
                                    <textarea class="form-control m-input" name="remarks" placeholder="Remarks about payment">{{ old('remarks', $studentPayment->remarks) }}</textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="m-portlet__foot m-portlet__foot--fit">
                        <div class="m-form__actions text-center">
                            <a href="{{route('student.payment.list')}}" class="btn btn-outline-brand"><i class="fa fa-times"></i> Cancel</a>
                            <button type="submit" class="btn btn-success"><i class="fa fa-save"></i> Save</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

@endsection

@push('scripts')
    <script>
        //modal form validation
        $.validator.addMethod('filesize', function (value, element, param) {
            if (element.files.length > 0){
                var fileSize = (element.files[0].size / 1024) / 1024;
                return this.optional(element) || (fileSize <= param)
            }else{
                return true;
            }
        }, 'File size must be less than {0} MB');

        $('#nemc-general-form').validate({
            rules:{
                session_id: {
                    required: true,
                    min: 1,
                },
                bank_copy_file: {
                    required: false,
                    extension: "jpeg|jpg|png|pdf|doc|docx",
                    filesize: 2,
                },
            },
        });

        $(document).ready(function() {
            $(".m_datepicker_1").datepicker( {
                todayHighlight: !0,
                orientation: "bottom left",
                format: 'dd/mm/yyyy',
            });

        });

    </script>
@endpush
