@props(['services'])

@php
$latestServices = $services->sortByDesc('created_at')->take(3);

$opdName = $latestServices->first()?->opd?->name ?? 'Instansi';
@endphp

<div class="max-w-screen-lg mx-auto w-full">
    <section class="max-w-screen-xl px-2 mx-auto w-full py-2 md:py-2">
        <!-- Card Utama -->
        <div class="bg-white p-6 md:p-8 rounded-xl shadow-xl border border-gray-200">
            <div class="text-center mb-6">
                <p class="flex justify-center text-xl font-semibold text-gray-700 mb-2 pb-2">
                    Layanan Tersedia
                </p>
                <div class="w-full h-0.5 mx-auto mt-2 bg-gradient-to-r from-transparent via-orange-500 to-transparent">
                </div>
            </div>

            <!-- Grid Layanan -->
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6 justify-items-center">
                @forelse($latestServices as $service)
                <div
                    class="w-full max-w-sm border border-gray-200 rounded-lg p-5 transition duration-300 hover:border-orange-300 bg-white flex flex-col h-full">
                    <!-- Icon -->
                    <div class="flex justify-center mb-4">
                        <div class="bg-blue-100 rounded-lg p-3">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7 text-orange-600" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round">
                                <path d="M14 3v4a1 1 0 0 0 1 1h4" />
                                <path d="M17 21H7a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h7l5 5v11a2 2 0 0 1-2 2z" />
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
                            class="bg-orange-600 text-white rounded-lg px-3 py-2 text-sm font-medium flex items-center gap-1">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 24 24" fill="none"
                                stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M14 3v4a1 1 0 0 0 1 1h4" />
                                <path d="M17 21H7a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h7l5 5v11a2 2 0 0 1-2 2z" />
                            </svg>
                            Detail File
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                stroke="currentColor" class="size-4">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="m4.5 19.5 15-15m0 0H8.25m11.25 0v11.25"></path>
                            </svg>
                        </a>
                    </div>
                </div>

                @empty
                <p class="col-span-3 text-center text-gray-500">
                    Belum ada layanan tersedia.
                </p>
                @endforelse
            </div>

            <footer class="flex pt-4 items-center gap-4">
                <div class="flex-grow border-b border-yellow-500"></div>
                <a wire:navigate="" href="/layanan"
                    class="inline-flex items-center gap-2 border border-slate-200 px-4 py-2 rounded-xl bg-orange-500 hover:bg-orange-600 text-white transition">
                    Selengkapnya
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="currentColor" class="size-4">
                        <path stroke-linecap="round" stroke-linejoin="round" d="m4.5 19.5 15-15m0 0H8.25m11.25 0v11.25">
                        </path>
                    </svg>
                </a>
            </footer>
        </div>
    </section>
</div>