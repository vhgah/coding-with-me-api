<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Post;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index(Request $request)
    {
        $categories = Category::query()
            ->get()
            ->map(function ($category) {
                return [
                    'id' => $category->id,
                    'name' => $category->name,
                    'slug' => $category->slug,
                    'link' => sprintf('/category/%s', $category->slug),
                ];
            });

        return response()->json([
            'data' => $categories,
        ]);
    }

    public function show($slug)
    {
        $post = Post::query()
            ->active()
            ->where('slug', $slug)
            ->firstOrFail();

        return response()->json([
            'data' => [
                'title' => $post->title,
                'content' => $post->content,
                'published_at' => $post->formatted_published_at,
            ]
        ]);
    }
}
