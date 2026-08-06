@php
$opdSlug = env('APP_ID');
$opd = App\Models\Opd::where('slug', $opdSlug)->first();

// Query untuk mengambil dokumen terbaru
$documents = App\Models\PlanningDocument::where('opd_id', $opd?->id)->with('opd')->latest()->paginate(10);
$opdName = $opd?->name ?? 'Instansi';
@endphp

@extends('layouts.app', ['activePage' => 'Arsip Dokumen'])

@section('content')
<div class="w-full bg-slate-50/60 py-12 min-h-screen">
    <div class="max-w-screen-xl mx-auto px-4 sm:px-6 lg:px-8">

        <!-- Wrapper Utama -->
        <div class="bg-white rounded-3xl p-6 sm:p-10 border border-slate-200/80 shadow-sm space-y-8">

            <!-- Header Dokumen -->
            <div class="border-b border-slate-100 pb-6">
                <div
                    class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-orange-100 border border-orange-200/80 text-orange-600 text-[11px] font-extrabold uppercase tracking-widest mb-2">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                    Transparansi Publik & Open Data
                </div>
                <h1 class="text-xl sm:text-3xl lg:text-2xl font-black text-slate-900 tracking-tight">
                    Arsip Dokumen Perencanaan
                </h1>
                <p class="text-xs sm:text-sm text-slate-500 mt-1">
                    Direktori dokumen perencanaan publik, laporan kinerja, dan arsip kebijakan resmi dari {{ $opdName }}
                </p>
            </div>

            <!-- Grid Kartu Dokumen -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                @forelse ($documents as $doc)
                <div
                    class="group relative flex flex-col justify-between p-6 bg-white rounded-2xl border border-slate-200/80 hover:border-orange-300 hover:shadow-xl transition-all duration-300">

                    <div>
                        <!-- Badge Tipe File -->
                        <div class="flex items-center justify-between gap-3 mb-4">
                            <div
                                class="p-3.5 bg-orange-50 text-orange-600 border border-orange-100 rounded-2xl group-hover:bg-orange-500 group-hover:text-white group-hover:border-orange-500 transition-colors duration-300 shadow-sm">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                </svg>
                            </div>

                            <span
                                class="text-[10px] font-black text-slate-600 bg-slate-100 border border-slate-200 px-2.5 py-1 rounded-lg uppercase tracking-wider">
                                PDF / DOKUMEN
                            </span>
                        </div>

                        <!-- Judul Dokumen -->
                        <a href="/planning-dokumen/{{ $doc->slug }}" class="block group/title">
                            <h2
                                class="text-base sm:text-lg font-bold text-slate-800 group-hover/title:text-orange-600 transition-colors leading-snug line-clamp-2 mb-3">
                                {{ $doc->title }}
                            </h2>
                        </a>

                        <!-- Metadata -->
                        <div
                            class="flex flex-wrap items-center gap-x-4 gap-y-1.5 text-xs text-slate-400 font-medium mb-6">
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
                                <span class="truncate">{{ $doc->opd->name ?? $opdName }}</span>
                            </div>
                        </div>
                    </div>

                    <!-- Tombol Detail File -->
                    <div class="pt-4 border-t border-slate-100 flex items-center justify-between">
                        <a href="/planning-dokumen/{{ $doc->slug }}"
                            class="w-full inline-flex items-center justify-center gap-2 px-4 py-2.5 rounded-xl bg-slate-50 hover:bg-orange-500 text-slate-700 hover:text-white border border-slate-200/80 hover:border-orange-500 text-xs font-bold transition-all duration-200 shadow-sm">
                            <span>Detail File Dokumen</span>
                            <svg class="w-3.5 h-3.5 group-hover:translate-x-1 transition-transform" fill="none"
                                stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M14 5l7 7m0 0l-7 7m7-7H3" />
                            </svg>
                        </a>
                    </div>

                </div>
                @empty
                <!-- Jika Dokumen Kosong -->
                <div class="col-span-full bg-slate-50 border border-slate-200/80 p-12 text-center rounded-2xl">
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

            <!-- Paginasi Dokumen Modern -->
            @if ($documents->hasPages())
            <div class="pt-8 border-t border-slate-100">
                {{ $documents->links() }}
            </div>
            @endif
        </div>
    </div>
</div>
@endsection