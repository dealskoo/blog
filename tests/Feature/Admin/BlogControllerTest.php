<?php

namespace Dealskoo\Blog\Tests\Feature\Admin;

use Dealskoo\Admin\Models\Admin;
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

    }

    public function test_show()
    {

    }

    public function test_create()
    {

    }

    public function test_store()
    {

    }

    public function test_edit()
    {

    }

    public function test_update()
    {

    }

    public function test_destroy()
    {

    }
}
