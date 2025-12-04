@php
$galleries = App\Models\Galleries::orderBy('created_at', 'desc')->get();
@endphp

@extends('layouts.app', ['activePage' => 'galeri'])

@section('content')
<section class="max-w-screen-lg px-2 mx-auto w-full">
    <div class="pt-10">
        <p class="text-4xl font-medium text-slate-800">Galeri</p>
    </div>

    <div class="flex flex-col md:flex-row gap-2 py-16">

        {{-- LIST GALERI --}}
        <div class="w-full md:w-2/3 p-4 border rounded-lg border-slate-200 space-y-4">
            <p class="text-2xl font-medium text-slate-600">Semua Galeri</p>

            <div class="pt-4 border-t border-slate-300 space-y-4">
                @forelse ($galleries as $gal)
                <div class="p-2 flex items-start h-full border border-slate-300 hover:border-slate-400 
                                gap-2 rounded-lg h-min group duration-200">

                    {{-- Gambar --}}
                    <div class="hidden md:block bg-slate-100 rounded p-1">
                        <img src="{{ asset('storage/' . $gal->images) }}" alt="{{ $gal->title }}"
                            class="h-20 w-24 object-cover rounded-md">
                    </div>

                    <div class="space-y-2 flex flex-col justify-between h-full w-full">

                        {{-- Judul --}}
                        <p class="text-xl font-medium text-slate-700 group-hover:text-slate-800 line-clamp-2">
                            {{ $gal->title }}
                        </p>

                        {{-- Deskripsi --}}
                        <p class="text-slate-600 text-sm line-clamp-3">
                            {{ $gal->description }}
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
                                    <p>
                                        {{ $gal->published_at 
                                            ? \Carbon\Carbon::parse($gal->published_at)->isoFormat('D MMMM Y')
                                            : $gal->created_at->isoFormat('D MMMM Y') }}
                                    </p>
                                </div>

                                <x-icons.dot class="hidden md:block h-1 w-1 text-slate-400" />

                                {{-- OPD --}}
                                <div class="flex items-center gap-1">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                        stroke="currentColor" class="h-5 w-5 stroke-[1.5]">
                                        <path d="M4 21v-15c0 -1 1 -2 2 -2h5c1 0 2 1 2 2v15" />
                                        <path d="M16 8h2c1 0 2 1 2 2v11" />
                                    </svg>
                                    <p>{{ $gal->opd->name ?? 'Tidak diketahui' }}</p>
                                </div>
                            </div>

                            {{-- TOMBOL LIHAT --}}
                            <a href="{{ asset('storage/' . $gal->images) }}" target="_blank" class="bg-white border border-slate-400 text-slate-700 hover:bg-slate-800 
                                       hover:text-white cursor-pointer rounded px-2 py-1 flex gap-1 active:scale-95">

                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-linecap="round"
                                    stroke-linejoin="round" class="h-auto w-5 stroke-[1.5]">
                                    <path d="M8 6h13" />
                                    <path d="M8 12h13" />
                                    <path d="M8 18h13" />
                                    <path d="M3 6h.01" />
                                    <path d="M3 12h.01" />
                                    <path d="M3 18h.01" />
                                </svg>

                                <span class="text-sm">Lihat</span>
                            </a>

                        </div>
                    </div>
                </div>

                @empty
                <p class="text-slate-500">Tidak ada galeri ditemukan.</p>
                @endforelse
            </div>
        </div>
    </div>
</section>
@endsection