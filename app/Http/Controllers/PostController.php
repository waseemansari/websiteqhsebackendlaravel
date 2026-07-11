<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Category;
use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Auth;
use App\Helpers\ImageUploadHelper;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
         $posts = Post::where('branch_id', Auth::user()->branch_id)->with(['category',])
            ->orderBy('created_at','desc')
            ->get();
         return view('posts.index', compact('posts'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::orderBy('name')->get();
        $tags = Tag::orderBy('name')->get();
        return view('posts.create', compact('categories','tags'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:posts,slug',
            'excerpt' => 'nullable|string',
            'content' => 'required',
            'featured_image' => 'nullable|file|image|max:2048',
            'meta_title' => 'nullable|string',
            'meta_description' => 'nullable|string',
            'status' => 'required|in:draft,published',
            'published_at' => 'nullable|date',
            'category_id' => 'nullable|exists:categories,id',
            'tags' => 'nullable|array',
            'tags.*' => 'nullable',
            'branch_id' => 'nullable|string'
        ]);

        if (empty($data['slug'])) {
            $data['slug'] = Str::slug($data['title']);
        }

        $data['branch_id'] = Auth::user()->branch_id ?? null;

        // handle uploaded image file
         if ($request->hasFile('featured_image')) {
            $url = ImageUploadHelper::uploadAndResize($request->file('featured_image'), 'blogs', 200, 200);
            $data['featured_image'] = $url;
        }
        

        $post = Post::create($data);

        // handle tags: accept ids or names
        $tagInput = $request->input('tags', []);
        $tagIds = [];
        foreach ($tagInput as $t) {
            if (is_numeric($t)) {
                $tagIds[] = (int)$t;
                continue;
            }
            if (is_string($t) && trim($t) !== '') {
                $tag = Tag::firstOrCreate(
                    ['slug' => Str::slug($t)],
                    ['name' => $t]
                );
                $tagIds[] = $tag->id;
            }
        }

        if (!empty($tagIds)) {
            $post->tags()->sync($tagIds);
        }

        return redirect()->route('post.index')->with('success', 'Post created');
    }

    /**
     * Display the specified resource.
     */
    public function show(Post $post)
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
}
