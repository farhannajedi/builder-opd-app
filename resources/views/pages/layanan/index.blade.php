@php

$opdSlug = env('APP_ID'); // Ambil slug OPD dari environment variable

$opd = App\Models\Opd::where('slug', $opdSlug)->first();

// Ambil semua layanan yang sudah dipublish
$services = App\Models\Service::where('opd_id',
$opd?->id)->with('opd')->latest()->paginate(10);
@endphp

@extends('layouts.app', ['activePage' => 'Layanan'])

@section('content')
<!-- halaman layanan -->
<div class="max-w-screen-lg pb-18 py-2 mx-auto w-full">
    <section class="max-w-screen-xl px-2 mx-auto w-full py-2 md:py-2">
        <!-- Card Utama -->
        <div class="bg-white p-6 md:p-8 rounded-xl">
            <div class="text-center mb-6">
                <h5 class="flex justify-center text-2xl font-bold text-gray-700 mb-2 pb-4">
                    Layanan Tersedia
                </h5>
                <div class="w-full h-0.5 mx-auto mt-2 bg-gradient-to-r from-transparent via-orange-500 to-transparent">
                </div>
            </div>

            <!-- Grid Layanan -->
            <div class="flex pt-2 flex-wrap grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6 justify-center">
                @forelse($services as $service)
                <div
                    class="w-full max-w-sm border border-slate-300 rounded-lg shadow-lg p-5 transition duration-300 hover:border-orange-300 bg-white flex flex-col h-full">
                    <!-- Icon -->
                    <div class="flex justify-center mb-4">
                        <div class="bg-blue-100 rounded-lg p-3">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round" class="lucide lucide-album-icon lucide-album">
                                <rect width="18" height="18" x="3" y="3" rx="2" ry="2" />
                                <polyline points="11 3 11 11 14 8 17 11 17 3" />
                            </svg>
                        </div>
                    </div>

                    <!-- Nama Layanan -->
                    <h3 class="text-lg font-semibold text-gray-800 text-center mb-2">
                        {{ $service->name }}
                    </h3>

                    <!-- Deskripsi -->
                    <p class="text-sm text-gray-600 text-center line-clamp-3 mb-4">
                        {{ $service->description }}
                    </p>

                    <!-- status dan indikator link detail layanan -->
                    <div class="flex justify-center gap-2">
                        <a href="/layanan/{{ $service->id }}"
                            class="bg-orange-500 text-white rounded-lg px-3 py-2 text-sm font-medium flex items-center gap-1 hover:bg-orange-600 transition">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round" class="lucide lucide-newspaper-icon lucide-newspaper">
                                <path d="M15 18h-5" />
                                <path d="M18 14h-8" />
                                <path
                                    d="M4 22h16a2 2 0 0 0 2-2V4a2 2 0 0 0-2-2H8a2 2 0 0 0-2 2v16a2 2 0 0 1-4 0v-9a2 2 0 0 1 2-2h2" />
                                <rect width="8" height="4" x="10" y="6" rx="1" />
                            </svg>
                            Detail Layanan
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                stroke="currentColor" class="size-4">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="m4.5 19.5 15-15m0 0H8.25m11.25 0v11.25"></path>
                            </svg>
                        </a>
                    </div>
                </div>

                @empty
                <div
                    class="col-span-full py-20 text-center bg-slate-50 rounded-2xl border-2 border-dashed border-slate-200">
                    <p class="text-slate-500 italic">Belum ada layanan yang disediakan.</p>
                </div>
                @endforelse
            </div>
        </div>
    </section>
</div>
@endsection