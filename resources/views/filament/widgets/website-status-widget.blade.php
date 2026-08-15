<x-filament-widgets::widget>
    <x-filament::section>
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div class="flex items-center gap-3">
                <div class="relative flex h-3 w-3">
                    <span
                        class="animate-ping absolute inline-flex h-full w-full rounded-full bg-emerald-400 opacity-75"></span>
                    <span class="relative inline-flex rounded-full h-3 w-3 bg-emerald-500"></span>
                </div>
                <div>
                    <h4 class="text-sm font-bold text-gray-800 dark:text-gray-200">Status Website OPD: <span
                            class="text-emerald-600 font-semibold">Aktif & Publik</span></h4>
                    <p class="text-xs text-gray-400 mt-0.5">Dapat diakses oleh masyarakat umum melalui browser</p>
                </div>
            </div>

            <div>
                <a href="{{ url('/') }}" target="_blank"
                    class="inline-flex items-center gap-2 px-4 py-2 rounded-xl bg-gray-100 dark:bg-gray-800 hover:bg-gray-200 dark:hover:bg-gray-700 text-xs font-semibold text-gray-700 dark:text-gray-200 transition">
                    <span>{{ url('/') }}</span>
                    <x-heroicon-m-arrow-top-right-on-square class="w-4 h-4 text-gray-400" />
                </a>
            </div>
        </div>
    </x-filament::section>
</x-filament-widgets::widget>