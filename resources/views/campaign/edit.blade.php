@php use Carbon\Carbon; @endphp
@extends('layouts.default')

@section('content')
    <!--begin::Portlet-->
    <div class="m-portlet m-portlet--full-height" id="campaign_wizard">
        <div class="m-portlet__head">
            <div class="m-portlet__head-caption">
                <div class="m-portlet__head-title">
                    <h3 class="m-portlet__head-text">
                        <i class="far fa-edit pr-2"></i>
                        Update Campaign: {{ $campaign->title }}
                    </h3>
                </div>
            </div>
            <div class="m-portlet__head-tools m-portlet__head-tools--right">
                @if (hasPermission('campaigns/index'))
                    <a href="{{ route('campaigns.index') }}"
                       class="btn btn-primary m-btn m-btn--pill m-btn--custom m-btn--icon m-btn--air">
                        <span>
                            <i class="la la-list"></i>
                            <span>Campaigns List</span>
                        </span>
                    </a>
                @endif
            </div>
        </div>
        <!--begin: Form Wizard-->
        <div class="m-wizard m-wizard--2 m-wizard--success" id="m_wizard">
            <!--begin: Message Container -->
            <div id="wizard_message"></div>

            <!--begin: Form Wizard Nav -->
            <div class="m-wizard__head m-portlet__padding-x">
                <!--begin: Form Wizard Progress -->
                <div class="m-wizard__progress">
                    <div class="progress">
                        <div class="progress-bar" role="progressbar" id="wizard_progress_bar" aria-valuenow="0"
                             aria-valuemin="0" aria-valuemax="100" style="width: 0%;"></div>
                    </div>
                </div>
                <!--end: Form Wizard Progress -->

                <!--begin: Form Wizard Nav -->
                <div class="m-wizard__nav">
                    <div class="m-wizard__steps">
                        <div class="m-wizard__step m-wizard__step--current" id="step_nav_1">
                            <div class="m-wizard__step-info">
                                <a href="#" class="m-wizard__step-number">
                                    <span>1</span>
                                </a>
                                <div class="m-wizard__step-label">
                                    Basics
                                </div>
                            </div>
                        </div>
                        <div class="m-wizard__step" id="step_nav_2">
                            <div class="m-wizard__step-info">
                                <a href="#" class="m-wizard__step-number">
                                    <span>2</span>
                                </a>
                                <div class="m-wizard__step-label">
                                    Recipients
                                </div>
                            </div>
                        </div>
                        <div class="m-wizard__step" id="step_nav_3">
                            <div class="m-wizard__step-info">
                                <a href="#" class="m-wizard__step-number">
                                    <span>3</span>
                                </a>
                                <div class="m-wizard__step-label">
                                    Schedule
                                </div>
                            </div>
                        </div>
                        <div class="m-wizard__step" id="step_nav_4">
                            <div class="m-wizard__step-info">
                                <a href="#" class="m-wizard__step-number">
                                    <span>4</span>
                                </a>
                                <div class="m-wizard__step-label">
                                    Review
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!--end: Form Wizard Nav -->
            </div>
            <!--end: Form Wizard Nav -->

            <!--begin: Form Wizard Form-->
            <div class="m-wizard__form">
                <form class="m-form m-form--label-align-left- m-form--state-" id="m_form">
                    @csrf
                    <!--begin: Form Body -->
                    <div class="m-portlet__body">

                        <!--begin: Step 1-->
                        <div class="wizard-step" id="step_1">
                            <div class="m-form__heading">
                                <h3 class="m-form__heading-title">Step 1: Campaign Basics</h3>
                            </div>
                            <div class="form-group m-form__group row">
                                <div class="col-lg-6">
                                    <label>Campaign Title: <span class="text-danger">*</span></label>
                                    <input type="text" name="title" id="campaign_title" class="form-control m-input"
                                           value="{{ $campaign->title }}" required>
                                    <span class="m-form__help">Please enter a unique title for your campaign</span>
                                </div>
                                <div class="col-lg-6">
                                    <label>Channel: <span class="text-danger">*</span></label>
                                    <div class="m-radio-list pt-2">
                                        <label class="m-radio m-radio--solid m-radio--brand">
                                            <input type="radio" name="channel"
                                                   value="sms" {{ $campaign->channel == 'sms' ? 'checked' : '' }}> SMS
                                            <span></span>
                                        </label>
                                        <label class="m-radio m-radio--solid m-radio--brand">
                                            <input type="radio" name="channel"
                                                   value="email" {{ $campaign->channel == 'email' ? 'checked' : '' }}>
                                            Email
                                            <span></span>
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group m-form__group row {{ $campaign->channel == 'email' ? '' : 'd-none'}}"
                                 id="subject_container">
                                <div class="col-md-6">
                                    <label>Email Subject: <span class="text-danger">*</span></label>
                                    <input type="text" name="subject" id="campaign_subject" class="form-control m-input"
                                           value="{{ $campaign->subject }}">
                                    <span class="m-form__help">Enter the subject line for your email campaign</span>
                                </div>
                            </div>
                            <div class="form-group m-form__group">
                                <label>Message Content: <span class="text-danger">*</span></label>
                                <textarea name="message" id="campaign_message" class="form-control m-input" rows="5"
                                          required>{{ $campaign->message }}</textarea>
                                <span class="m-form__help">Tip: Keep it concise for better engagement.</span>
                            </div>
                        </div>
                        <!--end: Step 1-->

                        <!--begin: Step 2-->
                        <div class="wizard-step d-none" id="step_2">
                            <div class="m-form__heading">
                                <h3 class="m-form__heading-title">Step 2: Select Recipients</h3>
                            </div>
                            @php
                                $selectedTypes = $campaign->recipients->pluck('recipientable_type')->toArray();
                                $hasStudents = in_array('App\Models\Student', $selectedTypes);
                                $hasTeachers = in_array('App\Models\Teacher', $selectedTypes);
                                $hasGuardians = in_array('App\Models\Guardian', $selectedTypes);

                                // Pre-fill Select2 multi-selects with already-selected recipient IDs.
                                $studentRecipients = $campaign->recipients
                                    ->where('recipientable_type', 'App\\Models\\Student')
                                    ->values();
                                $teacherRecipients = $campaign->recipients
                                    ->where('recipientable_type', 'App\\Models\\Teacher')
                                    ->values();
                                $guardianRecipients = $campaign->recipients
                                    ->where('recipientable_type', 'App\\Models\\Guardian')
                                    ->values();

                                $studentUserIdsText = $studentRecipients
                                    ->map(fn($r) => optional(optional($r->recipientable)->user)->user_id)
                                    ->unique()
                                    ->filter()
                                    ->implode("\n");
                                $teacherUserIdsText = $teacherRecipients
                                    ->map(fn($r) => optional(optional($r->recipientable)->user)->user_id)
                                    ->unique()
                                    ->filter()
                                    ->implode("\n");
                                $guardianUserIdsText = $guardianRecipients
                                    ->map(fn($r) => optional(optional($r->recipientable)->user)->user_id)
                                    ->unique()
                                    ->filter()
                                    ->implode("\n");
                            @endphp
                            <div class="form-group m-form__group">
                                <label>Target Audience: <span class="text-danger">*</span></label>
                                <div class="m-checkbox-list row">
                                    <div class="col-lg-4">
                                        <label class="m-checkbox m-checkbox--solid m-checkbox--brand">
                                            <input type="checkbox" name="recipients[]" value="students"
                                                   class="recipient-toggle"
                                                   data-target="#student_filters" {{ $hasStudents ? 'checked' : '' }}>
                                            Students
                                            <span></span>
                                        </label>
                                    </div>
                                    <div class="col-lg-4">
                                        <label class="m-checkbox m-checkbox--solid m-checkbox--brand">
                                            <input type="checkbox" name="recipients[]" value="teachers"
                                                   class="recipient-toggle"
                                                   data-target="#teacher_filters" {{ $hasTeachers ? 'checked' : '' }}>
                                            Teachers
                                            <span></span>
                                        </label>
                                    </div>
                                    <div class="col-lg-4">
                                        <label class="m-checkbox m-checkbox--solid m-checkbox--brand">
                                            <input type="checkbox" name="recipients[]" value="guardians"
                                                   class="recipient-toggle"
                                                   data-target="#guardian_filters" {{ $hasGuardians ? 'checked' : '' }}>
                                            Guardians
                                            <span></span>
                                        </label>
                                    </div>
                                </div>
                            </div>

                            <div id="student_filters" class="recipient-filters d-none p-3 mb-3 bg-light rounded border">
                                <h5 class="m--font-boldest mb-3" style="font-size: 0.9rem;">Filter Students:</h5>
                                <div class="row">
                                    <div class="col-lg-4 mb-3">
                                        <label>By Session:</label>
                                        <select name="session_id[]" class="form-control m-input m-select2" multiple>
                                            @foreach($sessions as $session)
                                                <option value="{{ $session->id }}">{{ $session->title }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-lg-4 mb-3">
                                        <label>By Course:</label>
                                        <select name="course_id[]" class="form-control m-input m-select2" multiple>
                                            @foreach($courses as $course)
                                                <option value="{{ $course->id }}">{{ $course->title }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-lg-4 mb-3">
                                        <label>By Phase:</label>
                                        <select name="phase_id[]" class="form-control m-input m-select2" multiple>
                                            @foreach($phases as $phase)
                                                <option value="{{ $phase->id }}">{{ $phase->title }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-lg-4 mb-3">
                                        <label>By Batch Type:</label>
                                        <select name="batch_type_id[]" class="form-control m-input m-select2" multiple>
                                            @foreach($batchTypes as $type)
                                                <option value="{{ $type->id }}">{{ $type->title }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-lg-4 mb-3">
                                        <label>By Category:</label>
                                        <select name="student_category_id[]" class="form-control m-input m-select2"
                                                multiple>
                                            @foreach($studentCategories as $category)
                                                <option value="{{ $category->id }}">{{ $category->title }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-lg-4 mb-3">
                                        <label>Specific Students (Optional):</label>
                                        <select name="individual_student_ids[]" class="form-control m-input m-select2"
                                                multiple>
                                            @foreach($studentRecipients as $r)
                                                <option value="{{ $r->recipientable->user->user_id }}" selected>
                                                    {{ $r->recipientable->full_name ?? 'N/A' }}
                                                    ({{ $r->recipientable->user->user_id }})
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div id="guardian_filters"
                                 class="recipient-filters d-none p-3 mb-3 bg-light rounded border">
                                <h5 class="m--font-boldest mb-3" style="font-size: 0.9rem;">Filter Guardians (via
                                    Student info):</h5>
                                <div class="row">
                                    <div class="col-lg-4 mb-3">
                                        <label>By Child's Session:</label>
                                        <select name="guardian_session_id[]" class="form-control m-input m-select2"
                                                multiple>
                                            @foreach($sessions as $session)
                                                <option value="{{ $session->id }}">{{ $session->title }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-lg-4 mb-3">
                                        <label>By Child's Course:</label>
                                        <select name="guardian_course_id[]" class="form-control m-input m-select2"
                                                multiple>
                                            @foreach($courses as $course)
                                                <option value="{{ $course->id }}">{{ $course->title }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-lg-4 mb-3">
                                        <label>By Child's Phase:</label>
                                        <select name="guardian_phase_id[]" class="form-control m-input m-select2"
                                                multiple>
                                            @foreach($phases as $phase)
                                                <option value="{{ $phase->id }}">{{ $phase->title }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-lg-4 mb-3">
                                        <label>By Child's Batch Type:</label>
                                        <select name="guardian_batch_type_id[]" class="form-control m-input m-select2"
                                                multiple>
                                            @foreach($batchTypes as $type)
                                                <option value="{{ $type->id }}">{{ $type->title }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-lg-4 mb-3">
                                        <label>By Child's Category:</label>
                                        <select name="guardian_student_category_id[]"
                                                class="form-control m-input m-select2" multiple>
                                            @foreach($studentCategories as $category)
                                                <option value="{{ $category->id }}">{{ $category->title }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-lg-4 mb-3">
                                        <label>Specific Guardians (Optional):</label>
                                        <select name="individual_guardian_ids[]" class="form-control m-input m-select2"
                                                multiple>
                                            @foreach($guardianRecipients as $r)
                                                <option value="{{ $r->recipientable->user->user_id }}" selected>
                                                    {{ $r->recipientable->full_name ?? 'N/A' }}
                                                    ({{ $r->recipientable->user->user_id }})
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div id="teacher_filters" class="recipient-filters d-none p-3 mb-3 bg-light rounded border">
                                <h5 class="m--font-boldest mb-3" style="font-size: 0.9rem;">Filter Teachers:</h5>
                                <div class="row">
                                    <div class="col-lg-4 mb-3">
                                        <label>By Department:</label>
                                        <select name="department_id[]" class="form-control m-input m-select2" multiple>
                                            @foreach($departments as $department)
                                                <option value="{{ $department->id }}">{{ $department->title }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-lg-4 mb-3">
                                        <label>By Designation:</label>
                                        <select name="designation_id[]" class="form-control m-input m-select2" multiple>
                                            @foreach($designations as $designation)
                                                <option
                                                    value="{{ $designation->id }}">{{ $designation->title }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-lg-4 mb-3">
                                        <label>Specific Teachers (Optional):</label>
                                        <select name="individual_teacher_ids[]" class="form-control m-input m-select2"
                                                multiple>
                                            @foreach($teacherRecipients as $r)
                                                <option value="{{ $r->recipientable->user->user_id }}" selected>
                                                    {{ $r->recipientable->full_name ?? 'N/A' }}
                                                    ({{ $r->recipientable->user->user_id }})
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <span class="m-form__help">Select at least one recipient group. Use filters to narrow down, or select specific individuals to override filters.</span>
                        </div>
                        <!--end: Step 2-->

                        <!--begin: Step 3-->
                        <div class="wizard-step d-none" id="step_3">
                            <div class="m-form__heading">
                                <h3 class="m-form__heading-title">Step 3: Action & Schedule</h3>
                            </div>
                            <div class="form-group m-form__group">
                                <label>Campaign Action: <span class="text-danger">*</span></label>
                                <div class="m-radio-list pt-2">
                                    <label class="m-radio m-radio--solid m-radio--brand">
                                        <input type="radio" name="status" value="processing"
                                               {{ $campaign->status == 'processing' ? 'checked' : '' }} class="status-radio">
                                        Send
                                        Immediately
                                        <span></span>
                                    </label>
                                    <label class="m-radio m-radio--solid m-radio--brand">
                                        <input type="radio" name="status" value="scheduled"
                                               {{ $campaign->status == 'scheduled' ? 'checked' : '' }} class="status-radio">
                                        Schedule for Later
                                        <span></span>
                                    </label>
                                    <label class="m-radio m-radio--solid m-radio--brand">
                                        <input type="radio" name="status" value="draft"
                                               {{ $campaign->status == 'draft' ? 'checked' : '' }} class="status-radio">
                                        Save as Draft
                                        <span></span>
                                    </label>
                                </div>
                            </div>
                            <div class="form-group m-form__group row {{ $campaign->status == 'scheduled' ? '' :
                            'd-none' }}"
                                 id="schedule_datetime_container">
                                <div class="col-md-3">
                                    <label><i class="la la-calendar pr-1"></i> Schedule Date & Time: <span
                                            class="text-danger">*</span></label>
                                    <input type="text" name="scheduled_at" id="scheduled_at_input"
                                           class="form-control m-input m_datetimepicker_full"
                                           value="{{ $campaign->scheduled_at ? Carbon::parse($campaign->scheduled_at)->format('Y-m-d h:i a') : '' }}"
                                           placeholder="Select date and time..." autocomplete="off" readonly>
                                    <span class="m-form__help">Select the date and time when you want the campaign to be sent.</span>
                                </div>
                            </div>
                        </div>
                        <!--end: Step 3-->

                        <!--begin: Step 4-->
                        <div class="wizard-step d-none" id="step_4">
                            <div class="m-form__heading">
                                <h3 class="m-form__heading-title">Step 4: Review & Update</h3>
                            </div>
                            <div class="review-box p-4 bg-light rounded shadow-sm">
                                <div class="row mb-3">
                                    <div class="col-md-3 font-weight-bold uppercase">Title:</div>
                                    <div class="col-md-9" id="review_title"></div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-md-3 font-weight-bold uppercase">Channel:</div>
                                    <div class="col-md-9" id="review_channel"></div>
                                </div>
                                <div class="row mb-3 d-none" id="review_subject_container">
                                    <div class="col-md-3 font-weight-bold uppercase">Subject:</div>
                                    <div class="col-md-9" id="review_subject"></div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-md-3 font-weight-bold uppercase">Audience:</div>
                                    <div class="col-md-9" id="review_recipients"></div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-md-3 font-weight-bold uppercase">Schedule:</div>
                                    <div class="col-md-9" id="review_schedule"></div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="font-weight-bold mb-2 uppercase">Message Preview:</div>
                                        <div class="p-3 border bg-white rounded" id="review_message"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!--end: Step 4-->

                    </div>
                    <!--end: Form Body -->

                    <!--begin: Form Actions -->
                    <div class="m-portlet__foot m-portlet__foot--fit">
                        <div class="m-form__actions">
                            <div class="row">
                                <div class="col-lg-12 text-center">
                                    <button type="button"
                                            class="btn btn-warning m-btn m-btn--pill m-btn--custom m-btn--icon"
                                            id="prev_btn">
                                        <span>
                                            <i class="la la-arrow-left pr-2"></i>
                                            <span>Back</span>
                                        </span>
                                    </button>
                                    <button type="button"
                                            class="btn btn-brand m-btn m-btn--pill m-btn--custom m-btn--icon"
                                            id="next_btn">
                                        <span>
                                            <span>Next</span>
                                            <i class="la la-arrow-right pl-2"></i>
                                        </span>
                                    </button>
                                    <button type="button"
                                            class="btn btn-success m-btn m-btn--pill m-btn--custom m-btn--icon"
                                            id="submit_btn">
                                        <span>
                                            <i class="la la-check pr-2"></i>
                                            <span>Update Campaign</span>
                                        </span>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--end: Form Actions -->
                </form>
            </div>
            <!--end: Form Wizard Form-->
        </div>
        <!--end: Form Wizard-->
    </div>
    <!--end::Portlet-->
    <style>
        .m-wizard.m-wizard--2 .m-wizard__head .m-wizard__nav .m-wizard__steps .m-wizard__step .m-wizard__step-info .m-wizard__step-label {
            font-size: 1.1rem;
            font-weight: 500;
        }

        .m-wizard.m-wizard--2 .m-wizard__head .m-wizard__nav .m-wizard__steps .m-wizard__step--current .m-wizard__step-info .m-wizard__step-number {
            background-color: #716aca;
            color: #fff;
        }

        .m-wizard.m-wizard--2 .m-wizard__head .m-wizard__nav .m-wizard__steps .m-wizard__step--done .m-wizard__step-info .m-wizard__step-number {
            background-color: #34bfa3;
            color: #fff;
        }

        .m-wizard.m-wizard--2 .m-wizard__head .m-wizard__nav .m-wizard__steps .m-wizard__step--done .m-wizard__step-info .m-wizard__step-label {
            color: #34bfa3;
        }

        .m-portlet__foot--fit .m-form__actions {
            padding: 2rem;
        }

        .font-weight-bold {
            font-weight: 600;
        }

        .uppercase {
            text-transform: uppercase;
            letter-spacing: 1px;
            color: #7b7e8a;
            font-size: 0.8rem;
        }
    </style>

@endsection

@push('scripts')
    <script>
        $(document).ready(function () {
            $('.m_datetimepicker_full').datetimepicker({
                format: 'yyyy-mm-dd hh:ii',
                showMeridian: true,
                autoclose: true,
                todayHighlight: true,
                startDate: new Date(),
                pickerPosition: 'bottom-left',
                forceParse: 0,
            });

            const initSelect2 = (selector, url, type, placeholder) => {
                // If Select2 was already initialized, destroy it so AJAX config is applied.
                if ($(selector).hasClass('select2-hidden-accessible')) {
                    $(selector).select2('destroy');
                }
                $(selector).select2({
                    placeholder: placeholder,
                    allowClear: true,
                    width: '100%',
                    ajax: {
                        url: url,
                        dataType: 'json',
                        delay: 250,
                        data: params => ({
                            q: params.term,
                            page: params.page,
                            type: type
                        }),
                        processResults: (data, params) => {
                            params.page = params.page || 1;
                            return {
                                results: data.items,
                                pagination: {
                                    more: (params.page * 30) < data.total_count
                                }
                            };
                        },
                        cache: false,
                        error: function (xhr) {
                            // Useful when Select2 "search not work" (AJAX error/JSON mismatch).
                            console.error('Select2 AJAX failed', xhr.status, xhr.responseText);
                        }
                    },
                    minimumInputLength: 1
                });
            };

            $('.m-select2').select2({
                placeholder: 'Select options',
                allowClear: true,
                width: '100%'
            });

            initSelect2('select[name="individual_student_ids[]"]', '{{ route("campaigns.search-recipients") }}', 'student', "Search for students...");
            initSelect2('select[name="individual_teacher_ids[]"]', '{{ route("campaigns.search-recipients") }}', 'teacher', "Search for teachers...");
            initSelect2('select[name="individual_guardian_ids[]"]', '{{ route("campaigns.search-recipients") }}', 'guardian', "Search for guardians...");

            let currentStep = 1;
            const totalSteps = 4;

            const $form = $('#m_form');
            const $nextBtn = $('#next_btn');
            const $prevBtn = $('#prev_btn');
            const $submitBtn = $('#submit_btn');
            const $progressBar = $('#wizard_progress_bar');

            // Initial setup
            updateWizard();

            // Initial toggles for pre-checked items
            $('.recipient-toggle:checked').each(function () {
                $($(this).data('target')).removeClass('d-none');
            });

            // Step toggle logic
            function updateWizard() {
                $('.wizard-step').addClass('d-none');
                $('#step_' + currentStep).removeClass('d-none');

                $('.m-wizard__nav .m-wizard__steps .m-wizard__step').removeClass('m-wizard__step--current m-wizard__step--done');
                $('.m-wizard__nav .m-wizard__steps .m-wizard__step').each(function (index) {
                    const stepNum = index + 1;
                    if (stepNum === currentStep) {
                        $(this).addClass('m-wizard__step--current');
                    } else if (stepNum < currentStep) {
                        $(this).addClass('m-wizard__step--done');
                    }
                });

                if (currentStep === 1) {
                    $prevBtn.addClass('d-none');
                } else {
                    $prevBtn.removeClass('d-none');
                }

                if (currentStep === totalSteps) {
                    $nextBtn.addClass('d-none');
                    $submitBtn.removeClass('d-none');
                    updateReview();
                } else {
                    $nextBtn.removeClass('d-none');
                    $submitBtn.addClass('d-none');
                }

                const progress = ((currentStep - 1) / (totalSteps - 1)) * 100;
                $progressBar.css('width', progress + '%');
            }

            function validateStep(step) {
                if (step === 1) {
                    const title = $('#campaign_title').val();
                    const message = $('#campaign_message').val();
                    const channel = $('input[name="channel"]:checked').val();
                    const subject = $('#campaign_subject').val();
                    if (!title || !message) {
                        Swal.fire('Oops!', 'Please fill in the campaign title and message.', 'warning');
                        return false;
                    }
                    if (channel === 'email' && !subject) {
                        Swal.fire('Oops!', 'Please enter a subject for the email campaign.', 'warning');
                        return false;
                    }
                } else if (step === 2) {
                    const checked = $('input[name="recipients[]"]:checked');
                    if (checked.length === 0) {
                        Swal.fire('Wait!', 'Select at least one recipient type.', 'warning');
                        return false;
                    }
                } else if (step === 3) {
                    const status = $('input[name="status"]:checked').val();
                    const scheduledAt = $('#scheduled_at_input').val();
                    if (status === 'scheduled' && !scheduledAt) {
                        Swal.fire('Date Required', 'Please select a date and time for scheduling.', 'warning');
                        return false;
                    }
                }
                return true;
            }

            function updateReview() {
                const channel = $('input[name="channel"]:checked').val();
                $('#review_title').text($('#campaign_title').val());
                $('#review_channel').text(channel.toUpperCase());

                if (channel === 'email') {
                    $('#review_subject_container').removeClass('d-none');
                    $('#review_subject').text($('#campaign_subject').val());
                } else {
                    $('#review_subject_container').addClass('d-none');
                }

                const recipients = $('input[name="recipients[]"]:checked').map(function () {
                    return this.value.charAt(0).toUpperCase() + this.value.slice(1);
                }).get().join(', ');
                $('#review_recipients').text(recipients);

                const status = $('input[name="status"]:checked').val();
                const scheduledAt = $('#scheduled_at_input').val();

                if (status === 'processing') {
                    $('#review_schedule').text('Immediate');
                } else if (status === 'scheduled') {
                    $('#review_schedule').text('Scheduled for ' + scheduledAt.replace('T', ' '));
                } else {
                    $('#review_schedule').text('Draft (Manual send later)');
                }

                $('#review_message').text($('#campaign_message').val());
            }

            $('.m-wizard__step-info').on('click', function (e) {
                e.preventDefault();
                const stepId = $(this).closest('.m-wizard__step').attr('id');
                const targetStep = parseInt(stepId.replace('step_nav_', ''));

                // Allow jumping back freely, or jumping forward if current step is valid
                if (targetStep < currentStep || validateStep(currentStep)) {
                    currentStep = targetStep;
                    updateWizard();
                }
            });

            $nextBtn.on('click', function () {
                if (validateStep(currentStep)) {
                    currentStep++;
                    updateWizard();
                }
            });

            $prevBtn.on('click', function () {
                currentStep--;
                updateWizard();
            });

            $('.status-radio').on('change', function () {
                if ($(this).val() === 'scheduled') {
                    $('#schedule_datetime_container').removeClass('d-none');
                } else {
                    $('#schedule_datetime_container').addClass('d-none');
                }
            });

            $('input[name="channel"]').on('change', function () {
                if ($(this).val() === 'email') {
                    $('#subject_container').removeClass('d-none');
                } else {
                    $('#subject_container').addClass('d-none');
                }
            });

            $('.recipient-toggle').on('change', function () {
                const target = $(this).data('target');
                if ($(this).is(':checked')) {
                    $(target).removeClass('d-none');
                } else {
                    $(target).addClass('d-none');
                }
            });

            $submitBtn.on('click', function () {
                const data = {};
                $form.serializeArray().forEach(item => {
                    let name = item.name;
                    if (name.endsWith('[]')) {
                        name = name.substring(0, name.length - 2);
                        if (!data[name]) data[name] = [];
                        data[name].push(item.value);
                    } else {
                        data[name] = item.value;
                    }
                });

                $submitBtn.prop('disabled', true).html('<span><i class="la la-refresh la-spin"></i>&nbsp;&nbsp;<span>Updating...</span></span>');

                $.ajax({
                    url: '{{ route("campaigns.update", $campaign->id) }}',
                    method: 'PUT',
                    data: JSON.stringify(data),
                    contentType: 'application/json',
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'X-CSRF-TOKEN': $('input[name="_token"]').val()
                    },
                    success: function (data) {
                        if (data.success) {
                            Swal.fire('Success!', data.message, 'success').then(function () {
                                window.location.href = '{{ route("campaigns.index") }}';
                            });
                        } else {
                            Swal.fire('Error', data.message || 'Something went wrong', 'error');
                            $submitBtn.prop('disabled', false).html('<span><i class="la la-check"></i>&nbsp;&nbsp;<span>Update Campaign</span></span>');
                        }
                    },
                    error: function (xhr) {
                        let msg = 'Server error occurred';
                        if (xhr.status === 422) {
                            const errors = xhr.responseJSON.errors;
                            msg = Object.values(errors).flat().join('<br>');
                        } else if (xhr.responseJSON && xhr.responseJSON.message) {
                            msg = xhr.responseJSON.message;
                        }
                        Swal.fire({
                            title: 'Error',
                            html: msg,
                            icon: 'error'
                        });
                        $submitBtn.prop('disabled', false).html('<span><i class="la la-check"></i>&nbsp;&nbsp;<span>Update Campaign</span></span>');
                    }
                });
            });
        });
    </script>
@endpush
