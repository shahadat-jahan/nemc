@extends('layouts.default')
@section('pageTitle', $pageTitle)

@push('style')
    <link href="{{asset('assets/global/plugins/datatables/datatables.bundle.css')}}" rel="stylesheet"
          type="text/css"/>
    <style>
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
                    <form id="searchForm" role="form" method="post">
                        <div class="form-body">
                            <div class="row">
                                <div class="col-xs-12 col-sm-6 col-md-4 col-lg-4 col-xl-4">
                                    <div class="form-group">
                                        <select class="form-control" name="session_id" id="session_id">
                                            <option value="">---- Select Session ----</option>
                                            {!! select($sessions) !!}
                                        </select>
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-6 col-md-4 col-lg-4 col-xl-4">
                                    <div class="form-group">
                                        <select class="form-control" name="course_id" id="course_id">
                                            <option value="">---- Select Course ----</option>
                                            {!! select($courses, Auth::user()->teacher->course_id ?? '') !!}
                                        </select>
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-6 col-md-4 col-lg-4 col-xl-4">
                                    <div class="form-group">
                                        <select class="form-control" name="phase_id" id="phase_id">
                                            <option value="">---- Select Phase ----</option>
                                            {!! select($phases) !!}
                                        </select>
                                    </div>
                                </div>
<!--                                <div class="col-xs-12 col-sm-6 col-md-4 col-lg-4 col-xl-4">
                                    <div class="form-group">
                                        <select class="form-control" name="term_id">
                                            <option value="">---- Select Term ----</option>
                                            {!! select($terms) !!}
                                        </select>
                                    </div>
                                </div>-->
                                <div class="col-xs-12 col-sm-6 col-md-4 col-lg-4 col-xl-4">
                                    <div class="form-group">
                                        <select class="form-control m-input" name="term_id" id="term_id">
                                           <option value="">---- Select Term ----</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-6 col-md-4 col-lg-4 col-xl-4">
                                    <div class="form-group">
                                        <select class="form-control m-input" name="subject_id" id="subject_id">
                                            <option value="">---- Select Subject ----</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-6 col-md-4 col-lg-4 col-xl-4">
                                    <div class="form-group">
                                        <select class="form-control m-input teacher_id" name="teacher_id">
                                            <option value="">---- Select Teacher ----</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-6 col-md-4 col-lg-4 col-xl-4">
                                    <div class="form-group">
                                        <select class="form-control m_selectpicker" data-live-search="true"
                                                name="class_type_id">
                                            <option value="">---- Select Class Types ----</option>
                                            {!! select($classTypes) !!}
                                        </select>
                                    </div>
                                </div>

                                <div class="col-xs-12 col-sm-6 col-md-4 col-lg-4 col-xl-4">
                                    <div class="form-group">
                                        <input type="number" class="form-control" name="roll_no" placeholder="Student Roll Number"/>
                                    </div>
                                </div>

                                <div class="col-xs-12 col-sm-6 col-md-4 col-lg-4 col-xl-4">
                                    <div class="form-group">
                                        <input type="text" class="form-control" name="full_name_en" placeholder="Student Name"/>
                                    </div>
                                </div>

                                <div class="col-xs-12 col-sm-6 col-md-4 col-lg-4 col-xl-4">
                                    <div class="form-group">
                                        <input type="text" class="form-control m-input m_datepicker_1" name="class_date" placeholder="Class Date" autocomplete="off"/>
                                    </div>
                                </div>

                                <div class="col-xs-12 col-sm-6 col-md-4 col-lg-4 col-xl-4">
                                    <div class="form-group">
                                        <select class="form-control" name="attendance">
                                            <option value="">---- Attendance ----</option>
                                            <option value="present">Present</option>
                                            <option value="absent">Absent</option>
                                        </select>
                                    </div>
                                </div>

                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="pull-right search-action-btn">
                                        <button class="btn btn-primary m-btn m-btn--icon"><i class="fa fa-search"></i> Search</button>
                                        <button type="reset" class="btn btn-default reset"><i class="fas fa-sync-alt search-reset"></i> Reset</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>

                    <div class="m-section__content">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="">
                                    <div class="table m-table table-responsive">
                                        <table class="table table-bordered table-hover" id="attendance-data">
                                            <thead>
                                            <tr>
                                                @foreach ($tableHeads as $key => $title)
                                                    <th class="uppercase"><?=$title;?></th>
                                                @endforeach
                                            </tr>
                                            </thead>
                                            <tbody>
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

    @include('attendance.edit_attendance_modal')

