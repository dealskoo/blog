@extends('admin::layouts.panel')
@section('title',__('blog::blog.add_blog'))
@section('body')
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a
                                href="{{ route('admin.dashboard') }}">{{ __('admin::admin.dashboard') }}</a></li>
                        <li class="breadcrumb-item active">{{ __('blog::blog.add_blog') }}</li>
                    </ol>
                </div>
                <h4 class="page-title">{{ __('blog::blog.add_blog') }}</h4>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('admin.blogs.store') }}" method="post" enctype="multipart/form-data">
                        @csrf
                        @if(!empty(session('success')))
                            <div class="alert alert-success">
                                <p class="mb-0">{{ session('success') }}</p>
                            </div>
                        @endif
                        @if(!empty($errors->all()))
                            <div class="alert alert-danger">
                                @foreach($errors->all() as $error)
                                    <p class="mb-0">{{ $error }}</p>
                                @endforeach
                            </div>
                        @endif
                        <div class="row">
                            <div class="col-md-10">
                                <div class="row">
                                    <div class="col-12 mb-3">
                                        <input type="text" class="form-control" id="title" name="title" required
                                               value="{{ old('title') }}" autofocus tabindex="1"
                                               placeholder="{{ __('blog::blog.title_placeholder') }}">
                                    </div>
                                    <div class="col-12 mb-3">
                                        <input type="text" class="form-control" id="slug" name="slug" required
                                               value="{{ old('slug') }}" tabindex="2"
                                               placeholder="{{ __('blog::blog.slug_placeholder') }}">
                                    </div>
                                    <div class="col-12">
                                        <div id="editor">
                                            <textarea name="content" tabindex="3"
                                                      style="display: none">{{ old('content') }}</textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="row">
                                    <div class="col-12 mb-3">
                                        <div class="cover-box">
                                            <img src="{{ asset(config('blog.default_cover')) }}"
                                                 class="img-thumbnail file-pic file-cover">
                                            <div class="upload-image">
                                                <i class="mdi mdi-cloud-upload upload-btn upload-cover-btn"></i>
                                                <input class="file-input" name="cover" tabindex="4" type="file" accept="image/*"/>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12 mb-3">
                                        <select id="country_id" name="country_id" class="form-control select2"
                                                data-toggle="select2" tabindex="5">
                                            @foreach($countries as $country)
                                                @if(old('country_id') == $country->id)
                                                    <option value="{{ $country->id }}"
                                                            selected>{{ $country->name }}</option>
                                                @else
                                                    <option value="{{ $country->id }}">{{ $country->name }}</option>
                                                @endif
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-12 mb-3">
                                        <input type="text" class="form-control tag-input" id="tag" name="tag"
                                               value="{{ old('tag') }}" tabindex="6"
                                               placeholder="{{ __('blog::blog.tag_placeholder') }}">
                                        <div class="mt-1 tags-box">
                                            @unless(empty(old('tags')))
                                                @foreach(old('tags') as $tag)
                                                    <div
                                                        class="badge bg-primary rounded-pill position-relative me-2 mt-2 tag-badge">
                                                        {{ $tag }}<input type="hidden" name="tags[]"
                                                                         value="{{ $tag }}"><span
                                                            class="position-absolute top-0 start-100 translate-middle bg-danger border border-light rounded-circle mdi mdi-close tag-remove"></span>
                                                    </div>
                                                @endforeach
                                            @endunless
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="form-check">
                                            <input type="checkbox" class="form-check-input" id="can_comment"
                                                   name="can_comment" tabindex="7"
                                                   value="1" @if(old('can_comment')) checked @endif>
                                            <label for="can_comment"
                                                   class="form-check-label">{{ __('blog::blog.can_comment') }}</label>
                                        </div>
                                    </div>
                                    <div class="col-12 mb-3">
                                        <div class="form-check">
                                            <input type="checkbox" class="form-check-input" id="published"
                                                   name="published" tabindex="8"
                                                   value="1" @if(old('published')) checked @endif>
                                            <label for="published"
                                                   class="form-check-label">{{ __('blog::blog.published') }}</label>
                                        </div>
                                    </div>
                                    <div class="text-end">
                                        <button type="submit" class="btn btn-success mt-2" tabindex="9"><i
                                                class="mdi mdi-content-save"></i> {{ __('admin::admin.save') }}
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div> <!-- end row -->
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('css')
    <link href="{{ asset('/vendor/admin/css/vendor/editormd.min.css') }}" rel="stylesheet" type="text/css"/>
@endsection
@section('script')
    <script src="{{ asset('/vendor/admin/js/vendor/editormd.js') }}"></script>
    <script type="text/javascript">
        $(function () {
            let path = '/vendor/admin/js/vendor';
            let editor = editormd("editor", {
                mode: "markdown",
                width: "100%",
                height: 800,
                watch: false,
                path: path + "/lib/",
                imageUpload: true,
                imageFormats: ["jpg", "jpeg", "png", "bmp", "webp"],
                imageUploadURL: "{{ route('admin.blogs.upload',['_token'=>csrf_token()]) }}",
                toolbarIcons: function () {
                    return [
                        "undo", "redo", "|",
                        "bold", "del", "italic", "quote", "ucwords", "uppercase", "lowercase", "|",
                        "h1", "h2", "h3", "h4", "h5", "h6", "|",
                        "list-ul", "list-ol", "hr", "|",
                        "link", "reference-link", "image", "code", "code-block", "table", "datetime", "pagebreak", "|",
                        "watch", "preview", "fullscreen", "clear", "search"
                    ];
                },
                onload: function () {
                    let lang = "{{ str_replace('_', '-', app()->getLocale()) }}";
                    if (lang !== 'zh-CN') {
                        editormd.loadScript(path + '/languages/' + lang, function () {
                            editor.lang = editormd.defaults.lang;
                        });
                    }
                }
            });
        });
    </script>
@endsection
