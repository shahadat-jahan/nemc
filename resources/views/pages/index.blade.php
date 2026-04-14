@extends('layouts.default')

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="portlet light bordered">
                <div class="portlet-title">
                    <div class="caption">
                        <i class="icon-doc font-green-sharp"></i>
                        <span class="caption-subject font-green-sharp sbold uppercase">page List</span>
                    </div>
                    <div class="actions">
                        @if (hasPermission('pages/create'))
                            <a href="{{ url('admin/pages/create') }}" class="btn uppercase btn-create btn-rounded"><i class="icon-plus"></i> create</a>
                        @endif
                    </div>
                </div>
                <div class="portlet-body">
                    <div class="row">
                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 table-responsive">
                            @include('./common/datatable')
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <!-- Modal -->
    <div class="modal fade" id="page-modal" tabindex="-1" role="dialog" aria-labelledby="pagePreview">
        <div class="modal-dialog" style="width: 90%" role="document">
            <div class="modal-content">
                <div class="modal-header bg-info">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title text-center" id="pagePreview">Page Preview</h4>
                </div>
                <div class="modal-body" style="padding: 0;">
                    <iframe id="preview-frame" src="{{ url('about-storage-finder') }}" width="100%" height="780"></iframe>
                </div>
                <div class="modal-footer bg-info">
                    <button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

@endsection

@push('scripts')
    <script>
        $(document).on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget); // Button that triggered the modal3
            var pageUrl = button.data('url') // Extract info from data-* attributes
            $('#preview-frame').attr('src', pageUrl);
        });
    </script>
@endpush
