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
                </div>
                <div class="m-portlet__body">
                    <form id="searchForm" role="form" method="get">
                        <div class="form-body">
                            <div class="row">
                                <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 col-xl-6">
                                    <div class="form-group">
                                        <select class="form-control" name="session_id" id="session_id">
                                            <option value="">---- Select Session ----</option>
                                            {!! select($sessions, app()->request->session_id) !!}
                                        </select>
                                    </div>
                                </div>
                                @php $authUser = Auth::guard('web')->user(); @endphp
                                @if($authUser->user_group_id == 7)
                                    <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 col-xl-6">
                                        <div class="form-group">
                                            <!-- Staff - Accounts (MBBS)-->
                                            @if($authUser->adminUser->course_id == 1)
                                                <select class="form-control" name="course_id" id="course_id">
                                                    <option value="">---- Select Course ----</option>
                                                    <option value="1" {{ app()->request->course_id == 1 ? 'selected' : ''}}> MBBS </option>
                                                </select>
                                                <!-- Staff - Accounts (BDS)-->
                                            @elseif($authUser->adminUser->course_id == 2)
                                                <select class="form-control" name="course_id" id="course_id">
                                                    <option value="">---- Select Course ----</option>
                                                    <option value="2" {{ app()->request->course_id == 2 ? 'selected' : ''}}> BDS </option>
                                                </select>
                                                <!-- Staff - Accounts (when no course with user(MBBS and BDS))-->
                                            @else
                                                <select class="form-control" name="course_id" id="course_id">
                                                    <option value="">---- Select Course ----</option>
                                                    {!! select($courses, app()->request->course_id) !!}
                                                </select>

                                            @endif
                                        </div>
                                    </div>
                                @else
                                    <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 col-xl-6">
                                        <div class="form-group">
                                            <select class="form-control" name="course_id" id="course_id">
                                                <option value="">---- Select Course ----</option>
                                                {!! select($courses, Auth::user()->teacher->course_id ?? app()->request->course_id) !!}
                                            </select>
                                        </div>
                                    </div>
                                @endif
                                <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 col-xl-6">
                                    <div class="form-group">
                                        <select class="form-control m-input m-bootstrap-select m_selectpicker" name="student_id" id="student_id" data-live-search="true">
                                            <option value="">---- Select Student ----</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 col-xl-6">
                                    <div class="form-group">
                                        <input type="text" class="form-control m-input" name="student_user_id"
                                               id="student-user-id"
                                               value="{{app()->request->student_user_id}}" placeholder="Student ID">
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 col-xl-6">
                                    <div class="form-group  m-form__group">
                                        <input type="text" class="form-control m-input m_datepicker_1" name="payment_date_start" value="{{request()->payment_date_start}}" placeholder="Payment Start Date" autocomplete="off"/>
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 col-xl-6">
                                    <div class="form-group  m-form__group">
                                        <input type="text" class="form-control m-input m_datepicker_1" name="payment_date_end" value="{{request()->payment_date_end}}" placeholder="Payment End Date" autocomplete="off"/>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
                                    <div class="pull-right search-action-btn">
                                        <button class="btn btn-primary m-btn m-btn--icon"><i class="fa fa-search"></i> Search</button>
                                        <a class="btn btn-default m-btn m-btn--icon"
                                           href="{{url('admin/student_payment')}}"><i
                                                class="fas fa-sync-alt search-reset"></i> Reset</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>

                    <div class="m-section__content">
                        <div class="row">
                           {{-- @if($studentPayments->toArray()->isNotEmpty())--}}
                            @if(!empty($studentPayments))
                            <div class="col-md-12">
                                @if ($studentPayments->isNotEmpty())
                                    <h4 class="text-center mt-4">Fee Info of Student - <b>{{$studentPayments->first()->student->full_name_en}}</b> , Roll No. - <b>{{$studentPayments->first()->student->roll_no}}</b></h4>
                                @else
                                    <h4 class="text-center mt-4">Student Payment Info</h4>
                                @endif
                                <div class="table-responsive">
                                    <table class="table table-bordered">
                                        <thead>
                                        <tr class="text-center">
                                            <th scope="col">Invoice No</th>
                                            <th scope="col">Payment Method</th>
                                            <th scope="col">Bank</th>
                                            <th width="6%" scope="col">Bank Copy</th>
                                            <th scope="col">Amount</th>
                                            <th scope="col">Payment Date</th>
                                            <th scope="col">Remarks</th>
                                            <th scope="col">Status</th>
                                            <th scope="col">Action</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($studentPayments as $studentPayment)
                                        <tr>
                                            <td>{{$studentPayment->invoice_no}}</td>
                                            <td>{{$studentPayment->paymentMethod->title}}</td>
                                            <td>{{!empty($studentPayment->bank->title) ? $studentPayment->bank->title : 'n/a'}}</td>
                                            <td class="text-center">
                                                @if($studentPayment->bank_copy)
                                                    <a href="{{asset('nemc_files/payment/'.$studentPayment->bank_copy)}}"
                                                       target="_blank" download><i class="fas fa-file-download"></i></a>
                                                    @else
                                                    <span>--</span>
                                                @endif
                                            </td>
                                            <td class="text-right">{{formatAmount($studentPayment->totalamount)}}</td>
                                            <td class="text-center">{{!empty($studentPayment->payment_date) ? $studentPayment->payment_date : 'n/a'}}</td>
                                            <td>{{!empty($studentPayment->remarks)? $studentPayment->remarks : 'n/a'}}</td>
                                            <td class="text-center">{!! paymentStatus($studentPayment->status) !!}</td>
                                            <td class="text-center">
		                                @php $invoice_no=!empty($studentPayment->invoice_no) ? $studentPayment->invoice_no :''; @endphp
                                                <a href="{{route('student.payment.view', $studentPayment->id)}}" class="m-portlet__nav-link btn m-btn m-btn--hover-brand m-btn--icon m-btn--icon-only m-btn--pill" title="Edit"><i class="flaticon-eye"></i></a>
                                                <a href="{{route('student.payment.edit', $invoice_no)}}" class="m-portlet__nav-link btn m-btn m-btn--hover-brand m-btn--icon m-btn--icon-only m-btn--pill" title="Edit"><i class="flaticon-edit"></i></a>
                                                <a href="{{url('admin/collect_fee_invoice_pdf/'.$invoice_no.'/yes')}}" target="_blank" class="m-portlet__nav-link btn m-btn m-btn--hover-brand m-btn--icon m-btn--icon-only m-btn--pill" title="Dowanload"><i class="flaticon-download"></i></a>
                                            </td>
                                        </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>
                                <div class="float-right">
                                    {{ $studentPayments->appends(['session_id' => app()->request->session_id, 'course_id' => app()->request->course_id, 'student_id' => app()->request->student_id])->links() }}
                                </div>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

