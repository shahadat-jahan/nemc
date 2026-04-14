@extends('layouts.default')

@push('style')
    <link href="{{asset('assets/global/plugins/bootstrap-summernote/summernote.css')}}" rel="stylesheet"
          type="text/css"/>
@endpush

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="portlet light">
                <div class="portlet-title">
                    <div class="caption">
                        <i class="icon-doc font-green-sharp"></i>
                        <span class="caption-subject font-green-sharp sbold uppercase">create page</span>
                    </div>
                    <div class="actions">
                        <a href="{{ url('admin/pages') }}" class="btn uppercase btn-create btn-rounded"><i
                                class="fa fa-table"></i> pages</a>
                    </div>
                </div>
                <div class="portlet-body form">
                    <div class="portlet light">
                        <form role="form" action="{{ url('admin/pages') }}" method="post">
                            @csrf
                            <div class="form-body">
                                <div class="row">

                                    <div class="col-md-6">
                                        {{--Page contnet--}}
                                        <div class="form-group {{ $errors->has('title') ? 'has-error' : '' }}">
                                            <label><span class="required">*</span> Title:
                                            </label>

                                            <input type="text" class="form-control" name="title"
                                                   value="{{ old('title') }}" placeholder="Page title">
                                            <span class="help-block">
                                            @if ($errors->has('title'))
                                                    <label class="control-label">{{ $errors->first('title') }}</label>
                                                @endif
                                        </span>
                                        </div>
                                        <div class="form-group {{ $errors->has('slug') ? 'has-error' : '' }}">
                                            <label><span class="required">*</span> Slug</label>

                                            <input type="text" class="form-control" name="slug"
                                                   value="{{ old('slug') }}" placeholder="page-slug">
                                            <span class="help-block">
                                            @if ($errors->has('slug'))
                                                    <label class="control-label">{{ $errors->first('slug') }}</label>
                                                @endif
                                        </span>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        {{--Meta content--}}
                                        <div class="form-group {{ $errors->has('meta_title') ? 'has-error' : '' }}">
                                            <label> Meta title</label>
                                            <input type="text" class="form-control" name="meta_title"
                                                   value="{{ old('meta_title') }}" placeholder="Meta title">
                                            <span class="help-block">
                                                @if ($errors->has('meta_title'))
                                                    <label class="control-label">{{ $errors->first('meta_title') }}</label>
                                                @endif
                                            </span>
                                        </div>
                                        <div class="form-group {{ $errors->has('meta_keyword') ? 'has-error' : '' }}">
                                            <label> Meta Keywords</label>

                                            <input type="text" class="form-control" name="meta_keyword"
                                                   value="{{ old('meta_keyword') }}" placeholder="Meta keywords">
                                            <span class="help-block">
                                            @if ($errors->has('meta_keyword'))
                                                    <label class="control-label">{{ $errors->first('meta_keyword') }}</label>
                                                @endif
                                        </span>
                                        </div>
                                    </div>
                                </div>
                                {{--Content--}}
                                <div class="form-group {{ $errors->has('meta_description') ? 'has-error' : '' }}">
                                    <label> Meta Description: </label>
                                    <textarea name="meta_description" id="" rows="5" class="form-control" placeholder="Meta description">{{ old('meta_description') }}</textarea>
                                    <span class="help-block">
                                        @if ($errors->has('meta_description'))
                                            <label class="control-label">{{ $errors->first('meta_description') }}</label>
                                        @endif
                                        </span>
                                </div>
                                <div class="form-group {{ $errors->has('content') ? 'has-error' : '' }}">
                                    <label> Page content: </label>
                                    <textarea name="content" id="" rows="20" class="form-control text-editor">{{ old('content') }}</textarea>
                                    <span class="help-block">
                                    @if ($errors->has('content'))3
                                        <label class="control-label">{{ $errors->first('content') }}</label>
                                        @endif
                                </span>
                                </div>
                            </div>
                            <div class="form-actions">
                                <div class="row">
                                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
                                        <div class="text-center">
                                            <button type="submit" name="status" value="0" class="btn btn-default btn-rounded"><i
                                                    class="fa fa-pencil-square"></i> Draft
                                            </button>
                                            <button type="submit" name="status" value="1" class="btn btn-save btn-rounded"><i
                                                    class="fa fa-share-square"></i> Publish
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    @include('common.fm-editor')
@endpush
