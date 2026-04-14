<div class="modal fade" id="applicantsUploadModal" role="dialog">
    <div class="modal-dialog" role="document">
        <form class="m-form m-form--fit m-form--label-align-right" action="{{ route('admission.applicants.import') }}"
              method="post" enctype="multipart/form-data" id="applicantsUploadForm">
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Upload Applicants</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body pt-2">
                    <div class="row">
                        <div class="col">
                            <div class="form-group m-form__group">
                                <label for="session_id" class="form-control-label">
                                    <span class="text-danger">*</span> Session
                                </label>
                                <select class="form-control m_selectpicker" name="session_id" id="session_id" required>
                                    <option value="">---- Select Session ----</option>
                                    {!! select($sessions) !!}
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <div class="form-group m-form__group">
                                <label for="course_id" class="form-control-label">
                                    <span class="text-danger">*</span> Course
                                </label>
                                <select class="form-control m_selectpicker" name="course_id" id="course_id" required>
                                    <option value="">---- Select Course ----</option>
                                    {!! select($courses, Auth::user()->teacher->course_id ?? '') !!}
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <div class="form-group m-form__group">
                                <label for="applicants_file" class="form-control-label">
                                    <span class="text-danger">*</span> Upload File
                                </label>
                                <input type="file" class="form-control-file" name="applicants_file" id="applicants_file"
                                       accept=".xls,.xlsx,application/vnd.ms-excel,application/vnd.openxmlformats-officedocument.spreadsheetml.sheet"
                                       required>
                                <span class="form-text text-muted">
                                    Max file size: 1 MB.
                                </span>
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
            window.location.href = '/sample_files/applicants_sample.xlsx?v=' + timestamp;
        });

        $(document).on('click', '#upload-applicants', function (e) {
            e.preventDefault();
            $('#applicantsUploadModal').modal('show');
        });

        $.validator.addMethod('filesize', function (value, element, param) {
            if (element.files.length > 0) {
                const fileSize = (element.files[0].size / 1024) / 1024; // Convert to MB
                return this.optional(element) || (fileSize <= param);
            } else {
                return true;
            }
        }, 'File size must be less than {0} MB');

        $("#applicantsUploadForm").validate({
            rules: {
                session_id: {
                    required: true
                },
                course_id: {
                    required: true
                },
                applicants_file: {
                    required: true,
                    extension: "xlsx|xls",
                    filesize: 1 // File size in MB
                },
            },
            messages: {
                session_id: {
                    required: "The session field is required."
                },
                course_id: {
                    required: "The course field is required."
                },
                applicants_file: {
                    required: "The applicants file is required.",
                    extension: "Invalid file format. Only .xlsx and .xls are allowed.",
                }
            },
        });
    </script>
@endpush
