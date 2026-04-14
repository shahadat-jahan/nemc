@extends('frontend.layouts.default')
@section('pageTitle', 'Attachments')

@section('content')
    <div class="m-portlet m-portlet--tab">
        <div class="m-portlet__head">
            <div class="m-portlet__head-caption">
                <div class="m-portlet__head-title">
                    <h3 class="m-portlet__head-text"><i class="far fa-edit pr-2"></i>Attachments for {{$student->full_name_en}}</h3>
                </div>
            </div>
        </div>

        <!--begin::Form-->
        <form class="m-form m-form--fit m-form--label-align-right"  action="{{ route('students.attachment.post', $student->id) }}" id="nemc-general-form" method="post">
            @csrf
            <div class="m-portlet__body">
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <div class="row pl-4 pr-4">
                    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                        <div class="row">
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
                                <div class="form-group  m-form__group {{ $errors->has('bds_development_fee_local') ? 'has-danger' : '' }}">
                                    <label class="form-control-label"> Attachment type </label>
                                    <select class="form-control m-input m-bootstrap-select m_selectpicker" name="attachment_types" id="attachment-type" data-live-search="true">
                                        {!! select($attachmentTypes) !!}
                                    </select>
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
                                <div class="form-group  m-form__group {{ $errors->has('remarks') ? 'has-danger' : '' }}">
                                    <label class="form-control-label"> Remark </label>
                                    <textarea class="form-control m-input" name="remark" rows="4" id="remarks" placeholder="Remark"></textarea>
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

                <div class="m-form__heading">
                    <h3 class="m-form__heading-title">Attachments</h3>
                </div>
                <div class="row">
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

            </div>
            <div class="m-portlet__foot m-portlet__foot--fit">
                <div class="m-form__actions text-center">
                    <a href="{{ url('admin/students') }}" class="btn btn-outline-brand"><i class="fa fa-times"></i> Cancel</a>
                    <button type="submit" class="btn btn-success"><i class="fa fa-save"></i> Save</button>
                </div>
            </div>
        </form>

        <!--end::Form-->
    </div>
@endsection

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
            params:{type: 'student.attachments'},
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