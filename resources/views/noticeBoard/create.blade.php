@extends('layouts.default')
@section('pageTitle', $pageTitle)

@push('style')
    <style>
        .hidden
        {
            visibility:hidden;
        }
        .visible
        {
            visibility:visible;
        }
    </style>
@endpush

@section('content')

    <div class="m-portlet m-portlet--tab">
        <div class="m-portlet__head">
            <div class="m-portlet__head-caption">
                <div class="m-portlet__head-title">
                    <h3 class="m-portlet__head-text"><i class="far fa-plus-square pr-2"></i>Create Notice</h3>
                </div>
            </div>
            <div class="m-portlet__head-tools">
                    <a href="{{ url('admin/notice_board') }}" class="btn btn-primary m-btn m-btn--icon"><i class="fas fa-calendar-times pr-2"></i>Notices</a>
            </div>
        </div>

        <!--begin::Form-->
        <form class="m-form m-form--fit m-form--label-align-right"  action="{{ url('admin/notice_board') }}" method="post" enctype="multipart/form-data">
            @csrf
            <div class="m-portlet__body">
                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4 col-xl-4">
                        <div class="form-group  m-form__group {{ $errors->has('title') ? 'has-danger' : '' }}">
                            <label class="form-control-label"><span class="text-danger">*</span> Title </label>
                            <input type="text" class="form-control m-input" name="title" value="{{ old('title') }}" placeholder="Notice Title"/>
                            @if ($errors->has('title'))
                                <div class="form-control-feedback">{{ $errors->first('title') }}</div>
                            @endif
                        </div>
                    </div>

                    <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4 col-xl-4">
                        <div class="form-group  m-form__group {{ $errors->has('session_id') ? 'has-danger' : '' }}">
                            <label class="form-control-label">Session</label>
                            <select class="form-control m-input m-bootstrap-select m_selectpicker" name="session_id"
                                    id="session_id" data-live-search="true">
                                <option value=" ">---- Select Session ----</option>
                                {!! select($sessions) !!}
                            </select>
                            @if ($errors->has('session_id'))
                                <div class="form-control-feedback">{{ $errors->first('session_id') }}</div>
                            @endif
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4 col-xl-4">
                        <div class="form-group  m-form__group {{ $errors->has('course_id') ? 'has-danger' : '' }}">
                            <label class="form-control-label">Course </label>
                            <select class="form-control m-input" name="course_id" id="course_id">
                                @if (Auth::guard('web')->check())
                                    {{$user = Auth::guard('web')->user()}}
                                    @if ($user->teacher)
                                        {!! select($courses, $user->teacher->course_id) !!}
                                    @else
                                        <option value="">---- Select Course----</option>
                                        {!! select($courses) !!}
                                    @endif
                                @endif
                            </select>
                            @if ($errors->has('course_id'))
                                <div class="form-control-feedback">{{ $errors->first('course_id') }}</div>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4 col-xl-4">
                        <div class="form-group  m-form__group {{ $errors->has('phase_id') ? 'has-danger' : '' }}">
                            <label class="form-control-label">Phase </label>
                            <select class="form-control m-input" name="phase_id" id="phase_id">
                                <option value="">---- Select Phase ----</option>
                                {!! select($phases) !!}
                            </select>

                            @if ($errors->has('phase_id'))
                                <div class="form-control-feedback">{{ $errors->first('phase_id') }}</div>
                            @endif
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4 col-xl-4">
                        <div class="form-group  m-form__group {{ $errors->has('department_ids') ? 'has-danger' : '' }}">
                            <label class="form-control-label">Department </label>
                            <select class="form-control department m-bootstrap-select m_selectpicker"
                                    name="department_ids[]" id="department_id" data-live-search="true" multiple>
                                <option value="">---- Select Department ----</option>
                                {!! select($departments) !!}
                            </select>
                            @if ($errors->has('department_ids'))
                                <div class="form-control-feedback">{{ $errors->first('department_ids') }}</div>
                            @endif
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4 col-xl-4">
                        <div class="form-group  m-form__group">
                            <label class="form-control-label">Batch Type</label>
                            <select class="form-control m-input" name="batch_type_id">
                                <option value=" ">---- Select Batch Type ----</option>
                                {!! select($batchTypes) !!}
                            </select>
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4 col-xl-4">
                        <div class="form-group  m-form__group {{ (! empty(old('is_publish')) ? '' : 'hidden') }}" id="published_date">
                            <label class="form-control-label">Publish Date </label>
                            <input type="text" class="form-control m-input m_datepicker_1" name="published_date" placeholder="Notice publish date" autocomplete="off">
                            @if ($errors->has('published_date'))
                                <div class="form-control-feedback">{{ $errors->first('published_date') }}</div>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="m-form__group form-group">
                            <div class="m-checkbox-list">
                                <label class="m-checkbox">
                                    <input type="checkbox" id="publish-notice" name="is_publish" value="1" {{ (! empty(old('is_publish')) ? 'checked' : '') }}> Want to publish the notice ?
                                    <span></span>
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="m-form__group form-group @error('notice_file') has-danger @enderror">
                            <label for="noticeFile">Notice File</label>
                            <input
                                type="file"
                                class="form-control-file @error('notice_file') is-invalid @enderror"
                                name="notice_file"
                                id="noticeFile"
                                accept=".pdf"
                            >
                            @error('notice_file')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
                        <div class="form-group  m-form__group ">
                            <label class="form-control-label">Notice Description </label>
                            <textarea class="form-control m-input summernote" name="description" placeholder="Topic Description"> {{ old('description') }}</textarea>
                        </div>
                    </div>
                </div>
            </div>

            <div class="m-portlet__foot m-portlet__foot--fit">
                <div class="m-form__actions text-center">
                    <a href="{{ url('admin/notice_board') }}" class="btn btn-outline-brand"><i class="fa fa-times"></i> Cancel</a>
                    <button type="submit" class="btn btn-success"><i class="fa fa-save"></i> Save</button>
                </div>
            </div>
        </form>

        <!--end::Form-->
    </div>
@endsection

@push('scripts')
    <script>
        $('#session_id, #course_id, #phase_id').change(function () {
            sessionId = $('#session_id').val();
            courseId = $('#course_id').val();
            phaseId = $('#phase_id').val();

            if (sessionId > 0 && courseId > 0 && phaseId > 0) {
                mApp.blockPage({
                    overlayColor: "#000000",
                    type: "loader",
                    state: "primary",
                    message: "Please wait..."
                });

                $.get('{{route('departments.list.session.course.phase')}}', {
                    sessionId: sessionId, courseId: courseId, phaseId: phaseId,
                }, function (response) {
                    $('#department_id').html('<option value="">---- Select Department ----</option>');
                    if (response.departments) {
                        for (i in response.departments) {
                            department = response.departments[i];
                            console.log(department)
                            $('#department_id').append('<option value="' + department.id + '">' + department.title + '</option>')
                        }
                    }
                    $('.m_selectpicker').selectpicker('refresh');
                });
                mApp.unblockPage()
            }
        });

        //hide publish date field when check box is not checked
        $("#publish-notice").change(function() {
            $("#published_date").toggleClass('hidden');

            $("#published_date").toggleClass('visible');
        });


        // date picker
        $(document).ready(function() {
            $(".m_datepicker_1").datepicker( {
                todayHighlight: !0,
                orientation: "bottom left",
                format: 'dd/mm/yyyy',
                autoClose: true,
            });

        });
        //editor
        $(".summernote").summernote({height:150})

    </script>
@endpush
