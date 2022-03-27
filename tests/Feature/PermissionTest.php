<?php

namespace Dealskoo\Blog\Tests\Feature;

use Dealskoo\Admin\Facades\PermissionManager;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Dealskoo\Blog\Tests\TestCase;

class PermissionTest extends TestCase
{
    use RefreshDatabase;

    public function test_permissions()
    {
        $this->assertNotNull(PermissionManager::getPermission('blogs.index'));
        $this->assertNotNull(PermissionManager::getPermission('blogs.show'));
        $this->assertNotNull(PermissionManager::getPermission('blogs.create'));
        $this->assertNotNull(PermissionManager::getPermission('blogs.edit'));
        $this->assertNotNull(PermissionManager::getPermission('blogs.destroy'));
    }
}
