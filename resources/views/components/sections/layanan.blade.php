@props(['services'])

@php
$latestServices = $services->sortByDesc('created_at')->take(3);

$opdName = $latestServices->first()?->opd?->name ?? 'Instansi';
@endphp

<div class="max-w-screen-lg mx-auto w-full">
    <section class="max-w-screen-xl px-2 mx-auto w-full py-2 md:py-2">
        <!-- header -->
        <div class="flex justify-center pt-4 mb-2 border-gray-300 pb-3">
            <h2 class="text-2xl font-semibold mb-6">Layanan {{ $opdName }}</h2>
        </div>

        <!-- konten grid container utama -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @forelse ($services as $service)
            <div class="bg-white rounded-lg shadow p-5 border border-gray-200">
                <h3 class="text-lg font-bold mb-2">
                    {{ $service->name }}
                </h3>

                <p class="text-gray-600 text-sm">
                    {{ $service->description }}
                </p>
            </div>
            @empty
            <p class="text-gray-500">Belum ada layanan tersedia.</p>
            @endforelse
        </div>
    </section>
</div>