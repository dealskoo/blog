<?php

namespace Dealskoo\Blog\Http\Controllers\Admin;

use Dealskoo\Admin\Http\Controllers\Controller as AdminController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class UploadController extends AdminController
{
    public function upload(Request $request)
    {
        $request->validate([
            'editormd-image-file' => ['required', 'image', 'max:1000']
        ]);

        $image = $request->file('editormd-image-file');
        $filename = time() . '.' . $image->guessExtension();
        $path = $image->storeAs('blog/images/' . date('Ymd'), $filename);
        return response()->json([
            'success' => 1,
            'url' => Storage::url($path)
        ]);
    }
}
