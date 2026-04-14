@extends('frontend.layouts.default')
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
                    {{--<div class="m-portlet__head-tools">
                        @if (hasPermission('collect_fee/create'))
                            <a href="{{ route('student.fee.collect.form') }}" class="btn btn-primary m-btn m-btn--icon" title="Add New Applicant"><i class="fa fa-plus"></i> Collect Fee</a>
                        @endif
                    </div>--}}
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
                                @php $authUser = Auth::guard('student_parent')->user(); @endphp
                                @if($authUser->user_group_id == 5)
                                    <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 col-xl-6">
                                        <div class="form-group">
                                            <!-- Staff - Accounts (MBBS)-->
                                            @if($authUser->student->course_id == 1)
                                                <select class="form-control" name="course_id" id="course_id">
                                                    <option value="">---- Select Course ----</option>
                                                    <option value="1" {{ app()->request->course_id == 1 ? 'selected' : ''}}> MBBS </option>
                                                </select>
                                                <!-- Staff - Accounts (BDS)-->
                                            @elseif($authUser->student->course_id == 2)
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
                                    @elseif($authUser->user_group_id == 5)
                                    <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 col-xl-6">
                                        <div class="form-group">
                                            <!-- Staff - Accounts (MBBS)-->
                                            @if($authUser->parent->students->first()->course_id == 1)
                                                <select class="form-control" name="course_id" id="course_id">
                                                    <option value="">---- Select Course ----</option>
                                                    <option value="1" {{ app()->request->course_id == 1 ? 'selected' : ''}}> MBBS </option>
                                                </select>
                                                <!-- Staff - Accounts (BDS)-->
                                            @elseif($authUser->parent->students->first()->course_id == 2)
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
                                                {!! select($courses, app()->request->course_id) !!}
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
                                        <button type="reset" class="btn btn-default reset"><i class="fas fa-sync-alt search-reset"></i> Reset</button>
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
                                        <tr>
                                            <th scope="col">Payment Type</th>
                                            <th scope="col">Payment Method</th>
                                            <th scope="col">Bank</th>
                                            <th scope="col">Bank Copy</th>
                                            <th scope="col">Amount</th>
                                            <th scope="col">Available Amount</th>
                                            <th scope="col">Payment Date</th>
                                            <th scope="col">Remarks</th>
                                            <th scope="col">Status</th>
                                            <th scope="col" style="width: 6.5rem;">Action</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($studentPayments as $studentPayment)
                                        <tr>
                                            <td>{{$studentPayment->paymentType->title}}</td>
                                            <td>{{$studentPayment->paymentMethod->title}}</td>
                                            <td>{{!empty($studentPayment->bank->title) ? $studentPayment->bank->title : 'n/a'}}</td>
                                            <td>
                                                @if($studentPayment->bank_copy)
                                                <a href="{{asset($studentPayment->bank_copy)}}" target="_blank" download><i class="fas fa-file-download"></i></a>
                                                    @else
                                                    <span>--</span>
                                                @endif
                                            </td>
                                            <td>{{formatAmount($studentPayment->amount)}}</td>
                                            <td>{{formatAmount($studentPayment->available_amount)}}</td>
                                            <td>{{!empty($studentPayment->payment_date) ? $studentPayment->payment_date : 'n/a'}}</td>
                                            <td>{{!empty($studentPayment->remarks)? $studentPayment->remarks : 'n/a'}}</td>
                                            <td>{!! paymentStatus($studentPayment->status) !!}</td>
                                            <td>
                                                <a href="{{route(customRoute('student.payment.view'), $studentPayment->id)}}" class="m-portlet__nav-link btn m-btn m-btn--hover-brand m-btn--icon m-btn--icon-only m-btn--pill" title="Edit"><i class="flaticon-eye"></i></a>
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
                $.get('<?php echo e(route(customRoute('student.info.session.course'))); ?>',
                    {courseId: courseId, sessionId: sessionId, _token: "<?php echo e(csrf_token()); ?>"},
                    function (response) {
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

        if (studentId > 0){
            $('#session_id, #course_id').trigger('change');
        }

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
