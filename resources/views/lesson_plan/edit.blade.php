@extends('layouts.default')
@section('pageTitle', $pageTitle)
@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="m-portlet">
                <div class="m-portlet__head">
                    <div class="m-portlet__head-caption">
                        <div class="m-portlet__head-title">
                            <h3 class="m-portlet__head-text"><i class="fas fa-clipboard pr-2"></i>{{ $pageTitle }}</h3>
                        </div>
                    </div>
                    <div class="m-portlet__head-tools">
                        <a href="{{ route('lesson.plan.index') }}" class="btn btn-primary m-btn m-btn--icon">
                            <i class="fas fa-list-ul pr-2"></i>Lesson Plans
                        </a>
                    </div>
                </div>

                <form class="m-form m-form--fit m-form--label-align-right" method="POST"
                    action="{{ route('lesson.plan.update', $lessonPlan->id) }}" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="m-portlet__body">
                        <div class="form-group m-form__group row">
                            <label class="col-form-label col-lg-3 col-sm-12">Input Method: <span
                                    class="text-danger">*</span></label>
                            <div class="col-lg-7 col-md-9 col-sm-12">
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="input_method"
                                        id="input_method_form" value="form" {{ !$lessonPlan->pdf_file ? 'checked' : '' }}>
                                    <label class="form-check-label" for="input_method_form">
                                        Fill Form
                                    </label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="input_method" id="input_method_pdf"
                                        value="pdf" {{ $lessonPlan->pdf_file ? 'checked' : '' }}>
                                    <label class="form-check-label" for="input_method_pdf">
                                        Upload PDF
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div id="pdf-upload-section" style="display: {{ $lessonPlan->pdf_file ? 'block' : 'none' }};">
                            <div class="form-group m-form__group row @error('pdf_file') has-danger @enderror">
                                <label class="col-form-label col-lg-3 col-sm-12">Lesson Plan PDF:
                                    @if (!$lessonPlan->pdf_file)
                                        <span class="text-danger">*</span>
                                    @endif
                                </label>
                                <div class="col-lg-7 col-md-9 col-sm-12">
                                    @if ($lessonPlan->pdf_file && file_exists(public_path($lessonPlan->pdf_file)))
                                        <div class="mb-2">
                                            <a href="{{ asset($lessonPlan->pdf_file) }}" target="_blank"
                                                class="btn btn-sm btn-info">
                                                <i class="far fa-file-pdf pr-2"></i>View Current PDF
                                            </a>
                                            <button type="button" class="btn btn-sm btn-danger" id="remove-pdf-btn">
                                                <i class="fa fa-times pr-2"></i>Remove PDF
                                            </button>
                                        </div>
                                        <input type="hidden" name="remove_pdf" id="remove_pdf_input" value="0">
                                    @endif
                                    <input type="file"
                                        class="form-control m-input @error('pdf_file') is-invalid @enderror" name="pdf_file"
                                        accept=".pdf" id="pdf_file_input" {{ !$lessonPlan->pdf_file ? 'required' : '' }}>
                                    <small class="form-text text-muted">Only PDF files are allowed. Max size: 10MB.
                                        @if ($lessonPlan->pdf_file)
                                            Leave empty to keep existing PDF.
                                        @else
                                            PDF is required.
                                        @endif
                                    </small>
                                    @error('pdf_file')
                                        <div class="form-control-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Basic fields always visible for both PDF and Form modes -->
                        <div class="form-group m-form__group row">
                            <label class="col-form-label col-lg-3 col-sm-12">Topic:</label>
                            <div class="col-lg-7 col-md-9 col-sm-12">
                                <input type="text" class="form-control m-input" value="{{ $topic->title }}" readonly>
                            </div>
                        </div>

                        <div class="form-group m-form__group row @error('title') has-danger @enderror">
                            <label class="col-form-label col-lg-3 col-sm-12">Lesson Plan Title: <span
                                    class="text-danger">*</span></label>
                            <div class="col-lg-7 col-md-9 col-sm-12">
                                <input type="text" class="form-control m-input @error('title') is-invalid @enderror"
                                    name="title" value="{{ old('title', $lessonPlan->title) }}"
                                    placeholder="Enter lesson plan title" required>
                                @error('title')
                                    <div class="form-control-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group m-form__group row @error('speaker_id') has-danger @enderror">
                            <label class="col-form-label col-lg-3 col-sm-12">Speaker: <span
                                    class="text-danger">*</span></label>
                            <div class="col-lg-7 col-md-9 col-sm-12">
                                <select
                                    class="form-control m-input m-bootstrap-select m_selectpicker @error('speaker_id') is-invalid @enderror"
                                    name="speaker_id" data-live-search="true" required>
                                    <option>---- Select Teacher ----</option>
                                    {!! select($teachers, old('speaker_id', $lessonPlan->speaker_id)) !!}
                                </select>
                                @error('speaker_id')
                                    <div class="form-control-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group m-form__group row @error('audience') has-danger @enderror">
                            <label class="col-form-label col-lg-3 col-sm-12">Audience: <span
                                    class="text-danger">*</span></label>
                            <div class="col-lg-7 col-md-9 col-sm-12">
                                <input type="text" class="form-control m-input @error('audience') is-invalid @enderror"
                                    name="audience" value="{{ old('audience', $lessonPlan->audience) }}"
                                    placeholder="Enter audience" required />
                                @error('audience')
                                    <div class="form-control-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Form-specific fields (hidden when PDF mode) -->
                        <div id="form-inputs-section" style="display: {{ $lessonPlan->pdf_file ? 'none' : 'block' }};">
                            <div class="form-group m-form__group row @error('date') has-danger @enderror">
                                <label class="col-form-label col-lg-3 col-sm-12">Date:</label>
                                <div class="col-lg-7 col-md-9 col-sm-12">
                                    <input type="text"
                                        class="form-control m-input m_datepicker @error('date') is-invalid @enderror"
                                        name="date" value="{{ old('date', $lessonPlan->date) }}"
                                        placeholder="Select date" readonly>
                                    @error('date')
                                        <div class="form-control-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group m-form__group row @error('place') has-danger @enderror">
                                <label class="col-form-label col-lg-3 col-sm-12">Place:</label>
                                <div class="col-lg-7 col-md-9 col-sm-12">
                                    <input type="text" class="form-control m-input @error('place') is-invalid @enderror"
                                        name="place" value="{{ old('place', $lessonPlan->place) }}"
                                        placeholder="Enter place">
                                    @error('place')
                                        <div class="form-control-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group m-form__group row @error('duration') has-danger @enderror">
                                <label class="col-form-label col-lg-3 col-sm-12">Duration:</label>
                                <div class="col-lg-7 col-md-9 col-sm-12">
                                    <input type="text"
                                        class="form-control m-input @error('duration') is-invalid @enderror" name="duration"
                                        value="{{ old('duration', $lessonPlan->duration) }}" placeholder="Enter duration">
                                    @error('duration')
                                        <div class="form-control-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div
                                class="form-group m-form__group row @error('start_time') has-danger @enderror @error('end_time') has-danger @enderror">
                                <label class="col-form-label col-lg-3 col-sm-12">Time Range: <span
                                        class="text-danger">*</span></label>
                                <div class="col-lg-7 col-md-9 col-sm-12 d-flex">
                                    <input type="text" id="start-time" class="form-control m-input m_timepicker"
                                        value="{{ $lessonPlan->start_time ? date('Y-m-d') . ' ' . parseClassTime($lessonPlan->start_time) : '' }}"
                                        name="start_time" placeholder="Start time" autocomplete="off" readonly>
                                    <input type="text" id="end-time" class="form-control m-input m_timepicker"
                                        value="{{ $lessonPlan->end_time ? date('Y-m-d') . ' ' . parseClassTime($lessonPlan->end_time) : '' }}"
                                        name="end_time" placeholder="End time" autocomplete="off" readonly>
                                </div>
                                @error('start_time')
                                    <div class="form-control-feedback offset-lg-3 col-lg-7 col-md-9 col-sm-12">
                                        {{ $message }}</div>
                                @enderror
                                @error('end_time')
                                    <div class="form-control-feedback offset-lg-3 col-lg-7 col-md-9 col-sm-12">
                                        {{ $message }}</div>
                                @enderror
                            </div>

                            <div
                                class="form-group m-form__group row @error('method_of_instruction') has-danger @enderror">
                                <label class="col-form-label col-lg-3 col-sm-12">Method of Instruction:</label>
                                <div class="col-lg-7 col-md-9 col-sm-12">
                                    <input type="text"
                                        class="form-control m-input @error('method_of_instruction') is-invalid @enderror"
                                        name="method_of_instruction"
                                        value="{{ old('method_of_instruction', $lessonPlan->method_of_instruction) }}"
                                        placeholder="Enter method of instruction">
                                    @error('method_of_instruction')
                                        <div class="form-control-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div
                                class="form-group m-form__group row @error('instructional_material') has-danger @enderror">
                                <label class="col-form-label col-lg-3 col-sm-12">Instructional Material:</label>
                                <div class="col-lg-7 col-md-9 col-sm-12">
                                    <input type="text"
                                        class="form-control m-input @error('instructional_material') is-invalid @enderror"
                                        name="instructional_material"
                                        value="{{ old('instructional_material', $lessonPlan->instructional_material) }}"
                                        placeholder="Enter instructional material">
                                    @error('instructional_material')
                                        <div class="form-control-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group m-form__group row @error('objectives') has-danger @enderror">
                                <label class="col-form-label col-lg-3 col-sm-12">Objectives:</label>
                                <div class="col-lg-7 col-md-9 col-sm-12">
                                    <textarea class="form-control m-input @error('objectives') is-invalid @enderror" name="objectives" rows="5"
                                        placeholder="Enter objectives">{{ old('objectives', $lessonPlan->objectives) }}</textarea>
                                    @error('objectives')
                                        <div class="form-control-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group m-form__group row @error('time_allocation') has-danger @enderror">
                                <label class="col-form-label col-lg-3 col-sm-12">Time Allocation:</label>
                                <div class="col-lg-7 col-md-9 col-sm-12">
                                    @php
                                        $timeAllocation = json_decode($lessonPlan->time_allocation, true);
                                    @endphp
                                    <div class="border p-2">
                                        <div class="form-row mb-2">
                                            <div class="col-10">Attendance taking:</div>
                                            <div class="col-2"><input type="text" name="attendance"
                                                    class="form-control"
                                                    value="{{ $timeAllocation['attendance'] ?? '' }}" placeholder="Time">
                                            </div>
                                        </div>
                                        <div class="form-row mb-2">
                                            <div class="col-10">Objective:</div>
                                            <div class="col-2"><input type="text" name="objective"
                                                    class="form-control" value="{{ $timeAllocation['objective'] ?? '' }}"
                                                    placeholder="Time">
                                            </div>
                                        </div>
                                        <div class="form-row mb-2">
                                            <div class="col-10">Purpose of learning:</div>
                                            <div class="col-2"><input type="text" name="purpose"
                                                    class="form-control" value="{{ $timeAllocation['purpose'] ?? '' }}"
                                                    placeholder="Time"></div>
                                        </div>
                                        <div class="form-row mb-2">
                                            <div class="col-10">Prerequisite learning:</div>
                                            <div class="col-2"><input type="text" name="prerequisite"
                                                    class="form-control"
                                                    value="{{ $timeAllocation['prerequisite'] ?? '' }}"
                                                    placeholder="Time">
                                            </div>
                                        </div>
                                        <div class="form-row mb-2">
                                            <div class="col-6">Contents:</div>
                                            <div class="col-6">
                                                @php
                                                    $contents = [];
                                                    if (
                                                        !empty($timeAllocation['contents']) &&
                                                        is_array($timeAllocation['contents'])
                                                    ) {
                                                        $contents = $timeAllocation['contents'];
                                                    }
                                                @endphp
                                                <div id="contents-fields">
                                                    @foreach ($contents as $item)
                                                        <div class="content-block form-row mb-2 justify-content-end">
                                                            <button class="btn btn-danger remove-content-line"
                                                                type="button"><i class="fa fa-times"></i></button>
                                                            <div class="col-7 no-padding">
                                                                <input type="text" name="contents_keys[]"
                                                                    class="form-control"
                                                                    value="{{ $item['context'] ?? '' }}"
                                                                    placeholder="Context">
                                                            </div>
                                                            <div class="col-4 pl-0" style="max-width:32%">
                                                                <input type="text" name="contents_values[]"
                                                                    class="form-control"
                                                                    value="{{ $item['time'] ?? '' }}" placeholder="Time">
                                                            </div>
                                                        </div>
                                                    @endforeach
                                                    @if (empty($contents))
                                                        <div class="content-block form-row mb-2 justify-content-end">
                                                            <button class="btn btn-danger remove-content-line"
                                                                type="button"><i class="fa fa-times"></i></button>
                                                            <div class="col-7 no-padding">
                                                                <input type="text" name="contents_keys[]"
                                                                    class="form-control" placeholder="Context">
                                                            </div>
                                                            <div class="col-4 pl-0" style="max-width:32%">
                                                                <input type="text" name="contents_values[]"
                                                                    class="form-control" placeholder="Time">
                                                            </div>
                                                        </div>
                                                    @endif
                                                </div>
                                                <button type="button" class="btn btn-sm btn-success float-right"
                                                    id="add-content-line"><i class="fa fa-plus"></i></button>
                                            </div>
                                        </div>
                                        <div class="form-row mb-2">
                                            <div class="col-10">Summary:</div>
                                            <div class="col-2"><input type="text" name="summary"
                                                    class="form-control" value="{{ $timeAllocation['summary'] ?? '' }}"
                                                    placeholder="Time"></div>
                                        </div>
                                        <div class="form-row mb-2">
                                            <div class="col-10">Assessment:</div>
                                            <div class="col-2"><input type="text" name="assessment"
                                                    class="form-control"
                                                    value="{{ $timeAllocation['assessment'] ?? '' }}" placeholder="Time">
                                            </div>
                                        </div>
                                    </div>
                                    @error('time_allocation')
                                        <div class="form-control-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="form-group m-form__group row @error('status') has-danger @enderror">
                            <label class="col-form-label col-lg-3 col-sm-12">Status:</label>
                            <div class="col-lg-7 col-md-9 col-sm-12">
                                <select class="form-control m-input @error('status') is-invalid @enderror"
                                    name="status">
                                    <option value="1"
                                        {{ old('status', $lessonPlan->status) == 1 ? 'selected' : '' }}>
                                        Active
                                    </option>
                                    <option value="0"
                                        {{ old('status', $lessonPlan->status) == 0 ? 'selected' : '' }}>
                                        Inactive
                                    </option>
                                </select>
                                @error('status')
                                    <div class="form-control-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="m-portlet__foot m-portlet__foot--fit" style="margin-left: 6px;">
                        <div class="m-form__actions text-center">
                            <a href="{{ route('lesson.plan.index') }}" class="btn btn-outline-brand">Cancel</a>
                            <button type="submit" class="btn btn-success">Update</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
