@props(['announcement'])

@php

$opdSlug = env('APP_ID');
$opd = App\Models\Opd::where('slug', $opdSlug)->first();

use Illuminate\Support\Str;

$announcements = $announcement->where('opd_id', $opd?->id)->sortByDesc('created_at')->take(4);
$opdName = $opd->name ?? 'Intansi';
@endphp

<!-- svg -->
<!-- <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10" fill="none" viewBox="0 0 24 24"
    stroke="currentColor">
    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
        d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z" />
</svg> -->

<!-- bg latar -->
<div class="w-full bg-gray-200 py-12">
    <div class="flex flex-col px-4 md:px-8 lg:px-9">

        <div class="flex items-center justify-center mb-8">
            <div class="flex items-center gap-3">
                <div class="text-[#ff6b6b]">
                </div>
                <h2 class="flex justify-center text-3xl font-black text-slate-900">Pengumuman</h2>
                <div class="w-full h-0.5 mx-auto mt-2 bg-gradient-to-r from-transparent via-orange-500 to-transparent">
                </div>
            </div>
            <!-- <a href="/pengumuman"
                class="flex items-center gap-2 px-5 py-2 bg-white border border-blue-400 text-blue-600 rounded-full hover:bg-blue-50 transition font-bold text-sm shadow-sm">
                Lihat Semua
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                </svg>
            </a> -->
        </div>

        @if($announcements->isNotEmpty())
        {{-- Grid 4 kolom sejajar --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
            @foreach ($announcements as $item)
            <div class="group h-full">
                <a href="/pengumuman/{{ $item->slug }}"
                    class="relative flex flex-col p-8 h-full rounded-[2.5rem] shadow-sm border border-slate-100 bg-white hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1 overflow-hidden">

                    <!-- garis aksen
                    <div class="absolute left-0 top-8 bottom-8 w-1.5 bg-blue-500 rounded-r-full"></div> -->

                    <div class="flex-grow">
                        <div class="flex items-center mb-4">
                            <span
                                class="text-[11px] bg-blue-500 text-white font-black uppercase px-3 py-1 rounded-lg tracking-wider">
                                PENGUMUMAN
                            </span>
                        </div>

                        <h4
                            class="text-[1.2rem] font-bold text-slate-800 group-hover:text-blue-600 leading-tight mb-4 transition-colors">
                            {{ $item->title }}
                        </h4>

                        <p class="text-sm text-slate-500 line-clamp-4 leading-relaxed">
                            {{ Str::limit(strip_tags($item->deskripsi), 120) }}
                        </p>
                    </div>

                    <!-- footer -->
                    <div class="mt-6 pt-4 border-t border-slate-50 flex items-center gap-2 text-slate-400">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                        <span class="text-xs font-medium">
                            {{ $item->created_at?->isoFormat('D MMM YYYY') }}
                        </span>
                    </div>
                </a>
            </div>
            @endforeach
        </div>

        @else
        <div class="bg-white border border-slate-200 rounded-[2.5rem] p-12 text-center shadow-sm mt-6">
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

        <!-- footer garis bawah -->
        <div class="mt-12 w-full h-px bg-slate-200"></div>
    </div>
</div>