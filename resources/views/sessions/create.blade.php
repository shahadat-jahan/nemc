@extends('layouts.default')
@section('pageTitle', $pageTitle)

@section('content')

    <div class="row mbbs-phase-subjects m--hide">
        <div class="col-xs-12 col-sm-12 col-md-2 col-lg-2 col-xl-2">
            <div class="form-group  m-form__group">
                <label class="form-control-label"><span class="text-danger">*</span> Phase </label>
                <select class="form-control m-input mbbs-phases" name="mbbs_phase[]">
                    <option value="">---- Select ----</option>
                    {!! select($phases) !!}
                </select>
            </div>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-2 col-lg-2 col-xl-2">
            <div class="form-group  m-form__group">
                <label class="form-control-label"><span class="text-danger">*</span>  Total Term </label>
                <input type="text" class="form-control m-input mbbs-terms" name="mbbs_phase_term[]" placeholder="Terms"/>
            </div>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-2 col-lg-2 col-xl-2">
            <div class="form-group  m-form__group">
                <label class="form-control-label"> Duration </label>
                <input type="text" class="form-control m-input" name="mbbs_phase_duration[]" placeholder="Duration"/>
            </div>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-2 col-lg-2 col-xl-2">
            <div class="form-group  m-form__group">
                <label class="form-control-label"> Exam Title </label>
                <input type="text" class="form-control m-input" name="mbbs_exam_title[]" placeholder="Exam Title"/>
            </div>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4 col-xl-4">
            <div class="form-group  m-form__group">
                <label class="form-control-label"><span class="text-danger">*</span> Subjects </label>
                <select class="form-control mbbs-subjects" name="mbbs_phase_subjects[0][]" multiple>
                    <option value="">---- Select ----</option>
                    {!! select($mbbs_subjects) !!}
                </select>
            </div>
        </div>
    </div>

    <div class="row bds-phase-subjects m--hide">
        <div class="col-xs-12 col-sm-12 col-md-2 col-lg-2 col-xl-2">
            <div class="form-group  m-form__group">
                <label class="form-control-label"><span class="text-danger">*</span> Phase </label>
                <select class="form-control m-input bds-phases" name="bds_phase[]">
                    <option value="">---- Select ----</option>
                    {!! select($phases) !!}
                </select>
            </div>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-2 col-lg-2 col-xl-2">
            <div class="form-group  m-form__group">
                <label class="form-control-label"><span class="text-danger">*</span>  Total Term </label>
                <input type="text" class="form-control m-input bds-terms" name="bds_phase_term[]" placeholder="Terms"/>
            </div>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-2 col-lg-2 col-xl-2">
            <div class="form-group  m-form__group">
                <label class="form-control-label"> Duration </label>
                <input type="text" class="form-control m-input" name="bds_phase_duration[]" placeholder="Duration"/>
            </div>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-2 col-lg-2 col-xl-2">
            <div class="form-group  m-form__group">
                <label class="form-control-label"> Exam Title </label>
                <input type="text" class="form-control m-input" name="bds_exam_title[]" placeholder="Exam Title"/>
            </div>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4 col-xl-4">
            <div class="form-group  m-form__group">
                <label class="form-control-label"><span class="text-danger">*</span> Subjects </label>
                <select class="form-control bds-subjects" name="bds_phase_subjects[0][]" multiple>
                    <option value="">---- Select ----</option>
                    {!! select($bds_subjects) !!}
                </select>
            </div>
        </div>
    </div>


    <div class="m-portlet m-portlet--tab">
        <div class="m-portlet__head">
            <div class="m-portlet__head-caption">
                <div class="m-portlet__head-title">
                    <h3 class="m-portlet__head-text"><i class="far fa-plus-square pr-2"></i>Create Session</h3>
                </div>
            </div>
            <div class="m-portlet__head-tools">
                <a href="{{ url('admin/sessions') }}" class="btn btn-primary m-btn m-btn--icon"><i class="flaticon-calendar-2 pr-2"></i>Sessions</a>
            </div>
        </div>

        <!--begin: Form Wizard-->
        <div class="m-wizard m-wizard--2 m-wizard--success" id="m_wizard">

            <!--begin: Message container -->
            <div class="m-portlet__padding-x">

                <!-- Here you can put a message or alert -->
            </div>

            <!--end: Message container -->

            <!--begin: Form Wizard Head -->
            <div class="m-wizard__head m-portlet__padding-x">

                <!--begin: Form Wizard Progress -->
                <div class="m-wizard__progress">
                    <div class="progress">
                        <div class="progress-bar" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                </div>

                <!--end: Form Wizard Progress -->

                <!--begin: Form Wizard Nav -->
                <div class="m-wizard__nav">
                    <div class="m-wizard__steps">
                        <div class="m-wizard__step m-wizard__step--current" m-wizard-target="m_wizard_form_step_1">
                            <a href="#" class="m-wizard__step-number">
                                <span><i class="flaticon-calendar-2"></i></span>
                            </a>
                            <div class="m-wizard__step-info">
                                <div class="m-wizard__step-title">1. Session</div>
                                <div class="m-wizard__step-desc">New batch for a calendar year</div>
                            </div>
                        </div>
                        <div class="m-wizard__step" m-wizard-target="m_wizard_form_step_2">
                            <a href="#" class="m-wizard__step-number">
                                <span><i class="fa  fas fa-book-reader"></i></span>
                            </a>
                            <div class="m-wizard__step-info">
                                <div class="m-wizard__step-title">2. MBBS</div>
                                <div class="m-wizard__step-desc">Setup MBBS course</div>
                            </div>
                        </div>
                        <div class="m-wizard__step" m-wizard-target="m_wizard_form_step_3">
                            <a href="#" class="m-wizard__step-number">
                                <span><i class="fa  fas fa-book-reader"></i></span>
                            </a>
                            <div class="m-wizard__step-info">
                                <div class="m-wizard__step-title">3. BDS</div>
                                <div class="m-wizard__step-desc">Setup BDS Course</div>
                            </div>
                        </div>
                    </div>
                </div>

                <!--end: Form Wizard Nav -->
            </div>

            <!--end: Form Wizard Head -->

            <!--begin: Form Wizard Form-->
            <div class="m-wizard__form">
                <form action="{{route('sessions.store')}}" method="post" class="m-form m-form--label-align-left- m-form--state-" id="nemc_wizard_form">
                @csrf
                    <!--begin: Form Body -->
                    <div class="m-portlet__body">

                        <!--begin: Form Wizard Step 1-->
                        <div class="m-wizard__form-step m-wizard__form-step--current" id="m_wizard_form_step_1">
                            <div class="row">
                                <div class="col-xl-12">
                                    <div class="m-form__section m-form__section--first">
                                        <div class="form-group m-form__group row">
                                            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                                                <div class="form-group  m-form__group {{ $errors->has('title') ? 'has-danger' : '' }}">
                                                    <label class="form-control-label"><span class="text-danger">*</span> Session Title </label>
                                                    <input type="text" class="form-control m-input" name="title" placeholder="Enter Session Like 2020-2021">
                                                    @if ($errors->has('title'))
                                                        <div class="form-control-feedback">{{ $errors->first('title') }}</div>
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                                                <div class="form-group  m-form__group {{ $errors->has('start_year') ? 'has-danger' : '' }}">
                                                    <label class="form-control-label"><span class="text-danger">*</span> Start Year </label>
                                                    <input type="text" class="form-control m-input date-own" name="start_year" placeholder="Session Start Year">
                                                    @if ($errors->has('start_year'))
                                                        <div class="form-control-feedback">{{ $errors->first('start_year') }}</div>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                        <!--end: Form Wizard Step 1-->

                        <!--begin: Form Wizard Step 2-->
                        <div class="m-wizard__form-step" id="m_wizard_form_step_2">
                            <input type="hidden" name="mbbs_course_id" value="1">
                            <div class="row">
                                <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                                    <div class="form-group  m-form__group {{ $errors->has('mbbs_development_fee_local') ? 'has-danger' : '' }}">
                                        <label class="form-control-label"><span class="text-danger">*</span> Development Fee (Local) </label>
                                        <input type="number" class="form-control m-input" name="mbbs_development_fee_local" placeholder="Development Fee"/>
                                        @if ($errors->has('mbbs_development_fee_local'))
                                            <div class="form-control-feedback">{{ $errors->first('mbbs_development_fee_local') }}</div>
                                        @endif
                                        <span class="m-form__help">in TK</span>
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                                    <div class="form-group  m-form__group {{ $errors->has('mbbs_development_fee_foreign') ? 'has-danger' : '' }}">
                                        <label class="form-control-label"><span class="text-danger">*</span> Development Fee (Foreign) :</label>
                                        <input type="number" class="form-control m-input" name="mbbs_development_fee_foreign" placeholder="Development Fee"/>
                                        @if ($errors->has('mbbs_development_fee_foreign'))
                                            <div class="form-control-feedback">{{ $errors->first('mbbs_development_fee_foreign') }}</div>
                                        @endif
                                        <span class="m-form__help">in USD</span>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                                    <div class="form-group  m-form__group {{ $errors->has('mbbs_tuition_fee_local') ? 'has-danger' : '' }}">
                                        <label class="form-control-label"><span class="text-danger">*</span> Tuition Fee (Local) </label>
                                        <input type="number" class="form-control m-input" name="mbbs_tuition_fee_local" placeholder="Tuition Fee"/>
                                        @if ($errors->has('mbbs_tuition_fee_local'))
                                            <div class="form-control-feedback">{{ $errors->first('mbbs_tuition_fee_local') }}</div>
                                        @endif
                                        <span class="m-form__help">in TK</span>
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                                    <div class="form-group  m-form__group {{ $errors->has('mbbs_tuition_fee_foreign') ? 'has-danger' : '' }}">
                                        <label class="form-control-label"><span class="text-danger">*</span> Tuition Fee (Foreign) </label>
                                        <input type="number" class="form-control m-input" name="mbbs_tuition_fee_foreign" placeholder="Tuition Fee"/>
                                        @if ($errors->has('mbbs_tuition_fee_foreign'))
                                            <div class="form-control-feedback">{{ $errors->first('mbbs_tuition_fee_foreign') }}</div>
                                        @endif
                                        <span class="m-form__help">in USD</span>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                                    <div class="form-group  m-form__group {{ $errors->has('mbbs_batch_number') ? 'has-danger' : '' }}">
                                        <label class="form-control-label"><span class="text-danger">*</span> Batch Number </label>
                                        <input type="text" class="form-control m-input" name="mbbs_batch_number" id="mbbs_batch_number" placeholder="Batch Number"/>
                                        @if ($errors->has('mbbs_batch_number'))
                                            <div class="form-control-feedback">{{ $errors->first('mbbs_batch_number') }}</div>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                                    <div class="form-group  m-form__group {{ $errors->has('mbbs_total_phases') ? 'has-danger' : '' }}">
                                        <label class="form-control-label"><span class="text-danger">*</span> How many phases? </label>
                                        <select class="form-control m-input" name="mbbs_total_phases" id="mbbs-phase">
                                            <option value="">---- Select ----</option>
                                            @for ($i = 1; $i <= 5; $i++)
                                                <option value="{{$i}}">{{$i}}</option>
                                            @endfor
                                        </select>
                                        @if ($errors->has('mbbs_total_phases'))
                                            <div class="form-control-feedback">{{ $errors->first('mbbs_total_phases') }}</div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div id="mbbs-generated-fields" class="m--hide"></div>
                        </div>
                        <!--end: Form Wizard Step 2-->

                        <!--begin: Form Wizard Step 3-->
                        <div class="m-wizard__form-step" id="m_wizard_form_step_3">

                            <input type="hidden" name="bds_course_id" value="2">
                            <div class="row">
                                <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                                    <div class="form-group  m-form__group {{ $errors->has('bds_development_fee_local') ? 'has-danger' : '' }}">
                                        <label class="form-control-label"><span class="text-danger">*</span> Development Fee (Local) </label>
                                        <input type="number" class="form-control m-input" name="bds_development_fee_local" placeholder="Development Fee"/>
                                        @if ($errors->has('bds_development_fee_local'))
                                            <div class="form-control-feedback">{{ $errors->first('bds_development_fee_local') }}</div>
                                        @endif
                                        <span class="m-form__help">in TK</span>
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                                    <div class="form-group  m-form__group {{ $errors->has('bds_development_fee_foreign') ? 'has-danger' : '' }}">
                                        <label class="form-control-label"> Development Fee (Foreign) </label>
                                        <input type="text" class="form-control m-input" name="bds_development_fee_foreign" placeholder="Development Fee"/>
                                        @if ($errors->has('bds_development_fee_foreign'))
                                            <div class="form-control-feedback">{{ $errors->first('bds_development_fee_foreign') }}</div>
                                        @endif
                                        <span class="m-form__help">in USD</span>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                                    <div class="form-group  m-form__group {{ $errors->has('bds_tuition_fee_local') ? 'has-danger' : '' }}">
                                        <label class="form-control-label"><span class="text-danger">*</span> Tuition Fee (Local) </label>
                                        <input type="number" class="form-control m-input" name="bds_tuition_fee_local" placeholder="Tuition Fee"/>
                                        @if ($errors->has('bds_tuition_fee_local'))
                                            <div class="form-control-feedback">{{ $errors->first('bds_tuition_fee_local') }}</div>
                                        @endif
                                        <span class="m-form__help">in TK</span>
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                                    <div class="form-group  m-form__group {{ $errors->has('bds_tuition_fee_foreign') ? 'has-danger' : '' }}">
                                        <label class="form-control-label"> Tuition Fee (Foreign) </label>
                                        <input type="number" class="form-control m-input" name="bds_tuition_fee_foreign" placeholder="Tuition Fee"/>
                                        @if ($errors->has('bds_tuition_fee_foreign'))
                                            <div class="form-control-feedback">{{ $errors->first('bds_tuition_fee_foreign') }}</div>
                                        @endif
                                        <span class="m-form__help">in USD</span>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                                    <div class="form-group  m-form__group {{ $errors->has('bds_batch_number') ? 'has-danger' : '' }}">
                                        <label class="form-control-label"><span class="text-danger">*</span> Batch Number </label>
                                        <input type="number" class="form-control m-input" id="bds_batch_number" name="bds_batch_number" placeholder="Batch Number"/>
                                        @if ($errors->has('bds_batch_number'))
                                            <div class="form-control-feedback">{{ $errors->first('bds_batch_number') }}</div>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                                    <div class="form-group  m-form__group {{ $errors->has('bds_total_phases') ? 'has-danger' : '' }}">
                                        <label class="form-control-label"><span class="text-danger">*</span> How many phases? </label>
                                        <select class="form-control m-input" name="bds_total_phases" id="bds-phase">
                                            <option value="">---- Select ----</option>
                                            @for ($i = 1; $i <= 5; $i++)
                                                <option value="{{$i}}">{{$i}}</option>
                                            @endfor
                                        </select>
                                        @if ($errors->has('bds_total_phases'))
                                            <div class="form-control-feedback">{{ $errors->first('bds_total_phases') }}</div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div id="bds-generated-fields" class="m--hide"></div>

                        </div>

                        <!--end: Form Wizard Step 3-->
                    </div>

                    <!--end: Form Body -->

                    <!--begin: Form Actions -->
                    <div class="m-portlet__foot m-portlet__foot--fit">
                        <div class="m-form__actions text-center">
                            <a href="#" class="btn btn-secondary m-btn m-btn--custom m-btn--icon" data-wizard-action="prev">
                                <span><i class="la la-arrow-left"></i>&nbsp;&nbsp;<span>Back</span></span>
                            </a>
                            <a href="#" class="btn btn-primary m-btn m-btn--custom m-btn--icon" data-wizard-action="submit">
                                <span><i class="la la-check"></i>&nbsp;&nbsp;<span>Submit</span></span>
                            </a>
                            <a href="#" class="btn btn-warning m-btn m-btn--custom m-btn--icon" data-wizard-action="next">
                                <span><span>Next</span>&nbsp;&nbsp;<i class="la la-arrow-right"></i></span>
                            </a>
                        </div>
                    </div>
                    <!--end: Form Actions -->
                </form>
            </div>

            <!--end: Form Wizard Form-->
        </div>

        <!--end: Form Wizard-->

    </div>
