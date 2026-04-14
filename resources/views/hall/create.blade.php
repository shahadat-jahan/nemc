@extends('layouts.default')
@section('pageTitle', $pageTitle)

@section('content')

    <div class="m-portlet m-portlet--tab">
        <div class="m-portlet__head">
            <div class="m-portlet__head-caption">
                <div class="m-portlet__head-title">
                    <h3 class="m-portlet__head-text"><i class="far fa-plus-square pr-2"></i>Create Class Room</h3>
                </div>
            </div>
            <div class="m-portlet__head-tools">
                <a href="{{ url('admin/hall') }}" class="btn btn-primary m-btn m-btn--icon"><i
                        class="far fa-building pr-2"></i>Class Rooms</a>
            </div>
        </div>

        <!--begin::Form-->
        <form class="m-form m-form--fit m-form--label-align-right" action="{{ url('admin/hall') }}" method="post">
            @csrf
            <div class="m-portlet__body">
                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                        <div class="form-group  m-form__group {{ $errors->has('title') ? 'has-danger' : '' }}">
                            <label class="form-control-label"><span class="text-danger">*</span> Title </label>
                            <input type="text" class="form-control m-input" name="title" value="{{ old('title') }}"
                                   placeholder="Room Title"/>
                            @if ($errors->has('title'))
                                <div class="form-control-feedback">{{ $errors->first('title') }}</div>
                            @endif
                        </div>
                    </div>
                    {{--                    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">--}}
                    {{--                        <div class="form-group  m-form__group {{ $errors->has('floor_number') ? 'has-danger' : '' }}">--}}
                    {{--                            <label class="form-control-label"><span class="text-danger">*</span> Floor Number </label>--}}
                    {{--                            <select class="form-control m-input  m-bootstrap-select m_selectpicker" name="floor_number" data-live-search="true">--}}
                    {{--                                <option value=" ">---- Select Floor Number ----</option>--}}
                    {{--                                @foreach($floors as $key=>$floor)--}}
                    {{--                                    <option value="{{$key}}" {{ old('floor_number') == $key ? 'selected' : '' }}>{{$floor}}</option>--}}
                    {{--                                @endforeach--}}
                    {{--                            </select>--}}
                    {{--                            @if ($errors->has('floor_number'))--}}
                    {{--                                <div class="form-control-feedback"> {{ $errors->first('floor_number') }} </div>--}}
                    {{--                            @endif--}}
                    {{--                        </div>--}}
                    {{--                    </div>--}}
                    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                        <div class="form-group  m-form__group {{ $errors->has('floor_number') ? 'has-danger' : '' }}">
                            <label class="form-control-label"><span class="text-danger">*</span> Floor </label>
                            <input type="text" class="form-control m-input" name="floor_number"
                                   value="{{ old('floor_number') }}" placeholder="Floor"/>
                            @if ($errors->has('floor_number'))
                                <div class="form-control-feedback"> {{ $errors->first('floor_number') }} </div>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                        <div class="form-group  m-form__group {{ $errors->has('room_number') ? 'has-danger' : '' }}">
                            <label class="form-control-label"><span class="text-danger">*</span> Room Number </label>
                            <input type="number" class="form-control m-input" name="room_number"
                                   value="{{ old('room_number') }}" placeholder="Room Number"/>
                            @if ($errors->has('room_number'))
                                <div class="form-control-feedback">{{ $errors->first('room_number') }}</div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            <div class="m-portlet__foot m-portlet__foot--fit">
                <div class="m-form__actions text-center">
                    <a href="{{ route('hall.index') }}" class="btn btn-outline-brand"><i class="fa fa-times"></i> Cancel</a>
                    <button type="submit" class="btn btn-success"><i class="fa fa-save"></i> Save</button>
                </div>
            </div>
        </form>

        <!--end::Form-->
    </div>
@endsection

