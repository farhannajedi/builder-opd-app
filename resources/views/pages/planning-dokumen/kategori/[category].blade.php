@php
use App\Models\PlanningDocument;
use App\Models\PlanningDocumentCategory;
use App\Models\Opd;

$opdSlug = env('APP_ID');
$opd = Opd::where('slug', $opdSlug)->first();

// Ambil data kategori aktif berdasarkan slug
$activeCategory = PlanningDocumentCategory::where('slug', $category)
->where('opd_id', $opd?->id)
->firstOrFail();

// Ambil seluruh daftar kategori untuk navigasi tab filter
$categoryList = PlanningDocumentCategory::where('opd_id', $opd?->id)->get();

// Query dokumen yang sesuai dengan kategori aktif
$documents = PlanningDocument::where('category_id', $activeCategory->id)
->where('opd_id', $opd?->id)
->with('opd')
->latest()
->paginate(10);

$opdName = $opd?->name ?? 'Instansi';
@endphp

@extends('layouts.app', ['activePage' => 'Arsip Dokumen'])

@section('content')
<div class="w-full bg-slate-50/60 py-10 min-h-screen">
    <div class="max-w-screen-xl mx-auto px-4 sm:px-6 lg:px-8 space-y-8">

        <!-- HEADER BANNER KATEGORI SPESIFIK -->
        <div
            class="relative overflow-hidden bg-slate-900 text-white rounded-3xl p-8 sm:p-12 shadow-lg border border-slate-800">
            <div
                class="absolute -right-10 -bottom-10 w-64 h-64 bg-orange-500/10 rounded-full blur-3xl pointer-events-none">
            </div>

            <div class="relative z-10 flex flex-col md:flex-row md:items-center justify-between gap-6">
                <div class="space-y-3 max-w-2xl">
                    <div
                        class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-orange-500/20 border border-orange-500/30 text-orange-400 text-[11px] font-extrabold uppercase tracking-widest">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z" />
                        </svg>
                        Klasifikasi Dokumen Perencanaan
                    </div>

                    <h1 class="text-2xl sm:text-4xl font-black tracking-tight leading-tight">
                        {{ $activeCategory->title }}
                    </h1>

                    <p class="text-xs sm:text-sm text-slate-300 leading-relaxed">
                        Menampilkan seluruh arsip dokumen resmi dalam kategori <span
                            class="text-orange-400 font-bold">{{ $activeCategory->title }}</span> yang dipublikasikan
                        oleh {{ $opdName }}.
                    </p>
                </div>

                <!-- Tombol Kembali ke Semua Dokumen -->
                <div class="flex-none">
                    <a href="{{ url('/planning-dokumen') }}"
                        class="inline-flex items-center gap-2 px-5 py-2.5 rounded-full bg-white/10 hover:bg-orange-500 text-white border border-white/20 hover:border-orange-500 text-xs font-bold transition-all backdrop-blur-md shadow-sm">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                        </svg>
                        <span>Lihat Semua Dokumen</span>
                    </a>
                </div>
            </div>
        </div>

        <!-- WRAPPER UTAMA KONTEN -->
        <div class="bg-white rounded-3xl p-6 sm:p-10 border border-slate-200/80 shadow-sm space-y-6">

            <!-- Filter Kategori Lain & Total Hasil -->
            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 border-b border-slate-100 pb-5">
                <!-- Navigasi Kategori Pills -->
                <div class="flex items-center gap-2 overflow-x-auto pb-2 sm:pb-0">
                    <a href="{{ url('/planning-dokumen') }}"
                        class="px-3.5 py-1.5 rounded-xl text-xs font-bold transition-all whitespace-nowrap bg-slate-100 text-slate-600 hover:bg-slate-200">
                        Semua
                    </a>
                    @foreach($categoryList as $cat)
                    <a href="{{ url('/planning-dokumen/kategori/' . $cat->slug) }}"
                        class="px-3.5 py-1.5 rounded-xl text-xs font-bold transition-all whitespace-nowrap {{ $cat->id === $activeCategory->id ? 'bg-orange-500 text-white shadow-md shadow-orange-500/20' : 'bg-slate-100 text-slate-600 hover:bg-slate-200' }}">
                        {{ $cat->title }}
                    </a>
                    @endforeach
                </div>

                <span class="text-xs font-semibold text-slate-400 flex-none">
                    Ditemukan {{ $documents->total() }} Dokumen
                </span>
            </div>

            <!-- TATA LETAK HORIZONTAL STRIP DOKUMEN -->
            <div class="space-y-4">
                @forelse ($documents as $doc)
                <div
                    class="group relative bg-white rounded-2xl border border-slate-200/80 hover:border-orange-300 hover:shadow-lg transition-all duration-300 p-5 sm:p-6">
                    <div class="flex flex-col md:flex-row md:items-center justify-between gap-5">

                        <!-- Bagian Kiri: Ikon & Detail -->
                        <div class="flex items-start gap-4 flex-grow min-w-0">
                            <div
                                class="p-3.5 bg-orange-50 text-orange-600 border border-orange-100 rounded-2xl flex-none group-hover:bg-orange-500 group-hover:text-white group-hover:border-orange-500 transition-colors duration-300 shadow-sm">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                </svg>
                            </div>

                            <div class="space-y-2 flex-grow min-w-0">
                                <div class="flex flex-wrap items-center gap-2">
                                    <span
                                        class="text-[10px] font-black text-white bg-orange-500 px-2 py-0.5 rounded-md uppercase tracking-wider">
                                        {{ $activeCategory->title }}
                                    </span>
                                    <span class="text-xs text-slate-300">•</span>
                                    <span class="text-xs text-slate-400 font-medium">Terbitan Resmi</span>
                                </div>

                                <a href="/planning-dokumen/{{ $doc->slug }}" class="block group/title">
                                    <h2
                                        class="text-base sm:text-lg font-bold text-slate-800 group-hover/title:text-orange-600 transition-colors leading-snug line-clamp-2">
                                        {{ $doc->title }}
                                    </h2>
                                </a>

                                <div
                                    class="flex flex-wrap items-center gap-x-4 gap-y-1 text-xs text-slate-400 font-medium">
                                    <div class="flex items-center gap-1.5">
                                        <svg class="w-3.5 h-3.5 text-slate-400" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                        </svg>
                                        <span>{{ $doc->created_at?->locale('id')->isoFormat('D MMMM YYYY') ?? '-' }}</span>
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

                        <!-- Bagian Kanan: Tombol Aksi -->
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
                <!-- State Jika Dokumen Kosong -->
                <div class="bg-slate-50 border border-slate-200/80 p-12 text-center rounded-2xl">
                    <div class="flex flex-col items-center justify-center gap-3">
                        <div class="p-4 bg-orange-50 rounded-full text-orange-500 border border-orange-100">
                            <svg class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-base font-bold text-slate-800">Belum Ada Dokumen dalam Kategori Ini</h3>
                            <p class="text-xs text-slate-500 mt-1">Saat ini belum ada arsip dokumen yang diterbitkan
                                untuk kategori <span
                                    class="font-bold text-slate-700">{{ $activeCategory->title }}</span>.</p>
                        </div>
                    </div>
                </div>
                @endforelse
            </div>

            <!-- Paginasi -->
            @if ($documents->hasPages())
            <div class="pt-8 border-t border-slate-100">
                {{ $documents->links() }}
            </div>
            @endif

        </div>

    </div>
</div>
@endsection