@php
use App\Models\News;
$berita = News::with('opd', 'category')->where('slug', $slug)->first();

// Jika berita tidak ditemukan, diarahkan ke halaman 404
if (!$berita) {
abort(404);
}

// ambil foto/berita lainnya untuk ditampilkan pada sidebar, sebagai tampilan more berita
$otherNews = News::where('opd_id', $berita->opd_id)->where('id', '!=', $berita->id)->latest()->take(4)->get();

// Kolom 'images' menyimpan path relatif dari storage/app/public, contoh misalnya nama filenya 'news/2025-12/foto.jpg'
$imagePath = asset('storage/' . $berita->images);

@endphp

@extends('layouts.app', ['activePage' => 'berita'])

@section('content')
<div class="bg-gray-50 min-h-screen py-10 md:py-16">
  <section class="max-w-screen-lg px-4 mx-auto w-full py-12">

    <!-- header breadcrumb -->
    <nav class="flex mb-8 text-sm text-slate-500 gap-2">
      <a href="{{ url('/') }}" class="hover:text-blue-600">Beranda</a>
      <span>/</span>
      <a href="{{ url('/berita') }}" class="hover:text-blue-600">Berita</a>
      <span>/</span>
      <span class="text-slate-800 truncate">{{ Str::limit($berita->title, 40) }}</span>
    </nav>

    <!-- konten berita -->
    <!-- grid layout -->
    <div class="grid grid-cols-1 lg:grid-cols-5 gap-8 md:gap-12">
      <!-- konten utama -->
      <div class="lg:col-span-3 space-y-8">
        <!-- judul berita -->
        <div class="space-y-4">
          <h1 class="text-sm md:text-4xl font-bold text-slate-900 leading-tight">
            {{ $berita->title }}
          </h1>

          <div
            class="flex flex-wrap items-center gap-4 text-slate-500 text-sm border-y border-slate-100 py-3">
            <div class="flex items-center gap-2">
              <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 stroke-[1.5]" viewBox="0 0 24 24"
                fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round">
                <path d="M3 21v-2a4 4 0 0 1 4-4h10a4 4 0 0 1 4 4v2" />
                <circle cx="12" cy="7" r="4" />
              </svg>
              <span class="font-semibold text-orange-600">{{ $berita->opd->name ?? 'Instansi' }}</span>
            </div>
            <span class="hidden md:block text-slate-300">|</span>
            <div class="flex items-center gap-2">
              <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24"
                stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
              </svg>
              {{ $berita->published_at ? $berita->published_at->isoFormat('D MMMM Y') : $berita->created_at->isoFormat('D MMMM Y') }}
            </div>
            @if($berita->category)
            <span class="hidden md:block text-slate-300">Kategori :</span>
            <span
              class="bg-slate-100 px-2 py-0.5 rounded text-xs font-medium">{{ $berita->category->title }}</span>
            @endif
          </div>
        </div>

        <!-- gambar utama konten berita -->
        <div class="rounded-2xl overflow-hidden shadow-lg bg-slate-100">
          <img src="{{ $imagePath }}" alt="{{ $berita->title }}" class="w-full h-auto object-cover">
        </div>

        <!-- deskripsi berita -->
        <div class="prose prose-slate max-w-none text-slate-700 leading-relaxed">
          {!! $berita->deskripsi !!}
        </div>

        <!-- tombol back -->
        <div class="pt-6 border-t border-slate-100">
          <a href="{{ url('/berita') }}"
            class="inline-flex items-center gap-2 text-blue-600 font-medium hover:underline">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
              stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M10 19l-7-7m0 0l7-7m-7 7h18" />
            </svg>
            Kembali ke Daftar Berita
          </a>
        </div>
      </div>

      <!-- konten sidebar berita lainnya -->
      <div class="lg:col-span-2 space-y-9 sticky">
        <h3 class="text-xl font-bold text-slate-800 border-l-4 border-blue-600 pl-4 mb-6">Berita Terkait</h3>

        <div class="flex flex-col gap-6">
          @forelse ($otherNews as $item)
          <a href="{{ url('berita/' . $item->slug) }}"
            class="group flex items-center gap-5 p-3 rounded-xl hover:bg-white hover:shadow-md transition-all duration-300">

            <!-- gambar, dengan rasio 4:3 -->
            <div
              class="flex-shrink-0 w-28 md:w-40 aspect-[4/3] bg-slate-100 rounded-lg overflow-hidden shadow-sm">
              <img src="{{ asset('storage/' . $item->images) }}" alt="{{ $item->title }}"
                class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
            </div>

            <!-- ruang konten teks menjadi lebih luas -->
            <div class="flex flex-col gap-2 min-w-0 flex-1">
              <!-- judul konten berita -->
              <h4
                class="text-sm md:text-lg font-bold text-slate-800 group-hover:text-blue-600 transition-colors line-clamp-3 leading-snug overflow-hidden text-ellipsis">
                {{ $item->title }}
              </h4>

              <!-- konten metadata waktu -->
              <div
                class="flex items-center gap-2 text-[10px] md:text-xs text-slate-400 font-medium uppercase tracking-wide whitespace-nowrap">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5 flex-shrink-0" fill="none"
                  viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <span>{{ $item->created_at->diffForHumans() }}</span>
              </div>
            </div>
          </a>
          @empty
          <p class="text-slate-500 italic text-sm">Belum ada berita terkait.</p>
          @endforelse
        </div>
      </div>
  </section>
</div>
@endsection