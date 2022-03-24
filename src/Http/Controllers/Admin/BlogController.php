<?php

namespace Dealskoo\Blog\Http\Controllers\Admin;

use Carbon\Carbon;
use Dealskoo\Admin\Http\Controllers\Controller as AdminController;
use Dealskoo\Admin\Rules\Slug;
use Dealskoo\Blog\Models\Blog;
use Dealskoo\Country\Models\Country;
use Dealskoo\Tag\Models\Tag;
use Illuminate\Http\Request;

class BlogController extends AdminController
{
    public function index(Request $request)
    {
        abort_if(!$request->user()->canDo('blogs.index'), 403);
        if ($request->ajax()) {
            return $this->table($request);
        } else {
            return view('blog::admin.blog.index');
        }
    }

    private function table(Request $request)
    {
        $start = $request->input('start', 0);
        $limit = $request->input('length', 10);
        $keyword = $request->input('search.value');
        $columns = ['id', 'title', 'country_id', 'can_comment', 'views', 'published_at', 'created_at', 'updated_at'];
        $column = $columns[$request->input('order.0.column', 0)];
        $desc = $request->input('order.0.dir', 'desc');
        $query = Blog::query();
        if ($keyword) {
            $query->where('title', 'like', '%' . $keyword . '%');
            $query->orWhere('slug', 'like', '%' . $keyword . '%');
        }
        $query->orderBy($column, $desc);
        $count = $query->count();
        $blogs = $query->skip($start)->take($limit)->get();
        $rows = [];
        $can_view = $request->user()->canDo('blogs.show');
        $can_edit = $request->user()->canDo('blogs.edit');
        $can_destroy = $request->user()->canDo('blogs.destroy');
        foreach ($blogs as $blog) {
            $row = [];
            $row[] = $blog->id;
            $row[] = '<img src="' . $blog->cover_url . '" alt="' . $blog->title . '" title="' . $blog->title . '" class="me-1"><p class="m-0 d-inline-block align-middle font-16">' . $blog->title . '</p>';
            $row[] = $blog->country->name;
            $row[] = $blog->can_comment;
            $row[] = $blog->views;
            $row[] = $blog->published_at != null ? Carbon::parse($blog->published_at)->format('Y-m-d H:i:s') : null;
            $row[] = Carbon::parse($blog->created_at)->format('Y-m-d H:i:s');
            $row[] = Carbon::parse($blog->updated_at)->format('Y-m-d H:i:s');
            $view_link = '';
            if ($can_view) {
                $view_link = '<a href="' . route('admin.blogs.show', $blog) . '" class="action-icon"><i class="mdi mdi-eye"></i></a>';
            }

            $edit_link = '';
            if ($can_edit) {
                $edit_link = '<a href="' . route('admin.blogs.edit', $blog) . '" class="action-icon"><i class="mdi mdi-square-edit-outline"></i></a>';
            }
            $destroy_link = '';
            if ($can_destroy) {
                $destroy_link = '<a href="javascript:void(0);" class="action-icon delete-btn" data-table="blogs_table" data-url="' . route('admin.blogs.destroy', $blog) . '"> <i class="mdi mdi-delete"></i></a>';
            }
            $row[] = $view_link . $edit_link . $destroy_link;
            $rows[] = $row;
        }
        return [
            'draw' => $request->draw,
            'recordsTotal' => $count,
            'recordsFiltered' => $count,
            'data' => $rows
        ];
    }

    public function show(Request $request, $id)
    {
        abort_if(!$request->user()->canDo('blogs.show'), 403);
        $blog = Blog::query()->findOrFail($id);
        return view('blog::admin.blog.show', ['blog' => $blog]);
    }

    public function create(Request $request)
    {
        abort_if(!$request->user()->canDo('blogs.create'), 403);
        $countries = Country::all();
        return view('blog::admin.blog.create', ['countries' => $countries]);
    }

    public function store(Request $request)
    {
        abort_if(!$request->user()->canDo('blogs.create'), 403);
        $request->validate([
            'title' => ['required', 'string'],
            'slug' => ['required', new Slug('blogs', 'slug')],
            'country_id' => ['required', 'exists:countries,id'],
            'cover' => ['required', 'image', 'max:1000']
        ]);

        $blog = new Blog($request->only([
            'title',
            'slug',
            'country_id',
            'content'
        ]));

        $image = $request->file('cover');
        $filename = time() . '.' . $image->guessExtension();
        $path = $image->storeAs('blog/images/' . date('Ymd'), $filename);

        $blog->cover = $path;
        $blog->can_comment = $request->boolean('can_comment', false);
        $blog->published_at = $request->boolean('published', false) ? Carbon::now() : null;
        $blog->save();
        $tags = $request->input('tags', []);
        foreach ($tags as $t) {
            $tag = Tag::query()->where('country_id', $blog->country_id)->where('name', $t)->first();
            if (!$tag) {
                $tag = new Tag(['name' => $t, 'country_id' => $blog->country_id]);
                $tag->save();
            }
            $blog->tag($tag);
        }
        return back()->with('success', __('admin::admin.added_success'));
    }

    public function edit(Request $request, $id)
    {
        abort_if(!$request->user()->canDo('blogs.edit'), 403);
        $blog = Blog::query()->findOrFail($id);
        $countries = Country::all();
        return view('blog::admin.blog.edit', ['countries' => $countries, 'blog' => $blog]);
    }

    public function update(Request $request, $id)
    {
        abort_if(!$request->user()->canDo('blogs.edit'), 403);

    }

    public function destroy(Request $request, $id)
    {
        abort_if(!$request->user()->canDo('blogs.destroy'), 403);

    }
}
