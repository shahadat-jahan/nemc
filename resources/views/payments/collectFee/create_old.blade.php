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
                        <a id="student-fee-detail-route" target="_blank" class="btn btn-primary m-btn m-btn--icon text-white mr-2 d-none" title="Show detail of current student fee"><i class="flaticon-eye"></i>View Student Fee Details</a>
                        <a href="{{url()->previous()}}" class="btn btn-primary m-btn m-btn--icon" title="Add New Applicant"><i class="fas fa-undo"></i> Back</a>
                    </div>
                </div>

                <form class="m-form m-form--fit m-form--label-align-right"  action="{{ route('student.fee.collect.save') }}" method="post"
                      id="nemc-general-form" enctype="multipart/form-data">
                    @csrf
                    <div class="m-portlet__body">
                        <div class="row">
                            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                                <div class="form-group  m-form__group {{ $errors->has('session_id') ? 'has-danger' : '' }}">
                                    <label class="form-control-label"><span class="text-danger">*</span> Session </label>
                                    <select class="form-control m-input" name="session_id" id="session_id">
                                        <option value="">---- Select Session ----</option>
                                        {!! select($sessions) !!}
                                    </select>
                                    @if ($errors->has('session_id'))
                                        <div class="form-control-feedback">{{ $errors->first('session_id') }}</div>
                                    @endif
                                </div>
                            </div>
                            {{--<div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                                <div class="form-group  m-form__group {{ $errors->has('course_id') ? 'has-danger' : '' }}">
                                    <label class="form-control-label"><span class="text-danger">*</span> Course </label>
                                    <select class="form-control m-input" name="course_id" id="course_id">
                                        <option value="">---- Select Course ----</option>
                                        {!! select($courses) !!}
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
                                                <option value="1" {{ app()->request->course_id == 1 ? 'selected' : ''}}> MBBS </option>
                                            </select>
                                            @if ($errors->has('course_id'))
                                                <div class="form-control-feedback">{{ $errors->first('course_id') }}</div>
                                            @endif
                                            <!-- Staff - Accounts (BDS)-->
                                        @elseif($authUser->adminUser->course_id == 2)
                                            <select class="form-control m-input" name="course_id" id="course_id">
                                                <option value="">---- Select Course ----</option>
                                                <option value="2" {{ app()->request->course_id == 2 ? 'selected' : ''}}> BDS </option>
                                            </select>
                                            @if ($errors->has('course_id'))
                                                <div class="form-control-feedback">{{ $errors->first('course_id') }}</div>
                                            @endif
                                            <!-- Staff - Accounts (when no course with user(MBBS and BDS))-->
                                        @else
                                            <select class="form-control m-input" name="course_id" id="course_id">
                                                <option value="">---- Select Course ----</option>
                                                {!! select($courses, app()->request->course_id) !!}
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
                                        <select class="form-control m-input" name="course_id" id="course_id">
                                            <option value="">---- Select Course ----</option>
                                            {!! select($courses) !!}
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
                                    <select class="form-control m-input m-bootstrap-select m_selectpicker" name="student_id" id="student_id" data-live-search="true">
                                        <option value="">---- Select Student ----</option>
                                    </select>
                                    @if ($errors->has('student_id'))
                                        <div class="form-control-feedback">{{ $errors->first('student_id') }}</div>
                                    @endif
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                                <div class="form-group  m-form__group">
                                    <label class="form-control-label"> Student Roll</label>
                                    <input class="form-control m-input" id="student-roll-no" value="After selecting student, roll number will shown here" style="height: 33px;" readonly>
                                </div>
                               {{-- <div class="form-group  m-form__group">
                                    <label class="form-control-label"><span class="text-danger">*</span> Payment Date </label>
                                    <input type="text" class="form-control m-input" id="student-roll-no" value=""  readonly/>
                                </div>--}}
                            </div>


                        </div>

                        <div class="row">
                            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                                <div class="form-group  m-form__group {{ $errors->has('payment_type_id') ? 'has-danger' : '' }}">
                                    <label class="form-control-label"><span class="text-danger">*</span> Payment Type </label>
                                    <select class="form-control m-input" name="payment_type_id" id="payment_type_id">
                                        <option value="">---- Select Payment Type ----</option>
                                        @foreach($paymentTypes as $key => $type)
                                            @if(in_array($key, [1, 3, 4]))
                                                <option value="{{$key}}" selected>{{$type}}</option>
                                            @endif
                                        @endforeach
                                    </select>

                                    @if ($errors->has('payment_type_id'))
                                        <div class="form-control-feedback">{{ $errors->first('payment_type_id') }}</div>
                                    @endif
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                                <div class="form-group  m-form__group {{ $errors->has('payment_method_id') ? 'has-danger' : '' }}">
                                    <label class="form-control-label"><span class="text-danger">*</span> Payment Method </label>
                                    <select class="form-control m-input" name="payment_method_id" id="payment_method_id">
                                        <option value="">---- Select Payment Method ----</option>
                                        {!! select($paymentMethods, 2) !!}
                                    </select>

                                    @if ($errors->has('payment_method_id'))
                                        <div class="form-control-feedback">{{ $errors->first('payment_method_id') }}</div>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <div class="row">

                            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                                <div class="form-group  m-form__group">
                                    <label class="form-control-label">Select Bank</label>
                                    <select class="form-control m-input m-bootstrap-select m_selectpicker" name="bank_id" id="bank_id" data-live-search="true">
                                        <option value="">---- Select Bank ----</option>
                                        {!! select($banks, 8) !!}
                                    </select>
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                                <div class="form-group m-form__group">
                                    <label for="bankCopy">Bank Copy</label>
                                    <input type="file" class="form-control-file" name="bank_copy" id="bankCopy">
                                    <small id="emailHelp" class="form-text text-muted">Bank copy is not require if you chose payment method "Cash On NEMC"</small>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                                <div class="form-group  m-form__group {{ $errors->has('amount') ? 'has-danger' : '' }}">
                                    <label class="form-control-label"><span class="text-danger">*</span> Amount </label>
                                    <input type="number" min="1" class="form-control m-input" name="amount" value="{{ old('amount') }}" placeholder="Amount"/>
                                    @if ($errors->has('amount'))
                                        <div class="form-control-feedback">{{ $errors->first('amount') }}</div>
                                    @endif
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                                <div class="form-group  m-form__group">
                                    <label class="form-control-label"><span class="text-danger">*</span> Payment Date </label>
                                    <input type="text" class="form-control m-input m_datepicker_1" name="payment_date" value="{{ old('payment_date') }}" placeholder="Payment Date" readonly/>
                                </div>
                            </div>
                        </div>


                        <div class="row">
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
                                <div class="form-group  m-form__group">
                                    <label class="form-control-label">Remarks</label>
                                    <textarea class="form-control m-input" name="remarks" placeholder="Remarks about payment">{{ old('remarks') }}</textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="m-portlet__foot m-portlet__foot--fit">
                        <div class="m-form__actions text-center">
                            <a href="" class="btn btn-outline-brand"><i class="fa fa-times"></i> Cancel</a>
                            <button type="submit" class="btn btn-success"><i class="fa fa-save"></i> Save</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

@endsection

@push('scripts')

    <script src="//cdnjs.cloudflare.com/ajax/libs/lodash.js/4.17.11/lodash.min.js" type="text/javascript"></script>

    <script>

        var baseUrl = '{!! url('/') !!}/';
        var studentId = '<?php echo app()->request->student_id; ?>';

        function makeStudentIdAndUserId(sessionId, courseId){
            if (courseId > 0 && sessionId > 0){
                mApp.blockPage({
                    overlayColor: "#000000",
                    type: "loader",
                    state: "primary",
                    message: "Please wait..."
                });

                $.get('<?php echo e(route('student.info.session.course')); ?>', {
                    courseId: courseId, sessionId: sessionId, _token: "<?php echo e(csrf_token()); ?>"
                }, function (response) {
                    $("#student_id").html('<option value="">---- Select Student ----</option>');
                    for (var i = 0; i < response.length; i++) {
                        selected = (studentId == response[i].id) ? 'selected' : '';
                        $("#student_id").append('<option value="' + response[i].id + '" '+ selected +'>' + response[i].full_name_en + ' (' +'Roll No-'+response[i].roll_no + ')'+ '</option>');
                    }
                    $('.m_selectpicker').selectpicker('refresh');
                    mApp.unblockPage();
                });
            }
        }

        $('#session_id, #course_id').change(function (e) {
            e.preventDefault();
            sessionId = $('#session_id').val();
            courseId = $('#course_id').val();
            makeStudentIdAndUserId(sessionId, courseId);
        });

        //get student roll number by student id
        $('#student_id').change(function () {
            studentId = $('#student_id').val();
            if(studentId > 0){
                $.get('<?php echo e(route('get.single.student.roll')); ?>', {
                    studentId: studentId, _token: "<?php echo e(csrf_token()); ?>"
                }, function (response) {
                    studentRollNumber = response;
                    $("#student-roll-no").val(studentRollNumber);
                });
            }
        });


        //configure fee details route
        $('#student_id, #payment_type_id').change(function () {
            studentId = $('#student_id').val();
            paymentTypeId = $('#payment_type_id').val();
            //route name
            urlRouteName = '{{route('get.single.student.fee')}}';
            if(studentId > 0 && paymentTypeId > 0){
                //generate route with student and payment type
                routeWithIds = urlRouteName +'?student_id='+studentId+ '&payment_type_id='+paymentTypeId;

                //set url to href
                $("#student-fee-detail-route").attr("href", routeWithIds);
                //show button when select student and payment type
                $("#student-fee-detail-route").removeClass("d-none");
            }
        });

        // form validations
        $('#nemc-general-form').validate({
            rules:{
                session_id: {
                    required: true,
                    min: 1,
                },
                course_id: {
                    required: true,
                    min: 1
                },
                student_id: {
                    required: true,
                    min: 1,
                },
                payment_type_id: {
                    required: true,
                    min: 1,
                },
                amount: {
                    required: true,
                    min: 1,
                },
                payment_date: {
                    required: true,
                },
                bank_id: {
                    required: function(element){
                        return ($("#payment_method_id").val() == 2 || $("#payment_method_id").val() == 3);
                    },
                },
               /* bank_copy: {
                    required: function(element){
                        return ($("#payment_method_id").val() == 2 || $("#payment_method_id").val() == 3);
                    },
                    extension: "jpeg|jpg|png|pdf|doc|docx"
                }*/
            },
            messages: {
                student_id: {
                    remote: 'Payment already generated'
                },
                bank_id:{
                    required: 'Bank is required for cash on bank or check payment'
                },
               /* bank_copy:{
                    required: 'Bank copy is required for cash on bank or check payment',
                    extension: 'Accepted files: jpeg, png, pdf, doc, docx',
                }*/
            }
        });

        $(document).ready(function() {
            $(".m_datepicker_1").datepicker( {
                todayHighlight: !0,
                orientation: "bottom left",
                format: 'dd/mm/yyyy',
                autoClose: true,
            });

        });

    </script>
@endpush
