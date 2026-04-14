<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Teacher Attendance</title>
    <style type="text/css">
        h1,
        h2,
        h3,
        h4,
        h5,
        h6 {
            margin: 0;
            padding: 0;
        }

        p {
            margin: 0;
            padding: 0;
        }

        .brand-section {
            background-color: #fff;
            /* padding: 10px 40px; */
        }

        .logo {
            width: 150px;
        }

        .row {
            display: flex;
            flex-wrap: wrap;
        }

        .col-6 {
            width: 50%;
            flex: 0 0 auto;
        }

        .text-black {
            color: #000 !important;
        }

        table {
            border-collapse: collapse;
            margin: 10px auto;
        }

        table thead tr {
            border: 1px solid #dee2e6;
            font-size: 15px;
        }

        table td {
            font-size: 13px;
            /*vertical-align: middle !important;*/
            /*text-align: center;*/
        }

        table th,
        table td {
            padding: 5px;
        }

        .table-bordered {
            box-shadow: 0 0 5px 0.5px gray;
        }

        .table-bordered td,
        .table-bordered th {
            border: 1px solid #dee2e6;
        }

        .text-uppercase {
            text-transform: uppercase !important;
        }

        .text-center {
            text-align: center !important;
        }

        .text-left {
            text-align: left !important;
        }

        .text-right {
            text-align: end !important;
        }

        .w-30 {
            width: 30%;
        }

        .w-70 {
            width: 70%;
        }

        .float-right {
            float: right;
        }


        .green-text {
            color: green;
        }

        .red-text {
            color: red;
        }

        /* Wrapper for summary and signature sections */
        .bottom-section {
            display: flex;
            /* Flexbox layout */
            justify-content: space-between;
            /* Place items at opposite ends */
            align-items: flex-end;
            /* Align items at the top */
            /*gap: 20px; !* Add spacing between items *!*/
            margin-top: 20px;
        }

        /* Styling for the summary section */
        .summary-section {
            padding-left: 50px !important;
            /*min-width: 10%; !* Ensure it has some minimum width *!*/
        }

        /* Styling for the signature section */
        .signature-section {
            min-width: 15%;
            /* Ensure it has some minimum width */
            /*margin-right: 30px;*/
        }

        @page {
            footer: page-footer;
            margin-footer: 10px;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="brand-section">
            <span>
                <img class="logo" src="{{ asset('assets/global/img/logo.jpg') }}" />
            </span>
            <div style="margin-top: -45px" class="text-center">
                <h2>
                    North East Medical College, Sylhet
                </h2>
                <h3>Teacher Attendance Report</h3>

            </div>
            <div style="margin-top: 40px;">
                <h4>Teacher Information</h4>
                <table style="width: 100%;">
                    <tr>
                        <th width="30%" style="text-align: left;">Name:</th>
                        <td style="text-align: left;">{{ $teacher->full_name }}</td>
                    </tr>
                    <tr>
                        <th style="text-align: left;">ID:</th>
                        <td style="text-align: left;">
                            {{ !empty($teacher->user->user_id) ? $teacher->user->user_id : 'n/a' }}</td>
                    </tr>
                    <tr>
                        <th style="text-align: left;">Department:</th>
                        <td style="text-align: left;">
                            {{ !empty($teacher->department->title) ? $teacher->department->title : 'n/a' }}</td>
                    </tr>
                    <tr>
                        <th style="text-align: left;">Designation:</th>
                        <td style="text-align: left;">
                            {{ !empty($teacher->designation->title) ? $teacher->designation->title : 'n/a' }}</td>
                    </tr>
                    <tr>
                        <th style="text-align: left;">Email:</th>
                        <td style="text-align: left;">{{ !empty($teacher->email) ? $teacher->email : 'n/a' }}</td>
                    </tr>
                    <tr>
                        <th style="text-align: left;">Phone:</th>
                        <td style="text-align: left;">{{ !empty($teacher->phone) ? $teacher->phone : 'n/a' }}</td>
                    </tr>
                </table>
            </div>
        </div>
        @if (isset($teacherWiseClass) && !empty($teacherWiseClass))
            <div class="attendance-details">
                <h4 style="text-align: center;">Class Attendance Details</h4>
                <table class="table table-bordered table-hover">
                    <thead>
                        <tr>
                            <th>Routine ID</th>
                            <th>Session</th>
                            <th>Phase</th>
                            <th>Term</th>
                            <th>Subject</th>
                            <th>Class Date</th>
                            <th>Attendance Date</th>
                            <th>Start From</th>
                            <th>End At</th>
                            <th>Class Done</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $totalClass = count($teacherWiseClass);
                            $totalTaken = 0;
                            $totalNotTaken = 0;
                            $totalSuspended = 0;
                        @endphp
                        @foreach ($teacherWiseClass as $key => $value)
                            @php
                                $class_routine_id = $value['class_routine_id'];
                                $attendClass = $value['class_status'] == 1 ?
                                             getAttaendClass($class_routine_id) : 'Suspended';

                                if ($value['class_status'] == 1){
                                    $color = getAttaendClass($class_routine_id)
                                     == 'Yes' ? 'green' : 'red';
                                } elseif ($value['class_status'] == 2){
                                    $color = 'orange';
                                }

                                $totalTaken += $attendClass == 'Yes' ? 1 : 0;
                                $totalNotTaken += $attendClass == 'No' ? 1 : 0;
                                $totalSuspended += $attendClass == 'Suspended' ? 1 : 0;
                            @endphp
                            <tr>
                                <td>{{ $class_routine_id }}</td>
                                <td>{{ $value['session'] }}</td>
                                <td>{{ $value['phase'] }}</td>
                                <td>{{ $value['term'] }}</td>
                                <td>{{ $value['subject'] }}</td>
                                <td>{{ $value['class_date'] }}</td>
                                <td>{!! $value['attendance_date'] !!}</td>
                                <td>{{ $value['start_from'] }}</td>
                                <td>{{ $value['end_at'] }}</td>
                                <td>
                                    <span style='color:{{ $color }}'>{{ $attendClass }}</span>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <p>No attendance records found for this teacher.</p>
        @endif
    </div>
    <table width="100%" style="padding-top: 10px;">
        <tr>
            <!-- Summary Section -->
            <td width="20%" style="font-size: 12px; vertical-align: top;">
                <h5 style="font-size: 16px; margin-bottom: 5px;">Summary:</h5>
                <p>Total Class: {{ $totalClass }}</p>
                <p>Taken: {{ $totalTaken }}</p>
                <p>Not taken: {{ $totalNotTaken }}</p>
                <p>Suspended: {{ $totalSuspended }}</p>
            </td>

            <!-- Page Number Section -->
            <td width="50%"></td>

            <!-- Signature Section -->
            <td width="30%" style="text-align: center; vertical-align: bottom; font-size: 12px;">
                <div>
                    _________________________
                </div>
                <p>Signature</p>
                <p>Date: {{ \Carbon\Carbon::now()->format('d-M-Y') }}</p>
            </td>
        </tr>
    </table>
    <htmlpagefooter name="page-footer">
        <div style="text-align: center; font-size: 12px; vertical-align: bottom;">Page {PAGENO} of {nbpg}</div>
    </htmlpagefooter>
</body>

</html>
