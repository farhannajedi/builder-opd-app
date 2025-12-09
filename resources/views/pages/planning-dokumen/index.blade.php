@php
// Query untuk mengambil dokumen terbaru
$documents = App\Models\PlanningDocument::with('opd')->latest()->paginate(10);
@endphp

@extends('layouts.app', ['activePage' => 'Arsip Dokumen'])

@section('content')
<div class="bg-gray-50 min-h-screen">
    <section class="max-w-screen-xl px-4 mx-auto w-full py-12 md:py-16">

        {{-- Header Halaman --}}
        <div class="mb-10 border-b border-gray-300 pb-3">
            <h1 class="text-2xl md:text-2xl font-extrabold text-gray-900 tracking-tight">
                Arsip Dokumen Perencanaan
            </h1>
        </div>

        {{-- CONTAINER UTAMA --}}
        <div class="grid grid-cols-1 gap-10">

            {{-- LIST DOKUMEN --}}
            <div class="bg-white p-6 md:p-8 rounded-xl shadow-lg border border-gray-200">
                <p class="text-2xl font-semibold text-gray-700 mb-6 border-b pb-4">
                    Dokumen Terbaru
                </p>

                <div class="space-y-4">
                    @forelse ($documents as $doc)

                    {{-- CARD DOKUMEN BARU (Link ke Detail Halaman) --}}
                    <a href="/planning-dokumen/{{ $doc->slug }}"
                        class="block border border-gray-200 rounded-lg p-4 transition duration-300 hover:shadow-md hover:border-blue-400 bg-white group"
                        style="text-decoration: none;">

                        <div class="flex items-start justify-between gap-4">

                            {{-- KIRI: ICON DAN DETAIL DOKUMEN --}}
                            <div class="flex items-start gap-4 flex-grow">

                                {{-- ICON FILE STATIS (PDF/DOC) --}}
                                <div class="bg-blue-100 rounded-lg p-3 flex-none">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-blue-600"
                                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                        stroke-linecap="round" stroke-linejoin="round">
                                        <path d="M14 3v4a1 1 0 0 0 1 1h4" />
                                        <path d="M17 21H7a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h7l5 5v11a2 2 0 0 1-2 2z" />
                                    </svg>
                                </div>

                                {{-- DETAIL --}}
                                <div class="flex-grow space-y-1">
                                    <p
                                        class="text-lg font-bold text-gray-800 line-clamp-2 group-hover:text-blue-600 transition duration-150">
                                        {{ $doc->title }}
                                    </p>

                                    {{-- META DATA --}}
                                    <div class="flex flex-wrap text-sm text-gray-500 gap-x-4 gap-y-1 mt-1">

                                        {{-- TANGGAL --}}
                                        <div class="flex items-center gap-1">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 stroke-[1.5]"
                                                fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                            </svg>
                                            <span>{{ $doc->created_at->isoFormat('D MMMM Y') }}</span>
                                        </div>

                                        {{-- OPD --}}
                                        <div class="flex items-center gap-1">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 stroke-[1.5]"
                                                viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                stroke-linecap="round" stroke-linejoin="round">
                                                <path d="M3 21v-2a4 4 0 0 1 4-4h10a4 4 0 0 1 4 4v2" />
                                                <circle cx="12" cy="7" r="4" />
                                            </svg>
                                            <span>{{ $doc->opd->name ?? 'OPD Tidak Diketahui' }}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            {{-- KANAN: STATUS DAN INDIKATOR LINK --}}
                            <div class="flex-none flex items-center gap-2">

                                {{-- INDIKATOR NON-LINK --}}
                                <div
                                    class="bg-blue-600 text-white rounded-lg px-3 py-2 text-sm font-medium flex items-center gap-1">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 24 24"
                                        fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                        stroke-linejoin="round">
                                        <path d="M14 3v4a1 1 0 0 0 1 1h4" />
                                        <path d="M17 21H7a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h7l5 5v11a2 2 0 0 1-2 2z" />
                                    </svg>
                                    Detail File
                                </div>

                                {{-- Panah Link --}}
                                <div class="hidden md:block">
                                    <svg xmlns="http://www.w3.org/2000/svg"
                                        class="h-6 w-6 text-blue-500 group-hover:translate-x-1 transition duration-150"
                                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                        stroke-linecap="round" stroke-linejoin="round">
                                        <path d="M5 12h14M12 5l7 7-7 7" />
                                    </svg>
                                </div>
                            </div>
                        </div>
                    </a>
                    @empty
                    <div class="bg-gray-100 p-8 text-center rounded-lg text-gray-600">
                        <p>Tidak ada dokumen perencanaan yang ditemukan saat ini.</p>
                    </div>
                    @endforelse
                </div>

                {{-- Pagination --}}
                @if ($documents->hasPages())
                <div class="pt-6 border-t mt-6 border-gray-200">
                    {{ $documents->links() }}
                </div>
                @endif
            </div>
        </div>
    </section>
</div>
@endsection