@php
$opdSlug = env('APP_ID');
$opd = \App\Models\Opd::where('slug', $opdSlug)->first();
$opdName = $opd?->name ?? 'Instansi';

// Ambil Menu Induk yang aktif berdasarkan parameter URL [menu_slug]
$menu = \App\Models\PageMenu::where('slug', $menu_slug)
->where('opd_id', $opd?->id)
->where('is_active', true)
->firstOrFail();

// Ambil semua halaman / badge di dalam Menu Induk ini
$pages = \App\Models\Page::where('page_menu_id', $menu->id)
->where('opd_id', $opd?->id)
->where('is_active', true)
->orderBy('order', 'asc')
->latest()
->paginate(9);
@endphp

@extends('layouts.app', ['activePage' => $menu->title])

@section('content')
<div class="w-full bg-slate-50/60 py-10 min-h-screen">
    <div class="max-w-screen-xl mx-auto px-4 sm:px-6 lg:px-8">

        <!-- Header Banner -->
        <div class="relative overflow-hidden bg-slate-900 text-white rounded-3xl p-8 sm:p-12 mb-10 shadow-lg">
            <div
                class="absolute -right-10 -bottom-10 w-64 h-64 bg-brand-500/10 rounded-full blur-3xl pointer-events-none">
            </div>
            <div class="relative z-10 max-w-2xl space-y-3">
                <div
                    class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-brand-500/20 border border-brand-500/30 text-brand-400 text-[9px] font-extrabold uppercase tracking-widest">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                    </svg>
                    Direktori Informasi
                </div>
                <h1 class="text-xl sm:text-2xl font-black tracking-tight leading-tight">
                    {{ $menu->title }}
                </h1>
                <p class="text-xs sm:text-sm text-slate-300 leading-relaxed">
                    {{ $menu->description ?? 'Kumpulan daftar informasi resmi yang diterbitkan oleh ' . $opdName . '.' }}
                </p>
            </div>
        </div>

        <!-- Kontainer Daftar Halaman -->
        <div class="bg-white rounded-3xl p-6 sm:p-10 border border-slate-200/80 shadow-sm space-y-8">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @forelse($pages as $item)
                <div
                    class="group relative flex flex-col justify-between p-6 bg-white rounded-2xl border border-slate-200/80 hover:border-brand-300 hover:shadow-xl transition-all duration-300">
                    <div>
                        <!-- Badge & Icon -->
                        <div class="flex items-start justify-between gap-4 mb-5">
                            <div
                                class="p-3.5 bg-brand-50 text-brand-600 border border-brand-100 rounded-2xl group-hover:bg-brand-500 group-hover:text-white group-hover:border-brand-500 transition-colors duration-300 shadow-sm">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                </svg>
                            </div>
                            <span
                                class="text-[10px] font-extrabold text-brand-600 bg-brand-50 border border-brand-100 px-2.5 py-1 rounded-lg uppercase tracking-wider">
                                {{ $item->badge_text ?? $menu->title }}
                            </span>
                        </div>

                        <!-- Judul Sub-Halaman -->
                        <a href="/halaman/{{ $menu->slug }}/{{ $item->slug }}" class="block group/title">
                            <h2
                                class="text-base sm:text-lg font-bold text-slate-800 group-hover/title:text-brand-600 transition-colors leading-snug line-clamp-2 mb-2">
                                {{ $item->title }}
                            </h2>
                        </a>

                        <!-- Ringkasan Sub-Halaman -->
                        <p class="text-xs text-slate-500 leading-relaxed line-clamp-3 mb-6">
                            {{ $item->subtitle ?? 'Klik tombol di bawah untuk melihat rincian informasi dan berkas dokumen lengkap.' }}
                        </p>
                    </div>

                    <!-- Tombol Aksi Masuk ke Rincian Isi Halaman -->
                    <div class="pt-4 border-t border-slate-100">
                        <a href="/halaman/{{ $menu->slug }}/{{ $item->slug }}"
                            class="w-full inline-flex items-center justify-center gap-2 px-4 py-2.5 rounded-xl bg-slate-50 hover:bg-brand-500 text-slate-700 hover:text-white border border-slate-200/80 hover:border-brand-500 text-xs font-bold transition-all duration-200 shadow-sm">
                            <span>Akses Rincian Informasi</span>
                            <svg class="w-3.5 h-3.5 group-hover:translate-x-1 transition-transform" fill="none"
                                stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M14 5l7 7m0 0l-7 7m7-7H3" />
                            </svg>
                        </a>
                    </div>
                </div>
                @empty
                <div class="col-span-full bg-slate-50 border border-slate-200/80 p-12 text-center rounded-2xl">
                    <p class="text-sm text-slate-500">Belum ada informasi yang terdaftar pada menu {{ $menu->title }}.
                    </p>
                </div>
                @endforelse
            </div>

            @if ($pages->hasPages())
            <div class="pt-8 border-t border-slate-100">
                {{ $pages->links() }}
            </div>
            @endif
        </div>
    </div>
</div>
@endsection