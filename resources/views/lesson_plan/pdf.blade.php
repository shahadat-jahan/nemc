<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lesson PLan</title>
    <style>
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
            background-color: #ffffff;
            padding: 10px 40px;
        }

        .logo {
            width: 150px;
            margin-left: -30px;
        }

        .row {
            display: flex;
            flex-wrap: wrap;
        }

        .col-6 {
            width: 50%;
            flex: 0 0 auto;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        table thead th {
            border: 1px solid #dee2e6;
        }

        table th,
        table td {
            padding: 5px;
            text-align: left !important;
            vertical-align: middle !important;
        }

        .table-bordered {
            box-shadow: 0 0 5px 0.5px gray;
        }

        .table-bordered td,
        .table-bordered th {
            border: 1px solid #dee2e6;
        }

        .text-uppercase {
            text-transform: uppercase;
        }

        .text-center {
            text-align: center;
        }

        .text-left {
            text-align: left;
        }

        .text-right {
            text-align: right;
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

        .info {
            width: 100%;
        }

        .info_one {
            width: 50%;
            float: left;
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
                <h2>North East Medical College, Sylhet</h2>
                @if (isset($department) && $department)
                    <span> Department of {{ $department }} </span>
                    <br>
                @endif
                <br>
            </div>
        </div>
        <h3 class="text-center">
            <span> LessonPlan of {{$subject}} </span>
        </h3>
        <br />
        <table class="table table-bordered">
            <tr>
                <th>Title:</th>
                <td colspan="2">{{ $lessonPlan->title }}</td>
            </tr>
            <tr>
                <th>Topic:</th>
                <td colspan="2">{{ $lessonPlan->topic->title }}</td>
            </tr>
            <tr>
                <th>Speaker:</th>
                <td colspan="2">{{ $lessonPlan->speaker->full_name }}</td>
            </tr>
            <tr>
                <th>Audience:</th>
                <td colspan="2">{{ $lessonPlan->audience }}</td>
            </tr>
            <tr>
                <th>Place:</th>
                <td colspan="2">{{ $lessonPlan->place }}</td>
            </tr>
            <tr>
                <th>Date:</th>
                <td colspan="2">
                    {{ $lessonPlan->date ? date('d M Y', strtotime($lessonPlan->date)) : 'Not specified' }}
                </td>
            </tr>
            <tr>
                <th>Time:</th>
                <td colspan="2">
                    {{ $lessonPlan->start_time && $lessonPlan->end_time ? parseClassTimeInTwelveHours($lessonPlan->start_time) . ' - ' . parseClassTimeInTwelveHours($lessonPlan->end_time) : 'Not specified' }}
                </td>
            </tr>
            <tr>
                <th>Duration:</th>
                <td colspan="2">{{ $lessonPlan->duration }}</td>
            </tr>
            <tr>
                <th>Method of Instruction:</th>
                <td colspan="2">{{ $lessonPlan->method_of_instruction }}</td>
            </tr>
            <tr>
                <th>Instructional Material:</th>
                <td colspan="2">{{ $lessonPlan->instructional_material }}</td>
            </tr>
            <tr>
                <th>Objectives:</th>
                <td colspan="2">{!! nl2br(e($lessonPlan->objectives)) !!}</td>
            </tr>
            @php
                $timeAllocation = $lessonPlan->time_allocation
                    ? json_decode($lessonPlan->time_allocation, true)
                    : [];
            @endphp
            <tr>
                <th colspan="2">Time Allocation</th>
                <th>Duration</th>
            </tr>
            <tr>
                <td colspan="2">Attendance taking:</td>
                <td>{{ $timeAllocation['attendance'] ?? '-' }}</td>
            </tr>
            <tr>
                <td colspan="2">Objective:</td>
                <td>{{ $timeAllocation['objective'] ?? '-' }}</td>
            </tr>
            <tr>
                <td colspan="2">Purpose of learning:</td>
                <td>{{ $timeAllocation['purpose'] ?? '-' }}</td>
            </tr>
            <tr>
                <td colspan="2">Prerequisite learning:</td>
                <td>{{ $timeAllocation['prerequisite'] ?? '-' }}</td>
            </tr>
            @php
                $contents = $timeAllocation['contents'] ?? null;
            @endphp
            @if (is_array($contents) && count($contents) && isset($contents[0]['context']))
                @foreach ($contents as $item)
                    <tr>
                        @if ($loop->first)
                            <td rowspan="{{ count($contents) }}">Contents:</td>
                        @endif
                            <td width="50%">{{ $item['context'] ?? '' }}</td>
                            <td>{{ $item['time'] ?? '' }}</td>
                    </tr>
                @endforeach
            @else
                <tr>
                    <td colspan="2">Contents:</td>
                    <td>
                        @if (!empty($contents))
                            {!! nl2br(e(is_array($contents) ? json_encode($contents) : $contents)) !!}
                        @else
                            -
                        @endif
                    </td>
                </tr>
            @endif
            <tr>
                <td colspan="2">Summary:</td>
                <td>{{ $timeAllocation['summary'] ?? '-' }}</td>
            </tr>
            <tr>
                <td colspan="2">Assessment:</td>
                <td>{{ $timeAllocation['assessment'] ?? '-' }}</td>
            </tr>
        </table>
        <div style="width: 100%; text-align: right; margin-top: 20px;">
            <strong>Creator:</strong>
            {{ $lessonPlan->creator->teacher ? $lessonPlan->creator->teacher->full_name : $lessonPlan->creator->name }}<br>
            <strong>Updater:</strong>
            {{ $lessonPlan->updater->teacher ? $lessonPlan->updater->teacher->full_name : $lessonPlan->updater->name }}
        </div>
    </div>
</body>

</html>
