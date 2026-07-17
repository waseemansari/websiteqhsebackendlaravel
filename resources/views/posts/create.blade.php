<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="text-lg font-semibold">Create Post</h2>
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
        <form action="{{ route('post.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="mb-3">
                <label class="block text-sm font-medium text-slate-700">Title</label>
                <input type="text" name="title" class="mt-1 w-full rounded border-gray-200" value="{{ old('title') }}" required>
            </div>

            <div class="mb-3">
                <label class="block text-sm font-medium text-slate-700">Slug</label>
                <input type="text" name="slug" class="mt-1 w-full rounded border-gray-200" value="{{ old('slug') }}">
            </div>

            <div class="mb-3">
                <label class="block text-sm font-medium text-slate-700">Category</label>
                <select name="category_id" class="mt-1 w-full rounded border-gray-200">
                    <option value="">-- Select category --</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="mb-3">
                <label class="block text-sm font-medium text-slate-700">Tags (hold Ctrl/Cmd to select multiple)</label>
                <select name="tags[]" class="mt-1 w-full rounded border-gray-200" multiple>
                    @foreach($tags as $tag)
                        <option value="{{ $tag->id }}" {{ in_array($tag->id, old('tags', [])) ? 'selected' : '' }}>{{ $tag->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="mb-3">
                <label class="block text-sm font-medium text-slate-700">Excerpt</label>
                <textarea name="excerpt" id="excerpt" class="mt-1 w-full rounded border-gray-200" rows="6">{{ old('excerpt') }}</textarea>
            </div>

            <div class="mb-3">
                <label class="block text-sm font-medium text-slate-700">Content</label>
                <textarea id="content" name="content" class="mt-1 w-full rounded border-gray-200" rows="16">{{ old('content') }}</textarea>
            </div>

            <div class="mb-3">
                <label class="block text-sm font-medium text-slate-700">Featured image (file)</label>
                <input type="file" name="featured_image" accept="image/*" class="mt-1 w-full rounded border-gray-200">
            </div>
            
            <div class="mb-3">
                <label class="block text-sm font-medium text-slate-700">Meta title</label>
                <input type="text" name="meta_title" class="mt-1 w-full rounded border-gray-200" value="{{ old('meta_title') }}">
            </div>
            <div class="mb-3">
                <label class="block text-sm font-medium text-slate-700">Meta description</label>
                <textarea  name="meta_description" class="mt-1 w-full rounded border-gray-200">{{ old('meta_description') }}</textarea>
                
            </div>
            <div class="mb-3">
                <label class="block text-sm font-medium text-slate-700">Meta Keywords</label>
                <input type="text" name="meta_keywords" class="mt-1 w-full rounded border-gray-200" value="{{ old('meta_keywords') }}">
            </div>
            <div class="mb-3">
                <label class="block text-sm font-medium text-slate-700">Status</label>
                <select name="status" class="mt-1 w-full rounded border-gray-200">
                    <option value="draft" {{ old('status') == 'draft' ? 'selected' : '' }}>Draft</option>
                    <option value="published" {{ old('status') == 'published' ? 'selected' : '' }}>Published</option>
                </select>
            </div>

            <input type="hidden" name="branch_id" value="1">

            <div class="mt-4">
                <button class="rounded bg-cyan-600 px-4 py-2 text-white">Create</button>
            </div>
        </form>
    </div>

    @push('scripts')

<script src="https://cdn.tiny.cloud/1/jh3wxkkytapr4l9oso0n0rvslmc08exbtavrbpubb86dm89g/tinymce/7/tinymce.min.js" referrerpolicy="origin"></script>
<script>
document.addEventListener("DOMContentLoaded", function () {

    tinymce.init({
        selector: '#excerpt, #content',

        height: 400,

        menubar: true,

        plugins: [
            'advlist',
            'autolink',
            'lists',
            'link',
            'image',
            'charmap',
            'preview',
            'anchor',
            'searchreplace',
            'visualblocks',
            'code',
            'fullscreen',
            'insertdatetime',
            'media',
            'table',
            'help',
            'wordcount'
        ],

        toolbar:
            'undo redo | ' +
            'blocks | ' +
            'bold italic underline | ' +
            'alignleft aligncenter alignright alignjustify | ' +
            'bullist numlist | ' +
            'link image media | ' +
            'table | ' +
            'code',

        toolbar_mode: 'wrap',

        content_style: `
            body {
                font-family: Arial, sans-serif;
                font-size: 16px;
            }
        `

    });

});
</script>

@endpush
</x-app-layout>
 