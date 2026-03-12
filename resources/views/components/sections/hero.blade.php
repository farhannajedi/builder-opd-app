@php

$opdSlug = env('APP_ID');
$opd = App\Models\Opd::where('slug', $opdSlug)->first();

$hero = App\Models\HeroSection::where('opd_id', $opd?->id)->with('banners')->where('is_active',
true)->latest('published_at')->first();

$opdName = $opd->name ?? 'Instansi';

@endphp

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />

<section class="relative w-full overflow-hidden bg-slate-900">
    <!-- jika web child punya hero banner -->
    @if($hero && $hero->banners->count() > 0)
    <div class="swiper heroSwiper w-full">
        <div class="swiper-wrapper">
            @foreach($hero->banners as $banner)

            <div class="swiper-slide">
                <img src="{{ asset('storage/' . $banner->image_path) }}" class="w-full h-auto" alt="Banner">
            </div>

            @endforeach

        </div>
        <div class="swiper-pagination"></div>
    </div>

    <!-- jika ada heronya, tapi gambarnya tidak ada -->

    @elseif($hero)
    <div class="flex items-center justify-center py-32">
        <div class="text-center text-white px-6">
            <h1 class="text-4xl md:text-6xl font-black uppercase drop-shadow-lg">
                {{ $hero->title }}
            </h1>
            <div class="w-32 h-1 bg-orange-500 mx-auto my-4"></div>

            @php
            $slogans = explode('|', $hero->subtitle);
            @endphp

            @foreach($slogans as $slogan)

            <p class="text-lg md:text-2xl font-semibold italic drop-shadow">
                {{ trim($slogan) }}
            </p>

            @endforeach

        </div>
    </div>

    <!-- jika tidak ada data hero -->
    @else
    <div class="flex items-center justify-center py-32">
        <div class="text-center text-white px-6">
            <h1 class="text-4xl md:text-6xl font-black uppercase">
                Selamat Datang
            </h1>
            <div class="w-32 h-1 bg-orange-500 mx-auto my-4"></div>
            <p class="text-lg md:text-2xl italic">
                Website Resmi {{ $opdName }}
            </p>
        </div>
    </div>

    @endif

</section>

@if($hero && $hero->banners->count() > 0)

<script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>

<script>
    document.addEventListener('DOMContentLoaded', function() {

        new window.Swiper(".heroSwiper", {

            loop: true,
            speed: 1000,

            autoplay: {
                delay: 4000,
                disableOnInteraction: false
            },

            pagination: {
                el: ".swiper-pagination",
                clickable: true
            }

        });

    });
</script>

@endif