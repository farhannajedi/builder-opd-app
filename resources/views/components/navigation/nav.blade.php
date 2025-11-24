@props(['activePage'])

@php $cfg = $opdConfig ?? null; @endphp
<!-- menu navigasi -->
<nav x-data="{ mobileOpen: false }" class="bg-white sticky top-0 z-50 shadow">
    <div class="max-w-screen-lg px-2 flex items-center justify-between mx-auto w-full py-4">
        <div class="flex gap-6">
            <a href="/">
                <img src="{{ $opdConfigs?->logo ? Storage::url($opdConfigs->logo) : asset('assets/images/logo_kab.png') }}"
                    class="w-auto h-12 hover:scale-110 duration-200" alt="logo_kab"></a>
            <img src="{{ asset('assets/images/komdigi.png') }}" class="w-auto h-12 hover:scale-110 duration-200"
                alt="logo_hut">
        </div>
        {{-- Nav Menu Mobile --}}
        <div class="block md:hidden">
            <button @click="mobileOpen = !mobileOpen"
                class="bg-white hover:bg-slate-800 p-2 active:scale-95 rounded-lg border border-slate-300 group duration-200">
                <svg x-show="!mobileOpen" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                    stroke-linecap="round" stroke-linejoin="round"
                    class="text-slate-600 group-hover:text-white h-6 w-6">
                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                    <path d="M4 6l16 0" />
                    <path d="M4 12l16 0" />
                    <path d="M4 18l16 0" />
                </svg>
                {{-- Switch this icon when reverse status --}}
                <svg x-show="mobileOpen" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                    stroke-linecap="round" stroke-linejoin="round"
                    class="text-slate-600 group-hover:text-white h-6 w-6">
                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                    <path d="M18 6l-12 12" />
                    <path d="M6 6l12 12" />
                </svg>
            </button>
        </div>
        {{-- Hidden on mobile --}}
        <div class="bg-white w-1/3 h-10 border border-slate-400 rounded-lg hidden md:flex p-1">
            <input type="text" class="flex-1 focus:outline-none pl-2" placeholder="Pencarian">
            <button class="bg-white hover:bg-amber-300 rounded-r-md px-2">
                <svg xmlns="http://www.w3.org/2000/svg" class="text-orange-600 h-6 w-auto" viewBox="0 0 24 24"
                    fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                    <path d="M10 10m-7 0a7 7 0 1 0 14 0a7 7 0 1 0 -14 0" />
                    <path d="M21 21l-6 -6" />
                </svg>
            </button>
        </div>
    </div>
    {{-- Menu navigator --}}
    <div class="hidden md:block max-w-screen-lg px-2 mx-auto w-full border-t-1 border-slate-200">
        <ul class="text-sm font-medium uppercase flex gap-4 text-slate-600">
            <li class="h-full">
                <a href="/"
                    class="{{ ($activePage ?? '') === 'beranda' ? 'text-orange-600' : 'hover:text-slate-800  border-transparent' }} flex gap-1 items-center border-b-2 py-2">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="h-5 w-5">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                        <path
                            d="M9 3a2 2 0 0 1 2 2v6a2 2 0 0 1 -2 2h-4a2 2 0 0 1 -2 -2v-6a2 2 0 0 1 2 -2zm0 12a2 2 0 0 1 2 2v2a2 2 0 0 1 -2 2h-4a2 2 0 0 1 -2 -2v-2a2 2 0 0 1 2 -2zm10 -4a2 2 0 0 1 2 2v6a2 2 0 0 1 -2 2h-4a2 2 0 0 1 -2 -2v-6a2 2 0 0 1 2 -2zm0 -8a2 2 0 0 1 2 2v2a2 2 0 0 1 -2 2h-4a2 2 0 0 1 -2 -2v-2a2 2 0 0 1 2 -2z" />
                    </svg>
                    <span>Beranda</span>
                </a>
            </li>
            <li class="">
                <a href="/berita"
                    class="{{ ($activePage ?? '') === 'berita' ? 'text-orange-600 border-b-2' : 'hover:text-slate-800 border-transparent border-b-2' }} h-full block hover:border-b-2 p-2 uppercase">
                    berita
                </a>
            </li>
            <li class="">
                <a href="/planning-dokumen"
                    class="{{ ($activePage ?? '') === 'planning-dokumen' ? 'text-orange-600 border-b-2' : 'hover:text-slate-800 border-transparent border-b-2' }} h-full block hover:border-b-2 p-2 uppercase">
                    Arsip Dokumen
                </a>
            </li>
            <!-- <li class="group relative">
                <a href="javacript:void(0)"
                    class="{{ ($activePage ?? '') === 'informasi-publik' ? 'text-orange-600 border-b-2' : 'hover:text-slate-800 border-transparent border-b-2' }} h-full block hover:border-b-2 py-2 flex items-center gap-1">
                    <span>Informasi Publik</span>
                    <x-icons.chevron-down class="h-5 w-5 stroke-2 group-hover:rotate-180 duration-300" />
                </a>
                <div
                    class="hidden group-hover:block bg-white p-1 min-w-44 w-full h-auto rounded absolute top-full ring-1 ring-slate-300 grid">
                    <a href="/pengumuman">
                        <div class="hover:bg-slate-100 p-2 rounded">
                            Pengumuman
                        </div>
                    </a>
                    <a href="/nomor-penting">
                        <div class="hover:bg-slate-100 p-2 rounded">
                            Nomor Penting
                        </div>
                    </a>
                    <a href="/">
                        <div class="hover:bg-slate-100 p-2 rounded">
                            Arsip Dokumen
                        </div>
                    </a>
                </div>
            </li> -->
            <!-- <li>
                <a href="/tautan-aplikasi"
                    class="{{ ($activePage ?? '') === 'tautan-aplikasi' ? 'text-orange-600 border-b-2' : 'hover:text-slate-800 border-transparent border-b-2' }} h-full block hover:border-b-2 py-2 uppercase">
                    Tautan Aplikasi
                </a>
            </li> -->
            <!-- <li>
                <a href="https://ppid.karimunkab.go.id/" target="_blank"
                    class="hover:text-slate-800 border-transparent border-b-2 h-full block hover:border-b-2 py-2 uppercase">
                    PPID
                </a>
            </li> -->
        </ul>
    </div>
    {{-- Mobile Menu --}}
    <div id="mobile-menu" x-cloak x-show="mobileOpen" x-transition @click.away="mobileOpen = false"
        class="block md:hidden shadow-lg bg-white p-2 absolute w-full rounded-b-lg border-t-1 border-slate-200 text-slate-600 grid divide-y divide-slate-400">

        {{-- Mobile Menu List --}}
        <a href="/" class="w-full text-lg font-base flex justify-between hover:bg-slate-100 p-2 group">
            <span class="group-hover:text-slate-800">Beranda</span>
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"
                class="h-8 w-8 rotate-45 group-hover:rotate-90 duration-200 text-slate-400 group-hover:text-slate-800">
                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                <path d="M12 5l0 14" />
                <path d="M18 11l-6 -6" />
                <path d="M6 11l6 -6" />
            </svg>
        </a>
        <a href="/berita" class="w-full text-lg font-base flex justify-between hover:bg-slate-100 p-2 group">
            <span class="group-hover:text-slate-800">Berita</span>
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"
                class="h-8 w-8 rotate-45 group-hover:rotate-90 duration-200 text-slate-400 group-hover:text-slate-800">
                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                <path d="M12 5l0 14" />
                <path d="M18 11l-6 -6" />
                <path d="M6 11l6 -6" />
            </svg>
        </a>
        <a href="/planning-dokumen" class="w-full text-lg font-base flex justify-between hover:bg-slate-100 p-2 group">
            <span class="group-hover:text-slate-800">Arsip Dokumen</span>
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"
                class="h-8 w-8 rotate-45 group-hover:rotate-90 duration-200 text-slate-400 group-hover:text-slate-800">
                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                <path d="M12 5l0 14" />
                <path d="M18 11l-6 -6" />
                <path d="M6 11l6 -6" />
            </svg>
        </a>
        <!-- <div class="p-2">
            <a href="javascript:void(0)"
                class="w-full text-lg font-base flex justify-between hover:bg-slate-100  group">
                <span class="group-hover:text-slate-800">Informasi Publik </span>
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"
                    stroke-linejoin="round" class="h-8 w-8 duration-200 text-slate-400 group-hover:text-slate-800">
                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                    <path d="M6 9l6 6l6 -6" />
                </svg>
            </a>
            <ul class="text-slate-500 space-y-2 w-full border-l-1 border-slate-200">
                <a href="/pengumuman" class="active:scale-95">
                    <li class="p-1 hover:bg-slate-200">
                        Pengumuman
                    </li>
                </a>
                <li class="p-1 hover:bg-slate-200">
                    <a href="/nomor-penting">Nomor Penting</a>
                </li>
                <li class="p-1 hover:bg-slate-200">
                    <a href="/arsip-dokumen">Arsip Dokumen</a>
                </li>
            </ul>
        </div> -->

        <!-- <a href="/tautan-aplikasi" class="w-full text-lg font-base flex justify-between hover:bg-slate-100 p-2 group">
            <span class="group-hover:text-slate-800">Tautan Aplikasi</span>
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"
                class="h-8 w-8 rotate-45 group-hover:rotate-90 duration-200 text-slate-400 group-hover:text-slate-800">
                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                <path d="M12 5l0 14" />
                <path d="M18 11l-6 -6" />
                <path d="M6 11l6 -6" />
            </svg>
        </a>
        <a href="https://ppid.karimunkab.go.id/" target="_blank"
            class="w-full text-lg font-base flex justify-between hover:bg-slate-100 p-2 group">
            <span class="group-hover:text-slate-800">PPID</span>
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"
                class="h-8 w-8 rotate-45 group-hover:rotate-90 duration-200 text-slate-400 group-hover:text-slate-800">
                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                <path d="M12 5l0 14" />
                <path d="M18 11l-6 -6" />
                <path d="M6 11l6 -6" />
            </svg>
        </a> -->
        {{-- Mobile Menu List --}}

        {{-- Searchbox --}}
        {{-- <div class="bg-white w-full h-10 border border-slate-400 rounded-lg flex p-1 mt-4">
        <input type="text" class="flex-1 focus:outline-none pl-2" placeholder="Pencarian">
        <button class="bg-white hover:bg-amber-300 rounded-r-md px-2">
          <svg xmlns="http://www.w3.org/2000/svg" class="text-orange-600 h-6 w-auto" viewBox="0 0 24 24"
            fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
            <path d="M10 10m-7 0a7 7 0 1 0 14 0a7 7 0 1 0 -14 0" />
            <path d="M21 21l-6 -6" />
          </svg>
        </button>
      </div> --}}
        {{-- Menu --}}
    </div>
</nav>