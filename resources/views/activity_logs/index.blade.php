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
                                <div class="col-xs-12 col-sm-6 col-md-3 col-lg-3 col-xl-3">
                                    <div class="form-group">
                                        <select class="form-control m-bootstrap-select m_selectpicker" name="causer_id"
                                                id="causer_id" data-live-search="true">
                                            <option value="">---- Select User ----</option>
                                            {!! select($users, app()->request->input('causer_id')) !!}
                                        </select>
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-6 col-md-3 col-lg-3 col-xl-3">
                                    <div class="form-group">
                                        <select class="form-control" name="subject_type" id="subject_type">
                                            <option value="">---- Select Subject Type ----</option>
                                            {!! select($subjectType, app()->request->input('subject_type')) !!}
                                        </select>
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-6 col-md-3 col-lg-3 col-xl-3">
                                    <div class="form-group">
                                        <input type="text" class="form-control m-input m_datepicker" name="date_from" value="{{app()->request->date_from}}" id="date_from" placeholder="Date From" autocomplete="off">
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-6 col-md-3 col-lg-3 col-xl-3">
                                    <div class="form-group">
                                        <input type="text" class="form-control m-input m_datepicker" name="date_to" value="{{app()->request->date_to}}" id="date_to" placeholder="Date to" autocomplete="off">
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
                                        <table class="table table-bordered table-hover" id="activity-logs-data-table">
                                            <thead>
                                            <tr>
                                                <th>Log ID</th>
                                                <th>User/Done by</th>
                                                <th>Target & Action Type</th>
                                                <th>Fields or Changes (field: old > new)</th>
                                                <th>Action Time</th>
{{--                                                <th>Action</th>--}}
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

            var dataTable = $('#activity-logs-data-table').DataTable({
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
                    url: '{{ url($url . "/data") }}',
                    data: function (e) {
                        var fields = $('#searchForm').serializeArray();
                        $.each( fields, function( i, field ) {
                            e[field.name] = field.value;
                        });
                    },
                },
                columns: [
                    {data: 'id', name: 'id'},
                    {data: 'user', name: 'user'},
                    {data: 'target', name: 'target'},
                    {data: 'changes', name: 'changes'},
                    {data: 'date', name: 'date'},
                    // {data: 'action', name: 'action', orderable: false}
                ],
                // columnDefs:[
                //     {className:'text-center', targets: -1}
                // ]
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
            $(".m_datepicker").datepicker({
                todayHighlight: !0,
                orientation: "bottom left",
                format: 'dd/mm/yyyy',
                autoclose: true,
            });
        });
    </script>
@endpush
