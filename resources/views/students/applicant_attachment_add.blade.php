@push('style')
    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/imgareaselect/0.9.10/css/imgareaselect-default.css">
@endpush

<ul id="image-errors"></ul>
<div class="row progress-row m--hide">
    <div class="col-sm-12">
        <span class="text-muted">Upload Process: </span>
        <span class="img-progress text-muted"></span>
    </div>
</div>
<div class="row pl-4 pr-4">
    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
                <div class="form-group  m-form__group {{ $errors->has('bds_development_fee_local') ? 'has-danger' : '' }}">
                    <label class="form-control-label"> Attachment type </label>
                    <select class="form-control m-input m-bootstrap-select m_selectpicker" name="attachment_type" id="attachment-type" data-live-search="true">
                        {!! select($attachmentTypes) !!}
                    </select>
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
                <div class="form-group  m-form__group {{ $errors->has('remarks') ? 'has-danger' : '' }}">
                    <label class="form-control-label"> Remark </label>
                    <textarea class="form-control m-input" name="remarks" rows="4" id="remarks" placeholder="Remark"></textarea>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
        <div class="form-group  m-form__group">
            <label class="form-control-label"><span class="text-danger">*</span> Drag n drop file or manually select a file </label>
            <div class="dropzone" id="attach-document"></div>
            <span class="m-form__help">accepted: doc, docx, pdf, jpeg, gif, png</span>
        </div>
    </div>
</div>
<div class="m-separator m-separator--dashed m-separator--lg"></div>
<div class="m-form__heading">
    <h3 class="m-form__heading-title">Attachments</h3>
</div>
<div class="row pl-4 pr-4">
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
        <div class="table-responsive">
            <table class="table table-bordered" id="attachment-table">
                <thead>
                <tr>
                    <th>Attachment Type</th>
                    <th>Remarks</th>
                    <th>Attachment</th>
                    <th>Remove</th>
                </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
        </div>
    </div>
</div>
<div class="m-separator m-separator--dashed m-separator--lg"></div>
<div class="m-form__heading">
    <h3 class="m-form__heading-title">Profile Image</h3>
</div>
<div class="row pl-4 pr-4">
    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
        <label class="form-control-label"> Drag n drop file or manually select a file </label>
        <div class="dropzone" id="attach-image" style="height: 280px"></div>
        <span class="m-form__help">accepted: jpeg, gif, png</span>
    </div>
    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
        <label class="form-control-label"> Preview </label><br>
        <img id="user-image" class="img-fluid" src="{{asset('assets/global/img/import_placeholder.png')}}" alt="">
        <input type="hidden" name="applicant_photo" id="user-profile-pic">
    </div>
</div>

