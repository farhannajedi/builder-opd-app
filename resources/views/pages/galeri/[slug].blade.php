@php
use App\Models\Galleries;

// Folio otomatis menyuntikkan variabel $slug dari nama file [slug].blade.php
$gallery = Galleries::where('slug', $slug)->firstOrFail();

// Ambil foto lain dari OPD yang sama untuk rekomendasi/sidebar
$otherGalleries = Galleries::where('opd_id', $gallery->opd_id)
->where('id', '!=', $gallery->id)
->latest()
->take(4)
->get();
@endphp

@extends('layouts.app', ['activePage' => 'galeri'])

@section('content')
<section class="max-w-screen-lg px-4 mx-auto w-full py-12">
    <!-- Breadcrumb  -->
    <nav class="flex mb-8 text-sm text-slate-500 gap-2">
        <a href="{{ url('/') }}" class="hover:text-blue-600">Beranda</a>
        <span>/</span>
        <a href="{{ url('/galeri') }}" class="hover:text-blue-600">Galeri</a>
        <span>/</span>
        <span class="text-slate-800 truncate">{{ $gallery->title }}</span>
    </nav>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-12">

        <!-- Konten Utama (Kiri)  -->
        <div class="lg:col-span-2 space-y-6">
            <!-- Judul & Meta  -->
            <div class="space-y-4">
                <h1 class="text-3xl md:text-4xl font-bold text-slate-900 leading-tight">
                    {{ $gallery->title }}
                </h1>

                <div class="flex flex-wrap items-center gap-4 text-slate-500 text-sm border-y border-slate-100 py-3">
                    <div class="flex items-center gap-2">
                        <span class="font-semibold text-orange-600">{{ $gallery->opd->name ?? 'Instansi' }}</span>
                    </div>
                    <span class="hidden md:block text-slate-300">|</span>
                    <div class="flex items-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                        {{ $gallery->created_at->isoFormat('D MMMM Y') }}
                    </div>
                </div>
            </div>

            <!-- Gambar Besar Konten Berita -->
            <div class="rounded-2xl overflow-hidden shadow-lg bg-slate-100">
                <img src="{{ asset('storage/' . $gallery->images) }}" alt="{{ $gallery->title }}"
                    class="w-full h-auto object-cover">
            </div>

            <!-- Detail Deskripsi -->
            <div class="prose prose-slate max-w-none">
                <p class="text-slate-700 leading-relaxed text-lg italic border-l-4 border-slate-200 pl-4">
                    {{ $gallery->description ?: 'Tidak ada deskripsi untuk galeri ini.' }}
                </p>
            </div>

            <!-- Tombol Kembali  -->
            <div class="pt-6">
                <a href="{{ url('/galeri') }}"
                    class="inline-flex items-center gap-2 text-blue-600 font-medium hover:underline">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                    Kembali ke Galeri
                </a>
            </div>
        </div>

        <!-- Sidebar (Kanan) tampilan galeri lainnya  -->
        <div class="space-y-8">
            <div class="bg-slate-50 rounded-2xl p-6 border border-slate-100">
                <h3 class="text-xl font-bold text-slate-800 mb-6">Foto Lainnya</h3>

                <div class="space-y-6">
                    @forelse ($otherGalleries as $item)
                    <a href="{{ url('galeri/' . $item->slug) }}" class="group flex gap-4 items-center">
                        <div class="flex-shrink-0 w-20 h-20 rounded-lg overflow-hidden bg-slate-200">
                            <img src="{{ asset('storage/' . $item->images) }}"
                                class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-300">
                        </div>
                        <div class="flex-1">
                            <h4
                                class="text-sm font-medium text-slate-800 line-clamp-2 group-hover:text-blue-600 transition-colors">
                                {{ $item->title }}
                            </h4>
                            <p class="text-[10px] text-slate-400 mt-1 uppercase">
                                {{ $item->created_at->diffForHumans() }}
                            </p>
                        </div>
                    </a>
                    @empty
                    <p class="text-sm text-slate-500 italic">Belum ada foto lainnya.</p>
                    @endforelse
                </div>
            </div>

            <!-- Box konten Info -->
            <div class="bg-blue-600 rounded-2xl p-6 text-white shadow-xl shadow-blue-100">
                <h4 class="font-bold mb-2">Butuh Informasi?</h4>
                <p class="text-sm text-blue-100 mb-4">Hubungi admin {{ $gallery->opd->name }} untuk informasi lebih
                    lanjut mengenai kegiatan ini.</p>
                <a href="{{ url('/kontak') }}"
                    class="block text-center bg-white text-blue-600 py-2 rounded-lg font-bold text-sm hover:bg-blue-50 transition-colors">Kontak
                    Kami</a>
            </div>
        </div>

    </div>
</section>
@endsection