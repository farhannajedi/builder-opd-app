@props(['activePage'])

use Illuminate\Support\Facades\Date;

@php
$opdSlug = env('APP_ID');
$opd = \App\Models\Opd::where('slug', $opdSlug)->first();
$opdConfigs = \App\Models\OpdConfigs::where('opd_id', $opd?->id)->first();
$opdName = $opd->name ?? 'Portal Resmi Instansi';
@endphp

<!-- Container Navigasi Utama -->
<nav x-data="{ mobileOpen: false, mobileSubmenuOpen: false }"
    class="bg-white sticky top-0 z-50 shadow-md border-b border-slate-100">

    <!-- Top Bar Informasi Resmi Pemerintah -->
    <div class="bg-slate-900 text-slate-300 text-xs py-2 px-4 hidden md:block border-b border-slate-800">
        <div class="max-w-screen-lg mx-auto flex justify-between items-center">
            <div class="flex items-center gap-3">
                <span class="flex items-center gap-1.5 text-orange-400 font-medium">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                    </svg>
                    <span id="nav-date-display">--/--/----</span>
                </span>
                <span class="text-slate-700">|</span>
                <span class="text-slate-300 font-semibold tracking-wide">Website Resmi {{ $opdName }}</span>
            </div>
            <div class="flex items-center gap-4 text-slate-400">
                <span
                    class="inline-flex items-center gap-1 text-[11px] bg-slate-800 px-2 py-0.5 rounded border border-slate-700 text-slate-300">
                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-400 animate-pulse"></span>
                    Karimun, Kep. Riau
                </span>
            </div>
        </div>
    </div>

    <!-- logo hamburger menu -->
    <div class="max-w-screen-lg flex items-center justify-between mx-auto w-full py-3 px-4">

        <!-- logo -->
        <div
            class="flex items-center gap-3 md:gap-5 bg-slate-50/80 p-2 rounded-xl border border-slate-200/60 shadow-sm">
            <a href="/" class="block">
                <img src="{{ asset('assets/images/logo_kab.png') }}"
                    class="w-20 md:w-24 h-10 md:h-12 object-contain hover:scale-105 transition-transform duration-200"
                    alt="logo_kab">
            </a>
            <span class="h-8 w-[1px] bg-slate-300 hidden sm:block"></span>
            <img src="{{ $opdConfigs?->logo ? Storage::url($opdConfigs->logo) : asset('assets/images/logo_kab.png') }}"
                class="w-20 md:w-24 h-10 md:h-12 object-contain hover:scale-105 transition-transform duration-200"
                alt="logo_opd">
            <span class="h-8 w-[1px] bg-slate-300 hidden sm:block"></span>
            <img src="{{ $opdConfigs?->favicon ? Storage::url($opdConfigs->favicon) : asset('assets/images/logo_kab.png') }}"
                class="w-20 md:w-24 h-10 md:h-12 object-contain hover:scale-105 transition-transform duration-200"
                alt="logo_favicon">
        </div>

        <!-- Tombol Hamburger Navbar Mobile -->
        <div class="block md:hidden">
            <button @click="mobileOpen = !mobileOpen" type="button"
                class="bg-white hover:bg-slate-800 p-2.5 active:scale-95 rounded-xl border border-slate-300 group duration-200 shadow-sm">
                <!-- Icon Hamburger (Saat Tertutup) -->
                <svg x-show="!mobileOpen" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                    stroke-linecap="round" stroke-linejoin="round"
                    class="text-slate-700 group-hover:text-white h-6 w-6">
                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                    <path d="M4 6l16 0" />
                    <path d="M4 12l16 0" />
                    <path d="M4 18l16 0" />
                </svg>
                <!-- Icon tutup (Saat Terbuka) -->
                <svg x-cloak x-show="mobileOpen" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                    stroke-linecap="round" stroke-linejoin="round"
                    class="text-slate-700 group-hover:text-white h-6 w-6">
                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                    <path d="M18 6l-12 12" />
                    <path d="M6 6l12 12" />
                </svg>
            </button>
        </div>

        <!-- Search Bar Desktop  -->
        <div
            class="bg-white w-1/3 h-10 border border-slate-300 rounded-lg hidden md:flex p-1 shadow-sm focus-within:border-orange-500 transition-colors">
            <input type="text" class="flex-1 focus:outline-none pl-2 text-sm text-slate-700" placeholder="Pencarian">
            <button class="bg-white hover:bg-amber-300 rounded-r-md px-3 transition-colors">
                <svg xmlns="http://www.w3.org/2000/svg" class="text-orange-600 h-5 w-auto" viewBox="0 0 24 24"
                    fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                    <path d="M10 10m-7 0a7 7 0 1 0 14 0a7 7 0 1 0 -14 0" />
                    <path d="M21 21l-6 -6" />
                </svg>
            </button>
        </div>
    </div>

    <!-- Menu Navigasi Desktop -->
    <div class="hidden md:block max-w-screen-lg px-2 mx-auto w-full border-t border-slate-200">
        <ul class="text-xs font-bold uppercase flex gap-1 lg:gap-2 text-slate-700">
            <li>
                <a href="/"
                    class="{{ ($activePage ?? '') === 'beranda' ? 'text-orange-600 border-orange-600 bg-orange-50/50' : 'hover:text-orange-600 hover:bg-slate-50 border-transparent' }} flex gap-1.5 items-center border-b-2 py-3 px-3 transition-all duration-200">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="h-4 w-4">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                        <path
                            d="M9 3a2 2 0 0 1 2 2v6a2 2 0 0 1 -2 2h-4a2 2 0 0 1 -2 -2v-6a2 2 0 0 1 2 -2zm0 12a2 2 0 0 1 2 2v2a2 2 0 0 1 -2 2h-4a2 2 0 0 1 -2 -2v-2a2 2 0 0 1 2 -2zm10 -4a2 2 0 0 1 2 2v6a2 2 0 0 1 -2 2h-4a2 2 0 0 1 -2 -2v-6a2 2 0 0 1 2 -2zm0 -8a2 2 0 0 1 2 2v2a2 2 0 0 1 -2 2h-4a2 2 0 0 1 -2 -2v-2a2 2 0 0 1 2 -2z" />
                    </svg>
                    <span>Beranda</span>
                </a>
            </li>
            <li>
                <a href="/berita"
                    class="{{ ($activePage ?? '') === 'berita' ? 'text-orange-600 border-orange-600 bg-orange-50/50' : 'hover:text-orange-600 hover:bg-slate-50 border-transparent' }} block border-b-2 py-3 px-3 transition-all duration-200">
                    Berita
                </a>
            </li>
            <li>
                <a href="/planning-dokumen"
                    class="{{ ($activePage ?? '') === 'Arsip Dokumen' ? 'text-orange-600 border-orange-600 bg-orange-50/50' : 'hover:text-orange-600 hover:bg-slate-50 border-transparent' }} block border-b-2 py-3 px-3 transition-all duration-200">
                    Arsip Dokumen
                </a>
            </li>
            <li>
                <a href="/layanan"
                    class="{{ ($activePage ?? '') === 'Layanan' ? 'text-orange-600 border-orange-600 bg-orange-50/50' : 'hover:text-orange-600 hover:bg-slate-50 border-transparent' }} block border-b-2 py-3 px-3 transition-all duration-200">
                    Layanan
                </a>
            </li>
            <li>
                <a href="/galeri"
                    class="{{ ($activePage ?? '') === 'galeri' ? 'text-orange-600 border-orange-600 bg-orange-50/50' : 'hover:text-orange-600 hover:bg-slate-50 border-transparent' }} block border-b-2 py-3 px-3 transition-all duration-200">
                    Galeri
                </a>
            </li>
            <li class="group relative">
                <a href="javascript:void(0)"
                    class="{{ ($activePage ?? '') === 'informasi-publik' ? 'text-orange-600 border-orange-600 bg-orange-50/50' : 'hover:text-orange-600 hover:bg-slate-50 border-transparent' }} border-b-2 py-3 px-3 flex items-center gap-1 transition-all duration-200">
                    <span>Informasi Publik</span>
                    <x-icons.chevron-down class="h-4 w-4 stroke-2 group-hover:rotate-180 duration-300" />
                </a>
                <div
                    class="hidden group-hover:block bg-white p-1.5 min-w-48 w-full rounded-xl shadow-xl border border-slate-100 absolute top-full left-0 z-50 grid transition-all duration-200">
                    <a href="/pengumuman">
                        <div
                            class="hover:bg-orange-50 hover:text-orange-600 p-2.5 rounded-lg text-xs font-semibold text-slate-700 transition-colors">
                            Pengumuman
                        </div>
                    </a>
                </div>
            </li>
        </ul>
    </div>

    <!-- Menu Navigasi Mobile -->
    <div id="mobile-menu" x-cloak x-show="mobileOpen" x-transition @click.away="mobileOpen = false"
        class="md:hidden shadow-2xl bg-white p-3 absolute left-0 right-0 top-full w-full rounded-b-2xl border-t border-slate-200 text-slate-700 grid divide-y divide-slate-100">

        <a href="/"
            class="w-full text-base font-semibold flex justify-between items-center hover:bg-slate-50 p-2.5 rounded-xl group transition-colors">
            <span class="group-hover:text-orange-600">Beranda</span>
        </a>
        <a href="/berita"
            class="w-full text-base font-semibold flex justify-between items-center hover:bg-slate-50 p-2.5 rounded-xl group transition-colors">
            <span class="group-hover:text-orange-600">Berita</span>
        </a>
        <a href="/planning-dokumen"
            class="w-full text-base font-semibold flex justify-between items-center hover:bg-slate-50 p-2.5 rounded-xl group transition-colors">
            <span class="group-hover:text-orange-600">Arsip Dokumen</span>
        </a>
        <a href="/layanan"
            class="w-full text-base font-semibold flex justify-between items-center hover:bg-slate-50 p-2.5 rounded-xl group transition-colors">
            <span class="group-hover:text-orange-600">Layanan</span>
        </a>
        <a href="/galeri"
            class="w-full text-base font-semibold flex justify-between items-center hover:bg-slate-50 p-2.5 rounded-xl group transition-colors">
            <span class="group-hover:text-orange-600">Galeri</span>
        </a>

        <!-- Submenu Mobile dengan Toggle Dropdown -->
        <div class="py-2 px-1">
            <button @click="mobileSubmenuOpen = !mobileSubmenuOpen" type="button"
                class="w-full text-base font-semibold flex justify-between items-center hover:bg-slate-50 p-1.5 rounded-xl group transition-colors">
                <span class="group-hover:text-orange-600">Informasi Publik</span>
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"
                    stroke-linejoin="round" class="h-5 w-5 duration-200 text-slate-400 group-hover:text-orange-600"
                    :class="{ 'rotate-180': mobileSubmenuOpen }">
                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                    <path d="M6 9l6 6l6 -6" />
                </svg>
            </button>
            <ul x-show="mobileSubmenuOpen" x-collapse
                class="text-slate-600 space-y-1 w-full border-l-2 border-orange-400 pl-3 mt-2 text-sm font-medium">
                <li>
                    <a href="/pengumuman"
                        class="block p-2 hover:bg-orange-50 hover:text-orange-600 rounded-lg transition-colors">Pengumuman</a>
                </li>
            </ul>
        </div>

        <!-- Input Search Mobile -->
        <div class="pt-3 pb-1 px-1">
            <div class="bg-white w-full h-10 border border-slate-300 rounded-lg flex p-1 shadow-sm">
                <input type="text" class="flex-1 focus:outline-none pl-2 text-sm text-slate-700"
                    placeholder="Pencarian">
                <button class="bg-white hover:bg-amber-300 rounded-r-md px-2 transition-colors">
                    <svg xmlns="http://www.w3.org/2000/svg" class="text-orange-600 h-5 w-auto" viewBox="0 0 24 24"
                        fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                        stroke-linejoin="round">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                        <path d="M10 10m-7 0a7 7 0 1 0 14 0a7 7 0 1 0 -14 0" />
                        <path d="M21 21l-6 -6" />
                    </svg>
                </button>
            </div>
        </div>
    </div>
</nav>

<!-- menampilkan waktu -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const dateDisplay = document.getElementById('nav-date-display');
        if (dateDisplay) {
            const options = {
                weekday: 'long',
                year: 'numeric',
                month: 'long',
                day: 'numeric'
            };
            dateDisplay.textContent = new Date().toLocaleDateString('id-ID', options);
        }
    });
</script>