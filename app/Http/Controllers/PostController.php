<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $posts = Post::with('author')->select([
            'id',
            'title',
            'slug',
            'short_description',
            'user_id',
            'created_at'
        ]);

        if (request()->query('author')) {
            $posts->where('user_id', request()->query('author'));
        }

        return view('post.index', [
            'posts' => $posts->paginate(1)
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function show(Post $post)
    {
        return view('post.show', [
            'post' => $post
        ]);
    }
}
