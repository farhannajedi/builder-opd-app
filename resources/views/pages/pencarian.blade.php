@php
$opdSlug = env('APP_ID');
$opd = \App\Models\Opd::where('slug', $opdSlug)->first();
$opdName = $opd?->name ?? 'Instansi';

$query = request('q');

// Mencari Berita
$news = \App\Models\News::where('opd_id', $opd?->id)
->where(function($q) use ($query) {
$q->where('title', 'like', "%{$query}%");
})->latest()->get();

$announcements = App\Models\announcement::where('opd_id', $opd?->id)->where(function($q) use ($query) {
$q->where('title', 'like', "%{$query}%");
})->latest()->get();

// Mencari Layanan
$services = \App\Models\Service::where('opd_id', $opd?->id)
->where(function($q) use ($query) {
$q->where('name', 'like', "%{$query}%")
->orWhere('description', 'like', "%{$query}%");
})->latest()->get();

// Mencari Halaman Kustom (dengan relasi menu induk)
$pages = \App\Models\Page::with('page_menu')
->where('opd_id', $opd?->id)
->where('is_active', true)
->where(function($q) use ($query) {
$q->where('title', 'like', "%{$query}%")
->orWhere('badge_text', 'like', "%{$query}%")
->orWhere('subtitle', 'like', "%{$query}%");
})->latest()->get();

$totalResults = $news->count() + $services->count() + $pages->count();
@endphp

@extends('layouts.app', ['activePage' => 'Pencarian'])

