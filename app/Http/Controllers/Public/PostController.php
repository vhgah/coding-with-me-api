<?php

namespace App\Http\Controllers\Public;

use App\Enums\PostStatusEnum;
use App\Http\Controllers\Controller;
use App\Models\Post;
use App\RepositoryInterfaces\PostRepositoryInterface;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function index(Request $request)
    {
        $params = array_merge($request->all(), [
            'status' => PostStatusEnum::ACTIVE,
            'sort_field' => 'published_at',
            'sort_order' => 'DESC',
        ]);

        return app(PostRepositoryInterface::class)
            ->paginate($params)
            ->through(function ($post) {
                return [
                    'title' => $post->title,
                    'slug' => $post->slug,
                    'summary' => $post->summary,
                    'featured_image' => $post->featured_image,
                    'link' => sprintf('/%s', $post->slug),
                    'author' => [
                        'name' => $post->author->username,
                    ],
                    'category' => [
                        'name' => $post->category->name,
                        'link' => sprintf('/category/%s', $post->category->slug),
                    ],
                    'content' => $post->content,
                    'published_at' => $post->formatted_published_at,
                ];
            });
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
                'slug' => $post->slug,
                'summary' => $post->summary,
                'featured_image' => $post->featured_image,
                'link' => sprintf('/%s', $post->slug),
                'author' => [
                    'name' => $post->author->username,
                ],
                'category' => [
                    'name' => $post->category->name,
                    'link' => sprintf('/category/%s', $post->category->slug),
                ],
                'content' => $post->content,
                'published_at' => $post->formatted_published_at,
            ]
        ]);
    }
}
