@extends('layouts.default')
@section('pageTitle', $pageTitle)

@push('style')
    <link href="{{asset('assets/global/plugins/datatables/datatables.bundle.css')}}" rel="stylesheet"
          type="text/css"/>
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
                                        <input type="text" class="form-control" name="name" placeholder="Name">
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-6 col-md-4 col-lg-4 col-xl-4">
                                    <div class="form-group">
                                        <select class="form-control" name="session_id" id="session_id">
                                            <option value="">---- Select Session ----</option>
                                            {!! select($sessions, app()->request->input('session_id')) !!}
                                        </select>
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-6 col-md-4 col-lg-4 col-xl-4">
                                    <div class="form-group">
                                        <select class="form-control" name="course_id" id="course_id">
                                            <option value="">---- Select Course ----</option>
                                            {!! select($courses, Auth::user()->teacher->course_id ?? app()->request->input('course_id')) !!}
                                        </select>
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-6 col-md-4 col-lg-4 col-xl-4">
                                    <div class="form-group">
                                        <input type="text" class="form-control" name="phone" placeholder="Phone">
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-6 col-md-4 col-lg-4 col-xl-4">
                                    <div class="form-group">
                                        <select class="form-control m-bootstrap-select m_selectpicker" name="student_id" id="student_id" data-live-search="true">
                                            <option value="">---- Select Student ----</option>
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
                    </form><br>

                    <div class="m-section__content">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="">
                                    <div class="table m-table table-responsive">
                                        <table class="table table-bordered table-hover" id="dataTable">
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
    <!-- Include message modal-->
    @include('common.messageModal')

@endsection

@push('scripts')
    <script src="{{asset('assets/global/plugins/datatables/datatables.bundle.js')}}" type="text/javascript"></script>

    <script>
        $(document).ready(function() {

            function makeStudentIdAndUserId(sessionId, courseId){
                studentId = '{{app()->request->input('student_id')}}';

                if (courseId > 0 && sessionId > 0){
                    $.get('{{route('student.info.session.course')}}', {courseId: courseId, sessionId: sessionId, _token: "{{ csrf_token() }}"}, function (response) {
                        for (var i = 0; i < response.length; i++) {
                            selected = (studentId == response[i].id) ? 'selected' : '';
                            $("#student_id").append('<option value="' + response[i].id + '" '+ selected +'>' + response[i].full_name_en + '</option>');
                        }
                        $('.m_selectpicker').selectpicker('refresh');
                    });
                }
            }

            $('#session_id').change(function (e) {
                e.preventDefault();
                sessionId = $(this).val();
                courseId = $('#course_id').val();
                makeStudentIdAndUserId(sessionId, courseId);
            });

            $('#course_id').change(function (e) {
                e.preventDefault();
                courseId = $(this).val();
                sessionId = $('#session_id').val();
                makeStudentIdAndUserId(sessionId, courseId);
            });

            var sessionId = '{{app()->request->input('session_id')}}';
            var courseId = '{{app()->request->input('course_id')}}';
            if (sessionId > 0 && courseId > 0){
                makeStudentIdAndUserId(sessionId, courseId);
            }

            var columns = eval('{!! json_encode($columns) !!}');

            var dataTable = $('#dataTable').DataTable({
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

            $('.reset').click(function (e) {
                e.preventDefault();
                $('#searchForm').trigger("reset");
                dataTable.draw();
            });

        });
    </script>
@endpush
