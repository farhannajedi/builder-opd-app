@php
use App\Models\News;
$berita = News::with('opd', 'category')
->where('slug', $slug)
->first();

// Jika berita tidak ditemukan, arahkan ke halaman 404
if (!$berita) {
abort(404);
}

// Kolom 'images' menyimpan path relatif dari storage/app/public, misal: 'news/2025-12/foto.jpg'
$imagePath = asset('storage/' . $berita->images);

@endphp

@extends('layouts.app', ['activePage' => 'berita'])

@section('content')
<div class="bg-gray-50 min-h-screen py-10 md:py-16">
  <section
    class="max-w-screen-lg px-4 mx-auto w-full bg-white p-6 md:p-10 rounded-xl shadow-lg border border-gray-200">

    {{-- Header Breadcrumb --}}
    <div class="mb-6 text-sm text-gray-500">
      <a href="/berita" class="hover:underline">Berita</a>
      <span class="mx-1">/</span>
      <span class="font-medium text-gray-700">{{ Str::limit($berita->title, 40) }}</span>
    </div>

    {{-- JUDUL DAN METADATA --}}
    <h1 class="text-4xl md:text-5xl font-extrabold text-gray-900 tracking-tight mb-4">
      {{ $berita->title }}
    </h1>

    <div class="flex flex-wrap items-center text-sm text-gray-600 gap-x-4 gap-y-2 mb-8 border-b pb-4">

      {{-- TANGGAL --}}
      <div class="flex items-center gap-1">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 stroke-[1.5]" fill="none" viewBox="0 0 24 24"
          stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round"
            d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
        </svg>
        <span>{{ $berita->published_at->isoFormat('D MMMM Y') }}</span>
      </div>

      {{-- OPD --}}
      <div class="flex items-center gap-1">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 stroke-[1.5]" viewBox="0 0 24 24" fill="none"
          stroke="currentColor" stroke-linecap="round" stroke-linejoin="round">
          <path d="M3 21v-2a4 4 0 0 1 4-4h10a4 4 0 0 1 4 4v2" />
          <circle cx="12" cy="7" r="4" />
        </svg>
        <span>{{ $berita->opd->name ?? 'OPD Tidak Diketahui' }}</span>
      </div>

      {{-- KATEGORI --}}
      @if ($berita->category)
      <div class="flex items-center gap-1 bg-gray-100 px-2 py-0.5 rounded-full text-xs font-medium text-gray-700">
        <span class="h-1.5 w-1.5 rounded-full bg-blue-500 block"></span>
        <span>{{ $berita->category->title ?? 'Tanpa Kategori' }}</span>
      </div>
      @endif
    </div>

    {{-- GAMBAR UTAMA --}}
    <figure class="mb-8">
      <img src="{{ $imagePath }}" class="w-full h-auto object-cover rounded-lg shadow-md ring-1 ring-gray-200"
        alt="{{ $berita->title }}">
    </figure>

    {{-- KONTEN DESKRIPSI (RICH EDITOR) --}}
    <div class="prose max-w-none text-gray-700 leading-relaxed">
      {!! $berita->deskripsi !!}
    </div>

  </section>
</div>
@endsection