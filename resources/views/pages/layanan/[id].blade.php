@php
// Ambil parameter id dari URL (Folio)
$service = App\Models\Service::with('opd')
->where('id', $id)
->whereNotNull('published_at')
->firstOrFail();
@endphp

@extends('layouts.app', ['activePage' => 'Detail Layanan'])

@section('content')
<div class="max-w-screen-lg mx-auto w-full">
    <section class="max-w-screen-xl px-4 mx-auto w-full py-12 md:py-16">

        <!-- Breadcrumb  -->
        <div class="mb-6 text-sm text-gray-500">
            <a href="/layanan" class="hover:text-blue-600">Layanan</a>
            <span class="mx-2">/</span>
            <span class="text-gray-700">{{ $service->name }}</span>
        </div>

        <!-- Judul Layanan -->
        <div class="mb-10 border-b border-gray-300 pb-4">
            <h1 class="text-4xl font-semibold text-slate-800">
                {{ $service->name }}
            </h1>

            <div class="mt-3 flex flex-wrap gap-4 text-sm text-gray-500">
                <span>
                    Dipublikasikan:
                    <strong>
                        {{ $service->published_at->isoFormat('D MMMM Y') }}
                    </strong>
                </span>

                <span>
                    OPD:
                    <strong>
                        {{ $service->opd->name ?? '-' }}
                    </strong>
                </span>
            </div>
        </div>

        <!-- Konten Deskripsi -->
        <div class="mt-4 mb-6 bg-white rounded-xl shadow border border-gray-200 p-6 md:p-8">
            <article class="prose max-w-none">
                {!! nl2br(e($service->description)) !!}
            </article>
        </div>

        <!-- Tombol Kembali  -->
        <div class="flex mt-8">
            <a href="/layanan" class="inlibe-flex bg-blue-600 text-white gap-2 rounded-lg px-3 py-2 text-sm">
                Kembali Ke Daftar Layanan
            </a>
        </div>

    </section>
</div>
@endsection