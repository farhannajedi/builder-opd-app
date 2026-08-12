@php
// Ambil parameter id dari URL
$service = App\Models\Service::with('opd')->where('id', $id)->whereNotNull('created_at')->firstOrFail();
$opdName = $service->opd->name ?? 'Instansi';
@endphp

@extends('layouts.app', ['activePage' => 'Layanan'])

@section('content')
<div class="bg-slate-50/60 min-h-screen py-10 md:py-16">
    <div class="max-w-screen-xl mx-auto px-4 sm:px-6 lg:px-8">

        <!-- Navigasi -->
        <nav class="flex items-center gap-2 mb-8 text-xs font-semibold text-slate-500 overflow-x-auto pb-2">
            <a href="{{ url('/') }}" class="hover:text-brand-600 transition-colors flex items-center gap-1 shrink-0">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                </svg>
                Beranda
            </a>
            <span class="text-slate-300">/</span>
            <a href="{{ url('/layanan') }}" class="hover:text-brand-600 transition-colors shrink-0">Layanan Publik</a>
            <span class="text-slate-300">/</span>
            <span class="text-slate-800 font-bold truncate max-w-[200px] sm:max-w-xs">{{ $service->name }}</span>
        </nav>

        <!-- Container Utama -->
        <div class="space-y-8">
            <!-- Header Layanan -->
            <div class="bg-white rounded-3xl p-6 sm:p-10 border border-slate-200/80 shadow-sm space-y-6">
                <div class="space-y-4">
                    <!-- Badge Layanan Digital -->
                    <div class="flex flex-wrap items-center gap-2">
                        <span
                            class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-brand-100 border border-brand-200/80 text-brand-600 text-[8px] font-extrabold uppercase tracking-wider">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                            </svg>
                            Fasilitas Layanan Publik
                        </span>

                        <span
                            class="inline-flex items-center px-2.5 py-1 rounded-full bg-slate-100 border border-slate-200 text-slate-700 text-[8px] font-black uppercase tracking-wider">
                            Terferifikasi
                        </span>
                    </div>

                    <!-- Judul Utama Layanan -->
                    <h1 class="text-xl sm:text-3xl lg:text-2xl font-black text-slate-900 leading-tight tracking-tight">
                        {{ $service->name }}
                    </h1>

                    <!-- Instansi Pengelola & Tanggal Publikasi -->
                    <div
                        class="flex flex-wrap items-center gap-4 text-xs font-semibold text-slate-500 pt-3 border-t border-slate-100">
                        <div class="flex items-center gap-2">
                            <div
                                class="w-7 h-7 rounded-full bg-brand-100 text-brand-600 flex items-center justify-center font-bold">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5m0 0h4m-4 0V11m0 0V7" />
                                </svg>
                            </div>
                            <span class="text-slate-800 font-bold">{{ $opdName }}</span>
                        </div>

                        <span class="text-slate-300">•</span>

                        <!-- Tanggal -->
                        <div class="flex items-center gap-1.5 text-slate-600">
                            <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                            <span>{{ $service->published_at ? $service->published_at->locale('id')->isoFormat('D MMMM YYYY') : $service->created_at->locale('id')->isoFormat('D MMMM YYYY') }}</span>
                        </div>
                    </div>
                </div>

                <!-- Baris Tombol -->
                <div
                    class="pt-4 border-t border-slate-100 flex flex-col sm:flex-row items-center justify-between gap-4">
                    <a href="{{ url('/layanan') }}"
                        class="inline-flex items-center gap-2 px-5 py-2.5 rounded-full bg-slate-100 hover:bg-brand-500 hover:text-slate-100 text-slate-700 text-xs font-bold transition-all w-full sm:w-auto justify-center">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                        </svg>
                        Kembali ke Daftar Layanan
                    </a>

                    <button type="button" onclick="copyServiceUrl('{{ url()->current() }}')"
                        class="inline-flex items-center justify-center gap-2 px-5 py-2.5 rounded-full bg-slate-50 border border-slate-200 hover:border-brand-500 text-slate-600 hover:text-brand-600 text-xs font-bold transition-all w-full sm:w-auto">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M8.684 13.342C8.886 12.938 9 12.482 9 12c0-.482-.114-.938-.316-1.342m0 2.684a3 3 0 110-2.684m0 2.684l6.632 3.316m-6.632-6l6.632-3.316m0 0a3 3 0 105.367-2.684 3 3 0 00-5.367 2.684zm0 9.316a3 3 0 105.368 2.684 3 3 0 00-5.368-2.684z" />
                        </svg>
                        Bagikan Tautan Layanan
                    </button>
                </div>
            </div>

            <!-- Rincian Layanan -->
            <div class="bg-white rounded-3xl p-6 sm:p-10 border border-slate-200/80 shadow-sm space-y-4">
                <h2 class="text-lg font-bold text-slate-800 border-b border-slate-100 pb-3 flex items-center gap-2">
                    <svg class="w-5 h-5 text-brand-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    Informasi & Ketentuan Layanan
                </h2>

                <div class="prose prose-slate max-w-none text-slate-700 text-sm sm:text-base leading-relaxed pt-2">
                    <p class="whitespace-pre-line">
                        {!! nl2br(e($service->description)) !!}
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Salin Tautan -->
<script>
    function copyServiceUrl(url) {
        if (navigator.clipboard && window.isSecureContext) {
            navigator.clipboard.writeText(url).then(() => {
                alert('Tautan informasi layanan berhasil disalin!');
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
            alert('Tautan informasi layanan berhasil disalin!');
        } catch (err) {
            alert('Gagal menyalin tautan.');
        }
        document.body.removeChild(textArea);
    }
</script>
@endsection