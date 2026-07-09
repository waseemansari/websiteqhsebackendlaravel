<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-2 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <p class="text-sm font-semibold uppercase tracking-[0.3em] text-cyan-600">Overview</p>
                <h2 class="text-2xl font-semibold text-slate-900">{{ __('Dashboard') }}</h2>
            </div>
            <div class="rounded-full border border-slate-200 bg-slate-50 px-4 py-2 text-sm text-slate-600">
                {{ __('You\'re logged in!') }}
            </div>
        </div>
    </x-slot>
    @php
        
        $user = Auth::user();
        $branchId = $user->branch_id;
        $totalFeedbacks = \App\Models\FeedBack::where('branch_id', $branchId)->count();
        $totalCourse = \App\Models\CourseRegister::where('branch_id', $branchId)->count();
        $totalContacts = \App\Models\ContactUs::where('branch_id', $branchId)->count();

      
    @endphp
    <div class="space-y-6">
        <div class="grid gap-4 md:grid-cols-3">
            <div class="rounded-3xl border border-slate-200 bg-white p-5 shadow-sm">
                <p class="text-sm text-slate-500">Total Feedbacks</p>
                <p class="mt-2 text-3xl font-semibold text-slate-900">{{ $totalFeedbacks }}</p>
            </div>
            <div class="rounded-3xl border border-slate-200 bg-white p-5 shadow-sm">
                <p class="text-sm text-slate-500">Registered Users for course</p>
                <p class="mt-2 text-3xl font-semibold text-slate-900">{{ $totalCourse }}</p>
            </div>
            <div class="rounded-3xl border border-slate-200 bg-white p-5 shadow-sm">
                <p class="text-sm text-slate-500">Total Contact Messages</p>
                <p class="mt-2 text-3xl font-semibold text-slate-900">{{ $totalContacts }}</p>
            </div>
        </div>

        <div class="grid gap-6 xl:grid-cols-[1.5fr_0.9fr]">
            <div class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">
                <div class="flex items-center justify-between">
                    <h3 class="text-lg font-semibold text-slate-900">Recent Activity</h3>
                    <span class="rounded-full bg-cyan-50 px-3 py-1 text-sm text-cyan-700">Live</span>
                </div>
                <div class="mt-6 space-y-4">
                    <div class="flex items-center justify-between rounded-2xl bg-slate-50 px-4 py-3">
                        <div>
                            <p class="font-medium text-slate-900">New product added</p>
                            <p class="text-sm text-slate-500">5 minutes ago</p>
                        </div>
                        <span class="text-sm font-semibold text-emerald-600">+1</span>
                    </div>
                    <div class="flex items-center justify-between rounded-2xl bg-slate-50 px-4 py-3">
                        <div>
                            <p class="font-medium text-slate-900">User profile updated</p>
                            <p class="text-sm text-slate-500">1 hour ago</p>
                        </div>
                        <span class="text-sm font-semibold text-blue-600">Updated</span>
                    </div>
                    <div class="flex items-center justify-between rounded-2xl bg-slate-50 px-4 py-3">
                        <div>
                            <p class="font-medium text-slate-900">Report exported</p>
                            <p class="text-sm text-slate-500">Today</p>
                        </div>
                        <span class="text-sm font-semibold text-violet-600">Ready</span>
                    </div>
                </div>
            </div>

            <div class="rounded-3xl border border-slate-200 bg-gradient-to-br from-slate-900 to-slate-700 p-6 text-white shadow-sm">
                <p class="text-sm text-slate-300">Performance</p>
                <p class="mt-2 text-3xl font-semibold">94%</p>
                <p class="mt-3 text-sm text-slate-300">Your workspace is healthy and running smoothly.</p>
            </div>
        </div>
    </div>
</x-app-layout>
