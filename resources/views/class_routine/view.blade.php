@extends('layouts.default')
@section('pageTitle', $pageTitle)
@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="m-portlet view-page">
                <div class="m-portlet__head">
                    <div class="m-portlet__head-caption">
                        <div class="m-portlet__head-title">
                            <h3 class="m-portlet__head-text"><i class="fa fa-clock fa-md pr-2"></i>Class Routine Detail</h3>
                        </div>
                    </div>
                    <div class="m-portlet__head-tools">
                        <a href="{{ route('class_routine.index') }}" class="btn btn-primary m-btn m-btn--icon" title="Applicants"><i class="fa fa-clock"></i> Class Routines</a>
                    </div>
                </div>

                <div class="m-portlet__body">
                    <div class="m-section__content">

                        <div class="card">
                            <div class="card-header">
                                Common Information
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                                        <div class="card">
                                            <ul class="list-group list-group-flush">
                                                <li class="list-group-item">
                                                    <div class="row">
                                                        <div class="col-md-4">Session :</div>
                                                        <div class="col-md-8">{{$classRoutine->session->title}}</div>
                                                    </div>
                                                </li>
                                                <li class="list-group-item">
                                                    <div class="row">
                                                        <div class="col-md-4">Phase :</div>
                                                        <div class="col-md-8">{{$classRoutine->phase->title}}</div>
                                                    </div>
                                                </li>
                                                <li class="list-group-item">
                                                    <div class="row">
                                                        <div class="col-md-4">Term :</div>
                                                        <div class="col-md-8">{{!empty($classRoutine->term) ? $classRoutine->term->title : '--'}}</div>
                                                    </div>
                                                </li>
                                                <li class="list-group-item">
                                                    <div class="row">
                                                        <div class="col-md-4">Start Date :</div>
                                                        <div class="col-md-8">{{date('d M, Y', strtotime($min_max_date->min_date))}}</div>
                                                    </div>
                                                </li>

                                            </ul>
                                        </div>
                                    </div>
                                    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                                        <div class="card">
                                            <ul class="list-group list-group-flush">
                                                <li class="list-group-item">
                                                    <div class="row">
                                                        <div class="col-md-4">Class Type :</div>
                                                        <div class="col-md-8">{{$classRoutine->classType->title}}</div>
                                                    </div>
                                                </li>
                                                <li class="list-group-item">
                                                    <div class="row">
                                                        <div class="col-md-4">Subject :</div>
                                                        <div class="col-md-8">{{$classRoutine->subject->title}}</div>
                                                    </div>
                                                </li>
                                                <li class="list-group-item">
                                                    <div class="row">
                                                        <div class="col-md-4">{{count(groupDatesByDay($classDates)) > 1 ? 'Days' : 'Day'}} :</div>
                                                        <div class="col-md-8">
                                                            {{implode(', ', groupDatesByDay($classDates))}}
                                                        </div>
                                                    </div>
                                                </li>
                                                <li class="list-group-item">
                                                    <div class="row">
                                                        <div class="col-md-4">End Date :</div>
                                                        <div class="col-md-8">{{date('d M, Y', strtotime($min_max_date->max_date))}}</div>
                                                    </div>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="card mt-3">
                            <div class="card-header">
                                All Classes
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
                                        <div class="">
                                            <div class="table m-table table-responsive">
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
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        // Single flexible button handler - allows user to select any status
        $(document).on('click', '.change-status-btn', function () {
            const remarks = $(this).data('remarks') || '';
            const classId = $(this).data('id');
            const currentStatus = parseInt($(this).data('status'));
            const canSuspend = $(this).data('can-suspend') == true;

            showStatusSelector(classId, currentStatus, canSuspend, remarks);
        });

        // Show modal with status selector
        function showStatusSelector(classId, currentStatus, canSuspend, remarks) {
            const inActiveSelected = currentStatus === 0 ? 'selected' : '';
            const activeSelected = currentStatus === 1 ? 'selected' : '';
            const suspendedSelected = currentStatus === 2 ? 'selected' : '';
            const suspendedDisabledAttr = canSuspend ? '' : 'disabled title="Requires Subject Teacher / HOD / Super Admin permission"';

            // Build status options based on permissions
            let statusOptions = `
                <option ${activeSelected} value="1">🟢 Active</option>
                <option ${inActiveSelected} value="0">🔴 Inactive</option>
                <option ${suspendedSelected} value="2" ${suspendedDisabledAttr}>🟠 Suspended</option>
            `;

            Swal.fire({
                title: 'Change Class Status',
                html: `
                    <div class="form-group text-left">
                        <label for="statusSelect" class="font-weight-bold">Select New Status:</label>
                        <select id="statusSelect" class="form-control" style="font-size: 14px;">
                            ${statusOptions}
                        </select>
                        <!-- If suspended is disabled, show helper text explaining why -->
                        ${canSuspend ? '' : '<small class="text-warning d-block my-1">Suspended is disabled: only ' +
                    'Attendance was not taken & who Subject Teacher, HOD or Super Admin can suspend a class.</small>'}

                        <label for="remarks" class="font-weight-bold mt-3">Remarks:</label>
                        <small class="text-muted d-block mb-2">Required for Inactive and Suspended. Max 500 characters.</small>
                        <textarea id="remarks" class="form-control" rows="4" placeholder="Enter reason..
                        .">${remarks}</textarea>
                    </div>
                `,
                icon: 'info',
                showCancelButton: true,
                confirmButtonText: 'Update Status',
                cancelButtonText: 'Cancel',
                preConfirm: function () {
                    const status = document.getElementById('statusSelect').value;
                    const remarks = document.getElementById('remarks').value;

                    // Validate status selection
                    if (!status) {
                        Swal.showValidationMessage('Please select a status');
                        return false;
                    }

                    // Validate remarks for inactive (0) and suspended (2)
                    if ((status == 0 || status == 2)) {
                        if (!remarks.trim()) {
                            Swal.showValidationMessage('Remarks are required for this status');
                            return false;
                        }
                        if (remarks.length > 500) {
                            Swal.showValidationMessage('Remarks must not exceed 500 characters');
                            return false;
                        }
                    }

                    return {status: status, remarks: remarks};
                },
                didOpen: function () {
                    document.getElementById('statusSelect').focus();
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    submitStatusChange(classId, result.value.status, result.value.remarks);
                }
            });
        }

        // Submit status change to server
        function submitStatusChange(classId, status, remarks) {
            const data = {
                _token: $('meta[name="csrf-token"]').attr('content'),
                id: classId,
                status: status,
                remarks: remarks
            };


            $.ajax({
                url: "{{route('class_routine.toggleStatus')}}",
                method: 'PATCH',
                data: data,
                success: function (response) {
                    if (response.success) {
                        toastr.success(response.message);
                        $('#dataTable').DataTable().ajax.reload();
                    } else {
                        toastr.error(response.message);
                    }
                },
                error: function (xhr) {
                    if (xhr.status === 422 || xhr.status === 403) {
                        const errors = xhr.responseJSON;
                        toastr.error(errors.message);
                    } else {
                        toastr.error('An error occurred. Please try again.');
                    }
                }
            });
        }
    </script>
@endpush
