@props(['news'])

@php
$opdSlug = env('APP_ID');
$opd = App\Models\Opd::where('slug', $opdSlug)->first();

// Mengambil 5 berita terbaru (1 berita utama + 4 berita sampingan)
$latestNews = $news->where('opd_id', $opd?->id)->sortByDesc('published_at')->take(5);
$opdName = $opd->name ?? 'Instansi';
@endphp

<section class="w-full bg-slate-50/60 py-16">
    <div class="max-w-screen-xl mx-auto px-4 sm:px-6 lg:px-8">

        <!-- Berita Utama -->
        <div class="flex flex-col sm:flex-row sm:items-end justify-between mb-10 gap-4">
            <div class="space-y-1">
                <div
                    class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-orange-100 border border-orange-200/80 text-orange-600 text-[11px] font-extrabold uppercase tracking-widest">
                    <span class="w-2 h-2 rounded-full bg-orange-500 animate-pulse"></span>
                    Kabar Terkini
                </div>
                <h2 class="text-2xl sm:text-3xl lg:text-4xl font-black text-slate-900 tracking-tight">
                    Berita & Informasi Publik
                </h2>
                <p class="text-xs sm:text-sm text-slate-500">
                    Sajian berita terbaru seputar kegiatan dan kebijakan {{ $opdName }}
                </p>
            </div>

            <!-- Tombol Lihat Semua Berita -->
            <a href="/berita"
                class="hidden sm:inline-flex items-center gap-2 px-5 py-2.5 rounded-full bg-white border border-slate-200 hover:border-orange-500 text-slate-700 hover:text-orange-600 text-xs font-bold shadow-sm hover:shadow-md transition-all duration-200 group">
                <span>Lihat Semua Berita</span>
                <svg class="w-4 h-4 text-slate-400 group-hover:text-orange-600 group-hover:translate-x-1 transition-all"
                    fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M14 5l7 7m0 0l-7 7m7-7H3" />
                </svg>
            </a>
        </div>

        @if($latestNews->isNotEmpty())
        @php
        $first = $latestNews->first();
        $firstImage = $first?->images ? url('storage/'.$first->images) : asset('images/default-news.jpg');
        $categoryName = $first?->category?->title ?? 'Informasi Terkini';
        @endphp

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">

            <!-- berita utama -->
            <div class="lg:col-span-7">
                <div
                    class="group relative bg-white rounded-[2rem] border border-slate-200/80 p-4 sm:p-6 shadow-sm hover:shadow-xl transition-all duration-300 overflow-hidden h-full flex flex-col justify-between">

                    <div class="grid grid-cols-1 gap-6">
                        <!-- Foto Berita Utama -->
                        <div
                            class="relative aspect-[16/9] w-full overflow-hidden rounded-[1.5rem] bg-slate-100 shadow-inner">
                            <img src="{{ $firstImage }}" alt="{{ $first?->title }}"
                                class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-105">
                            <div
                                class="absolute inset-0 bg-slate-900/10 group-hover:bg-transparent transition-colors duration-300">
                            </div>
                        </div>

                        <!-- Detail Konten Berita Utama -->
                        <div class="flex flex-col justify-between py-1 px-1 sm:px-2 space-y-4">
                            <div>
                                <!-- badge kategori berita -->
                                @if($first?->category)
                                <a href="{{ url('berita/kategori/' . $first->category->slug) }}"
                                    class="inline-flex items-center gap-1.5 px-3.5 py-1 rounded-full bg-rose-50 text-rose-600 border border-rose-100 text-xs font-bold mb-3 hover:bg-rose-500 hover:text-white hover:border-rose-500 transition-all duration-200">
                                    <span class="w-1.5 h-1.5 rounded-full bg-rose-500 group-hover:bg-white"></span>
                                    {{ $categoryName }}
                                </a>
                                @else
                                <div
                                    class="inline-flex items-center gap-1.5 px-3.5 py-1 rounded-full bg-rose-50 text-rose-600 border border-rose-100 text-xs font-bold mb-3">
                                    <span class="w-1.5 h-1.5 rounded-full bg-rose-500"></span>>
                                    {{ $categoryName }}
                                </div>
                                @endif

                                <!-- Judul Berita Utama -->
                                <a href="{{ url('berita/' . $first?->slug) }}" class="block group/title">
                                    <h3
                                        class="text-xl sm:text-2xl lg:text-3xl font-bold text-slate-800 group-hover/title:text-sky-600 transition-colors leading-snug tracking-tight mb-3 line-clamp-2">
                                        {{ $first?->title }}
                                    </h3>
                                </a>

                                <!-- Deskripsi Singkat -->
                                <p class="text-xs sm:text-sm text-slate-600 leading-relaxed line-clamp-3 font-normal">
                                    {{ strip_tags($first?->deskripsi) }}
                                </p>
                            </div>

                            <!-- Author & Tanggal Rilis -->
                            <div
                                class="pt-4 border-t border-slate-100 flex items-center gap-4 text-xs font-semibold text-slate-500">
                                <div class="flex items-center gap-2">
                                    <div
                                        class="w-7 h-7 rounded-full bg-slate-200 flex items-center justify-center text-slate-500 font-bold">
                                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd"
                                                d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z"
                                                clip-rule="evenodd" />
                                        </svg>
                                    </div>
                                    <span class="text-slate-700 font-bold">{{ $first?->opd?->name ?? 'Admin' }}</span>
                                </div>

                                <span class="text-sky-400">•</span>

                                <div class="flex items-center gap-1.5 text-slate-600">
                                    <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                    </svg>
                                    <span>{{ $first?->published_at?->locale('id')->isoFormat('D MMMM YYYY') ?? now()->locale('id')->isoFormat('D MMMM YYYY') }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Daftar Berita Lainnya -->
            @if($latestNews->count() > 1)
            <div class="lg:col-span-5">
                <div class="bg-white rounded-[2rem] border border-slate-200/80 p-6 shadow-sm">

                    <!-- Header Widget Berita Terkini -->
                    <div class="flex items-center gap-3 mb-6">
                        <h3 class="text-xl font-bold text-slate-800 tracking-tight">Berita Terkini</h3>
                        <div class="flex-grow flex items-center">
                            <span class="w-2.5 h-2.5 rounded-full bg-sky-400 shrink-0"></span>
                            <div class="h-[1px] w-full bg-slate-200"></div>
                        </div>
                    </div>

                    <!-- Daftar Berita -->
                    <div class="divide-y divide-slate-100">
                        @foreach ($latestNews->skip(1)->take(4) as $item)
                        <a href="/berita/{{ $item->slug }}"
                            class="group block py-4 first:pt-0 last:pb-0 transition-colors">
                            <h4
                                class="text-sm font-bold text-slate-800 group-hover:text-sky-600 leading-snug line-clamp-2 transition-colors mb-2">
                                {{ $item->title }}
                            </h4>

                            <!-- Deskripsi Singkat -->
                            <p class="text-xs sm:text-sm text-slate-600 leading-relaxed line-clamp-3 font-normal">
                                {{ strip_tags($item?->deskripsi) }}
                            </p>

                            <div class="flex items-center gap-1.5 text-xs text-slate-400 font-medium">
                                <svg class="w-3.5 h-3.5 text-slate-400" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                <span>{{ $item->published_at?->locale('id')->isoFormat('D MMMM YYYY') ?? now()->locale('id')->isoFormat('D MMMM YYYY') }}</span>

                                <div
                                    class="flex items-center gap-1.5 px-3.5 py-1 rounded-full bg-rose-50 text-rose-600 border border-rose-100 text-xs -bold hover:bg-rose-500 hover:text-white hover:border-rose-500 transition-all duration-200">
                                    <span class="w-1.5 h-1.5 rounded-full bg-rose-500 group-hover:bg-white"></span>
                                    {{ $categoryName }}
                                </div>
                            </div>
                        </a>
                    </div>
                    </a>
                    @endforeach
                </div>
            </div>
        </div>
        @endif
    </div>

    <!-- Apabila Berita Kosong -->
    @else
    <div class="bg-white border border-slate-200/80 rounded-2xl p-12 text-center shadow-sm">
        <div class="flex flex-col items-center justify-center gap-3">
            <div class="bg-orange-50 p-4 rounded-full border border-orange-100">
                <svg class="h-8 w-8 text-orange-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z" />
                </svg>
            </div>
            <div>
                <h3 class="text-base font-bold text-slate-800">Belum Ada Berita Diterbitkan</h3>
                <p class="text-xs text-slate-500 mt-1">Saat ini belum ada artikel berita yang dipublikasikan oleh
                    {{ $opdName }}.
                </p>
            </div>
        </div>
    </div>
    @endif

    <!-- Tombol Selengkapnya -->
    <div class="mt-8 flex items-center justify-center sm:hidden">
        <a href="/berita"
            class="inline-flex items-center gap-2 px-6 py-3 rounded-xl bg-orange-500 hover:bg-orange-600 text-white font-extrabold text-xs shadow-lg shadow-orange-500/20 transition-all w-full justify-center">
            <span>Lihat Seluruh Berita</span>
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" />
            </svg>
        </a>
    </div>
    </div>
</section>