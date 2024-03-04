<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use App\Http\Resources\PostResource;
use App\Http\Resources\PostResourceDetail;

class PostController extends Controller
{
    public function index() {
        $posts = Post::all();
        // return response()->json(['data' => $posts]);

        return PostResource::collection($posts);

    }

    public function show($id) {
        $post = Post::with('writer:id,username')->findOrFail($id);

        return new PostResourceDetail($post);

    }

    public function addPost(Request $request) {
        $validateData = $request->validate ([
            'title' => 'required',
            'news_content' => 'required',
            'author' => 'required'
        ]);

        $post = Post::create($validateData);
        return response()->json(['data' => $post]);

    }
}
