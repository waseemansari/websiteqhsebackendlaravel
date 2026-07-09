<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-2 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <p class="text-sm font-semibold uppercase tracking-[0.3em] text-cyan-600">Feedback</p>
                <h2 class="text-2xl font-semibold text-slate-900">Customer Feedback</h2>
            </div>
            <div class="rounded-full border border-slate-200 bg-slate-50 px-4 py-2 text-sm text-slate-600">
                {{ $feedbacks->count() }} total records
            </div>
        </div>
    </x-slot>

    <div class="overflow-hidden rounded-3xl border border-slate-200 bg-white shadow-sm">
        <div class="flex flex-col gap-3 border-b border-slate-200 px-6 py-4 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <h3 class="text-lg font-semibold text-slate-900">Recent Feedback</h3>
                <p class="mt-1 text-sm text-slate-500">Showing feedback submitted by learners and customers.</p>
            </div>
            <div class="w-full sm:w-72">
                <label for="feedback-search" class="sr-only">Search feedback</label>
                <div class="relative">
                    <input id="feedback-search" type="text" placeholder="Search by name, email, course..." class="w-full rounded-2xl border border-slate-200 bg-slate-50 px-4 py-2.5 pr-10 text-sm text-slate-700 outline-none ring-0 transition focus:border-cyan-400 focus:bg-white" />
                    <svg class="pointer-events-none absolute right-3 top-2.5 h-5 w-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-4.35-4.35m0 0A7.5 7.5 0 104.5 4.5a7.5 7.5 0 0012.15 12.15z" />
                    </svg>
                </div>
            </div>
        </div>

        @if($feedbacks->isEmpty())
            <div class="px-6 py-12 text-center text-slate-500">
                No feedback found yet.
            </div>
        @else
            <div class="overflow-x-auto">
                <table id="feedback-table" class="min-w-full divide-y divide-slate-200">
                    <thead class="bg-slate-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider text-slate-500">Name</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider text-slate-500">Email</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider text-slate-500">Phone</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider text-slate-500">Course Start Date</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider text-slate-500">Trainer</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider text-slate-500">Status</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider text-slate-500">Action</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 bg-white">
                        @foreach($feedbacks as $feedback)
                        
                            <tr class="hover:bg-slate-50 @if($feedback->status == 'new') font-black text-8xl text-emerald-600 @endif">
                                <td class="whitespace-nowrap px-6 py-4 text-sm font-medium text-slate-900">
                                    {{ $feedback->first_name }} {{ $feedback->last_name }}
                                </td>
                                <td class="whitespace-nowrap px-6 py-4 text-sm text-slate-600">{{ $feedback->email }}</td>
                                 <td class="whitespace-nowrap px-6 py-4 text-sm text-slate-600">{{ $feedback->phone }}</td>
                                <td class="whitespace-nowrap px-6 py-4 text-sm text-slate-600">{{ $feedback->course }}</td>
                                <td class="whitespace-nowrap px-6 py-4 text-sm text-slate-600">{{ $feedback->trainer }}</td>
                                
                                <td class="whitespace-nowrap px-6 py-4 text-sm">
                                    <span class="rounded-full px-3 py-1 text-xs font-semibold {{ $feedback->status === 'readed' ? 'bg-emerald-100 text-emerald-700' : 'bg-amber-100 text-amber-700' }}">
                                        {{ ucfirst($feedback->status ?? 'new') }}
                                    </span>
                                </td>
                                <td class="whitespace-nowrap px-6 py-4 text-sm font-medium">
                                    <a href="{{ route('feedback.show', $feedback->id) }}" class="text-cyan-600 hover:text-cyan-700">
                                        View
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>

    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                const searchInput = document.getElementById('feedback-search');
                const table = document.getElementById('feedback-table');

                if (!table || !searchInput) return;

                const rows = Array.from(table.querySelectorAll('tbody tr'));

                searchInput.addEventListener('input', function () {
                    const query = this.value.toLowerCase().trim();

                    rows.forEach((row) => {
                        const text = row.textContent.toLowerCase();
                        row.style.display = text.includes(query) ? '' : 'none';
                    });
                });
            });
        </script>
    @endpush
</x-app-layout>
