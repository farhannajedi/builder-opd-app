@php
// daftar OPD unik (untuk sidebar)
$opdList = \App\Models\PlanningDocument::with('opd')
->get()
->pluck('opd.name')
->unique()
->filter()
->values();

// list dokumen terbaru
$documents = \App\Models\PlanningDocument::with('opd')
->latest()
->paginate(10);
@endphp

@extends('layouts.app', ['activePage' => 'informasi-publik'])

@section('content')
<section class="max-w-screen-lg px-2 mx-auto w-full">
    <div class="pt-10">
        <p class="text-4xl font-medium text-slate-800">Dokumen Perencanaan</p>
    </div>

    <div class="flex flex-col md:flex-row gap-2 py-16">
        {{-- SIDEBAR --}}
        <div class="w-full md:w-1/3 p-4 h-min border rounded-lg border-slate-200 space-y-2">
            <p class="text-lg font-medium text-slate-600">Organisasi/OPD</p>
            <hr class="border-t border-slate-200">

            <ul class="space-y-2 text-slate-500">
                <li>
                    <a href="javascript:void(0)"
                        class="block hover:px-2 duration-200 py-2 rounded-md hover:bg-slate-200">
                        Semua
                    </a>
                </li>

                @foreach ($opdList as $opd)
                <li>
                    <a href="javascript:void(0)"
                        class="block hover:px-2 duration-200 py-2 rounded-md hover:bg-slate-200">
                        {{ $opd }}
                    </a>
                </li>
                @endforeach
            </ul>
        </div>

        {{-- LIST DOKUMEN --}}
        <div class="w-full md:w-2/3 p-4 border rounded-lg border-slate-200 space-y-4">
            <p class="text-2xl font-medium text-slate-600">Semua Dokumen</p>

            <div class="pt-4 border-t border-slate-300 space-y-4">
                @forelse ($documents as $doc)
                <div class="p-2 flex items-start h-full border border-slate-300 hover:border-slate-400 
                                gap-2 rounded-lg h-min group duration-200">

                    {{-- ICON FILE --}}
                    <div class="hidden md:block bg-slate-100 rounded p-4">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"
                            class="h-12 w-auto flex-none text-slate-500 group-hover:text-slate-600">
                            <path stroke="none" d="M0 0h24v24H0z" />
                            <path d="M14 3v4a1 1 0 0 0 1 1h4" />
                            <path d="M5 12v-7a2 2 0 0 1 2 -2h7l5 5v4" />
                            <path d="M5 18h1.5a1.5 1.5 0 0 0 0 -3h-1.5v6" />
                            <path d="M17 18h2" />
                            <path d="M20 15h-3v6" />
                            <path d="M11 15v6h1a2 2 0 0 0 2 -2v-2a2 2 0 0 0 -2 -2h-1z" />
                        </svg>
                    </div>

                    <div class="space-y-2 flex flex-col justify-between h-full w-full">
                        <p class="text-xl font-medium text-slate-700 group-hover:text-slate-800 line-clamp-2">
                            {{ $doc->title }}
                        </p>

                        <div class="flex gap-2 text-slate-600 items-center justify-between">
                            <div class="flex flex-col md:flex-row md:items-center gap-2">

                                {{-- TANGGAL --}}
                                <div class="flex items-center gap-1">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                        stroke="currentColor" class="h-5 w-5 stroke-[1.5]">
                                        <path stroke="none" d="M0 0h24v24H0z" />
                                        <path
                                            d="M4 5m0 2a2 2 0 0 1 2 -2h12a2 2 0 0 1 2 2v12a2 2 0 0 1 -2 2h-12a2 2 0 0 1 -2 -2z" />
                                        <path d="M16 3l0 4" />
                                        <path d="M8 3l0 4" />
                                        <path d="M4 11h16" />
                                    </svg>
                                    <p>{{ $doc->created_at->isoFormat('D MMMM Y') }}</p>
                                </div>

                                <x-icons.dot class="hidden md:block h-1 w-1 text-slate-400" />

                                {{-- OPD --}}
                                <div class="flex items-center gap-1">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                        stroke="currentColor" class="h-5 w-5 stroke-[1.5]">
                                        <path d="M4 21v-15c0 -1 1 -2 2 -2h5c1 0 2 1 2 2v15" />
                                        <path d="M16 8h2c1 0 2 1 2 2v11" />
                                    </svg>
                                    <p>{{ $doc->opd->name ?? 'Tidak diketahui' }}</p>
                                </div>
                            </div>

                            {{-- TOMBOL DOWNLOAD --}}
                            <a href="{{ asset('storage/' . $doc->file) }}" download
                                class="bg-white border border-slate-400 text-slate-700 hover:bg-slate-800 
                                           hover:text-white cursor-pointer rounded px-2 py-1 flex gap-1 active:scale-95">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-linecap="round"
                                    stroke-linejoin="round" class="h-auto w-5 stroke-[1.5]">
                                    <path d="M4 17v2a2 2 0 0 0 2 2h12a2 2 0 0 0 2 -2v-2" />
                                    <path d="M7 11l5 5l5 -5" />
                                    <path d="M12 4v12" />
                                </svg>
                                <span class="text-sm">Unduh</span>
                            </a>
                        </div>
                    </div>
                </div>

                @empty
                <p class="text-slate-500">Tidak ada dokumen ditemukan.</p>
                @endforelse
            </div>

            {{-- Pagination --}}
            <div class="pt-4">
                {{ $documents->links() }}
            </div>
        </div>
    </div>
</section>
@endsection