@php

$opdSlug = env('APP_ID');
$opd = App\Models\Opd::where('slug', $opdSlug)->first();

$otherNews = App\Models\News::where('opd_id', $opd?->id)->with('category')->latest()->paginate(9);
$newsCategory = App\Models\NewsCategories::where('opd_id', $opd?->id)->limit(7)->get();

$opdName = $opd->name ?? 'Instansi';
@endphp

@extends('layouts.app', ['activePage' => 'berita'])

@section('content')
<div class="w-full bg-slate-50/60 py-12 min-h-screen">
    <div class="max-w-screen-xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="bg-white rounded-3xl p-6 sm:p-10 border border-slate-200/80 shadow-sm space-y-8">

            <!-- Header Berita -->
            <div class="border-b border-slate-100 pb-6">
                <div
                    class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-orange-100 border border-orange-200/80 text-orange-600 text-[11px] font-extrabold uppercase tracking-widest mb-2">
                    <span class="w-2 h-2 rounded-full bg-orange-500 animate-pulse"></span>
                    Portal Informasi Publik
                </div>
                <h1 class="text-2xl sm:text-3xl lg:text-4xl font-black text-slate-900 tracking-tight">
                    Berita Terbaru {{ $opdName }}
                </h1>
                <p class="text-xs sm:text-sm text-slate-500 mt-1">
                    Kumpulan rilis berita, informasi kebijakan, dan dokumentasi kegiatan resmi dari {{ $opdName }}
                </p>
            </div>

            <!-- Komponen Kategori Berita -->
            <div class="pt-2">
                <x-commons.category-news :categories="$newsCategory" />
            </div>

            <!-- Grid Daftar Berita -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 sm:gap-8 pt-2">
                @forelse ($otherNews as $news)
                <div
                    class="group flex flex-col justify-between bg-white rounded-2xl border border-slate-200/80 hover:border-orange-300 hover:shadow-xl transition-all duration-300 overflow-hidden">
                    <div>
                        <!-- Thumbnail Foto Berita -->
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
                                <span>{{ $news->published_at?->isoFormat('D MMMM YYYY') ?? now()->isoFormat('D MMMM YYYY') }}</span>
                            </div>

                            <!-- Judul Berita -->
                            <a href="/berita/{{ $news->slug }}" class="block">
                                <h2
                                    class="text-base sm:text-lg font-bold text-slate-800 group-hover:text-orange-600 transition-colors leading-snug line-clamp-2">
                                    {{ $news->title }}
                                </h2>
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
                @empty
                <!-- Jika Berita Kosong -->
                <div class="col-span-full bg-slate-50 border border-slate-200/80 p-12 text-center rounded-2xl">
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
                @endforelse
            </div>

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