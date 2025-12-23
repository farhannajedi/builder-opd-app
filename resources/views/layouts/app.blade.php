@php
use App\Models\Opd;

$opd = Opd::find(env('APP_ID'));
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

    {{-- Memuat semua aset yang didaftarkan di AppServiceProvider --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <link rel="preconnect" href="https://fonts.googleapis.com">
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

        {{-- BIG BACKGROUND TEXT --}}
        <p class="pointer-events-none select-none absolute -left-4 top-2
        text-[170px] font-black tracking-widest leading-none
        bg-gradient-to-t from-yellow-200 via-yellow-800 to-yellow-800 bg-clip-text text-transparent opacity-40">

        </p>
        <p class="pointer-events-none select-none absolute -right-4 bottom-5
        text-[150px] font-black tracking-widest leading-none
        bg-gradient-to-b from-yellow-200 via-yellow-800 to-yellow-800 bg-clip-text text-transparent opacity-40">

        </p>

        <div class="max-w-screen-lg mx-auto px-4 relative z-10">

            {{-- TOP SECTION --}}
            <div class="flex justify-between items-start gap-10 mb-14">
                <div>
                    <img src="{{ asset('assets/images/logo_kab.png') }}" class="w-28 mb-3 drop-shadow-xl" alt="">
                    <p class="text-xl font-semibold text-white drop-shadow">Kabupaten Karimun</p>
                    <p class="text-sm text-white-200 drop-shadow">Diskominfo</p>
                </div>

                {{-- Kontak --}}
                <div class="text-sm space-y-1">
                    <p class="text-yellow-200 mb-1 font-medium">Hubungi Kami</p>
                    <p>Jl. Jendral Sudirman No. ...</p>
                    <p>Email: diskominfo@karimun.go.id</p>
                    <p>Telp: (0777) xxxx</p>
                </div>

                {{-- Sosial Media --}}
                <div class="text-sm space-y-1">
                    <p class="text-yellow-200 mb-1 font-medium">Media Sosial</p>
                    <div class="flex gap-4">
                        <a href="#" target="_blank"
                            class="p-2 border-2 border-yellow-400 hover:bg-yellow-800 hover:text-white duration-200 rounded-lg">
                            <x-icons.facebook class="w-5 h-5" />
                        </a>
                        <a href="#" target="_blank"
                            class="p-2 border-2 border-yellow-400 hover:bg-yellow-800 hover:text-white duration-200 rounded-lg">
                            <x-icons.instagram class="w-5 h-5" />
                        </a>
                        <a href="#" target="_blank"
                            class="p-2 border-2 border-yellow-400 hover:bg-yellow-800 hover:text-white duration-200 rounded-lg">
                            <x-icons.tiktok class="w-5 h-5" />
                        </a>
                        <a href="#" target="_blank"
                            class="p-2 border-2 border-yellow-400 hover:bg-yellow-800 hover:text-white duration-200 rounded-lg">
                            <x-icons.youtube class="w-5 h-5" />
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </footer>

    {{-- COPYRIGHT BAR --}}
    <div class="w-full bg-yellow-600 shadow py-1">
        <p class="text-sm text-center font-medium text-yellow-800">Copyright &copy; 2025</p>
    </div>


</body>

</html>