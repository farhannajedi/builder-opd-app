@php
// Ambil data Hero Section yang aktif
// Sesuaikan logika pengambilan ID (bisa dari env atau database)
$hero = \App\Models\HeroSection::with(['banners'])->where('is_active', true)->latest('published_at')->first();
@endphp

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

        <div class="absolute inset-0 z-20 flex items-center">
            <div class="container mx-auto px-6 flex flex-col lg:flex-row items-center justify-between gap-12 w-full">
                <div class="w-full lg:flex-1">
                    <h1
                        class="w-full text-[14vw] lg:text-[9rem] font-black tracking-widest leading-none flex justify-between text-white uppercase select-none drop-shadow-2xl">
                        @if($hero->letters)
                        @foreach($hero->letters as $letter)
                        <span class="hover:text-orange-500 transition-colors duration-300">{{ $letter }}</span>
                        @endforeach
                        @else
                        {{ $hero->title }}
                        @endif
                    </h1>
                </div>

                <div
                    class="pl-0 lg:pl-8 flex-0 text-4xl grid gap-2 font-medium text-slate-100 border-t-2 lg:border-t-0 border-l-0 lg:border-l-2 border-orange-600 pt-4 lg:pt-0">
                    @php $slogans = explode('|', $hero->subtitle); @endphp
                    @foreach($slogans as $slogan)
                    <p class="whitespace-nowrap drop-shadow-md">{{ trim($slogan) }}</p>
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