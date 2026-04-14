@extends('layouts.default')
@section('pageTitle', $pageTitle)

@push('style')
    <style>
        .m-portlet .m-portlet__body{
            padding: 1.2rem 2.2rem;
        }
        #attach-document {
            cursor: pointer;
            position: relative;
            margin-top: 19px;
            padding-left: 15px;
        }
        .img-fluid{
            max-height: 261px;
        }
        .m-wizard [data-wizard-action="submit"]{
            display: inline-block;
        }
    </style>
    @endpush
@section('content')

    <div class="m-portlet m-portlet--tab">
        <div class="m-portlet__head">
            <div class="m-portlet__head-caption">
                <div class="m-portlet__head-title">
                    <h3 class="m-portlet__head-text"><i class="far flaticon-edit pr-2"></i>Edit Student Information</h3>
                </div>
            </div>
            <div class="m-portlet__head-tools">
                <a href="{{ url('admin/students') }}" class="btn btn-primary m-btn m-btn--icon"><i class="flaticon-calendar-2"></i> Students</a>
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
                                <span><i class="fa fa-user"></i></span>
                            </a>
                            <div class="m-wizard__step-info">
                                <div class="m-wizard__step-title">Applicant</div>
                            </div>
                        </div>
                        <div class="m-wizard__step" m-wizard-target="m_wizard_form_step_2">
                            <a href="#" class="m-wizard__step-number">
                                <span><i class="fa fa-user"></i></span>
                            </a>
                            <div class="m-wizard__step-info">
                                <div class="m-wizard__step-title">Address</div>
                            </div>
                        </div>
                        <div class="m-wizard__step" m-wizard-target="m_wizard_form_step_3">
                            <a href="#" class="m-wizard__step-number">
                                <span><i class="fas fa-university"></i></span>
                            </a>
                            <div class="m-wizard__step-info">
                                <div class="m-wizard__step-title">Education</div>
                            </div>
                        </div>
                        <div class="m-wizard__step" m-wizard-target="m_wizard_form_step_4">
                            <a href="#" class="m-wizard__step-number">
                                <span><i class="fa fa-phone"></i></span>
                            </a>
                            <div class="m-wizard__step-info">
                                <div class="m-wizard__step-title">Emergency Contact</div>
                            </div>
                        </div>
                        <div class="m-wizard__step" m-wizard-target="m_wizard_form_step_5">
                            <a href="#" class="m-wizard__step-number">
                                <span><i class="fa fa-image"></i></span>
                            </a>
                            <div class="m-wizard__step-info">
                                <div class="m-wizard__step-title">Image</div>
                            </div>
                        </div>

                    </div>
                </div>

                <!--end: Form Wizard Nav -->
            </div>

            <!--end: Form Wizard Head -->

            <!--begin: Form Wizard Form-->
            <div class="m-wizard__form">
                <form action="{{route('students.update', [$student->id])}}" method="post" class="m-form m-form--label-align-left- m-form--state-" id="nemc_wizard_form">
                @csrf
                @method('PUT')
                <!--begin: Form Body -->
                    <div class="m-portlet__body">

                        <!--begin: Form Wizard Step 1-->
                        <div class="m-wizard__form-step m-wizard__form-step--current" id="m_wizard_form_step_1">
                            @include('students.applicant_edit')
                        </div>
                        <!--end: Form Wizard Step 1-->

                        <!--begin: Form Wizard Step 2-->
                        <div class="m-wizard__form-step" id="m_wizard_form_step_2">
                            @include('students.applicant_address_edit')
                        </div>
                        <!--begin: Form Wizard Step 2-->

                        <!--begin: Form Wizard Step 3-->
                        <div class="m-wizard__form-step" id="m_wizard_form_step_3">
                            @include('students.applicant_education_edit')
                        </div>

                        <!--end: Form Wizard Step 3-->

                        <!--begin: Form Wizard Step 4-->
                        <div class="m-wizard__form-step" id="m_wizard_form_step_4">
                            @include('students.applicant_emergency_contact_edit')
                        </div>
                        <!--end: Form Wizard Step 4-->

                        <!--begin: Form Wizard Step 5-->
                        <div class="m-wizard__form-step" id="m_wizard_form_step_5">
                            @include('students.applicant_attachment_edit')
                        </div>
                        <!--end: Form Wizard Step 5-->

                    </div>

                    <!--end: Form Body -->

                    <!--begin: Form Actions -->
                    <div class="m-portlet__foot m-portlet__foot--fit">
                        <div class="m-form__actions text-center">
                            <a href="#" class="btn btn-secondary m-btn m-btn--custom m-btn--icon" data-wizard-action="prev">
                                <span><i class="la la-arrow-left"></i>&nbsp;&nbsp;<span>Back</span></span>
                            </a>
                            <a href="#" class="btn btn-success" data-wizard-action="submit">
                                <i class="fa fa-save"></i> Submit
                            </a>
                            <a href="#" class="btn btn-warning m-btn m-btn--custom m-btn--icon" data-wizard-action="next">
                                <span><span> Next</span>&nbsp;&nbsp;<i class="la la-arrow-right"></i></span>
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

    <script>

        var WizardDemo=function() {
            $("#m_wizard");
            var e,
                r,
                i=$("#nemc_wizard_form");
            return {
                init:function() {
                    // Add custom validation method for student mobile number
                    $.validator.addMethod("validMobile", function(value, element) {
                        // Check for at least one non-zero digit and a minimum length of 11 digits
                        // Check the student category (you need to replace 'isStudentNormal' with your actual check)
                        var isStudentNormal = $('#student-category').val();  // Replace this with your actual logic to determine the category
                        // Define regular expressions based on the student category
                        var normalCategoryRegex = /^(?=.*[1-9])[0-9]{11}$/;
                        var otherCategoryRegex = /^\+(?:\d{1,3}[-.\s])?\(?\d{1,4}\)?[-.\s]?\d{1,6}[-.\s]?\d{1,10}$/;  // Replace this with your other regex
                        // Use the appropriate regex based on the student category
                        var regexToUse = isStudentNormal != 2 ? normalCategoryRegex : otherCategoryRegex;
                        // Test the value against the selected regex
                        return regexToUse.test(value);
                    }, "Please enter a valid mobile number.");

                    var n;
                    $("#m_wizard"),
                        i=$("#nemc_wizard_form"),
                        (r=new mWizard("m_wizard", {
                                startStep: 1,
                                manualStepForward: true
                            }
                        )).on("beforeNext", function(r) {

                                // !0!==e.form()&&r.stop()

                            }
                        ),
                        r.on("change", function(e) {
                                // mUtil.scrollTop()
                            }
                        ),
                        r.on("change", function(e) {

                                // 1===e.getStep()
                            }
                        ),
                        e=i.validate( {
                                ignore:":hidden",
                                rules: {
                                    session_id: {
                                        required: true,
                                        min: 1
                                    },
                                    course_id: {
                                        required: true,
                                        min: 1
                                    },
                                    student_category_id: {
                                        required: true,
                                        min: 1
                                    },
                                    phase_id: {
                                        required: true,
                                        min: 1
                                    },
                                    term_id: {
                                        required: true,
                                        min: 1
                                    },
                                    batch_type_id: {
                                        required: true,
                                        min: 1
                                    },
                                    full_name_en: {
                                        required: true,
                                    },
                                    admission_year: {
                                        required: true,
                                        min: 1
                                    },
                                    commenced_year: {
                                        required: true,
                                        min: 1
                                    },
                                    reg_no: {
                                        // required: true,
                                        remote: {
                                            url: "{{route('student.registration.unique')}}",
                                            type: "post",
                                            data: {
                                                reg_no: function() {
                                                    return $("#reg_no").val();
                                                },
                                                id: "{{ $student->id }}",
                                                _token: "{{ csrf_token() }}",
                                            }
                                        }
                                    },
                                    roll_no: {
                                        required: true,
                                        number:true,
                                        remote: {
                                            url: "{{route('admission.student_info.unique')}}",
                                            type: "post",
                                            data: {
                                                roll_no: function() {
                                                    return $("#roll_no").val();
                                                },
                                                session_id: function() {
                                                    return $("#followed_by_session_id").val();
                                                },
                                                course_id: function() {
                                                    return $("#course_id").val();
                                                },
                                                phase_id: function() {
                                                    return $("#phase_id").val();
                                                },
                                                id: function() {
                                                    return '{{$student->id}}';
                                                },
                                                _token: "{{ csrf_token() }}",
                                            }
                                        }
                                    },
                                    date_of_birth: {
                                        required: true,
                                    },
                                    mobile: {
                                        validMobile: true,
                                        required: true,
                                        noSpace: true,
                                        remote: {
                                            url: "{{route('student.mobile.unique')}}",
                                            type: "post",
                                            data: {
                                                mobile: function() {
                                                    return $( "#mobile" ).val();
                                                },
                                                id: "{{ $student->id }}",
                                                _token: "{{ csrf_token() }}",
                                            }
                                        }
                                    },
                                    email: {
                                        email_not_required:true,
                                        remote: {
                                            url: "{{route('admission.student_info.unique')}}",
                                            type: "post",
                                            data: {
                                                email: function() {
                                                    return $("#email").val();
                                                },
                                                session_id: function() {
                                                    return $("#followed_by_session_id").val();
                                                },
                                                course_id: function() {
                                                    return $("#course_id").val();
                                                },
                                                id: function() {
                                                    return '{{$student->id}}';
                                                },
                                                _token: "{{ csrf_token() }}",
                                            }
                                        }
                                    },
                                    gender: {
                                        required: true,
                                    },
                                    nationality: {
                                        required: true,
                                        min: 1,
                                    },
                                    place_of_birth: {
                                        required: true,
                                    },
                                    permanent_address: {
                                        required: true,
                                    },
                                    present_address: {
                                        required: true,
                                    },
                                    education_level_ssc: {
                                        required: true,
                                    },
                                    education_board_id_ssc: {
                                        required: true,
                                    },
                                    institution_ssc: {
                                        required: true,
                                    },
                                    pass_year_ssc: {
                                        required: true,
                                    },
                                    gpa_ssc: {
                                        required: true,
                                    },
                                    gpa_biology_ssc: {
                                        required: true,
                                    },
                                    education_level_hsc: {
                                        required: true,
                                    },
                                    education_board_id_hsc: {
                                        required: true,
                                    },
                                    institution_hsc: {
                                        required: true,
                                    },
                                    pass_year_hsc: {
                                        required: true,
                                    },
                                    gpa_hsc: {
                                        required: true,
                                    },
                                    gpa_biology_hsc: {
                                        required: true,
                                    },

                                }
                                , messages: {
                                    student_id:{
                                        remote : 'Value must be unique.',
                                    },
                                    roll_no:{
                                        remote : 'Value must be unique.',
                                    },
                                    user_id:{
                                        remote : 'Value must be unique.',
                                    },
                                    email:{
                                        remote : 'Value must be unique.',
                                    },
                                    mobile:{
                                        remote : 'Mobile must be unique, this mobile number already has been taken.',
                                    },
                                    reg_no:{
                                        required:'Registration number is required.',
                                        remote : 'Registration number must be unique.',
                                    }
                                },
                                invalidHandler:function(e, r) {
                                    /*mUtil.scrollTop(), swal( {
                                            title: "", text: "There are some errors in your submission. Please correct them.", type: "error", confirmButtonClass: "btn btn-secondary m-btn m-btn--wide"
                                        }
                                    )*/
                                },
                                submitHandler:function(e) {}
                            }
                        ),
                        (n=i.find('[data-wizard-action="submit"]')).on("click", function(r) {

                                r.preventDefault(), e.form()&&(mApp.progress(n),

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

            $(".m_year_picker").datepicker({
                todayHighlight: true,
                orientation: "bottom left",
                format: "yyyy",
                minViewMode: "years",
                autoclose: true
            });

            $(".m_datepicker_1").datepicker({
                todayHighlight: !0,
                orientation: "bottom left",
                format: 'dd/mm/yyyy',
                autoClose: true,
            });

            $('#student-category').change(function () {
                category = $(this).val();

                if (category == 2){
                    $('.foreign-row').removeClass('m--hide');
                } else{
                    $('.foreign-row').addClass('m--hide');
                }
            });

            function getTotalAssets(){
                annualIncome = ($('#annual_income').val().length > 0 )? $('#annual_income').val() : 0;
                movableProperty = ($('#movable_property').val().length > 0 )? $('#movable_property').val() : 0;
                immovableProperty = ($('#immovable_property').val().length > 0 )? $('#immovable_property').val() : 0;
                totalAsset = parseInt(annualIncome) + parseInt(movableProperty) + parseInt(immovableProperty);

                $('#total_asset').val(totalAsset.toFixed(2));
            }

            function getTotalAssetsPoints(){
                annualIncomePoint = ($('#annual_income_grade').val().length > 0 )? $('#annual_income_grade').val() : 0;
                movablePropertyPoint = ($('#movable_property_grade').val().length > 0 )? $('#movable_property_grade').val() : 0;
                immovablePropertyPoint = ($('#immovable_property_grade').val().length > 0 )? $('#immovable_property_grade').val() : 0;
                totalAssetPoint = parseInt(annualIncomePoint) + parseInt(movablePropertyPoint) + parseInt(immovablePropertyPoint);

                $('#total_asset_grade').val(totalAssetPoint.toFixed(2));
            }

            $('#annual_income, #movable_property, #immovable_property').keyup(function (e) {
                e.preventDefault();
                getTotalAssets();
            })

            $('#annual_income_grade, #movable_property_grade, #immovable_property_grade').keyup(function (e) {
                e.preventDefault();
                getTotalAssetsPoints();
            })

            $('#same_as_present'). click(function(){
                if ($(this).is(':checked')){
                    $('#st-present-addr').val($('#st-permanent-addr').val()).attr('readonly', true);
                }else{
                    $('#st-present-addr').val('').removeAttr('readonly');
                }
            });



        });
    </script>
@endpush
