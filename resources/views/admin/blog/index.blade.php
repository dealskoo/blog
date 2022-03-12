@extends('admin::layouts.panel')

@section('title',__('blog::blog.blogs_list'))
@section('body')
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a
                                href="{{ route('admin.dashboard') }}">{{ __('admin::admin.dashboard') }}</a></li>
                        <li class="breadcrumb-item active">{{ __('blog::blog.blogs_list') }}</li>
                    </ol>
                </div>
                <h4 class="page-title">{{ __('blog::blog.blogs_list') }}</h4>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    @if(Auth::user()->canDo('blogs.create'))
                        <div class="row mb-2">
                            <div class="col-12">
                                <a href="{{ route('admin.blogs.create') }}" class="btn btn-danger mb-2"><i
                                        class="mdi mdi-plus-circle me-2"></i> {{ __('blog::blog.add_blog') }}
                                </a>
                            </div>
                        </div>
                    @endif
                    <div class="table-responsive">
                        <table id="blogs_table" class="table table-centered w-100 dt-responsive nowrap">
                            <thead class="table-light">
                            <tr>
                                <th>{{ __('blog::blog.id') }}</th>
                                <th>{{ __('blog::blog.title') }}</th>
                                <th>{{ __('blog::blog.country') }}</th>
                                <th>{{ __('blog::blog.can_comment') }}</th>
                                <th>{{ __('blog::blog.views') }}</th>
                                <th>{{ __('blog::blog.published_at') }}</th>
                                <th>{{ __('blog::blog.created_at') }}</th>
                                <th>{{ __('blog::blog.updated_at') }}</th>
                                <th>{{ __('blog::blog.action') }}</th>
                            </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script type="text/javascript">
        $(function () {
            let table = $('#blogs_table').dataTable({
                "processing": true,
                "serverSide": true,
                "ajax": "{{ route('admin.blogs.index') }}",
                "language": language,
                "pageLength": pageLength,
                "columns": [
                    {'orderable': true},
                    {'orderable': true},
                    {'orderable': true},
                    {'orderable': true},
                    {'orderable': true},
                    {'orderable': true},
                    {'orderable': true},
                    {'orderable': true},
                    {'orderable': false},
                ],
                "order": [[0, "desc"]],
                "drawCallback": function () {
                    $('.dataTables_paginate > .pagination').addClass('pagination-rounded');
                    $('#blogs_table tr td:nth-child(2)').addClass('table-user');
                    $('#blogs_table tr td:nth-child(9)').addClass('table-action');
                    delete_listener();
                }
            });
            table.on('childRow.dt', function (e, row) {
                delete_listener();
            });
        });
    </script>
@endsection
