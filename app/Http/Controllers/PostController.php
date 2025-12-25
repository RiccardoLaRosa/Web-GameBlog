<?php

namespace App\Http\Controllers;

use App\Models\Tag;
use App\Models\Post;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Requests\PostRequest;
use Illuminate\Support\Facades\Auth;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index() {
        $tags=Tag::all();
        $posts=Post::orderBy('created_at','desc')->paginate(10);
        return view('posts.index', compact('posts','tags'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create() {
        $categories = Category::all();
        $tags = Tag::all();
        return view('blog.create', compact('categories','tags'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(PostRequest $request) {
        $validated = $request->validated();
        if ($request->hasFile('image') && $request->file('image')->isValid()) {
            $path = $request->file('image')->store('uploads','public');
            $validated['image'] = $path; }
        $post=Post::create($validated);
        $post->category_id = $request->category_id;
        // auth()->user()->posts()->associate($post);
        $post->user_id = Auth::user()->id;
        if($request->tag) {
            $post->tags()->attach($request->tag);
        }
        $post->save();
        return redirect()->back()->with('success', 'Post inserito correttamente!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Post $post)
    {
        return view('blog.show');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Post $post)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Post $post)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Post $post)
    {
        //
    }

    public function byCategory(Category $category) {
        $posts = $category->posts()->get();
        return view('posts.filteredByCategory', compact('posts','category'));
    }
}