@section('content')
<div class="w-full bg-slate-50/60 py-10 min-h-screen">
    <div class="max-w-screen-xl mx-auto px-4 sm:px-6 lg:px-8 space-y-8">

        <!-- Navigasi -->
        <nav class="flex items-center gap-2 text-xs font-semibold text-slate-500 overflow-x-auto pb-1">
            <a href="{{ url('/') }}" class="hover:text-brand-600 transition-colors flex items-center gap-1 shrink-0">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                </svg>
                Beranda
            </a>
            <span class="text-slate-300">/</span>
            <span class="text-slate-800 font-bold truncate">Hasil Pencarian</span>
        </nav>

        <!-- Header Pencarian -->
        <div class="relative overflow-hidden bg-slate-900 text-white rounded-3xl p-8 sm:p-12 shadow-lg">
            <div
                class="absolute -right-10 -bottom-10 w-64 h-64 bg-brand-500/10 rounded-full blur-3xl pointer-events-none">
            </div>

            <div class="relative z-10 max-w-2xl space-y-3">
                <div
                    class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-brand-500/20 border border-brand-500/30 text-brand-400 text-[9px] font-extrabold uppercase tracking-widest">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                    Pencarian Portal Publik
                </div>

                <h1 class="text-xl sm:text-3xl font-black tracking-tight leading-tight">
                    Hasil Penelusuran: <span class="text-brand-400">"{{ $query }}"</span>
                </h1>

                <p class="text-xs sm:text-sm text-slate-300 leading-relaxed">
                    Ditemukan <span class="font-bold text-white">{{ $totalResults }} informasi</span> terkait kata kunci
                    tersebut pada basis data resmi {{ $opdName }}.
                </p>
            </div>
        </div>

        <!-- Daftar Hasil Pencarian -->
        <div class="bg-white rounded-3xl p-6 sm:p-10 border border-slate-200/80 shadow-sm space-y-6">

            <!-- Berita -->
            @foreach($news as $item)
            <div
                class="group p-5 sm:p-6 rounded-2xl border border-slate-100 hover:border-brand-300 bg-white hover:bg-brand-50/20 transition-all duration-300 shadow-sm hover:shadow-md flex flex-col justify-between gap-4">
                <div class="space-y-2.5">
                    <div class="flex items-center justify-between gap-3">
                        <span
                            class="inline-flex items-center gap-1.5 px-3 py-1 rounded-lg text-[10px] font-extrabold uppercase tracking-wider bg-blue-50 text-blue-700 border border-blue-100">
                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z" />
                            </svg>
                            Berita & Informasi
                        </span>

                        @if($item->created_at)
                        <span class="text-[11px] font-medium text-slate-400">
                            {{ $item->created_at->locale('id')->isoFormat('D MMMM YYYY') }}
                        </span>
                        @endif
                    </div>

                    <a href="{{ url('/berita/' . ($item->slug ?? $item->id)) }}"
                        class="block group-hover:text-brand-600 transition-colors">
                        <h2 class="text-base sm:text-lg font-bold text-slate-800 leading-snug">
                            {{ $item->title }}
                        </h2>
                    </a>
                </div>

                <div class="pt-3 border-t border-slate-100 flex items-center justify-between">
                    <span class="text-xs font-semibold text-slate-400">Publikasi OPD</span>
                    <a href="{{ url('/berita/' . ($item->slug ?? $item->id)) }}"
                        class="inline-flex items-center gap-1.5 text-xs font-bold text-brand-600 hover:text-brand-700 transition">
                        <span>Baca Selengkapnya</span>
                        <svg class="w-3.5 h-3.5 group-hover:translate-x-1 transition-transform" fill="none"
                            stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M14 5l7 7m0 0l-7 7m7-7H3" />
                        </svg>
                    </a>
                </div>
            </div>
            @endforeach

            <!-- Pengumuman -->
            @foreach($announcements as $item)
            <div
                class="group p-5 sm:p-6 rounded-2xl border border-slate-100 hover:border-emerald-300 bg-white hover:bg-emerald-50/20 transition-all duration-300 shadow-sm hover:shadow-md flex flex-col justify-between gap-4">
                <div class="space-y-2.5">
                    <div class="flex items-center justify-between gap-3">
                        <span
                            class="inline-flex items-center gap-1.5 px-3 py-1 rounded-lg text-[10px] font-extrabold uppercase tracking-wider bg-emerald-50 text-emerald-700 border border-emerald-100">
                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                            </svg>
                            Pengumuman
                        </span>
                    </div>

                    <a href="{{ url('/pengumuman/' . $item->slug ?? $item->id) }}"
                        class="block group-hover:text-emerald-700 transition-colors">
                        <h2 class="text-base sm:text-lg font-bold text-slate-800 leading-snug">
                            {{ $item->title }}
                        </h2>
                    </a>

                    @if(!empty($item->description))
                    <p class="text-xs sm:text-sm text-slate-500 line-clamp-2 leading-relaxed">
                        {{ $item->description }}
                    </p>
                    @endif
                </div>

                <div class="pt-3 border-t border-slate-100 flex items-center justify-between">
                    <span class="text-xs font-semibold text-slate-400">Fasilitas & Aplikasi</span>
                    <a href="{{ url('/pengumuman/' . $item->slug ?? $item->id) }}"
                        class="inline-flex items-center gap-1.5 text-xs font-bold text-emerald-600 hover:text-emerald-700 transition">
                        <span>Akses Detail Pengumuman</span>
                        <svg class="w-3.5 h-3.5 group-hover:translate-x-1 transition-transform" fill="none"
                            stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M14 5l7 7m0 0l-7 7m7-7H3" />
                        </svg>
                    </a>
                </div>
            </div>
            @endforeach

            <!-- Layanan Publik -->
            @foreach($services as $service)
            <div
                class="group p-5 sm:p-6 rounded-2xl border border-slate-100 hover:border-emerald-300 bg-white hover:bg-emerald-50/20 transition-all duration-300 shadow-sm hover:shadow-md flex flex-col justify-between gap-4">
                <div class="space-y-2.5">
                    <div class="flex items-center justify-between gap-3">
                        <span
                            class="inline-flex items-center gap-1.5 px-3 py-1 rounded-lg text-[10px] font-extrabold uppercase tracking-wider bg-emerald-50 text-emerald-700 border border-emerald-100">
                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                            </svg>
                            Layanan Publik
                        </span>
                    </div>

                    <a href="{{ url('/layanan/' . $service->id) }}"
                        class="block group-hover:text-emerald-700 transition-colors">
                        <h2 class="text-base sm:text-lg font-bold text-slate-800 leading-snug">
                            {{ $service->name }}
                        </h2>
                    </a>

                    @if(!empty($service->description))
                    <p class="text-xs sm:text-sm text-slate-500 line-clamp-2 leading-relaxed">
                        {{ $service->description }}
                    </p>
                    @endif
                </div>

                <div class="pt-3 border-t border-slate-100 flex items-center justify-between">
                    <span class="text-xs font-semibold text-slate-400">Fasilitas & Aplikasi</span>
                    <a href="{{ url('/layanan/' . $service->id) }}"
                        class="inline-flex items-center gap-1.5 text-xs font-bold text-emerald-600 hover:text-emerald-700 transition">
                        <span>Akses Detail Layanan</span>
                        <svg class="w-3.5 h-3.5 group-hover:translate-x-1 transition-transform" fill="none"
                            stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M14 5l7 7m0 0l-7 7m7-7H3" />
                        </svg>
                    </a>
                </div>
            </div>
            @endforeach

            <!-- Halaman Kustom OPD -->
            @foreach($pages as $custom)
            @php
            $menuSlug = $custom->page_menu->slug ?? 'umum';
            @endphp
            <div
                class="group p-5 sm:p-6 rounded-2xl border border-slate-100 hover:border-purple-300 bg-white hover:bg-purple-50/20 transition-all duration-300 shadow-sm hover:shadow-md flex flex-col justify-between gap-4">
                <div class="space-y-2.5">
                    <div class="flex items-center justify-between gap-3">
                        <span
                            class="inline-flex items-center gap-1.5 px-3 py-1 rounded-lg text-[10px] font-extrabold uppercase tracking-wider bg-purple-50 text-purple-700 border border-purple-100">
                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                            </svg>
                            {{ $custom->badge_text ?? ($custom->page_menu->title ?? 'Halaman Informasi') }}
                        </span>
                    </div>

                    <a href="{{ url('/halaman/' . $menuSlug . '/' . $custom->slug) }}"
                        class="block group-hover:text-purple-700 transition-colors">
                        <h2 class="text-base sm:text-lg font-bold text-slate-800 leading-snug">
                            {{ $custom->title }}
                        </h2>
                    </a>

                    @if(!empty($custom->subtitle))
                    <p class="text-xs sm:text-sm text-slate-500 line-clamp-2 leading-relaxed">
                        {{ $custom->subtitle }}
                    </p>
                    @endif
                </div>

                <div class="pt-3 border-t border-slate-100 flex items-center justify-between">
                    <span class="text-xs font-semibold text-slate-400">Modul:
                        {{ $custom->page_menu->title ?? 'Informasi Khusus' }}</span>
                    <a href="{{ url('/halaman/' . $menuSlug . '/' . $custom->slug) }}"
                        class="inline-flex items-center gap-1.5 text-xs font-bold text-purple-600 hover:text-purple-700 transition">
                        <span>Buka Rincian Halaman</span>
                        <svg class="w-3.5 h-3.5 group-hover:translate-x-1 transition-transform" fill="none"
                            stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M14 5l7 7m0 0l-7 7m7-7H3" />
                        </svg>
                    </a>
                </div>
            </div>
            @endforeach

            <!-- State Tampilan Jika Tidak Ada Hasil Ditemukan -->
            @if($totalResults === 0)
            <div class="py-16 text-center">
                <div
                    class="w-16 h-16 rounded-full bg-brand-50 text-brand-500 border border-brand-100 flex items-center justify-center mx-auto mb-4 shadow-sm">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                </div>
                <h3 class="text-base font-bold text-slate-800">Tidak Ada Informasi Ditemukan</h3>
                <p class="text-xs sm:text-sm text-slate-400 mt-1 max-w-sm mx-auto leading-relaxed">
                    Kami tidak dapat menemukan berita, layanan, atau dokumen yang cocok dengan kata kunci <span
                        class="text-slate-600 font-semibold">"{{ $query }}"</span>.
                </p>
                <div class="mt-6">
                    <a href="{{ url('/') }}"
                        class="inline-flex items-center gap-2 px-5 py-2.5 rounded-xl bg-slate-100 hover:bg-brand-500 hover:text-white text-slate-700 text-xs font-bold transition-all duration-200">
                        ← Kembali ke Beranda
                    </a>
                </div>
            </div>
            @endif
        </div>
    </div>
</div>
@endsection