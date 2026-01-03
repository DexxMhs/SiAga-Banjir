<!-- Sidebar -->
<aside
    class="w-64 h-full flex flex-col border-r border-slate-200 dark:border-slate-800 bg-white dark:bg-[#151a30] shrink-0 transition-all duration-300 hidden md:flex">
    <div class="p-6 flex items-center gap-3">
        <div class="bg-primary/10 p-2 rounded-lg">
            <span class="material-symbols-outlined text-primary text-3xl">water_drop</span>
        </div>
        <div>
            <h1 class="text-lg font-bold leading-none tracking-tight">
                SiAGA Banjir
            </h1>
            <p class="text-xs text-slate-500 dark:text-slate-400 mt-1">
                Admin Panel
            </p>
        </div>
    </div>
    <nav class="flex-1 overflow-y-auto px-3 py-4 flex flex-col gap-1">
        <!-- Active Item -->
        <a class="@if (Request::segment(1) == 'dashboard') flex items-center gap-3 px-3 py-3 rounded-lg bg-primary text-white shadow-lg shadow-primary/30 @else flex items-center gap-3 px-3 py-3 rounded-lg text-slate-600 dark:text-[#8e99cc] hover:bg-slate-100 dark:hover:bg-surface-dark transition-colors group @endif "
            href="{{ route('admin.dashboard') }}">
            <span class="material-symbols-outlined group-hover:text-primary fill-1">dashboard</span>
            <span class="text-sm font-medium">Dashboard</span>
        </a>
        <!-- Inactive Items -->
        <a class="@if (Request::segment(1) == 'stations') flex items-center gap-3 px-3 py-3 rounded-lg bg-primary text-white shadow-lg shadow-primary/30 @else flex items-center gap-3 px-3 py-3 rounded-lg text-slate-600 dark:text-[#8e99cc] hover:bg-slate-100 dark:hover:bg-surface-dark transition-colors group @endif"
            href="{{ route('stations.index') }}">
            <span class="material-symbols-outlined group-hover:text-primary transition-colors">location_on</span>
            <span class="text-sm font-medium">Manajemen Pos Pantau</span>
        </a>
        <a class="@if (Request::segment(1) == 'regions') flex items-center gap-3 px-3 py-3 rounded-lg bg-primary text-white shadow-lg shadow-primary/30 @else flex items-center gap-3 px-3 py-3 rounded-lg text-slate-600 dark:text-[#8e99cc] hover:bg-slate-100 dark:hover:bg-surface-dark transition-colors group @endif"
            href="{{ route('regions.index') }}">
            <span class="material-symbols-outlined group-hover:text-primary transition-colors">location_city</span>
            <span class="text-sm font-medium">Manajemen Wilayah</span>
        </a>
        <a class="@if (Request::segment(1) == 'disaster-facilities') flex items-center gap-3 px-3 py-3 rounded-lg bg-primary text-white shadow-lg shadow-primary/30 @else flex items-center gap-3 px-3 py-3 rounded-lg text-slate-600 dark:text-[#8e99cc] hover:bg-slate-100 dark:hover:bg-surface-dark transition-colors group @endif"
            href="{{ route('disaster-facilities.index') }}">
            <span class="material-symbols-outlined group-hover:text-primary transition-colors">build</span>
            <span class="text-sm font-medium">Manajemen Fasilitas</span>
        </a>
        <a class="@if (Request::segment(1) == 'officers') flex items-center gap-3 px-3 py-3 rounded-lg bg-primary text-white shadow-lg shadow-primary/30 @else flex items-center gap-3 px-3 py-3 rounded-lg text-slate-600 dark:text-[#8e99cc] hover:bg-slate-100 dark:hover:bg-surface-dark transition-colors group @endif"
            href="{{ route('officers.index') }}">
            <span class="material-symbols-outlined group-hover:text-primary transition-colors">group</span>
            <span class="text-sm font-medium">Manajemen Petugas</span>
        </a>
        <a class="@if (Request::segment(1) == 'citizens') flex items-center gap-3 px-3 py-3 rounded-lg bg-primary text-white shadow-lg shadow-primary/30 @else flex items-center gap-3 px-3 py-3 rounded-lg text-slate-600 dark:text-[#8e99cc] hover:bg-slate-100 dark:hover:bg-surface-dark transition-colors group @endif"
            href="{{ route('citizens.index') }}">
            <span class="material-symbols-outlined group-hover:text-primary transition-colors">group</span>
            <span class="text-sm font-medium">Manajemen Masyarakat</span>
        </a>
        <a class="@if (Request::segment(1) == 'officer-reports') flex items-center gap-3 px-3 py-3 rounded-lg bg-primary text-white shadow-lg shadow-primary/30 @else flex items-center gap-3 px-3 py-3 rounded-lg text-slate-600 dark:text-[#8e99cc] hover:bg-slate-100 dark:hover:bg-surface-dark transition-colors group @endif"
            href="{{ route('officer-reports.index') }}">
            <span class="material-symbols-outlined group-hover:text-primary transition-colors">assignment</span>
            <span class="text-sm font-medium">Laporan Petugas</span>
        </a>
        <a class="@if (Request::segment(1) == 'public-reports') flex items-center gap-3 px-3 py-3 rounded-lg bg-primary text-white shadow-lg shadow-primary/30 @else flex items-center gap-3 px-3 py-3 rounded-lg text-slate-600 dark:text-[#8e99cc] hover:bg-slate-100 dark:hover:bg-surface-dark transition-colors group @endif"
            href="{{ route('public-reports.index') }}">
            <span class="material-symbols-outlined group-hover:text-primary transition-colors">warning</span>
            <span class="text-sm font-medium">Laporan Masyarakat</span>
        </a>
        <a class="@if (Request::segment(1) == 'map') flex items-center gap-3 px-3 py-3 rounded-lg bg-primary text-white shadow-lg shadow-primary/30 @else flex items-center gap-3 px-3 py-3 rounded-lg text-slate-600 dark:text-[#8e99cc] hover:bg-slate-100 dark:hover:bg-surface-dark transition-colors group @endif"
            href="{{ route('map.index') }}">
            <span class="material-symbols-outlined group-hover:text-primary transition-colors">thunderstorm</span>
            <span class="text-sm font-medium">Potensi Banjir</span>
        </a>
        <a class="@if (Request::segment(1) == 'recap') flex items-center gap-3 px-3 py-3 rounded-lg bg-primary text-white shadow-lg shadow-primary/30 @else flex items-center gap-3 px-3 py-3 rounded-lg text-slate-600 dark:text-[#8e99cc] hover:bg-slate-100 dark:hover:bg-surface-dark transition-colors group @endif"
            href="{{ route('recap.index') }}">
            <span class="material-symbols-outlined group-hover:text-primary transition-colors">bar_chart</span>
            <span class="text-sm font-medium">Rekap Laporan</span>
        </a>
    </nav>
    <div class="p-4 border-t border-slate-200 dark:border-slate-800">
        <form action="{{ route('auth.logout') }}" method="POST">
            @csrf
            <button
                class="flex items-center gap-3 px-3 py-3 rounded-lg text-danger hover:bg-danger/10 transition-colors">
                <span class="material-symbols-outlined">logout</span>
                <span class="text-sm font-medium">Keluar</span>
            </button>
        </form>
    </div>
</aside>
