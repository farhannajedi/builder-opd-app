@php
$opdSlug = env('APP_ID');
$opd = App\Models\Opd::where('slug', $opdSlug)->first();

$hero = App\Models\HeroSection::where('opd_id', $opd?->id)->with('banners')->where('is_active',
true)->latest('published_at')->first();

$opdName = $opd->name ?? 'Instansi Pemerintah';
@endphp

<!-- CSS Swiper -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />

<!-- Kustomisasi Warna Paginasi -->
<style>
.heroSwiper .swiper-pagination-bullet {
    background: #ffffff;
    opacity: 0.6;
    width: 10px;
    height: 10px;
    transition: all 0.3s ease;
}

.heroSwiper .swiper-pagination-bullet-active {
    background: var(--color-primary) !important;
    opacity: 1;
    width: 28px;
    border-radius: 9999px;
}
</style>

<section class="relative w-full overflow-hidden bg-slate-950">

    @if($hero && $hero->banners->count() > 0)
    <div class="swiper heroSwiper w-full h-[400px] sm:h-[500px] lg:h-[600px]">
        <div class="swiper-wrapper">
            @foreach($hero->banners as $banner)
            <div class="swiper-slide relative w-full h-full">
                <!-- Gambar Banner -->
                <img src="{{ asset('storage/' . $banner->image_path) }}"
                    class="w-full h-full object-cover object-center" alt="Hero Banner {{ $loop->iteration }}">

                <!-- Overlay Gradien -->
                <div class="absolute inset-0 bg-gradient-to-t from-slate-950 via-slate-950/30 to-transparent"></div>

                <!-- (Opsional) Teks Judul di atas Banner -->
                <div class="absolute inset-0 flex items-center justify-center text-center p-6 z-10">
                    <div class="max-w-4xl space-y-4">
                        <!-- Badge Kategori/Instansi -->
                        <div
                            class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full bg-white/10 backdrop-blur-md border border-white/20 text-white text-xs sm:text-sm font-semibold tracking-wide uppercase shadow-lg">
                            <span class="w-2 h-2 rounded-full bg-emerald-400 animate-pulse"></span>
                            Portal Resmi • {{ $opdName }}
                        </div>

                        <!-- Judul Utama -->
                        <h2
                            class="text-3xl sm:text-5xl lg:text-6xl font-extrabold text-white tracking-tight drop-shadow-md leading-tight">
                            {{ $hero->title }}
                        </h2>

                        <!-- Subtitle / Slogan -->
                        @if($hero->subtitle)
                        <p class="text-sm sm:text-lg text-slate-200 max-w-2xl mx-auto font-medium drop-shadow">
                            {{ $hero->subtitle }}
                        </p>
                        @endif
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        <!-- Tombol Navigasi Swiper -->
        <div
            class="swiper-button-prev !hidden sm:!flex !w-12 !h-12 !bg-slate-900/60 backdrop-blur-md !text-white rounded-full after:!text-lg hover:!bg-brand-500 transition-all border border-white/10 !left-6">
        </div>
        <div
            class="swiper-button-next !hidden sm:!flex !w-12 !h-12 !bg-slate-900/60 backdrop-blur-md !text-white rounded-full after:!text-lg hover:!bg-brand-500 transition-all border border-white/10 !right-6">
        </div>
        <div class="swiper-pagination !bottom-6"></div>
    </div>

    @elseif($hero)
    <div class="relative py-24 lg:py-32 bg-slate-950 border-b border-slate-800/80 overflow-hidden">
        <!-- Aksen Background Blur -->
        <div
            class="absolute -top-24 left-1/2 -translate-x-1/2 w-96 h-96 bg-brand-500/10 rounded-full blur-3xl pointer-events-none">
        </div>

        <div class="max-w-screen-lg mx-auto px-6 text-center relative z-10">
            <!-- Badge Identitas Resmi -->
            <div
                class="inline-flex items-center gap-2 px-3 py-1.5 rounded-full bg-slate-900 border border-slate-800 text-brand-400 text-xs font-semibold uppercase tracking-widest mb-6 shadow-inner">
                <span class="w-2 h-2 rounded-full bg-brand-500 animate-pulse"></span>
                Portal Resmi Informasi
            </div>

            <h1
                class="text-3xl sm:text-5xl lg:text-6xl font-black uppercase tracking-tight text-white drop-shadow-md leading-tight">
                {{ $hero->title }}
            </h1>

            <div
                class="w-24 h-1.5 bg-gradient-to-r from-brand-500 to-amber-400 mx-auto my-6 rounded-full shadow-lg shadow-brand-500/30">
            </div>

            @php
            $slogans = explode('|', $hero->subtitle);
            @endphp

            <div class="space-y-2 max-w-2xl mx-auto">
                @foreach($slogans as $slogan)
                <p class="text-base sm:text-xl font-medium text-slate-300 italic">
                    "{{ trim($slogan) }}"
                </p>
                @endforeach
            </div>
        </div>
    </div>

    @else
    <div class="relative py-24 lg:py-32 bg-slate-950 border-b border-slate-800/80 overflow-hidden">
        <div
            class="absolute -top-24 left-1/2 -translate-x-1/2 w-96 h-96 bg-brand-500/10 rounded-full blur-3xl pointer-events-none">
        </div>

        <div class="max-w-screen-lg mx-auto px-6 text-center relative z-10">
            <div
                class="inline-flex items-center gap-2 px-3 py-1.5 rounded-full bg-slate-900 border border-slate-800 text-brand-400 text-xs font-semibold uppercase tracking-widest mb-6">
                <span class="w-2 h-2 rounded-full bg-emerald-500"></span>
                Website Publik
            </div>

            <h1 class="text-4xl sm:text-6xl font-black uppercase tracking-tight text-white drop-shadow-md">
                Selamat Datang
            </h1>

            <div
                class="w-24 h-1.5 bg-gradient-to-r from-brand-400 to-brand-600 mx-auto my-6 rounded-full shadow-lg shadow-brand-500/30">
            </div>

            <p class="text-lg sm:text-2xl font-medium text-slate-300 italic max-w-xl mx-auto">
                Website Resmi <span class="text-white font-semibold">{{ $opdName }}</span>
            </p>
        </div>
    </div>
    @endif

</section>

<!-- Swiper Untuk Javascript -->
@if($hero && $hero->banners->count() > 0)
<script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>

<script>
document.addEventListener('DOMContentLoaded', function() {
    new window.Swiper(".heroSwiper", {
        loop: true,
        speed: 1000,
        autoplay: {
            delay: 4500,
            disableOnInteraction: false
        },
        pagination: {
            el: ".swiper-pagination",
            clickable: true
        },
        navigation: {
            nextEl: ".swiper-button-next",
            prevEl: ".swiper-button-prev",
        },
    });
});
</script>
@endif