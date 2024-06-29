<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PostController extends Controller
{
    public function show($slug)
    {
        return response()
            ->json([
                'message' => 'This is a post with slug ' . $slug
            ]);
    }
}
