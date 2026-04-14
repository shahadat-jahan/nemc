@extends('layouts.default')
@section('pageTitle', $pageTitle)

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="m-portlet">
                <div class="m-portlet__head">
                    <div class="m-portlet__head-caption">
                        <div class="m-portlet__head-title">
                            <h3 class="m-portlet__head-text"><i class="fas fa-list-ul fa-md pr-2"></i>{{$pageTitle}}
                            </h3>
                        </div>
                    </div>
                    <div class="m-portlet__head-tools">
                        <a href="{{ route('student.tuition.fee.list') }}" class="btn btn-primary m-btn m-btn--icon"
                           title="Class Absent Fee"><i class="far fa-credit-card"></i> Student Tuition Fee</a>
                    </div>
                </div>

                <form class="m-form m-form--fit m-form--label-align-right" id="nemc-general-form"
                      action="{{ route('student.tuition.fee.update', $studentFeeInfo->id) }}" method="post"
                      enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="m-portlet__body">

                        <div class="row">
                            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                                <div class="form-group m-form__group">
                                    <label class="form-control-label">Student</label>
                                    <input type="text" class="form-control" name="student_id"
                                           value="{{$studentFeeInfo->student->full_name_en . ' (Roll No-'.$studentFeeInfo->student->roll_no. ')'}}"
                                           id="student_id" disabled>
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                                <div class="form-group m-form__group">
                                    <label class="form-control-label">Fee Title</label>
                                    <input type="text" class="form-control" name="title"
                                           value="{{$studentFeeInfo->title}}" id="title" disabled>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                                <div class="form-group m-form__group">
                                    <label class="form-control-label">Total Amount</label>
                                    <input type="number" class="form-control" name="total_amount"
                                           value="{{$studentFeeInfo->total_amount}}" id="total_amount"
                                           placeholder="Total Amount" disabled>
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                                <div class="form-group m-form__group">
                                    <label class="form-control-label">Payable Amount</label>
                                    <input type="number" class="form-control" name="payable_amount"
                                           value="{{$studentFeeInfo->payable_amount}}" id="payable_amount" disabled>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                                <div class="form-group m-form__group ">
                                    <label class="form-control-label">Due Amount</label>
                                    <input type="number" class="form-control" name="due_amount"
                                           value="{{$studentFeeInfo->due_amount}}" id="due_amount"
                                           placeholder="Total Amount" disabled>
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                                <div class="form-group m-form__group">
                                    <label class="form-control-label">Discount Amount</label>
                                    <input type="number" max="{{abs($studentFeeInfo->payable_amount)}}"
                                           class="form-control" name="request_discount_amount"
                                           value="{{$studentFeeInfo->request_discount_amount}}"
                                           id="request_discount_amount">
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                                <div class="form-group m-form__group ">
                                    <label class="form-control-label">Discount Application File</label>
                                    <input type="file" class="form-control-file" name="discount_application_file"
                                           id="discount_application_file">
                                    <small id="emailHelp" class="form-text text-muted">Excepted file
                                        formats-jpeg,jpg,png,pdf,doc,docx and max file size 2 MB</small>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
                                <div class="form-group m-form__group ">
                                    <label class="form-control-label">Comment on Discount</label>
                                    <textarea class="form-control" name="remarks" id="remarks" rows="3"
                                              placeholder="Comment About Discount">{{$studentFeeInfo->remarks}}</textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="m-portlet__foot m-portlet__foot--fit">
                        <div class="m-form__actions text-center">
                            <a href="{{ route('student.tuition.fee.list') }}" class="btn btn-outline-brand"><i
                                    class="fa fa-times"></i> Cancel</a>
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
        var students = [];

        $("#phase_id").css("pointer-events", "none");

        function makeStudentIdAndUserId(sessionId, courseId) {
            if (courseId > 0 && sessionId > 0) {
                mApp.blockPage({
                    overlayColor: "#000000",
                    type: "loader",
                    state: "primary",
                    message: "Please wait..."
                });

                $.get('<?php echo e(route('student.info.session.course')); ?>', {
                    courseId: courseId, sessionId: sessionId, _token: "<?php echo e(csrf_token()); ?>"
                }, function (response) {
                    students = response;
                    $("#student_id").html('<option value="">---- Select Student ----</option>');
                    for (var i = 0; i < response.length; i++) {
                        selected = (studentId == response[i].id) ? 'selected' : '';
                        $("#student_id").append('<option value="' + response[i].id + '" ' + selected + '>' + response[i].full_name_en + ' (' + 'Roll No-' + response[i].roll_no + ')' + '</option>');
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

        $('#student_id').change(function () {
            //selectedGroups = _.filter(selectedGroups, function(item) { return item.type == 3});
            studentId = $(this).val();
            if (studentId > 0) {
                selectedStudent = _.head(_.filter(students, function (item) {
                    return item.id == studentId
                }));
                $('#phase_id').val(selectedStudent.phase_id);
            }
        })


        //modal form validation
        $.validator.addMethod('filesize', function (value, element, param) {
            if (element.files.length > 0) {
                var fileSize = (element.files[0].size / 1024) / 1024;
                return this.optional(element) || (fileSize <= param)
            } else {
                return true;
            }
        }, 'File size must be less than {0} MB');


        $('#nemc-general-form').validate({
            rules: {
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
                    min: 1
                },
                discount_application_file: {
                    required: true,
                    extension: "jpeg|jpg|png|pdf|doc|docx",
                    filesize: 2,
                },
                request_discount_amount: {
                    required: true
                },
            },
        });

    </script>
@endpush
