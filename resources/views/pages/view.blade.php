@extends('layouts.default')

@push('style')
    <style>
        .blog-content-2 .blog-single-content {
            padding: 40px 30px 15px;
            background-color: #fff;
        }
        .blog-single-head-date {
            font-size: 13px;
            font-weight: 600;
            margin: 0 0 30px;
        }
        .blog-content-2 .blog-single-content>.blog-single-head>.blog-single-head-title {
            font-size: 25px;
            font-weight: 600;
            color: #4e5a64;
            margin: 0 0 40px;
            display: inline-block;
        }
        .blog-content-2 .blog-single-content>.blog-single-desc>p,
        .portlet>.portlet-body p {
            margin: 0 0 35px;
            font-size: 16px;
            color: #7e8691;
            line-height: 24px;
        }
        .blog-single-foot {
            border-top: 1px solid;
            border-bottom: 1px solid;
            border-color: #f0f1f2;
            padding: 20px 0 25px;
            margin-bottom: 20px;
        }
        .blog-content-2 .blog-single-sidebar {
            padding: 40px 30px;
            background-color: #f5f5f5;
        }

        .blog-page .blog-container {
            margin-bottom: 30px;
        }
        .blog-content-2 .blog-single-sidebar .blog-sidebar-title {
            font-weight: 600;
            font-size: 14px;
            color: #4e5a64;
            letter-spacing: 1px;
            margin-top: 40px;
        }
        .blog-content-2 .blog-single-sidebar>.blog-single-sidebar-tags .blog-post-tags {
            text-align: left;
            padding: 0;
            margin: 20px 0 0;
        }
        .blog-content-2 .blog-single-sidebar>.blog-single-sidebar-tags .blog-post-tags>li {
            list-style: none;
            display: inline-block;
            margin: 0 5px 20px 0;
            background-color: #ddd;
            color: #666;
            font-size: 11px;
            font-weight: 600;
            padding: 7px 10px;
        }
    </style>
@endpush

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="portlet light bordered">
                <div class="portlet-title">
                    <div class="caption">
                        <i class="icon-calendar font-green-sharp"></i>
                        <span class="caption-subject font-green-sharp sbold uppercase">Page Details</span>
                    </div>
                    <div class="actions">
                        <a href="{{ url('admin/pages') }}" class="btn uppercase btn-create btn-rounded"><i class="icon-list"></i> Pages</a>
                    </div>
                </div>
                <div class="portlet-body">
                    <!--section view start-->
                    <div class="blog-page blog-content-2">
                        <div class="row">
                            <div class="col-md-8">
                                <div class="blog-single-content bordered blog-container">
                                    <div class="blog-single-head">
                                        <h1 class="blog-single-head-title">{{ $page->title }}</h1>
                                    </div>
                                    <div class="blog-single-desc">
                                        @if(isset($page->content))
                                            {!! $page->content !!}
                                        @else
                                            <p class="text-muted text-center">No page content found.</p>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="blog-single-sidebar bordered blog-container">
                                    <div class="blog-single-sidebar-tags" style="margin-top: 0;">
                                        <h3 class="blog-sidebar-title uppercase" style="margin-top: 0;">Status</h3>
                                        <p>{!! ($page->status == 1) ? '<span class="badge badge-success">Published</span>' : '<span class="badge badge-danger">Draft</span>' !!}</p>
                                    </div>
                                    <div class="blog-single-sidebar-tags" style="margin-top: 0;">
                                        <h3 class="blog-sidebar-title uppercase">Slug</h3>
                                        <p>{{ $page->slug }}</p>
                                    </div>
                                    <div class="blog-single-sidebar-tags">
                                        <h3 class="blog-sidebar-title uppercase">Meta title</h3>
                                        <p>{{ $page->meta_title }}</p>
                                    </div>
                                    <div class="blog-single-sidebar-tags">
                                        <h3 class="blog-sidebar-title uppercase">Meta description</h3>
                                        <p>{{ $page->meta_description }}</p>
                                    </div>
                                    <div class="blog-single-sidebar-tags">
                                        <h3 class="blog-sidebar-title uppercase">Meta keywords</h3>
                                        @if($metaKeywords == [""])
                                            <p class="text-muted">No meta keywords found.</p>
                                        @else
                                        <ul class="blog-post-tags">
                                            @foreach($metaKeywords as $metaKeyword)
                                            <li class="uppercase">{{ $metaKeyword }}</li>
                                            @endforeach
                                        </ul>
                                        @endif
                                    </div>
                                    <div class="blog-single-sidebar-tags">
                                        <h3 class="blog-sidebar-title uppercase">Created on</h3>
                                        <div class="blog-single-head-date">
                                            <p><i class="icon-calendar font-blue"></i> {{ $page->created_at }}</p>
                                        </div>
                                    </div>
                                    <div class="blog-single-sidebar-tags">
                                        <h3 class="blog-sidebar-title uppercase">Last updated</h3>
                                        <div class="blog-single-head-date">
                                            <p><i class="icon-calendar font-blue"></i> {{ $page->created_at }}</p>
                                        </div>
                                    </div>

                                    <hr>
                                    <div class="actions">
                                        <a href="{{ url('admin/pages/'.$page->id.'/edit') }}" class="btn btn-block btn-save"><i class="fa fa-pencil-square"></i> Edit Page</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
