@extends('layouts.default')
@section('pageTitle', $pageTitle)

@push('style')
    <style>
        .m-stack--demo.m-stack--ver .m-stack__item, .m-stack--demo.m-stack--hor .m-stack__demo-item{
            padding: 29px;
        }
        .column-rotate{
            transform: rotate(270deg);
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
                        <h3 class="m-portlet__head-text"><i class="fas fa-list-ul fa-md pr-2"></i>{{$pageTitle}}</h3>
                    </div>
                </div>
            </div>

                <div class="m-portlet__body">
                    <div class="m-section__content">
                        <form id="searchForm" role="form" method="get" action="{{route('report.student.admission.type', 'all')}}">
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
                                            @if(isset($searchResult) && !empty($searchResult->toArray()))
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
                                                           href="{{ route('report.student.admission.print.type', array_merge(['all', 'session_id' => $sessionId, 'course_id' => $courseId], ['page_layout' => 'A4-landscape'])) }}"
                                                           target="_blank">
                                                            <i class="fas fa-arrows-alt-h"></i> Landscape
                                                        </a>
                                                        <a class="dropdown-item"
                                                           href="{{ route('report.student.admission.print.type', array_merge(['all', 'session_id' => $sessionId, 'course_id' => $courseId], ['page_layout' => 'A4-portrait'])) }}"
                                                           target="_blank">
                                                            <i class="fas fa-arrows-alt-v"></i> Portrait
                                                        </a>
                                                    </div>
                                                </div>
                                                <a class="btn btn-primary m-btn m-btn--icon" href="{{route('report.student.admission.excel.type', ['all', 'session_id' => $sessionId, 'course_id' => $courseId])}}" class="btn btn-brand m-btn m-btn--icon"><i class="fa fa-file-export"></i> Export</a>
                                            @endif
                                            <button class="btn btn-primary m-btn m-btn--icon"><i class="fa fa-search"></i> Search</button>
                                            <a href="{{route('report.student.admission.type', 'all')}}" class="btn btn-default reset"><i class="fas fa-sync-alt search-reset"></i> Reset</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                        <br>
                    </div>


                    <div class="m-section__content">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="">
                                    <div class="table m-table table-responsive">
                                        <table class="table table-bordered table-hover" id="dataTable">
                                            <thead>
                                            <tr style="box-sizing:border-box;">
                                                <th rowspan="2" style="border-bottom-width: 2px;vertical-align: bottom;border-bottom: 2px solid #dee2e6;border: 1px solid #f4f5f8;padding: .75rem;">SL#</th>
                                                <th rowspan="2" style="border-bottom-width: 2px;vertical-align: bottom;border-bottom: 2px solid #dee2e6;border: 1px solid #f4f5f8;padding: .75rem;"><div style="width: 150px">Name & parents name of the candidates</div></th>
                                                <th rowspan="2" style="border-bottom-width: 2px;vertical-align: bottom;border-bottom: 2px solid #dee2e6;border: 1px solid #f4f5f8;padding: .75rem;"><div style="width: 130px">Permanent Address</div></th>
                                                <th rowspan="2" style="border-bottom-width: 2px;vertical-align: bottom;border-bottom: 2px solid #dee2e6;border: 1px solid #f4f5f8;padding: .75rem;">Student Category</th>
                                                <th rowspan="2" style="border-bottom-width: 2px;vertical-align: bottom;border-bottom: 2px solid #dee2e6;border: 1px solid #f4f5f8;padding: .75rem;">Date of birth</th>
                                                <th rowspan="2" style="border-bottom-width: 2px;vertical-align: bottom;border-bottom: 2px solid #dee2e6;border: 1px solid #f4f5f8;padding: .75rem;">Nationality</th>
                                                <th rowspan="2" style="border-bottom-width: 2px;vertical-align: bottom;border-bottom: 2px solid #dee2e6;border: 1px solid #f4f5f8;padding: .75rem;">Class Roll</th>
                                                <th colspan="2" style="border-bottom-width: 2px;vertical-align: bottom;border-bottom: 2px solid #dee2e6;border: 1px solid #f4f5f8;padding: .75rem;">Name of Board Exam With Details</th>
                                                <th rowspan="2" style="border-bottom-width: 2px;vertical-align: bottom;border-bottom: 2px solid #dee2e6;border: 1px solid #f4f5f8;padding: .75rem;">SSC & HSC total GPA</th>
                                                <th rowspan="2" style="border-bottom-width: 2px;vertical-align: bottom;border-bottom: 2px solid #dee2e6;border: 1px solid #f4f5f8;padding: .75rem;">Total GPA converted to marks (15+25)</th>
                                                <th rowspan="2">MBBS/BNMC/BDS/Others Admission Details</th>
                                                <th rowspan="2" style="border-bottom-width: 2px;vertical-align: bottom;border-bottom: 2px solid #dee2e6;border: 1px solid #f4f5f8;padding: .75rem;">Form Fillup Date Date</th>
                                                <th rowspan="2">Action</th>
                                            </tr>
                                            <tr style="box-sizing:border-box;">
                                                <th style="border-bottom-width: 2px;vertical-align: bottom;border-bottom: 2px solid #dee2e6;border: 1px solid #f4f5f8;padding: .75rem;">SSC/EQ/Others</th>
                                                <th style="border-bottom-width: 2px;vertical-align: bottom;border-bottom: 2px solid #dee2e6;border: 1px solid #f4f5f8;padding: .75rem;">HSC/EQ/Others</th>
                                            </tr>
                                            @if(isset($searchResult))
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
                                            </tr>
                                            @endif
                                            </thead>
                                            <tbody>
                                            @if(isset($searchResult))
                                                @if(!empty($searchResult))
                                                    <?php $i = 1; ?>
                                                    @foreach($searchResult as $student)
                                                        <?php
                                                        $sscInfo = $student->educations->first();
                                                        $hscInfo = $student->educations->last();
                                                        ?>
                                                        <tr>
                                                            <td style="box-sizing:border-box;border-width:1px;border-style:solid;border-color:#f4f5f8;padding-top:.2rem !important;padding-bottom:.2rem !important;padding-right:.75rem;padding-left:.75rem;vertical-align:top;border-top-width:1px;border-top-style:solid;border-top-color:#f4f5f8;">{{$i}}</td>
                                                            <td style="box-sizing:border-box;border-width:1px;border-style:solid;border-color:#f4f5f8;padding-top:.2rem !important;padding-bottom:.2rem !important;padding-right:.75rem;padding-left:.75rem;vertical-align:top;border-top-width:1px;border-top-style:solid;border-top-color:#f4f5f8;">{!! '<b>Name: </b>' . $student->full_name_en . '<br><b>Father: </b>' . $student->parent->father_name.'<br><b>Mother: </b>' . $student->parent->mother_name !!}</td>
                                                            <td style="box-sizing:border-box;border-width:1px;border-style:solid;border-color:#f4f5f8;padding-top:.2rem !important;padding-bottom:.2rem !important;padding-right:.75rem;padding-left:.75rem;vertical-align:top;border-top-width:1px;border-top-style:solid;border-top-color:#f4f5f8;">{{$student->permanent_address}}</td>
                                                            <td style="box-sizing:border-box;border-width:1px;border-style:solid;border-color:#f4f5f8;padding-top:.2rem !important;padding-bottom:.2rem !important;padding-right:.75rem;padding-left:.75rem;vertical-align:top;border-top-width:1px;border-top-style:solid;border-top-color:#f4f5f8;">{{$student->studentCategory->title}}</td>
                                                            <td style="box-sizing:border-box;border-width:1px;border-style:solid;border-color:#f4f5f8;padding-top:.2rem !important;padding-bottom:.2rem !important;padding-right:.75rem;padding-left:.75rem;vertical-align:top;border-top-width:1px;border-top-style:solid;border-top-color:#f4f5f8;">{{$student->date_of_birth}}</td>
                                                            <td style="box-sizing:border-box;border-width:1px;border-style:solid;border-color:#f4f5f8;padding-top:.2rem !important;padding-bottom:.2rem !important;padding-right:.75rem;padding-left:.75rem;vertical-align:top;border-top-width:1px;border-top-style:solid;border-top-color:#f4f5f8;">{{$student->country->name}}</td>
                                                            <td style="box-sizing:border-box;border-width:1px;border-style:solid;border-color:#f4f5f8;padding-top:.2rem !important;padding-bottom:.2rem !important;padding-right:.75rem;padding-left:.75rem;vertical-align:top;border-top-width:1px;border-top-style:solid;border-top-color:#f4f5f8;">{{$student->roll_no}}</td>
                                                            <td style="box-sizing:border-box;border-width:1px;border-style:solid;border-color:#f4f5f8;padding-top:.2rem !important;padding-bottom:.2rem !important;padding-right:.75rem;padding-left:.75rem;vertical-align:top;border-top-width:1px;border-top-style:solid;border-top-color:#f4f5f8;">{!! 'Reg: ' . $sscInfo->reg . '<br>' . 'Result: ' . $sscInfo->gpa . '<br>' . 'Board: ' . $sscInfo->educationBoard->title . '<br>' . 'Year: ' . $sscInfo->pass_year !!}</td>
                                                            <td style="box-sizing:border-box;border-width:1px;border-style:solid;border-color:#f4f5f8;padding-top:.2rem !important;padding-bottom:.2rem !important;padding-right:.75rem;padding-left:.75rem;vertical-align:top;border-top-width:1px;border-top-style:solid;border-top-color:#f4f5f8;">{!! 'Reg: ' . $hscInfo->reg . '<br>' . 'Result: ' . $hscInfo->gpa . '<br>' . 'Board: ' . $hscInfo->educationBoard->title . '<br>' . 'Year: ' . $hscInfo->pass_year !!}</td>
                                                            <td style="box-sizing:border-box;border-width:1px;border-style:solid;border-color:#f4f5f8;padding-top:.2rem !important;padding-bottom:.2rem !important;padding-right:.75rem;padding-left:.75rem;vertical-align:top;border-top-width:1px;border-top-style:solid;border-top-color:#f4f5f8;">{{$sscInfo->gpa + $hscInfo->gpa}}</td>
                                                            <td style="box-sizing:border-box;border-width:1px;border-style:solid;border-color:#f4f5f8;padding-top:.2rem !important;padding-bottom:.2rem !important;padding-right:.75rem;padding-left:.75rem;vertical-align:top;border-top-width:1px;border-top-style:solid;border-top-color:#f4f5f8;">{{($sscInfo->gpa * 15) + ($hscInfo->gpa * 25)}}</td>
                                                            <td style="box-sizing:border-box;border-width:1px;border-style:solid;border-color:#f4f5f8;padding-top:.2rem !important;padding-bottom:.2rem !important;padding-right:.75rem;padding-left:.75rem;vertical-align:top;border-top-width:1px;border-top-style:solid;border-top-color:#f4f5f8;">{!! 'Test Roll: ' . $student->admission_roll_no . '<br>' . 'Test Score: ' . $student->test_score . '<br>' . 'Merit Score: ' . $student->merit_score . '<br>' . 'Position: ' . $student->merit_position . '<br>' . 'Other: ' . $student->remarks !!}</td>
                                                            <td style="box-sizing:border-box;border-width:1px;border-style:solid;border-color:#f4f5f8;padding-top:.2rem !important;padding-bottom:.2rem !important;padding-right:.75rem;padding-left:.75rem;vertical-align:top;border-top-width:1px;border-top-style:solid;border-top-color:#f4f5f8;">{{$student->form_fillup_date ? $student->form_fillup_date : '--'}}</td>
                                                            <td>
                                                                <a href="{{route('admission.student.single.report', $student->id)}}" class="m-portlet__nav-link btn m-btn m-btn--hover-brand m-btn--icon m-btn--icon-only m-btn--pill" title="View">
                                                                    <i class="flaticon-eye"></i>
                                                                </a>
                                                            </td>
                                                        </tr>
                                                        <?php $i++; ?>
                                                    @endforeach
                                                @else
                                                    <tr><td colspan="15" align="center">No data found</td></tr>
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
