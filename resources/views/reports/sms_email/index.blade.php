@extends('layouts.default')
@section('pageTitle', $pageTitle)

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="m-portlet">
                <div class="m-portlet__head">
                    <div class="m-portlet__head-caption">
                        <div class="m-portlet__head-title">
                            <h3 class="m-portlet__head-text"><i class="fas fa-list-ul fa-md pr-2"></i>{{ $pageTitle }}
                            </h3>
                        </div>
                    </div>
                </div>
                <div class="m-portlet__body">
                    <form id="searchForm" role="form" method="get">
                        <div class="form-body">
                            <div class="row">
                                <div class="col-xs-12 col-sm-6 col-md-3 col-lg-3 col-xl-3">
                                    <div class="form-group">
                                        <select class="form-control m-bootstrap-select m_selectpicker" name="sender_id"
                                            id="sender_id" data-live-search="true">
                                            <option value="">---- Select Sender ----</option>
                                            {!! select($users, app()->request->sender_id) !!}
                                        </select>
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-6 col-md-3 col-lg-3 col-xl-3">
                                    <div class="form-group">
                                        <select class="form-control m-input" name="message_type" id="message_type">
                                            <option value="">---- Select Message type ----</option>
                                            {!! select(['email' => 'Email', 'sms' => 'SMS'], app()->request->message_type) !!}
                                        </select>
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-6 col-md-3 col-lg-3 col-xl-3">
                                    <div class="form-group">
                                        <select class="form-control m-input" name="purpose" id="purpose">
                                            <option value="">---- Select Purpose ----</option>
                                            @foreach ($purposeOptions as $key => $label)
                                                <option value="{{ $key }}"
                                                    {{ app()->request->purpose == $key ? 'selected' : '' }}>
                                                    {{ $label }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-6 col-md-3 col-lg-3 col-xl-3">
                                    <input type="text" class="form-control m-input m_datepicker"
                                        value="{!! app()->request->start_date !!}" name="start_date" id="start_date"
                                        placeholder="Start Date" autocomplete="off" readonly
                                        aria-describedby="start_date-error" aria-invalid="false">
                                </div>
                                <div class="col-xs-12 col-sm-6 col-md-3 col-lg-43 col-xl-3">
                                    <input type="text" class="form-control m-input m_datepicker" name="end_date"
                                        value="{!! app()->request->end_date !!}" id="end_date" placeholder="End Date"
                                        autocomplete="off" readonly aria-describedby="end_date-error" aria-invalid="false">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="pull-right search-action-btn">
                                        <button class="btn btn-primary m-btn m-btn--icon"><i class="fa fa-search"></i>
                                            Search
                                        </button>
                                        <a class="btn btn-default m-btn m-btn--icon"
                                            href="{{ url('admin/report_sms_email_report') }}">
                                            <i class="fas fa-sync-alt search-reset"></i> Reset</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                    <div class="m-section__content">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="">
                                    <div class="table m-table table-responsive">
                                        @include('common/datatable')
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

@push('scripts')
    <script>
        $(".m_datepicker").datepicker({
            todayHighlight: !0,
            orientation: "bottom left",
            format: 'dd/mm/yyyy',
            autoclose: true,
        });
    </script>
@endpush
