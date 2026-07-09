<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm font-semibold uppercase tracking-[0.3em] text-cyan-600">Feedback</p>
                <h2 class="text-2xl font-semibold text-slate-900">Feedback Details</h2>
            </div>
            <a href="{{ route('feedback.index') }}" class="rounded-full border border-slate-200 bg-white px-4 py-2 text-sm font-medium text-slate-700 hover:bg-slate-50">
                Back to list
            </a>
        </div>
    </x-slot>

    <div class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">
        <div class="grid gap-6 md:grid-cols-2">
            <div>
                <p class="text-sm font-semibold uppercase tracking-[0.2em] text-slate-400">Name</p>
                <p class="mt-2 text-lg font-semibold text-slate-900">{{ $feedBack->first_name }} {{ $feedBack->last_name }}</p>
            </div>
            <div>
                <p class="text-sm font-semibold uppercase tracking-[0.2em] text-slate-400">Email</p>
                <p class="mt-2 text-lg font-semibold text-slate-900">{{ $feedBack->email }}</p>
            </div>
            <div>
                <p class="text-sm font-semibold uppercase tracking-[0.2em] text-slate-400">Phone</p>
                <p class="mt-2 text-lg font-semibold text-slate-900">{{ $feedBack->phone }}</p>
            </div>
            <div>
                <p class="text-sm font-semibold uppercase tracking-[0.2em] text-slate-400">Course</p>
                <p class="mt-2 text-lg font-semibold text-slate-900">{{ $feedBack->course }}</p>
            </div>
            <div>
                <p class="text-sm font-semibold uppercase tracking-[0.2em] text-slate-400">Trainer</p>
                <p class="mt-2 text-lg font-semibold text-slate-900">{{ $feedBack->trainer }}</p>
            </div>
            <div>
                <p class="text-sm font-semibold uppercase tracking-[0.2em] text-slate-400">Profession</p>
                <p class="mt-2 text-lg font-semibold text-slate-900">{{ $feedBack->profession }}</p>
            </div>
        </div>

        <div class="mt-8 border-t border-slate-200 pt-6">
            <p class="text-sm font-semibold uppercase tracking-[0.2em] text-slate-400">Comments</p>
            <p class="mt-2 text-base leading-7 text-slate-700">{{ $feedBack->comments }}</p>
        </div>

        <div class="mt-8 border-t border-slate-200 pt-6">
            <div class="flex items-center justify-between">
                <h3 class="text-lg font-semibold text-slate-900">Feedback Answers</h3>
                <span class="rounded-full bg-slate-100 px-3 py-1 text-sm text-slate-600">{{ $answers->count() }} items</span>
            </div>

            @if($answers->isEmpty())
                <p class="mt-4 text-sm text-slate-500">No answers were submitted for this feedback.</p>
            @else
                <div class="mt-4 overflow-hidden rounded-2xl border border-slate-200">
                    <table class="min-w-full divide-y divide-slate-200">
                        <thead class="bg-slate-50">
                            <tr>
                                <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider text-slate-500">Question</th>
                                <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider text-slate-500">Answer</th>
                                <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider text-slate-500">Status</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100 bg-white">
                            @foreach($answers as $answer)
                                <tr>
                                    <td class="px-4 py-3 text-sm font-medium text-slate-900">Question {{ $answer->question_no }}</td>
                                    <td class="px-4 py-3 text-sm text-slate-700">{{ $answer->answer }}</td>
                                    <td class="px-4 py-3 text-sm">
                                        <span class="rounded-full px-3 py-1 text-xs font-semibold {{ $answer->status === 'readed' ? 'bg-emerald-100 text-emerald-700' : 'bg-amber-100 text-amber-700' }}">
                                            {{ ucfirst($answer->status ?? 'new') }}
                                        </span>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
