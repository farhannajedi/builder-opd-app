@php

$opdSlug = env('APP_ID');

$opd = App\Models\Opd::where('slug', $opdSlug)->first();

$announcement = App\Models\announcement::where('opd_id', $opd?->id)->with('opd')->latest()->paginate(10);

@endphp

@extends('layouts.app', ['activePage' => 'Pengumuman'])

@section('content')
<div class="max-w-screen-lg mx-auto w-full pb-18">
    <section class="max-w-screen-xl px-4 mx-auto w-full py-2 md:py-6">

        <!-- header halaman -->
        <div class="pt-2 mb-10 border-gray-300 pb-3">
            <p class="flex justify-center text-2xl font-bold text-gray-700 mb-2">Pengumuman Terbaru</p>
            <div class="w-full h-0.5 mx-auto mt-2 bg-gradient-to-r from-transparent via-orange-500 to-transparent">
            </div>
        </div>

        <!-- container utama -->
        <div class="grid grid-cols-1 gap-10">
            <!-- list pengumuman -->
            <div class="bg-white p-6 md:p-8 rounded-xl shadow-lg border border-gray-400">
                <p class="flex justify-center text-2xl font-semibold text-gray-700 mb-6 border-b pb-4">
                    Pengumuman Resmi
                </p>

                <div class="space-y-4">
                    @forelse ($announcement as $item)
                    <!-- Link ke Detail Halaman -->
                    <a href="/pengumuman/{{ $item->slug }}"
                        class="block border border-gray-300 rounded-lg p-4 transition duration-300 hover:shadow-md hover:border-orange-200 bg-white group"
                        style="text-decoration: none;">
                        <div class="flex items-start justify-between gap-4">
                            <!-- icon dan detail pengumuman -->
                            <div class="flex items-start gap-4 flex-grow">
                                <!-- icon file statis -->
                                <div class="bg-blue-100 rounded-lg p-3 flex-none">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-orange-600"
                                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                        stroke-linecap="round" stroke-linejoin="round">
                                        <path d="M14 3v4a1 1 0 0 0 1 1h4" />
                                        <path d="M17 21H7a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h7l5 5v11a2 2 0 0 1-2 2z" />
                                    </svg>
                                </div>

                                <!-- detail pengumuman -->
                                <div class="flex-grow space-y-1">
                                    <p
                                        class="text-lg font-bold text-gray-800 line-clamp-2 group-hover:text-slate-600 transition duration-150">
                                        {{ $item->title }}
                                    </p>

                                    <!-- metadata -->
                                    <div class="flex flex-wrap text-sm text-gray-500 gap-x-4 gap-y-1 mt-1">
                                        <!-- tanggal diupload -->
                                        <div class="flex items-center gap-1">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 stroke-[1.5]"
                                                fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                            </svg>
                                            {{ $item->created_at->format('d M Y') }} |
                                            {{ $item->opd->name ?? 'Instansi' }}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </a>
                    @empty
                    <p class="text-center text-gray-500 py-10">Belum ada pengumuman terbaru.</p>
                    @endforelse
                </div>
            </div>
        </div>
    </section>
</div>
@endsection