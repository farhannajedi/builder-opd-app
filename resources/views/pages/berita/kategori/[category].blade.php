@php

// Filter OPD berdasarkan APP_ID
$opdSlug = env('APP_ID');
$opd = App\Models\Opd::where('slug', $opdSlug)->first();

$categoryList = App\Models\NewsCategories::where('opd_id', $opd?->id)->get();
$categoryData = App\Models\NewsCategories::where('slug', $category)->where('opd_id', $opd?->id)->firstOrFail();

$news = App\Models\News::where('category_id', $categoryData->id)
->where('opd_id', $opd?->id)
->orderBy('published_at', 'desc')
->paginate(9);

$opdName = $opd?->name ?? 'Instansi';
@endphp

@extends('layouts.app', ['activePage' => 'berita'])

@section('content')
<div class="w-full bg-slate-50/60 py-10 min-h-screen">
    <div class="max-w-screen-xl mx-auto px-4 sm:px-6 lg:px-8 space-y-8">
        <!-- Header Kategori -->
        <div
            class="relative overflow-hidden bg-slate-900 text-white rounded-3xl p-8 sm:p-10 shadow-lg border border-slate-800">
            <div
                class="absolute -right-10 -bottom-10 w-64 h-64 bg-orange-500/10 rounded-full blur-3xl pointer-events-none">
            </div>

            <div class="relative z-10 flex flex-col md:flex-row md:items-center justify-between gap-6">
                <div class="space-y-3 max-w-2xl">
                    <div
                        class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-orange-500/20 border border-orange-500/30 text-orange-400 text-[8px] font-extrabold uppercase tracking-widest">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z" />
                        </svg>
                        Arsip Berita Kategori
                    </div>

                    <h1 class="text-xl sm:text-2xl font-black tracking-tight leading-tight">
                        {{ $categoryData->title }}
                    </h1>

                    <p class="text-xs sm:text-sm text-slate-300 leading-relaxed">
                        Menampilkan kumpulan publikasi artikel dan rilis berita dalam topik <span
                            class="text-orange-400 font-bold">{{ $categoryData->title }}</span> dari {{ $opdName }}.
                    </p>
                </div>

                <!-- Navigasi Kembali ke Semua Berita -->
                <div class="flex-none">
                    <a href="{{ url('/berita') }}"
                        class="inline-flex items-center gap-2 px-5 py-2.5 rounded-full bg-white/10 hover:bg-orange-500 text-white border border-white/20 hover:border-orange-500 text-xs font-bold transition-all backdrop-blur-md shadow-sm">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                        </svg>
                        <span>Lihat Semua Berita</span>
                    </a>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-3xl p-6 sm:p-10 border border-slate-200/80 shadow-sm space-y-8">
            <!-- Komponen Pilih Kategori Lain -->
            <div class="border-b border-slate-100 pb-6">
                <div class="flex items-center justify-between mb-3">
                    <span class="text-xs font-bold text-slate-400 uppercase tracking-wider">Pilih Kategori
                        Lainnya</span>
                    <span class="text-xs font-semibold text-slate-500">
                        Total {{ $news->total() }} Artikel Ditemukan
                    </span>
                </div>
                <x-commons.category-news :categories="$categoryList" />
            </div>

            <!-- Daftar Berita Kategori -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 sm:gap-8">
                @forelse ($news as $item)
                <div
                    class="group flex flex-col justify-between bg-white rounded-2xl border border-slate-200/80 hover:border-orange-300 hover:shadow-xl transition-all duration-300 overflow-hidden">
                    <div>
                        <!-- Thumbnail Foto Berita -->
                        <div class="relative aspect-[16/9] w-full overflow-hidden bg-slate-100">
                            <span
                                class="absolute top-3 left-3 z-10 px-3 py-1 bg-rose-500 text-white text-[10px] font-bold uppercase tracking-wider rounded-lg shadow-sm">
                                {{ $categoryData->title }}
                            </span>

                            <img src="{{ asset('storage/' . $item->images) }}"
                                class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105"
                                alt="{{ $item->title }}">

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
                                <span>{{ $item->published_at?->locale('id')->isoFormat('D MMMM YYYY') ?? now()->locale('id')->isoFormat('D MMMM YYYY') }}</span>
                            </div>

                            <!-- Judul Berita -->
                            <a href="/berita/{{ $item->slug }}" class="block">
                                <h2
                                    class="text-base sm:text-lg font-bold text-slate-800 group-hover:text-orange-600 transition-colors leading-snug line-clamp-2">
                                    {{ $item->title }}
                                </h2>
                            </a>
                        </div>
                    </div>

                    <!-- Link Selengkapnya -->
                    <div class="p-5 pt-0">
                        <a href="/berita/{{ $item->slug }}"
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
                            <h3 class="text-base font-bold text-slate-800">Belum Ada Berita Dalam Kategori Ini</h3>
                            <p class="text-xs text-slate-500 mt-1">Saat ini belum ada publikasi berita untuk topik <span
                                    class="font-bold text-slate-700">{{ $categoryData->title }}</span>.</p>
                        </div>
                        <a href="{{ url('/berita') }}"
                            class="mt-2 inline-flex items-center gap-1.5 text-xs font-bold text-orange-600 hover:text-orange-700">
                            <span>Kembali ke Semua Berita</span>
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M14 5l7 7m0 0l-7 7m7-7H3" />
                            </svg>
                        </a>
                    </div>
                </div>
                @endforelse
            </div>

            @if ($news->hasPages())
            <div class="pt-8 border-t border-slate-100 flex flex-col sm:flex-row items-center justify-between gap-4">

                <!-- Nomor Halaman -->
                <ul class="flex items-center gap-2 text-xs font-bold">
                    @php
                    $start = max(1, $news->currentPage() - 2);
                    $end = min($news->lastPage(), $news->currentPage() + 2);
                    @endphp

                    @if ($start > 1)
                    <li>
                        <a href="{{ $news->url(1) }}"
                            class="px-3.5 py-2 bg-slate-100 hover:bg-orange-500 hover:text-white rounded-xl text-slate-700 transition-colors">1</a>
                    </li>
                    @if ($start > 2)
                    <li class="text-slate-400 px-1">...</li>
                    @endif
                    @endif

                    @for ($i = $start; $i <= $end; $i++) @if ($i==$news->currentPage())
                        <li>
                            <span
                                class="px-3.5 py-2 bg-orange-500 text-white rounded-xl shadow-md shadow-orange-500/20">
                                {{ $i }}
                            </span>
                        </li>
                        @else
                        <li>
                            <a href="{{ $news->url($i) }}"
                                class="px-3.5 py-2 bg-slate-100 hover:bg-orange-500 hover:text-white rounded-xl text-slate-700 transition-colors">
                                {{ $i }}
                            </a>
                        </li>
                        @endif
                        @endfor

                        @if ($end < $news->lastPage())
                            @if ($end < $news->lastPage() - 1)
                                <li class="text-slate-400 px-1">...</li>
                                @endif
                                <li>
                                    <a href="{{ $news->url($news->lastPage()) }}"
                                        class="px-3.5 py-2 bg-slate-100 hover:bg-orange-500 hover:text-white rounded-xl text-slate-700 transition-colors">
                                        {{ $news->lastPage() }}
                                    </a>
                                </li>
                                @endif
                </ul>

                <!-- Tombol Navigasi -->
                <div class="flex items-center gap-2">
                    <a href="{{ $news->previousPageUrl() }}"
                        class="{{ $news->onFirstPage() ? 'pointer-events-none opacity-40' : 'hover:bg-orange-500 hover:text-white' }} px-3.5 py-2 bg-slate-100 text-slate-700 rounded-xl font-bold text-xs flex items-center gap-1 transition-colors">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                        </svg>
                        <span>Sebelumnya</span>
                    </a>

                    <a href="{{ $news->nextPageUrl() }}"
                        class="{{ $news->hasMorePages() ? 'hover:bg-orange-500 hover:text-white' : 'pointer-events-none opacity-40' }} px-3.5 py-2 bg-slate-100 text-slate-700 rounded-xl font-bold text-xs flex items-center gap-1 transition-colors">
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