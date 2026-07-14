<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm font-semibold uppercase tracking-[0.3em] text-cyan-600">Newsletter</p>
                <h2 class="text-2xl font-semibold text-slate-900">Subscriber Details</h2>
            </div>
            <a href="{{ route('news-letters.index') }}" class="rounded-full border border-slate-200 bg-white px-4 py-2 text-sm font-medium text-slate-700 hover:bg-slate-50">
                Back to list
            </a>
        </div>
    </x-slot>

    <div class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">
        <div class="grid gap-6 md:grid-cols-2">
            <div>
                <p class="text-sm font-semibold uppercase tracking-[0.2em] text-slate-400">Name</p>
                <p class="mt-2 text-lg font-semibold text-slate-900">{{ $subscriber->name ?? '—' }}</p>
            </div>
            <div>
                <p class="text-sm font-semibold uppercase tracking-[0.2em] text-slate-400">Email</p>
                <p class="mt-2 text-lg font-semibold text-slate-900">{{ $subscriber->email }}</p>
            </div>
            <div>
                <p class="text-sm font-semibold uppercase tracking-[0.2em] text-slate-400">Status</p>
                <span class="mt-2 inline-flex rounded-full px-3 py-1 text-sm font-semibold {{ $subscriber->status === 'subscribed' ? 'bg-emerald-100 text-emerald-700' : ($subscriber->status === 'unsubscribed' ? 'bg-rose-100 text-rose-700' : 'bg-amber-100 text-amber-700') }}">
                    {{ ucfirst($subscriber->status ?? 'pending') }}
                </span>
            </div>
            <div>
                <p class="text-sm font-semibold uppercase tracking-[0.2em] text-slate-400">Source</p>
                <p class="mt-2 text-lg font-semibold text-slate-900">{{ $subscriber->source ?? 'website' }}</p>
            </div>
            <div>
                <p class="text-sm font-semibold uppercase tracking-[0.2em] text-slate-400">IP Address</p>
                <p class="mt-2 text-lg font-semibold text-slate-900">{{ $subscriber->ip_address ?? '—' }}</p>
            </div>
            <div>
                <p class="text-sm font-semibold uppercase tracking-[0.2em] text-slate-400">Verified At</p>
                <p class="mt-2 text-lg font-semibold text-slate-900">{{ $subscriber->verified_at?->format('F j, Y H:i') ?? 'Not verified' }}</p>
            </div>
        </div>

        <div class="mt-8 border-t border-slate-200 pt-6">
            <h3 class="text-lg font-semibold text-slate-900">Update Subscriber Status</h3>

            @if(session('success'))
                <div class="mt-4 rounded-2xl border border-emerald-100 bg-emerald-50 px-4 py-3 text-sm text-emerald-700">
                    {{ session('success') }}
                </div>
            @endif

            <form method="POST" action="{{ route('news-letters.update', $subscriber->id) }}" class="mt-6 space-y-6">
                @csrf
                @method('PATCH')

                <div class="grid gap-6 md:grid-cols-2">
                    <div>
                        <label for="name" class="block text-sm font-semibold text-slate-700">Name</label>
                        <input id="name" name="name" type="text" value="{{ old('name', $subscriber->name) }}" class="mt-2 w-full rounded-2xl border border-slate-200 bg-slate-50 px-4 py-2 text-sm text-slate-700 outline-none focus:border-cyan-400 focus:bg-white" />
                        @error('name')
                            <p class="mt-2 text-sm text-rose-600">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label for="status" class="block text-sm font-semibold text-slate-700">Status</label>
                        <select id="status" name="status" class="mt-2 w-full rounded-2xl border border-slate-200 bg-slate-50 px-4 py-2 text-sm text-slate-700 outline-none focus:border-cyan-400 focus:bg-white">
                            <option value="pending" {{ old('status', $subscriber->status) === 'pending' ? 'selected' : '' }}>Pending</option>
                            <option value="subscribed" {{ old('status', $subscriber->status) === 'subscribed' ? 'selected' : '' }}>Subscribed</option>
                            <option value="unsubscribed" {{ old('status', $subscriber->status) === 'unsubscribed' ? 'selected' : '' }}>Unsubscribed</option>
                        </select>
                        @error('status')
                            <p class="mt-2 text-sm text-rose-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="flex items-center justify-end gap-3">
                    <button type="submit" class="inline-flex items-center justify-center rounded-2xl bg-cyan-600 px-5 py-2.5 text-sm font-semibold text-white transition hover:bg-cyan-700">
                        Save changes
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
