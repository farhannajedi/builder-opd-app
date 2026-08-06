@php
$opdSlug = env('APP_ID');
$opd = App\Models\Opd::where('slug', $opdSlug)->first();

// Query untuk mengambil dokumen terbaru
$documents = App\Models\PlanningDocument::where('opd_id', $opd?->id)->with('opd')->latest()->paginate(10);
$opdName = $opd?->name ?? 'Instansi';
@endphp

@extends('layouts.app', ['activePage' => 'Arsip Dokumen'])

@section('content')
<div class="w-full bg-slate-50/60 py-10 min-h-screen">
    <div class="max-w-screen-xl mx-auto px-4 sm:px-6 lg:px-8">
        <div
            class="relative overflow-hidden bg-slate-900 text-white rounded-3xl p-8 sm:p-12 mb-10 shadow-lg border border-slate-800">
            <div
                class="absolute -right-10 -bottom-10 w-64 h-64 bg-orange-500/10 rounded-full blur-3xl pointer-events-none">
            </div>
            <div class="relative z-10 max-w-3xl space-y-3">
                <div
                    class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-orange-500/20 border border-orange-500/30 text-orange-400 text-[9px] font-extrabold uppercase tracking-widest">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                    Repositori Data Terbuka (Open Data)
                </div>
                <h1 class="text-xl sm:text-2xl font-black tracking-tight leading-tight">
                    Arsip Dokumen Perencanaan Resmi
                </h1>
                <p class="text-xs sm:text-sm text-slate-300 leading-relaxed">
                    Akses transparan seluruh dokumen perencanaan publik, laporan kinerja tahunan, serta arsip kebijakan
                    publik dari {{ $opdName }}.
                </p>
            </div>
        </div>

        <!-- Daftar Dokumen -->
        <div class="bg-white rounded-3xl p-6 sm:p-10 border border-slate-200/80 shadow-sm space-y-6">

            <!-- Filter & Judul Seksi -->
            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 border-b border-slate-100 pb-5">
                <div class="flex items-center gap-2 text-slate-800 font-bold text-sm">
                    <span class="w-2.5 h-2.5 rounded-full bg-orange-500"></span>
                    <span>Daftar Berkas Dokumen Publik</span>
                </div>
                <span class="text-xs font-semibold text-slate-400">
                    Menampilkan {{ $documents->firstItem() ?? 0 }} - {{ $documents->lastItem() ?? 0 }} dari
                    {{ $documents->total() }} Dokumen
                </span>
            </div>
            <div class="space-y-4">
                @forelse ($documents as $doc)
                <div
                    class="group relative bg-white rounded-2xl border border-slate-200/80 hover:border-orange-300 hover:shadow-lg transition-all duration-300 p-5 sm:p-6">
                    <div class="flex flex-col md:flex-row md:items-center justify-between gap-5">

                        <!-- Judul -->
                        <div class="flex items-start gap-4 flex-grow min-w-0">
                            <!-- Ikon Tipe Dokumen Visual -->
                            <div
                                class="p-3.5 bg-orange-50 text-orange-600 border border-orange-100 rounded-2xl flex-none group-hover:bg-orange-500 group-hover:text-white group-hover:border-orange-500 transition-colors duration-300 shadow-sm">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                </svg>
                            </div>

                            <!-- Detail Teks -->
                            <div class="space-y-2 flex-grow min-w-0">
                                <div class="flex flex-wrap items-center gap-2">
                                    <span
                                        class="text-[10px] font-black text-slate-700 bg-slate-100 border border-slate-200 px-2 py-0.5 rounded-md uppercase tracking-wider">
                                        PDF / DOKUMEN
                                    </span>
                                    <span class="text-xs text-slate-400">•</span>
                                    <span class="text-xs text-slate-400 font-medium">Terbitan Resmi</span>
                                </div>

                                <a href="/planning-dokumen/{{ $doc->slug }}" class="block group/title">
                                    <h2
                                        class="text-base sm:text-lg font-bold text-slate-800 group-hover/title:text-orange-600 transition-colors leading-snug line-clamp-2">
                                        {{ $doc->title }}
                                    </h2>
                                </a>

                                <!-- Metadata -->
                                <div
                                    class="flex flex-wrap items-center gap-x-4 gap-y-1 text-xs text-slate-400 font-medium">
                                    <div class="flex items-center gap-1.5">
                                        <svg class="w-3.5 h-3.5 text-slate-400" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                        </svg>
                                        <span>{{ $doc->created_at?->isoFormat('D MMMM YYYY') ?? now()->isoFormat('D MMMM YYYY') }}</span>
                                    </div>

                                    <span class="text-slate-300">•</span>

                                    <div class="flex items-center gap-1.5">
                                        <svg class="w-3.5 h-3.5 text-slate-400" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5m0 0h4m-4 0V11m0 0V7" />
                                        </svg>
                                        <span class="truncate max-w-[200px]">{{ $doc->opd->name ?? $opdName }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Tombol Aksi -->
                        <div
                            class="flex-none self-end md:self-center w-full md:w-auto pt-3 md:pt-0 border-t md:border-t-0 border-slate-100">
                            <a href="/planning-dokumen/{{ $doc->slug }}"
                                class="inline-flex items-center justify-center gap-2 w-full md:w-auto px-5 py-2.5 rounded-xl bg-slate-50 hover:bg-orange-500 text-slate-700 hover:text-white border border-slate-200/80 hover:border-orange-500 text-xs font-bold transition-all duration-200 shadow-sm">
                                <span>Pratinjau & Unduh</span>
                                <svg class="w-3.5 h-3.5 group-hover:translate-x-1 transition-transform" fill="none"
                                    stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M14 5l7 7m0 0l-7 7m7-7H3" />
                                </svg>
                            </a>
                        </div>
                    </div>
                </div>
                @empty
                <!--  Jika Dokumen Kosong -->
                <div class="bg-slate-50 border border-slate-200/80 p-12 text-center rounded-2xl">
                    <div class="flex flex-col items-center justify-center gap-3">
                        <div class="p-4 bg-orange-50 rounded-full text-orange-500 border border-orange-100">
                            <svg class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-base font-bold text-slate-800">Belum Ada Dokumen Perencanaan</h3>
                            <p class="text-xs text-slate-500 mt-1">Saat ini belum ada arsip dokumen yang dipublikasikan
                                oleh {{ $opdName }}.</p>
                        </div>
                    </div>
                </div>
                @endforelse
            </div>

            <!-- Paginasi Dokumen -->
            @if ($documents->hasPages())
            <div class="pt-8 border-t border-slate-100">
                {{ $documents->links() }}
            </div>
            @endif
        </div>
    </div>
</div>
@endsection