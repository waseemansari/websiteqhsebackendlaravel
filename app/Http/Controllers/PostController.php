<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Category;
use App\Models\{Tag,PostTag};
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

    private function syncTags(Post $post, array $tagInput = []): void
    {
        $tagIds = [];

        foreach ($tagInput as $tagValue) {
            if (is_numeric($tagValue)) {
                $tagIds[] = (int) $tagValue;
                continue;
            }

            if (is_string($tagValue) && trim($tagValue) !== '') {
                $tag = Tag::firstOrCreate(
                    ['slug' => Str::slug($tagValue)],
                    ['name' => $tagValue]
                );
                $tagIds[] = $tag->id;
            }
        }

        $post->tags()->sync($tagIds);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $branchId = Auth::user()->branch_id;
        $categories = Category::orderBy('name')->get();
        $tags = Tag::where('branch_id', $branchId)->orderBy('name')->get();
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
            'meta_keywords' => 'nullable|string',
            'status' => 'required|in:draft,published',
            'published_at' => 'nullable|date',
            'category_id' => 'required|exists:categories,id',
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

        $this->syncTags($post, $request->input('tags', []));

        return redirect()->route('post.index')->with('success', 'Post created');
    }

    /**
     * Display the specified resource.
     */
    public function show(Post $post)
    {
        return view('posts.show', compact('post'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Post $post)
    {
        if (Auth::check() && Auth::user()->branch_id && $post->branch_id !== Auth::user()->branch_id) {
            abort(403);
        }

        $categories = Category::orderBy('name')->get();
        $tags = Tag::orderBy('name')->get();
        $selectedTags = $post->tags()->pluck('tags.id')->toArray();

        return view('posts.edit', compact('post', 'categories', 'tags', 'selectedTags'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Post $post)
    {
        if (Auth::check() && Auth::user()->branch_id && $post->branch_id !== Auth::user()->branch_id) {
            abort(403);
        }

        $data = $request->validate([
            'title' => 'required|string|max:255',
            'slug' => ['nullable', 'string', 'max:255', 'unique:posts,slug,' . $post->id],
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

        $data['branch_id'] = Auth::user()->branch_id ?? $post->branch_id;

        if ($request->hasFile('featured_image')) {
            $data['featured_image'] = ImageUploadHelper::uploadAndResize($request->file('featured_image'), 'blogs', 200, 200);
        }

        $post->update($data);
        $this->syncTags($post, $request->input('tags', []));

        return redirect()->route('post.index')->with('success', 'Post updated');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        Post::where('id', $id)->delete();
        PostTag::where('post_id', $id)->delete();
        return redirect()->route('post.index')->with('success', 'Post deleted');    
    }

    public function ApiGetBlogPosts(Request $request)
    {
        $branchId = $request->query('branch');
        $posts = Post::when($branchId, function ($query) use ($branchId) {
                $query->where('branch_id', $branchId);
            })
            ->where('status', 'published')
            ->with(['category', 'tags'])
            ->orderBy('published_at', 'desc')
            ->get();

        return response()->json([
            'blog'=>$posts,
            'status'=>200,
            'message'=>'Blogs List'
        ]);
    }

    public function ApiGetSingleBlogPost($id)
    {
        
        $post = Post::where('status', 'published')
            ->with(['category', 'tags'])
            ->orderBy('published_at', 'desc')
            ->first();

        return response()->json([
            'blog'=>$post,
            'status'=>200,
            'message'=>'Single Blog Post'
        ]);
    }
}
