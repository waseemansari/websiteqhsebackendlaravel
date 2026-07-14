<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm font-semibold uppercase tracking-[0.3em] text-cyan-600">Newsletter</p>
                <h2 class="text-2xl font-semibold text-slate-900">Unsubscribed</h2>
            </div>
            <a href="{{ route('news-letters.index') }}" class="rounded-full border border-slate-200 bg-white px-4 py-2 text-sm font-medium text-slate-700 hover:bg-slate-50">
                Back to subscribers
            </a>
        </div>
    </x-slot>

    <div class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">
        <div class="text-center">
            <h3 class="text-xl font-semibold text-slate-900">You have been unsubscribed</h3>
            <p class="mt-4 text-sm text-slate-500">{{ $subscriber->email }} will no longer receive newsletter emails.</p>
            <p class="mt-4 text-sm text-slate-500">If this was a mistake, please contact support.</p>
        </div>
    </div>
</x-app-layout>
