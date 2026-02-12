@php
// Ambil data Hero Section yang aktif
// Sesuaikan logika pengambilan ID (bisa dari env atau database)
$hero = \App\Models\HeroSection::with(['banners'])
->where('is_active', true)
->latest('published_at')
->first();
@endphp

@if($hero)
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />

<section class="relative w-full h-screen overflow-hidden bg-slate-900">
    <div class="swiper heroSwiper w-full h-full">
        <div class="swiper-wrapper">
            @foreach($hero->banners as $banner)
            <div class="swiper-slide relative overflow-hidden">
                <img src="{{ asset('storage/' . $banner->image_path) }}"
                    class="absolute inset-0 w-full h-full object-cover transform scale-110 transition-transform duration-[5000ms] ease-out slide-image"
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

                <div class="flex-none lg:pl-12 border-t-4 lg:border-t-0 lg:border-l-4 border-orange-600 pt-6 lg:pt-2">
                    <div
                        class="grid gap-3 text-3xl lg:text-5xl font-bold text-slate-100 italic tracking-tighter uppercase">
                        @php $slogans = explode('|', $hero->subtitle); @endphp
                        @foreach($slogans as $slogan)
                        <p class="whitespace-nowrap drop-shadow-md">{{ trim($slogan) }}</p>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
        <div class="swiper-pagination !bottom-10 !z-30"></div>
    </div>
</section>

<script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    var swiper = new Swiper(".heroSwiper", {
        effect: "fade",
        fadeEffect: {
            crossFade: true
        },
        loop: true,
        speed: 2000,
        autoplay: {
            delay: 5000,
            disableOnInteraction: false
        },
        pagination: {
            el: ".swiper-pagination",
            clickable: true
        },
        on: {
            slideChangeTransitionStart: function() {
                const images = document.querySelectorAll('.slide-image');
                images.forEach(img => img.classList.remove('scale-100'));
            },
            slideChangeTransitionEnd: function() {
                const activeSlideImg = document.querySelector('.swiper-slide-active .slide-image');
                if (activeSlideImg) activeSlideImg.classList.add('scale-100');
            }
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