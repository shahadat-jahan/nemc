@extends('frontend.layouts.default')
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
    @include('frontend.common.messageModal')

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
