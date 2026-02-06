@props(['news'])

<!-- hanya menampilkan 3 berita terbaru berdasarkan tanggal upload -->
@php
$latestNews = $news->sortByDesc('published_at')->take(3);

// ambil nama opd
$opdName = $latestNews->first()?->opd?->name ?? 'Instansi';
@endphp

<!-- jika berita lebih dari -->
@if ($latestNews->count() > 0)
<section class="w-full bg-white mb-2 py-10 md:py-20">
    <div class="max-w-screen-lg px-4 bg-white mx-auto grid gap-6">
        <p class="flex justify-center text-2xl md:text-2xl font-medium text-slate-700">Berita {{ $opdName }}
        <div class="w-full md:w-l mb-2 h-0.5 mx-auto bg-gradient-to-r from-transparent via-orange-500 to-transparent">
        </div>
        </p>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            @php
            $first = $latestNews->first();
            $firstImage = asset('storage/' . $first->images);
            @endphp
            <div class="h-80 md:h-[500px] relative overflow-hidden rounded-2xl group">
                <div class="absolute inset-0 bg-cover bg-center transition-transform duration-500 group-hover:scale-105"
                    style="background-image: url('{{ $firstImage }}')"></div>
                <div
                    class="absolute inset-0 bg-gradient-to-t from-slate-900 via-slate-900/40 to-transparent p-6 flex flex-col justify-between">
                    <div class="bg-blue-600 w-fit px-3 py-1 rounded-full text-white text-xs font-semibold">
                        {{ $first->published_at->isoFormat('D MMMM Y') }}
                    </div>
                    <div class="flex flex-col gap-4">
                        <a href="/berita/{{ $first->slug }}"
                            class="text-2xl md:text-3xl font-bold text-white hover:underline decoration-2 underline-offset-4 line-clamp-3 leading-tight">
                            {{ $first->title }}
                        </a>
                        <div class="flex justify-end">
                            <a href="/berita/{{ $first->slug }}"
                                class="bg-white/20 backdrop-blur-md hover:bg-white p-3 rounded-full transition-all duration-300 group/btn">
                                <svg xmlns="http://www.w3.org/2000/svg"
                                    class="h-6 w-6 text-white group-hover/btn:text-slate-900 group-hover/btn:rotate-45 transition-transform"
                                    fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="m4.5 19.5 15-15m0 0H8.25m11.25 0v11.25" />
                                </svg>
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-2 gap-4">
                @foreach ($latestNews->slice(1)->values() as $index => $item)
                @php
                // Berita kedua (index 0 di slice) ambil lebar penuh, sisanya bagi dua
                $isWide = $index === 0;
                $image = asset('storage/' . $item->images);
                @endphp

                <div
                    class="{{ $isWide ? 'col-span-2 h-48 md:h-60' : 'col-span-1 h-44 md:h-56' }} relative rounded-2xl overflow-hidden group shadow-sm">
                    <div class="absolute inset-0 bg-cover bg-center transition-transform duration-500 group-hover:scale-105"
                        style="background-image: url('{{ $image }}')"></div>

                    {{-- Overlay Gradasi agar teks terbaca --}}
                    <div
                        class="absolute inset-0 bg-gradient-to-t from-slate-900/90 via-slate-900/20 to-transparent p-4 flex flex-col justify-between">
                        <span class="text-[10px] md:text-xs text-slate-200 font-medium">
                            {{ $item->published_at->isoFormat('D MMM Y') }}
                        </span>

                        <div class="flex flex-col gap-2">
                            <a href="/berita/{{ $item->slug }}"
                                class="text-sm md:text-base font-semibold text-white line-clamp-2 hover:text-blue-300 transition-colors leading-tight">
                                {{ $item->title }}
                            </a>
                            <div class="flex justify-end">
                                <a href="/berita/{{ $item->slug }}"
                                    class="bg-white/10 backdrop-blur-sm border border-white/20 hover:bg-white p-1.5 rounded-full transition-all group/sbtn">
                                    <svg xmlns="http://www.w3.org/2000/svg"
                                        class="h-4 w-4 text-white group-hover/sbtn:text-slate-900 group-hover/sbtn:rotate-45"
                                        fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="m4.5 19.5 15-15m0 0H8.25m11.25 0v11.25" />
                                    </svg>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>

        <!-- lihat semua berita yang tersedia -->
        <div class="md:hidden">
            <a href="/berita" class="block w-full text-center bg-slate-100 text-slate-800 py-2 rounded-2xl font bold">
                Lihat Semua Berita Tersedia</a>
        </div>

    </div>
</section>
@endif