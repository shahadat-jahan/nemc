<div class="modal fade" id="resultPublishModal" role="dialog">
    <div class="modal-dialog" role="document">
        <form class="m-form m-form--fit m-form--label-align-right form-validation"  action="{{ route('result.publish') }}" method="post">
            @csrf
            <input type="hidden" name="exam_id" id="exam-id">
            <input type="hidden" name="subject_id" id="subject-id">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Publish Exam Result</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body pt-2">
                    <div class="row">
                        <div class="col-12">
                            <div class="form-group m-form__group">
                                <label class="form-control-label"><span class="text-danger">*</span> Select Publish Status </label>
                                <select class="form-control" name="result_published">
                                    <option value="1">Publish Result</option>
                                </select>
                            </div>
                                <small class="text-danger">Once published, result is no longer editable.</small>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-brand" data-dismiss="modal"><i class="fa fa-times"></i> Close</button>
                    <button type="submit" class="btn btn-success"><i class="fa fa-save"></i> Save</button>
                </div>
            </div>
        </form>
    </div>
</div>


@push('scripts')
    <script>
        //receive user id when click on message icon in list page
        $(document).on('click', '.modal-exam-result-publish', function (e) {
            e.preventDefault();
            examId = $(this).data('exam-id');
            subjectId = $(this).data('subject-id');

            $('#exam-id').val(examId);
            $('#subject-id').val(subjectId);
            $('#resultPublishModal').modal('show');

        });

        //modal form validation


        $(".form-validation").validate({
            rules: {
                subject: {
                    required: true
                    //minlength: 5,
                    //maxlength: 10,
                    //email: true
                    //startWithA: true
                },
                message: {
                    required: true
                },
                attachment: {
                    extension: "jpg|jpeg|gif|png|pdf|doc|xls",
                    filesize: 2,
                },
            },
            // Custom message for error
            messages: {
                subject: {
                    required: "The subject field is require",
                },
                message: {
                    required: "The message field is require",
                },
                attachment: {
                    extension: "Invalid file format",
                }
            },
            /*highlight: function(element, errorClass) {
                $(element).closest(".form-group").addClass("has-danger");
            },
            unhighlight: function(element, errorClass) {
                $(element).closest(".form-group").removeClass("has-danger");
            },*/
            /*errorPlacement: function (error, element) {
                error.appendTo(element.parent().next());
            }*/

        });
         $(".summernote").summernote({height:150})
    </script>
@endpush
