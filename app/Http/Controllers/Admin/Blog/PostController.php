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

        $views = $posts->sum('views');
        $total_post = $posts->count();
        $published = $posts->where('status', 'published')->count();
        $drafts = $posts->where('status', 'draft')->count();

        $data = [
            'posts' => $posts,
            'views' => $views,
            'total_post' => $total_post,
            'published' => $published,
            'drafts' => $drafts,
        ];
        return view('admin.blog.post.index', $data);
    }

    public function create()
    {
        $categories = Category::all();

        $data = [
            'categories' => $categories,
        ];


        return view('admin.blog.post.create', $data);
    }

    public function store(Request $request)
    {


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

    public function edit(Post $post)
    {
        $categories = Category::all();

        $data = [
            'post' => $post,
            'categories' => $categories,
        ];

        return view('admin.blog.post.edit', $data);
    }

    public function update(Request $request, Post $post)
    {
        // validate request
        $request->validate([
            'category' => 'required|exists:blog_categories,id',
            'title' => 'required|string',
            'content' => 'required|string',
            'thumbnail' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        DB::beginTransaction();

        try {
            $post->title = $request->title;
            $post->content = $request->content;
            $post->slug = \Str::slug($request->title . '-' . time());
            $post->category_id = $request->category;
            $post->status = 'draft';
            $post->published_at = now();
            $post->save();

            if ($request->hasFile('thumbnail')) {
                $post->clearMediaCollection('thumbnails');
                $post->addMediaFromRequest('thumbnail')->toMediaCollection('thumbnails');
            }

            DB::commit();
            return redirect()->route('admin.blog.post.index')->with('success', 'Post updated successfully');
        } catch (\Exception $e) {
            DB::rollBack();
            if (app()->isProduction()) {
                return redirect()->back()->withInput($request->all());
            } else {
                return redirect()->back()->with('error', $e->getMessage());
            }
        }
    }

    // delete
    public function destroy(Post $post)
    {
        DB::beginTransaction();

        try {
            $post->clearMediaCollection('thumbnails');
            $post->delete();
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            if (app()->isProduction()) {
                return redirect()->back()->with('error', 'An error occurred while deleting the post.');
            } else {
                return redirect()->back()->with('error', $e->getMessage());
            }
        }
        return redirect()->route('admin.blog.post.index')->with('success', 'Post deleted successfully');
    }

    // Route::get('/publish/{post}', [PostController::class, 'publish'])->name('publish');

    public function publish(Post $post)
    {
        DB::beginTransaction();

        try {
            if ($post->status === 'published') {
                $post->status = 'draft';
                $message = 'Post unpublished successfully';
            } else {
                $post->status = 'published';
                $post->published_at = now();
                $message = 'Post published successfully';
            }
            $post->save();
            DB::commit();
            return redirect()->route('admin.blog.post.index')->with('success', $message);
        } catch (\Exception $e) {
            DB::rollBack();
            if (app()->isProduction()) {
                return redirect()->back()->with('error', 'An error occurred while publishing the post.');
            } else {
                return redirect()->back()->with('error', $e->getMessage());
            }
        }
    }
}
