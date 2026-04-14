@extends('layouts.default')
@section('pageTitle', $pageTitle)

@section('content')

    <div class="m-portlet m-portlet--tab">
        <div class="m-portlet__head">
            <div class="m-portlet__head-caption">
                <div class="m-portlet__head-title">
                    <h3 class="m-portlet__head-text"><i class="far fa-plus-square pr-2"></i>Create Lecture Material</h3>
                </div>
            </div>
            <div class="m-portlet__head-tools">
                    <a href="{{ URL::previous() }}" class="btn btn-primary m-btn m-btn--icon"><i class="fas fa-book-reader pr-2"></i>Lecture Materials</a>
            </div>
        </div>

        <!--begin::Form-->
        <form class="m-form m-form--fit m-form--label-align-right"  action="{{ url('admin/lecture_material') }}" method="post" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="mode" value="{{$mode}}">
            <input type="hidden" name="class_routine_id" value="{{$classId}}">
            <div class="m-portlet__body">
                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
                        <div class="form-group  m-form__group">
                            <label class="form-control-label">Content </label>
                            <textarea type="text" class="form-control m-input summernote" name="content"> {{old('content')}} </textarea>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
                        <div class="form-group  m-form__group {{ $errors->has('resource_url') ? 'has-danger' : '' }}">
                            <label class="form-control-label">Resource Url </label>
                            <textarea type="text" class="form-control m-input" name="resource_url" placeholder="Enter resource URL by comma (,) Separator" style="height: 5rem !important;"> {{old('resource_url')}} </textarea>
                            @if ($errors->has('resource_url'))
                                <div class="form-control-feedback">{{ $errors->first('resource_url') }}</div>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
                        <div class="form-group  m-form__group">
                            <label class="form-control-label">Chose Lecture Attachment </label>
                            <input type="file" class="form-control-file" name="attachment_file">
                        </div>
                    </div>
                </div>
            </div>


            <div class="m-portlet__foot m-portlet__foot--fit">
                <div class="m-form__actions text-center">
                    <a href=" {{ URL::previous() }}" class="btn btn-outline-brand"><i class="fa fa-times"></i> Cancel</a>
                    <button type="submit" class="btn btn-success"><i class="fa fa-save"></i> Save</button>
                </div>
            </div>
        </form>

        <!--end::Form-->
    </div>
@endsection

@push('scripts')
    <script>
        $(".summernote").summernote({height:150})
    </script>
@endpush

