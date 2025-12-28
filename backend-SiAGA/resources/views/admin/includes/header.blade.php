<header
    class="flex h-20 w-full items-center justify-between border-b border-slate-200 bg-surface-light px-6 dark:border-[#21284a] dark:bg-[#101323]">
    <!-- Breadcrumbs -->
    <div class="flex items-center gap-2">
        <a class="text-sm font-medium text-slate-500 hover:text-primary dark:text-[#8e99cc]"
            href="{{ route('admin.dashboard') }}">Dashboard</a>
        @yield('breadcrumbs')
    </div>
    <!-- Right Actions: Notifications & Profile -->
    <div class="flex items-center gap-4">
        <button
            class="relative flex size-10 items-center justify-center rounded-full text-slate-500 hover:bg-slate-100 dark:text-[#8e99cc] dark:hover:bg-[#21284a]">
            <span class="material-symbols-outlined">notifications</span>
            <span
                class="absolute right-2 top-2 size-2.5 rounded-full bg-red-500 border-2 border-white dark:border-[#101323]"></span>
        </button>
        <div class="h-8 w-px bg-slate-200 dark:bg-[#21284a]"></div>
        <div class="flex items-center gap-3">
            <div class="text-right hidden sm:block">
                <p class="text-sm font-bold text-slate-900 dark:text-white">
                    {{ auth()->user()->name }}
                </p>
                <p class="text-xs text-slate-500 dark:text-[#8e99cc]">
                    {{ ucfirst(auth()->user()->role) }}
                </p>
            </div>
            <div class="size-10 overflow-hidden rounded-full bg-slate-200 dark:bg-[#21284a]">
                <img alt="Profile Avatar" class="h-full w-full object-cover"
                    data-alt="User profile avatar of Budi Santoso"
                    src="https://lh3.googleusercontent.com/aida-public/AB6AXuChQ7BV4qYRL89njwz8fEcWvVeu71lT0xQ2fRhsHO168Edc-nfofc4fINuprUkrdo9XxjUFcTFWbvUoZoWALFzgw_B-XqH0cuTXojbwamHzCb_cSHO-Zzoek6B6189_dcFMSb3s_mwC4zcOSQNTExjUz30ES4iem9pUJ8DrNQKLqpKM7pF3x9-0XdgPCsLxmpZJOlWnh2PKQ1GvM80X_EdWKbQRU3AmPSsETS0qtFokPJ0ubXpEM0kL1N_TPug4jvMOCYBZ0gaMr8wB" />
            </div>
            <span class="material-symbols-outlined text-slate-400 dark:text-[#566088] cursor-pointer">expand_more</span>
        </div>
    </div>
</header>
