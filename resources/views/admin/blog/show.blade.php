@extends('admin::layouts.panel')

@section('title',__('blog::blog.view_blog'))
@section('body')
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a
                                href="{{ route('admin.dashboard') }}">{{ __('admin::admin.dashboard') }}</a></li>
                        <li class="breadcrumb-item active">{{ __('blog::blog.view_blog') }}</li>
                    </ol>
                </div>
                <h4 class="page-title">{{ __('blog::blog.view_blog') }}</h4>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <h3>{{ $blog->title }}</h3>
                    <div>
                        <span>{{ __('blog::blog.updated_at') }}: {{ $blog->updated_at->diffForHumans() }}</span>
                        @isset($blog->published_at)
                            <span
                                class="ms-2">{{ __('blog::blog.published_at') }}: {{ $blog->published_at->diffForHumans() }}</span>
                        @endisset
                        <span class="ms-2">{{ __('blog::blog.country') }}: {{ $blog->country->name }}</span>
                        @if($blog->can_comment)
                            <span class="ms-2">{{ __('blog::blog.can_comment') }}</span>
                        @endif
                        <span class="ms-2">{{ __('blog::blog.views') }}: {{ $blog->views }}</span>
                    </div>
                    <div class="mb-2">
                        @unless(empty($blog->tags))
                            @foreach($blog->tags as $tag)
                                <div class="badge bg-primary rounded-pill position-relative me-2 mt-2">
                                    {{ $tag->name }}
                                </div>
                            @endforeach
                        @endunless
                    </div>
                    <img src="{{ $blog->cover_url }}" class="img-fluid mb-2">
                    <div class="mb-2 markdown-body">
                        @unless(empty($blog->content))
                            {!! Str::markdown($blog->content) !!}
                        @endunless
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('css')
    <link href="{{ asset('/vendor/admin/css/vendor/github-markdown-light.css') }}" rel="stylesheet" type="text/css"/>
@endsection
