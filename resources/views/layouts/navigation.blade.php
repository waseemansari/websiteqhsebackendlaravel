<nav x-data="{ open: false }" class="border-b border-slate-800 bg-slate-950 text-slate-100 lg:min-h-screen lg:w-72 lg:border-b-0 lg:border-r">
    <div class="flex items-center justify-between px-4 py-4 lg:px-6 lg:py-6">
        <a href="{{ route('dashboard') }}" class="flex items-center gap-3">
            <div class="flex h-11 w-11 items-center justify-center rounded-2xl bg-gradient-to-br from-cyan-400 to-blue-600 text-sm font-semibold text-white shadow-lg shadow-cyan-500/30">
                Q
            </div>
            <div>
                <p class="text-sm font-semibold tracking-wide">QHSE</p>
                <p class="text-xs text-slate-400">Admin Panel</p>
            </div>
        </a>

        <button @click="open = !open" class="rounded-xl border border-slate-800 p-2 text-slate-300 lg:hidden">
            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path x-show="!open" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                <path x-show="open" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
            </svg>
        </button>
    </div>

    <div :class="{ 'block': open, 'hidden': !open }" class="hidden px-4 pb-4 lg:block lg:px-6">
        @php
            $menuItems = [
                ['label' => 'Dashboard', 'route' => 'dashboard', 'icon' => 'M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001 1h3'],
                ['label' => 'FeedBack', 'url' => '/feedback', 'icon' => 'M5 8h14M5 8a2 2 0 012-2h10a2 2 0 012 2M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4'],
                ['label' => 'Users Register Course', 'url' => '/course-register', 'icon' => 'M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z'],
                ['label' => 'Contact with experts', 'url' => '/contact-us', 'icon' => 'M3 3h2l.5 2M7 13h10l4-8H5.5M7 13L5.5 5M7 13l-1.4 2.8a1 1 0 00.9 1.4h12.2'],
                [
                    'label' => 'Blogs',
                    'url' => '/post',
                    'icon' => 'M7 2a2 2 0 00-2 2v16a2 2 0 002 2h10a2 2 0 002-2V8l-6-6H7zm6 1.5L18.5 9H13V3.5zM8 12h8M8 16h8M8 20h5'
                ],
                [
                    'label' => 'Add New Blogs',
                    'url' => '/post/create',
                    'icon' => 'M7 2a2 2 0 00-2 2v16a2 2 0 002 2h10a2 2 0 002-2V8l-6-6H7zm6 1.5L18.5 9H13V3.5zM8 12h8M8 16h8M8 20h5M19 18v6M16 21h6'
                ],
                [
                    'label' => 'Newsletter Subscribers',
                    'url' => '/news-letters',
                    'icon' => 'M7 2a2 2 0 00-2 2v16a2 2 0 002 2h10a2 2 0 002-2V8l-6-6H7zm6 1.5L18.5 9H13V3.5zM8 12h8M8 16h8M8 20h5'
                ],
               
                [
                    'label' => 'Send Email Newsletter Subscribers',
                    'url' => '/news-letters/bulk',
                    'icon' => 'M7 2a2 2 0 00-2 2v16a2 2 0 002 2h10a2 2 0 002-2V8l-6-6H7zm6 1.5L18.5 9H13V3.5zM8 12h8M8 16h8M8 20h5'
                ],
            ];
        @endphp 

        <div class="space-y-2">
            @foreach ($menuItems as $item)
                @php
                    $active = isset($item['route']) && request()->routeIs($item['route']);
                    $href = $item['url'] ?? route($item['route']);
                @endphp

                <a href="{{ $href }}"
                   class="flex items-center gap-3 rounded-2xl px-4 py-3 text-sm font-medium transition {{ $active ? 'bg-white/15 text-white shadow-lg shadow-cyan-500/10' : 'text-slate-300 hover:bg-white/10 hover:text-white' }}">
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="{{ $item['icon'] }}" />
                    </svg>
                    <span>{{ __($item['label']) }}</span>
                </a>
            @endforeach
        </div>

      

        <div class="mt-8 border-t border-slate-800 pt-4">
            <div class="flex items-center gap-3 rounded-2xl bg-slate-900/70 p-3">
                <div class="flex h-10 w-10 items-center justify-center rounded-full bg-gradient-to-br from-amber-400 to-orange-500 text-sm font-semibold text-slate-950">
                    {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                </div>
                <div class="min-w-0">
                    <p class="truncate text-sm font-semibold text-white">{{ Auth::user()->name }}</p>
                    <p class="truncate text-xs text-slate-400">{{ Auth::user()->email }}</p>
                </div>
            </div>

            <div class="mt-3 space-y-2">
                <a href="{{ route('profile.edit') }}" class="flex items-center gap-2 rounded-xl px-3 py-2 text-sm text-slate-300 transition hover:bg-white/10 hover:text-white">
                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M5.121 17.121A3 3 0 016.879 16H17.12a3 3 0 01.758 1.121l.121.121H5zM12 12a4 4 0 100-8 4 4 0 000 8z" /></svg>
                    <span>{{ __('Profile') }}</span>
                </a>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="flex w-full items-center gap-2 rounded-xl px-3 py-2 text-left text-sm text-slate-300 transition hover:bg-white/10 hover:text-white">
                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a2 2 0 01-2 2H5a2 2 0 01-2-2V7a2 2 0 012-2h6a2 2 0 012 2v1" /></svg>
                        <span>{{ __('Log Out') }}</span>
                    </button>
                </form>
            </div>
        </div>
    </div>
</nav>
