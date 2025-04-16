<?php

namespace Modules\PkgBlog\App\Controllers;

use Illuminate\Http\Request;
use Modules\Core\App\Controllers\BaseController;

class ArticleImageController extends BaseController
{
    public function store(Request $request)
    {
        $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,webp|max:5120'
        ]);

        try {
            $path = $request->file('image')->store('articles/gallery', 'public');
            $url = asset('storage/' . $path);

            return response()->json([
                'url' => $url,
                'path' => $path
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Upload failed: ' . $e->getMessage()
            ], 500);
        }
    }
}
