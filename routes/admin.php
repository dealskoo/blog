<?php

use Dealskoo\Blog\Http\Controllers\Admin\BlogController;
use Dealskoo\Blog\Http\Controllers\Admin\UploadController;
use Illuminate\Support\Facades\Route;

Route::middleware(['web', 'admin_locale'])->prefix(config('admin.route.prefix'))->name('admin.')->group(function () {

    Route::middleware(['guest:admin'])->group(function () {

    });

    Route::middleware(['auth:admin', 'admin_active'])->group(function () {
        Route::resource('blogs', BlogController::class);
        Route::post('/blogs/upload', [UploadController::class, 'upload'])->name('blogs.upload');
    });

});
