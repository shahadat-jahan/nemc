@extends('layouts.default')
@section('pageTitle', $pageTitle)

@push('style')
    <style>
        .applicant-delete {
            color: red;
        }
        #dataTable_wrapper tbody tr td:last-child{
            width: 7rem !important;
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
                        @if (hasPermission('admission/create'))
                            <button class="btn btn-primary m-btn m-btn--icon mr-2" id="upload-applicants"
                                    title="Upload Applicants"><i
                                    class="fa fa-upload"></i> Upload Applicants
                            </button>
                        <a href="{{ route('admission.create') }}" class="btn btn-primary m-btn m-btn--icon" title="Add New Applicant"><i class="fa fa-plus"></i> Add Applicant</a>
                        @endif
                    </div>
                </div>

                <div class="m-portlet__body">
                    <form id="searchForm" role="form" method="post">
                        <div class="form-body">
                            <div class="row">
                                <div class="col-xs-12 col-sm-6 col-md-3 col-lg-3 col-xl-3">
                                    <div class="form-group">
                                        <select class="form-control" name="session_id">
                                            <option value="">---- Select Session ----</option>
                                            {!! select($sessions) !!}
                                        </select>
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-6 col-md-3 col-lg-3 col-xl-3">
                                    <div class="form-group">
                                        <select class="form-control" name="course_id">
                                            <option value="">---- Select Course ----</option>
                                            {!! select($courses, Auth::user()->teacher->course_id ?? '') !!}
                                        </select>
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-6 col-md-3 col-lg-3 col-xl-3">
                                    <div class="form-group">
                                        <select class="form-control" name="student_category_id">
                                            <option value="">---- Select Category ----</option>
                                            {!! select($studentCategories) !!}

                                        </select>
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-6 col-md-3 col-lg-3 col-xl-3">
                                    <div class="form-group">
                                        <select class="form-control" name="status">
                                            <option value="">---- Select Status ----</option>
                                            {!! select($admissionStatus) !!}
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-xs-12 col-sm-6 col-md-3 col-lg-3 col-xl-3">
                                    <div class="form-group">
                                        <input type="text" class="form-control m-input" name="full_name_en" placeholder="Full Name"/>
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-6 col-md-3 col-lg-3 col-xl-3">
                                    <div class="form-group">
                                        <input type="text" class="form-control m-input" name="admission_roll_no" placeholder="Admission Roll No"/>
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-6 col-md-3 col-lg-3 col-xl-3">
                                    <div class="form-group">
                                        <input type="email" class="form-control m-input" name="email" placeholder="Email"/>
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-6 col-md-3 col-lg-3 col-xl-3">
                                    <div class="form-group">
                                        <input type="text" class="form-control m-input" name="phone_mobile" placeholder="Phone"/>
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
                                    <div class="table m-table table-responsive" id="admission-data">
                                        @include('common/datatable')
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal -->
    {{--<div class="modal fade" id="changeStatusModal" role="dialog">--}}
        <div class="modal fade" id="changeStatusModal" tabindex="-1" role="dialog" aria-labelledby="editStudentAttendanceLabel" aria-hidden="true">

        <div class="modal-dialog" role="document">
            <form class="m-form m-form--fit m-form--label-align-right form-validation">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Update Applicant Status</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body pt-2">
                        <div class="row">
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
                                <input type="hidden" name="id" id="applicant-id">
                                <div class="form-group  m-form__group">
                                    <label class="form-control-label"><span class="text-danger">*</span> Select Status </label>
                                    <select class="form-control m-input" name="status" id="applicant-status" required>
                                        <option value="1">Pending</option>
                                        <option value="2">Waiting List</option>
                                        <option value="3">Selected for admission</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-brand" data-dismiss="modal"><i class="fa fa-times"></i> Close</button>
                        <button type="button" class="btn btn-success" id="update-status-btn"><i class="fa fa-save"></i> Save</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    @include('common.applicantsUploadModal')
@endsection

@push('scripts')
    <script src="{{asset('assets/global/plugins/datatables/datatables.bundle.js')}}" type="text/javascript"></script>
    <script>
        $('body').on('click', '.applicant-delete', function (e) {
            e.preventDefault();
            var id = $(this).data('applicant-id');
            var url = baseUrl + 'admin/admission/' + id;

            Swal.fire({
                title: 'Are you sure?',
                text: "Do you want to delete this applicant?",
                type: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.value) {
                    $.ajax({
                        url: url,
                        type: 'DELETE',
                        data: {
                            _token: $('meta[name="csrf-token"]').attr('content')
                        },
                        success: function (response) {
                            if (response.status === 'success') {
                                toastr.success(response.message, "Success");
                                location.reload();
                            } else {
                                toastr.error(response.message, "Error");
                            }
                        },
                        error: function (xhr) {
                            toastr.error(xhr.responseJSON.message, "Error");
                        }
                    });

                } else if (result.dismiss === Swal.DismissReason.cancel) {
                    return false;
                }
            });
        });


        $(".form-validation").validate({
            rules: {
                status: {
                    required: true,
                    min:1,
                },
            },
            // Custom message for error
            messages: {
                status: {
                    required: "The Status field is require",
                },
            },

        });

        //receive user id and status when click on message icon in list page
        $('#admission-data').on('click', '.status-update',function (e) {
            $('#applicant-id').val($(this).data('applicant-id'));
            $('#applicant-status').val($(this).data('applicant-status'));
            $('#changeStatusModal').modal('show');
        });


        $('#update-status-btn').click(function (e) {
            e.preventDefault();
            //receive value when click on submit button
            var applicantId = $('#applicant-id').val();
            var applicantStatus = $('#applicant-status').val();

            $.ajax({
                type: 'PUT',
                //go to this url and update data in controller
                url: baseUrl+ 'admin/admission/admission_applicant_update/'+applicantId,
                data: {status: applicantStatus, _token: "{{ csrf_token() }}",},
                success: function(response) {
                    if (response.status){
                        $('#changeStatusModal').modal('hide');
                        location.reload();
                    }
                }
            });
        })
    </script>
@endpush
