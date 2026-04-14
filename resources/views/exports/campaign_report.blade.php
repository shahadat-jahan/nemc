<div class="col-md-12" style="position:relative;width:100%;padding-right:15px;padding-left:15px;-ms-flex:0 0 100%;flex:0 0 100%;max-width:100%;">
    <div class="text-center" style="text-align:center; margin-left: 500px;">
        <h4 class="font-bold text-uppercase" style="font-size:1.5rem;margin-bottom:.5rem;line-height:1.2;margin-top:0;font-weight:bold;text-transform:uppercase;">North East Medical College, Sylhet</h4>
        <h5 class="font-bold" style="font-size:1.2rem;margin-bottom:.5rem;line-height:1.2;margin-top:0;font-weight:bold;">
            <span>Campaign Report</span>
        </h5>
    </div>
</div>
<br/>
<table class="table table-bordered">
    <thead>
        <tr>
            <th style="vertical-align: middle; text-align: center; font-weight: bold; border: 1px solid #000000; background-color: #f2f2f2;">Sl.</th>
            <th style="vertical-align: middle; text-align: center; font-weight: bold; border: 1px solid #000000; background-color: #f2f2f2;">Channel</th>
            <th style="vertical-align: middle; text-align: center; font-weight: bold; border: 1px solid #000000; background-color: #f2f2f2;">Title</th>
            <th style="vertical-align: middle; text-align: center; font-weight: bold; border: 1px solid #000000; background-color: #f2f2f2;">Receiver</th>
            <th style="vertical-align: middle; text-align: center; font-weight: bold; border: 1px solid #000000; background-color: #f2f2f2;">Contact Info</th>
            <th style="vertical-align: middle; text-align: center; font-weight: bold; border: 1px solid #000000; background-color: #f2f2f2;">Message</th>
            <th style="vertical-align: middle; text-align: center; font-weight: bold; border: 1px solid #000000; background-color: #f2f2f2;">Response</th>
            <th style="vertical-align: middle; text-align: center; font-weight: bold; border: 1px solid #000000; background-color: #f2f2f2;">Status</th>
            <th width="15%" style="vertical-align: middle; text-align: center; font-weight: bold; border: 1px solid #000000; background-color: #f2f2f2;">Sent At</th>
        </tr>
    </thead>
    <tbody>
        @foreach($reports as $index => $row)
            <tr>
                <td style="vertical-align: middle; text-align: center; border: 1px solid #000000;">{{ $index + 1 }}</td>
                <td style="vertical-align: middle; text-align: center; border: 1px solid #000000;">{{ strtoupper($row->channel) }}</td>
                <td style="vertical-align: middle; text-align: center; border: 1px solid #000000;">{{ ucfirst(str_replace('_', ' ', $row->campaign_type ?? '')) }}</td>
                <td style="vertical-align: middle; text-align: center; border: 1px solid #000000;">{{ $row->receiver_type ? class_basename($row->receiver_type) : 'Unknown' }}</td>
                <td style="vertical-align: middle; text-align: center; border: 1px solid #000000;">
                    @if($row->channel === 'email')
                        {{ $row->email ?? 'N/A' }}
                    @else
                        {{ $row->mobile_number ?? 'N/A' }}
                    @endif
                </td>
                <td style="vertical-align: middle; text-align: left; border: 1px solid #000000;">{{ strip_tags($row->message) }}</td>
                <td style="vertical-align: middle; text-align: left; border: 1px solid #000000;">{{ is_array($row->response) ? json_encode($row->response) : $row->response }}</td>
                <td style="vertical-align: middle; text-align: center; border: 1px solid #000000;">{{ $row->status == 1 ? 'Success' : 'Failed' }}</td>
                <td style="vertical-align: middle; text-align: center; border: 1px solid #000000;">
                    {{ $row->sent_at ? \Carbon\Carbon::parse($row->sent_at)->format('d M, Y h:i A') : 'N/A' }}
                    <br>
                    <small class="text-muted">{{ $row->sent_at ? \Carbon\Carbon::parse($row->sent_at)->diffForHumans() : '' }}</small>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
