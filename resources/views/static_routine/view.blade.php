@extends('layouts.default')

@section('pageTitle', $pageTitle)

@section('content')
    <div class="m-portlet">
        <div class="m-portlet__head">
            <div class="m-portlet__head-caption">
                <div class="m-portlet__head-title">
                    <h3 class="m-portlet__head-text">View Static Routine</h3>
                </div>
            </div>
            <div class="m-portlet__head-tools">
                @if (hasPermission('static_routine/edit'))
                    <a href="{{ route('static_routine.edit', $routine->id) }}"
                       class="btn btn-primary m-btn m-btn--icon mr-2"
                       title="Create New Session"><i class="fas fa-edit pr-2"></i>Edit</a>
                @endif
                <a href="{{ route('static_routine.index') }}" class="btn btn-primary m-btn m-btn--icon"
                   title="Create New Session"><i class="fas fa-list-ul pr-2"></i>List</a>
            </div>
        </div>
        <div class="m-portlet__body">
            <div class="m-section__content">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group row">
                            <label class="col-sm-4 col-form-label">Title</label>
                            <div class="col-sm-8 col-form-label">
                                {{ $routine->title }}
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group row">
                            <label class="col-sm-4 col-form-label">Session</label>
                            <div class="col-sm-8 col-form-label">
                                {{ $routine->session ? $routine->session->title : 'N/A' }}
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group row">
                            <label class="col-sm-4 col-form-label">Phase</label>
                            <div class="col-sm-8 col-form-label">
                                {{ $routine->phase ? $routine->phase->title : 'N/A' }}
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group row">
                            <label class="col-sm-4 col-form-label">Status</label>
                            <div class="col-sm-8 col-form-label">
                                {!! setStatus($routine->status) !!}
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label">Description</label>
                            <div class="col-sm-10 col-form-label">
                                {{ $routine->description ?? 'N/A' }}
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label">Routine File</label>
                            <div class="col-sm-10">
                                @if ($routine->file_path)
                                    @php
                                        $extension = pathinfo($routine->file_path, PATHINFO_EXTENSION);
                                        $isImage = in_array(strtolower($extension), ['jpg', 'jpeg', 'png', 'gif']);
                                    @endphp

                                    @if ($isImage)
                                        <img src="{{ asset($routine->file_path) }}" class="img-fluid"
                                            style="max-width: 100%; max-height: 500px;">
                                    @else
                                        <a href="{{ asset($routine->file_path) }}" class="btn btn-primary"
                                            target="_blank">View/Download File</a>
                                    @endif
                                @else
                                    <span class="text-muted">No file uploaded</span>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
