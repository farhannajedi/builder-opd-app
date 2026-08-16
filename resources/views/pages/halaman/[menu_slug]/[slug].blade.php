@php
$opdSlug = env('APP_ID');
$opd = \App\Models\Opd::where('slug', $opdSlug)->first();

// Ambil data sub-halaman berdasarkan parameter [slug] dan opd_id yang aktif
$page = \App\Models\Page::where('slug', $slug)
->where('opd_id', $opd?->id)
->where('is_active', true)
->firstOrFail();

$menu = $page->page_menu;
@endphp

@extends('layouts.app', ['activePage' => $menu?->title])

@section('content')
<div class="w-full bg-slate-50/60 py-10 min-h-screen">
    <div class="max-w-screen-xl mx-auto px-4 sm:px-6 lg:px-8">

        <!-- Navigasi -->
        <nav class="flex items-center gap-2 mb-6 text-xs font-semibold text-slate-500 overflow-x-auto pb-2">
            <a href="{{ url('/') }}" class="hover:text-brand-600 transition-colors flex items-center gap-1 shrink-0">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                </svg>
                Beranda
            </a>
            <span class="text-slate-300">/</span>
            <a href="{{ url('/halaman/' . $menu?->slug) }}" class="hover:text-brand-600 transition-colors shrink-0">
                {{ $menu?->title }}
            </a>
            <span class="text-slate-300">/</span>
            <span class="text-slate-800 font-bold truncate max-w-[200px] sm:max-w-xs">{{ $page->title }}</span>
        </nav>

        <!-- Header Section -->
        <div class="relative overflow-hidden bg-slate-900 text-white rounded-3xl p-8 sm:p-12 mb-10 shadow-lg">
            <div
                class="absolute -right-10 -bottom-10 w-64 h-64 bg-brand-500/10 rounded-full blur-3xl pointer-events-none">
            </div>

            <div class="relative z-10 max-w-2xl space-y-3">
                @if(!empty($page->badge_text))
                <div
                    class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-brand-500/20 border border-brand-500/30 text-brand-400 text-[9px] font-extrabold uppercase tracking-widest">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                    </svg>
                    {{ $page->badge_text }}
                </div>
                @endif

                <h1 class="text-xl sm:text-2xl font-black tracking-tight leading-tight">
                    {{ $page->title }}
                </h1>

                @if(!empty($page->subtitle))
                <p class="text-xs sm:text-sm text-slate-300 leading-relaxed">
                    {{ $page->subtitle }}
                </p>
                @endif
            </div>
        </div>

        <!-- Render Blok Konten Dinamis (Teks, Gambar, PDF) -->
        <div class="space-y-8">
            @if(!empty($page->content) && is_array($page->content))
            @foreach ($page->content as $block)

            {{-- Blok Teks / Paragraf Bebas --}}
            @if (($block['type'] ?? '') === 'paragraph')
            <div class="bg-white rounded-3xl p-6 sm:p-10 border border-slate-200/80 shadow-sm">
                <div class="prose prose-slate max-w-none text-slate-700 text-sm sm:text-base leading-relaxed">
                    {!! $block['data']['text'] ?? '' !!}
                </div>
            </div>

            {{-- Blok Gambar / Foto --}}
            @elseif (($block['type'] ?? '') === 'image_block')
            <div class="bg-white rounded-3xl p-6 sm:p-8 border border-slate-200/80 shadow-sm text-center">
                <img src="{{ Storage::url($block['data']['image_url']) }}" alt="Gambar"
                    class="mx-auto rounded-2xl max-h-[500px] w-full object-cover border border-slate-100 shadow-sm">
                @if(!empty($block['data']['caption']))
                <p class="text-xs text-slate-500 mt-3 italic font-medium">{{ $block['data']['caption'] }}</p>
                @endif
            </div>

            {{-- Blok Dokumen PDF --}}
            @elseif (($block['type'] ?? '') === 'pdf_document')
            <div
                class="bg-white rounded-2xl p-5 border border-slate-200/80 shadow-sm flex items-center justify-between gap-4">
                <div class="flex items-center gap-3">
                    <div class="p-3 bg-red-50 text-red-600 rounded-xl border border-red-100">
                        <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20">
                            <path
                                d="M4 4a2 2 0 012-2h4.586A2 2 0 0112 2.586L15.414 6A2 2 0 0116 7.414V16a2 2 0 01-2 2H6a2 2 0 01-2-2V4z" />
                        </svg>
                    </div>
                    <div>
                        <h4 class="text-sm font-bold text-slate-800">{{ $block['data']['doc_title'] ?? 'Dokumen PDF' }}
                        </h4>
                        <p class="text-[11px] text-slate-400">Berkas Lampiran Resmi</p>
                    </div>
                </div>
                <a href="{{ Storage::url($block['data']['file_path']) }}" target="_blank" download
                    class="inline-flex items-center gap-2 px-4 py-2 rounded-xl bg-brand-50 hover:bg-brand-500 text-brand-600 hover:text-white border border-brand-200 text-xs font-bold transition-all">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                    </svg>
                    Unduh PDF
                </a>
            </div>
            @endif

            @endforeach
            @else
            <div class="bg-white rounded-3xl p-12 border border-slate-200/80 text-center">
                <p class="text-sm text-slate-500">Belum ada blok konten yang ditambahkan pada halaman ini.</p>
            </div>
            @endif
        </div>

        <!-- Tombol Kembali ke Indeks Menu -->
        <div class="mt-8">
            <a href="{{ url('/halaman/' . $menu?->slug) }}"
                class="inline-flex items-center gap-2 text-xs font-bold text-slate-600 hover:text-brand-600 transition">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                    stroke="currentColor" class="size-6">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 15.75 3 12m0 0 3.75-3.75M3 12h18" />
                </svg>
                Kembali ke Daftar {{ $menu?->title }}
            </a>
        </div>

    </div>
</div>
@endsection