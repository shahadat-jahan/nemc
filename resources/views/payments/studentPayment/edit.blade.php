@extends('layouts.default')
@section('pageTitle', $pageTitle)

@section('content')
    <?php
    $p_one = ''; $p_two = ''; $p_three = '';$p_four = ''; $p_five = ''; $p_six = '';
    $studentPaymentInfo = !empty($studentPayment['info']) ? $studentPayment['info'] : '';
    $payments = $studentPayment['payments'];
    foreach ($payments as $p_value) {
        if ($p_value['payment_type_id'] == 1) {
            $p_one = [
                'p_type' => $p_value['payment_type_id'],
                'p_due' => $p_value['total_due'],
                'p_amount' => $p_value['total_amount'],
                'p_discount' => $p_value['single_total_discount_amount'],
                'p_total' => $p_value['total_due'] > $p_value['total_amount'] ? $p_value['total_due'] - $p_value['total_amount'] - $p_value['single_total_discount_amount'] : 0,
                'p_available_amount' => $p_value['total_due'] < $p_value['total_amount'] ? $p_value['total_amount'] - $p_value['total_due'] - $p_value['single_total_discount_amount'] : 0,
            ];
        }
        if ($p_value['payment_type_id'] == 2) {
            $p_two = [
                'p_type' => $p_value['payment_type_id'],
                'p_due' => $p_value['total_due'],
                'p_amount' => $p_value['total_amount'],
                'p_discount' => $p_value['single_total_discount_amount'],
                'p_total' => $p_value['total_due'] > $p_value['total_amount'] ? $p_value['total_due'] - $p_value['total_amount'] - $p_value['single_total_discount_amount'] : 0,
                'p_available_amount' => $p_value['total_due'] < $p_value['total_amount'] ? $p_value['total_amount'] - $p_value['total_due'] - $p_value['single_total_discount_amount'] : 0,
            ];
        }
        if ($p_value['payment_type_id'] == 3) {
            $p_three = [
                'p_type' => $p_value['payment_type_id'],
                'p_due' => $p_value['total_due'],
                'p_amount' => $p_value['total_amount'],
                'p_discount' => $p_value['single_total_discount_amount'],
                'p_total' => $p_value['total_due'] > $p_value['total_amount'] ? $p_value['total_due'] - $p_value['total_amount'] - $p_value['single_total_discount_amount'] : 0,
                'p_available_amount' => $p_value['total_due'] < $p_value['total_amount'] ? $p_value['total_amount'] - $p_value['total_due'] - $p_value['single_total_discount_amount'] : 0,
            ];
        }
        if ($p_value['payment_type_id'] == 4) {
            $p_four = [
                'p_type' => $p_value['payment_type_id'],
                'p_due' => $p_value['total_due'],
                'p_amount' => $p_value['total_amount'],
                'p_discount' => $p_value['single_total_discount_amount'],
                'p_total' => $p_value['total_due'] > $p_value['total_amount'] ? $p_value['total_due'] - $p_value['total_amount'] - $p_value['single_total_discount_amount'] : 0,
                'p_available_amount' => $p_value['total_due'] < $p_value['total_amount'] ? $p_value['total_amount'] - $p_value['total_due'] - $p_value['single_total_discount_amount'] : 0,
            ];
        }
        if ($p_value['payment_type_id'] == 5) {
            $p_five = [
                'p_type' => $p_value['payment_type_id'],
                'p_due' => $p_value['total_due'],
                'p_amount' => $p_value['total_amount'],
                'p_discount' => $p_value['single_total_discount_amount'],
                'p_total' => $p_value['total_due'] > $p_value['total_amount'] ? $p_value['total_due'] - $p_value['total_amount'] - $p_value['single_total_discount_amount'] : 0,
                'p_available_amount' => $p_value['total_due'] < $p_value['total_amount'] ? $p_value['total_amount'] - $p_value['total_due'] - $p_value['single_total_discount_amount'] : 0,
            ];
        }
        if ($p_value['payment_type_id'] == 6) {
            $p_six = [
                'p_type' => $p_value['payment_type_id'],
                'p_due' => $p_value['total_due'],
                'p_amount' => $p_value['total_amount'],
                'p_discount' => $p_value['single_total_discount_amount'],
                'p_total' => $p_value['total_due'] > $p_value['total_amount'] ? $p_value['total_due'] - $p_value['total_amount'] - $p_value['single_total_discount_amount'] : 0,
                'p_available_amount' => $p_value['total_due'] < $p_value['total_amount'] ? $p_value['total_amount'] - $p_value['total_due'] - $p_value['single_total_discount_amount'] : 0,
            ];
        }
    }
    ?>
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
                        <a href="{{url()->previous()}}" class="btn btn-primary m-btn m-btn--icon"
                           title="Add New Applicant"><i class="fas fa-undo"></i> Back</a>
                    </div>
                </div>

                <form class="m-form m-form--fit m-form--label-align-right"
                      action="{{ route('student.payment.update',!empty($studentPaymentInfo->invoice_no) ? $studentPaymentInfo->invoice_no :'') }}"
                      method="post"
                      id="nemc-general-form" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="m-portlet__body">
                        <div class="row">
                            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                                <div
                                    class="form-group  m-form__group {{ $errors->has('session_id') ? 'has-danger' : '' }}">
                                    <label class="form-control-label"><span class="text-danger">*</span> Session
                                    </label>
                                    <select class="form-control m-input" name="session_id" id="session_id">
                                        <option value="">---- Select Session ----</option>
                                        {!! select($sessions,$studentPaymentInfo->student->session->id) !!}
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
                                                <option
                                                    value="1" {{ $studentPaymentInfo->student->course->id == 1 ? 'selected' : ''}}>
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
                                                <option
                                                    value="2" {{ $studentPaymentInfo->student->course->id == 2 ? 'selected' : ''}}>
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
                                                {!! select($courses, $studentPaymentInfo->student->course->id) !!}
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
                                            {!! select($courses, $studentPaymentInfo->student->course->id ?? Auth::user()->teacher->course_id ?? '') !!}
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
                                    <label class="form-control-label"><span class="text-danger">*</span> Student
                                    </label>
                                    <input type="text" class="form-control m-input"
                                           value="{{ $studentPaymentInfo->student->full_name_en }}" readonly/>
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                                <div class="form-group  m-form__group">
                                    <label class="form-control-label"> Student Roll</label>
                                    <input type="text" class="form-control m-input"
                                           value="{{ $studentPaymentInfo->student->roll_no }}" readonly/>
                                </div>
                                {{-- <div class="form-group  m-form__group">
                                     <label class="form-control-label"><span class="text-danger">*</span> Payment Date </label>
                                     <input type="text" class="form-control m-input" id="student-roll-no" value=""  readonly/>
                                 </div>--}}
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                                <div
                                    class="form-group  m-form__group {{ $errors->has('payment_method_id') ? 'has-danger' : '' }}">
                                    <label class="form-control-label"><span class="text-danger">*</span> Payment Method
                                    </label>
                                    <select class="form-control m-input" name="payment_method_id"
                                            id="payment_method_id">
                                        <option value="">---- Select Payment Method ----</option>
                                        {!! select($paymentMethods, $studentPaymentInfo->paymentMethod ? $studentPaymentInfo->paymentMethod->id : 1) !!}
                                    </select>

                                    @if ($errors->has('payment_method_id'))
                                        <div
                                            class="form-control-feedback">{{ $errors->first('payment_method_id') }}</div>
                                    @endif
                                </div>
                            </div>

                            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                                <div class="form-group  m-form__group">
                                    <label class="form-control-label">Select Bank</label>
                                    <select class="form-control m-input m-bootstrap-select m_selectpicker"
                                            name="bank_id" id="bank_id" data-live-search="true">
                                        <option value="">---- Select Bank ----</option>
                                        {!! select($banks, $studentPaymentInfo->bank ? $studentPaymentInfo->bank->id : 0) !!}
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="row">

                            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                                <div class="form-group m-form__group">
                                    <label for="bankCopy">Bank Copy</label>
                                    <input type="file" class="form-control-file" name="bank_copy" id="bankCopy">
                                    <small id="emailHelp" class="form-text text-muted">Bank copy is not require if you
                                        chose payment method "Cash On NEMC"</small>
                                </div>
                            </div>

                            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                                <div class="form-group  m-form__group">
                                    <label class="form-control-label"><span class="text-danger">*</span> Payment Date
                                    </label>
                                    <!--<input type="text" class="form-control m-input m_datepicker_1" name="payment_date" value="{{ old('payment_date') }}" placeholder="Payment Date" readonly/>-->
                                    <input type="text" class="form-control m-input m_datepicker_1" name="payment_date"
                                           value="{{ old('payment_date', $studentPaymentInfo->payment_date) }}"
                                           placeholder="Payment Date" readonly/>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
                                <div class="card card-items_1 payment-type-static mt-3 col-12 p-0" data-row="0">
                                    <div class="card-header">
                                        <span>Setup Payment Type Wise Amount</span>
                                    </div>
                                    <div class="card-body">
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
                                                        <input type="hidden" class="form-control m-input" value="7"
                                                               style="height: 33px;">
                                                     </span>
                                                </div>
                                            </div>
                                            <div class="col-xs-12 col-sm-12 col-md-2 col-lg-2 col-xl-2">
                                                <div class="form-group  m-form__group">
                                                    <label class="form-control-label">Due Amount</label>
                                                    <span class="subject-list-static">
                                                        <input class="form-control m-input" id="student-due-amount-1"
                                                               value="{{!empty($p_one['p_due']) ? $p_one['p_due'] :''}}"
                                                               style="height: 33px;" readonly>
                                                        <input class="form-control m-input" id="student-due-amount-2"
                                                               value="{{!empty($p_two['p_due']) ? $p_two['p_due']:''}}"
                                                               style="height: 33px;" readonly>
                                                        <input class="form-control m-input" id="student-due-amount-3"
                                                               value="{{!empty($p_three['p_due']) ? $p_three['p_due'] :''}}"
                                                               style="height: 33px;" readonly>
                                                        <input class="form-control m-input" id="student-due-amount-4"
                                                               value="{{!empty($p_four['p_due']) ? $p_four['p_due'] :''}}"
                                                               style="height: 33px;" readonly>
                                                        <input class="form-control m-input" id="student-due-amount-5"
                                                               value="{{!empty($p_five['p_due']) ? $p_five['p_due'] :''}}"
                                                               style="height: 33px;" readonly>
                                                        <input class="form-control m-input" id="student-due-amount-6"
                                                               value="{{!empty($p_six['p_due']) ? $p_six['p_due'] :''}}"
                                                               style="height: 33px;" readonly>
                                                        <input type="hidden" class="form-control m-input"
                                                               id="student-due-amount-7" value="" style="height: 33px;"
                                                               readonly>
                                                     </span>
                                                </div>
                                            </div>

                                            <div class="col-xs-12 col-sm-12 col-md-2 col-lg-2 col-xl-2">
                                                <div
                                                    class="form-group  m-form__group {{ $errors->has('amount') ? 'has-danger' : '' }}">
                                                    <label class="form-control-label">Discount Amount </label>
                                                    <input type="number" min="1" onkeyup="findTotalOne()"
                                                           id="discount_amount1" class="form-control m-input"
                                                           name="discount_amount[]"
                                                           value="{{!empty($p_one['p_discount']) ? $p_one['p_discount']==0 ? '' :$p_one['p_discount'] :''}}"
                                                           placeholder="Discount Amount"/>
                                                    <input type="number" min="1" onkeyup="findTotalTwo()"
                                                           id="discount_amount2" class="form-control m-input"
                                                           name="discount_amount[]"
                                                           value="{{ !empty($p_two['p_discount']) ? $p_two['p_discount']==0 ? '' :$p_two['p_discount'] :'' }}"
                                                           placeholder="Discount Amount"/>
                                                    <input type="number" min="1" onkeyup="findTotalThree()"
                                                           id="discount_amount3" class="form-control m-input"
                                                           name="discount_amount[]"
                                                           value="{{!empty($p_three['p_discount']) ? $p_three['p_discount']==0 ? '' :$p_three['p_discount']:'' }}"
                                                           placeholder="Discount Amount"/>
                                                    <input type="number" min="1" onkeyup="findTotalFour()"
                                                           id="discount_amount4" class="form-control m-input"
                                                           name="discount_amount[]"
                                                           value="{{ !empty($p_four['p_discount']) ? $p_four['p_discount']==0 ? '' :$p_four['p_discount'] :'' }}"
                                                           placeholder="Discount Amount"/>
                                                    <input type="number" min="1" onkeyup="findTotalFive()"
                                                           id="discount_amount5" class="form-control m-input"
                                                           name="discount_amount[]"
                                                           value="{{ !empty($p_five['p_discount']) ? $p_five['p_discount']==0 ? '' :$p_five['p_discount'] :'' }}"
                                                           placeholder="Discount Amount"/>
                                                    <input type="number" min="1" onkeyup="findTotalSix()"
                                                           id="discount_amount6" class="form-control m-input"
                                                           name="discount_amount[]"
                                                           value="{{ !empty($p_six['p_discount']) ?$p_six['p_discount']==0 ? '' :$p_six['p_discount'] :'' }}"
                                                           placeholder="Discount Amount"/>
                                                    @if ($errors->has('discount_amount'))
                                                        <div
                                                            class="form-control-feedback">{{ $errors->first('discount_amount') }}</div>
                                                    @endif
                                                </div>
                                            </div>

                                            <div class="col-xs-12 col-sm-12 col-md-2 col-lg-2 col-xl-2">
                                                <div
                                                    class="form-group  m-form__group {{ $errors->has('amount') ? 'has-danger' : '' }}">
                                                    <label class="form-control-label">Amount </label>
                                                    <input type="number" min="1" onkeyup="findTotalOne()" id="amount1"
                                                           class="form-control m-input" name="amount[]"
                                                           value="{{ !empty($p_one['p_amount']) ? $p_one['p_amount'] :'' }}"
                                                           placeholder="Amount"/>
                                                    <input type="number" min="1" onkeyup="findTotalTwo()" id="amount2"
                                                           class="form-control m-input" name="amount[]"
                                                           value="{{ !empty($p_two['p_amount']) ? $p_two['p_amount'] :'' }}"
                                                           placeholder="Amount"/>
                                                    <input type="number" min="1" onkeyup="findTotalThree()" id="amount3"
                                                           class="form-control m-input" name="amount[]"
                                                           value="{{ !empty($p_three['p_amount']) ? $p_three['p_amount'] :'' }}"
                                                           placeholder="Amount"/>
                                                    <input type="number" min="1" onkeyup="findTotalFour()" id="amount4"
                                                           class="form-control m-input" name="amount[]"
                                                           value="{{ !empty($p_four['p_amount']) ? $p_four['p_amount'] :'' }}"
                                                           placeholder="Amount"/>
                                                    <input type="number" min="1" onkeyup="findTotalFive()" id="amount5"
                                                           class="form-control m-input" name="amount[]"
                                                           value="{{ !empty($p_five['p_amount']) ? $p_five['p_amount'] :'' }}"
                                                           placeholder="Amount"/>
                                                    <input type="number" min="1" onkeyup="findTotalSix()" id="amount6"
                                                           class="form-control m-input" name="amount[]"
                                                           value="{{ !empty($p_six['p_amount']) ? $p_six['p_amount'] :'' }}"
                                                           placeholder="Amount"/>
                                                    @if ($errors->has('amount'))
                                                        <div
                                                            class="form-control-feedback">{{ $errors->first('amount') }}</div>
                                                    @endif
                                                </div>
                                            </div>

                                            <div class="col-xs-12 col-sm-12 col-md-2 col-lg-2 col-xl-2">
                                                <div
                                                    class="form-group  m-form__group {{ $errors->has('amount') ? 'has-danger' : '' }}">
                                                    <label class="form-control-label">Total Due </label>
                                                    <input type="text" class="form-control m-input"
                                                           value="{{!empty($p_one['p_total']) ? $p_one['p_total'] :0 }}"
                                                           id="total1" readonly=""/>
                                                    <input type="text" class="form-control m-input"
                                                           value="{{!empty($p_two['p_total']) ? $p_two['p_total'] :0 }}"
                                                           id="total2" readonly=""/>
                                                    <input type="text" class="form-control m-input"
                                                           value="{{!empty($p_three['p_total']) ? $p_three['p_total'] :0 }}"
                                                           id="total3" readonly=""/>
                                                    <input type="text" class="form-control m-input"
                                                           value="{{!empty($p_four['p_total']) ? $p_four['p_total']:0 }}"
                                                           id="total4" readonly=""/>
                                                    <input type="text" class="form-control m-input"
                                                           value="{{!empty($p_five['p_total']) ? $p_five['p_total'] :0 }}"
                                                           id="total5" readonly=""/>
                                                    <input type="text" class="form-control m-input"
                                                           value="{{!empty($p_six['p_total']) ? $p_six['p_total'] :0 }}"
                                                           id="total6" readonly=""/>
                                                </div>
                                            </div>
                                            <div class="col-xs-12 col-sm-12 col-md-2 col-lg-2 col-xl-2">
                                                <div
                                                    class="form-group  m-form__group {{ $errors->has('amount') ? 'has-danger' : '' }}">
                                                    <label class="form-control-label">Advance Amount </label>
                                                    <input type="text" class="form-control m-input"
                                                           value="{{!empty($p_one['p_available_amount']) ? $p_one['p_available_amount'] :0 }}"
                                                           id="total1" readonly=""/>
                                                    <input type="text" class="form-control m-input"
                                                           value="{{!empty($p_two['p_available_amount']) ? $p_two['p_available_amount'] :0 }}"
                                                           id="total2" readonly=""/>
                                                    <input type="text" class="form-control m-input"
                                                           value="{{!empty($p_three['p_available_amount']) ? $p_three['p_available_amount'] :0 }}"
                                                           id="total3" readonly=""/>
                                                    <input type="text" class="form-control m-input"
                                                           value="{{!empty($p_four['p_available_amount']) ? $p_four['p_available_amount']:0 }}"
                                                           id="total4" readonly=""/>
                                                    <input type="text" class="form-control m-input"
                                                           value="{{!empty($p_five['p_available_amount']) ? $p_five['p_available_amount'] :0 }}"
                                                           id="total5" readonly=""/>
                                                    <input type="text" class="form-control m-input"
                                                           value="{{!empty($p_six['p_available_amount']) ? $p_six['p_available_amount'] :0 }}"
                                                           id="total6" readonly=""/>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="m-separator m-separator--dashed m-separator--lg"
                                             style="width: 100%"></div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
                                <div class="form-group  m-form__group">
                                    <label class="form-control-label">Remarks</label>
                                    <textarea class="form-control m-input" name="remarks"
                                              placeholder="Remarks about payment">{{ old('remarks', $studentPaymentInfo->remarks) }}</textarea>
                                </div>
                            </div>
                        </div>
                    </div>


                    <div class="m-portlet__foot m-portlet__foot--fit">
                        <div class="m-form__actions text-center">
                            <a href="{{route('student.payment.list')}}" class="btn btn-outline-brand"><i
                                    class="fa fa-times"></i> Cancel</a>
                            <button type="submit" class="btn btn-success"><i class="fa fa-save"></i> Update</button>
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


        //        $('#student-discount-amount-1,#student-amount-1').keypress(function() {
        //            var dInput = this.value;
        //            var studentDueAmount_1 = $('#student-due-amount-1').val();
        //            var studentDiscountAmount_1 = $('#student-discount-amount-1').val();
        //            var studentAmount_1 = $('#student-amount-1').val();
        //
        //            console.log(studentDiscountAmount_1);
        //            console.log(studentDueAmount_1);
        //            console.log(studentAmount_1);
        ////            $(".dDimension:contains('" + dInput + "')").css("display","block");
        //        });


        function findTotalOne() {
            var studentDueAmount_1 = $('#student-due-amount-1').val();
            var studentDiscountAmount_1 = $('#discount_amount1').val();
            var studentAmount_1 = $('#amount1').val();

            var totalAmount1 = studentDueAmount_1 - studentDiscountAmount_1 - studentAmount_1;
            if (totalAmount1 >= 0) {
                //document.getElementById('total1').value = 1;
                $("#total1").removeAttr('required');
                $("#submitBtn").removeAttr("disabled", "");
                document.getElementById('total1').value = studentDueAmount_1 - studentDiscountAmount_1 - studentAmount_1;
            } else {
                alert('Development Fee Please Adjust or les Total Due Amount');
                document.getElementById('total1').value = studentDueAmount_1 - studentDiscountAmount_1 - studentAmount_1;
                var el = document.getElementById("total1");
                var ele = document.getElementById("submitBtn");
                el.setAttribute("required", "required");
                ele.setAttribute("disabled", "");
                return false;
            }
        }

        function findTotalTwo() {
            var studentDueAmount_2 = $('#student-due-amount-2').val();
            var studentDiscountAmount_2 = $('#discount_amount2').val();
            var studentAmount_2 = $('#amount2').val();
            var totalAmount2 = studentDueAmount_2 - studentDiscountAmount_2 - studentAmount_2;
            if (totalAmount2 >= 0) {
                //document.getElementById('total1').value = 1;
                $("#total2").removeAttr('required');
                $("#submitBtn").removeAttr("disabled", "");
                document.getElementById('total2').value = studentDueAmount_2 - studentDiscountAmount_2 - studentAmount_2;
            } else {
                alert('Admission Fee Please Adjust or les Total Due Amount');
                document.getElementById('total2').value = studentDueAmount_2 - studentDiscountAmount_2 - studentAmount_2;
                var el = document.getElementById("total2");
                var ele = document.getElementById("submitBtn");
                el.setAttribute("required", "required");
                ele.setAttribute("disabled", "");
                return false;
            }
        }

        function findTotalThree() {
            var studentDueAmount_3 = $('#student-due-amount-3').val();
            var studentDiscountAmount_3 = $('#discount_amount3').val();
            var studentAmount_3 = $('#amount3').val();
            var totalAmount3 = studentDueAmount_3 - studentDiscountAmount_3 - studentAmount_3;
            document.getElementById('total3').value = studentDueAmount_3 - studentDiscountAmount_3 - studentAmount_3;
        }

        function findTotalFour() {
            var studentDueAmount_4 = $('#student-due-amount-4').val();
            var studentDiscountAmount_4 = $('#discount_amount4').val();
            var studentAmount_4 = $('#amount4').val();

            var totalAmount4 = studentDueAmount_4 - studentDiscountAmount_4 - studentAmount_4;
            if (totalAmount4 >= 0) {
                //document.getElementById('total1').value = 1;
                $("#total4").removeAttr('required');
                $("#submitBtn").removeAttr("disabled", "");
                document.getElementById('total4').value = studentDueAmount_4 - studentDiscountAmount_4 - studentAmount_4;
            } else {
                alert('Development Fee Please Adjust or les Total Due Amount');
                document.getElementById('total4').value = studentDueAmount_4 - studentDiscountAmount_4 - studentAmount_4;
                var el = document.getElementById("total4");
                var ele = document.getElementById("submitBtn");
                el.setAttribute("required", "required");
                ele.setAttribute("disabled", "");
                return false;
            }
        }

        function findTotalFive() {
            var studentDueAmount_5 = $('#student-due-amount-5').val();
            var studentDiscountAmount_5 = $('#discount_amount5').val();
            var studentAmount_5 = $('#amount5').val();

            var totalAmount5 = studentDueAmount_5 - studentDiscountAmount_5 - studentAmount_5;
            if (totalAmount5 >= 0) {
                //document.getElementById('total1').value = 1;
                $("#total5").removeAttr('required');
                $("#submitBtn").removeAttr("disabled", "");
                document.getElementById('total5').value = studentDueAmount_5 - studentDiscountAmount_5 - studentAmount_5;
            } else {
                alert('Development Fee Please Adjust or les Total Due Amount');
                document.getElementById('total5').value = studentDueAmount_5 - studentDiscountAmount_5 - studentAmount_5;
                var el = document.getElementById("total5");
                var ele = document.getElementById("submitBtn");
                el.setAttribute("required", "required");
                ele.setAttribute("disabled", "");
                return false;
            }
        }

        function findTotalSix() {
            var studentDueAmount_6 = $('#student-due-amount-6').val();
            var studentDiscountAmount_6 = $('#discount_amount6').val();
            var studentAmount_6 = $('#amount6').val();

            var totalAmount6 = studentDueAmount_6 - studentDiscountAmount_6 - studentAmount_6;
            if (totalAmount6 >= 0) {
                //document.getElementById('total1').value = 1;
                $("#total6").removeAttr('required');
                $("#submitBtn").removeAttr("disabled", "");
                document.getElementById('total6').value = studentDueAmount_6 - studentDiscountAmount_6 - studentAmount_6;
            } else {
                alert('Development Fee Please Adjust or les Total Due Amount');
                document.getElementById('total6').value = studentDueAmount_6 - studentDiscountAmount_6 - studentAmount_6;
                var el = document.getElementById("total6");
                var ele = document.getElementById("submitBtn");
                el.setAttribute("required", "required");
                ele.setAttribute("disabled", "");
                return false;
            }
        }


        //
        //        function findTotal(){
        //            var arr = document.getElementsByName('discount_amount[]');
        //            var tot=0;
        //            for(var i=0;i<arr.length;i++){
        //                if(parseInt(arr[i].value))
        //                    tot += parseInt(arr[i].value);
        //            }
        //
        //            var am = document.getElementsByName('amount[]');
        //            var amount=0;
        //            for(var i=0;i<am.length;i++){
        //                if(parseInt(am[i].value))
        //                    amount += parseInt(am[i].value);
        //            }
        //
        //            var studentDueAmount_1 = $('#student-due-amount-1').val();
        //            var totalAmount=studentDueAmount_1-tot-amount;
        //            if(totalAmount > 0){
        //                document.getElementById('total').value = 1;
        //                $("#total").removeAttr('required');
        //                $("#submitBtn").removeAttr("disabled", "");
        //                document.getElementById('total').value = studentDueAmount_1-tot-amount;
        //            }else{
        //                alert('Value is required..');
        //                document.getElementById('total').value = studentDueAmount_1-tot-amount;
        //                var el = document.getElementById("total");
        //                var ele = document.getElementById("submitBtn");
        //                //$("#submitBtn").attr('disabled');
        //                el.setAttribute("required", "required");
        //                ele.setAttribute("disabled", "");
        //
        //
        //                return false;
        //                //document.getElementById('total').value = 2;
        //            }
        //
        //            //document.getElementById('total').value = studentDueAmount_1-tot-amount;
        //
        //        }

        $('#student-discount-amount-1,#student-amount-1').on('keyup', function () {
            var studentDueAmount_1 = $('#student-due-amount-1').val();
            var studentDiscountAmount_1 = $('#student-discount-amount-1').val();
            var studentAmount_1 = $('#student-amount-1').val();

            totalamount = studentDiscountAmount_1 + studentAmount_1;

            console.log(studentDueAmount_1);
            console.log(totalamount);
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
//                    for (i in response.data){
//                        subject = response.data[i];
//                        row.append('<option value="'+subject.id+'">'+subject.title+'</option>')
//                    }
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

        //get student roll number by student id
        //        $('#student_id').change(function () {
        //            studentId = $('#student_id').val();
        //            if(studentId > 0){
        //                $.get('<?php //echo e(route('get.single.student.roll')); ?>', {
        //                    studentId: studentId, _token: "<?php //echo e(csrf_token()); ?>"
        //                }, function (response) {
        //                    studentRollNumber = response;
        //                    $("#student-roll-no").val(studentRollNumber);
        //                });
        //            }
        //        });

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
                    console.log(response);
                    for (var i = 0; i < response.length; i++) {
                        if (response[i].payment_type_id == 1) {
                            $("#student-due-amount-1").val(response[i].total_due);
                        }
                        if (response[i].payment_type_id == 2) {
                            $("#student-due-amount-2").val(response[i].total_due);
                        }
                        if (response[i].payment_type_id == 3) {
                            $("#student-due-amount-3").val(response[i].total_due);
                        }
                        if (response[i].payment_type_id == 4) {
                            $("#student-due-amount-4").val(response[i].total_due);
                        }
                        if (response[i].payment_type_id == 5) {
                            $("#student-due-amount-5").val(response[i].total_due);
                        }
                        if (response[i].payment_type_id == 6) {
                            $("#student-due-amount-6").val(response[i].total_due);
                        }
                    }
//                    if(response[0].payment_type_id==1){
//                        $("#student-due-amount-1").val(response[0].total_due);
//                    }else{
//                       $("#student-due-amount-1").val('');
//                    }

                    studentRollNumber = response[0].roll_no;
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
            if (studentId > 0 && paymentTypeId > 0) {
                //generate route with student and payment type
                routeWithIds = urlRouteName + '?student_id=' + studentId + '&payment_type_id=' + paymentTypeId;

                //set url to href
                $("#student-fee-detail-route").attr("href", routeWithIds);
                //show button when select student and payment type
                $("#student-fee-detail-route").removeClass("d-none");
            }
        });

        // form validations
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
                    required: function (element) {
                        return ($("#payment_method_id").val() == 2 || $("#payment_method_id").val() == 3);
                    },
                },
                bank_copy: {
                     required: function(element){
                         return ($("#payment_method_id").val() == 2 || $("#payment_method_id").val() == 3);
                     },
                    extension: "jpeg|jpg|png|pdf"
                }
            },
            messages: {
                student_id: {
                    remote: 'Payment already generated'
                },
                bank_id: {
                    required: 'Bank is required for cash on bank or check payment'
                },
                bank_copy: {
                     required: 'Bank copy is required for cash on bank or check payment',
                    extension: 'Accepted files: jpeg, jpg, png, pdf',
                }
            }
        });

        $(document).ready(function () {
            $(".m_datepicker_1").datepicker({
                todayHighlight: !0,
                orientation: "bottom left",
                format: 'dd/mm/yyyy',
            });

        });

    </script>
@endpush
