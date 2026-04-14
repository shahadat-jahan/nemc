@php use Carbon\Carbon; @endphp
@extends('layouts.default')
@section('pageTitle', $pageTitle)

@section('content')
    <div class="row">
        <div class="col-xl-4">
            <!--begin::Portlet-->
            <div class="m-portlet m-portlet--full-height">
                <div class="m-portlet__head">
                    <div class="m-portlet__head-caption">
                        <div class="m-portlet__head-title">
                            <h3 class="m-portlet__head-text">
                                Campaign Summary
                            </h3>
                        </div>
                    </div>
                </div>
                <div class="m-portlet__body">
                    <div class="m-widget13">
                        <div class="m-widget13__item">
                                <span class="m-widget13__desc m--align-right">
                                    Campaign Title:
                                </span>
                            <span class="m-widget13__text m-widget13__text-b">
                                    {{ $campaign->title }}
                                </span>
                        </div>
                        <div class="m-widget13__item">
                                <span class="m-widget13__desc m--align-right">
                                    Channel:
                                </span>
                            <span class="m-widget13__text">
                                    <span
                                        class="m-badge m-badge--{{ $campaign->channel == 'email' ? 'success' : 'brand' }} m-badge--wide">{{ strtoupper($campaign->channel) }}</span>
                                </span>
                        </div>
                        @if($campaign->channel == 'email')
                            <div class="m-widget13__item">
                                    <span class="m-widget13__desc m--align-right">
                                        Subject:
                                    </span>
                                <span class="m-widget13__text">
                                        {{ $campaign->subject }}
                                    </span>
                            </div>
                        @endif
                        <div class="m-widget13__item">
                                <span class="m-widget13__desc m--align-right">
                                    Status:
                                </span>
                            <span class="m-widget13__text">
                                    <span
                                        class="m-badge m-badge--{{ $campaign->status == 'completed' ? 'success' : ($campaign->status == 'processing' ? 'warning' : 'info') }} m-badge--wide">{{ ucfirst($campaign->status) }}</span>
                                </span>
                        </div>
                        <div class="m-widget13__item">
                                <span class="m-widget13__desc m--align-right">
                                    Scheduled For:
                                </span>
                            <span class="m-widget13__text">
                                    {{ $campaign->scheduled_at ? Carbon::parse($campaign->scheduled_at)->format('Y-m-d H:i') : 'N/A' }}
                                </span>
                        </div>
                        <div class="m-widget13__item">
                                <span class="m-widget13__desc m--align-right">
                                    Created At:
                                </span>
                            <span class="m-widget13__text">
                                    {{ $campaign->created_at->format('Y-m-d H:i') }}
                                </span>
                        </div>
                    </div>
                </div>
            </div>
            <!--end::Portlet-->
        </div>
        <div class="col-xl-8">
            <!--begin::Portlet-->
            <div class="m-portlet m-portlet--full-height">
                <div class="m-portlet__head">
                    <div class="m-portlet__head-caption">
                        <div class="m-portlet__head-title">
                            <h3 class="m-portlet__head-text">
                                Message Content
                            </h3>
                        </div>
                    </div>
                    <div class="m-portlet__head-tools m-portlet__head-tools--right">
                        @if ($campaign->status === 'completed' && hasPermission('campaigns/create'))
                            <a href="{{ route('campaigns.rerun', $campaign->id) }}"
                               class="btn btn-primary m-btn m-btn--pill m-btn--custom m-btn--icon m-btn--air mr-2">
                                    <span>
                                        <i class="la la-refresh"></i>
                                        <span>Re-run</span>
                                    </span>
                            </a>
                        @endif
                        @if(in_array($campaign->status, ['draft', 'scheduled']) && hasPermission('campaigns/edit'))
                            <a href="{{ route('campaigns.edit', $campaign->id) }}"
                               class="btn btn-primary m-btn m-btn--pill m-btn--custom m-btn--icon m-btn--air mr-2">
                                    <span>
                                        <i class="la la-edit"></i>
                                        <span>Edit</span>
                                    </span>
                            </a>
                        @endif
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
                <div class="m-portlet__body">
                    <div class="p-3 border bg-light rounded" style="white-space: pre-wrap;">{{ $campaign->message }}
                    </div>
                </div>
            </div>
            <!--end::Portlet-->
        </div>
    </div>

    <div class="row">
        <div class="col-xl-12">
            <!--begin::Portlet-->
            <div class="m-portlet m-portlet--mobile">
                <div class="m-portlet__head">
                    <div class="m-portlet__head-caption">
                        <div class="m-portlet__head-title">
                            <h3 class="m-portlet__head-text">
                                Recipients & Delivery Status
                            </h3>
                        </div>
                    </div>
                </div>
                <div class="m-portlet__body">
                    <!--begin: Datatable -->
                    <table class="table table-striped table-bordered table-hover"
                           id="m_table_recipients">
                        <thead>
                        <tr>
                            <th>User ID</th>
                            <th>Name</th>
                            <th>Type</th>
                            <th>Contact Info</th>
                            <th>Status</th>
                            <th>Response</th>
                            <th>Sent At</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($campaign->recipients as $recipient)
                            <tr>
                                <td>{{ $recipient->recipientable->user->user_id ?? 'N/A' }}</td>
                                <td>{{ $recipient->recipientable->full_name ?? 'N/A' }}</td>
                                <td>{{ class_basename($recipient->recipientable_type) }}</td>
                                <td>
                                    @if($campaign->channel == 'email')
                                        {{ $recipient->recipientable->email ??
                                        $recipient->recipientable->father_email ?? 'Not set' }}
                                    @else
                                        {{ $recipient->recipientable->mobile ??
                                        $recipient->recipientable->father_phone ?? 'Not set' }}
                                    @endif
                                </td>
                                <td>
                                    <span class="m-badge m-badge--{{ $recipient->status == 'sent' ? 'success'
                                        : ($recipient->status == 'failed' ? 'danger' : 'metal') }} m-badge--dot"></span>&nbsp;
                                    <span class="m--font-bold m--font-{{ $recipient->status == 'sent' ? 'success'
                                        : ($recipient->status == 'failed' ? 'danger' : 'metal') }}">{{ ucfirst($recipient->status) }}</span>
                                </td>
                                <td>{{ $recipient->response ?? 'N/A' }}</td>
                                <td>
                                    {{ $recipient->sent_at ? Carbon::parse($recipient->sent_at)->format('Y-m-d H:i') : '-' }}
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                    <!--end: Datatable -->
                </div>
            </div>
            <!--end::Portlet-->
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        $(document).ready(function () {
            $('#m_table_recipients').DataTable({
                responsive: true,
                pageLength: 10,
                order: [[0, 'asc']]
            });
        });
    </script>
@endpush
