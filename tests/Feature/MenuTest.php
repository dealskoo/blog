<?php

namespace Dealskoo\Blog\Tests\Feature;

use Dealskoo\Admin\Facades\AdminMenu;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Dealskoo\Blog\Tests\TestCase;

class MenuTest extends TestCase
{
    use RefreshDatabase;

    public function test_menu()
    {
        $this->assertNotNull(AdminMenu::findBy('title', 'blog::blog.blogs'));
    }
}
