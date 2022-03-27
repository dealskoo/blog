<?php

namespace Dealskoo\Blog\Tests\Unit;

use Dealskoo\Blog\Models\Blog;
use Dealskoo\Blog\Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Storage;

class BlogTest extends TestCase
{
    use RefreshDatabase;

    public function test_cover_url()
    {
        $blog = Blog::factory()->create();
        $blog->cover = 'cover.png';
        $this->assertEquals($blog->cover_url, Storage::url($blog->cover));
    }

    public function test_with_published()
    {
        $count = 2;
        Blog::factory()->create();
        Blog::factory()->count($count)->published()->create();
        $this->assertEquals($count, Blog::published()->count());
    }
}
