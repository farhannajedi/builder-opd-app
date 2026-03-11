@props(['news'])

<!-- hanya menampilkan jumlah 4 berita terbaru berdasarkan tanggal upload -->
@php
use Illuminate\Support\Str;
$latestNews = $news->sortByDesc('published_at')->take(4);

// ambil nama opd
$opdName = $opd->name ?? 'Instansi';
@endphp

<!-- berita terbaru -->
<div class="w-full">
    <!-- Berita Terbaru -->
    <div class="flex flex-col px-2 md:px-8 lg:px-9 mt-10">
        <div class="bg-white p-6 md:p-8 rounded-xl">
            <p class="flex justify-center text-2xl font-bold text-gray-700 mb-2 pb-2">
                <!-- border-b memberikan garis dibawah teks -->
                Berita Terbaru
            <div class="w-full md:w-l h-0.5 mx-auto bg-gradient-to-r from-transparent via-orange-500 to-transparent">
            </div>
            </p>
        </div>

        @if($latestNews->isNotEmpty())
        <div class="grid grid-cols-1 md:grid-cols-1 lg:grid-cols-12 gap-5 mb-2">
            <!-- Berita Paling Terbaru -->
            @php
            $first = $latestNews->first();
            $firstImage = $first?->images ? url('storage/'.$first->images) : asset('images/default-news.jpg');
            $categoryName = $first->category?->title ?? 'Berita';
            @endphp
            <div
                class="relative col-span-7 lg:row-span-3 p-3 rounded-lg shadow-sm hover:border-primary hover:cursor-pointer transition-all duration-300 hover:shadow-lg border border-slate-300 bg-white">
                <!-- Kategori -->
                <div
                    class="bg-orange-300 text-slate-900 rounded-full w-fit px-4 py-1 font-normal ml-5 mt-5 absolute z-10">
                    {{ $categoryName }}
                </div>

                <!-- Gambar dengan ukuran konsisten -->
                <div class="h-90 md:h-[600px] relative overflow-hidden rounded-2xl mb-3">
                    <div class="absolute inset-0 bg-cover bg-center transition-transform duration-500 group-hover:scale-105"
                        style="background-image: url('{{ $firstImage }}')"></div>
                </div>

                <!-- Konten Berita -->
                <div class="text-sm flex items-center gap-2 text-slate-700 h-fit">
                    <a href="{{ url('berita/' . $first?->slug) }}"
                        class="text-xl font-bold text-slate-600 cursor-pointer hover:text-orange-600">
                        {{ $first?->title }}
                    </a>
                </div>
                <div class="px-1">
                    <p class="text-slate-400 mt-3 pb-3 text-sm font-normal line-clamp-2">
                        {!! Str::limit($first?->deskripsi, 100) !!}
                    </p>
                    <ul class="flex border-t border-slate-300 mt-4 pt-3 items-center gap-2 text-slate-400 text-sm mt-2">
                        <li>
                            <span class="px-2 py-1 text-xs bg-orange-600 text-white rounded">{{ $categoryName }}</span>
                        </li>
                        <span class="hidden md:block text-slate-500">|</span>
                        <li class="flex items-center gap-2">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                            {{ $first?->published_at->isoFormat('D MMMM Y') }}
                        </li>
                    </ul>
                </div>
            </div>

            @else
            <div class="bg-white border border-slate-200 rounded-xl p-10 text-center shadow-sm">
                <div class="flex flex-col items-center justify-center gap-4">
                    <!-- Icon -->
                    <div class="bg-orange-100 p-4 rounded-full">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 text-orange-500" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M19 21H5a2 2 0 01-2-2V7a2 2 0 012-2h4l2-2h2l2 2h4a2 2 0 012 2v12a2 2 0 01-2 2z" />
                        </svg>
                    </div>

                    <!-- Text -->
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

            <!-- 3 Berita Terbaru Lainnya -->
            @forelse ($latestNews->skip(1)->take(3) as $item)
            @php
            $itemImage = url('storage/' . $item->images);
            $categoryNameItem = $item->category?->title ?? 'Berita';
            @endphp
            <a href="/berita/{{ $item->slug }}"
                class="relative col-span-5 flex flex-col shadow-sm h-fit md:flex-row gap-3 border border-slate-300 p-3 rounded-lg hover:border-primary hover:cursor-pointer transition-all duration-300 hover:shadow-xl bg-white">
                <!-- Kategori -->
                <!-- <div
                    class="bg-primary text-white rounded-full w-fit px-4 py-1 font-normal ml-2 mt-2 absolute z-10 text-sm">
                    {{ $categoryNameItem }}
                </div> -->

                <!-- Gambar dengan ukuran konsisten -->
                <div class="relative overflow-hidden rounded-xl border border-slate-400 mb-3 md:mb-0 md:w-1/3">
                    <img src="{{ $itemImage }}" alt="{{ $item->title }}"
                        class="w-full h-48 object-cover transition-transform duration-500 hover:scale-105">
                </div>

                <!-- Konten Berita -->
                <div class="mt-2 md:mt-0 md:pl-3 md:w-2/3">
                    <p class="text-xl font-bold text-slate-600 cursor-pointer hover:text-orange-600">
                        {{ $item->title }}
                    </p>
                    <br>
                    <h5 class="text-slate-400 mt-3 pb-3 text-sm font-normal line-clamp-2">
                        {!! Str::limit($item->deskripsi, 80) !!}
                    </h5>
                    <ul
                        class="flex items-center mt-4 pt-3 border-t border-slate-300 gap-2 text-slate-400 text-sm mt-2 flex">
                        <li>
                            <span
                                class="px-2 py-1 text-xs bg-orange-600 text-white rounded">{{ $categoryNameItem }}</span>
                        </li>
                        <span class="hidden md:block text-slate-500">|</span>
                        <li class="flex items-center gap-2">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                            {{ $item->published_at->isoFormat('D MMMM Y') }}
                        </li>
                    </ul>
                </div>
            </a>
            @empty
            @endforelse

            <!-- link menuju berita lainnya -->
            <footer class="flex pt-4 pb-6 items-center gap-4">
                <div class="flex-grow border-b border-yellow-500"></div>
                <a wire:navigate="" href="/planning-dokumen"
                    class="inline-flex text-medium items-center gap-2 border border-slate-200 px-4 py-2 rounded-xl bg-orange-400 hover:bg-orange-700 text-white transition">
                    Berita Lainnya
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="currentColor" class="size-4">
                        <path stroke-linecap="round" stroke-linejoin="round" d="m4.5 19.5 15-15m0 0H8.25m11.25 0v11.25">
                        </path>
                    </svg>
                </a>
            </footer>
        </div>
    </div>
</div>
<br>