<?php

namespace Dealskoo\Blog\Providers;

use Dealskoo\Admin\Facades\AdminMenu;
use Dealskoo\Admin\Facades\PermissionManager;
use Dealskoo\Admin\Permission;
use Illuminate\Support\ServiceProvider;

class BlogServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {

    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        if ($this->app->runningInConsole()) {
            $this->loadMigrationsFrom(__DIR__ . '/../../database/migrations');

            $this->publishes([
                __DIR__ . '/../../resources/lang' => resource_path('lang/vendor/blog')
            ], 'lang');
        }

        $this->loadRoutesFrom(__DIR__ . '/../../routes/admin.php');

        $this->loadViewsFrom(__DIR__ . '/../../resources/views', 'blog');

        $this->loadTranslationsFrom(__DIR__ . '/../../resources/lang', 'blog');

        AdminMenu::route('admin.blogs.index', 'blog::blog.blogs', [], ['icon' => 'uil-file-alt', 'permission' => 'blogs.index'])->order(4);

        PermissionManager::add(new Permission('blogs.index', 'Blog Lists'));
        PermissionManager::add(new Permission('blogs.show', 'View Blog'), 'blogs.index');
        PermissionManager::add(new Permission('blogs.edit', 'Edit Blog'), 'blogs.index');
        PermissionManager::add(new Permission('blogs.destroy', 'Destroy Blog'), 'blogs.index');

    }
}
