<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
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
        ];

        $posts = $this->postRepository->paginate(
            $options
        );

        return response()->json($posts);
    }
}
