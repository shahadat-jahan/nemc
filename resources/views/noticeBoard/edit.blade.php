@extends('layouts.default')
@section('pageTitle', 'Designation')
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
                    <h3 class="m-portlet__head-text"><i class="far fa-edit pr-2"></i>Edit Notice</h3>
                </div>
            </div>
            <div class="m-portlet__head-tools">
                    <a href="{{ url('admin/notice_board') }}" class="btn btn-primary m-btn m-btn--icon"><i class="fas fa-list pr-2"></i>Notices</a>
            </div>
        </div>

        <!--begin::Form-->
        <form class="m-form m-form--fit m-form--label-align-right"  action="{{ url('admin/notice_board/' .$notice->id) }}" method="post" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="m-portlet__body">

                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4 col-xl-4">
                        <div class="form-group  m-form__group {{ $errors->has('title') ? 'has-danger' : '' }}">
                            <label class="form-control-label"><span class="text-danger">*</span> Title </label>
                            <input type="text" class="form-control m-input" name="title" value="{{ old('title', $notice->title) }}" placeholder="Notice Title"/>
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
                                {!! select($sessions, $notice->session_id) !!}
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
                                        {!! select($courses, $notice->course_id) !!}
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
                                {!! select($phases, $notice->phase_id) !!}
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
                                @foreach($departments as $id => $name)
                                    <option value="{{ $id }}"
                                        {{ in_array($id, $notice->departments->pluck('id')->toArray()) ? 'selected' : '' }}>
                                        {{ $name }}
                                    </option>
                                @endforeach
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
                                {!! select($batchTypes, $notice->batch_type_id) !!}
                            </select>
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4 col-xl-4">
                        <div class="form-group  m-form__group {{$notice->is_publish == 0 ? 'hidden' : ' '}}" id="published_date">
                            <label class="form-control-label">Notice Published Date </label>
                            <input type="text" class="form-control m-input m_datepicker_1" name="published_date" value="{{ old('published_date', $notice->published_date) }}" placeholder="Notice Published Date" autocomplete="off">
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12">
                        <div class="m-form__group form-group">
                            <div class="m-checkbox-list">
                                <label class="m-checkbox">
                                    <input type="checkbox" id="publish-notice" name="is_publish" value="1" {{ $notice->is_publish == 1  ? 'checked' : '' }} {{$notice->is_publish == 1? 'disabled' : ''}} > Want to publish the notice ?
                                    <span></span>
                                </label>
                                @if($notice->is_publish == 1)
                                <small id="is_publishHelp" class="form-text text-muted">Can't edit publish status because this notice already has been published </small>
                                    @endif
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
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
                        <div class="form-group  m-form__group">
                            <label class="form-control-label">Notice Description </label>
                            <textarea class="form-control m-input summernote" name="description" placeholder="Topic Description"> {{ old('description', $notice->description) }}</textarea>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                        <div class="form-group  m-form__group">
                            <label class="form-control-label">Select Status </label>
                            <select class="form-control m-input " name="status">
                                <option value="1" {{ $notice->status == 1  ? 'selected' : '' }}>Active</option>
                                <option value="0" {{ $notice->status == 0  ? 'selected' : '' }}>Inactive</option>
                            </select>
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

