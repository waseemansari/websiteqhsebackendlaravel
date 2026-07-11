<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="text-lg font-semibold">Edit Post</h2>
            <a href="{{ route('post.index') }}" class="text-sm text-cyan-600">Back to posts</a>
        </div>
    </x-slot>

    @if ($errors->any())
        <div class="mb-4 rounded-lg bg-red-50 p-4 text-red-700">
            <ul class="list-disc pl-5">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="overflow-hidden rounded-3xl border border-slate-200 bg-white p-6">
        <form action="{{ route('post.update', $post->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label class="block text-sm font-medium text-slate-700">Title</label>
                <input type="text" name="title" class="mt-1 w-full rounded border-gray-200" value="{{ old('title', $post->title) }}" required>
            </div>

            <div class="mb-3">
                <label class="block text-sm font-medium text-slate-700">Slug</label>
                <input type="text" name="slug" class="mt-1 w-full rounded border-gray-200" value="{{ old('slug', $post->slug) }}">
            </div>

            <div class="mb-3">
                <label class="block text-sm font-medium text-slate-700">Category</label>
                <select name="category_id" class="mt-1 w-full rounded border-gray-200">
                    <option value="">-- Select category --</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}" {{ old('category_id', $post->category_id) == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="mb-3">
                <label class="block text-sm font-medium text-slate-700">Tags (hold Ctrl/Cmd to select multiple)</label>
                <select name="tags[]" class="mt-1 w-full rounded border-gray-200" multiple>
                    @foreach($tags as $tag)
                        <option value="{{ $tag->id }}" {{ in_array($tag->id, old('tags', $selectedTags)) ? 'selected' : '' }}>{{ $tag->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="mb-3">
                <label class="block text-sm font-medium text-slate-700">Excerpt</label>
                <textarea name="excerpt" class="mt-1 w-full rounded border-gray-200">{{ old('excerpt', $post->excerpt) }}</textarea>
            </div>

            <div class="mb-3">
                <label class="block text-sm font-medium text-slate-700">Content</label>
                <textarea name="content" class="mt-1 w-full rounded border-gray-200" rows="6">{{ old('content', $post->content) }}</textarea>
            </div>

            <div class="mb-3">
                <label class="block text-sm font-medium text-slate-700">Featured image (file)</label>
                <input type="file" name="featured_image" accept="image/*" class="mt-1 w-full rounded border-gray-200">
                @if($post->featured_image)
                    <p class="mt-2 text-sm text-slate-500">Current image: {{ $post->featured_image }}</p>
                @endif
            </div>

            <div class="mb-3">
                <label class="block text-sm font-medium text-slate-700">Status</label>
                <select name="status" class="mt-1 w-full rounded border-gray-200">
                    <option value="draft" {{ old('status', $post->status) == 'draft' ? 'selected' : '' }}>Draft</option>
                    <option value="published" {{ old('status', $post->status) == 'published' ? 'selected' : '' }}>Published</option>
                </select>
            </div>

            <input type="hidden" name="branch_id" value="{{ old('branch_id', $post->branch_id) }}">

            <div class="mt-4">
                <button class="rounded bg-cyan-600 px-4 py-2 text-white">Update</button>
            </div>
        </form>
    </div>
</x-app-layout>
