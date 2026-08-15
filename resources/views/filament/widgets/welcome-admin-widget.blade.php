<x-filament-widgets::widget>
    <x-filament::section
        class="bg-gradient-to-r from-emerald-600 via-teal-600 to-cyan-700 text-white rounded-2xl shadow-sm border-0 p-6">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-bold flex items-center gap-2">
                    Selamat Datang, {{ auth()->user()->name }}
                </h1>
                <p class="text-emerald-100 text-sm mt-1">
                    @if(auth()->user()->opd)
                    Kelola informasi dan portal resmi untuk <strong>{{ auth()->user()->opd->name }}</strong>
                    @else
                    Kelola seluruh portal Organisasi Perangkat Daerah (OPD)
                    @endif
                </p>
            </div>
        </div>
    </x-filament::section>
</x-filament-widgets::widget>