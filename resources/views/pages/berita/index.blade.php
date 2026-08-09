@php
$opdSlug = env('APP_ID');
$opd = App\Models\Opd::where('slug', $opdSlug)->first();

$otherNews = App\Models\News::where('opd_id', $opd?->id)->with('category', 'opd')->latest()->paginate(9);
$newsCategory = App\Models\NewsCategories::where('opd_id', $opd?->id)->limit(7)->get();

$opdName = $opd->name ?? 'Instansi';
@endphp

@extends('layouts.app', ['activePage' => 'berita'])

@section('content')
<div class="w-full bg-slate-50/60 py-10 min-h-screen">
    <div class="max-w-screen-xl mx-auto px-4 sm:px-6 lg:px-8 space-y-8">
        <!-- Header -->
        <div
            class="relative overflow-hidden bg-slate-900 text-white rounded-3xl p-8 sm:p-12 shadow-lg border border-slate-800">
            <div
                class="absolute -right-10 -bottom-10 w-64 h-64 bg-orange-500/10 rounded-full blur-3xl pointer-events-none">
            </div>
            <div class="relative z-10 max-w-3xl space-y-3">
                <div
                    class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-orange-500/20 border border-orange-500/30 text-orange-400 text-[9px] font-extrabold uppercase tracking-widest">
                    <span class="w-2 h-2 rounded-full bg-orange-400 animate-pulse"></span>
                    Portal Publikasi & Pers Resmi
                </div>
                <h1 class="text-xl sm:text-2xl font-black tracking-tight leading-tight">
                    Kabar & Informasi {{ $opdName }}
                </h1>
                <p class="text-xs sm:text-sm text-slate-300 leading-relaxed">
                    Pusat rilis berita terkini, siaran pers, dokumentasi kegiatan pimpinan, dan pembaruan kebijakan
                    publik resmi.
                </p>
            </div>
        </div>
        <div class="bg-white rounded-3xl p-6 sm:p-10 border border-slate-200/80 shadow-sm space-y-8">

            <!-- Filter Kategori Berita -->
            <div class="border-b border-slate-100 pb-6">
                <div class="flex items-center gap-2 mb-3 text-xs font-bold text-slate-400 uppercase tracking-wider">
                    <svg class="w-4 h-4 text-orange-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M3 4a1 1 0 011-1h16a1 1 0 011 1v25a1 1 0 01-1 1H4a1 1 0 01-1-1V4z" />
                    </svg>
                    <span>Kategori Topik Berita</span>
                </div>
                <x-commons.category-news :categories="$newsCategory" />
            </div>

            @if ($otherNews->isNotEmpty())
            @php
            $featured = $otherNews->first();
            @endphp

            <!-- Berita Teratas -->
            @if ($otherNews->currentPage() == 1)
            <div class="group relative bg-slate-900 rounded-3xl overflow-hidden shadow-lg border border-slate-800">
                <div class="grid grid-cols-1 lg:grid-cols-12 items-center">

                    <!-- Foto -->
                    <div class="lg:col-span-7 relative aspect-[16/10] lg:aspect-[16/11] w-full overflow-hidden">
                        <img src="{{ asset('storage/' . $featured->images) }}" alt="{{ $featured->title }}"
                            class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-105 opacity-90 group-hover:opacity-100">
                        <div
                            class="absolute inset-0 bg-gradient-to-t from-slate-950 via-slate-950/20 to-transparent lg:hidden">
                        </div>
                    </div>

                    <!-- Detail Teks Artikel -->
                    <div
                        class="lg:col-span-5 p-6 sm:p-8 lg:p-10 text-white flex flex-col justify-between h-full space-y-4">
                        <div>
                            <!-- Badge Kategori & Sorotan -->
                            <div class="flex items-center gap-2 mb-4">
                                <span
                                    class="px-3 py-1 bg-orange-500 text-white text-[10px] font-black uppercase tracking-wider rounded-lg shadow-sm">
                                    BERITA UTAMA
                                </span>
                                @if($featured->category)
                                <span
                                    class="px-3 py-1 bg-white/10 backdrop-blur-md text-slate-200 border border-white/20 text-[10px] font-bold uppercase tracking-wider rounded-lg">
                                    {{ $featured->category->title }}
                                </span>
                                @endif
                            </div>

                            <!-- Judul Utama -->
                            <a href="/berita/{{ $featured->slug }}" class="block group/title">
                                <h2
                                    class="text-xl sm:text-2xl lg:text-3xl font-bold group-hover/title:text-orange-400 transition-colors leading-snug tracking-tight mb-3">
                                    {{ $featured->title }}
                                </h2>
                            </a>

                            <!-- Deskripsi -->
                            <p class="text-xs sm:text-sm text-slate-300 leading-relaxed line-clamp-3 font-normal">
                                {{ strip_tags($featured->deskripsi) }}
                            </p>
                        </div>

                        <!-- Metadata & Tombol Baca -->
                        <div
                            class="pt-6 border-t border-slate-800 flex items-center justify-between text-xs text-slate-400">
                            <div class="flex items-center gap-1.5 font-medium">
                                <svg class="w-4 h-4 text-orange-400" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                                <span>{{ $featured->published_at?->locale('id')->isoFormat('D MMMM YYYY') ?? now()->locale('id')->isoFormat('D MMMM YYYY') }}</span>
                            </div>

                            <a href="/berita/{{ $featured->slug }}"
                                class="inline-flex items-center gap-2 px-4 py-2 rounded-xl bg-orange-500 hover:bg-orange-600 text-white font-bold transition-all shadow-md shadow-orange-500/20">
                                <span>Baca Artikel</span>
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M14 5l7 7m0 0l-7 7m7-7H3" />
                                </svg>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            @endif

            <!-- Daftar Berita lainnya -->
            <div class="space-y-4 pt-4">
                <div class="flex items-center justify-between border-b border-slate-100 pb-3">
                    <h3 class="text-base font-bold text-slate-800">
                        {{ $otherNews->currentPage() == 1 ? 'Arsip Berita Terbaru Lainnya' : 'Daftar Berita' }}
                    </h3>
                    <span class="text-xs font-semibold text-slate-400">Halaman {{ $otherNews->currentPage() }} dari
                        {{ $otherNews->lastPage() }}</span>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 sm:gap-8">
                    @foreach ($otherNews->when($otherNews->currentPage() == 1, fn($collection) => $collection->skip(1))
                    as $news)
                    <div
                        class="group flex flex-col justify-between bg-white rounded-2xl border border-slate-200/80 hover:border-orange-300 hover:shadow-xl transition-all duration-300 overflow-hidden">
                        <div>
                            <!-- Foto Berita -->
                            <div class="relative aspect-[16/9] w-full overflow-hidden bg-slate-100">
                                @if($news->category)
                                <span
                                    class="absolute top-3 left-3 z-10 px-3 py-1 bg-slate-900/80 backdrop-blur-md text-white border border-white/20 text-[10px] font-bold uppercase tracking-wider rounded-lg shadow-sm">
                                    {{ $news->category->title }}
                                </span>
                                @endif

                                <img src="{{ asset('storage/' . $news->images) }}"
                                    class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105"
                                    alt="{{ $news->title }}">

                                <div
                                    class="absolute inset-0 bg-slate-900/10 group-hover:bg-transparent transition-colors duration-300">
                                </div>
                            </div>

                            <!-- Detail Konten Berita -->
                            <div class="p-5 space-y-3">
                                <!-- Tanggal Publikasi -->
                                <div class="flex items-center gap-1.5 text-xs text-slate-400 font-medium">
                                    <svg class="w-3.5 h-3.5 text-slate-400" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                    </svg>
                                    <span>{{ $news->published_at?->locale('id')->isoFormat('D MMMM YYYY') ?? now()->locale('id')->isoFormat('D MMMM YYYY') }}</span>
                                </div>

                                <!-- Judul Berita -->
                                <a href="/berita/{{ $news->slug }}" class="block">
                                    <h4
                                        class="text-base sm:text-lg font-bold text-slate-800 group-hover:text-orange-600 transition-colors leading-snug line-clamp-2">
                                        {{ $news->title }}
                                    </h4>
                                </a>
                            </div>
                        </div>

                        <!-- Link Selengkapnya -->
                        <div class="p-5 pt-0">
                            <a href="/berita/{{ $news->slug }}"
                                class="inline-flex items-center gap-1.5 text-xs font-bold text-orange-600 hover:text-orange-700 transition-colors">
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
                </div>
            </div>

            @else
            <!-- Jika Berita Kosong -->
            <div class="bg-slate-50 border border-slate-200/80 p-12 text-center rounded-2xl">
                <div class="flex flex-col items-center justify-center gap-3">
                    <div class="p-4 bg-orange-50 rounded-full text-orange-500 border border-orange-100">
                        <svg class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z" />
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-base font-bold text-slate-800">Belum Ada Berita Diterbitkan</h3>
                        <p class="text-xs text-slate-500 mt-1">Saat ini belum ada artikel berita yang dipublikasikan
                            oleh {{ $opdName }}.</p>
                    </div>
                </div>
            </div>
            @endif

            <!-- Paginasi Berita -->
            @if ($otherNews->hasPages())
            <div class="pt-8 border-t border-slate-100 flex flex-col sm:flex-row items-center justify-between gap-4">

                <!-- Nomor Halaman -->
                <ul class="flex items-center gap-2 text-xs font-bold">
                    @php
                    $start = max(1, $otherNews->currentPage() - 2);
                    $end = min($otherNews->lastPage(), $otherNews->currentPage() + 2);
                    @endphp

                    @if ($start > 1)
                    <li>
                        <a href="{{ $otherNews->url(1) }}"
                            class="px-3.5 py-2 bg-slate-100 hover:bg-orange-500 hover:text-white rounded-xl text-slate-700 transition-colors">1</a>
                    </li>
                    @if ($start > 2)
                    <li class="text-slate-400 px-1">...</li>
                    @endif
                    @endif

                    @for ($i = $start; $i <= $end; $i++) @if ($i==$otherNews->currentPage())
                        <li>
                            <span
                                class="px-3.5 py-2 bg-orange-500 text-white rounded-xl shadow-md shadow-orange-500/20">
                                {{ $i }}
                            </span>
                        </li>
                        @else
                        <li>
                            <a href="{{ $otherNews->url($i) }}"
                                class="px-3.5 py-2 bg-slate-100 hover:bg-orange-500 hover:text-white rounded-xl text-slate-700 transition-colors">
                                {{ $i }}
                            </a>
                        </li>
                        @endif
                        @endfor

                        @if ($end < $otherNews->lastPage())
                            @if ($end < $otherNews->lastPage() - 1)
                                <li class="text-slate-400 px-1">...</li>
                                @endif
                                <li>
                                    <a href="{{ $otherNews->url($otherNews->lastPage()) }}"
                                        class="px-3.5 py-2 bg-slate-100 hover:bg-orange-500 hover:text-white rounded-xl text-slate-700 transition-colors">
                                        {{ $otherNews->lastPage() }}
                                    </a>
                                </li>
                                @endif
                </ul>

                <!-- Tombol Navigasi -->
                <div class="flex items-center gap-2">
                    <a href="{{ $otherNews->previousPageUrl() }}"
                        class="{{ $otherNews->onFirstPage() ? 'pointer-events-none opacity-40' : 'hover:bg-orange-500 hover:text-white' }} px-3.5 py-2 bg-slate-100 text-slate-700 rounded-xl font-bold text-xs flex items-center gap-1 transition-colors">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                        </svg>
                        <span>Sebelumnya</span>
                    </a>

                    <a href="{{ $otherNews->nextPageUrl() }}"
                        class="{{ $otherNews->hasMorePages() ? 'hover:bg-orange-500 hover:text-white' : 'pointer-events-none opacity-40' }} px-3.5 py-2 bg-slate-100 text-slate-700 rounded-xl font-bold text-xs flex items-center gap-1 transition-colors">
                        <span>Berikutnya</span>
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                        </svg>
                    </a>
                </div>
            </div>
            @endif
        </div>
    </div>
</div>
@endsection