<?php

namespace App\Http\Controllers\Admin;

use App\Models\Post;
use App\Actions\CreatePost;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\CreatePostRequest;
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

    public function show($id)
    {
        $post = $this->postRepository->findWhere([
            'id' => $id,
            'admin_id' => auth()->user()->id,
        ]);

        if (!$post) {
            return response()->json([
                'message' => 'Post not found'
            ], 404);
        }

        return response()->json(
            $this->getResource($post)
        );
    }

    public function update(CreatePostRequest $request, $id)
    {
        $data = $request->validated();

        $post = $this->postRepository->findWhere([
            'id' => $id,
            'admin_id' => auth()->user()->id,
        ]);

        if (!$post) {
            return response()->json([
                'message' => 'Post not found'
            ], 404);
        }

        $post->update($data);

        return response()->json(
            $this->getResource($post)
        );
    }

    private function getResource(Post $post)
    {
        return [
            'id' => $post->id,
            'title' => $post->title,
            'summary' => $post->summary,
            'content' => $post->content,
            'status' => $post->status,
            'created_at' => $post->created_at,
            'updated_at' => $post->updated_at,
            'published_at' => $post->published_at,
        ];
    }
}
