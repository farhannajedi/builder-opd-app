@php
use Illuminate\Support\Str;

$announcement = App\Models\announcement::with('opd')->where('slug', $slug)->firstOrFail();

// Mengambil pengumuman lain dari OPD yang sama untuk sidebar
$otherAnnouncements = App\Models\announcement::where('opd_id', $announcement->opd_id)
->where('id', '!=', $announcement->id)
->latest()
->take(4)
->get();

$imagePath = asset('storage/' . $announcement->images);
$opdName = $announcement->opd->name ?? 'Instansi';
// Agar updated_at TIDAK ikut ter-update setiap ada pembaca baru
$announcement->increment('views');
@endphp

@extends('layouts.app', ['activePage' => 'pengumuman'])

@section('content')
<div class="bg-slate-50/60 min-h-screen py-10 md:py-16">
    <div class="max-w-screen-xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Navigasi Breadcrumb -->
        <nav class="flex items-center gap-2 mb-8 text-xs font-semibold text-slate-500 overflow-x-auto pb-2">
            <a href="{{ url('/') }}" class="hover:text-orange-600 transition-colors flex items-center gap-1 shrink-0">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                </svg>
                Beranda
            </a>
            <span class="text-slate-300">/</span>
            <a href="{{ url('/pengumuman') }}" class="hover:text-orange-600 transition-colors shrink-0">Pengumuman</a>
            <span class="text-slate-300">/</span>
            <span class="text-slate-800 font-bold truncate max-w-[200px] sm:max-w-xs">{{ $announcement->title }}</span>
        </nav>

        <!-- Grid Utama -->
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">

            <!-- Konten Utama -->
            <article
                class="lg:col-span-8 bg-white rounded-3xl p-6 sm:p-10 border border-slate-200/80 shadow-sm space-y-6">

                <!-- Badge Kategori & Header Judul -->
                <div class="space-y-4">
                    <div class="flex flex-wrap items-center gap-2">
                        <span
                            class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-orange-100 border border-orange-200/80 text-orange-600 text-[11px] font-extrabold uppercase tracking-wider">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.684A1.761 1.761 0 013 12c0-.972.784-1.761 1.761-1.761l.675 1.922zm10.128-4.248a5 5 0 010 5.128" />
                            </svg>
                            Pemberitahuan Resmi
                        </span>
                    </div>

                    <!-- Judul Utama -->
                    <h1 class="text-2xl sm:text-3xl lg:text-4xl font-black text-slate-900 leading-tight tracking-tight">
                        {{ $announcement->title }}
                    </h1>

                    <!-- Instansi Pengelola & Tanggal Publikasi -->
                    <div
                        class="flex flex-wrap items-center gap-4 text-xs font-semibold text-slate-500 pt-3 border-t border-slate-100">
                        <div class="flex items-center gap-2">
                            <div
                                class="w-7 h-7 rounded-full bg-orange-100 text-orange-600 flex items-center justify-center font-bold text-xs">
                                {{ substr($opdName, 0, 1) }}
                            </div>
                            <span class="text-slate-800 font-bold">{{ $opdName }}</span>
                        </div>

                        <span class="text-slate-300">•</span>

                        <div class="flex items-center gap-1.5 text-slate-600">
                            <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                            <span>{{ $announcement->created_at?->isoFormat('D MMMM YYYY') ?? now()->isoFormat('D MMMM YYYY') }}</span>
                        </div>

                        <span class="text-slate-300">•</span>

                        <!-- Total Dilihat -->
                        <div class="flex items-center gap-1.5 text-slate-600">
                            <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                            </svg>
                            <span>{{ number_format($announcement->views ?? 0, 0, ',', '.') }} Dilihat</span>
                        </div>

                    </div>
                </div>

                <!-- Tampilan Gambar -->
                @if($announcement->images || $announcement->image)
                <div
                    class="w-full overflow-hidden rounded-2xl bg-slate-100/80 border border-slate-200/80 shadow-sm flex items-center justify-center p-1 sm:p-2">
                    <img src="{{ asset('storage/' . ($announcement->images ?? $announcement->image)) }}"
                        alt="{{ $announcement->title }}"
                        class="w-full h-auto max-h-[600px] object-contain rounded-xl mx-auto">
                </div>
                @endif

                <!-- Isi Teks Deskripsi Pengumuman -->
                <div class="prose prose-slate max-w-none text-slate-700 text-sm sm:text-base leading-relaxed pt-2">
                    <p class="whitespace-pre-line">
                        {!! nl2br(e($announcement->deskripsi)) !!}
                    </p>
                </div>

                <!-- Tombol Kembali & Bagikan -->
                <div
                    class="pt-8 border-t border-slate-100 flex flex-col sm:flex-row items-center justify-between gap-4">
                    <a href="{{ url('/pengumuman') }}"
                        class="inline-flex items-center gap-2 px-5 py-2.5 rounded-full bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-bold transition-all w-full sm:w-auto justify-center">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                        </svg>
                        Kembali ke Daftar Pengumuman
                    </a>

                    <button type="button" onclick="copyNoticeUrl('{{ url()->current() }}')"
                        class="inline-flex items-center justify-center gap-2 px-5 py-2.5 rounded-full bg-slate-50 border border-slate-200 hover:border-orange-500 text-slate-600 hover:text-orange-600 text-xs font-bold transition-all w-full sm:w-auto">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M8.684 13.342C8.886 12.938 9 12.482 9 12c0-.482-.114-.938-.316-1.342m0 2.684a3 3 0 110-2.684m0 2.684l6.632 3.316m-6.632-6l6.632-3.316m0 0a3 3 0 105.367-2.684 3 3 0 00-5.367 2.684zm0 9.316a3 3 0 105.368 2.684 3 3 0 00-5.368-2.684z" />
                        </svg>
                        Bagikan Pengumuman
                    </button>
                </div>

            </article>

            <!-- Pengumuman Lainnya -->
            <aside class="lg:col-span-4 space-y-6 sticky top-24">
                <div class="bg-white rounded-3xl p-6 border border-slate-200/80 shadow-sm">

                    <!-- Header Widget Sidebar -->
                    <div class="flex items-center gap-3 mb-6">
                        <h2 class="text-xl font-bold text-slate-800 tracking-tight">Pengumuman Lainnya</h2>
                        <div class="flex-grow flex items-center">
                            <span class="w-2.5 h-2.5 rounded-full bg-orange-500 shrink-0"></span>
                            <div class="h-[1px] w-full bg-slate-200"></div>
                        </div>
                    </div>

                    <!-- List Pengumuman Lainnya -->
                    <div class="space-y-4">
                        @forelse ($otherAnnouncements as $item)
                        <a href="{{ url('pengumuman/' . $item->slug) }}"
                            class="group block p-4 rounded-2xl border border-slate-100 bg-slate-50/50 hover:bg-white hover:border-orange-200 hover:shadow-md transition-all duration-300 space-y-2">

                            <span class="text-[10px] font-black text-orange-600 uppercase tracking-wider block">
                                {{ $item->created_at?->locale('id')->isoFormat('D MMMM YYYY') }}
                            </span>

                            <h3
                                class="text-xs sm:text-sm font-bold text-slate-800 group-hover:text-orange-600 transition-colors line-clamp-2 leading-snug">
                                {{ $item->title }}
                            </h3>

                            <p class="text-xs text-slate-500 line-clamp-2 leading-relaxed">
                                {{ Str::limit(strip_tags($item->deskripsi), 90) }}
                            </p>
                        </a>
                        @empty
                        <div class="p-6 text-center bg-slate-50 rounded-2xl border border-slate-100">
                            <p class="text-xs text-slate-400 italic">Belum ada pengumuman lainnya saat ini.</p>
                        </div>
                        @endforelse
                    </div>
                </div>
            </aside>
        </div>
    </div>
</div>

<!-- Salin Tautan -->
<script>
    function copyNoticeUrl(url) {
        if (navigator.clipboard && window.isSecureContext) {
            navigator.clipboard.writeText(url).then(() => {
                alert('Tautan pengumuman berhasil disalin!');
            }).catch(() => fallbackCopy(url));
        } else {
            fallbackCopy(url);
        }
    }

    function fallbackCopy(text) {
        var textArea = document.createElement("textarea");
        textArea.value = text;
        textArea.style.position = "fixed";
        document.body.appendChild(textArea);
        textArea.focus();
        textArea.select();
        try {
            document.execCommand('copy');
            alert('Tautan pengumuman berhasil disalin!');
        } catch (err) {
            alert('Gagal menyalin tautan.');
        }
        document.body.removeChild(textArea);
    }
</script>
@endsection