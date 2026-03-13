@props(['galleries'])

@php

$opdSlug = env('APP_ID');
$opd = App\Models\Opd::where('slug', $opdSlug)->first();

$galleries = $galleries->where('opd_id', $opd?->id)->sortByDesc('published_at')->take(3);

$opdName = $opd?->name ?? 'Instansi';
@endphp

<div class="w-full max-w-screen-lg px-4 bg-white mx-auto pb-22 grid gap-6">
    <section class="w-full bg-white py-10 md:py-10">
        <!-- card pembungkus utama -->
        <div class="bg-white p-6 md:p-8 rounded-xl shadow-xl border border-gray-200">
            <div class="text-center mb-6">
                <p class="flex justify-center text-2xl font-bold text-gray-700 mb-2 pb-2">
                    Galleri Foto
                </p>
                <div class="w-full h-0.5 mx-auto mt-2 bg-gradient-to-r from-transparent via-orange-500 to-transparent">
                </div>
            </div>

            <!-- daftar galleri -->
            <div class="flex flex-wrap justify-center gap-6">
                @forelse ($galleries as $gal)
                <div wire:key="gal-{{ $gal->id }}"
                    class="relative w-full sm:w-[48%] md:w-[30%] aspect-[3/4] overflow-hidden rounded-xl shadow-lg group transition duration-500 hover:scale-[1.02]">

                    <img src="{{ url('storage/' . $gal->images) }}" alt="{{ $gal->title }}"
                        class="absolute inset-0 w-full h-full object-cover transition duration-500 group-hover:scale-110">

                    <div class="absolute inset-0 bg-gradient-to-t from-black/90 via-black/40 to-transparent"></div>

                    <div class="absolute inset-0 p-5 flex flex-col justify-end">
                        <h3 class="text-lg font-semibold text-white text-center mb-2">
                            {{ $gal->title }}
                        </h3>

                        <p class="text-sm text-gray-400 text-center line-clamp-3 mb-3">
                            {{ $gal->description }}
                        </p>

                        <!-- status dan indikator link detail layanan -->
                        <div class="flex justify-center gap-2">
                            <a href="/galeri/{{ $gal->slug }}"
                                class="bg-orange-600 text-white rounded-lg px-3 py-2 text-sm font-medium flex items-center gap-1">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 24 24" fill="none"
                                    stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round">
                                    <path d="M14 3v4a1 1 0 0 0 1 1h4" />
                                    <path d="M17 21H7a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h7l5 5v11a2 2 0 0 1-2 2z" />
                                </svg>
                                Detail File
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke-width="1.5" stroke="currentColor" class="size-4">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="m4.5 19.5 15-15m0 0H8.25m11.25 0v11.25"></path>
                                </svg>
                            </a>
                        </div>
                    </div>
                </div>
                @empty
                <div class="w-full bg-gray-100 p-8 text-center rounded-lg text-gray-600">
                    <p>Belum ada Galeri yang dipublikasikan.</p>
                </div>
                @endforelse
            </div>

            <!-- indikator link panah ke daftar galeri -->
            <footer class="flex pt-4 items-center gap-4">
                <div class="flex-grow border-b border-yellow-500"></div>
                <a wire:navigate="" href="/galeri"
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