@endsection

@push('scripts')

    <script src="//cdnjs.cloudflare.com/ajax/libs/lodash.js/4.17.11/lodash.min.js" type="text/javascript"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.5.0/js/bootstrap-datepicker.js"></script>

    <script>

        var WizardDemo=function() {
            $("#m_wizard");
            var e,
                r,
                i=$("#nemc_wizard_form");
            return {
                init:function() {
                    var n;
                    $("#m_wizard"),
                        i=$("#nemc_wizard_form"),
                        (r=new mWizard("m_wizard", {
                                startStep: 1
                            }
                        )).on("beforeNext", function(r) {

                                !0!==e.form()&&r.stop()

                                if(r.getStep() == 2){
                                    if ($('#mbbs-generated-fields').text().length != 0){
                                        validateMbbsPhase = true;
                                        $('#mbbs-generated-fields .mbbs-phases').each(function(){
                                            if($(this).val() == ''){
                                                validateMbbsPhase = false;
                                            }
                                        });
                                        if(validateMbbsPhase == false){
                                            sweetAlert('Phase cannot be empty', 'error');
                                            r.stop();
                                        }

                                        validateMbbsTerm = true;
                                        $('#mbbs-generated-fields .mbbs-terms').each(function(){
                                            if($(this).val() == ''){
                                                validateMbbsTerm = false;
                                            }
                                        });
                                        if(validateMbbsTerm == false){
                                            sweetAlert('Term cannot be empty', 'error');
                                            r.stop();
                                        }

                                        validateMbbsSubjects = true;
                                        $('#mbbs-generated-fields .m_selectpicker').each(function(){
                                            if($(this).val().length == 0){
                                                validateMbbsSubjects = false;
                                            }
                                        });
                                        if(validateMbbsSubjects == false){
                                            sweetAlert('Subjects cannot be empty', 'error');
                                            r.stop();
                                        }
                                    }
                                }

                            }
                        ),
                        r.on("change", function(e) {
                                // mUtil.scrollTop()
                            }
                        ),
                        r.on("change", function(e) {

                                1===e.getStep()
                            }
                        ),
                        e=i.validate( {
                                ignore:":hidden", rules: {
                                    title: {
                                        required: true
                                    }
                                    , start_year: {
                                        required: true
                                    }
                                    , mbbs_development_fee_local: {
                                        required: true,
                                        number: true,
                                    }
                                    , mbbs_development_fee_foreign: {
                                        required: true,
                                        number: true
                                    }
                                    , mbbs_tuition_fee_local: {
                                        required: true,
                                        number: true,
                                    }
                                    , mbbs_tuition_fee_foreign: {
                                        required: true,
                                        number: true
                                    }
                                    , mbbs_batch_number: {
                                        required: true,
                                        remote: {
                                            url: "{{route('session.batch.unique')}}",
                                            type: "post",
                                            data: {
                                                batch_number: function() {
                                                    return $( "#mbbs_batch_number" ).val();
                                                },course_id: function() {
                                                    return 1;
                                                },
                                                _token: "{{ csrf_token() }}",
                                            }
                                        }
                                    }
                                    , mbbs_total_phases: {
                                        required: !0
                                    }
                                    , bds_development_fee_local: {
                                        required: true,
                                        number: true,
                                    }
                                    , bds_tuition_fee_local: {
                                        required: true,
                                        number: true
                                    }
                                    , bds_batch_number: {
                                        required: true,
                                        remote: {
                                            url: "{{route('session.batch.unique')}}",
                                            type: "post",
                                            data: {
                                                batch_number: function() {
                                                    return $( "#bds_batch_number" ).val();
                                                },course_id: function() {
                                                    return 2;
                                                },
                                                _token: "{{ csrf_token() }}",
                                            }
                                        }
                                    }
                                    , bds_total_phases: {
                                        required: !0
                                    }
                                }
                                , messages: {
                                    "mbbs_batch_number": {
                                        remote: "This field is must be unique"
                                    },
                                    "bds_batch_number": {
                                        remote: "This field is must be unique"
                                    }
                                }
                                , invalidHandler:function(e, r) {
                                    /*mUtil.scrollTop(), swal( {
                                            title: "", text: "There are some errors in your submission. Please correct them.", type: "error", confirmButtonClass: "btn btn-secondary m-btn m-btn--wide"
                                        }
                                    )*/
                                }
                                , submitHandler:function(e) {}
                            }
                        ),
                        (n=i.find('[data-wizard-action="submit"]')).on("click", function(r) {
                            // i[0].submit();
                            if ($('#bds-generated-fields').text().length != 0){
                                validateBdsPhase = true;
                                $('#bds-generated-fields .bds-phases').each(function(){
                                    if($(this).val() == ''){
                                        validateBdsPhase = false;
                                    }
                                });
                                if(validateBdsPhase == false){
                                    sweetAlert('Phase cannot be empty', 'error');
                                    return false;
                                }

                                validateBdsTerm = true;
                                $('#bds-generated-fields .bds-terms').each(function(){
                                    if($(this).val() == ''){
                                        validateBdsTerm = false;
                                    }
                                });
                                if(validateBdsTerm == false){
                                    sweetAlert('Term cannot be empty', 'error');
                                    return false;
                                }

                                validateBdsSubjects = true;
                                $('#bds-generated-fields .m_selectpicker').each(function(){
                                    if($(this).val().length == 0){
                                        validateBdsSubjects = false;
                                    }
                                });
                                if(validateBdsSubjects == false){
                                    sweetAlert('Subjects cannot be empty', 'error');
                                    return false;
                                }
                            }

                                r.preventDefault(), e.form()&&(mApp.progress(n),
                                    /*i.ajaxSubmit({
                                        success:function() {
                                            mApp.unprogress(n), swal( {
                                                    title: "", text: "The application has been successfully submitted!", type: "success", confirmButtonClass: "btn btn-secondary m-btn m-btn--wide"
                                                }
                                            )
                                        }
                                    })*/
                                    i[0].submit()
                                )
                            }
                        )
                }
            }
        }
        ();

        $(document).ready(function() {
                WizardDemo.init();

                var setupMBBSPhases = function(mbbsPhases){
                    for (i = 0; i < mbbsPhases; i++) {
                        mbbsPhaseFields = $('.mbbs-phase-subjects');
                        mbbsPhaseData = mbbsPhaseFields.clone(true);
                        mbbsPhaseData = mbbsPhaseData.removeClass('mbbs-phase-subjects');
                        mbbsPhaseData.find('.mbbs-subjects').attr('name', 'mbbs_phase_subjects['+i+'][]');
                        mbbsPhaseData.find('.mbbs-subjects').addClass('m-bootstrap-select').addClass('m_selectpicker');
                        mbbsPhaseData.find('.mbbs-subjects').attr('data-live-search', true);
                        $('#mbbs-generated-fields').append(mbbsPhaseData.removeClass('m--hide'));
                        $(".m_selectpicker").selectpicker();
                        $('#mbbs-generated-fields').removeClass('m--hide');
                    }
                }

                var setupBDSPhases = function(bdsPhases){
                    for (i = 0; i < bdsPhases; i++) {
                        bdsPhaseFields = $('.bds-phase-subjects');
                        bdsPhaseData = bdsPhaseFields.clone(true);
                        bdsPhaseData = bdsPhaseData.removeClass('bds-phase-subjects');
                        bdsPhaseData.find('.bds-subjects').attr('name', 'bds_phase_subjects['+i+'][]');
                        bdsPhaseData.find('.bds-subjects').addClass('m-bootstrap-select').addClass('m_selectpicker');
                        bdsPhaseData.find('.bds-subjects').attr('data-live-search', true);
                        $('#bds-generated-fields').append(bdsPhaseData.removeClass('m--hide'));
                        $(".m_selectpicker").selectpicker();
                        $('#bds-generated-fields').removeClass('m--hide');
                    }
                }


                $('#mbbs-phase').change(function (e) {

                    mbbsPhases= $(this).val();

                    e.preventDefault();
                    if ($('#mbbs-generated-fields').html().length > 0 ){
                        Swal.fire({
                            title: 'Are you sure?',
                            text: "Do you want to re-generate phase setting",
                            type: 'warning',
                            showCancelButton: true,
                            confirmButtonText: 'Yes'
                        }).then((result) => {
                            if (result.value) {
                                $('#mbbs-generated-fields').html('');
                                setupMBBSPhases(mbbsPhases);

                            }else if (result.dismiss === Swal.DismissReason.cancel){
                                return false;
                            }
                        })

                    }else{
                        setupMBBSPhases(mbbsPhases);
                    }
                });

                $('#bds-phase').change(function (e) {

                    bdsPhases= $(this).val();

                    e.preventDefault();
                    if ($('#bds-generated-fields').html().length > 0 ){
                        Swal.fire({
                            title: 'Are you sure?',
                            text: "Do you want to re-generate phase setting",
                            type: 'warning',
                            showCancelButton: true,
                            confirmButtonText: 'Yes'
                        }).then((result) => {
                            if (result.value) {
                                $('#bds-generated-fields').html('');
                                setupBDSPhases(bdsPhases);

                            }else if (result.dismiss === Swal.DismissReason.cancel){
                                return false;
                            }
                        })

                    }else{
                        setupBDSPhases(bdsPhases);
                    }
                });

                $('.mbbs-phases').change(function () {
                    current = $(this);
                    var phaseIndex=[];
                    $('.mbbs-phases').each(function(){
                        if($(this).val() != ''){
                            phaseIndex.push($(this).val());
                        }
                    });
                    uniqValues = _.uniq(phaseIndex)
                    if(phaseIndex.length != uniqValues.length){
                        sweetAlert('Phase must be unique', 'error');
                        current.val('');
                        return false;
                    }
                });

                $('.bds-phases').change(function () {
                    current = $(this);
                    var phaseIndex=[];
                    $('.bds-phases').each(function(){
                        if($(this).val() != ''){
                            phaseIndex.push($(this).val());
                        }
                    });
                    uniqValues = _.uniq(phaseIndex)
                    if(phaseIndex.length != uniqValues.length){
                        sweetAlert('Phase must be unique', 'error');
                        current.val('');
                        return false;
                    }
                });

            });

        //year picker
        $('.date-own').datepicker({
            minViewMode: 2,
            format: 'yyyy',
            autoclose: true,
        });

    </script>
@endpush
