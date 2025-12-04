@php
use App\Models\PlanningDocument;

// variabel $slug dari URL (misal: /dokumen/nama-dokumen)
$document = PlanningDocument::with('opd')->where('slug', $slug)->first();

// path file dan tipe:
$relativePath = 'storage/' . $document->file;

// Hitung ukuran dan tipe file
$fileSize = 'N/A';
if (file_exists($fullPath)) {
$fileSize = number_format(filesize($fullPath) / 1024 / 1024, 2) . ' MB';
}
$fileType = strtoupper(pathinfo($document->file, PATHINFO_EXTENSION) ?? 'N/A');

@endphp

@extends('layouts.app', ['activePage' => 'Informasi Publik'])

@section('content')
<div class="bg-gray-50 min-h-screen">
    <section class="max-w-screen-xl px-4 mx-auto w-full py-12 md:py-16">

        {{-- Header Breadcrumb --}}
        <div class="mb-6 text-sm text-gray-500">
            <a href="/dokumen" class="hover:underline">Dokumen Perencanaan</a>
            <span class="mx-1">/</span>
            <span class="font-medium text-gray-700">{{ Str::limit($document->title, 50) }}</span>
        </div>

        {{-- GRID UTAMA: INFORMASI (Kiri) dan PREVIEW (Kanan) --}}
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">

            {{-- Kolom Kiri: INFORMASI DETAIL --}}
            <div class="md:col-span-1 bg-white p-6 rounded-xl shadow-lg border border-gray-200 h-min">

                <h1 class="text-2xl font-bold text-gray-800 mb-4">
                    {{ $document->title }}
                </h1>

                <hr class="mb-4 border-gray-200">

                @if ($document->content)
                <div class="mb-4 text-sm text-gray-700 leading-relaxed">
                    <p class="font-semibold text-base mb-1">Deskripsi:</p>
                    {{-- Asumsi content adalah Rich Editor HTML --}}
                    {!! $document->content !!}
                </div>
                <hr class="mb-4 border-gray-200">
                @endif

                {{-- METADATA DOKUMEN --}}
                <div class="space-y-3 text-sm text-gray-600">
                    <p class="flex items-center gap-2">
                        <span class="font-semibold w-24">Oleh:</span>
                        <span>{{ $document->opd->name ?? 'Tidak Diketahui' }}</span>
                    </p>
                    <p class="flex items-center gap-2">
                        <span class="font-semibold w-24">Publikasi:</span>
                        {{-- Menggunakan created_at --}}
                        <span>{{ $document->created_at->isoFormat('D MMMM Y') }}</span>
                    </p>
                    <p class="flex items-center gap-2">
                        <span class="font-semibold w-24">Terakhir diperbarui:</span>
                        <span>{{ $document->updated_at->isoFormat('D MMMM Y') }}</span>
                    </p>
                    <p class="flex items-center gap-2">
                        <span class="font-semibold w-24">Ukuran File:</span>
                        <span>{{ $fileSize }}</span>
                    </p>
                    <p class="flex items-center gap-2">
                        <span class="font-semibold w-24">Jenis File:</span>
                        <span>{{ $fileType }}</span>
                    </p>
                </div>

                <hr class="my-4 border-gray-200">

                {{-- TOMBOL DOWNLOAD --}}
                <a href="{{ asset($relativePath) }}" download
                    class="w-full bg-blue-600 text-white rounded-lg px-4 py-3 text-lg font-medium flex items-center justify-center gap-2 hover:bg-blue-700 transition duration-200 shadow-md">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" viewBox="0 0 24 24" fill="none"
                        stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M12 5v14" />
                        <path d="M19 12l-7 7-7-7" />
                    </svg>
                    Download
                </a>
            </div>

            {{-- Kolom Kanan: PREVIEW DOKUMEN --}}
            <div class="md:col-span-2 bg-white rounded-xl shadow-lg border border-gray-200 overflow-hidden">
                <div class="p-4 bg-gray-100 border-b border-gray-200 flex items-center gap-2 text-gray-700">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 24 24" fill="none"
                        stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M12 2v20M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6" />
                    </svg>
                    <span class="font-semibold">Preview Dokumen</span>
                </div>

                {{-- IFRAME UNTUK MENAMPILKAN PDF DENGAN GOOGLE VIEWER --}}
                <iframe src="https://docs.google.com/gview?url={{ url(asset($relativePath)) }}&embedded=true"
                    class="w-full" style="height: 80vh;" frameborder="0">
                    <p class="p-4 text-center text-gray-500">
                        Browser Anda tidak mendukung preview. Silakan unduh dokumen.
                    </p>
                </iframe>
            </div>
        </div>
    </section>
</div>
@endsection