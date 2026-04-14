<div class="modal fade" id="editRequestModal" role="dialog"
     aria-labelledby="editRequestLabel">
    <div class="modal-dialog" role="document">
        <form class="m-form m-form--fit " id="edit-request-form" method="POST"
              enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="exam_id" id="request_exam_id">
            <input type="hidden" name="subject_id" id="request_subject_id">

            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Result edit request</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group m-form__group">
                        <label class="form-control-label" for="proof-file"><span class="text-danger">*</span> Select
                            file (PDF, JPG, JPEG, PNG)</label>
                        <input type="file" name="proof_file" id="proof-file" class="form-control"
                               accept=".pdf,.jpg,.jpeg,.png" required>
                        <small class="alert-info">Max size: 300kb</small>
                    </div>
                    {{--No need now--}}
                    {{--                    <div class="form-group m-form__group">--}}
                    {{--                        <label class="form-control-label" for="note">Note</label>--}}
                    {{--                        <textarea name="note" id="note" class="form-control" rows="3"></textarea>--}}
                    {{--                    </div>--}}
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-outline-brand" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-success">Submit</button>
                </div>
            </div>
        </form>
    </div>
</div>
