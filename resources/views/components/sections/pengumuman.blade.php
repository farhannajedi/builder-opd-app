@props(['announcement'])

@php

$opdSlug = env('APP_ID');
$opd = App\Models\Opd::where('slug', $opdSlug)->first();

use Illuminate\Support\Str;

$announcement = $announcement->where('opd_id', $opd?->id)->sortByDesc('published_at')->take(4);
$opdName = $opd->name ?? 'Intansi';
@endphp

<div class="w-full">
    <div class="flex flex-col px-2 md:px-8 lg:px-9 mt-10">
        <div class="bg-white p-2 rounded-xl">
            <p class="flex justify-center text-2xl font-bold text-gray-700 mb-2 pb-2">
                Pengumuman Terbaru
            </p>
            <div class="w-full h-0.5 mx-auto bg-gradient-to-r from-transparent via-blue-500 to-transparent"></div>
        </div>

        @if($announcement->isNotEmpty())

        @php
        $first = $announcement->first();
        // Cek jika gambar ada, jika tidak ada variabel ini akan null
        $firstImage = $first->image ? url('storage/'.$first->image) : null;
        @endphp

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-5 mt-6">
            <div class="lg:col-span-7">
                <div
                    class="relative p-5 rounded-2xl shadow-sm border border-slate-200 bg-white hover:shadow-lg transition h-full flex flex-col">
                    <div
                        class="bg-blue-600 text-white text-xs font-bold uppercase rounded-full w-fit px-4 py-1 absolute ml-2 mt-2 z-10">
                        Penting
                    </div>

                    @if($firstImage)
                    <div class="relative aspect-video overflow-hidden rounded-xl border border-slate-100 mb-4 group">
                        <img src="{{ $firstImage }}" alt="{{ $first->title }}"
                            class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105">
                    </div>
                    @endif

                    <div class="flex flex-col flex-grow">
                        <a href="{{ url('pengumuman/' . $first->slug) }}"
                            class="text-2xl font-extrabold text-slate-800 hover:text-blue-600 transition leading-tight">
                            {{ $first->title }}
                        </a>

                        <p class="text-slate-500 leading-relaxed mt-3 flex-grow">
                            {{ Str::limit(strip_tags($first->deskripsi), 150) }}
                        </p>

                        <div
                            class="flex border-t border-slate-100 mt-5 pt-4 items-center justify-between text-slate-400 text-sm">
                            <div class="flex items-center gap-2">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-blue-500" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                                {{ $first->created_at->translatedFormat('d F Y') }}
                            </div>
                            <span
                                class="text-xs bg-slate-100 px-3 py-1 rounded-full text-slate-600 font-medium">Pengumuman</span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="lg:col-span-5 flex flex-col gap-4">
                <div class="flex items-center gap-3 mb-1">
                    <h3 class="text-lg font-semibold text-slate-700">Lainnya</h3>
                    <div class="flex-grow h-[2px] bg-blue-200 rounded"></div>
                </div>

                @foreach ($announcement->skip(1) as $item)
                @php $itemImage = $item->image ? url('storage/'.$item->image) : null; @endphp

                <a href="/pengumuman/{{ $item->slug }}"
                    class="flex flex-col sm:flex-row gap-4 border border-slate-200 p-4 rounded-xl hover:border-blue-300 bg-white transition group">

                    @if($itemImage)
                    <div class="sm:w-1/3 aspect-video sm:aspect-square overflow-hidden rounded-lg">
                        <img src="{{ $itemImage }}" alt="{{ $item->title }}"
                            class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-110">
                    </div>
                    @endif

                    <div class="{{ $itemImage ? 'sm:w-2/3' : 'w-full' }} flex flex-col justify-between">
                        <div>
                            <h4 class="font-bold text-slate-800 group-hover:text-blue-600 line-clamp-2 transition">
                                {{ $item->title }}
                            </h4>
                            <p class="text-sm text-slate-500 mt-1 line-clamp-2">
                                {{ Str::limit(strip_tags($item->deskripsi), 80) }}
                            </p>
                        </div>
                        <div class="text-[10px] text-slate-400 mt-3 flex items-center gap-2">
                            <span class="text-blue-500 font-bold uppercase">Info</span>
                            <span>•</span>
                            <span>{{ $item->created_at->diffForHumans() }}</span>
                        </div>
                    </div>
                </a>
                @endforeach
            </div>
        </div>

        @else

        <div class="bg-white border border-slate-200 rounded-2xl p-12 text-center shadow-sm mt-6">
            <div class="flex flex-col items-center justify-center gap-4">
                <div class="bg-blue-50 p-4 rounded-full">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 text-blue-400" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z" />
                    </svg>
                </div>
                <div>
                    <h3 class="text-lg font-semibold text-slate-700">Belum Ada Pengumuman</h3>
                    <p class="text-sm text-gray-400 mt-1">Saat ini belum ada pengumuman resmi dari {{ $opdName }}.</p>
                </div>
            </div>
        </div>

        @endif

        <footer class="flex pt-8 pb-10 items-center gap-4">
            <div class="flex-grow border-b border-blue-200"></div>
            <a href="/pengumuman"
                class="inline-flex items-center gap-2 border border-blue-100 px-6 py-2.5 rounded-full bg-blue-600 hover:bg-blue-700 text-white text-sm font-semibold transition shadow-md">
                Lihat Semua
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2"
                    stroke="currentColor" class="size-4">
                    <path stroke-linecap="round" stroke-linejoin="round" d="m4.5 19.5 15-15m0 0H8.25m11.25 0v11.25" />
                </svg>
            </a>
        </footer>
    </div>
</div>