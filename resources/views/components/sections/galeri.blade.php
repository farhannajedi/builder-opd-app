@props(['galleries'])

@php
$opdSlug = env('APP_ID');
$opd = App\Models\Opd::where('slug', $opdSlug)->first();

$latestGalleries = $galleries->where('opd_id', $opd?->id)->sortByDesc('published_at')->take(3);
$opdName = $opd?->name ?? 'Instansi';
@endphp

<section class="w-full bg-slate-50/60 py-16 border-b border-slate-200/80">
    <div class="max-w-screen-xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Wrapper Kartu Utama -->
        <div class="bg-white rounded-3xl p-6 sm:p-10 border border-slate-200/80 shadow-sm">
            <!-- Header Galeri -->
            <div
                class="flex flex-col sm:flex-row sm:items-end justify-between mb-10 gap-4 border-b border-slate-100 pb-6">
                <div>
                    <div
                        class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-orange-100 border border-orange-200/80 text-orange-600 text-[11px] font-extrabold uppercase tracking-widest mb-2">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                        Dokumentasi Kegiatan
                    </div>
                    <h2 class="text-2xl sm:text-3xl font-black text-slate-900 tracking-tight">
                        Galeri Foto Resmi
                    </h2>
                    <p class="text-xs sm:text-sm text-slate-500 mt-1">
                        Kumpulan dokumentasi foto program dan kegiatan terbaru dari {{ $opdName }}
                    </p>
                </div>

                <!-- Tombol Selengkapnya -->
                <a href="/galeri" wire:navigate
                    class="hidden sm:inline-flex items-center gap-2 px-5 py-2.5 rounded-full bg-slate-900 hover:bg-orange-500 text-white text-xs font-bold shadow-sm transition-all duration-200 group">
                    <span>Lihat Seluruh Galeri</span>
                    <svg class="w-4 h-4 group-hover:translate-x-1 transition-transform" fill="none"
                        stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M14 5l7 7m0 0l-7 7m7-7H3" />
                    </svg>
                </a>
            </div>

            <!-- Grid Galeri Foto -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                @forelse ($latestGalleries as $gal)
                <div wire:key="gal-{{ $gal->id }}"
                    class="group relative flex flex-col justify-between overflow-hidden rounded-2xl border border-slate-200/80 bg-white hover:border-orange-300 hover:shadow-xl transition-all duration-300">

                    <!-- Gambar -->
                    <div class="relative aspect-[4/3] w-full overflow-hidden bg-slate-900">
                        <!-- Badge Tanggal -->
                        <span
                            class="absolute top-3 right-3 z-10 px-2.5 py-1 bg-slate-900/80 backdrop-blur-md text-white border border-white/20 text-[10px] font-semibold rounded-lg shadow-sm">
                            {{ $gal->created_at?->isoFormat('D MMM YYYY') ?? now()->isoFormat('D MMM YYYY') }}
                        </span>

                        <img src="{{ url('storage/' . $gal->images) }}" alt="{{ $gal->title }}"
                            class="h-full w-full object-cover transition-transform duration-700 group-hover:scale-110">

                        <!-- Gradien -->
                        <div
                            class="absolute inset-0 bg-gradient-to-t from-slate-950/80 via-slate-950/20 to-transparent opacity-60 group-hover:opacity-80 transition-opacity">
                        </div>
                    </div>

                    <!-- Konten Informasi -->
                    <div class="p-5 flex flex-col justify-between flex-grow">
                        <div>
                            <h3
                                class="text-base font-bold text-slate-800 group-hover:text-orange-600 transition-colors leading-snug line-clamp-1 mb-2">
                                {{ $gal->title }}
                            </h3>

                            <p class="text-xs text-slate-500 leading-relaxed line-clamp-2 mb-4">
                                {{ $gal->description }}
                            </p>
                        </div>

                        <!-- Tombol Detail -->
                        <div class="pt-3 border-t border-slate-100">
                            <a href="/galeri/{{ $gal->slug }}"
                                class="inline-flex items-center justify-between w-full px-4 py-2 rounded-xl bg-slate-50 hover:bg-orange-500 text-slate-700 hover:text-white border border-slate-200/80 hover:border-orange-500 text-xs font-bold transition-all duration-200">
                                <span class="flex items-center gap-1.5">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M3 9a2 2 0 012-2h0.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z" />
                                        <circle cx="12" cy="13" r="3" />
                                    </svg>
                                    Lihat Foto
                                </span>
                                <svg class="w-3.5 h-3.5 group-hover:translate-x-0.5 transition-transform" fill="none"
                                    stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M14 5l7 7m0 0l-7 7m7-7H3" />
                                </svg>
                            </a>
                        </div>
                    </div>

                </div>
                @empty
                <!-- Jika Data Galeri Kosong -->
                <div class="col-span-full bg-slate-50 border border-slate-200/80 p-10 text-center rounded-2xl">
                    <div class="flex flex-col items-center justify-center gap-2">
                        <div class="p-3 bg-orange-50 rounded-full text-orange-500 mb-1">
                            <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                        </div>
                        <p class="text-sm font-bold text-slate-700">Belum Ada Foto Dipublikasikan</p>
                        <p class="text-xs text-slate-400">Saat ini belum ada album galeri kegiatan yang diterbitkan oleh
                            {{ $opdName }}.
                        </p>
                    </div>
                </div>
                @endforelse
            </div>

            <!-- Tombol Selengkapnya -->
            <div class="mt-8 pt-4 border-t border-slate-100 flex items-center justify-center sm:hidden">
                <a href="/galeri" wire:navigate
                    class="inline-flex items-center justify-center gap-2 px-6 py-3 rounded-xl bg-orange-500 text-white font-bold text-xs shadow-md shadow-orange-500/20 w-full">
                    <span>Lihat Seluruh Galeri Foto</span>
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M14 5l7 7m0 0l-7 7m7-7H3" />
                    </svg>
                </a>
            </div>
        </div>
    </div>
</section>