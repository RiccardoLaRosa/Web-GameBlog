<?php

namespace App\Http\Controllers;

use App\Models\Tag;
use App\Models\Post;
use App\Models\Category;
use App\Http\Requests\PostRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Routing\Controllers\HasMiddleware;

class PostController extends Controller implements HasMiddleware
{
    public static function middleware(): array {
        return [
            new Middleware(['auth', 'can:admin'], except: ['index', 'show', 'byCategory']),
        ];
    }

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
            $validated['image'] = $request->file('image')->store('uploads', 'public');
        }

        $validated['user_id'] = Auth::id();

        $post = Post::create($validated);

        $post->tags()->sync($validated['tag'] ?? []);

        return redirect()->back()->with('success', 'Post inserito correttamente!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Post $post)
    {
        $isSubscribed = Auth::check() && $post->subscribers()->where('user_id', Auth::id())->exists();
        return view('posts.show', compact('post','isSubscribed'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Post $post)
    {
        $categories = Category::all();
        $tags = Tag::all();
        return view('blog.edit', compact('post','categories','tags'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(PostRequest $request, Post $post)
    {
        $validated = $request->validated();
        unset($validated['image']);

        $oldImage = $post->image;
        $hasNewImage = $request->hasFile('image') && $request->file('image')->isValid();

        if ($hasNewImage) {
            $validated['image'] = $request->file('image')->store('uploads', 'public');
        }

        $post->update($validated);
        $post->tags()->sync($validated['tag'] ?? []);

        if ($hasNewImage && $oldImage) {
            Storage::disk('public')->delete($oldImage);
        }

        return redirect()->route('posts.show', $post)->with('success', 'Post modificato correttamente!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Post $post)
    {
        $image = $post->image;

        $post->delete();

        if ($image) {
            Storage::disk('public')->delete($image);
        }

        return redirect()->route('posts.index')->with('success', 'Post eliminato correttamente!');
    }

    public function byCategory(Category $category) {
        $posts = $category->posts()->get();
        return view('posts.filteredByCategory', compact('posts','category'));
    }
}