@push('scripts')
    <script>
        $(".m_datepicker").datepicker({
            todayHighlight: !0,
            orientation: "bottom left",
            format: 'yyyy/mm/dd',
            autoclose: true,
        });

        $('.m_timepicker').datetimepicker({
            format: 'hh:ii',
            showMeridian: 1,
            todayHighlight: 1,
            autoclose: true,
            startView: 1,
            minView: 0,
            maxView: 1,
            forceParse: 0,
        });

        splitStartTime = $('#start-time').val().split(' ');
        splitEndTime = $('#end-time').val().split(' ');
        $('#start-time').val(splitStartTime[1]);
        $('#end-time').val(splitEndTime[1]);
    </script>
    <script>
        $(document).on('click', '#add-content-line', function() {
            $('#contents-fields').append(`
                <div class="content-block form-row mb-2 justify-content-end">
                                                        <button class="btn btn-danger remove-content-line"
                                                                type="button"><i
                                                                class="fa fa-times"></i></button>
                                                        <div class="col-7 no-padding">
                                                            <input type="text" name="contents_keys[]"
                                                                   class="form-control"
                                                                   placeholder="Context">
                                                        </div>
                                                        <div class="col-4 pl-0" style="max-width:32%">
                                                            <input type="text" name="contents_values[]"
                                                                   class="form-control" placeholder="Time">
                                                        </div>
                                                    </div>
            `);
        });
        $(document).on('click', '.remove-content-line', function() {
            $(this).closest('.content-block').remove();
        });

        // Toggle between PDF upload and form inputs
        $('input[name="input_method"]').on('change', function() {
            const selectedMethod = $(this).val();
            if (selectedMethod === 'pdf') {
                $('#pdf-upload-section').show();
                $('#form-inputs-section').hide();
                // Required fields for PDF: Topic (readonly), Title, Speaker, Audience, PDF file
                $('input[name="title"]').prop('required', true);
                $('select[name="speaker_id"]').prop('required', true);
                $('input[name="audience"]').prop('required', true);
                // Make PDF required only if no existing PDF
                const hasExistingPdf = $('#remove-pdf-btn').length > 0;
                $('#pdf_file_input').prop('required', !hasExistingPdf);
                // Remove required from form-specific inputs (time range, time allocation, etc.)
                $('#form-inputs-section input, #form-inputs-section select, #form-inputs-section textarea').each(
                    function() {
                        $(this).prop('required', false);
                    });
                $('#remove_pdf_input').val('0'); // Don't remove if switching to PDF
            } else {
                $('#pdf-upload-section').hide();
                $('#form-inputs-section').show();
                // Make PDF not required and clear file input
                $('#pdf_file_input').prop('required', false);
                $('#pdf_file_input').val('');
                $('#remove_pdf_input').val('1'); // Mark for removal when switching to form
                // Required fields for form: Title, Speaker, Audience, Time Range
                $('input[name="title"]').prop('required', true);
                $('select[name="speaker_id"]').prop('required', true);
                $('input[name="audience"]').prop('required', true);
                $('input[name="start_time"], input[name="end_time"]').prop('required', true);
            }
        });

        // Handle remove PDF button
        $('#remove-pdf-btn').on('click', function() {
            if (confirm('Are you sure you want to remove the PDF? This will switch to form input mode.')) {
                $('#remove_pdf_input').val('1');
                $('#input_method_form').prop('checked', true).trigger('change');
            }
        });

        // Trigger on page load to set initial state
        $('input[name="input_method"]:checked').trigger('change');
    </script>
@endpush
