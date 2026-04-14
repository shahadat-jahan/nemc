@extends('layouts.default')
@section('pageTitle', $pageTitle)

@push('style')
    <style>
        .m-stack--demo.m-stack--ver .m-stack__item,
        .m-stack--demo.m-stack--hor .m-stack__demo-item {
            padding: 29px;
        }

        .column-rotate {
            transform: rotate(270deg);
        }

        .table thead th {
            vertical-align: top;
        }
    </style>
@endpush

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="m-portlet">
                <div class="m-portlet__head">
                    <div class="m-portlet__head-caption">
                        <div class="m-portlet__head-title">
                            <h3 class="m-portlet__head-text"><i class="fas fa-list-ul fa-md pr-2"></i>{{ $pageTitle }}</h3>
                        </div>
                    </div>
                </div>
                <div class="m-portlet__body">
                    <form id="searchForm" role="form" method="get"
                        action="{{ route('report.student.admission.type', [3]) }}">
                        <div class="form-body">
                            <div class="row">
                                <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 col-xl-6">
                                    <div class="form-group">
                                        <select class="form-control" name="session_id">
                                            <option value="">---- Select Session ----</option>
                                            {!! select($sessions, $sessionId) !!}
                                        </select>
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 col-xl-6">
                                    <div class="form-group">
                                        <select class="form-control" name="course_id">
                                            <option value="">---- Select Course ----</option>
                                            {!! select($courses, $courseId ?: Auth::user()->teacher->course_id ?? '') !!}
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="pull-right search-action-btn">
                                        @if (isset($searchResult) && !empty($searchResult->toArray()))
                                            <div class="btn-group" data-hover="dropdown">
                                                <button type="button"
                                                    class="btn btn-primary m-btn m-btn--icon pdf-dropdown-btn"
                                                    data-toggle="dropdown" data-trigger="hover" aria-haspopup="true"
                                                    aria-expanded="false">
                                                    <i class="fa fa-file-pdf"></i> PDF Download <i
                                                        class="pt-1 fa fa-angle-down angle-icon"></i>
                                                </button>
                                                <div class="dropdown-menu dropdown-menu-right w-100">
                                                    <a class="dropdown-item"
                                                        href="{{ route('report.student.admission.print.type', array_merge([3, 'session_id' => $sessionId, 'course_id' => $courseId], ['page_layout' => 'A4-landscape'])) }}"
                                                        target="_blank">
                                                        <i class="fas fa-arrows-alt-h"></i> Landscape
                                                    </a>
                                                    <a class="dropdown-item"
                                                        href="{{ route('report.student.admission.print.type', array_merge([3, 'session_id' => $sessionId, 'course_id' => $courseId], ['page_layout' => 'A4-portrait'])) }}"
                                                        target="_blank">
                                                        <i class="fas fa-arrows-alt-v"></i> Portrait
                                                    </a>
                                                </div>
                                            </div>
                                            <a class="btn btn-primary m-btn m-btn--icon"
                                                href="{{ route('report.student.admission.excel.type', [3, 'session_id' => $sessionId, 'course_id' => $courseId]) }}"
                                                class="btn btn-brand m-btn m-btn--icon"><i class="fa fa-file-export"></i>
                                                Export</a>
                                        @endif
                                        <button class="btn btn-primary m-btn m-btn--icon"><i class="fa fa-search"></i>
                                            Search</button>
                                        <a href="{{ route('report.student.admission.type', [3]) }}"
                                            class="btn btn-default reset"><i class="fas fa-sync-alt search-reset"></i>
                                            Reset</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                    <br>

                    <div class="m-section__content">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="">
                                    <div class="table m-table table-responsive">
                                        <table class="table table-bordered table-hover" id="dataTable">
                                            <thead>
                                                <tr>
                                                    <th rowspan="2">SL#</th>
                                                    <th rowspan="2">
                                                        <div style="width: 150px">Name & parents name of the candidates
                                                        </div>
                                                    </th>
                                                    <th rowspan="2">
                                                        <div style="width: 130px">Permanent Address</div>
                                                    </th>
                                                    <th rowspan="2">Date of birth</th>
                                                    <th rowspan="2">Nationality</th>
                                                    <th rowspan="2">Class Roll</th>
                                                    <th colspan="4">SSC</th>
                                                    <th colspan="5">HSC</th>
                                                    <th colspan="4">Particulars of Admission Test</th>
                                                    <th rowspan="2">Annual Income</th>
                                                    <th rowspan="2" class="column-rotate">Insolvent Gradation(11)</th>
                                                    <th rowspan="2">Immovable Assets</th>
                                                    <th rowspan="2" class="column-rotate">Insolvent Gradation(9)</th>
                                                    <th rowspan="2">Movable Assets</th>
                                                    <th rowspan="2" class="column-rotate">Insolvent Gradation(9)</th>
                                                    <th rowspan="2">Total Assets</th>
                                                    <th rowspan="2" class="column-rotate">Total Insolvent Gradation(9)
                                                    </th>
                                                    <th rowspan="2">Total Point from Merit Score & insolvement gradation
                                                    </th>
                                                    <th rowspan="2">Affidifit Verify</th>
                                                    <th rowspan="2">Admission Date</th>
                                                    <th rowspan="2">Remarks</th>
                                                    <th rowspan="2">Action</th>
                                                </tr>
                                                <tr>
                                                    <th>Board</th>
                                                    <th>Year</th>
                                                    <th>GPA<br>(WOS)</th>
                                                    <th>Total<br>GPA</th>
                                                    <th>Board</th>
                                                    <th>Year</th>
                                                    <th>GPA<br>(WOS)</th>
                                                    <th>Total<br>GPA</th>
                                                    <th>Biology</th>
                                                    <th>Roll No</th>
                                                    <th>Test Score</th>
                                                    <th>Merit Score</th>
                                                    <th>Merit Position</th>
                                                </tr>
                                                @if (isset($searchResult))
                                                    <tr>
                                                        <td>A</td>
                                                        <td>B</td>
                                                        <td>C</td>
                                                        <td>D</td>
                                                        <td>E</td>
                                                        <td>F</td>
                                                        <td>G</td>
                                                        <td>H</td>
                                                        <td>I</td>
                                                        <td>J</td>
                                                        <td>K</td>
                                                        <td>L</td>
                                                        <td>M</td>
                                                        <td>N</td>
                                                        <td>O</td>
                                                        <td>P</td>
                                                        <td>Q</td>
                                                        <td>R</td>
                                                        <td>S</td>
                                                        <td>T</td>
                                                        <td>U=(O+Q+S)</td>
                                                        <td>V=(P+R+T)</td>
                                                        <td>W=(M+V)</td>
                                                        <td>X</td>
                                                        <td>Y</td>
                                                        <td>Z</td>
                                                        <td>A</td>
                                                        <td>B</td>
                                                        <td>C</td>
                                                        <td>D</td>
                                                        <td>E</td>
                                                    </tr>
                                                @endif
                                            </thead>
                                            <tbody>
                                                @if (isset($searchResult))
                                                    @if (!empty($searchResult))
                                                        <?php $i = 1; ?>
                                                        @foreach ($searchResult as $student)
                                                            <?php
                                                            $sscInfo = $student->educations->first();
                                                            $hscInfo = $student->educations->last();
                                                            ?>
                                                            <tr>
                                                                <td>{{ $i }}</td>
                                                                <td>{!! '<b>Name:</b> ' .
                                                                    $student->full_name_en .
                                                                    '<br> <b>Father:</b> ' .
                                                                    $student->parent->father_name .
                                                                    '<br> <b>Mother:</b> ' .
                                                                    $student->parent->mother_name !!}</td>
                                                                <td>{{ $student->permanent_address }}</td>
                                                                <td>{{ $student->date_of_birth }}</td>
                                                                <td>{{ $student->country->name }}</td>
                                                                <td>{{ $student->roll_no }}</td>
                                                                <td>{{ $sscInfo->educationBoard->title }}</td>
                                                                <td>{{ $sscInfo->pass_year }}</td>
                                                                <td>{{ $sscInfo->gpa }}</td>
                                                                <td>{{ $sscInfo->gpa * 15 }}</td>
                                                                <td>{{ $hscInfo->educationBoard->title }}</td>
                                                                <td>{{ $hscInfo->pass_year }}</td>
                                                                <td>{{ $hscInfo->gpa }}</td>
                                                                <td>{{ $hscInfo->gpa * 25 }}</td>
                                                                <td>{{ $hscInfo->gpa_biology }}</td>
                                                                <td>{{ $student->admission_roll_no }}</td>
                                                                <td>{{ $student->test_score }}</td>
                                                                <td>{{ $student->merit_score }}</td>
                                                                <td>{{ $student->merit_position }}</td>
                                                                <td>{{ formatAmount($student->parent->annual_income, 0) }}
                                                                </td>
                                                                <td>{{ $student->parent->annual_income_grade }}</td>
                                                                <td>{{ formatAmount($student->parent->immovable_property, 0) }}
                                                                </td>
                                                                <td>{{ $student->parent->immovable_property_grade }}</td>
                                                                <td>{{ formatAmount($student->parent->movable_property, 2) }}
                                                                </td>
                                                                <td>{{ $student->parent->movable_property_grade }}</td>
                                                                <td>{{ formatAmount($student->parent->total_asset, 2) }}
                                                                </td>
                                                                <td>{{ $student->parent->total_asset_grade }}</td>
                                                                <td>{{ $student->merit_score + $student->parent->total_asset_grade }}
                                                                </td>
                                                                <td></td>
                                                                <td>{{ $student->form_fillup_date ? $student->form_fillup_date : '--' }}
                                                                </td>
                                                                <td>{{ $student->remarks }}</td>
                                                                <td>
                                                                    <a href="{{ route('admission.student.single.report', $student->id) }}"
                                                                        class="m-portlet__nav-link btn m-btn m-btn--hover-brand m-btn--icon m-btn--icon-only m-btn--pill"
                                                                        title="View">
                                                                        <i class="flaticon-eye"></i>
                                                                    </a>
                                                                </td>
                                                            </tr>
                                                            <?php $i++; ?>
                                                        @endforeach
                                                    @else
                                                        <tr>
                                                            <td colspan="15" align="center">No data found</td>
                                                        </tr>
                                                    @endif
                                                @endif
                                            </tbody>
                                        </table>
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
        $(document).ready(function() {
            // Enable dropdown on hover for PDF button
            $('.btn-group[data-hover="dropdown"]').hover(
                function () {
                    $(this).find('.dropdown-menu').stop(true, true).delay(100).fadeIn(200);
                },
                function () {
                    $(this).find('.dropdown-menu').stop(true, true).delay(100).fadeOut(200);
                }
            );

            $('.btn-group[data-hover="dropdown"]').hover(
                function () {
                    $(this).find('.angle-icon').removeClass('fa-angle-down').addClass('fa-angle-up');
                },
                function () {
                    $(this).find('.angle-icon').removeClass('fa-angle-up').addClass('fa-angle-down');
                }
            );

        });
    </script>
@endpush