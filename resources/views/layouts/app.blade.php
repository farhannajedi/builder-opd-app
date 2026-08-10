@php
$opdSlug = env('APP_ID');
$opd = \App\Models\Opd::where('slug', $opdSlug)->first();

$opdConfigs = \App\Models\OpdConfigs::where('opd_id', $opd?->id)->first();

$opdName = $opd?->name ?? 'Dinas Kabupaten Karimun';

// Ambil konfigurasi warna milik OPD ini dari database
$config = App\Models\OpdConfigs::where('opd_id', $opd?->id)->first();

// Set warna utama (jika belum diisi, fallback ke oren)
$primaryColor = $config?->primary_color ?? '#f97316';

// Link sosial media OPD
$socialMedia = [
[
'url' => $opdConfigs?->facebook_url,
'icon' => 'facebook',
'name' => 'Facebook'
],

[
'url' => $opdConfigs?->instagram_url,
'icon' => 'instagram',
'name' => 'Instagram'
],

[
'url' => $opdConfigs?->tiktok_url,
'icon' => 'tiktok',
'name' => 'TikTok'
],

[
'url' => $opdConfigs?->youtube_url,
'icon' => 'youtube',
'name' => 'YouTube'
],

];
@endphp

<!DOCTYPE html>
<html lang="id" class="scroll-smooth">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="/favicon.ico" type="image/x-icon">
    <link rel="icon" href="/favicon.ico" type="image/x-icon">
    <link rel="apple-touch-icon" sizes="180x180" href="/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/favicon-16x16.png">
    <title>{{ $title ?? 'Website Resmi ' . $opdName }}</title>

    <!-- memuat semua aset yang didaftarkan di AppServiceProvider / Vite -->
    @vite(['resources/css/app.css', 'resources/js/app.js'], 'web-builder-app')

    <!-- Fonts Google -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap"
        rel="stylesheet">

    <!-- Swiper JS CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />

    <!-- Injeksi CSS Variables (Ditulis dalam 1 baris agar tidak corrupt) -->
    <style>
        :root {
            --color-primary: {
                    {
                    $primaryColor
                }
            }

            ;
        }

        body {
            font-family: 'Inter', sans-serif;
        }

        [x-cloak] {
            display: none !important;
        }
    </style>

</head>

<body class="min-h-screen flex flex-col bg-brand text-brand antialiased selection:bg-brand selection:text-white">

    <!--navbar-->
    <x-navigation.nav :activePage="$activePage ?? ''" />
    <!--content-->
    <main class="bg-white flex-1 w-full">
        @yield('content')
    </main>
    <!-- Footer Utama Portal Pemerintahan -->
    <footer
        class="w-full bg-slate-900 text-slate-300 pt-12 pb-8 relative overflow-hidden border-t-4 border-brand shadow-lg">
        <div
            class="pointer-events-none select-none absolute -right-2 -bottom-2 text-[120px] font-black tracking-widest text-slate-800/40 uppercase leading-none hidden lg:block">
            KARIMUN
        </div>

        <div class="max-w-screen-lg mx-auto px-4 sm:px-6 relative z-10">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8 lg:gap-12 pb-10">

                <!--identitas instansi dan logo-->
                <div class="space-y-4">
                    <div class="flex items-center gapp-3">
                        <img src="{{ $opdConfigs?->logo ? Storage::url($opdConfigs->logo) : asset('assets/images/logo_kab.png') }}"
                            class="w-16 h-10 object-contain" alt="logo_opd">
                        <div class="border-l border-slate-700 pl-3">
                            <p class="text-xs font-bold text-brand uppercase tracking-wider">Pemerintah Kabupaten
                            </p>
                            <p class="text-xs font-extrabold text-white">Karimun</p>
                        </div>
                    </div>
                    <div>
                        <h2 class="text-lg font-bold text-white leading-snug">{{ $opdName }}</h2>
                        <p class="text-xs text-slate-400 mt-1">Portal Pelayanan Publik & Informasi Resmi Pemerintah
                            Daerah Kabupaten Karimun.</p>
                    </div>
                </div>

                <!--informasi kontak-->
                <div class="space-y-3">
                    <h3 class="text-sm font-bold text-brand uppercase tracking-wider flex items-center gap-2">
                        Hubungi Kami
                    </h3>
                    <div class="text-xs text-slate-300 space-y-2 leading-relaxed">
                        <p class="flex items-start gap-2">
                            <span class="text-slate-400 shrink-0">Alamat:</span>
                            <span>{{ $opdConfigs?->address ?? 'Jl. Jend. Ahmad Yani No. 1, Kabupaten Karimun, Kepulauan Riau' }}</span>
                        </p>
                        <p class="flex items-center gap-2">
                            <span class="text-slate-400 shrink-0">Email:</span>
                            <a href="mailto:{{ $opdConfigs?->email }}"
                                class="text-slate-200 hover:text-brand transition-colors">{{ $opdConfigs?->email ?? '-' }}</a>
                        </p>
                        <p class="flex items-center gap-2">
                            <span class="text-slate-400 shrink-0">Telepon:</span>
                            <span>{{ $opdConfigs?->phone ?? '-' }}</span>
                        </p>
                    </div>
                </div>

                <!--media sosial-->
                <div class="space-y-4">
                    <h3 class="text-sm font-bold text-brand uppercase tracking-wider flex items-center gap-2">
                        Media Sosial Resmi
                    </h3>
                    <p class="text-xs text-slate-400">Ikuti saluran komunikasi resmi kami untuk mendapatkan pembaruan
                        informasi publik secara berkala.</p>

                    <div class="flex flex-wrap gap-2.5 pt-1">
                        @foreach($socialMedia as $socmed)
                        @if(!empty($socmed['url']))
                        <a href="{{ $socmed['url'] }}" target="_blank" rel="noopener noreferrer"
                            title="{{ $socmed['name'] }}"
                            class="p-2.5 bg-slate-800 hover:bg-brand text-slate-300 hover:text-white border border-slate-700/80 rounded-xl duration-200 transition-all transform hover:-translate-y-0.5 shadow-sm">
                            @if($socmed['icon'] === 'facebook')
                            <x-icons.facebook class="w-4 h-4" />
                            @elseif($socmed['icon'] === 'instagram')
                            <x-icons.instagram class="w-4 h-4" />
                            @elseif($socmed['icon'] === 'tiktok')
                            <x-icons.tiktok class="w-4 h-4" />
                            @elseif($socmed['icon'] === 'youtube')
                            <x-icons.youtube class="w-4 h-4" />
                            @endif
                        </a>
                        @endif
                        @endforeach
                    </div>
                </div>
            </div>

            <!-- Bar Copyright Bawah -->
            <div
                class="pt-6 border-t border-slate-800 flex flex-col sm:flex-row justify-between items-center gap-3 text-xs text-slate-400">
                <p>&copy; {{ date('Y') }} <span class="text-slate-200 font-medium">{{ $opdName }}</span>. Hak Cipta
                    Dilindungi.</p>
                <p class="text-[11px] text-slate-500">Pemerintah Kabupaten Karimun</p>
            </div>
        </div>
    </footer>
</body>

</html>