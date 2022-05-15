<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Validation\Rule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class AdminPostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $breadcrumbs = [];

        $breadcrumbs[] = [
            'title' => 'Posts',
            'url' => route('admin.post.index'),
        ];

        $posts = Post::select([
            'id',
            'title',
            'is_enabled',
            'created_at',
            'user_id'
        ])->with('author:id,first_name,last_name');

        if (request()->query('search')) {
            $posts->where('title', 'like', '%' . request()->query('search') . '%');
        }

        return view('admin.post.index', [
            'breadcrumbs' => $breadcrumbs,
            'posts' => $posts->paginate(2),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $breadcrumbs = [];

        $breadcrumbs[] = [
            'title' => 'Posts',
            'url' => route('admin.post.index'),
        ];

        $breadcrumbs[] = [
            'title' => 'Add New Post',
            'url' => '',
        ];

        return view('admin.post.create', [
            'breadcrumbs' => $breadcrumbs
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|unique:posts|max:255',
            'short_description' => 'required|max:255',
            'description' => 'required',
            'featured_image' => 'required|mimes:jpeg,jpg,png',
            'status' => 'boolean|required',
        ]);

        $file = $request->file('featured_image');
        $name = $file->hashName();
        $extension = $file->extension();
        $filename = $name . "." . $extension;
        $slug = Str::slug($validated['title']);

        $request->file('featured_image')->storeAs('public', $filename);

        $post = Post::create([
            'title' => $validated['title'],
            'slug' => $slug,
            'short_description' => $validated['short_description'],
            'description' => $validated['description'],
            'featured_image' => $filename,
            'is_enabled' => $validated['status'],
            'user_id' => Auth::id()
        ]);

        return redirect(route('admin.post.index'))->with('status', 'Post created!');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $breadcrumbs = [];

        $breadcrumbs[] = [
            'title' => 'Posts',
            'url' => route('admin.post.index'),
        ];

        $breadcrumbs[] = [
            'title' => 'Edit Post',
            'url' => '',
        ];

        $post = Post::find($id);

        return view('admin.post.edit', [
            'post' => $post,
            'breadcrumbs' => $breadcrumbs,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $post = Post::find($id);

        $validated = $request->validate([
            'title' => [
                Rule::unique('posts')->ignore($post->id),
                'required',
                'max:255'
            ],
            'short_description' => 'required|max:255',
            'description' => 'required',
            'featured_image' => 'mimes:jpeg,jpg,png',
            'status' => 'boolean|required',
        ]);

        $slug = Str::slug($validated['title']);

        $post->title = $validated['title'];
        $post->slug = $slug;
        $post->short_description = $validated['short_description'];
        $post->description = $validated['description'];

        $post->is_enabled = $validated['status'];

        if ($request->has('featured_image')) {
            Storage::delete($post->featured_image);

            $file = $request->file('featured_image');
            $name = $file->hashName();
            $extension = $file->extension();
            $filename = $name . "." . $extension;

            $request->file('featured_image')->storeAs('public', $filename);

            $post->featured_image = $filename;
        }

        $post->save();

        return redirect(route('admin.post.index'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $post = Post::find($id);

        if ($post) {
            $post->delete();
        }

        return redirect()->back();
    }
}
