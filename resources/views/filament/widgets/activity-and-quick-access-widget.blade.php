use Illuminate\Support\Str;
<x-filament-widgets::widget>
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

        {{-- Aktivitas --}}
        <div class="lg:col-span-2">
            <x-filament::section>
                <x-slot name="heading">
                    <div class="flex items-center gap-2 font-bold text-gray-800 dark:text-gray-100">
                        <x-heroicon-m-clock class="w-5 h-5 text-primary-500" />
                        {{ $isSuperAdmin ? 'Daftar OPD' : 'Aktivitas Konten Terbaru' }}
                    </div>
                </x-slot>

                <div class="space-y-3 divide-y divide-gray-100 dark:divide-gray-800">
                    @if($isSuperAdmin)
                    @forelse($recentOpds as $opd)
                    <div class="pt-3 first:pt-0 flex items-center justify-between">
                        <div class="flex items-center gap-3">
                            <span
                                class="p-2 bg-primary-50 text-primary-600 dark:bg-primary-950 dark:text-primary-300 rounded-lg">
                                <x-heroicon-m-building-office class="w-4 h-4" />
                            </span>
                            <div>
                                <p class="text-sm font-semibold text-gray-800 dark:text-gray-200">{{ $opd->name }}</p>
                                <span class="text-xs text-gray-400">Kode: {{ $opd->code ?? '-' }} • Dibuat
                                    {{ $opd->created_at?->diffForHumans() }}</span>
                            </div>
                        </div>
                    </div>
                    @empty
                    <p class="text-sm text-gray-400 py-2">Belum ada OPD terdaftar.</p>
                    @endforelse
                    @else
                    @forelse($recentNews as $item)
                    <div class="pt-3 first:pt-0 flex items-center justify-between">
                        <div class="flex items-center gap-3">
                            <span class="p-2 bg-sky-50 text-sky-600 dark:bg-sky-950 dark:text-sky-300 rounded-lg">
                                <x-heroicon-m-newspaper class="w-4 h-4" />
                            </span>
                            <div>
                                <p class="text-sm font-semibold text-gray-800 dark:text-gray-200">
                                    {{ Str::limit($item->title, 45) }}
                                </p>
                                <span class="text-xs text-gray-400">Berita •
                                    {{ $item->created_at->diffForHumans() }}</span>
                            </div>
                        </div>
                    </div>
                    @empty
                    <p class="text-sm text-gray-400 py-2">Belum ada konten berita.</p>
                    @endforelse

                    @foreach($recentAnnouncement as $item)
                    <div class="pt-3 flex items-center justify-between">
                        <div class="flex items-center gap-3">
                            <span
                                class="p-2 bg-amber-50 text-amber-600 dark:bg-amber-950 dark:text-amber-300 rounded-lg">
                                <x-heroicon-m-megaphone class="w-4 h-4" />
                            </span>
                            <div>
                                <p class="text-sm font-semibold text-gray-800 dark:text-gray-200">
                                    {{ Str::limit($item->title, 45) }}
                                </p>
                                <span class="text-xs text-gray-400">Pengumuman •
                                    {{ $item->created_at->diffForHumans() }}</span>
                            </div>
                        </div>
                    </div>
                    @endforeach
                    @endif
                </div>
            </x-filament::section>
        </div>

        {{-- Akses Cepat --}}
        <div class="lg:col-span-1">
            <x-filament::section>
                <x-slot name="heading">
                    <div class="flex items-center gap-2 font-bold text-gray-800 dark:text-gray-100">
                        <x-heroicon-m-bolt class="w-5 h-5 text-amber-500" />
                        Akses Cepat
                    </div>
                </x-slot>

                <div class="flex flex-col gap-2.5">
                    @if($isSuperAdmin)
                    <a href="{{ url('/admin/opds/create') }}"
                        class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl border border-gray-200 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-800 transition text-sm font-medium text-gray-700 dark:text-gray-200 shadow-sm">
                        <x-heroicon-m-plus-circle class="w-5 h-5 text-primary-500" />
                        Tambah OPD Baru
                    </a>

                    <a href="{{ url('/admin/users/create') }}"
                        class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl border border-gray-200 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-800 transition text-sm font-medium text-gray-700 dark:text-gray-200 shadow-sm">
                        <x-heroicon-m-user-plus class="w-5 h-5 text-emerald-500" />
                        Tambah Pengguna
                    </a>

                    <a href="{{ url('/admin/opd-configs') }}"
                        class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl border border-gray-200 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-800 transition text-sm font-medium text-gray-700 dark:text-gray-200 shadow-sm">
                        <x-heroicon-m-cog-6-tooth class="w-5 h-5 text-gray-500" />
                        Konfigurasi OPD
                    </a>
                    @else
                    <a href="{{ url('/admin/news/create') }}"
                        class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl border border-gray-200 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-800 transition text-sm font-medium text-gray-700 dark:text-gray-200 shadow-sm">
                        <x-heroicon-m-plus-circle class="w-5 h-5 text-sky-500" />
                        Tambah Berita
                    </a>

                    <a href="{{ url('/admin/services/create') }}"
                        class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl border border-gray-200 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-800 transition text-sm font-medium text-gray-700 dark:text-gray-200 shadow-sm">
                        <x-heroicon-m-plus-circle class="w-5 h-5 text-emerald-500" />
                        Tambah Layanan
                    </a>

                    <a href="{{ url('/admin/opd-configs') }}"
                        class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl border border-gray-200 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-800 transition text-sm font-medium text-gray-700 dark:text-gray-200 shadow-sm">
                        <x-heroicon-m-cog-6-tooth class="w-5 h-5 text-gray-500" />
                        Pengaturan Profil OPD
                    </a>
                    @endif
                </div>
            </x-filament::section>
        </div>

    </div>
</x-filament-widgets::widget>