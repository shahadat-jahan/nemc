@extends('layouts.default')
@section('pageTitle', $pageTitle)

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="m-portlet">
                <div class="m-portlet__head">
                    <div class="m-portlet__head-caption">
                        <div class="m-portlet__head-title">
                            <h3 class="m-portlet__head-text"><i class="fas fa-clipboard pr-2"></i>{{ $pageTitle }}</h3>
                        </div>
                    </div>
                    <div class="m-portlet__head-tools">
                        @if (hasPermission('lesson_plan/edit'))
                            <a href="{{ route('lesson.plan.edit', $lessonPlan->id) }}"
                                class="btn btn-primary m-btn m-btn--icon">
                                <i class="flaticon-edit pr-2"></i>Edit
                            </a>
                        @endif
                        @if ($lessonPlan->pdf_file && file_exists(public_path($lessonPlan->pdf_file)))
                            <a href="{{ route('lesson.plan.download.pdf', $lessonPlan->id) }}"
                                class="btn btn-primary m-btn m-btn--icon ml-2" download>
                                <i class="fa fa-download pr-2"></i>Download PDF
                            </a>
                        @else
                            <a href="{{ route('lesson.plan.pdf', $lessonPlan->id) }}"
                                class="btn btn-primary m-btn m-btn--icon ml-2" target="_blank">
                                <i class="far fa-file-pdf pr-2"></i>Generate PDF
                            </a>
                        @endif
                        <a href="{{ route('lesson.plan.index', $lessonPlan->topic_id) }}"
                            class="btn btn-primary m-btn m-btn--icon ml-2">
                            <i class="fas fa-list-ul pr-2"></i>List
                        </a>
                    </div>
                </div>

                <div class="m-portlet__body">
                    @if ($lessonPlan->pdf_file && file_exists(public_path($lessonPlan->pdf_file)))
                        <div class="alert alert-info mb-3">
                            <strong>Note:</strong> This lesson plan has an uploaded PDF document.
                        </div>
                        <div class="mb-4 text-center">
                            <iframe src="{{ asset($lessonPlan->pdf_file) }}#toolbar=0" width="100%" height="600px"
                                style="border: 1px solid #ddd;">
                                <p>Your browser does not support PDFs.
                                    <a href="{{ route('lesson.plan.download.pdf', $lessonPlan->id) }}">Download the PDF</a>
                                    instead.
                                </p>
                            </iframe>
                        </div>
                        <div class="text-center mb-4">
                            <a href="{{ route('lesson.plan.download.pdf', $lessonPlan->id) }}"
                                class="btn btn-success btn-lg" download>
                                <i class="fa fa-download pr-2"></i>Download PDF
                            </a>
                        </div>
                    @else
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
                                        @if (!empty($contents) && isset($contents[0]['context']))
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
                    @endif
                    <div style="width: 100%; text-align: right; margin-top: 20px;">
                        <strong>Creator:</strong>
                        {{ $lessonPlan->creator->teacher ? $lessonPlan->creator->teacher->full_name : $lessonPlan->creator->name }}<br>
                        <strong>Updater:</strong>
                        {{ $lessonPlan->updater->teacher ? $lessonPlan->updater->teacher->full_name : $lessonPlan->updater->name }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
