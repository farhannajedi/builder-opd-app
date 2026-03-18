@php

$opdSlug = env('APP_ID');
$opd = \App\Models\Opd::where('slug', $opdSlug)->first();

$opdConfigs = \App\Models\OpdConfigs::where('opd_id', $opd?->id)->first();

$opdName = $opd?->name ?? 'Dinas Kabupaten Karimun';

// link menuju sosial media opd
$socialMedia = [
[
'url' => $opdConfigs?->facebook_url,
'icon' => 'facebook'
],
[
'url' => $opdConfigs?->instagram_url,
'icon' => 'instagram'
],
[
'url' => $opdConfigs?->tiktok_url,
'icon' => 'tiktok'
],
[
'url' => $opdConfigs?->youtube_url,
'icon' => 'youtube'
],
];

@endphp

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="/favicon.ico" type="image/x-icon">
    <link rel="icon" href="/favicon.ico" type="image/x-icon">
    <link rel="apple-touch-icon" sizes="180x180" href="/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/favicon-16x16.png">
    <title>{{ $title?? 'OPD' }}</title>

    <!-- Memuat semua aset yang didaftarkan di AppServiceProvider -->
    @vite(['resources/css/app.css', 'resources/js/app.js'], '../../web-builder-app')

    <link rel="preconnect" href="https://fonts.googleapis.com">

    <!-- swiper js -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&display=swap"
        rel="stylesheet">
</head>

<body class="min-h-screen flex flex-col">
    <!-- content navbar -->
    <x-navigation.nav :activePage="$activePage" />
    <main class="bg-white flex-1">

        @yield('content')

    </main>
    <footer class="w-full bg-yellow-600 text-yellow-50 pt-9 pb-5 relative overflow-hidden">

        <!-- teks background -->
        <p class="pointer-events-none select-none absolute -left-4 top-2
        text-[170px] font-black tracking-widest leading-none
        bg-gradient-to-t from-yellow-200 via-yellow-800 to-yellow-800 bg-clip-text text-transparent opacity-40">

        </p>
        <p class="pointer-events-none select-none absolute -right-4 bottom-5
        text-[150px] font-black tracking-widest leading-none
        bg-gradient-to-b from-yellow-200 via-yellow-800 to-yellow-800 bg-clip-text text-transparent opacity-40">

        </p>

        <div class="max-w-screen-lg mx-auto px-4 relative z-10">

            <!-- section atas -->
            <div class="flex justify-between items-start gap-10 mb-14">
                <div>
                    <img src="{{ $opdConfigs?->logo ? Storage::url($opdConfigs->logo) : asset('assets/images/logo_kab.png') }}"
                        class="w-24 h-12 object-contain hover:scale-110 duration-200" alt="logo_opd">
                    <p class="text-xl font-semibold text-white drop-shadow">{{ $opdName }}</p>
                    <p class="text-sm text-white-200 drop-shadow">Kabupaten Karimun</p>
                </div>

                <!-- Kontak  -->
                <div class="text-sm space-y-1">
                    <h1 class="text-yellow-200 mb-1 text-xl font-bold">Hubungi Kami</h1>
                    <p>{{ $opdConfigs?->address ?? 'Alamat belum ditambahkan!' }}</p>
                    <p>Email: {{ $opdConfigs?->email ?? '-' }}</p>
                    <p>Telp: {{ $opdConfigs?->phone ?? '-' }}</p>
                </div>

                <!-- Link Sosial Media  -->
                <div class="text-sm space-y-1">
                    <p class="text-yellow-200 mb-1 text-xl font-bold">Media Sosial</p>

                    <div class="flex gap-4 pt-2">

                        @foreach($socialMedia as $socmed)

                        @if(!empty($socmed['url']))
                        <a href="{{ $socmed['url'] }}" target="_blank"
                            class="p-2 border-2 border-yellow-400 hover:bg-yellow-800 hover:text-white duration-200 rounded-lg">

                            @if($socmed['icon'] === 'facebook')
                            <x-icons.facebook class="w-5 h-5" />
                            @elseif($socmed['icon'] === 'instagram')
                            <x-icons.instagram class="w-5 h-5" />
                            @elseif($socmed['icon'] === 'tiktok')
                            <x-icons.tiktok class="w-5 h-5" />
                            @elseif($socmed['icon'] === 'youtube')
                            <x-icons.youtube class="w-5 h-5" />
                            @endif

                        </a>
                        @endif

                        @endforeach

                    </div>
                </div>
            </div>
        </div>
    </footer>

    <!-- Bar Copyright -->
    <div class="w-full bg-yellow-600 shadow py-1">
        <p class="text-sm text-center font-medium text-yellow-800">{{$opdName}} &copy;</p>
    </div>


</body>

</html>