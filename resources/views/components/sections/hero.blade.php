@php
// Ambil data Hero Section yang aktif
// Sesuaikan logika pengambilan ID (bisa dari env atau database)
$hero = \App\Models\HeroSection::with(['banners'])->where('is_active', true)->latest('published_at')->first();
@endphp

<style>
    h1 span {
        display: inline-block;
        filter: drop-shadow(0 10px 15px rgba(0, 0, 0, 0.5));
    }

    /* agar teks tidak terpotong saat layar sangat kecil */
    @media (max-width: 640px) {
        h1 {
            letter-spacing: -0.05em !important;
            /* untuk merapatkan sedikit di mobile */
        }
    }
</style>

@if($hero)
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />

<section class="relative w-full h-screen overflow-hidden bg-slate-900">
    <div class="swiper heroSwiper w-full h-full">
        <div class="swiper-wrapper">
            @foreach($hero->banners as $banner)
            <div class="swiper-slide relative overflow-hidden">
                <img src="{{ asset('storage/' . $banner->image_path) }}" class="w-full h-full object-cover slide-image"
                    alt="Banner">
                <div class="absolute inset-0 bg-black/40 z-10"></div>
            </div>
            @endforeach
        </div>

        <div class="absolute inset-0 z-20 flex items-center justify-center">
            <div class="container mx-auto px-6 flex flex-col items-center text-center w-full max-w-7xl">
                <div class="w-full mb-4 lg:mb-6">
                    <h1 class="w-full text-[10vw] lg:text-[7rem] font-black tracking-normal
                        lg:tracking-widest leading-none flex justify-between text-white uppercase select-none
                        drop-shadow-2xl">
                        @if($hero->letters)
                        @foreach($hero->letters as $letter)
                        <span
                            class="hover:text-orange-500 transition-all duration-300 transform hover:scale-110 cursor-default">{{ $letter }}</span>
                        @endforeach
                        @else
                        {{ $hero->title }}
                        @endif
                    </h1>
                </div>

                <!--  -->
                <div
                    class="w-full h-1 lg:h-1.5 bg-gradient-to-r from-transparent via-orange-600 to-transparent mb-6 lg:mb-8 shadow-lg">
                </div>

                <div class="flex flex-col gap-2 md:gap-4">
                    @php $slogans = explode('|', $hero->subtitle); @endphp
                    @foreach($slogans as $slogan)
                    <p
                        class="text-2xl md:text-4xl lg:text-5xl font-bold text-slate-100 uppercase tracking-widest drop-shadow-lg italic">
                        {{ trim($slogan) }}
                    </p>
                    @endforeach
                </div>
            </div>
        </div>
        <div class="swiper-pagination !bottom-10 !z-30"></div>
    </div>
</section>

<script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
<!-- window.swiper, mengartikan bahwa menggunakan swiper dengan global cdn -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
        var swiper = new window.Swiper(".heroSwiper", {
            effect: "fade",
            fadeEffect: {
                crossFade: true
            },
            loop: false,
            speed: 2000,
            autoplay: {
                delay: 5000,
                disableOnInteraction: false
            },
            pagination: {
                el: ".swiper-pagination",
                clickable: true
            }
        });
    });
</script>

<style>
    h1 span {
        display: inline-block;
    }

    .swiper-pagination-bullet-active {
        background: #ea580c !important;
        width: 30px !important;
        border-radius: 5px !important;
    }
</style>
@endif