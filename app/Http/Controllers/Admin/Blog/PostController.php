<?php

namespace App\Http\Controllers\Admin\Blog;

use App\Http\Controllers\Controller;
use App\Models\Blog\Category;
use App\Models\Blog\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use RealRashid\SweetAlert\Facades\Alert;

class PostController extends Controller
{
    public function index()
    {
        $posts = Post::all();
        $data = [
            'posts' => $posts,
        ];
        return view('admin.blog.post.index', $data);
    }

    public function create()
    {
        $method = 'POST';
        $categories = Category::all();

        $data = [
            'method' => $method,
            'categories' => $categories,
        ];


        return view('admin.blog.post.create', $data);
    }

    public function store(Request $request)
    {

        // validate request
        //         "category": "4",
        // "title": "adasdsad",
        // "content": "<h1>dfsfsdfdsf</h1>",
        // "thumbnail": {}

        $request->validate([
            'category' => 'required|exists:blog_categories,id',
            'title' => 'required|string',
            'content' => 'required|string',
            'thumbnail' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);


        DB::beginTransaction();

        try {
            $post = new Post();
            $post->title = $request->title;
            $post->content = $request->content;
            $post->slug = \Str::slug($request->title . '-' . time());
            $post->user_id = auth()->id();
            $post->category_id = $request->category;
            $post->status = 'draft';
            $post->published_at = now();
            $post->views = 0;
            $post->likes = 0;
            $post->save();

            if ($request->hasFile('thumbnail')) {
                $post->addMediaFromRequest('thumbnail')->toMediaCollection('thumbnails');
            }


            DB::commit();
            return redirect()->route('admin.blog.post.index')->with('success', 'Post created successfully');
        } catch (\Exception $e) {
            DB::rollBack();
            if (app()->isProduction()) {
                return redirect()->back()->withInput($request->all());
            } else {
                return redirect()->back()->with('error', $e->getMessage());
            }
        }
    }
}
