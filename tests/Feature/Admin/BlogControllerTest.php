<?php

namespace Dealskoo\Blog\Tests\Feature\Admin;

use Dealskoo\Admin\Models\Admin;
use Dealskoo\Blog\Models\Blog;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Dealskoo\Blog\Tests\TestCase;

class BlogControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_index()
    {
        $admin = Admin::factory()->isOwner()->create();
        $response = $this->actingAs($admin, 'admin')->get(route('admin.blogs.index'));
        $response->assertStatus(200);
    }

    public function test_table()
    {
        $admin = Admin::factory()->isOwner()->create();
        $response = $this->actingAs($admin, 'admin')->get(route('admin.blogs.index'), ['HTTP_X-Requested-With' => 'XMLHttpRequest']);
        $response->assertJsonPath('recordsTotal', 0);
        $response->assertStatus(200);
    }

    public function test_show()
    {
        $admin = Admin::factory()->isOwner()->create();
        $blog = Blog::factory()->create();
        $response = $this->actingAs($admin, 'admin')->get(route('admin.blogs.show', $blog));
        $response->assertStatus(200);
    }

    public function test_create()
    {
        $admin = Admin::factory()->isOwner()->create();
        $response = $this->actingAs($admin, 'admin')->get(route('admin.blogs.create'));
        $response->assertStatus(200);
    }

    public function test_store()
    {
        $admin = Admin::factory()->isOwner()->create();
        $blog = Blog::factory()->make();
        $response = $this->actingAs($admin, 'admin')->post(route('admin.blogs.store'), $blog->only([
            'title',
            'slug',
            'content',
            'country_id'
        ]));
        $response->assertStatus(302);
    }

    public function test_edit()
    {
        $admin = Admin::factory()->isOwner()->create();
        $blog = Blog::factory()->create();
        $response = $this->actingAs($admin, 'admin')->get(route('admin.blogs.edit', $blog));
        $response->assertStatus(200);
    }

    public function test_update()
    {
        $admin = Admin::factory()->isOwner()->create();
        $blog = Blog::factory()->create();
        $blog1 = Blog::factory()->make();
        $response = $this->actingAs($admin, 'admin')->put(route('admin.blogs.update', $blog), $blog1->only([
            'title',
            'country_id',
        ]));
        $response->assertStatus(302);
    }

    public function test_destroy()
    {
        $admin = Admin::factory()->isOwner()->create();
        $blog = Blog::factory()->create();
        $response = $this->actingAs($admin, 'admin')->delete(route('admin.blogs.destroy', $blog));
        $response->assertStatus(200);
        $this->assertSoftDeleted($blog);
    }
}
