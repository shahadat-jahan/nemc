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
                </div>

                <div class="m-portlet__body">
                    <form role="form" method="get" action="{{route('get.student.fee')}}">
                        <div class="form-body">
                            <div class="row">
                                <div class="col-xs-12 col-sm-6 col-md-4 col-lg-4 col-xl-4">
                                    <div class="form-group">
                                        <select class="form-control" name="session_id" id="session_id">
                                            <option value="">---- Select Session ----</option>
                                            @foreach($sessions as $session)
                                                <option
                                                    value="{{$session->id}}" {{ app()->request->session_id == $session->id ? 'selected' : '' }}>{{$session->title}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-6 col-md-4 col-lg-4 col-xl-4">
                                    <div class="form-group">
                                        <select class="form-control" name="course_id" id="course_id">
                                            <option value="">---- Select Course ----</option>
                                            @foreach($courses as $course)
                                                <option
                                                    value="{{$course->id}}" {{ app()->request->course_id == $course->id ? 'selected' : '' }}>{{$course->title}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-6 col-md-4 col-lg-4 col-xl-4">
                                    <div class="form-group">
                                        <select class="form-control m-input m-bootstrap-select m_selectpicker"
                                                name="student_id" id="student_id" data-live-search="true">
                                            <option value="">---- Select Student ----</option>
                                        </select>
                                    </div>
                                </div>

                            </div>

                            <div class="row">
                                <div class="col-md-12">
                                    <div class="pull-right search-action-btn">
                                        <button class="btn btn-primary m-btn m-btn--icon"><i class="fa fa-search"></i>
                                            Search
                                        </button>
                                        <button type="reset" class="btn btn-default reset"><i
                                                class="fas fa-sync-alt search-reset"></i> Reset
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                    <br>

                    <div class="m-section__content">
                        <div class="row">
                            <div class="col-md-12">
                                @if(isset($studentFees))
                                    <div class="table-responsive">
                                        <table class="table">
                                            <thead>
                                            <tr>
                                                <th scope="col">Id</th>
                                                <th scope="col">Student Name</th>
                                                <th scope="col">Title</th>
                                                <th scope="col">Payable Amount</th>
                                                <th scope="col">Paid Amount</th>
                                                <th scope="col">Remarks</th>
                                                <th scope="col">Status</th>
                                                <th scope="col">Action</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            @foreach($studentFees as $studentFee)
                                                <tr>
                                                    <th scope="row">{{$studentFee->id}}</th>
                                                    <td>{{$studentFee->student->full_name_en}}</td>
                                                    <td>{{$studentFee->title}}</td>
                                                    <td>{{$studentFee->payable_amount}}</td>
                                                    <td>{{$studentFee->paid_amount}}</td>
                                                    <td>{{$studentFee->remarks}}</td>
                                                    <td>
                                                        {!! paymentStatus($studentFee->status) !!}
                                                    </td>
                                                    <td>
                                                        @php $feeDetails = $studentFee->feeDetails->where('payment_type_id', 1); @endphp
                                                        @if(empty($feeDetails->toArray()))
                                                            <a href="{{route('student.fee.collect.form', [$studentFee->id])}}"
                                                               class="m-portlet__nav-link btn m-btn m-btn--hover-brand m-btn--icon m-btn--icon-only m-btn--pill"
                                                               title="Collect payment"><i
                                                                    class="fas fa-money-bill-alt"></i></a>
                                                        @endif
                                                        <a href="{{route('student.fee.detail', [$studentFee->id])}}"
                                                           class="m-portlet__nav-link btn m-btn m-btn--hover-brand m-btn--icon m-btn--icon-only m-btn--pill"
                                                           title="View"><i class="flaticon-eye"></i></a>
                                                    </td>
                                                </tr>
                                            @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
@push('scripts')

    <script src="//cdnjs.cloudflare.com/ajax/libs/lodash.js/4.17.11/lodash.min.js" type="text/javascript"></script>

    <script>

        var baseUrl = '{!! url('/') !!}/';
        var studentId = '<?php echo app()->request->student_id; ?>';

        function makeStudentIdAndUserId(sessionId, courseId) {


            if (courseId > 0 && sessionId > 0) {
                $.get('<?php echo e(route('student.info.session.course')); ?>', {
                    courseId: courseId,
                    sessionId: sessionId,
                    _token: "<?php echo e(csrf_token()); ?>"
                }, function (response) {
                    $("#student_id").html('<option value="">---- Select Student ----</option>');
                    for (var i = 0; i < response.length; i++) {
                        selected = (studentId == response[i].id) ? 'selected' : '';
                        $("#student_id").append('<option value="' + response[i].id + '" ' + selected + '>' + response[i].full_name_en + '</option>');
                    }
                    $('.m_selectpicker').selectpicker('refresh');
                });
            }
        }

        $('#session_id, #course_id').change(function (e) {
            e.preventDefault();
            sessionId = $('#session_id').val();
            courseId = $('#course_id').val();
            makeStudentIdAndUserId(sessionId, courseId);
        });
        if (studentId > 0) {
            $('#session_id, #course_id').trigger('change');
        }


    </script>
@endpush
