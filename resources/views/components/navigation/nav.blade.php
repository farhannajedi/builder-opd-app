@props(['activePage'])

<nav class="bg-white border-b shadow-sm">
    <div class="max-w-7xl mx-auto px-4 md:px-6 lg:px-8">
        <div class="flex justify-between items-center h-16">

            <!-- Logo -->
            <a href="/" class="text-xl font-semibold text-gray-800">
                OPD Website
            </a>

            <!-- Hamburger (Mobile) -->
            <div class="md:hidden flex items-center">
                <input id="menu-toggle" type="checkbox" class="peer hidden">
                <label for="menu-toggle" class="cursor-pointer">
                    <svg class="w-7 h-7 text-gray-700" fill="none" stroke="currentColor" stroke-width="2"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                </label>
            </div>

            <!-- Menu Desktop -->
            <div class="hidden md:flex space-x-8">
                <a href="/" class="text-gray-700 hover:text-blue-600 transition">Beranda</a>
                <a href="/profil" class="text-gray-700 hover:text-blue-600 transition">Profil</a>
                <a href="/layanan" class="text-gray-700 hover:text-blue-600 transition">Layanan</a>
                <a href="/kontak" class="text-gray-700 hover:text-blue-600 transition">Kontak</a>
            </div>

        </div>
    </div>

    <!-- Menu Mobile -->
    <div class="md:hidden peer-checked:block hidden bg-white border-t">
        <div class="px-4 py-3 space-y-2">
            <a href="/" class="block text-gray-700 hover:text-blue-600 transition">Beranda</a>
            <a href="/profil" class="block text-gray-700 hover:text-blue-600 transition">Profil</a>
            <a href="/layanan" class="block text-gray-700 hover:text-blue-600 transition">Layanan</a>
            <a href="/kontak" class="block text-gray-700 hover:text-blue-600 transition">Kontak</a>
        </div>
    </div>
</nav>