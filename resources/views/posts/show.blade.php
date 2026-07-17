<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm font-semibold uppercase tracking-[0.3em] text-cyan-600">Blog</p>
                <h2 class="text-2xl font-semibold text-slate-900">Post Details</h2>
            </div>
            <a href="{{ route('post.index') }}" class="rounded-full border border-slate-200 bg-white px-4 py-2 text-sm font-medium text-slate-700 hover:bg-slate-50">
                Back to list
            </a>
        </div>
    </x-slot>

    <div class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">
        <div class="flex items-center justify-between">
            <div>
                <h3 class="text-2xl font-semibold text-slate-900">{{ $post->title }}</h3>
                <p class="mt-2 text-sm text-slate-500">Slug: {{ $post->slug }}</p>
            </div>
            <span class="rounded-full px-3 py-1 text-sm font-semibold {{ $post->status === 'published' ? 'bg-emerald-100 text-emerald-700' : 'bg-amber-100 text-amber-700' }}">
                {{ ucfirst($post->status) }}
            </span>
        </div>

        <div class="mt-6 grid gap-6 md:grid-cols-2">
            <div>
                <p class="text-sm font-semibold uppercase tracking-[0.2em] text-slate-400">Category</p>
                <p class="mt-2 text-lg font-semibold text-slate-900">{{ $post->category->name ?? 'Uncategorized' }}</p>
            </div>
            <div>
                <p class="text-sm font-semibold uppercase tracking-[0.2em] text-slate-400">Published At</p>
                <p class="mt-2 text-lg font-semibold text-slate-900">{{ $post->published_at ? 
                    	$post->published_at->format('d M Y, H:i') : 'Not published yet' }}</p>
            </div>
        </div>

        <div class="mt-8 border-t border-slate-200 pt-6">
            <p class="text-sm font-semibold uppercase tracking-[0.2em] text-slate-400">Excerpt</p>
            <div class="mt-2 text-base leading-7 text-slate-700">{!! $post->excerpt !!}</div>
        </div>

        <div class="mt-8 border-t border-slate-200 pt-6">
            <p class="text-sm font-semibold uppercase tracking-[0.2em] text-slate-400">Content</p>
            <div class="mt-2 text-base leading-7 text-slate-700">{!! $post->content !!}</div>
        </div>

        @if($post->featured_image)
            <div class="mt-8 border-t border-slate-200 pt-6">
                <p class="text-sm font-semibold uppercase tracking-[0.2em] text-slate-400">Featured Image</p>
                <img src="{{ env('DO_SPACES_URL') . '/' . $post->featured_image }}" alt="{{ $post->title }}" class="mt-4 h-48 w-auto rounded-xl object-cover">
            </div>
        @endif
    </div>
</x-app-layout>
