@extends('layouts.default')
@section('pageTitle', 'Designation')

@section('content')
    <div class="m-portlet m-portlet--tab">
        <div class="m-portlet__head">
            <div class="m-portlet__head-caption">
                <div class="m-portlet__head-title">
                    <h3 class="m-portlet__head-text"><i class="far fa-edit pr-2"></i>Edit Holiday</h3>
                </div>
            </div>
            <div class="m-portlet__head-tools">
                    <a href="{{ url('admin/holiday') }}" class="btn btn-primary m-btn m-btn--icon"><i class="fas fa-calendar-times pr-2"></i>Holidays</a>
            </div>
        </div>

        <!--begin::Form-->
        <form class="m-form m-form--fit m-form--label-align-right"  action="{{ url('admin/holiday/' .$holiday->id) }}" method="post">
            @csrf
            @method('PUT')
            <div class="m-portlet__body">

                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                        <div class="form-group  m-form__group {{ $errors->has('title') ? 'has-danger' : '' }}">
                            <label class="form-control-label"><span class="text-danger">*</span> Title </label>
                            <input type="text" class="form-control m-input" name="title" value="{{ old('title', $holiday->title) }}" placeholder="Holiday Title"/>
                            @if ($errors->has('title'))
                                <div class="form-control-feedback">{{ $errors->first('title') }}</div>
                            @endif
                        </div>
                    </div>

                    <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3 col-xl-3">
                        <div class="form-group  m-form__group {{ $errors->has('from_date') ? 'has-danger' : '' }}">
                            <label class="form-control-label"><span class="text-danger">*</span> From Date </label>
                            <input type="text" class="form-control m-input m_datepicker_1" name="from_date" value="{{ old('from_date', $holiday->from_date) }}" placeholder="Holiday start date" autocomplete="off">
                            @if ($errors->has('from_date'))
                                <div class="form-control-feedback">{{ $errors->first('from_date') }}</div>
                            @endif
                        </div>
                    </div>

                    <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3 col-xl-3">
                        <div class="form-group  m-form__group">
                            <label class="form-control-label">To Date </label>
                            <input type="text" class="form-control m-input m_datepicker_1" name="to_date" value="{{ old('to_date', $holiday->to_date) }}" placeholder="Holiday end date" autocomplete="off">
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                        <div class="form-group  m-form__group {{ $errors->has('session_id') ? 'has-danger' : '' }}">
                            <label class="form-control-label">Session </label>
                            <select class="form-control m-input m-bootstrap-select m_selectpicker" name="session_id" data-live-search="true">
                                <option value=" ">---- Select Session ----</option>
                                @foreach($sessions as $session)
                                    @if(!empty($holiday->session->id))
                                        <option value="{{$session->id}}" {{$session->id == $holiday->session->id ? 'selected' : ' '}}>{{$session->title}}</option>
                                    @else
                                        <option value="{{$session->id}}">{{$session->title}}</option>
                                    @endif
                                @endforeach
                            </select>
                            @if ($errors->has('session_id'))
                                <div class="form-control-feedback">{{ $errors->first('session_id') }}</div>
                            @endif
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                        <div class="form-group  m-form__group">
                            <label class="form-control-label">Batch Type </label>
                            <select class="form-control m-input m-bootstrap-select m_selectpicker" name="batch_type_id" data-live-search="true">
                                <option value=" ">---- Select Batch Type ----</option>
                                @foreach($batchTypes as $batchType)
                                    @if(!empty($holiday->batchType->id))
                                        <option value="{{$batchType->id}}" {{$batchType->id == $holiday->batchType->id ? 'selected' : ' '}}>{{$batchType->title}}</option>
                                    @else
                                        <option value="{{$batchType->id}}">{{$batchType->title}}</option>
                                    @endif
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
                        <div class="form-group  m-form__group">
                            <label class="form-control-label">Holiday Description </label>
                            <textarea class="form-control m-input summernote" name="description" placeholder="Topic Description"> {{ old('description', $holiday->description) }}</textarea>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                        <div class="form-group  m-form__group">
                            <label class="form-control-label">Select Status </label>
                            <select class="form-control m-input " name="status">
                                <option value="1" {{ $holiday->status == 1  ? 'selected' : '' }}>Active</option>
                                <option value="0" {{ $holiday->status == 0  ? 'selected' : '' }}>Canceled</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
            <div class="m-portlet__foot m-portlet__foot--fit">
                <div class="m-form__actions text-center">
                    <a href="{{ url('admin/holiday') }}" class="btn btn-outline-brand"><i class="fa fa-times"></i> Cancel</a>
                    <button type="submit" class="btn btn-success"><i class="fa fa-save"></i> Save</button>
                </div>
            </div>
        </form>

        <!--end::Form-->
    </div>
@endsection

@push('scripts')
    <script>
        $(document).ready(function() {
            $(".m_datepicker_1").datepicker( {
                todayHighlight: !0,
                orientation: "bottom left",
                format: 'dd/mm/yyyy',
                autoClose: true,
            });

        });

        $(".summernote").summernote({height:150})

    </script>
@endpush

