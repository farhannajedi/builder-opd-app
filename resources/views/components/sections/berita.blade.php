@props(['news'])

@php

$opdSlug = env('APP_ID');
$opd = App\Models\Opd::where('slug', $opdSlug)->first();

use Illuminate\Support\Str;

$latestNews = $news->where('opd_id', $opd->id)->sortByDesc('published_at')->take(4);
$opdName = $opd->name ?? 'Instansi';
@endphp

<div class="w-full">
    <div class="flex flex-col px-2 md:px-8 lg:px-9 mt-10">
        <!-- Judul Section -->
        <div class="bg-white p-2 md:p-2 rounded-xl">
            <p class="flex justify-center text-2xl font-bold text-gray-700 mb-2 pb-2">
                Berita Terbaru
            </p>
            <div class="w-full h-0.5 mx-auto bg-gradient-to-r from-transparent via-orange-500 to-transparent"></div>
        </div>

        @if($latestNews->isNotEmpty())

        @php
        $first = $latestNews->first();
        $firstImage = $first?->images
        ? url('storage/'.$first->images)
        : asset('images/default-news.jpg');

        $categoryName = $first->category?->title ?? 'Berita';
        @endphp

        <!-- grid utamanya -->
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-5 mt-6">
            <!-- tampilan berita utama -->
            <div class="lg:col-span-7">
                <div
                    class="relative p-3 rounded-lg shadow-sm border border-slate-300 bg-white hover:shadow-lg transition">
                    <!-- kategori -->
                    <div class="bg-orange-300 text-slate-900 rounded-full w-fit px-4 py-1 absolute ml-5 mt-5 z-10">
                        {{ $categoryName }}
                    </div>
                    <!-- gambar -->
                    <div
                        class="relative aspect-video md:aspect-[16/9] overflow-hidden rounded-xl border border-slate-300 mb-3 group">
                        <img src="{{ $firstImage }}" alt="{{ $first?->title }}"
                            class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105">
                    </div>
                    <!-- judul -->
                    <a href="{{ url('berita/' . $first?->slug) }}"
                        class="text-2xl font-bold text-slate-700 hover:text-orange-600 transition">
                        {{ $first?->title }}
                    </a>
                    <!-- deskripsi -->
                    <p class="text-slate-400 leading-relaxed mt-2">
                        {!! Str::limit($first?->deskripsi, 100) !!}
                    </p>
                    <!-- kolom kategori sejajar -->
                    <ul class="flex border-t border-slate-300 mt-4 pt-3 items-center gap-2 text-slate-400 text-sm">
                        <li>
                            <span class="px-2 py-1 text-xs bg-orange-600 text-white rounded">
                                {{ $categoryName }}
                            </span>
                        </li>

                        <span class="hidden md:block text-slate-500">|</span>

                        <li class="flex items-center gap-2">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                            {{ $first?->published_at?->isoFormat('D MMMM Y') }}
                        </li>
                    </ul>
                </div>
            </div>

            <!-- berita lainnya -->
            <div class="lg:col-span-5 flex flex-col gap-4">

                <!-- Judul Berita Lainnya -->
                <div class="flex items-center gap-3 mb-1">
                    <h3 class="text-lg font-semibold text-slate-700">
                        Berita Terbaru
                    </h3>
                    <div class="flex-grow h-[2px] bg-orange-400 rounded"></div>
                </div>

                @foreach ($latestNews->skip(1)->take(3) as $item)

                @php
                $itemImage = $item->images
                ? url('storage/'.$item->images)
                : asset('images/default-news.jpg');

                $categoryNameItem = $item->category?->title ?? 'Berita';
                @endphp

                <a href="/berita/{{ $item->slug }}"
                    class="flex gap-3 border border-slate-300 shadow-lg p-3 rounded-lg hover:shadow-xl bg-white transition">
                    <!-- gambar -->
                    <div class="w-1/3 aspect-video overflow-hidden rounded-lg border border-slate-400">
                        <img src="{{ $itemImage }}" alt="{{ $item->title }}"
                            class="w-full h-full object-cover transition-transform duration-500 hover:scale-105">
                    </div>
                    <!-- konten -->
                    <div class="w-2/3">
                        <p class="font-bold text-slate-700 hover:text-orange-600 line-clamp-2">
                            {{ $item->title }}
                        </p>
                        <p class="text-sm text-slate-400 mt-2 line-clamp-2">
                            {!! Str::limit($item->deskripsi,80) !!}
                        </p>
                        <div class="flex items-center gap-2 text-xs text-slate-400 mt-3">
                            <span class="px-2 py-1 bg-orange-600 text-white rounded">
                                {{ $categoryNameItem }}
                            </span>
                            <span>|</span>
                            <span class="flex items-center gap-2">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                                {{ $item->published_at?->isoFormat('D MMMM Y') }}
                            </span>
                        </div>
                    </div>
                </a>
                @endforeach
            </div>
        </div>

        @else

        <!-- state jika tidak ada data -->
        <!-- jika web baru digenerate data diweb kosong -->
        <div class="bg-white border border-slate-200 rounded-xl p-10 text-center shadow-sm mt-6">
            <div class="flex flex-col items-center justify-center gap-4">
                <div class="bg-orange-100 p-4 rounded-full">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 text-orange-500" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M19 21H5a2 2 0 01-2-2V7a2 2 0 012-2h4l2-2h2l2 2h4a2 2 0 012 2v12a2 2 0 01-2 2z" />
                    </svg>
                </div>
                <div>
                    <h3 class="text-lg font-semibold text-slate-700">
                        Belum Ada Berita
                    </h3>
                    <p class="text-sm text-gray-500 mt-1">
                        Saat ini belum ada berita yang dipublikasikan oleh {{ $opdName }}.
                    </p>
                </div>
            </div>
        </div>

        @endif

        <!-- berita lainnya -->
        <footer class="flex pt-4 pb-16 items-center gap-4">
            <div class="flex-grow border-b border-yellow-500"></div>
            <a href="/berita"
                class="inline-flex items-center gap-2 border border-slate-200 px-4 py-2 rounded-xl bg-orange-400 hover:bg-orange-700 text-white transition">
                Berita Lainnya
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                    stroke="currentColor" class="size-4">
                    <path stroke-linecap="round" stroke-linejoin="round" d="m4.5 19.5 15-15m0 0H8.25m11.25 0v11.25" />
                </svg>
            </a>
        </footer>
    </div>
</div>