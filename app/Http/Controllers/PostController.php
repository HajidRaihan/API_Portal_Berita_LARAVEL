<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use App\Http\Resources\PostResource;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\PostResourceDetail;

class PostController extends Controller
{
    public function index() {
        $posts = Post::with('writer:id,username')->get();
        // return response()->json(['data' => $posts]);

        return PostResource::collection($posts);

    }

    public function show($id) {
        $post = Post::with('writer:id,username')->findOrFail($id);

        return new PostResourceDetail($post);

    }

    public function store(Request $request) {
        $validateData = $request->validate ([
            'title' => 'required',
            'news_content' => 'required',
        ]);

        $request['author'] = Auth::user()->id;

        $post = Post::create($request->all());
        // return response()->json(['data' => $post]);
        return new PostResourceDetail($post->loadMissing('writer:id,username'));



    }

    public function update(Request $request, $id) {
        $validate = $request->validate([
            'title' => 'required',
            'news_content' => 'required',
        ]);

        $post = Post::findOrFail($id);
        $post->update($validate);
        // return response()->json(['data' => $post]);
        return new PostResourceDetail($post->loadMissing('writer:id,username'));
    }

    public function destroy($id) {
        $post = Post::findOrFail($id);
        $post->delete();
        return response()->json(['message' => 'deleted']);
    }
}
