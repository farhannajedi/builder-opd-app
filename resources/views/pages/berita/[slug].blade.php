@php

$berita = App\Models\News::with('opd', 'category')->where('slug', $slug)->first();

if (!$berita) {
abort(404);
}

// Ambil berita terkait dari OPD yang sama
$otherNews = App\Models\News::where('opd_id', $berita->opd_id)
->where('id', '!=', $berita->id)
->latest()
->take(4)
->get();

$imagePath = asset('storage/' . $berita->images);
@endphp

@extends('layouts.app', ['activePage' => 'berita'])

@section('content')
<div class="bg-slate-50/60 min-h-screen py-10 md:py-16">
    <div class="max-w-screen-xl mx-auto px-4 sm:px-6 lg:px-8">

        <!-- Navigasi -->
        <nav class="flex items-center gap-2 mb-8 text-xs font-semibold text-slate-500 overflow-x-auto pb-2">
            <a href="{{ url('/') }}" class="hover:text-orange-600 transition-colors flex items-center gap-1 shrink-0">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                </svg>
                Beranda
            </a>
            <span class="text-slate-300">/</span>
            <a href="{{ url('/berita') }}" class="hover:text-orange-600 transition-colors shrink-0">Berita</a>
            <span class="text-slate-300">/</span>
            <span class="text-slate-800 font-bold truncate max-w-[200px] sm:max-w-xs">{{ $berita->title }}</span>
        </nav>

        <!-- Grid Utama -->
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">

            <!-- Konten Berita Utama -->
            <article
                class="lg:col-span-8 bg-white rounded-3xl p-6 sm:p-10 border border-slate-200/80 shadow-sm space-y-6">

                <!-- Badge Kategori -->
                <div class="space-y-4">
                    @if($berita->category)
                    <a href="{{ url('berita/kategori/' . $berita->category->slug) }}"
                        class="inline-flex items-center gap-1.5 px-3.5 py-1 rounded-full bg-rose-50 text-rose-600 border border-rose-100 text-xs font-bold hover:bg-rose-500 hover:text-white hover:border-rose-500 transition-all">
                        <span class="w-1.5 h-1.5 rounded-full bg-rose-500"></span>
                        {{ $berita->category->title }}
                    </a>
                    @endif

                    <!-- Judul Utama Berita -->
                    <h1 class="text-2xl sm:text-3xl lg:text-4xl font-black text-slate-900 leading-tight tracking-tight">
                        {{ $berita->title }}
                    </h1>

                    <!-- Informasi Penulis & Tanggal -->
                    <div
                        class="flex flex-wrap items-center gap-4 text-xs font-semibold text-slate-500 pt-2 border-t border-slate-100">
                        <!-- Instansi -->
                        <div class="flex items-center gap-2">
                            <div
                                class="w-7 h-7 rounded-full bg-orange-100 text-orange-600 flex items-center justify-center font-bold">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5m0 0h4m-4 0V11m0 0V7" />
                                </svg>
                            </div>
                            <span class="text-slate-800 font-bold">{{ $berita->opd->name ?? 'Instansi' }}</span>
                        </div>

                        <span class="text-slate-300">•</span>

                        <!-- Tanggal Publikasi -->
                        <div class="flex items-center gap-1.5 text-slate-600">
                            <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                            <span>{{ $berita->published_at ? $berita->published_at->locale('id')->isoFormat('D MMMM YYYY') : $berita->created_at->locale('id')->isoFormat('D MMMM YYYY') }}</span>
                        </div>
                    </div>
                </div>

                <!-- Gambar Utama -->
                <div
                    class="w-full overflow-hidden rounded-2xl bg-slate-100/80 border border-slate-200/80 shadow-sm flex items-center justify-center p-1 sm:p-2">
                    <img src="{{ $imagePath }}" alt="{{ $berita->title }}"
                        class="w-full h-auto max-h-[600px] object-contain rounded-xl mx-auto">
                </div>

                <!-- Isi Berita -->
                <div
                    class="prose prose-slate max-w-none prose-p:text-slate-700 prose-p:leading-relaxed prose-headings:font-bold prose-headings:text-slate-900 prose-img:rounded-2xl pt-2">
                    {!! $berita->deskripsi ?: '<p class="text-slate-400 italic">Tidak ada deskripsi rinci untuk berita
                        ini.</p>' !!}
                </div>

                <!-- Tombol Kembali -->
                <div
                    class="pt-8 border-t border-slate-100 flex flex-col sm:flex-row items-center justify-between gap-4">
                    <a href="{{ url('/berita') }}"
                        class="inline-flex items-center gap-2 px-5 py-2.5 rounded-full bg-slate-100 hover:bg-orange-500 hover:text-white text-slate-700 text-xs font-bold transition-all duration-200 w-full sm:w-auto justify-center">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                        </svg>
                        Kembali ke Daftar Berita
                    </a>

                    <!-- Tombol Salin Tautan / Bagikan -->
                    <div class="flex flex-wrap items-center gap-2 pt-2">
                        <span class="text-xs font-bold text-slate-500 mr-2">Bagikan via:</span>

                        <!-- WhatsApp -->
                        <a href="https://api.whatsapp.com/send?text={{ urlencode($berita->title . ' - ' . url()->current()) }}"
                            target="_blank" rel="noopener noreferrer"
                            class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full bg-emerald-500 hover:bg-emerald-600 text-white text-xs font-bold transition-all shadow-sm">
                            <x-icons.whatsapp class="w-3.5 h-3.5" />
                        </a>

                        <!-- instagram -->
                        <button type="button" onclick="shareToInstagram('{{ url()->current() }}')"
                            class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full bg-gradient-to-r from-amber-500 via-rose-500 to-purple-600 hover:opacity-90 text-white text-xs font-bold transition-all shadow-sm cursor-pointer">
                            <x-icons.instagram class="w-3.5 h-3.5" />
                        </button>

                        <!-- Facebook -->
                        <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(url()->current()) }}"
                            target="_blank" rel="noopener noreferrer"
                            class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full bg-blue-600 hover:bg-blue-700 text-white text-xs font-bold transition-all shadow-sm">
                            <x-icons.facebook class="w-3.5 h-3.5" />
                        </a>

                        <!-- X / Twitter -->
                        <a href="https://twitter.com/intent/tweet?text={{ urlencode($berita->title) }}&url={{ urlencode(url()->current()) }}"
                            target="_blank" rel="noopener noreferrer"
                            class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full bg-slate-900 hover:bg-slate-800 text-white text-xs font-bold transition-all shadow-sm">
                            <svg class="w-3.5 h-3.5 fill-current" viewBox="0 0 24 24">
                                <path
                                    d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z" />
                            </svg>
                        </a>

                        <!-- Copy Link -->
                        <button type="button" onclick="copyUrlToClipboard('{{ url()->current() }}')"
                            class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-bold transition-all cursor-pointer">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z" />
                            </svg>
                            Salin Link
                        </button>
                    </div>
                </div>

            </article>

            <!-- Berita Lainnya -->
            <aside class="lg:col-span-4 space-y-6 sticky top-24">
                <div class="bg-white rounded-3xl p-6 border border-slate-200/80 shadow-sm">

                    <!-- Header Sidebar -->
                    <div class="flex items-center gap-3 mb-6">
                        <h2 class="text-xl font-bold text-slate-800 tracking-tight">Berita Terkait</h2>
                        <div class="flex-grow flex items-center">
                            <span class="w-2.5 h-2.5 rounded-full bg-sky-400 shrink-0"></span>
                            <div class="h-[1px] w-full bg-slate-200"></div>
                        </div>
                    </div>

                    <!-- List Berita Terkait -->
                    <div class="space-y-4">
                        @forelse ($otherNews as $item)
                        <a href="{{ url('berita/' . $item->slug) }}"
                            class="group flex gap-4 p-3 rounded-2xl border border-slate-100 bg-slate-50/50 hover:bg-white hover:border-orange-200 hover:shadow-md transition-all duration-300">

                            <!-- Thumbnail Foto -->
                            <div class="w-24 aspect-[4/3] shrink-0 rounded-xl overflow-hidden bg-slate-200">
                                <img src="{{ asset('storage/' . $item->images) }}" alt="{{ $item->title }}"
                                    class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                            </div>

                            <!-- Detail Teks -->
                            <div class="flex flex-col justify-between flex-grow py-0.5">
                                <h3
                                    class="text-xs sm:text-sm font-bold text-slate-800 group-hover:text-orange-600 transition-colors line-clamp-2 leading-snug">
                                    {{ $item->title }}
                                </h3>

                                <!-- Deskripsi Singkat -->
                                <p class="text-xs sm:text-sm text-slate-600 leading-relaxed line-clamp-3 font-normal">
                                    {{ strip_tags($item?->deskripsi) }}
                                </p>

                                <div class="flex items-center gap-1.5 text-[11px] text-slate-400 font-medium mt-2">
                                    <svg class="w-3.5 h-3.5 text-slate-400" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    <span>{{ $item->published_at ? $berita->published_at->locale('id')->isoFormat('D MMMM YYYY') : $item->created_at->locale('id')->isoFormat('D MMMM YYYY') }}</span>
                                </div>
                            </div>
                        </a>
                        @empty
                        <div class="p-6 text-center bg-slate-50 rounded-2xl border border-slate-100">
                            <p class="text-xs text-slate-400 italic">Belum ada berita terkait lainnya saat ini.</p>
                        </div>
                        @endforelse
                    </div>
                </div>
            </aside>
        </div>
    </div>
</div>
@endsection

<script>
    function copyUrlToClipboard(url) {
        if (navigator.clipboard && window.isSecureContext) {
            navigator.clipboard.writeText(url).then(() => {
                alert('Tautan berita berhasil disalin!');
            }).catch(err => {
                fallbackCopyTextToClipboard(url);
            });
        } else {
            // Fallback untuk HTTP
            fallbackCopyTextToClipboard(url);
        }
    }

    // Fungsi cadangan menggunakan dokumen teks sementara
    function fallbackCopyTextToClipboard(text) {
        var textArea = document.createElement("textarea");
        textArea.value = text;

        textArea.style.top = "0";
        textArea.style.left = "0";
        textArea.style.position = "fixed";

        document.body.appendChild(textArea);
        textArea.focus();
        textArea.select();

        try {
            var successful = document.execCommand('copy');
            if (successful) {
                alert('Tautan berita berhasil disalin!');
            } else {
                alert('Gagal menyalin tautan.');
            }
        } catch (err) {
            alert('Browser Anda tidak mendukung fitur salin otomatis.');
        }

        document.body.removeChild(textArea);
    }
</script>