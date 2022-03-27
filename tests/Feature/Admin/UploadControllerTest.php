<?php

namespace Dealskoo\Blog\Tests\Feature\Admin;

use Dealskoo\Admin\Models\Admin;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Dealskoo\Blog\Tests\TestCase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class UploadControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_upload()
    {
        Storage::fake();
        $admin = Admin::factory()->create();
        $response = $this->actingAs($admin, 'admin')->post(route('admin.blogs.upload'), [
            'editormd-image-file' => UploadedFile::fake()->image('file.jpg')
        ]);
        $response->assertStatus(200);
        $url = json_decode($response->content())->url;
        $filename = basename($url);
        Storage::assertExists('blog/images/' . date('Ymd') . '/' . $filename);
    }
}
