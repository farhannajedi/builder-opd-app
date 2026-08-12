@php
$opdSlug = env('APP_ID');
$opd = App\Models\Opd::where('slug', $opdSlug)->first();

// Ambil semua layanan yang sudah dipublish
$services = App\Models\Service::where('opd_id', $opd?->id)->with('opd')->latest()->paginate(9);
$opdName = $opd?->name ?? 'Instansi';
@endphp

@extends('layouts.app', ['activePage' => 'Layanan'])

@section('content')
<div class="w-full bg-slate-50/60 py-10 min-h-screen">
    <div class="max-w-screen-xl mx-auto px-4 sm:px-6 lg:px-8">

        <!-- Header -->
        <div class="relative overflow-hidden bg-slate-900 text-white rounded-3xl p-8 sm:p-12 mb-10 shadow-lg">
            <div
                class="absolute -right-10 -bottom-10 w-64 h-64 bg-brand-500/10 rounded-full blur-3xl pointer-events-none">
            </div>
            <div class="relative z-10 max-w-2xl space-y-3">
                <div
                    class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-brand-500/20 border border-brand-500/30 text-brand-400 text-[9px] font-extrabold uppercase tracking-widest">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                    </svg>
                    Portal Direktori Publik
                </div>
                <h1 class="text-xl sm:text-2xl font-black tracking-tight leading-tight">
                    Layanan Instansi
                </h1>
                <p class="text-xs sm:text-sm text-slate-300 leading-relaxed">
                    Direktori lengkap aplikasi, portal informasi, dan kemudahan fasilitas pelayanan publik terpadu dari
                    {{ $opdName }}.
                </p>
            </div>
        </div>

        <!-- Daftar Layanan -->
        <div class="bg-white rounded-3xl p-6 sm:p-10 border border-slate-200/80 shadow-sm space-y-8">

            <!-- Grid Layanan -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @forelse($services as $service)
                <div
                    class="group relative flex flex-col justify-between p-6 bg-white rounded-2xl border border-slate-200/80 hover:border-brand-300 hover:shadow-xl transition-all duration-300">

                    <div>
                        <!-- Ikon & Badge Status -->
                        <div class="flex items-start justify-between gap-4 mb-5">
                            <div
                                class="p-3.5 bg-brand-50 text-brand-600 border border-brand-100 rounded-2xl group-hover:bg-brand-500 group-hover:text-white group-hover:border-brand-500 transition-colors duration-300 shadow-sm">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z" />
                                </svg>
                            </div>

                            <span
                                class="text-[10px] font-extrabold text-slate-600 bg-slate-100 border border-slate-200 px-2.5 py-1 rounded-lg uppercase tracking-wider">
                                LAYANAN PUBLIK
                            </span>
                        </div>

                        <!-- Nama Layanan -->
                        <a href="/layanan/{{ $service->id }}" class="block group/title">
                            <h2
                                class="text-base sm:text-lg font-bold text-slate-800 group-hover/title:text-brand-600 transition-colors leading-snug line-clamp-2 mb-2">
                                {{ $service->name }}
                            </h2>
                        </a>

                        <!-- Deskripsi -->
                        <p class="text-xs text-slate-500 leading-relaxed line-clamp-3 mb-6">
                            {{ $service->description }}
                        </p>
                    </div>

                    <!-- Tombol Aksi -->
                    <div class="pt-4 border-t border-slate-100 flex items-center justify-between">
                        <a href="/layanan/{{ $service->id }}"
                            class="w-full inline-flex items-center justify-center gap-2 px-4 py-2.5 rounded-xl bg-slate-50 hover:bg-brand-500 text-slate-700 hover:text-white border border-slate-200/80 hover:border-brand-500 text-xs font-bold transition-all duration-200 shadow-sm">
                            <span>Akses Detail Layanan</span>
                            <svg class="w-3.5 h-3.5 group-hover:translate-x-1 transition-transform" fill="none"
                                stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M14 5l7 7m0 0l-7 7m7-7H3" />
                            </svg>
                        </a>
                    </div>
                </div>
                @empty
                <!-- Jika Data Layanan Kosong -->
                <div class="col-span-full bg-slate-50 border border-slate-200/80 p-12 text-center rounded-2xl">
                    <div class="flex flex-col items-center justify-center gap-3">
                        <div class="p-4 bg-brand-50 rounded-full text-brand-500 border border-brand-100">
                            <svg class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-base font-bold text-slate-800">Belum Ada Layanan Disediakan</h3>
                            <p class="text-xs text-slate-500 mt-1">Saat ini belum ada fasilitas layanan publik yang
                                terdaftar untuk {{ $opdName }}.</p>
                        </div>
                    </div>
                </div>
                @endforelse
            </div>

            <!-- Paginasi Layanan -->
            @if ($services->hasPages())
            <div class="pt-8 border-t border-slate-100">
                {{ $services->links() }}
            </div>
            @endif
        </div>
    </div>
</div>
@endsection