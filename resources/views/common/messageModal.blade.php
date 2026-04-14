<div class="modal fade" id="sendMessageUserModal" role="dialog">
    <div class="modal-dialog" role="document">
        <form class="m-form m-form--fit m-form--label-align-right form-validation"  action="{{ route('message.store') }}" method="post" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="user_id" id="user-id">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Send Message</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body pt-2">
                    <div class="row">
                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
                            <div class="form-group  m-form__group ">
                                <label class="form-control-label"><span class="text-danger">*</span> Subject </label>
                                <input type="text" class="form-control m-input" name="subject" placeholder="Message Subject">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
                            <div class="form-group  m-form__group ">
                                <label class="form-control-label"><span class="text-danger">*</span> Message</label>
                                <textarea class="form-control m-input summernote" name="message" placeholder="Your Message"></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
                            <div class="form-group  m-form__group ">
                                <label class="form-control-label">Share File </label>
                                <input type="file" class="form-control-file" name="attachment">
                            </div>
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
        $(document).on('click', '.send-message-user', function (e) {
            e.preventDefault();
            var value = $('#user-id').val($(this).data('message-to-user-id'))

            $('#sendMessageUserModal').modal('show');

        });

        //modal form validation
        $.validator.addMethod('filesize', function (value, element, param) {
            if (element.files.length > 0){
                var fileSize = (element.files[0].size / 1024) / 1024;
                return this.optional(element) || (fileSize <= param)
            }else{
                return true;
            }
        }, 'File size must be less than {0} MB');


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
         $(".summernote").summernote({
             height:250,
             toolbar: false
         })
    </script>
@endpush
