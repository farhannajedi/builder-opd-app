@props(['news'])

<!-- hanya menampilkan jumlah 4 berita terbaru berdasarkan tanggal upload -->
@php
use Illuminate\Support\Str;
$latestNews = $news->sortByDesc('published_at')->take(4);

// ambil nama opd
$opdName = $latestNews->first()?->opd?->name ?? 'Instansi';
@endphp

<!-- berita terbaru -->
<div class="w-full">
    <!-- Berita Terbaru -->
    <div class="flex flex-col px-4 md:px-10 lg:px-14 mt-10">
        <div class="flex flex-col md:flex-row w-full mb-6">
            <div class="font-bold text-2xl text-slate-700 text-center md:text-left">
                <p>Berita Terbaru</p>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-1 lg:grid-cols-12 gap-5">
            <!-- Berita Paling Terbaru -->
            @php
            $first = $latestNews->first();
            $firstImage = url('storage/' . $first->images);
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
                    <a href="{{ url('berita/' . $first->slug) }}"
                        class="text-xl font-bold text-slate-600 cursor-pointer hover:text-orange-600">
                        {{ $first->title }}
                    </a>
                </div>
                <div class="px-1">
                    <p class="text-slate-400 mt-3 pb-3 text-sm font-normal line-clamp-2">
                        {!! Str::limit($first->deskripsi, 100) !!}
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
                            {{ $first->published_at->isoFormat('D MMMM Y') }}
                        </li>
                    </ul>
                </div>
            </div>

            <!-- 3 Berita Terbaru Lainnya -->
            @foreach ($latestNews->skip(1)->take(3) as $item)
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
                            <span class="px-2 py-1 text-xs bg-orange-600 text-white rounded">{{ $categoryName }}</span>
                        </li>
                        <span class="hidden md:block text-slate-500">|</span>
                        <li class="flex items-center gap-2">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                            {{ $first->published_at->isoFormat('D MMMM Y') }}
                        </li>
                    </ul>
                </div>
            </a>
            @endforeach
        </div>
    </div>
</div>
<br>