@push('scripts')

    {{--<script src="//cdn.jsdelivr.net/npm/dropzone@5.5.1/dist/dropzone.min.js"></script>--}}
    {{--<script src="//cdnjs.cloudflare.com/ajax/libs/imgareaselect/0.9.10/js/jquery.imgareaselect.pack.js"></script>--}}

    <script>



        var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
        var baseUrl = '{!! url('/') !!}/';
        Dropzone.autoDiscover = false;

        function resetFields(){
            $('#attachment-type').val(3);
            $('.m_selectpicker').selectpicker('refresh');
            $('#remarks').val('');
        }

        // upload attachment
        $("#attach-document").dropzone({
            paramName: "file",
            params:{type: 'admission'},
            createImageThumbnails: false,
            previewTemplate: '<div style="display:none"></div>',
            maxFilesize: 2, // MB
            init: function() {
                this.on("error", function(file, message) {
                    alert(message);
                    this.removeFile(file);
                });
                this.on("totaluploadprogress", function (progress) {
                    $('.progress-row').removeClass('hide');
                    $('.img-progress').html(progress + '%');
                    // $(".image-upload-bar").width(progress + '%');
                });
            },
            url: "{{route('attachment.upload')}}",
            acceptedFiles: 'image/*, application/pdf, application/msword, application/vnd.openxmlformats-officedocument.wordprocessingml.document',
            headers: {
                'x-csrf-token': CSRF_TOKEN,
            },
            success: function (file, response) {
                this.removeFile(file);
                $('#image-errors').html('');


                imageHtml = "<tr>";
                imageHtml += "<td><input type='hidden' name='attachment_type_id[]' value='"+$('#attachment-type').val()+"'/>"+$('#attachment-type option:selected').text()+"</td>";
                imageHtml += "<td><input type='hidden' name='remarks[]' value='"+$('#remarks').val()+"'/>"+$('#remarks').val()+"</td>";
                imageHtml += "<td><input type='hidden' name='file_path[]' value='"+response.full_path+"'/><input type='hidden' name='type[]' value='"+response.extension+"'/>" +
                    "<a href='"+baseUrl+response.full_path+"' target='_blank'>View</a></td>";
                imageHtml += "<td><a href='#' class='remove-attachment' title='Remove attachment'><i class='fa fa-trash-alt'></i></a></td>";
                imageHtml += "</tr>";

                $('#attachment-table tbody').append(imageHtml);
                resetFields();

                sweetAlert('Attachment has been uploaded');


            },
            complete: function (file, response) {
                // $('.progress-row').addClass('hide');
                // $('.img-progress').html('');
                /*$('.progress').fadeOut('3000');
                setTimeout(function () {
                    $(".image-upload-bar").width(0 + '%');
                }, 4000);*/

            },
            error: function (file, response) {
                file.previewElement.classList.add("dz-error");
                html = '';
                if(response.errors){
                    for(i in response.errors.file){
                        html+= '<li class="error">'+ response.errors.file[i] +'</li>';
                    }
                }

                $('#image-errors').html(html);
            }
        });

        $("#attach-image").dropzone({
            paramName: "file",
            params:{type: 'admission.student.photo'},
            createImageThumbnails: false,
            maxFiles: 1,
            previewTemplate: '<div style="display:none"></div>',
            maxFilesize: 2, // MB
            init: function() {
                this.on("error", function(file, message) {
                    alert(message);
                    this.removeFile(file);
                });
                this.on("totaluploadprogress", function (progress) {
                    $('.progress-row').removeClass('hide');
                    $('.img-progress').html(progress + '%');
                    // $(".image-upload-bar").width(progress + '%');
                });
            },
            url: "{{route('attachment.upload')}}",
            acceptedFiles: 'image/*',
            headers: {
                'x-csrf-token': CSRF_TOKEN,
            },
            success: function (file, response) {
                this.removeFile(file);

                $('#user-image').attr('src', baseUrl+response.full_path);
                $('#user-profile-pic').val(response.full_path);

                /*$('#user-image').imgAreaSelect({
                    handles: true,
                    aspectRatio: "4:3",
                    onSelectEnd: function (img, selection) {
                        $('#img-height').val(selection.height);
                        $('#img-width').val(selection.width);
                        $('#img-x1').val(selection.x1);
                        $('#img-x2').val(selection.x2);
                        $('#img-y1').val(selection.y1);
                        $('#img-y2').val(selection.y2);
                        console.log(selection);
                    }
                });*/

                sweetAlert('Profile image has been uploaded');

            },
            complete: function (file, response) {
                // $('.progress-row').addClass('hide');
                // $('.img-progress').html('');
                /*$('.progress').fadeOut('3000');
                setTimeout(function () {
                    $(".image-upload-bar").width(0 + '%');
                }, 4000);*/

            },
            error: function (file, response) {
                file.previewElement.classList.add("dz-error");
                html = '';
                if(response.errors){
                    for(i in response.errors.file){
                        html+= '<li class="error">'+ response.errors.file[i] +'</li>';
                    }
                }

                $('#image-errors').html(html);
            }
        });

        $('body').on('click', '.remove-attachment', function(e){
            e.preventDefault();
            current = $(this);
            Swal.fire({
                title: 'Are you sure?',
                text: "Do you want delete",
                type: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Yes'
            }).then((result) => {
                if (result.value) {
                current.parents('tr').remove();

            }else if (result.dismiss === Swal.DismissReason.cancel){
                return false;
            }
        })
        })



</script>

@endpush
