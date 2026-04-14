<div class="modal fade" id="bulkPaymentModal" role="dialog">
    <div class="modal-dialog" role="document">
        <form class="m-form m-form--fit m-form--label-align-right" action="{{ route('bulk.payment.save') }}"
              method="post" enctype="multipart/form-data" id="bulkPaymentForm">
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Bulk Payment Collect </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body pt-2">
                    <div class="row">
                        <div class="col">
                            <div class="form-group m-form__group">
                                <label for="applicants_file" class="form-control-label">
                                    <span class="text-danger">*</span> Upload File
                                </label>
                                <input type="file" class="form-control-file" name="payment_file" id="payment_file"
                                       accept=".xls,.xlsx,application/vnd.ms-excel,application/vnd.openxmlformats-officedocument.spreadsheetml.sheet"
                                       required>
                                <span class="form-text text-muted">
                                    Max file size: 1 MB.
                                </span>
                                <div class="alert alert-info mt-2" role="alert">
                                    <strong>Important:</strong> The uploaded Excel file must contain valid data.<br>
                                    - <strong>User ID</strong> must be a valid, existing user ID and cannot be null.<br>
                                    - <strong>Payment date</strong> is required and must be in a valid date format
                                    "dd/mm/YYYY".
                                </div>

                            </div>
                            <a href="javascript:void(0)"
                               class="btn btn-primary m-btn m-btn--icon" id="sample-download-btn">
                                <i class="fa fa-download"></i> Download Sample
                            </a>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-brand" data-dismiss="modal">
                        <i class="fa fa-times"></i> Close
                    </button>
                    <button type="submit" class="btn btn-success">
                        <i class="fa fa-save"></i> Save
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

@push('scripts')
    <script>
        $(document).on('click', '#sample-download-btn', function (e) {
            const timestamp = new Date().getTime();
            window.location.href = '/sample_files/bulk_payment_sample.xlsx?v=' + timestamp;
        });

        $(document).on('click', '#bulk-payment', function (e) {
            e.preventDefault();
            $('#bulkPaymentModal').modal('show');
        });

        $.validator.addMethod('filesize', function (value, element, param) {
            if (element.files.length > 0) {
                const fileSize = (element.files[0].size / 1024) / 1024; // Convert to MB
                return this.optional(element) || (fileSize <= param);
            } else {
                return true;
            }
        }, 'File size must be less than {0} MB');

        $("#bulkPaymentForm").validate({
            rules: {
                payment_file: {
                    required: true,
                    extension: "xls|xlsx",
                    filesize: 1 // MB
                },
            },
            messages: {
                payment_file: {
                    required: "The payment file is required.",
                    extension: "Invalid file format. Only .xlsx and .xls are allowed.",
                }
            },
        });

        // Add this to the existing script section in bulkPaymentModal.blade.php
        $("#bulkPaymentForm").submit(function (e) {
            e.preventDefault();

            // Create FormData object to handle file upload
            var formData = new FormData(this);

            // Show loading indicator
            mApp.blockPage({
                overlayColor: "#000000",
                type: "loader",
                state: "primary",
                message: "Processing..."
            });

            $.ajax({
                url: $(this).attr('action'),
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                success: function (response) {
                    mApp.unblockPage();
                    $('#bulkPaymentModal').modal('hide');

                    // Display SweetAlert notification
                    sweetAlert(response.message, response.status);

                    // // Redirect after alert is closed
                    // setTimeout(function () {
                    //     window.location.href = response.redirect;
                    // }, 1500);
                },
                error: function (xhr) {
                    mApp.unblockPage();

                    var errorMessage = 'Something went wrong';
                    if (xhr.responseJSON && xhr.responseJSON.message) {
                        errorMessage = xhr.responseJSON.message;
                    }

                    sweetAlert(errorMessage, 'error');
                }
            });
        });
    </script>
@endpush
