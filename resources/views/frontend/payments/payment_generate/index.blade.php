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
                                            <!-- Student (MBBS)-->
                                            @if($authUser->student->course_id == 1)
                                                <select class="form-control" name="course_id" id="course_id">
                                                    <option value="">---- Select Course ----</option>
                                                    <option value="1" {{ app()->request->course_id == 1 ? 'selected' : ''}}> MBBS </option>
                                                </select>
                                                <!-- Student (BDS)-->
                                            @elseif($authUser->student->course_id == 2)
                                                <select class="form-control" name="course_id" id="course_id">
                                                    <option value="">---- Select Course ----</option>
                                                    <option value="2" {{ app()->request->course_id == 2 ? 'selected' : ''}}> BDS </option>
                                                </select>
                                            @endif
                                        </div>
                                    </div>
                                    @elseif($authUser->user_group_id == 6)
                                    <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 col-xl-6">
                                        <div class="form-group">
                                            <!-- Student (MBBS)-->
                                            @if($authUser->parent->students->first()->course_id == 1)
                                                <select class="form-control" name="course_id" id="course_id">
                                                    <option value="">---- Select Course ----</option>
                                                    <option value="1" {{ app()->request->course_id == 1 ? 'selected' : ''}}> MBBS </option>
                                                </select>
                                                <!-- Student (BDS)-->
                                            @elseif($authUser->parent->students->first()->course_id == 2)
                                                <select class="form-control" name="course_id" id="course_id">
                                                    <option value="">---- Select Course ----</option>
                                                    <option value="2" {{ app()->request->course_id == 2 ? 'selected' : ''}}> BDS </option>
                                                </select>

                                            @endif
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
                                        <select class="form-control" name="payment_type_id" id="payment_type_id">
                                            <option value="">---- Select Payment Type ----</option>
                                            @if(!empty($paymentTypes))
                                                @foreach($paymentTypes as $key => $type)
                                                    @if(in_array($key, [1, 3, 4]))
                                                        <option value="{{$key}}" {{(request()->payment_type_id == $key) ? 'selected' : ''}}>{{$type}}</option>
                                                    @endif
                                                @endforeach
                                            @endif
                                            {{--{!! select($paymentTypes, app()->request->payment_type_id) !!}--}}
                                        </select>
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
                            <div class="col-md-12">
                                @if(!empty($studentFees))

                                    @if ($studentFees->isNotEmpty())
                                        <h4 class="text-center mt-4">Fee Info of Student - <b>{{$studentFees->first()->student->full_name_en}}</b> , Roll No. - <b>{{$studentFees->first()->student->roll_no}}</b></h4>
                                    @else
                                        <h4 class="text-center mt-4">Student Fee Info</h4>
                                    @endif
                                    <br>

                                    <div class="table m-table table-responsive">
                                        <table class="table table-bordered table-hover" id="dataTable">
                                            <thead>
                                            <tr>
                                                <th class="uppercase">Fee Title</th>
                                                <th class="uppercase">Total Amount</th>
                                                <th class="uppercase">Discount Amount</th>
                                                <th class="uppercase">Payable Amount</th>
                                                <th class="uppercase">Paid Amount</th>
                                                <th class="uppercase">Due Amount</th>
                                                <th class="uppercase">Discount Application</th>
                                                <th class="uppercase">Date</th>
                                                <th class="uppercase" style="width: 7rem;">Status</th>
                                                <th class="uppercase" style="width: 6.5rem;">Action</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            @php
                                                $sortedStudentFees = $studentFees->sortByDesc(function ($item, $key) {
                                                    return $item->feeDetails->first()->bill_year.$item->feeDetails->first()->bill_month;
                                                });
                                            @endphp
                                            @foreach($sortedStudentFees as $studentFee)
                                                <tr>
                                                    <td>{{$studentFee->title}}</td>
                                                    <td>{{formatAmount($studentFee->total_amount)}}</td>
                                                    <td>{{formatAmount($studentFee->discount_amount)}}</td>
                                                    <td>{{formatAmount($studentFee->payable_amount)}}</td>
                                                    <td>{{formatAmount($studentFee->paid_amount)}}</td>
                                                    <td>{{formatAmount($studentFee->due_amount)}}</td>
                                                    <td>
                                                        @if(!empty($studentFee->discount_application))
                                                        <a href="{{asset('nemc_files/payment/'.$studentFee->discount_application)}}" title="Download Discount Application" download><i class="fas fa-download"></i></a>
                                                        @else
                                                            <span>--</span>
                                                        @endif
                                                    </td>
                                                    <td>
                                                        @if(!empty($studentFee->feeDetails->first()->bill_month) and !empty( $studentFee->feeDetails->first()->bill_year))
                                                            {{date("F", mktime(0, 0, 0, $studentFee->feeDetails->first()->bill_month, 1)) .','. $studentFee->feeDetails->first()->bill_year}},
                                                            @else
                                                            <span>--</span>
                                                        @endif
                                                    </td>
                                                    <td>{!! paymentStatus($studentFee->status) !!}</td>
                                                    <td>
                                                        <a href="{{route(customRoute('generate.student.fee.view'), $studentFee->id)}}" class="m-portlet__nav-link btn m-btn m-btn--hover-brand m-btn--icon m-btn--icon-only m-btn--pill" title="View"><i class="flaticon-eye"></i></a>
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

    </script>
@endpush
