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
                        <a id="student-fee-detail-route" target="_blank"
                           class="btn btn-primary m-btn m-btn--icon text-white mr-2 d-none"
                           title="Show detail of current student fee"><i class="flaticon-eye"></i>View Student Fee
                            Details</a>
                        <a href="{{ route('get.student.development.fee') }}"
                           class="btn btn-primary m-btn m-btn--icon"><i class="fas fa-undo"></i> Back</a>
                    </div>
                </div>

                <form class="m-form m-form--fit m-form--label-align-right"
                      action="{{ route('student.fee.collect.save') }}" method="post"
                      id="nemc-general-form" enctype="multipart/form-data">
                    @csrf
                    <div class="m-portlet__body">
                        <div class="row">
                            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                                <div
                                    class="form-group  m-form__group {{ $errors->has('session_id') ? 'has-danger' : '' }}">
                                    <label class="form-control-label"><span class="text-danger">*</span> Session
                                    </label>
                                    <select class="form-control m-input" name="session_id" id="session_id">
                                        <option value="">---- Select Session ----</option>
                                        {!! select($sessions) !!}
                                    </select>
                                    @if ($errors->has('session_id'))
                                        <div class="form-control-feedback">{{ $errors->first('session_id') }}</div>
                                    @endif
                                </div>
                            </div>
                            @php $authUser = Auth::guard('web')->user(); @endphp
                            @if($authUser->user_group_id == 7)
                                <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 col-xl-6">
                                    <div
                                        class="form-group  m-form__group {{ $errors->has('course_id') ? 'has-danger' : '' }}">
                                        <label class="form-control-label"><span class="text-danger">*</span> Course
                                        </label>
                                        <!-- Staff - Accounts (MBBS)-->
                                        @if($authUser->adminUser->course_id == 1)
                                            <select class="form-control m-input" name="course_id" id="course_id">
                                                <option value="">---- Select Course ----</option>
                                                <option value="1" {{ app()->request->course_id == 1 ? 'selected' : ''}}>
                                                    MBBS
                                                </option>
                                            </select>
                                            @if ($errors->has('course_id'))
                                                <div
                                                    class="form-control-feedback">{{ $errors->first('course_id') }}</div>
                                            @endif
                                            <!-- Staff - Accounts (BDS)-->
                                        @elseif($authUser->adminUser->course_id == 2)
                                            <select class="form-control m-input" name="course_id" id="course_id">
                                                <option value="">---- Select Course ----</option>
                                                <option value="2" {{ app()->request->course_id == 2 ? 'selected' : ''}}>
                                                    BDS
                                                </option>
                                            </select>
                                            @if ($errors->has('course_id'))
                                                <div
                                                    class="form-control-feedback">{{ $errors->first('course_id') }}</div>
                                            @endif
                                            <!-- Staff - Accounts (when no course with user(MBBS and BDS))-->
                                        @else
                                            <select class="form-control m-input" name="course_id" id="course_id">
                                                <option value="">---- Select Course ----</option>
                                                {!! select($courses, app()->request->course_id) !!}
                                            </select>
                                            @if ($errors->has('course_id'))
                                                <div
                                                    class="form-control-feedback">{{ $errors->first('course_id') }}</div>
                                            @endif

                                        @endif
                                    </div>
                                </div>
                            @else
                                <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                                    <div
                                        class="form-group  m-form__group {{ $errors->has('course_id') ? 'has-danger' : '' }}">
                                        <label class="form-control-label"><span class="text-danger">*</span> Course
                                        </label>
                                        <select class="form-control m-input" name="course_id" id="course_id">
                                            <option value="">---- Select Course ----</option>
                                            {!! select($courses, Auth::user()->teacher->course_id ?? '') !!}
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
                                <div
                                    class="form-group  m-form__group {{ $errors->has('student_id') ? 'has-danger' : '' }}">
                                    <label class="form-control-label">Student
                                    </label>
                                    <select class="form-control m-input m-bootstrap-select m_selectpicker"
                                            name="student_id" id="student_id" data-live-search="true">
                                        <option value="">---- Select Student ----</option>
                                    </select>
                                    @if ($errors->has('student_id'))
                                        <div class="form-control-feedback">{{ $errors->first('student_id') }}</div>
                                    @endif
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 col-xl-6">
                                <div
                                    class="form-group  m-form__group {{ $errors->has('student_user_id') ? 'has-danger' : '' }}">
                                    <label class="form-control-label"><span class="text-danger">*</span> Student ID
                                    </label>
                                    <input type="text" class="form-control m-input" name="student_user_id"
                                           id="student-user-id"
                                           value="{{app()->request->student_user_id}}" placeholder="Student ID"/>
                                    @if ($errors->has('student_user_id'))
                                        <div class="form-control-feedback">{{ $errors->first('student_user_id') }}</div>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                                <div class="form-group  m-form__group">
                                    <label class="form-control-label"> Student Roll</label>
                                    <input class="form-control m-input" id="student-roll-no"
                                           value="After selecting student, roll number will shown here"
                                           style="height: 33px;" readonly>
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                                <div
                                    class="form-group  m-form__group {{ $errors->has('payment_method_id') ? 'has-danger' : '' }}">
                                    <label class="form-control-label"><span class="text-danger">*</span> Payment Method
                                    </label>
                                    <select class="form-control m-input" name="payment_method_id"
                                            id="payment_method_id">
                                        <option value="">---- Select Payment Method ----</option>
                                        {!! select($paymentMethods, 1) !!}
                                    </select>
                                    @if ($errors->has('payment_method_id'))
                                        <div
                                            class="form-control-feedback">{{ $errors->first('payment_method_id') }}</div>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                                <div class="form-group  m-form__group">
                                    <label class="form-control-label">Select Bank</label>
                                    <select class="form-control m-input m-bootstrap-select m_selectpicker"
                                            name="bank_id" id="bank_id" data-live-search="true">
                                        <option value="">---- Select Bank ----</option>
                                        {!! select($banks) !!}
                                    </select>
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                                <div class="form-group m-form__group">
                                    <label for="bankCopy">Bank Copy</label>
                                    <input type="file" class="form-control-file" name="bank_copy" id="bankCopy">
                                    <small id="emailHelp" class="form-text text-muted">Bank copy is not require if you
                                        chose payment method "Cash On NEMC"</small>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                                <div class="form-group  m-form__group">
                                    <label class="form-control-label"><span class="text-danger">*</span> Payment Date
                                    </label>
                                    <input type="text" class="form-control m-input m_datepicker_1" name="payment_date"
                                           value="{{ old('payment_date') }}" placeholder="Payment Date" readonly/>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
                                <div class="card card-items_1 payment-type-static mt-3 col-12 p-0" data-row="0">
                                    <div class="card-header">
                                        <span>Setup Payment Type Wise Amount</span>
                                    </div>
                                    <div class="card-body amount-card">
                                        <div class="row">
                                            <div class="col-xs-12 col-sm-12 col-md-2 col-lg-2 col-xl-2">
                                                <div class="form-group  m-form__group">
                                                    <label class="form-control-label">Payment Fee Type</label>
                                                    <span class="subject-list-static">
                                                        <input type="hidden" class="form-control m-input"
                                                               name="payment_type_id[]" value="1" style="height: 33px;">
                                                        <input type="hidden" class="form-control m-input"
                                                               name="payment_type_id[]" value="2" style="height: 33px;">
                                                        <input type="hidden" class="form-control m-input"
                                                               name="payment_type_id[]" value="3" style="height: 33px;">
                                                        <input type="hidden" class="form-control m-input"
                                                               name="payment_type_id[]" value="4" style="height: 33px;">
                                                        <input type="hidden" class="form-control m-input"
                                                               name="payment_type_id[]" value="5" style="height: 33px;">
                                                        <input type="hidden" class="form-control m-input"
                                                               name="payment_type_id[]" value="6" style="height: 33px;">

                                                        <input class="form-control m-input" value="Development Fee"
                                                               style="height: 33px;" readonly>
                                                        <input class="form-control m-input" value="Admission Fee"
                                                               style="height: 33px;" readonly>
                                                        <input class="form-control m-input" value="Tuition Fee"
                                                               style="height: 33px;" readonly>
                                                        <input class="form-control m-input" value="Class Absent Fee"
                                                               style="height: 33px;" readonly>
                                                        <input class="form-control m-input" value="Late Fee"
                                                               style="height: 33px;" readonly>
                                                        <input class="form-control m-input" value="Re-admission Fee"
                                                               style="height: 33px;" readonly>
                                                     </span>
                                                </div>
                                            </div>
                                            <div class="col-xs-12 col-sm-12 col-md-2 col-lg-2 col-xl-2">
                                                <div class="form-group  m-form__group">
                                                    <label class="form-control-label">Due Amount <span
                                                            class="currency_show" style="color:red;"></span></label>
                                                    <span class="subject-list-static">
                                                        <input class="form-control m-input" id="student-due-amount-1"
                                                               name="due_amount[]" value="" style="height: 33px;"
                                                               readonly>
                                                        <input class="form-control m-input" id="student-due-amount-2"
                                                               name="due_amount[]" value="" style="height: 33px;"
                                                               readonly>
                                                        <input class="form-control m-input" id="student-due-amount-3"
                                                               name="due_amount[]" value="" style="height: 33px;"
                                                               readonly>
                                                        <input class="form-control m-input" id="student-due-amount-4"
                                                               name="due_amount[]" value="" style="height: 33px;"
                                                               readonly>
                                                        <input class="form-control m-input" id="student-due-amount-5"
                                                               name="due_amount[]" value="" style="height: 33px;"
                                                               readonly>
                                                        <input class="form-control m-input" id="student-due-amount-6"
                                                               name="due_amount[]" value="" style="height: 33px;"
                                                               readonly>
                                                     </span>
                                                </div>
                                            </div>

                                            <div class="col-xs-12 col-sm-12 col-md-2 col-lg-2 col-xl-2">
                                                <div
                                                    class="form-group  m-form__group {{ $errors->has('amount') ? 'has-danger' : '' }}">
                                                    <label class="form-control-label">Amount </label>
                                                    <input type="number" onkeyup="findTotalOne()" id="amount1"
                                                           class="form-control m-input amount" name="amount[]"
                                                           value="{{old('amount')}}" placeholder="Amount"
                                                           style="height: 33px!important;"/>
                                                    <input type="number" onkeyup="findTotalTwo()" id="amount2"
                                                           class="form-control m-input amount" name="amount[]"
                                                           value="{{old('amount')}}" placeholder="Amount"
                                                           style="height: 33px!important;"/>
                                                    <input type="number" onkeyup="findTotalThree()" id="amount3"
                                                           class="form-control m-input amount" name="amount[]"
                                                           value="{{old('amount')}}" placeholder="Amount"
                                                           style="height: 33px!important;"/>
                                                    <input type="number" onkeyup="findTotalFour()" id="amount4"
                                                           class="form-control m-input amount" name="amount[]"
                                                           value="{{old('amount')}}" placeholder="Amount"
                                                           style="height: 33px!important;"/>
                                                    <input type="number" onkeyup="findTotalFive()" id="amount5"
                                                           class="form-control m-input amount" name="amount[]"
                                                           value="{{old('amount')}}" placeholder="Amount"
                                                           style="height: 33px!important;"/>
                                                    <input type="number" onkeyup="findTotalSix()" id="amount6"
                                                           class="form-control m-input amount" name="amount[]"
                                                           value="{{old('amount')}}" placeholder="Amount"
                                                           style="height: 33px!important;"/>
                                                    @if ($errors->has('amount'))
                                                        <div
                                                            class="form-control-feedback">{{ $errors->first('amount') }}</div>
                                                    @endif
                                                </div>
                                            </div>

                                            <div class="col-xs-12 col-sm-12 col-md-2 col-lg-2 col-xl-2">
                                                <div
                                                    class="form-group  m-form__group {{ $errors->has('amount') ? 'has-danger' : '' }}">
                                                    <label class="form-control-label">Discount Amount </label>
                                                    <input type="number" min="1" onkeyup="findTotalOne()"
                                                           id="discount_amount1" class="form-control m-input discount"
                                                           name="discount_amount[]" value="{{ old('discount_amount') }}"
                                                           placeholder="Discount Amount"
                                                           style="height: 33px!important;"/>
                                                    <input type="number" min="1" onkeyup="findTotalTwo()"
                                                           id="discount_amount2" class="form-control m-input discount"
                                                           name="discount_amount[]" value="{{ old('discount_amount') }}"
                                                           placeholder="Discount Amount"
                                                           style="height: 33px!important;"/>
                                                    <input type="number" min="1" onkeyup="findTotalThree()"
                                                           id="discount_amount3" class="form-control m-input discount"
                                                           name="discount_amount[]" value="{{ old('discount_amount') }}"
                                                           placeholder="Discount Amount"
                                                           style="height: 33px!important;"/>
                                                    <input type="number" min="1" onkeyup="findTotalFour()"
                                                           id="discount_amount4" class="form-control m-input discount"
                                                           name="discount_amount[]" value="{{ old('discount_amount') }}"
                                                           placeholder="Discount Amount"
                                                           style="height: 33px!important;"/>
                                                    <input type="number" min="1" onkeyup="findTotalFive()"
                                                           id="discount_amount5" class="form-control m-input discount"
                                                           name="discount_amount[]" value="{{ old('discount_amount') }}"
                                                           placeholder="Discount Amount"
                                                           style="height: 33px!important;"/>
                                                    <input type="number" min="1" onkeyup="findTotalSix()"
                                                           id="discount_amount6" class="form-control m-input discount"
                                                           name="discount_amount[]" value="{{ old('discount_amount') }}"
                                                           placeholder="Discount Amount"
                                                           style="height: 33px!important;"/>
                                                    @if ($errors->has('discount_amount'))
                                                        <div
                                                            class="form-control-feedback">{{ $errors->first('discount_amount') }}</div>
                                                    @endif
                                                </div>
                                            </div>

                                            <div class="col-xs-12 col-sm-12 col-md-2 col-lg-2 col-xl-2">
                                                <div
                                                    class="form-group  m-form__group {{ $errors->has('amount') ? 'has-danger' : '' }}">
                                                    <label class="form-control-label">Total Due</label>
                                                    <input type="text" class="form-control m-input total-due"
                                                           id="total1"
                                                           readonly="" style="height: 33px!important;"/>
                                                    <input type="text" class="form-control m-input total-due"
                                                           id="total2"
                                                           readonly="" style="height: 33px!important;"/>
                                                    <input type="text" class="form-control m-input total-due"
                                                           id="total3"
                                                           readonly="" style="height: 33px!important;"/>
                                                    <input type="text" class="form-control m-input total-due"
                                                           id="total4"
                                                           readonly="" style="height: 33px!important;"/>
                                                    <input type="text" class="form-control m-input total-due"
                                                           id="total5"
                                                           readonly="" style="height: 33px!important;"/>
                                                    <input type="text" class="form-control m-input total-due"
                                                           id="total6"
                                                           readonly="" style="height: 33px!important;"/>
                                                </div>
                                            </div>

                                            <div class="col-xs-12 col-sm-12 col-md-2 col-lg-2 col-xl-2">
                                                <div
                                                    class="form-group  m-form__group {{ $errors->has('amount') ? 'has-danger' : '' }}">
                                                    <label class="form-control-label">Advance Amount</label>
                                                    {{--                                                    <label--}}
                                                    {{--                                                        class="use-content form-control-label d-flex float-right mr-4">(✔)</label>--}}
                                                    <div class="available_amount" style="display:inline-flex">
                                                        <input type="text" class="form-control m-input" id="advance1"
                                                               name="available_amount[]"
                                                               value="{{ old('available_amount') }}" readonly=""
                                                               style="height: 33px!important;"/>
                                                        {{--                                                        <input title="Use this" class="use-this not-allowed"--}}
                                                        {{--                                                               type="checkbox"--}}
                                                        {{--                                                               name="use_this[]" id="useThis1" value="1" disabled/>--}}
                                                    </div>
                                                    <div class="available_amount" style="display:inline-flex">
                                                        <input type="text" class="form-control m-input" id="advance2"
                                                               name="available_amount[]"
                                                               value="{{ old('available_amount') }}" readonly=""
                                                               style="height: 33px!important;"/>
                                                        {{--                                                        <input title="Use this" class="use-this not-allowed"--}}
                                                        {{--                                                               type="checkbox"--}}
                                                        {{--                                                               name="use_this[]" id="useThis2" value="2" disabled/>--}}
                                                    </div>
                                                    <div class="available_amount" style="display:inline-flex">
                                                        <input type="text" class="form-control m-input" id="advance3"
                                                               name="available_amount[]"
                                                               value="{{ old('available_amount') }}" readonly=""
                                                               style="height: 33px!important;"/>
                                                        {{--                                                        <input title="Use this" class="use-this not-allowed"--}}
                                                        {{--                                                               type="checkbox"--}}
                                                        {{--                                                               name="use_this[]" id="useThis3" value="3" disabled/>--}}
                                                    </div>
                                                    <div class="available_amount" style="display:inline-flex">
                                                        <input type="text" class="form-control m-input" id="advance4"
                                                               name="available_amount[]"
                                                               value="{{ old('available_amount') }}" readonly=""
                                                               style="height: 33px!important;"/>
                                                        {{--                                                        <input title="Use this" class="use-this not-allowed"--}}
                                                        {{--                                                               type="checkbox"--}}
                                                        {{--                                                               name="use_this[]" id="useThis4" value="4" disabled/>--}}
                                                    </div>
                                                    <div class="available_amount" style="display:inline-flex">
                                                        <input type="text" class="form-control m-input" id="advance5"
                                                               name="available_amount[]"
                                                               value="{{ old('available_amount') }}" readonly=""
                                                               style="height: 33px!important;"/>
                                                        {{--                                                        <input title="Use this" class="use-this not-allowed"--}}
                                                        {{--                                                               type="checkbox"--}}
                                                        {{--                                                               name="use_this[]" id="useThis5" value="5" disabled/>--}}
                                                    </div>
                                                    <div class="available_amount" style="display:inline-flex">
                                                        <input type="text" class="form-control m-input" id="advance6"
                                                               name="available_amount[]"
                                                               value="{{ old('available_amount') }}" readonly=""
                                                               style="height: 33px!important;"/>
                                                        {{--                                                        <input title="Use this" class="use-this not-allowed"--}}
                                                        {{--                                                               type="checkbox"--}}
                                                        {{--                                                               name="use_this[]" id="useThis6" value="6" disabled/>--}}
                                                    </div>
                                                    <input type="hidden" id="prevAdvance1"
                                                           class="form-control m-input"/>
                                                    <input type="hidden" id="prevAdvance2"
                                                           class="form-control m-input"/>
                                                    <input type="hidden" id="prevAdvance3"
                                                           class="form-control m-input"/>
                                                    <input type="hidden" id="prevAdvance4"
                                                           class="form-control m-input"/>
                                                    <input type="hidden" id="prevAdvance5"
                                                           class="form-control m-input"/>
                                                    <input type="hidden" id="prevAdvance6"
                                                           class="form-control m-input"/>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="m-separator m-separator--dashed m-separator--lg"
                                             style="width: 100%"></div>

                                        {{--                                        <div class="m-checkbox-inline text-right mr-2">--}}
                                        {{--                                            <label class="not-allowed m-checkbox mr-1">--}}
                                        {{--                                                <input type="checkbox" name="use_this_total" id="use_this_total"--}}
                                        {{--                                                       disabled>Total--}}
                                        {{--                                                Available--}}
                                        {{--                                                Amount:<span class="not-allowed"></span>--}}
                                        {{--                                            </label>--}}
                                        {{--                                            <span id="total_available_amount">0.00</span><span--}}
                                        {{--                                                class="currency_show ml-1" style="color:red;"></span>--}}
                                        {{--                                        </div>--}}
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
                                <div class="form-group  m-form__group">
                                    <label class="form-control-label">Remarks</label>
                                    <textarea class="form-control m-input" name="remarks"
                                              placeholder="Remarks about payment">{{ old('remarks') }}</textarea>
                                </div>
                            </div>
                        </div>
                    </div>


                    <div class="m-portlet__foot m-portlet__foot--fit">
                        <div class="m-form__actions text-center">
                            <a href="" class="btn btn-outline-brand"><i class="fa fa-times"></i> Cancel</a>
                            <button type="submit" id="submitBtn" class="btn btn-success"><i class="fa fa-save"></i> Save
                            </button>
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

        function checkdata() {
            if (($('#session_id').val() > 0) && ($('#course_id').val() > 0) && ($('#student_id').val() > 0)) {
                return true;
            } else {
                return false;
            }
        }

        function findTotalOne() {
            var studentDueAmount_1 = $('#student-due-amount-1').val();
            var studentDiscountAmount_1 = $('#discount_amount1').val();
            var studentAmount_1 = $('#amount1').val();
            var totalAmount1 = studentDueAmount_1 - studentDiscountAmount_1 - studentAmount_1;
            var totalDiscount1 = studentDueAmount_1 - studentDiscountAmount_1;
            var totalPay1 = studentDiscountAmount_1 + studentAmount_1;

            $("#discount_amount1").attr("max", studentDueAmount_1);
            $("#amount1").attr("max", (studentDueAmount_1 - studentDiscountAmount_1));

            if (totalPay1 > 0) {
                $("#submitBtn").removeAttr("disabled", "").removeClass('not-allowed');
            } else {
                $("#submitBtn").attr("disabled", "").addClass('not-allowed');
            }

            if (totalAmount1 >= 0) {
                $("#total1").removeAttr('required');
                $("#submitBtn").removeAttr("disabled", "").removeClass('not-allowed');
                document.getElementById('total1').value = studentDueAmount_1 - studentDiscountAmount_1 - studentAmount_1;
            } else {
                alert('Development Fee please adjust, Equal or less Total Due Amount');
                document.getElementById('total1').value = 0;
                if (totalDiscount1 > 0) {
                    document.getElementById('total1').value = studentDueAmount_1 - studentDiscountAmount_1;
                }
                var el = document.getElementById("total1");
                el.setAttribute("required", "required");
                return false;
            }
        }

        function findTotalTwo() {
            var studentDueAmount_2 = $('#student-due-amount-2').val();
            var studentDiscountAmount_2 = $('#discount_amount2').val();
            var studentAmount_2 = $('#amount2').val();
            var totalAmount2 = studentDueAmount_2 - studentDiscountAmount_2 - studentAmount_2;
            var totalDiscount2 = studentDueAmount_2 - studentDiscountAmount_2;
            var totalPay2 = studentDiscountAmount_2 + studentAmount_2;

            $("#discount_amount2").attr("max", studentDueAmount_2);
            $("#amount2").attr("max", (studentDueAmount_2 - studentDiscountAmount_2));

            if (totalPay2 > 0) {
                $("#submitBtn").removeAttr("disabled", "").removeClass('not-allowed');
            } else {
                $("#submitBtn").attr("disabled", "").addClass('not-allowed');
            }

            if (totalAmount2 >= 0) {
                $("#total2").removeAttr('required');
                $("#submitBtn").removeAttr("disabled", "").removeClass('not-allowed');
                document.getElementById('total2').value = studentDueAmount_2 - studentDiscountAmount_2 - studentAmount_2;
            } else {
                alert('Admission Fee please adjust, Equal or less Total Due Amount');
                document.getElementById('total2').value = 0;

                if (totalDiscount2 > 0) {
                    document.getElementById('amount2').value = studentDueAmount_2 - studentDiscountAmount_2;
                }

                var el = document.getElementById("total2");
                el.setAttribute("required", "required");
                return false;
            }
        }

        function findTotalThree() {
            var studentDueAmount_3 = $('#student-due-amount-3').val();
            var studentDiscountAmount_3 = $('#discount_amount3').val();
            var studentAmount_3 = $('#amount3').val();
            var advanceAmount_3 = Number($("#prevAdvance3").val());
            var totalAmount3 = studentDueAmount_3 - studentDiscountAmount_3 - studentAmount_3;
            var totalDiscount3 = studentDueAmount_3 - studentDiscountAmount_3;
            var totalPay3 = studentDiscountAmount_3 + studentAmount_3;

            $("#discount_amount3").attr("max", studentDueAmount_3);

            if (totalDiscount3 < 0) {
                alert('Tuition Fee Discount please adjust, Equal or less Total Due Amount');
                $("#submitBtn").attr("disabled", "").addClass('not-allowed');
                return false;
            }

            if (totalPay3 > 0) {
                $("#submitBtn").removeAttr("disabled", "").removeClass('not-allowed');
            } else {
                $("#submitBtn").attr("disabled", "").addClass('not-allowed');
            }

            if (totalAmount3 >= 0) {
                $("#total3").removeAttr('required');
                document.getElementById('total3').value = studentDueAmount_3 - studentDiscountAmount_3 - studentAmount_3;
                document.getElementById('advance3').value = advanceAmount_3;
            } else {
                document.getElementById('total3').value = 0;
                if ($("#useThis3").is(":checked")) {
                    console.log("checked")
                    document.getElementById('advance3').value = studentAmount_3 - (studentDueAmount_3 - studentDiscountAmount_3);
                } else {
                    console.log("unchecked")
                    document.getElementById('advance3').value = studentAmount_3 - (studentDueAmount_3 - studentDiscountAmount_3) + advanceAmount_3;
                }
                var el = document.getElementById("amount3");
                el.setAttribute("required", "required");
            }
        }

        function findTotalFour() {
            var studentDueAmount_4 = $('#student-due-amount-4').val();
            var studentDiscountAmount_4 = $('#discount_amount4').val();
            var studentAmount_4 = $('#amount4').val();
            var advanceAmount_4 = Number($("#prevAdvance4").val());
            var totalAmount4 = studentDueAmount_4 - studentDiscountAmount_4 - studentAmount_4;
            var totalDiscount4 = studentDueAmount_4 - studentDiscountAmount_4;
            var totalPay4 = studentDiscountAmount_4 + studentAmount_4;

            $("#discount_amount4").attr("max", studentDueAmount_4);

            if (totalDiscount4 < 0) {
                alert('Class Absent Fee Discount please adjust, Equal or less Total Due Amount');
                $("#submitBtn").attr("disabled", "").addClass('not-allowed');
                return false;
            }

            if (totalPay4 > 0) {
                $("#submitBtn").removeAttr("disabled", "").removeClass('not-allowed');
            } else {
                $("#submitBtn").attr("disabled", "").addClass('not-allowed');
            }

            if (totalAmount4 >= 0) {
                $("#total4").removeAttr('required');
                document.getElementById('total4').value = studentDueAmount_4 - studentDiscountAmount_4 - studentAmount_4;
                document.getElementById('advance4').value = advanceAmount_4;
            } else {
                document.getElementById('total4').value = 0;

                if ($("#useThis4").is(":checked")) {
                    console.log("checked")
                    document.getElementById('advance4').value = studentAmount_4 - (studentDueAmount_4 - studentDiscountAmount_4);
                } else {
                    console.log("unchecked")
                    document.getElementById('advance4').value = studentAmount_4 - (studentDueAmount_4 - studentDiscountAmount_4) + advanceAmount_4;
                }

                var el = document.getElementById("amount4");
                el.setAttribute("required", "required");
            }
        }

        function findTotalFive() {
            var studentDueAmount_5 = $('#student-due-amount-5').val();
            var studentDiscountAmount_5 = $('#discount_amount5').val();
            var studentAmount_5 = $('#amount5').val();
            var advanceAmount_5 = Number($("#prevAdvance5").val());
            var totalAmount5 = studentDueAmount_5 - studentDiscountAmount_5 - studentAmount_5;
            var totalDiscount5 = studentDueAmount_5 - studentDiscountAmount_5;
            var totalPay5 = studentDiscountAmount_5 + studentAmount_5;

            $("#discount_amount5").attr("max", studentDueAmount_5);

            if (totalDiscount5 < 0) {
                alert('Late Fee Discount please adjust, Equal or less Total Due Amount');
                $("#submitBtn").attr("disabled", "").addClass('not-allowed');
                return false;
            }

            if (totalPay5 > 0) {
                $("#submitBtn").removeAttr("disabled", "").removeClass('not-allowed');
            } else {
                $("#submitBtn").attr("disabled", "").addClass('not-allowed');
            }

            if (totalAmount5 >= 0) {
                $("#total5").removeAttr('required');
                $("#submitBtn").removeAttr("disabled", "").removeClass('not-allowed');
                document.getElementById('total5').value = studentDueAmount_5 - studentDiscountAmount_5 - studentAmount_5;
                document.getElementById('advance5').value = advanceAmount_5;
            } else {
                document.getElementById('total5').value = 0;

                if ($("#useThis5").is(":checked")) {
                    console.log("checked")
                    document.getElementById('advance5').value = studentAmount_5 - (studentDueAmount_5 - studentDiscountAmount_5);
                } else {
                    console.log("unchecked")
                    document.getElementById('advance5').value = studentAmount_5 - (studentDueAmount_5 - studentDiscountAmount_5) + Number(advanceAmount_5);
                }

                var el = document.getElementById("amount5");
                el.setAttribute("required", "required");
            }
        }

        function findTotalSix() {
            var studentDueAmount_6 = $('#student-due-amount-6').val();
            var studentDiscountAmount_6 = $('#discount_amount6').val();
            var studentAmount_6 = $('#amount6').val();
            var totalAmount6 = studentDueAmount_6 - studentDiscountAmount_6 - studentAmount_6;
            var totalDiscount6 = studentDueAmount_6 - studentDiscountAmount_6;
            var totalPay6 = studentDiscountAmount_6 + studentAmount_6;

            $("#discount_amount6").attr("max", studentDueAmount_6);
            $("#amount6").attr("max", (studentDueAmount_6 - studentDiscountAmount_6));

            if (totalPay6 > 0) {
                $("#submitBtn").removeAttr("disabled", "").removeClass('not-allowed');
            } else {
                $("#submitBtn").attr("disabled", "").addClass('not-allowed');
            }

            if (totalAmount6 >= 0) {
                $("#total6").removeAttr('required');
                document.getElementById('total6').value = studentDueAmount_6 - studentDiscountAmount_6 - studentAmount_6;
            } else {
                alert('Re-admission Fee please adjust, Equal or less Total Due Amount');
                document.getElementById('total6').value = 0;

                if (totalDiscount6 > 0) {
                    document.getElementById('amount6').value = studentDueAmount_6 - studentDiscountAmount_6;
                }

                var el = document.getElementById("total6");
                el.setAttribute("required", "required");
                return false;
            }
        }

        $('#student-discount-amount-1,#student-amount-1').on('keyup', function () {
            var studentDueAmount_1 = $('#student-due-amount-1').val();
            var studentDiscountAmount_1 = $('#student-discount-amount-1').val();
            var studentAmount_1 = $('#student-amount-1').val();

            totalamount = studentDiscountAmount_1 + studentAmount_1;
        });

        // code for add
        $('.add-payment-type').on('click', function () {
            if (checkdata() != true) {
                sweetAlert('Select Session, Course, Student', 'error');
                return false;
            }
            rowSize = $('.card-items').attr('data-row');
            paymentsTypes = $('.payment-type:first');
            paymentsTypesRow = paymentsTypes.clone(true);
            paymentsTypesRow.removeClass('card-items');

            paymentsTypesRow.find('.payment-group').attr('name', 'payment_type_id[' + rowSize + ']');
            paymentsTypesRow.find('.discount-amount-pay').attr('name', 'discount_amount[' + rowSize + ']');
            paymentsTypesRow.find('.amount-pay').attr('name', 'amount[' + rowSize + ']');

            $('#all-payments').prepend(paymentsTypesRow.removeClass('m--hide'));
            $('.card-items').attr('data-row', (parseInt(rowSize) + 1));
        });

        // code for remove
        $('.remove-row').on('click', function () {
            Swal.fire({
                title: 'Are you sure?',
                text: "Do you want to remove this",
                type: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Yes'
            }).then((result) => {
                if (result.value) {
                    current = $(this);
                    $(this).parents('.payment-type').remove();

                } else if (result.dismiss === Swal.DismissReason.cancel) {
                    return false;
                }
            });
        });


        $('.payment-group').change(function () {
            if (checkdata() != true) {
                sweetAlert('Select Session, Course, Student', 'error');
                return false;
            }
            current = $(this);
            courseId = $('#course_id').val();
            sessionId = $('#session_id').val();
            studentId = $('#student_id').val();

            mApp.blockPage({
                overlayColor: "#000000",
                type: "loader",
                state: "primary",
                message: "Please wait..."
            });

            // load subjects
            $.get('{{route('get.single.student.due')}}', {
                studentId: studentId,
                sessionId: sessionId,
                courseId: courseId,
                paymentTypeId: $(this).val()
            }, function (response) {
                if (response) {
                    row = current.parents('.payment-type').find('.subject-list');
                    row.html('<input class="form-control m-input" name="due_amount[]" id="due_amount" type="text" value="' + response + '" />');
                }
                mApp.unblockPage()
            })
        });


        $('.payment-group-static').change(function () {
            if (checkdata() != true) {
                sweetAlert('Select Session, Course, Student', 'error');
                return false;
            }
            current = $(this);
            courseId = $('#course_id').val();
            sessionId = $('#session_id').val();
            studentId = $('#student_id').val();

            mApp.blockPage({
                overlayColor: "#000000",
                type: "loader",
                state: "primary",
                message: "Please wait..."
            });

            // load subjects
            $.get('{{route('get.single.student.due')}}', {
                studentId: studentId,
                sessionId: sessionId,
                courseId: courseId,
                paymentTypeId: $(this).val()
            }, function (response) {
                if (response) {
                    row = current.parents('.payment-type-static').find('.subject-list-static');
                    row.html('<input class="form-control m-input" name="due_amount[]" type="text" value="' + response + '" />');
                }
                mApp.unblockPage()
            })
        });

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
            studentId = $('#student_id').val();
            $("#student-due-amount-1").val('');
            $("#student-due-amount-2").val('');
            $("#student-due-amount-3").val('');
            $("#student-due-amount-4").val('');
            $("#student-due-amount-5").val('');
            $("#student-due-amount-6").val('');
            if (studentId > 0) {
                $.get('<?php echo e(route('get.single.student.amount')); ?>', {
                    studentId: studentId, _token: "<?php echo e(csrf_token()); ?>"
                }, function (response) {
                    studentUserId = response[0].user_id;
                    studentRollNumber = response[0].roll_no;

                    $("#student-user-id").val(studentUserId);
                    $("#student-roll-no").val(studentRollNumber);

                    if (response[0].student_category == 2) {
                        $(".currency_show").text("($)");
                    } else {
                        $(".currency_show").text("(TK)");
                    }
                    var total_available_amount_sum = 0;
                    for (var i = 0; i < response.length; i++) {
                        if (isInt(response[i].total_available_amount)) {
                            total_available_amount_sum += parseFloat(response[i].total_available_amount);
                        }
                        if (response[i].payment_type_id == 1) {
                            $("#student-due-amount-1").val(response[i].total_due);
                            $("#prevAdvance1").val(response[i].total_available_amount);
                            $("#amount1").attr("max", response[i].total_due);
                        }
                        if (response[i].payment_type_id == 2) {
                            $("#student-due-amount-2").val(response[i].total_due);
                            $("#prevAdvance2").val(response[i].total_available_amount);
                            $("#amount2").attr("max", response[i].total_due);
                        }
                        if (response[i].payment_type_id == 3) {
                            $("#student-due-amount-3").val(response[i].total_due);
                            $("#prevAdvance3").val(response[i].total_available_amount);
                        }
                        if (response[i].payment_type_id == 4) {
                            $("#student-due-amount-4").val(response[i].total_due);
                            $("#prevAdvance4").val(response[i].total_available_amount);
                        }
                        if (response[i].payment_type_id == 5) {
                            $("#student-due-amount-5").val(response[i].total_due);
                            $("#prevAdvance5").val(response[i].total_available_amount);
                        }
                        if (response[i].payment_type_id == 6) {
                            $("#student-due-amount-6").val(response[i].total_due);
                            $("#prevAdvance6").val(response[i].total_available_amount);
                            $("#amount6").attr("max", response[i].total_due);
                        }
                    }
                    //clear all amount
                    $(".amount").each(function () {
                        this.value = '';
                    });
                    //clear all total due
                    $(".total-due").each(function () {
                        this.value = '';
                    });
                    //clear all discount
                    $(".discount").each(function () {
                        this.value = '';
                    });

                    $("#total_available_amount").text(total_available_amount_sum);
                    $("#use_this_total").val(total_available_amount_sum);

                    if (total_available_amount_sum > 0) {
                        $("#use_this_total").removeAttr('disabled');
                        $("#use_this_total").parent().removeClass('not-allowed');
                        $("#use_this_total + span").removeClass('not-allowed');
                        $(".use-this").removeAttr('disabled');
                        $(".use-this").removeClass('not-allowed');
                    } else {
                        $("#use_this_total").attr('disabled', true);
                        $("#use_this_total").prop("checked", false);
                        $("#use_this_total").parent().addClass('not-allowed');
                        $(".use-this").attr('disabled', true);
                        $(".use-this").prop("checked", false);
                        $(".use-this").addClass('not-allowed');
                    }

                    var adv1 = $("#prevAdvance1").val() ?? 0;
                    var adv2 = $("#prevAdvance2").val() ?? 0;
                    var adv3 = $("#prevAdvance3").val() ?? 0;
                    var adv4 = $("#prevAdvance4").val() ?? 0;
                    var adv5 = $("#prevAdvance5").val() ?? 0;
                    var adv6 = $("#prevAdvance6").val() ?? 0;

                    $("#advance1").val(adv1 ?? 0);
                    $("#advance2").val(adv2 ?? 0);
                    $("#advance3").val(adv3 ?? 0);
                    $("#advance4").val(adv4 ?? 0);
                    $("#advance5").val(adv5 ?? 0);
                    $("#advance6").val(adv6 ?? 0);
                });
            }

        });

        //check value
        function isInt(value) {
            return !isNaN(value) && (function (x) {
                return (x | 0) === x;
            })(parseFloat(value))
        }

        //configure fee details route
        $('#student_id, #payment_type_id').change(function () {
            studentId = $('#student_id').val();
            paymentTypeId = $('#payment_type_id').val();
            //route name
            urlRouteName = '{{route('get.single.student.fee')}}';
            if (studentId > 0 && paymentTypeId > 0) {
                //generate route with student and payment type
                routeWithIds = urlRouteName + '?student_id=' + studentId + '&payment_type_id=' + paymentTypeId;

                //set url to href
                $("#student-fee-detail-route").attr("href", routeWithIds);
                //show button when select student and payment type
                $("#student-fee-detail-route").removeClass("d-none");
            }
        });

        $('#student-user-id').keyup(function (e) {
            e.preventDefault();

            $("#student_id").val('');
            $('.m_selectpicker').selectpicker('refresh');

            let studentUserId = $(this).val();
            if (studentUserId > 0) {
                $.get('<?php echo e(route('student.amount.by.userId')); ?>', {
                    studentUserId: studentUserId,
                    _token: "<?php echo e(csrf_token()); ?>"
                }, function (response) {
                    let studentRollNumber = response[0].roll_no;
                    $("#student-roll-no").val(studentRollNumber);

                    if (response[0].student_category == 2) {
                        $(".currency_show").text("($)");
                    } else {
                        $(".currency_show").text("(TK)");
                    }
                    let total_available_amount_sum = 0;
                    for (let i = 0; i < response.length; i++) {
                        if (isInt(response[i].total_available_amount)) {
                            total_available_amount_sum += parseFloat(response[i].total_available_amount);
                        }
                        if (response[i].payment_type_id == 1) {
                            $("#student-due-amount-1").val(response[i].total_due);
                            $("#prevAdvance1").val(response[i].total_available_amount);
                            $("#amount1").attr("max", response[i].total_due);
                        }
                        if (response[i].payment_type_id == 2) {
                            $("#student-due-amount-2").val(response[i].total_due);
                            $("#prevAdvance2").val(response[i].total_available_amount);
                            $("#amount2").attr("max", response[i].total_due);
                        }
                        if (response[i].payment_type_id == 3) {
                            $("#student-due-amount-3").val(response[i].total_due);
                            $("#prevAdvance3").val(response[i].total_available_amount);
                        }
                        if (response[i].payment_type_id == 4) {
                            $("#student-due-amount-4").val(response[i].total_due);
                            $("#prevAdvance4").val(response[i].total_available_amount);
                        }
                        if (response[i].payment_type_id == 5) {
                            $("#student-due-amount-5").val(response[i].total_due);
                            $("#prevAdvance5").val(response[i].total_available_amount);
                        }
                        if (response[i].payment_type_id == 6) {
                            $("#student-due-amount-6").val(response[i].total_due);
                            $("#prevAdvance6").val(response[i].total_available_amount);
                            $("#amount6").attr("max", response[i].total_due);
                        }
                    }

                    $(".amount").each(function () {
                        this.value = '';
                    });
                    $(".total-due").each(function () {
                        this.value = '';
                    });
                    $(".discount").each(function () {
                        this.value = '';
                    });

                    $("#total_available_amount").text(total_available_amount_sum);
                    $("#use_this_total").val(total_available_amount_sum);

                    if (total_available_amount_sum > 0) {
                        $("#use_this_total").removeAttr('disabled');
                        $("#use_this_total").parent().removeClass('not-allowed');
                        $("#use_this_total + span").removeClass('not-allowed');
                        $(".use-this").removeAttr('disabled');
                        $(".use-this").removeClass('not-allowed');
                    } else {
                        $("#use_this_total").attr('disabled', true);
                        $("#use_this_total").prop("checked", false);
                        $("#use_this_total").parent().addClass('not-allowed');
                        $(".use-this").attr('disabled', true);
                        $(".use-this").prop("checked", false);
                        $(".use-this").addClass('not-allowed');
                    }

                    let adv1 = $("#prevAdvance1").val() ?? 0;
                    let adv2 = $("#prevAdvance2").val() ?? 0;
                    let adv3 = $("#prevAdvance3").val() ?? 0;
                    let adv4 = $("#prevAdvance4").val() ?? 0;
                    let adv5 = $("#prevAdvance5").val() ?? 0;
                    let adv6 = $("#prevAdvance6").val() ?? 0;

                    $("#advance1").val(adv1 ?? 0);
                    $("#advance2").val(adv2 ?? 0);
                    $("#advance3").val(adv3 ?? 0);
                    $("#advance4").val(adv4 ?? 0);
                    $("#advance5").val(adv5 ?? 0);
                    $("#advance6").val(adv6 ?? 0);
                });
            }
        });

        // form validations
        $('#nemc-general-form').validate({
            rules: {
                session_id: {
                    required: function () {
                        return $("#student-user-id").val() == 0;
                    },
                    min: 1,
                },
                course_id: {
                    required: function () {
                        return $("#student-user-id").val() == 0;
                    },
                    min: 1
                },
                student_id: {
                    required: function () {
                        return $("#session_id").val() > 0 || $("#course_id").val() > 0;
                    },
                    min: 1,
                },
                student_user_id: {
                    required: true,
                    min: 1,
                    remote: {
                        url: "{{route('check.userId.exist')}}",
                        type: "post",
                        data: {
                            user_id: function () {
                                return $("#student-user-id").val();
                            },
                            _token: "{{ csrf_token() }}",
                        },
                        dataFilter: function (response) {
                            // Reverse the response logic: true -> false, false -> true
                            return response === "true" ? "false" : "true";
                        }
                    }
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
                    required: function (element) {
                        return ($("#payment_method_id").val() == 2 || $("#payment_method_id").val() == 3);
                    },
                },
                bank_copy: {
                    required: function (element) {
                        return ($("#payment_method_id").val() == 2 || $("#payment_method_id").val() == 3);
                    },
                    extension: "jpeg|jpg|png|pdf"
                }
            },
            messages: {
                session_id: {
                    required: 'This field is required when a student ID is not provided.',
                },
                course_id: {
                    required: 'This field is required when a student ID is not provided.',
                },
                student_id: {
                    required: 'This field is required when session or course are provided.',
                },
                student_user_id: {
                    required: 'This field is required.',
                    remote: 'No student found with this ID',
                },
                bank_id: {
                    required: 'Bank is required for cash on bank or check payment',
                },
                bank_copy: {
                    required: 'Bank copy is required for cash on bank or check payment',
                    extension: 'Accepted files: jpeg, jpg, png, pdf',
                }
            }
        });

        $(document).ready(function () {
            $('#submitBtn').prop('disabled', true).addClass('not-allowed');

            $("#use_this_total").click(function () {
                var availableAmount = this.value;
                if (this.checked) {
                    Swal.fire({
                        type: 'info',
                        title: 'Set amount & fee',
                        text: "Do you want to use this " + availableAmount + " available amount?",
                        input: 'select',
                        inputOptions: {
                            '1': 'Development Fee',
                            '2': 'Admission Fee',
                            '3': 'Tuition Fee',
                            '4': 'Class Absent Fee',
                            '5': 'Late Fee',
                            '6': 'Re-admission Fee',
                        },
                        allowEscapeKey: false,
                        allowEnterKey: false,
                        allowOutsideClick: false,
                        showCancelButton: true,
                        inputPlaceholder: 'Select Fee',
                        inputValidator: function (value) {
                            console.log(value)
                            return new Promise(function (resolve, reject) {
                                if (value !== '') {
                                    resolve();
                                } else {
                                    resolve('You need to select Fee!');
                                }
                            });
                        }
                    }).then((result) => {
                        if (result.value) {
                            let text;
                            switch (result.value) {
                                case '1':
                                    text = 'Development';
                                    var discount = $("#discount_amount1").val() ?? 0;
                                    var due = $("#student-due-amount-1").val() ?? 0;
                                    var amount = $("#amount1").val() ?? 0;
                                    amount = Number(availableAmount);
                                    if (due > amount) {
                                        amount = Number(amount) - Number(discount);
                                        due = Number(due) - Number(amount);
                                    } else {
                                        amount = due - discount;
                                        due = 0;
                                    }
                                    $("#total1").val(due);
                                    $("#amount1").val(amount);
                                    $("#amount2").val('');
                                    $("#amount3").val('');
                                    $("#amount4").val('');
                                    $("#amount5").val('');
                                    $("#amount6").val('');
                                    break;
                                case '2':
                                    text = 'Admission';
                                    $("#amount1").val('');
                                    var discount = $("#discount_amount2").val() ?? 0;
                                    var due = $("#student-due-amount-2").val() ?? 0;
                                    var amount = $("#amount2").val() ?? 0;
                                    amount = Number(availableAmount) + Number(amount);
                                    if (due > amount) {
                                        amount = Number(amount) - Number(discount);
                                        due = Number(due) - Number(amount);
                                    } else {
                                        amount = due - discount;
                                        due = 0;
                                    }
                                    $("#total2").val(due)
                                    $("#amount2").val(amount);
                                    $("#amount3").val('');
                                    $("#amount4").val('');
                                    $("#amount5").val('');
                                    $("#amount6").val('');
                                    break;
                                case '3':
                                    text = 'Tuition';
                                    $("#amount1").val('');
                                    $("#amount2").val('');
                                    var discount = $("#discount_amount3").val() ?? 0;
                                    var due = $("#student-due-amount-3").val() ?? 0;
                                    var amount = $("#amount3").val() ?? 0;
                                    amount = Number(availableAmount) + Number(amount);
                                    if (due > amount) {
                                        amount = Number(amount) - Number(discount);
                                        due = Number(due) - Number(amount);
                                    } else {
                                        amount = due - discount;
                                        due = 0
                                    }
                                    $("#total3").val(due)
                                    $("#amount3").val(amount);
                                    $("#amount4").val('');
                                    $("#amount5").val('');
                                    $("#amount6").val('');
                                    break;
                                case '4':
                                    text = 'Class Absent';
                                    $("#amount1").val('');
                                    $("#amount2").val('');
                                    $("#amount3").val('');
                                    var discount = $("#discount_amount4").val() ?? 0;
                                    var due = $("#student-due-amount-4").val() ?? 0;
                                    var amount = $("#amount4").val() ?? 0;
                                    amount = Number(availableAmount) + Number(amount);
                                    if (due > amount) {
                                        amount = Number(amount) - Number(discount);
                                        due = Number(due) - Number(amount);
                                    } else {
                                        amount = due - discount;
                                        due = 0
                                    }
                                    $("#total4").val(due)
                                    $("#amount4").val(amount);
                                    $("#amount5").val('');
                                    $("#amount6").val('');
                                    break;
                                case '5':
                                    text = 'Late';
                                    $("#amount1").val('');
                                    $("#amount2").val('');
                                    $("#amount3").val('');
                                    $("#amount4").val('');
                                    var discount = $("#discount_amount5").val() ?? 0;
                                    var due = $("#student-due-amount-5").val() ?? 0;
                                    var amount = $("#amount5").val() ?? 0;
                                    var advance = $("#advance5").val() ?? 0;
                                    amount = Number(availableAmount) + Number(amount);
                                    if (due > amount) {
                                        amount = Number(amount) - Number(discount);
                                        due = Number(due) - Number(amount);
                                    } else {
                                        amount = due - discount;
                                        due = 0
                                    }
                                    $("#total5").val(due)
                                    $("#amount5").val(amount);
                                    $("#advance5").val(advance);
                                    $("#amount6").val('');
                                    break;
                                case '6':
                                    text = 'Re-admission';
                                    $("#amount1").val('');
                                    $("#amount2").val('');
                                    $("#amount3").val('');
                                    $("#amount4").val('');
                                    $("#amount5").val('');
                                    var discount = $("#discount_amount6").val() ?? 0;
                                    var due = $("#student-due-amount-6").val() ?? 0;
                                    var amount = $("#amount6").val() ?? 0;
                                    amount = Number(availableAmount);
                                    if (due > amount) {
                                        amount = Number(amount) - Number(discount);
                                        due = Number(due) - Number(amount);
                                    } else {
                                        amount = due - discount;
                                        due = 0;
                                    }
                                    $("#total6").val(due)
                                    $("#amount6").val(amount);
                                    break;
                            }
                            Swal.fire({
                                allowEscapeKey: false,
                                allowEnterKey: false,
                                allowOutsideClick: false,
                                type: 'success',
                                html: 'You have selected ' + text + ' Fee to use this ' + amount + ' available amount.',
                            });
                            $('.use-this').each(function () {
                                this.checked = true;
                            });
                            $("#submitBtn").removeAttr("disabled", "").removeClass("not-allowed");
                        } else if (result.dismiss === Swal.DismissReason.cancel) {
                            $("#use_this_total").prop("checked", false);
                            $('.use-this').each(function () {
                                this.checked = false;
                            });
                            //clear all amount
                            $(".amount").each(function () {
                                this.value = '';
                            });
                            //clear all total due
                            $(".total-due").each(function () {
                                this.value = '';
                            });
                            //clear all discount
                            $(".discount").each(function () {
                                this.value = '';
                            });
                            $("#submitBtn").attr("disabled", "").addClass("not-allowed");
                        }
                    });
                } else {
                    Swal.fire({
                        type: 'question',
                        title: 'Select Fee',
                        text: "Do you want to remove this " + availableAmount + " available amount from which Fee?",
                        input: 'select',
                        inputOptions: {
                            '1': 'Development Fee',
                            '2': 'Admission Fee',
                            '3': 'Tuition Fee',
                            '4': 'Class Absent Fee',
                            '5': 'Late Fee',
                            '6': 'Re-admission Fee',
                        },
                        allowEscapeKey: false,
                        allowEnterKey: false,
                        allowOutsideClick: false,
                        showCancelButton: true,
                        inputPlaceholder: 'Select a Fee',
                        inputValidator: function (value) {
                            return new Promise(function (resolve, reject) {
                                if (value !== '') {
                                    resolve();
                                } else {
                                    resolve('You need to select a Fee!');
                                }
                            });
                        }
                    }).then((result) => {
                        if (result.value) {
                            let text = nameByType(result.value)[0];
                            let selector = nameByType(result.value)[1];
                            let dueAmount = nameByType(result.value)[2];
                            let totalDue = nameByType(result.value)[3];
                            let discountAmount = nameByType(result.value)[4];
                            var prevAmount = amount = $(selector).val() ?? 0;
                            var due = $(dueAmount).val() ?? 0;
                            var discount = $(discountAmount).val() ?? 0;
                            if (availableAmount < amount) {
                                amount = Number(amount) - Number(availableAmount)
                            } else {
                                amount = '';
                            }
                            due = Number(due) - Number(amount) - Number(discount);
                            $(selector).val(amount);
                            $(totalDue).val(due);
                            $("#use_this_total").prop("checked", false);
                            Swal.fire({
                                allowEscapeKey: false,
                                allowEnterKey: false,
                                allowOutsideClick: false,
                                type: 'success',
                                html: 'You have removed this ' + prevAmount + ' available amount from ' + text + ' Fee.',
                            });
                            $('.use-this').each(function () {
                                this.checked = false;
                            });
                            $("#submitBtn").attr("disabled", "").addClass("not-allowed");
                        } else if (result.dismiss === Swal.DismissReason.cancel) {
                            $("#use_this_total").prop("checked", true);
                            $('.use-this').each(function () {
                                this.checked = true;
                            });
                            $("#submitBtn").removeAttr("disabled", "").removeClass("not-allowed");
                        }
                    });
                }
            });
            $(".use-this").click(function () {
                let typeId
                var availableAmountType = this.value;
                let availableAmount = amountByType(availableAmountType);
                if (this.checked) {
                    Swal.fire({
                        type: 'question',
                        title: 'Select Fee',
                        text: "Do you want to use this available amount?",
                        input: 'select',
                        inputOptions: {
                            '1': 'Development Fee',
                            '2': 'Admission Fee',
                            '3': 'Tuition Fee',
                            '4': 'Class Absent Fee',
                            '5': 'Late Fee',
                            '6': 'Re-admission Fee',
                        },
                        allowEscapeKey: false,
                        allowEnterKey: false,
                        allowOutsideClick: false,
                        showCancelButton: true,
                        inputPlaceholder: 'Select a Fee',
                        inputValidator: function (value) {
                            return new Promise(function (resolve, reject) {
                                if (value !== '') {
                                    typeId = Number(value);
                                    resolve();
                                } else {
                                    resolve('You need to select a Fee!');
                                }
                            });
                        }
                    }).then((result) => {
                        if (result.value) {
                            let text;
                            switch (result.value) {
                                case '1':
                                    text = 'Development';
                                    var discount = $("#discount_amount1").val() ?? 0;
                                    var due = $("#student-due-amount-1").val() ?? 0;
                                    var amount = $("#amount1").val() ?? 0;
                                    amount = Number(availableAmount) + Number(amount);
                                    if (due > amount) {
                                        amount = Number(amount) - Number(discount);
                                        due = Number(due) - Number(amount);
                                    } else {
                                        amount = due - discount;
                                        due = 0;
                                    }
                                    $("#total1").val(due)
                                    $("#amount1").val(amount);
                                    // $("#amount1").attr("data-type", result.value);
                                    // $("#amount2").val('');
                                    // $("#amount3").val('');
                                    // $("#amount4").val('');
                                    // $("#amount5").val('');
                                    // $("#amount6").val('');
                                    break;
                                case '2':
                                    text = 'Admission';
                                    // $("#amount1").val('');
                                    var discount = $("#discount_amount2").val() ?? 0;
                                    var due = $("#student-due-amount-2").val() ?? 0;
                                    var amount = $("#amount2").val() ?? 0;
                                    amount = Number(availableAmount) + Number(amount);
                                    if (due > amount) {
                                        amount = Number(amount) - Number(discount);
                                        due = Number(due) - Number(amount);
                                    } else {
                                        amount = due - discount;
                                        due = 0;
                                    }
                                    $("#total2").val(due)
                                    $("#amount2").val(amount);
                                    // $("#amount3").val('');
                                    // $("#amount4").val('');
                                    // $("#amount5").val('');
                                    // $("#amount6").val('');
                                    break;
                                case '3':
                                    text = 'Tuition';
                                    // $("#amount1").val('');
                                    // $("#amount2").val('');
                                    var discount = $("#discount_amount3").val() ?? 0;
                                    var due = $("#student-due-amount-3").val() ?? 0;
                                    var amount = $("#amount3").val() ?? 0;
                                    amount = Number(availableAmount) + Number(amount);
                                    if (due > amount) {
                                        amount = Number(amount) - Number(discount);
                                        due = Number(due) - Number(amount);
                                    } else {
                                        amount = due - discount;
                                        due = 0
                                    }
                                    $("#total3").val(due)
                                    $("#amount3").val(amount);
                                    // $("#amount4").val('');
                                    // $("#amount5").val('');
                                    // $("#amount6").val('');
                                    break;
                                case '4':
                                    text = 'Class Absent';
                                    // $("#amount1").val('');
                                    // $("#amount2").val('');
                                    // $("#amount3").val('');
                                    var discount = $("#discount_amount4").val() ?? 0;
                                    var due = $("#student-due-amount-4").val() ?? 0;
                                    var amount = $("#amount4").val() ?? 0;
                                    amount = Number(availableAmount) + Number(amount);
                                    if (due > amount) {
                                        amount = Number(amount) - Number(discount);
                                        due = Number(due) - Number(amount);
                                    } else {
                                        amount = due - Number(discount);
                                        due = 0
                                    }
                                    $("#total4").val(due)
                                    $("#amount4").val(amount);
                                    // $("#amount5").val('');
                                    // $("#amount6").val('');
                                    break;
                                case '5':
                                    text = 'Late';
                                    // $("#amount1").val('');
                                    // $("#amount2").val('');
                                    // $("#amount3").val('');
                                    // $("#amount4").val('');
                                    var discount = $("#discount_amount5").val() ?? 0;
                                    var due = $("#student-due-amount-5").val() ?? 0;
                                    var amount = $("#amount5").val() ?? 0;
                                    amount = Number(availableAmount) + Number(amount);
                                    if (due > amount) {
                                        amount = Number(amount) - Number(discount);
                                        due = Number(due) - Number(amount);
                                    } else {
                                        amount = due - discount;
                                        due = 0
                                    }
                                    $("#total5").val(due)
                                    $("#amount5").val(amount);
                                    // $("#amount6").val('');
                                    break;
                                case '6':
                                    text = 'Re-admission';
                                    // $("#amount1").val('');
                                    // $("#amount2").val('');
                                    // $("#amount3").val('');
                                    // $("#amount4").val('');
                                    // $("#amount5").val('');
                                    var discount = $("#discount_amount6").val() ?? 0;
                                    var due = $("#student-due-amount-6").val() ?? 0;
                                    var amount = $("#amount6").val() ?? 0;
                                    amount = Number(availableAmount) + Number(amount);
                                    if (due > amount) {
                                        amount = Number(amount) - Number(discount);
                                        due = Number(due) - Number(amount);
                                    } else {
                                        amount = due - discount;
                                        due = 0;
                                    }
                                    $("#total6").val(due)
                                    $("#amount6").val(amount);
                                    break;
                            }
                            Swal.fire({
                                allowEscapeKey: false,
                                allowEnterKey: false,
                                allowOutsideClick: false,
                                type: 'success',
                                html: 'You have selected ' + text + ' Fee to use this ' + availableAmount + ' available amount.',
                            });
                            if ($('.use-this:checked').length === $('.use-this').length) {
                                $('#use_this_total').prop('checked', true);
                            } else {
                                $('#use_this_total').prop('checked', false);
                            }
                            $("#submitBtn").removeAttr("disabled", "").removeClass("not-allowed");
                        } else if (result.dismiss === Swal.DismissReason.cancel) {
                            $(this).prop("checked", false);
                            if ($('.use-this:checked').length === $('.use-this').length) {
                                $('#use_this_total').prop('checked', true);
                            } else {
                                $('#use_this_total').prop('checked', false);
                            }
                            $("#submitBtn").attr("disabled", "").addClass("not-allowed");
                        }
                    });
                } else {
                    Swal.fire({
                        type: 'question',
                        title: 'Select Fee',
                        text: "Do you want to remove this available amount from which Fee?",
                        input: 'select',
                        inputOptions: {
                            '1': 'Development Fee',
                            '2': 'Admission Fee',
                            '3': 'Tuition Fee',
                            '4': 'Class Absent Fee',
                            '5': 'Late Fee',
                            '6': 'Re-admission Fee',
                        },
                        allowEscapeKey: false,
                        allowEnterKey: false,
                        allowOutsideClick: false,
                        showCancelButton: true,
                        inputPlaceholder: 'Select a Fee',
                        inputValidator: function (value) {
                            return new Promise(function (resolve, reject) {
                                if (value !== '') {
                                    resolve();
                                } else {
                                    resolve('You need to select a Fee!');
                                }
                            });
                        }
                    }).then((result) => {
                        if (result.value) {
                            let text = nameByType(result.value)[0];
                            let selector = nameByType(result.value)[1];
                            let dueAmount = nameByType(result.value)[2];
                            let totalDue = nameByType(result.value)[3];
                            let discountAmount = nameByType(result.value)[4];
                            var availableAmountSum = getTotal();
                            var amount = $(selector).val() ?? 0;
                            var due = $(dueAmount).val() ?? 0;
                            var discount = $(discountAmount).val() ?? 0;
                            if (availableAmountSum < amount) {
                                amount = Number(availableAmountSum);
                            }
                            if (due > amount) {
                                due = Number(due) - Number(amount) - Number(discount);
                            } else {
                                due = 0;
                            }
                            $(selector).val(amount);
                            $(totalDue).val(due);
                            $("#use_this_total").prop("checked", false);
                            Swal.fire({
                                allowEscapeKey: false,
                                allowEnterKey: false,
                                allowOutsideClick: false,
                                type: 'success',
                                html: 'You have removed this ' + availableAmount + ' available amount from ' + text + ' Fee.',
                            });
                            if ($('.use-this:checked').length === $('.use-this').length) {
                                $('#use_this_total').prop('checked', true);
                            } else {
                                $('#use_this_total').prop('checked', false);
                            }
                            $("#submitBtn").attr("disabled", "").addClass("not-allowed");
                        } else if (result.dismiss === Swal.DismissReason.cancel) {
                            $(this).prop("checked", true);
                            if ($('.use-this:checked').length === $('.use-this').length) {
                                $('#use_this_total').prop('checked', true);
                            } else {
                                $('#use_this_total').prop('checked', false);
                            }
                            $("#submitBtn").removeAttr("disabled", "").removeClass("not-allowed");
                        }
                    });
                }
            });

            //get fee name & selector
            function nameByType(type) {
                let text;
                let selector;
                let dueAmount;
                let totalDue;
                let discount;
                switch (type) {
                    case '1':
                        text = 'Development';
                        selector = "#amount1";
                        dueAmount = "#student-due-amount-1";
                        totalDue = "#total1";
                        discount = "#discount_amount1";
                        break;
                    case '2':
                        text = 'Admission';
                        selector = "#amount2";
                        dueAmount = "#student-due-amount-2";
                        totalDue = "#total2";
                        discount = "#discount_amount2";
                        break;
                    case '3':
                        text = 'Tuition';
                        selector = "#amount3";
                        dueAmount = "#student-due-amount-3";
                        totalDue = "#total3";
                        discount = "#discount_amount3";
                        break;
                    case '4':
                        text = 'Class Absent';
                        selector = "#amount4";
                        dueAmount = "#student-due-amount-4";
                        totalDue = "#total4";
                        discount = "#discount_amount4";
                        break;
                    case '5':
                        text = 'Late';
                        selector = "#amount5";
                        dueAmount = "#student-due-amount-5";
                        totalDue = "#total5";
                        discount = "#discount_amount5";
                        break;
                    case '6':
                        text = 'Re-admission';
                        selector = "#amount6";
                        dueAmount = "#student-due-amount-6";
                        totalDue = "#total6";
                        discount = "#discount_amount6";
                        break;
                }
                return [text, selector, dueAmount, totalDue, discount];
            }

            //get amount by type
            function amountByType(availableAmountType) {
                let availableAmount = 0;
                switch (availableAmountType) {
                    case '1':
                        availableAmount = $("#advance1").val();
                        break;
                    case '2':
                        availableAmount = $("#advance2").val();
                        break;
                    case '3':
                        availableAmount = $("#advance3").val();
                        break;
                    case '4':
                        availableAmount = $("#advance4").val();
                        break;
                    case '5':
                        availableAmount = $("#advance5").val();
                        break;
                    case '6':
                        availableAmount = $("#advance6").val();
                        break;
                }
                return availableAmount;
            }

            function getTotal() {
                var availableAmount = 0;
                var total = 0;
                var selector = ".use-this:checked";
                $(selector).each(function () {
                    availableAmount = amountByType($(this).val())
                    total += Number(availableAmount);
                });
                return total;
            }

            $(".m_datepicker_1").datepicker({
                todayHighlight: !0,
                orientation: "bottom left",
                format: 'dd/mm/yyyy',
                autoclose: true,
            });

        });

    </script>
@endpush



