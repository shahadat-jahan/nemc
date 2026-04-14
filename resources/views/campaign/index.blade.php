@extends('layouts.default')

@section('content')
    <div class="m-portlet m-portlet--mobile">
        <div class="m-portlet__head">
            <div class="m-portlet__head-caption">
                <div class="m-portlet__head-title">
                    <h3 class="m-portlet__head-text">
                        Campaign List
                    </h3>
                </div>
            </div>
            <div class="m-portlet__head-tools">
                <ul class="m-portlet__nav">
                    <li class="m-portlet__nav-item">
                        <a href="{{ route('campaigns.create') }}"
                            class="btn btn-primary m-btn m-btn--pill m-btn--custom m-btn--icon m-btn--air">
                            <span>
                                <i class="la la-plus"></i>
                                <span>New Campaign</span>
                            </span>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
        <div class="m-portlet__body">
            <!-- Filter Section -->
            <form role="form" id="searchForm" class="mb-3">
                    <div class="row">
                        <div class="col-md-3">
                            <label>Channel</label>
                            <select name="channel" class="form-control m-input">
                                <option value="">All</option>
                                <option value="email">Email</option>
                                <option value="sms">SMS</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label>Status</label>
                            <select name="status" class="form-control m-input">
                                <option value="">All</option>
                                <option value="draft">Draft</option>
                                <option value="scheduled">Scheduled</option>
                                <option value="processing">Processing</option>
                                <option value="completed">Completed</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label>Date From</label>
                            <input type="text" name="date_from" id="filter_date_from"
                                   class="form-control m-input m_datepicker"
                                   placeholder="dd/mm/yyyy" autocomplete="off" readonly>
                        </div>
                        <div class="col-md-3">
                            <label>Date To</label>
                            <input type="text" name="date_to" id="filter_date_to"
                                   class="form-control m-input m_datepicker"
                                   placeholder="dd/mm/yyyy" autocomplete="off" readonly>
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
                            <div class="pull-right search-action-btn">
                            <button type="submit" class="btn btn-primary m-btn m-btn--icon search-result">
                                <span><i class="la la-search"></i> <span>Filter</span></span>
                            </button>
                            <button type="button" class="btn btn-default m-btn m-btn--icon reset">
                                <span><i class="la la-refresh"></i> <span>Reset</span></span>
                            </button>
                            </div>
                        </div>
                    </div>
                </form>

            <!--begin: Datatable -->
            <div class="table m-table table-responsive">
                @include('common/datatable')
            </div>
            <!--end: Datatable -->
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        $(document).ready(function () {
            $('.m_datepicker').datepicker({
                todayHighlight: true,
                orientation: 'bottom left',
                format: 'dd/mm/yyyy',
                autoclose: true,
            });
        });
    </script>
@endpush
