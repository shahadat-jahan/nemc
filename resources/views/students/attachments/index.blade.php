@extends('layouts.default')
@section('pageTitle', 'Attachments')

@push('style')
    <link href="{{asset('assets/global/plugins/datatables/datatables.bundle.css')}}" rel="stylesheet"
          type="text/css"/>

    <style>
        .remove-attachment{
            color: red;
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
                    <div class="m-portlet__head-tools">
                        @if (hasPermission('attachment/create'))
                            <a href="{{ route('students.attachment.form', [$student->id]) }}" class="btn btn-primary m-btn m-btn--icon" title="Add New Attachment"><i class="fa fa-plus"></i> New Attachment</a>
                        @endif
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
@endsection

@push('scripts')
    <script src="{{asset('assets/global/plugins/datatables/datatables.bundle.js')}}" type="text/javascript"></script>
    <script>
        $(function() {

            var baseUrl = '{!! url('/') !!}/';

            var columns = eval('{!! json_encode($columns) !!}');

            var dataTable = $('#dataTable').DataTable({
                /*dom: "<'row'<'col-sm-12 col-md-6'l><'col-sm-12 col-md-6'f>>" +
                    "<'row'<'col-sm-12'tr>>" +
                    "<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>",*/
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

            $('body').on('click', '.remove-attachment', function(e){
                e.preventDefault();
                current = $(this);
                attachmentId = $(this).data('attachment-id');
                studentId = $(this).data('student-id');
                Swal.fire({
                    title: 'Are you sure?',
                    text: "Do you want delete",
                    type: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Yes'
                }).then((result) => {
                    if (result.value) {
                        // current.parents('tr').remove();
                        $.get(baseUrl+'admin/students/'+studentId+'/attachment/delete/'+attachmentId, {}, function (response) {
                            if (response.status){
                                toastr["success"](response.message, "Success")
                                dataTable.draw();
                            }

                        })

                    }else if (result.dismiss === Swal.DismissReason.cancel){
                        return false;
                    }
                })
            });

        });
    </script>
@endpush
