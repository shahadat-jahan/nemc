@extends('frontend.layouts.default')
@section('pageTitle', $pageTitle)

@push('style')
    <style>
        .m-stack--demo.m-stack--ver .m-stack__item, .m-stack--demo.m-stack--hor .m-stack__demo-item{
            padding: 29px;
        }
        .table thead th{
            vertical-align: top;
            text-align: center;
        }
        .table td {
            padding-top: 0.6rem !important;
            padding-bottom: .6rem !important;
            vertical-align: top;
            border-top: 1px solid #f4f5f8;
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
                        <form id="searchForm" role="form" method="get">
                            <div class="row">
                                <div class="col-xs-12 col-sm-6 col-md-4 col-lg-4 col-xl-4">
                                    <div class="form-group">
                                        <select class="form-control" name="session_id" id="session_id">
                                            <option value="">---- Select Session ----</option>
                                            {!! select($sessions, app()->request->session_id) !!}
                                        </select>
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-6 col-md-4 col-lg-4 col-xl-4">
                                    <div class="form-group">
                                        <select class="form-control" name="course_id" id="course_id">
                                            <option value="">---- Select Course ----</option>
                                            {!! select($courses, app()->request->course_id) !!}
                                        </select>
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-6 col-md-4 col-lg-4 col-xl-4">
                                    <div class="form-group">
                                        <select class="form-control" name="phase_id" id="phase_id">
                                            <option value="">---- Select Phase ----</option>
                                            {!! select($phases, app()->request->phase_id) !!}
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row mt-4">
                                <div class="col-xs-12 col-sm-6 col-md-12 col-lg-12 col-xl-12">
                                    <div class="pull-right search-action-btn">
                                        @if(!empty($examResults) && $examResults->isNotEmpty())
                                            <a href="{{route('report.exam_result.phase.excel', [
                                        'session_id' => app()->request->session_id,
                                        'course_id' => app()->request->course_id,
                                        'phase_id' => app()->request->phase_id,
                                    ])}}" class="btn btn-primary m-btn m-btn--icon"><i class="fa fa-file-export"></i> Export</a>
                                        @endif
                                        <button class="btn btn-primary m-btn m-btn--icon search-result"><i class="fa fa-search"></i> Search</button>
                                        <button type="reset" class="btn btn-default reset"><i class="fas fa-sync-alt search-reset"></i> Reset</button>
                                    </div>
                                </div>
                            </div>
                        </form>

                    </div>

                    @if(!empty($examResults))

                    <div class="row mt-4">
                        <div class="table m-table table-responsive">
                            <table class="table table-bordered table-hover sticky-header" id="exam-results">
                                <thead>
                                <tr>
                                    <th rowspan="2">Roll No</th>
                                    <th rowspan="2">Name</th>
                                    @foreach($examSubjects as $subject)
                                        <th colspan="{{count($exams)}}">{{$subject->subjectGroup->title}}</th>
                                    @endforeach
                                    <th rowspan="2">Remark</th>
                                </tr>
                                <tr>
                                    @foreach($examSubjects as $subject)
                                        @foreach($exams as $exam)
                                        <th>{{$exam->title}}</th>
                                        @endforeach
                                    @endforeach
                                </tr>

                                </thead>
                                <tbody>
                                @if(!empty($examResults) && $examResults->isNotEmpty())
                                    @foreach($examResults->groupBy('student_id') as $studentId => $studentResult)
                                        <?php $studentExamStatus = $studentResult->first()->pass_status; ?>
                                        <?php $remark = $studentResult->first()->remark; ?>
                                        <tr>
                                            <td>{{$studentResult->first()->student->roll_no}}</td>
                                            <td>{{$studentResult->first()->student->full_name_en}}</td>
                                            @foreach($studentResult->groupBy('subject_id') as $subjectId => $examSubject)
                                                @foreach($examSubject as $exam)
                                                    <td>{{$exam->total}}</td>
                                                @endforeach
                                            @endforeach
                                            <td>
                                                <div>
                                                    @php $fail = $studentResult->where('result_status', 'Fail')->count(); @endphp
                                                    <p>{{$fail == 0 ? 'Pass' : 'Fail'}}</p>
                                                </div>
                                            </td>
                                        </tr>

                                    @endforeach
                                @else
                                    <tr>
                                        <td colspan="3" class="text-center"><p class="mb-1">No data found</p></td>
                                    </tr>
                                @endif
                                </tbody>
                            </table>
                        </div>
                    </div>
                    @endif

                </div>

            </div>
        </div>
    </div>

@endsection

@push('scripts')
    <script>
        $('.search-result').click(function () {
            valid = true;
            $('#searchForm select').each(function () {
                if (($(this).val() == '')){
                    valid = false;
                }
            });

            if(valid == false){
                sweetAlert('All fields are required to search', 'error');
                return false;
            }else{
                $('#searchForm').submit();
            }
        });
    </script>
@endpush
