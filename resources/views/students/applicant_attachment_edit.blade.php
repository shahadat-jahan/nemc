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
        @php $photo = !empty($student->photo) ? $student->photo : 'assets/global/img/import_placeholder.png'; @endphp
        <img id="user-image" class="img-fluid" src="{{asset($photo)}}" alt="">
        <input type="hidden" name="applicant_photo" value="{{$student->photo}}" id="user-profile-pic">
    </div>
</div>

@push('scripts')

    {{--<script src="//cdn.jsdelivr.net/npm/dropzone@5.5.1/dist/dropzone.min.js"></script>--}}
    {{--<script src="//cdnjs.cloudflare.com/ajax/libs/imgareaselect/0.9.10/js/jquery.imgareaselect.pack.js"></script>--}}

    <script>



        var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
        var baseUrl = '{!! url('/') !!}/';
        Dropzone.autoDiscover = false;

        $("#attach-image").dropzone({
            paramName: "file",
            params:{type: 'admission.student.photo'},
            maxFiles: 1,
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
            acceptedFiles: 'image/*',
            headers: {
                'x-csrf-token': CSRF_TOKEN,
            },
            success: function (file, response) {
                this.removeFile(file);

                $('#user-image').attr('src', baseUrl+response.full_path);
                $('#user-profile-pic').val(response.full_path);

                sweetAlert('Profile image has been uploaded');

            },
            complete: function (file, response) {

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


</script>

@endpush
