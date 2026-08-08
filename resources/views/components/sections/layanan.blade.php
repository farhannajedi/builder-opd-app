@props(['services'])

@php
$opdSlug = env('APP_ID');
$opd = App\Models\Opd::where('slug', $opdSlug)->first();

$latestServices = $services->take(4);
$opdName = $opd?->name ?? 'Instansi';
@endphp

<section class="w-full bg-slate-50/60 py-16 border-b border-slate-200/80">
    <div class="max-w-screen-xl mx-auto px-4 sm:px-6 lg:px-8">

        <!-- Wrapper Kartu Utama -->
        <div class="bg-white rounded-3xl p-6 sm:p-10 border border-slate-200/80 shadow-sm">
            <!-- Header Seksi Layanan -->
            <div
                class="flex flex-col sm:flex-row sm:items-end justify-between mb-10 gap-4 border-b border-slate-100 pb-6">
                <div>
                    <div
                        class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-orange-100 border border-orange-200/80 text-orange-600 text-[11px] font-extrabold uppercase tracking-widest mb-2">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                        </svg>
                        Layanan {{ $opdName }}
                    </div>
                    <h2 class="text-2xl sm:text-3xl font-black text-slate-900 tracking-tight">
                        Layanan Publik
                    </h2>
                    <p class="text-xs sm:text-sm text-slate-500 mt-1">
                        Portal akses fasilitas dan layanan digital resmi dari {{ $opdName }}
                    </p>
                </div>

                <!-- Tombol Selengkapnya (Desktop Header) -->
                <a href="/layanan" wire:navigate
                    class="hidden sm:inline-flex items-center gap-2 px-5 py-2.5 rounded-full bg-slate-900 hover:bg-orange-500 text-white text-xs font-bold shadow-sm transition-all duration-200 group">
                    <span>Lihat Semua Layanan</span>
                    <svg class="w-4 h-4 group-hover:translate-x-1 transition-transform" fill="none"
                        stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M14 5l7 7m0 0l-7 7m7-7H3" />
                    </svg>
                </a>
            </div>

            <!-- Grid Kartu Layanan (4 Kolom Simetris) -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                @forelse($latestServices as $service)
                <div
                    class="group relative flex flex-col justify-between p-6 bg-white rounded-2xl border border-slate-200/80 hover:border-orange-300 hover:shadow-xl transition-all duration-300">

                    <div>
                        <!-- Ikon Layanan -->
                        <div
                            class="mb-5 inline-flex p-3.5 bg-orange-50 text-orange-600 border border-orange-100 rounded-2xl group-hover:bg-orange-500 group-hover:text-white group-hover:border-orange-500 transition-colors duration-300 shadow-sm">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9.75 17L9 20l-1 1h6l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                            </svg>
                        </div>

                        <!-- Nama Layanan -->
                        <h3
                            class="text-base sm:text-lg font-bold text-slate-800 group-hover:text-orange-600 transition-colors leading-snug line-clamp-2 mb-2">
                            {{ $service->name }}
                        </h3>

                        <!-- Deskripsi Singkat -->
                        <p class="text-xs text-slate-500 leading-relaxed line-clamp-3 mb-6">
                            {{ $service->description }}
                        </p>
                    </div>

                    <!-- Tombol Aksi Kapsul -->
                    <div class="pt-4 border-t border-slate-100">
                        <a href="/layanan/{{ $service->id }}"
                            class="w-full inline-flex items-center justify-center gap-1.5 px-4 py-2.5 rounded-xl bg-slate-50 hover:bg-orange-500 text-slate-700 hover:text-white border border-slate-200/80 hover:border-orange-500 text-xs font-bold transition-all duration-200 shadow-sm">
                            <span>Akses Layanan</span>
                            <svg class="w-3.5 h-3.5 group-hover:translate-x-0.5 transition-transform" fill="none"
                                stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M14 5l7 7m0 0l-7 7m7-7H3" />
                            </svg>
                        </a>
                    </div>
                </div>
                @empty
                <!-- Jika Data Kosong -->
                <div class="col-span-full bg-slate-50 border border-slate-200/80 p-10 text-center rounded-2xl">
                    <div class="flex flex-col items-center justify-center gap-2">
                        <div class="p-3 bg-orange-50 rounded-full text-orange-500 mb-1">
                            <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                            </svg>
                        </div>
                        <p class="text-sm font-bold text-slate-700">Belum Ada Layanan Tersedia</p>
                        <p class="text-xs text-slate-400">Saat ini belum ada aplikasi atau fasilitas layanan publik yang
                            terdaftar dari {{ $opdName }}.</p>
                    </div>
                </div>
                @endforelse
            </div>

            <!-- Tombol Selengkapnya -->
            <div class="mt-8 pt-4 border-t border-slate-100 flex items-center justify-center sm:hidden">
                <a href="/layanan" wire:navigate
                    class="inline-flex items-center justify-center gap-2 px-6 py-3 rounded-xl bg-orange-500 text-white font-bold text-xs shadow-md shadow-orange-500/20 w-full">
                    <span>Lihat Seluruh Layanan</span>
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M14 5l7 7m0 0l-7 7m7-7H3" />
                    </svg>
                </a>
            </div>
        </div>
    </div>
</section>