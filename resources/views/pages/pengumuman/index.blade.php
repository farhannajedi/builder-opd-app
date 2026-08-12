@php
$opdSlug = env('APP_ID');
$opd = App\Models\Opd::where('slug', $opdSlug)->first();

$announcements = App\Models\announcement::where('opd_id', $opd?->id)->with('opd')->latest()->paginate(9);
$opdName = $opd?->name ?? 'Instansi';
@endphp

@extends('layouts.app', ['activePage' => 'pengumuman'])

@section('content')
<div class="w-full bg-slate-50/60 py-10 min-h-screen">
    <div class="max-w-screen-xl mx-auto px-4 sm:px-6 lg:px-8 space-y-8">

        <!-- Header -->
        <div
            class="relative overflow-hidden bg-slate-900 text-white rounded-3xl p-8 sm:p-12 shadow-lg border border-slate-800">
            <div
                class="absolute -right-10 -bottom-10 w-64 h-64 bg-brand-500/10 rounded-full blur-3xl pointer-events-none">
            </div>
            <div class="relative z-10 max-w-3xl space-y-3">
                <div
                    class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-brand-500/20 border border-brand-500/30 text-brand-400 text-[9px] font-extrabold uppercase tracking-widest">
                    <span class="w-2 h-2 rounded-full bg-brand-400 animate-pulse"></span>
                    Pemberitahuan & Informasi Resmi
                </div>
                <h1 class="text-xl sm:text-2xl font-black tracking-tight leading-tight">
                    Papan Pengumuman Publik
                </h1>
                <p class="text-xs sm:text-sm text-slate-300 leading-relaxed">
                    Pusat penyampaian pengumuman resmi, edaran dinas, hasil seleksi, dan pemberitahuan penting untuk
                    masyarakat dari {{ $opdName }}.
                </p>
            </div>
        </div>

        <!-- Daftar Pengumuman -->
        <div class="bg-white rounded-3xl p-6 sm:p-10 border border-slate-200/80 shadow-xl space-y-8">
            <!-- Header -->
            <div class="flex items-center justify-between border-b border-slate-100 pb-5">
                <div class="flex items-center gap-2 text-slate-800 font-bold text-sm">
                    <span class="w-2.5 h-2.5 rounded-full bg-brand-500"></span>
                    <span>Daftar Pengumuman Aktif</span>
                </div>
                <span class="text-xs font-semibold text-slate-400">
                    Total {{ $announcements->total() }} Pengumuman Diterbitkan
                </span>
            </div>

            <!-- Grid Pengumuman -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                @forelse ($announcements as $item)
                <div
                    class="group relative flex flex-col justify-between p-6 bg-white rounded-2xl border border-slate-200/80 hover:border-brand-300 hover:shadow-xl transition-all duration-300 shadow-xl">
                    <div>
                        <!-- Header Kartu -->
                        <div class="flex items-start justify-between gap-4 mb-5">
                            <div
                                class="p-3.5 bg-brand-50 text-brand-600 border border-brand-100 rounded-2xl group-hover:bg-brand-500 group-hover:text-white group-hover:border-brand-500 transition-colors duration-300 shadow-sm">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>

                            <span
                                class="text-[10px] font-extrabold text-slate-600 bg-slate-100 border border-slate-200 px-2.5 py-1 rounded-lg uppercase tracking-wider">
                                PENGUMUMAN RESMI
                            </span>
                        </div>

                        <!-- Judul Pengumuman -->
                        <a href="/pengumuman/{{ $item->slug }}" class="block group/title">
                            <h2
                                class="text-base sm:text-lg font-bold text-slate-800 group-hover/title:text-brand-600 transition-colors leading-snug line-clamp-2 mb-3">
                                {{ $item->title }}
                            </h2>
                        </a>

                        <!-- Tanggal Upload OPD -->
                        <div
                            class="flex flex-wrap items-center gap-x-4 gap-y-1.5 text-xs text-slate-400 font-medium mb-6">
                            <div class="flex items-center gap-1.5">
                                <svg class="w-3.5 h-3.5 text-slate-400" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                                <span>{{ $item->created_at?->locale('id')->isoFormat('D MMMM YYYY') ?? now()->locale('id')->isoFormat('D MMMM YYYY') }}</span>
                            </div>

                            <span class="text-slate-300">•</span>

                            <div class="flex items-center gap-1.5">
                                <svg class="w-3.5 h-3.5 text-slate-400" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5m0 0h4m-4 0V11m0 0V7" />
                                </svg>
                                <span class="truncate max-w-[150px]">{{ $item->opd->name ?? $opdName }}</span>
                            </div>
                        </div>
                    </div>

                    <!-- Footer Aksi -->
                    <div class="pt-4 border-t border-slate-100 flex items-center justify-between">
                        <a href="/pengumuman/{{ $item->slug }}"
                            class="w-full inline-flex items-center justify-center gap-2 px-4 py-2.5 rounded-xl bg-slate-50 hover:bg-brand-500 text-slate-700 hover:text-white border border-slate-200/80 hover:border-brand-500 text-xs font-bold transition-all duration-200 shadow-sm">
                            <span>Lihat Pengumuman</span>
                            <svg class="w-3.5 h-3.5 group-hover:translate-x-1 transition-transform" fill="none"
                                stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M14 5l7 7m0 0l-7 7m7-7H3" />
                            </svg>
                        </a>
                    </div>
                </div>
                @empty
                <!-- Jika Pengumuman Kosong -->
                <div class="col-span-full bg-slate-50 border border-slate-200/80 p-12 text-center rounded-2xl">
                    <div class="flex flex-col items-center justify-center gap-3">
                        <div class="p-4 bg-brand-50 rounded-full text-brand-500 border border-brand-100">
                            <svg class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.684A1.761 1.761 0 013 12c0-.972.784-1.761 1.761-1.761l.675 1.922zm10.128-4.248a5 5 0 010 5.128" />
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-base font-bold text-slate-800">Belum Ada Pengumuman Terbaru</h3>
                            <p class="text-xs text-slate-500 mt-1">Saat ini belum ada edaran atau pengumuman resmi yang
                                diterbitkan oleh {{ $opdName }}.</p>
                        </div>
                    </div>
                </div>
                @endforelse
            </div>

            <!-- Paginasi Pengumuman Modern -->
            @if ($announcements->hasPages())
            <div class="pt-8 border-t border-slate-100">
                {{ $announcements->links() }}
            </div>
            @endif
        </div>
    </div>
</div>
@endsection