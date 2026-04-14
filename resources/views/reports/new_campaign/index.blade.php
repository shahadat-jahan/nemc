@extends('layouts.default')
@section('pageTitle', $pageTitle)
@section('content')
        <div class="m-portlet">
            <div class="m-portlet__head">
                <div class="m-portlet__head-caption">
                    <div class="m-portlet__head-title">
                        <h3 class="m-portlet__head-text">
                            {{ $pageTitle }}
                        </h3>
                    </div>
                </div>
            </div>
            <div class="m-portlet__body">
                <div class="m-section__content">
                <form role="form" id="searchForm" method="get">
                    <div class="row">
                        <div class="col-md-3">
                            <label>Channel</label>
                            <select name="channel" class="form-control m-input">
                                <option value="">All</option>
                                <option value="email" {{ request('channel') == 'email' ? 'selected' : '' }}>Email</option>
                                <option value="sms" {{ request('channel') == 'sms' ? 'selected' : '' }}>SMS</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label>Status</label>
                            <select name="status" class="form-control m-input">
                                <option value="">All</option>
                                <option value="1" {{ request('status') == '1' ? 'selected' : '' }}>Success</option>
                                <option value="0" {{ request('status') == '0' ? 'selected' : '' }}>Failed</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label>Date From</label>
                            <input type="text" name="date_from" id="filter_date_from"
                                   class="form-control m-input m_datepicker"
                                   value="{{ request('date_from') }}"
                                   placeholder="dd/mm/yyyy" autocomplete="off" readonly>
                        </div>
                        <div class="col-md-3">
                            <label>Date To</label>
                            <input type="text" name="date_to" id="filter_date_to"
                                   class="form-control m-input m_datepicker"
                                   value="{{ request('date_to') }}"
                                   placeholder="dd/mm/yyyy" autocomplete="off" readonly>
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
                            <div class="pull-right search-action-btn">
                                @if($reports->count() > 0)
                                    <div class="btn-group" data-hover="dropdown">
                                                <button type="button"
                                                        class="btn btn-primary m-btn m-btn--icon pdf-dropdown-btn"
                                                        data-toggle="dropdown" data-trigger="hover" aria-haspopup="true"
                                                        aria-expanded="false">
                                                    <i class="fa fa-file-pdf"></i> PDF Download <i class="pt-1 fa fa-angle-down angle-icon"></i>
                                                </button>
                                                <div class="dropdown-menu dropdown-menu-right w-100">
                                                    <a class="dropdown-item"
                                                       href="{{ route('report.new_campaign.pdf', array_merge(request()->all(), ['page_layout' => 'A4-landscape'])) }}"
                                                       target="_blank">
                                                        <i class="fas fa-arrows-alt-h"></i> Landscape
                                                    </a>
                                                    <a class="dropdown-item"
                                                       href="{{ route('report.new_campaign.pdf', array_merge(request()->all(), ['page_layout' => 'A4-portrait'])) }}"
                                                       target="_blank">
                                                        <i class="fas fa-arrows-alt-v"></i> Portrait
                                                    </a>
                                                </div>
                                            </div>
                                            <a href="{{route('report.new_campaign.excel', request()->all())}}"
                                               class="btn btn-primary m-btn m-btn--icon">
                                                <i class="fa fa-file-export"></i> Export
                                            </a>
                                @endif
                                <button type="submit" class="btn btn-primary m-btn m-btn--icon search-result">
                                    <span><i class="fa fa-search"></i> <span>Search</span></span>
                                </button>
                                <a href="{{ route('report.new_campaign.index') }}" class="btn btn-default m-btn m-btn--icon reset">
                                    <span><i class="la la-refresh"></i> <span>Reset</span></span>
                                </a>
                            </div>
                        </div>
                    </div>
                </form>

                <div class="table-responsive">
                    <table class="table table-bordered table-hover">
                        <thead>
                            <tr>
                                <th>Sl.</th>
                                <th>Channel</th>
                                <th>Title</th>
                                <th>Receiver</th>
                                <th>Contact Info</th>
                                <th>Message</th>
                                <th>Response</th>
                                <th>Status</th>
                                <th width="10%">Sent At</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($reports as $index => $row)
                                <tr>
                                    <td>{{ $reports->firstItem() + $index }}</td>
                                    <td>
                                        @php
                                            $class = $row->channel == 'email' ? 'success' : 'brand';
                                        @endphp
                                        <span class="m-badge m-badge--{{ $class }} m-badge--wide">{{ strtoupper($row->channel) }}</span>
                                    </td>
                                    <td>{{ ucfirst(str_replace('_', ' ', $row->campaign_type ?? '')) }}</td>
                                    <td>{{ $row->receiver_type ? class_basename($row->receiver_type) : 'Unknown' }}</td>
                                    <td>
                                        @if($row->channel === 'email')
                                            {{ $row->email ?? 'N/A' }}
                                        @else
                                            {{ $row->mobile_number ?? 'N/A' }}
                                        @endif
                                    </td>
                                    <td>{{ strip_tags($row->message) }}</td>
                                    <td>
                                        {{ is_array($row->response) ? json_encode($row->response) : $row->response }}</td>
                                    <td>
                                        @if($row->status == 1)
                                            <span class="text-success">Success</span>
                                        @else
                                            <span class="text-danger">Failed</span>
                                        @endif
                                    </td>
                                    <td>
                                        {{ $row->sent_at ? \Carbon\Carbon::parse($row->sent_at)->format('d M, Y h:i A') : 'N/A' }}
                                        <br>
                                        <small class="text-muted">{{ $row->sent_at ? \Carbon\Carbon::parse($row->sent_at)->diffForHumans() : '' }}</small>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8" class="text-center">No data found</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                    <div class="float-right">
                        {{ $reports->appends(request()->input())->links() }}
                    </div>
                </div>
                <!--end: Datatable -->
            </div>
        </div>
    </div>
@endsection

@push('scripts')
 <script src="//cdnjs.cloudflare.com/ajax/libs/lodash.js/4.17.11/lodash.min.js" type="text/javascript"></script>
    <script>
        $(document).ready(function () {
            $('.m_datepicker').datepicker({
                todayHighlight: true,
                orientation: 'bottom left',
                format: 'dd/mm/yyyy',
                autoclose: true,
            });

            // PDF dropdown hover effect
            $('.btn-group[data-hover="dropdown"]').hover(
                function() {
                    $(this).find('.dropdown-menu').stop(true, true).delay(100).fadeIn(200);
                    $(this).find('.angle-icon').removeClass('fa-angle-down').addClass('fa-angle-up');
                },
                function() {
                    $(this).find('.dropdown-menu').stop(true, true).delay(100).fadeOut(200);
                    $(this).find('.angle-icon').removeClass('fa-angle-up').addClass('fa-angle-down');
                }
            );


            // Form submission
            $('.search-result').click(function(e) {
                e.preventDefault();

                // Show loading
                mApp.blockPage({
                    overlayColor: "#000000",
                    type: "loader",
                    state: "primary",
                    message: "Please wait..."
                });

                $('#searchForm').submit();
            });
        });
    </script>
@endpush
