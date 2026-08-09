@props(['announcement'])

@php
use Illuminate\Support\Str;

$opdSlug = env('APP_ID');
$opd = App\Models\Opd::where('slug', $opdSlug)->first();
$opdName = $opd?->name ?? 'Instansi';

// Menggunakan data $announcement yang dikirim dari index.blade.php
$announcements = $announcement;
@endphp

<!-- Container Utama -->
<section class="w-full bg-slate-100/70 py-16 border-y border-slate-200/80">
    <div class="max-w-screen-xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header Pengumuman -->
        <div class="flex flex-col sm:flex-row sm:items-end justify-between mb-10 gap-4">
            <div>
                <div
                    class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-orange-100 border border-orange-200 text-orange-600 text-xs font-bold uppercase tracking-wider mb-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z" />
                    </svg>
                    Informasi Resmi
                </div>
                <h2 class="text-2xl sm:text-3xl font-extrabold text-slate-900 tracking-tight">
                    Pengumuman Terbaru
                </h2>
                <p class="text-xs sm:text-sm text-slate-500 mt-1">
                    Pemberitahuan resmi dan edaran penting dari {{ $opdName }}
                </p>
            </div>

            <!-- Lihat Semua -->
            <a href="/pengumuman"
                class="inline-flex items-center gap-2 px-4 py-2 bg-white border border-slate-300 hover:border-orange-500 text-slate-700 hover:text-orange-600 rounded-full transition-all duration-200 font-bold text-xs shadow-sm hover:shadow-md self-start sm:self-auto">
                <span>Lihat Semua Pengumuman</span>
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                </svg>
            </a>
        </div>

        <!-- Grid Pengumuman -->
        @if($announcements && $announcements->isNotEmpty())
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
            @foreach ($announcements as $item)
            <div class="group h-full">
                <a href="/pengumuman/{{ $item->slug }}"
                    class="relative flex flex-col p-6 h-full rounded-2xl shadow-sm border border-slate-200/80 bg-white hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1 overflow-hidden group-hover:border-orange-200">

                    <div
                        class="absolute top-0 left-0 right-0 h-1 bg-slate-200 group-hover:bg-orange-500 transition-colors duration-300">
                    </div>

                    <div class="flex-grow pt-2">
                        <div class="flex items-center gap-1.5 mb-3">
                            <span
                                class="text-[10px] bg-orange-50 text-orange-600 border border-orange-200 font-bold uppercase px-2.5 py-0.5 rounded-md tracking-wider">
                                PENGUMUMAN
                            </span>
                        </div>

                        <h3
                            class="text-base font-bold text-slate-800 group-hover:text-orange-600 leading-snug mb-3 transition-colors line-clamp-2">
                            {{ $item->title }}
                        </h3>

                        <p class="text-xs text-slate-500 line-clamp-3 leading-relaxed">
                            {{ Str::limit(strip_tags($item->deskripsi), 110) }}
                        </p>
                    </div>

                    <div class="mt-6 pt-3 border-t border-slate-100 flex items-center justify-between text-slate-400">
                        <div class="flex items-center gap-1.5 text-slate-400">
                            <svg xmlns="http://www.w3.org/2000/svg"
                                class="h-3.5 w-3.5 text-slate-400 group-hover:text-orange-500 transition-colors"
                                fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                            <span class="text-[11px] font-medium text-slate-500">
                                {{ $item->created_at?->locale('id')->isoFormat('D MMM YYYY') }}
                            </span>
                        </div>
                        <span
                            class="text-xs font-bold text-orange-500 opacity-0 group-hover:opacity-100 transition-opacity flex items-center gap-0.5">
                            Baca
                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 5l7 7-7 7" />
                            </svg>
                        </span>
                    </div>
                </a>
            </div>
            @endforeach
        </div>
        @else
        <div class="bg-white border border-slate-200/80 rounded-2xl p-10 text-center shadow-sm">
            <div class="flex flex-col items-center justify-center gap-3">
                <div class="bg-orange-50 p-3.5 rounded-full border border-orange-100">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-orange-500" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z" />
                    </svg>
                </div>
                <div>
                    <h3 class="text-base font-bold text-slate-800">Belum Ada Pengumuman</h3>
                    <p class="text-xs text-slate-500 mt-1">Saat ini belum ada pengumuman resmi yang diterbitkan oleh
                        {{ $opdName }}.
                    </p>
                </div>
            </div>
        </div>
        @endif
    </div>
</section>