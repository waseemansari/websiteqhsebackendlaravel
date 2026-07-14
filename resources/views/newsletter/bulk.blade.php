<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm font-semibold uppercase tracking-[0.3em] text-cyan-600">Newsletter</p>
                <h2 class="text-2xl font-semibold text-slate-900">Send Bulk Email</h2>
            </div>
            <a href="{{ route('news-letters.index') }}" class="rounded-full border border-slate-200 bg-white px-4 py-2 text-sm font-medium text-slate-700 hover:bg-slate-50">
                Back to subscribers
            </a>
        </div>
    </x-slot>

    <div class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">
        @if(session('success'))
            <div class="mb-6 rounded-2xl border border-emerald-100 bg-emerald-50 p-4 text-sm text-emerald-700">
                {{ session('success') }}
            </div>
        @endif

        <form method="POST" action="{{ route('news-letters.bulk.send') }}" class="space-y-6">
            @csrf

            <div>
                <label for="subject" class="block text-sm font-semibold text-slate-700">Subject</label>
                <input id="subject" name="subject" type="text" value="{{ old('subject') }}" class="mt-2 w-full rounded-2xl border border-slate-200 bg-slate-50 px-4 py-2 text-sm text-slate-700 outline-none focus:border-cyan-400 focus:bg-white" />
                @error('subject')
                    <p class="mt-2 text-sm text-rose-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="message" class="block text-sm font-semibold text-slate-700">Message</label>
                <textarea id="message" name="message" rows="8" class="mt-2 w-full rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm text-slate-700 outline-none focus:border-cyan-400 focus:bg-white">{{ old('message') }}</textarea>
                @error('message')
                    <p class="mt-2 text-sm text-rose-600">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex justify-end">
                <button type="submit" class="inline-flex items-center justify-center rounded-2xl bg-cyan-600 px-5 py-2.5 text-sm font-semibold text-white transition hover:bg-cyan-700">
                    Send bulk email
                </button>
            </div>
        </form>
    </div>
</x-app-layout>
