@php

$document = App\Models\PlanningDocument::with('opd')
->where('slug', $slug)
->firstOrFail();

$fileUrl = asset('storage/' . $document->file);
$extension = strtolower(pathinfo($document->file, PATHINFO_EXTENSION));

@endphp

@extends('layouts.app', ['activePage' => 'Arsip Dokumen'])

@section('content')
<div class="max-w-5xl mx-auto py-10">
    <!-- bagian header section -->
    <div class="bg-white shadow-md rounded-xl p-8 mb-10 border border-gray-200">
        <a href="/planning-dokumen"
            class="mt-3 inlibe-flex bg-blue-600 text-white gap-2 rounded-lg px-3 py-2 text-sm hover:text-gray-800 px-4">
            Kembali ke Daftar Dokumen
        </a>

        <h1 class="text-4xl font-extrabold text-gray-800 leading-tight">
            {{ $document->title }}
        </h1>

        <div class="mt-3 flex items-center gap-3 text-gray-600">
            <div class="px-3 py-1 bg-blue-100 text-blue-700 rounded-full text-xs font-semibold uppercase tracking-wide">
                {{ $document->opd->name }}
            </div>

            @if ($document->published_at)
            <p class="text-sm">
                Dipublikasikan: <strong>{{ Carbon\Carbon::parse($document->published_at)->format('d M Y') }}</strong>
            </p>
            @endif
        </div>
    </div>

    <!-- mengarahkan ke detail file / folder -->
    @if ($document->file)
    <div class="bg-white shadow-md rounded-xl border border-gray-200 overflow-hidden mb-10">
        <div class="p-5 border-b">
            <h3 class="text-xl font-semibold text-gray-800 flex items-center gap-2">
                Pratinjau Dokumen
            </h3>
            <p class="text-sm text-gray-500">** Jika preview tidak tampil, gunakan tombol download di bawah .**</p>
        </div>

        <div class="w-full bg-gray-50">
            @if ($extension === 'pdf')
            {{-- PDF VIEWER --}}
            <iframe src="{{ $fileUrl }}" class="w-full h-[700px] rounded-b-xl"></iframe>
            @else
            {{-- GOOGLE DOCS VIEWER --}}
            <iframe src="https://docs.google.com/gview?url={{ $fileUrl }}&embedded=true"
                class="w-full h-[700px] rounded-b-xl" frameborder="0"></iframe>
            @endif
        </div>
    </div>
    @endif


    <!-- content  -->
    <div class="bg-white shadow-md rounded-xl border border-gray-200 p-8 mb-10">
        <article class="prose prose-lg max-w-none text-gray-800 leading-relaxed">
            {!! $document->content !!}
        </article>
    </div>

    <!-- button section download -->
    @if ($document->file)
    <div class="flex justify-center">
        <a href="{{ $fileUrl }}" target="_blank"
            class="px-6 py-3 bg-green-600 text-white text-lg font-semibold rounded-lg shadow hover:bg-green-700 hover:shadow-lg transition">
            Download Dokumen
        </a>
    </div>
    @endif

</div>

@endsection