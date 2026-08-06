@props(['documents'])

@php
$opdSlug = env('APP_ID');
$opd = App\Models\Opd::where('slug', $opdSlug)->first();

$latestDocuments = $documents->where('opd_id', $opd?->id)->sortByDesc('published_at')->take(3);
$opdName = $opd?->name ?? 'Instansi';
@endphp

<section class="w-full bg-slate-100/70 py-16 border-y border-slate-200/80">
    <div class="max-w-screen-xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="bg-white rounded-3xl p-6 sm:p-10 border border-slate-200/80 shadow-sm">
            <!-- Header Dokumen -->
            <div
                class="flex flex-col sm:flex-row sm:items-end justify-between mb-8 gap-4 border-b border-slate-100 pb-6">
                <div>
                    <div
                        class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-orange-100 border border-orange-200/80 text-orange-600 text-[11px] font-extrabold uppercase tracking-widest mb-2">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                        Transparansi Publik
                    </div>
                    <h2 class="text-2xl sm:text-3xl font-black text-slate-900 tracking-tight">
                        Arsip Dokumen Perencanaan
                    </h2>
                    <p class="text-xs sm:text-sm text-slate-500 mt-1">
                        Dokumen perencanaan, laporan kinerja, dan arsip resmi {{ $opdName }}
                    </p>
                </div>

                <!-- Tombol Selengkapnya -->
                <a href="/planning-dokumen" wire:navigate
                    class="hidden sm:inline-flex items-center gap-2 px-5 py-2.5 rounded-full bg-slate-900 hover:bg-orange-500 text-white text-xs font-bold shadow-sm transition-all duration-200 group">
                    <span>Lihat Semua Dokumen</span>
                    <svg class="w-4 h-4 group-hover:translate-x-1 transition-transform" fill="none"
                        stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M14 5l7 7m0 0l-7 7m7-7H3" />
                    </svg>
                </a>
            </div>

            <!-- Daftar Dokumen -->
            <div class="space-y-4">
                @forelse($latestDocuments as $doc)
                <a href="/planning-dokumen/{{ $doc->slug }}"
                    class="group block p-5 rounded-2xl border border-slate-200/80 bg-white hover:border-orange-300 hover:shadow-lg transition-all duration-300">
                    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                        <!-- Ikon & Detail Dokumen -->
                        <div class="flex items-start gap-4 flex-grow">
                            <div
                                class="p-3.5 bg-orange-50 text-orange-600 border border-orange-100 rounded-2xl flex-none group-hover:bg-orange-500 group-hover:text-white group-hover:border-orange-500 transition-colors duration-300">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                </svg>
                            </div>

                            <!-- Detail Judul -->
                            <div class="space-y-1.5 flex-grow">
                                <div class="flex flex-wrap items-center gap-2">
                                    <span
                                        class="inline-block text-[10px] font-black text-slate-600 bg-slate-100 border border-slate-200 px-2 py-0.5 rounded-md uppercase tracking-wider">
                                        PDF / DOKUMEN
                                    </span>
                                </div>
                                <h3
                                    class="text-base sm:text-lg font-bold text-slate-800 group-hover:text-orange-600 transition-colors duration-200 line-clamp-2 leading-snug">
                                    {{ $doc->title }}
                                </h3>
                                <div
                                    class="flex flex-wrap items-center gap-x-4 gap-y-1 text-xs text-slate-400 font-medium">
                                    <!-- Tanggal Rilis -->
                                    <div class="flex items-center gap-1.5">
                                        <svg class="w-3.5 h-3.5 text-slate-400" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                        </svg>
                                        <span>{{ $doc->created_at?->isoFormat('D MMMM YYYY') ?? now()->isoFormat('D MMMM YYYY') }}</span>
                                    </div>
                                    <span class="text-slate-300">•</span>
                                    <!-- Instansi Terkait -->
                                    <div class="flex items-center gap-1.5">
                                        <svg class="w-3.5 h-3.5 text-slate-400" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5m0 0h4m-4 0V11m0 0V7" />
                                        </svg>
                                        <span>{{ $doc->opd->name ?? $opdName }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Tombol Indikator File -->
                        <div class="flex-none self-end sm:self-center pt-2 sm:pt-0">
                            <span
                                class="inline-flex items-center gap-1.5 px-4 py-2 rounded-xl bg-orange-50 group-hover:bg-orange-500 text-orange-600 group-hover:text-white font-bold text-xs transition-all duration-300 border border-orange-200/60 group-hover:border-orange-500 shadow-sm">
                                <span>Detail File</span>
                                <svg class="w-3.5 h-3.5 group-hover:translate-x-0.5 transition-transform" fill="none"
                                    stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M14 5l7 7m0 0l-7 7m7-7H3" />
                                </svg>
                            </span>
                        </div>
                    </div>
                </a>
                @empty
                <!-- Jika Dokumen Kosong -->
                <div class="bg-slate-50 border border-slate-200/80 p-8 text-center rounded-2xl">
                    <div class="flex flex-col items-center justify-center gap-2">
                        <div class="p-3 bg-orange-50 rounded-full text-orange-500 mb-1">
                            <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                            </svg>
                        </div>
                        <p class="text-sm font-bold text-slate-700">Belum Ada Dokumen Perencanaan</p>
                        <p class="text-xs text-slate-400">Saat ini belum ada dokumen perencanaan yang dipublikasikan
                            oleh {{ $opdName }}.</p>
                    </div>
                </div>
                @endforelse
            </div>

            <!-- Tombol Selengkapnya -->
            <div class="mt-8 pt-4 border-t border-slate-100 flex items-center justify-center sm:hidden">
                <a href="/planning-dokumen" wire:navigate
                    class="inline-flex items-center justify-center gap-2 px-6 py-3 rounded-xl bg-orange-500 text-white font-bold text-xs shadow-md shadow-orange-500/20 w-full">
                    <span>Lihat Seluruh Arsip Dokumen</span>
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M14 5l7 7m0 0l-7 7m7-7H3" />
                    </svg>
                </a>
            </div>
        </div>
    </div>
</section>