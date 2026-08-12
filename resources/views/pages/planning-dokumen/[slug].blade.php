@php

$document = App\Models\PlanningDocument::with('opd')->where('slug', $slug)->firstOrFail();

$fileUrl = asset('storage/' . $document->file);
$extension = strtolower(pathinfo($document->file, PATHINFO_EXTENSION));
$opdName = $document->opd->name ?? 'Instansi';
@endphp

@extends('layouts.app', ['activePage' => 'Arsip Dokumen'])

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
            <a href="{{ url('/planning-dokumen') }}" class="hover:text-brand-600 transition-colors shrink-0">Arsip
                Dokumen</a>
            <span class="text-slate-300">/</span>
            <span class="text-slate-800 font-bold truncate max-w-[200px] sm:max-w-xs">{{ $document->title }}</span>
        </nav>

        <!-- Detail Dokumen -->
        <div class="space-y-8">

            <!-- Header Dokumen -->
            <div class="bg-white rounded-3xl p-6 sm:p-10 border border-slate-200/80 shadow-sm space-y-6">

                <!-- Metadata -->
                <div class="space-y-4">
                    <div class="flex flex-wrap items-center gap-2">
                        <span
                            class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-brand-100 border border-brand-200/80 text-brand-600 text-[11px] font-extrabold uppercase tracking-wider">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                            </svg>
                            Arsip Resmi
                        </span>

                        <span
                            class="inline-flex items-center px-2.5 py-1 rounded-full bg-slate-100 border border-slate-200 text-slate-700 text-[10px] font-black uppercase tracking-wider">
                            FORMAT {{ strtoupper($extension) }}
                        </span>
                    </div>

                    <!-- Judul Utama Dokumen -->
                    <h1 class="text-xl sm:text-3xl lg:text-2xl font-black text-slate-900 leading-tight tracking-tight">
                        {{ $document->title }}
                    </h1>

                    <!-- Instansi & Tanggal Publikasi -->
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

                        <div class="flex items-center gap-1.5 text-slate-600">
                            <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                            <span>{{ $document->published_at ? \Carbon\Carbon::parse($document->published_at)->locale('id')->isoFormat('D MMMM YYYY') : $document->created_at->locale('id')->isoFormat('D MMMM YYYY') }}</span>
                        </div>
                    </div>
                </div>

                <!-- Tombol Aksi -->
                <div
                    class="pt-4 border-t border-slate-100 flex flex-col sm:flex-row items-center justify-between gap-4">
                    <a href="{{ url('/planning-dokumen') }}"
                        class="inline-flex items-center gap-2 px-5 py-2.5 rounded-full bg-slate-100 hover:bg-brand-500 hover:text-slate-100 text-slate-700 text-xs font-bold transition-all w-full sm:w-auto justify-center">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                        </svg>
                        Kembali ke Daftar Dokumen
                    </a>

                    @if ($document->file)
                    <div class="flex items-center gap-2 w-full sm:w-auto">
                        <!-- Tombol Salin Link -->
                        <button type="button" onclick="copyDocUrl('{{ url()->current() }}')"
                            class="inline-flex items-center justify-center gap-2 px-4 py-2.5 rounded-full bg-slate-50 border border-slate-200 hover:border-brand-500 text-slate-600 hover:text-brand-600 text-xs font-bold transition-all w-full sm:w-auto">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M8.684 13.342C8.886 12.938 9 12.482 9 12c0-.482-.114-.938-.316-1.342m0 2.684a3 3 0 110-2.684m0 2.684l6.632 3.316m-6.632-6l6.632-3.316m0 0a3 3 0 105.367-2.684 3 3 0 00-5.367 2.684zm0 9.316a3 3 0 105.368 2.684 3 3 0 00-5.368-2.684z" />
                            </svg>
                            Salin Tautan
                        </button>

                        <!-- Tombol Download Dokumen -->
                        <a href="{{ $fileUrl }}" target="_blank" download
                            class="inline-flex items-center justify-center gap-2 px-6 py-2.5 rounded-full bg-brand-500 hover:bg-brand-600 text-white text-xs font-bold shadow-md shadow-brand-500/20 transition-all w-full sm:w-auto">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                            </svg>
                            Unduh File Dokumen
                        </a>
                    </div>
                    @endif
                </div>

            </div>

            <!-- Deskripsi Dokumen -->
            @if ($document->content)
            <div class="bg-white rounded-3xl p-6 sm:p-10 border border-slate-200/80 shadow-sm">
                <h2
                    class="text-lg font-bold text-slate-800 mb-4 border-b border-slate-100 pb-3 flex items-center gap-2">
                    <svg class="w-5 h-5 text-brand-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    Ringkasan & Catatan Dokumen
                </h2>
                <article class="prose prose-slate max-w-none text-xs sm:text-sm text-slate-700 leading-relaxed">
                    {!! $document->content !!}
                </article>
            </div>
            @endif

            <!-- Melihat Detail Dokumen -->
            @if ($document->file)
            <div class="bg-white rounded-3xl border border-slate-200/80 shadow-sm overflow-hidden">
                <div
                    class="p-5 sm:p-6 border-b border-slate-100 bg-slate-50/50 flex flex-col sm:flex-row sm:items-center justify-between gap-3">
                    <div>
                        <h2 class="text-base font-bold text-slate-800 flex items-center gap-2">
                            <svg class="w-5 h-5 text-brand-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                            </svg>
                            Pratinjau Dokumen
                        </h2>
                        <p class="text-xs text-slate-400 mt-0.5">Jika pratinjau tidak muncul di layar Anda, gunakan
                            tombol unduh di atas.</p>
                    </div>

                    <a href="{{ $fileUrl }}" target="_blank"
                        class="inline-flex items-center gap-1.5 text-xs font-bold text-brand-600 hover:text-brand-700 self-start sm:self-auto">
                        <span>Buka di Tab Baru</span>
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" />
                        </svg>
                    </a>
                </div>

                <!-- Viewer Container -->
                <div class="w-full bg-slate-100 relative min-h-[500px] sm:min-h-[700px]">
                    @if ($extension === 'pdf')
                    <iframe src="{{ $fileUrl }}" class="w-full h-[500px] sm:h-[700px]" frameborder="0"></iframe>
                    @else
                    <iframe src="https://docs.google.com/gview?url={{ $fileUrl }}&embedded=true"
                        class="w-full h-[500px] sm:h-[700px]" frameborder="0"></iframe>
                    @endif
                </div>
            </div>
            @endif
        </div>
    </div>
</div>

<!-- Script Salin Tautan -->
<script>
    function copyDocUrl(url) {
        if (navigator.clipboard && window.isSecureContext) {
            navigator.clipboard.writeText(url).then(() => {
                alert('Tautan dokumen berhasil disalin!');
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
            alert('Tautan dokumen berhasil disalin!');
        } catch (err) {
            alert('Gagal menyalin tautan.');
        }
        document.body.removeChild(textArea);
    }
</script>
@endsection