@endsection





@push('scripts')
    <script src="{{asset('assets/global/plugins/datatables/datatables.bundle.js')}}" type="text/javascript"></script>
    <script src="{{asset('assets/global/scripts/charts.js')}}"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/lodash.js/4.17.11/lodash.min.js" type="text/javascript"></script>
    <script>
        $(function() {

            var phaseInfo = [];
            var total_terms='';
            var selectedPhase='';

            $('#course_id, #session_id').change(function () {
                courseId = $('#course_id').val();
                sessionId = $('#session_id').val();
                $.get('{{route('phase.term.list')}}', {sessionId: sessionId, courseId: courseId}, function (response) {
                     if (response.data){
                         phaseInfo = response.data;
                         console.log(phaseInfo);
                     }
                })
            });

            $(".m_datepicker_1").datepicker( {
                todayHighlight: !0,
                orientation: "bottom left",
                format: 'dd/mm/yyyy',
                autoclose: true,
            });

            var columns = eval('{!! json_encode($columns) !!}');

            var dataTable = $('#attendance-data').DataTable({
                 dom: 'rt<"row"<"col-md-2 col-sm-12"l><"col-md-5 col-sm-12 text-center"i><"col-md-5 col-sm-12"p>>',
                language: {
                    search: "",
                    searchPlaceholder: "Search",
                },
                lengthMenu: [
                    [10, 20, 50, 100, 150, 200, -1],
                    [10, 20, 50, 100, 150, 200, "All"]
                ],
                pageLength: 10,
                pagingType: "full_numbers",
                order: [
                    [0, "desc"]
                ],
                processing: true,
                serverSide: true,
                ajax: {
                    url: '{{ url($dataUrl) }}',
                    data: function (e) {
                        var fields = $('#searchForm').serializeArray();
                        $.each( fields, function( i, field ) {
                            e[field.name] = field.value;
                        });
                    }
                },
                columns: columns
            });

            $('#searchForm').submit(function (e) {
                e.preventDefault();
                dataTable.draw();
            });

            //filter attendance
            $('#phase_id').change(function () {
                phaseId = $(this).val();
                courseId = $('#course_id').val();
                sessionId = $('#session_id').val();

                mApp.blockPage({
                    overlayColor: "#000000",
                    type: "loader",
                    state: "primary",
                    message: "Please wait..."
                });


                selectedPhase = _.find(phaseInfo, function(o) { return o.phase.id  == phaseId; });
                if (selectedPhase) {
                  console.log(`x === undefined`)
                  totalTerms=selectedPhase.total_terms;
                } else {
                  console.log(`x !== undefined`)
                  totalTerms=''
                }
                $('#term_id').html('<option value="">---- Select Term----</option>');
                for (var i = 1; i <= totalTerms; i++){
                    $('#term_id').append('<option value="'+i+'"> Term '+i+'</option>')
                }

                // load subjects
                $.get('{{route('subjects.session.course.phase')}}', {sessionId: sessionId, courseId: courseId, phaseId: phaseId}, function (response) {
                    if (response.data){
                        $('#subject_id').html('<option value="">---- Select Subject ----</option>');
                        for (i in response.data){
                            subject = response.data[i];
                            $('#subject_id').append('<option value="'+subject.id+'">'+subject.title+'</option>')
                        }

                    }
                    mApp.unblockPage();
                })
            });

            $('#subject_id').change(function(e){
                e.preventDefault();
                mApp.blockPage({
                    overlayColor: "#000000",
                    type: "loader",
                    state: "primary",
                    message: "Please wait..."
                });

                subjectId = $(this).val();

                $.get('{{route('teacher.list.subject')}}', {subjectId: subjectId}, function(response){
                    $(".teacher_id").html('<option value="">--Select Teacher--</option>');
                    if (response.data.length > 0){
                        for (i in response.data){
                            item = response.data[i];
                            $(".teacher_id").append('<option value="' + item.id + '">' + item.full_name + '</option>');
                        }
                    }
                    mApp.unblockPage();
                });

            });


            $('.reset').click(function (e) {
                e.preventDefault();
                $('#searchForm').trigger("reset");
                dataTable.draw();
            });

        });
    </script>
@endpush
