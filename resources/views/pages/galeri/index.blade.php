@php
use App\Models\Galleries;

$slug = getenv('APP_ID');

// Menggunakan logika deteksi domain
if (!$slug) {
$galleries = Galleries::withoutGlobalScope('filterOPD')->orderBy('created_at', 'desc')->get();
} else {
$galleries = Galleries::orderBy('created_at', 'desc')->get();
}
@endphp

@extends('layouts.app', ['activePage' => 'galeri'])

@section('content')
<section class="max-w-screen-lg px-4 mx-auto w-full py-10">
    <div class="mb-10">
        <p class="text-4xl font-semibold text-slate-800 tracking-tight">Galeri Foto</p>
        <p class="text-slate-500 mt-2">Kumpulan dokumentasi kegiatan terbaru.</p>
    </div>

    <!-- Grid 3 gambar di tampilan dekstop -->
    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6">
        @forelse ($galleries as $gal)
        <!-- Link Detail yang membungkus seluruh gambar -->
        <a href="{{ url('galeri/' . $gal->slug) }}"
            class="group block bg-white border border-slate-200 rounded-xl overflow-hidden hover:shadow-xl hover:-translate-y-1 transition-all duration-300">

            <!-- Container Gambar dengan Rasio 4:3  -->
            <div class="relative aspect-video sm:aspect-[4/3] overflow-hidden bg-slate-100">
                <img src="{{ asset('storage/' . $gal->images) }}" alt="{{ $gal->title }}"
                    class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-110">

                <!-- Overlay saat cursor diarahkan ke gambar  -->
                <div
                    class="absolute inset-0 bg-black/0 group-hover:bg-black/20 transition-colors duration-300 flex items-center justify-center">
                    <svg xmlns="http://www.w3.org/2000/svg"
                        class="h-10 w-10 text-white opacity-0 group-hover:opacity-100 scale-50 group-hover:scale-100 transition-all duration-300"
                        fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0zM10 7v3m0 0v3m0-3h3m-3 0H7" />
                    </svg>
                </div>
            </div>

            <!-- Konten Teks Detail -->
            <div class="p-4">
                <p class="text-xs font-bold text-orange-600 uppercase tracking-wider mb-1">
                    {{ $gal->opd->name ?? 'Instansi' }}
                </p>
                <h3
                    class="text-lg font-bold text-slate-800 line-clamp-2 leading-snug group-hover:text-blue-600 transition-colors">
                    {{ $gal->title }}
                </h3>

                <div class="mt-4 pt-3 border-t border-slate-100 flex items-center justify-between text-slate-400">
                    <div class="flex items-center gap-1.5 text-xs">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                        <span>
                            {{ $gal->published_at 
                                    ? \Carbon\Carbon::parse($gal->published_at)->isoFormat('D MMM Y')
                                    : $gal->created_at->isoFormat('D MMM Y') }}
                        </span>
                    </div>
                    <span class="text-[10px] font-medium bg-slate-100 px-2 py-0.5 rounded-full uppercase">Detail</span>
                </div>
            </div>
        </a>

        <!-- logika jika data kosong -->
        @empty
        <div class="col-span-full py-20 text-center bg-slate-50 rounded-2xl border-2 border-dashed border-slate-200">
            <p class="text-slate-500 italic">Belum ada koleksi foto yang dipublikasikan.</p>
        </div>
        @endforelse
    </div>
</section>
@endsection