@push('scripts')

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
                $.get('<?php echo e(route('student.info.session.course')); ?>',
                    {courseId: courseId, sessionId: sessionId, _token: "<?php echo e(csrf_token()); ?>"},
                    function (response) {
                    $("#student_id").html('<option value="">---- Select Student ----</option>');
                    for (var i = 0; i < response.length; i++) {
                        selected = (studentId == response[i].id) ? 'selected' : '';
                        $("#student_id").append('<option data-user-id="' + response[i].user.user_id + '" value="' + response[i].id + '" ' + selected + '>' + response[i].full_name_en + ' (' + 'Roll No-' + response[i].roll_no + ')' + '</option>');
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

        $('#student_id').change(function (e) {
            e.preventDefault();

            studentUserId = $('#student_id option:selected').attr('data-user-id');
            $('#student-user-id').val(studentUserId);
        });

        $('#student-user-id').keyup(function (e) {
            e.preventDefault();

            $("#student_id").val('');
            $('.m_selectpicker').selectpicker('refresh');
        });

        if (studentId > 0 && studentUserId == 0) {
            $('#session_id, #course_id').trigger('change');

        } else {
            $('#session_id, #course_id').val('');
        }

        $(document).ready(function() {
            $(".m_datepicker_1").datepicker( {
                todayHighlight: !0,
                orientation: "bottom left",
                format: 'dd/mm/yyyy',
            });

        });

    </script>
@endpush
