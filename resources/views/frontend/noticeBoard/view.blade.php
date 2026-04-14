@extends('frontend.layouts.default')
@section('pageTitle', $pageTitle)

@section('content')
    <div class="m-portlet m-portlet--tab">
        <div class="m-portlet__head">
            <div class="m-portlet__head-caption">
                <div class="m-portlet__head-title">
                    <h3 class="m-portlet__head-text"><i class="fas fa-info-circle pr-2"></i>Notice Detail</h3>
                </div>
            </div>
            <div class="m-portlet__head-tools">
                <a href="{{ route('frontend.notice_board.index') }}" class="btn btn-primary m-btn m-btn--icon"><i class="fas fa-list-alt pr-2"></i>Notices</a>
            </div>
        </div>

        <div class="m-section__content">
            <div class="m-grid__item m-grid__item--fluid m-wrapper">
                <div class="m-content">
                    <div class="row">
                        <div class="col-sm-9">
                            <h4>Title : {{$notice->title}}</h4>
                            <h6><i class="far fa-clock"></i>Created at : {{$notice->created_at->format('j F Y')}}</h6>
                            <h6><i class="far fa-check-circle"></i>Published Date
                                : {{!empty($notice->published_date) ? $notice->published_date : 'Do not publish yet'}}
                            </h6>
                            <span
                                class="badge badge-primary">Session : {{!empty($notice->session->title) ? $notice->session->title : 'All Session'}}</span>
                            <span
                                class="badge badge-info">Batch Type : {{!empty($notice->batchType->title) ? $notice->batchType->title : 'All Batch'}}</span>
                            <span class="badge badge-success">Status : @if($notice->status == 1)
                                    Active
                                @else
                                    Inactive
                                @endif</span>
                            @if(!empty($notice->description))
                                <p class="mt-3"><strong class="pr-1">Description
                                        :</strong> {{strip_tags($notice->description)}}</p>
                            @endif
                        </div>
                    </div>
                    @if(!empty($notice->file_path) && file_exists(public_path('nemc_files/noticeBoard/'.$notice->file_path)))
                        <div class="row justify-content-center">
                            <div id="pdf-viewer" class="w-100 border"
                                 style="max-width: 950px; height: 100vh; overflow: auto"></div>
                            <a href="{{asset('nemc_files/noticeBoard/'.$notice->file_path)}}"
                               class="btn m-btn m-btn--hover-brand m-btn--icon m-btn--icon-only m-btn--pill"
                               target="_blank" title="Download" download><i class="fa fa-download"></i></a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
@push('scripts')
    @if(!empty($notice->file_path) && file_exists(public_path('nemc_files/noticeBoard/'.$notice->file_path)))
        {
        <script src="https://cdnjs.cloudflare.com/ajax/libs/pdf.js/2.10.377/pdf.min.js"></script>
        <script>

            var url = '{{ asset('nemc_files/noticeBoard/'.$notice->file_path) }}';
            var pdfjsLib = window['pdfjs-dist/build/pdf'];
            pdfjsLib.GlobalWorkerOptions.workerSrc = 'https://cdnjs.cloudflare.com/ajax/libs/pdf.js/2.10.377/pdf.worker.min.js';

            // Loading the PDF
            var loadingTask = pdfjsLib.getDocument(url);
            loadingTask.promise.then(function (pdf) {
                console.log('PDF loaded');

                // Function to render a page
                function renderPage(page) {
                    var scale = 1.5;
                    var viewport = page.getViewport({scale: scale});

                    // Prepare canvas using PDF page dimensions
                    var canvas = document.createElement('canvas');
                    var context = canvas.getContext('2d');
                    canvas.height = viewport.height;
                    canvas.width = viewport.width;

                    // Render PDF page into canvas context
                    var renderContext = {
                        canvasContext: context,
                        viewport: viewport
                    };
                    var renderTask = page.render(renderContext);
                    renderTask.promise.then(function () {
                        console.log('Page rendered');
                        document.getElementById('pdf-viewer').appendChild(canvas);
                    });
                }

                // Loop through all pages and render them
                for (var i = 1; i <= pdf.numPages; i++) {
                    pdf.getPage(i).then(renderPage);
                }
            }, function (reason) {
                console.error(reason);
            });
        </script>
    @endif
@endpush
