@php
$opdSlug = env('APP_ID');
$opd = App\Models\Opd::where('slug', $opdSlug)->first();

$galleries = App\Models\Galleries::where('opd_id', $opd?->id)->with('opd')->latest()->paginate(9);
$opdName = $opd?->name ?? 'Instansi';
@endphp

@extends('layouts.app', ['activePage' => 'galeri'])

@section('content')
<div class="w-full bg-slate-50/60 py-10 min-h-screen">
    <div class="max-w-screen-xl mx-auto px-4 sm:px-6 lg:px-8 space-y-8">
        <!-- Header Banner -->
        <div
            class="relative overflow-hidden bg-slate-900 text-white rounded-3xl p-8 sm:p-12 shadow-lg border border-slate-800">
            <div
                class="absolute -right-10 -bottom-10 w-64 h-64 bg-brand-500/10 rounded-full blur-3xl pointer-events-none">
            </div>
            <div class="relative z-10 max-w-3xl space-y-3">
                <div
                    class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-brand-500/20 border border-brand-500/30 text-brand-400 text-[9px] font-extrabold uppercase tracking-widest">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                    </svg>
                    Media & Dokumentasi Publik
                </div>
                <h1 class="text-xl sm:text-2xl font-black tracking-tight leading-tight">
                    Galeri Foto {{ $opdName }}
                </h1>
                <p class="text-xs sm:text-sm text-slate-300 leading-relaxed">
                    Arsip dokumentasi visual liputan program kerja, kunjungan dinas, dan kegiatan kemasyarakatan dari
                    {{ $opdName }}.
                </p>
            </div>
        </div>

        <!-- Daftar Galeri -->
        <div class="bg-white rounded-3xl p-6 sm:p-10 border border-slate-200/80 shadow-sm space-y-8">
            <div class="flex items-center justify-between border-b border-slate-100 pb-5">
                <div class="flex items-center gap-2 text-slate-800 font-bold text-sm">
                    <span class="w-2.5 h-2.5 rounded-full bg-brand-500"></span>
                    <span>Koleksi Album Foto Resmi</span>
                </div>
                <span class="text-xs font-semibold text-slate-400">
                    Total {{ $galleries->total() }} Foto Diterbitkan
                </span>
            </div>

            <!-- Grid Foto -->
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6">
                @forelse ($galleries as $gal)
                <div
                    class="group relative flex flex-col justify-between overflow-hidden rounded-2xl border border-slate-200/80 bg-white hover:border-brand-300 hover:shadow-xl transition-all duration-300">
                    <div>
                        <!-- Gambar Visual -->
                        <div class="relative aspect-[4/3] w-full overflow-hidden bg-slate-900">
                            <span
                                class="absolute top-3 right-3 z-10 px-2.5 py-1 bg-slate-900/80 backdrop-blur-md text-white border border-white/20 text-[10px] font-semibold rounded-lg shadow-sm">
                                {{ $gal->published_at ? \Carbon\Carbon::parse($gal->published_at)->locale('id')->isoFormat('D MMM Y') : $gal->created_at->isoFormat('D MMM Y') }}
                            </span>

                            <img src="{{ asset('storage/' . $gal->images) }}" alt="{{ $gal->title }}"
                                class="h-full w-full object-cover transition-transform duration-700 group-hover:scale-110">

                            <div
                                class="absolute inset-0 bg-gradient-to-t from-slate-950/80 via-slate-950/20 to-transparent opacity-60 group-hover:opacity-80 transition-opacity">
                            </div>
                        </div>

                        <!-- Detail Deskripsi Teks -->
                        <div class="p-5">
                            <span
                                class="block text-[10px] font-extrabold text-brand-600 uppercase tracking-wider mb-1.5">
                                {{ $gal->opd->name ?? $opdName }}
                            </span>

                            <a href="{{ url('galeri/' . $gal->slug) }}" class="block group/title">
                                <h3
                                    class="text-base font-bold text-slate-800 group-hover/title:text-brand-600 transition-colors leading-snug line-clamp-2">
                                    {{ $gal->title }}
                                </h3>
                            </a>
                        </div>
                    </div>

                    <!-- Tombol Detail -->
                    <div class="p-5 pt-0">
                        <a href="{{ url('galeri/' . $gal->slug) }}"
                            class="w-full inline-flex items-center justify-center gap-1.5 px-4 py-2.5 rounded-xl bg-slate-50 hover:bg-brand-500 text-slate-700 hover:text-white border border-slate-200/80 hover:border-brand-500 text-xs font-bold transition-all duration-200 shadow-sm">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M3 9a2 2 0 012-2h0.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z" />
                                <circle cx="12" cy="13" r="3" />
                            </svg>
                            <span>Detail Album Foto</span>
                            <svg class="w-3.5 h-3.5 group-hover:translate-x-0.5 transition-transform" fill="none"
                                stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M14 5l7 7m0 0l-7 7m7-7H3" />
                            </svg>
                        </a>
                    </div>
                </div>
                @empty
                <!-- Jika Galeri Kosong -->
                <div class="col-span-full bg-slate-50 border border-slate-200/80 p-12 text-center rounded-2xl">
                    <div class="flex flex-col items-center justify-center gap-3">
                        <div class="p-4 bg-brand-50 rounded-full text-brand-500 border border-brand-100">
                            <svg class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-base font-bold text-slate-800">Belum Ada Koleksi Foto Diterbitkan</h3>
                            <p class="text-xs text-slate-500 mt-1">Saat ini belum ada dokumentasi album foto yang
                                dipublikasikan oleh {{ $opdName }}.</p>
                        </div>
                    </div>
                </div>
                @endforelse
            </div>

            <!-- Paginasi Galeri -->
            @if ($galleries->hasPages())
            <div class="pt-8 border-t border-slate-100">
                {{ $galleries->links() }}
            </div>
            @endif
        </div>
    </div>
</div>
@endsection