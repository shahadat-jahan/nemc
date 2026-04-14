<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Campaign Report</title>
    <style>
        h1, h2, h3, h4, h5, h6 {
            margin: 0;
            padding: 0;
        }

        p {
            margin: 0;
            padding: 0;
        }

        .brand-section {
            padding: 10px 40px;
        }

        .logo {
            width: 150px;
            margin-left: -30px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        table thead th {
            border: 1px solid #dee2e6;
            background-color: #f2f2f2;
        }

        table td {
            vertical-align: middle !important;
            text-align: left;
            font-size: 11px;
        }

        table th {
            padding: 5px;
            font-size: 12px;
        }

        .table-bordered td, .table-bordered th {
            border: 1px solid #dee2e6;
        }

        .text-center {
            text-align: center;
        }
    </style>
</head>
<body>
<div class="container">
    <div class="brand-section">
        <span>
            <img class="logo" src="{{ public_path('assets/global/img/logo.jpg') }}"/>
        </span>
        <div style="margin-top: -45px" class="text-center">
            <h2>North East Medical College, Sylhet</h2>
            <br>
            <h3>Campaign Report</h3>
        </div>
    </div>
    <br/>
    <table class="table table-bordered">
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
                <th width="15%">Sent At</th>
            </tr>
        </thead>
        <tbody>
            @foreach($reports as $index => $row)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ strtoupper($row->channel) }}</td>
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
                    <td>{{ is_array($row->response) ? json_encode($row->response) : $row->response }}</td>
                    <td>{{ $row->status == 1 ? 'Success' : 'Failed' }}</td>
                    <td>
                        {{ $row->sent_at ? \Carbon\Carbon::parse($row->sent_at)->format('d M, Y h:i A') : 'N/A' }}
                        <br>
                        <small class="text-muted">{{ $row->sent_at ? \Carbon\Carbon::parse($row->sent_at)->diffForHumans() : '' }}</small>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
</body>
</html>
