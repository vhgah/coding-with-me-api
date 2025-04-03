<?php

namespace App\Http\Controllers\Admin;

use App\Models\Post;
use App\Actions\CreatePost;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\CreatePostRequest;
use App\Http\Requests\Admin\UpdatePostStatusRequest;
use App\RepositoryInterfaces\PostRepositoryInterface;

class PostController extends Controller
{
    public function __construct(
        protected PostRepositoryInterface $postRepository
    ) {
        //   
    }

    public function index(Request $request)
    {
        $options = [
            'keyword' => $request->input('keyword'),
            'status' => $request->input('status'),
            'sort_field' => 'created_at',
            'sort_order' => 'desc',
            'admin_id' => auth()->user()->id,
        ];

        $posts = $this->postRepository
            ->paginate($options)
            ->through(function (Post $post) {
                return $this->getResource($post);
            });

        return response()->json($posts);
    }

    public function store(CreatePostRequest $request)
    {
        $data = $request->validated();

        $data['admin_id'] = auth()->user()->id;

        $post = CreatePost::make($data)->execute();

        return response()->json(
            $this->getResource($post),
            201
        );
    }

    public function show(Post $post)
    {
        if ($post->admin_id !== auth()->user()->id) {
            return response()->json([
                'message' => 'You do not have permission to update this post'
            ], 403);
        }

        return response()->json(
            $this->getResource($post)
        );
    }

    public function update(CreatePostRequest $request, Post $post)
    {
        if ($post->admin_id !== auth()->user()->id) {
            return response()->json([
                'message' => 'You do not have permission to update this post'
            ], 403);
        }

        $data = $request->validated();

        $post->update($data);

        return response()->json(
            $this->getResource($post)
        );
    }

    public function destroy(Post $post)
    {
        if ($post->admin_id !== auth()->user()->id) {
            return response()->json([
                'message' => 'You do not have permission to delete this post'
            ], 403);
        }

        $post->delete();
        
        return response()->json(null, 204);
    }

    public function updateStatus(UpdatePostStatusRequest $request, Post $post)
    {
        $data = $request->validated();

        $post->update([
            'status' => $data['status']
        ]);

        return response()->json(
            $this->getResource($post)
        );
    }

    private function getResource(Post $post)
    {
        return [
            'id' => $post->id,
            'title' => $post->title,
            'featured_image' => $post->featured_image,
            'summary' => $post->summary,
            'content' => $post->content,
            'status' => $post->status,
            'category_id' => $post->category_id,
            'created_at' => $post->created_at,
            'updated_at' => $post->updated_at,
            'published_at' => $post->published_at,
            'is_active' => $post->isActive(),
        ];
    }
}
