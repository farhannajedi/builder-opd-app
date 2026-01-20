@props(['services'])

@php
$latestServices = $services->sortByDesc('created_at')->take(3);

$opdName = $latestServices->first()?->opd?->name ?? 'Instansi';
@endphp

@if ($latestServices->count() > 0)
<section class="py-10">
    <div class="max-w-7xl mx-auto px-4">
        <h2 class="text-2xl font-semibold mb-6">Layanan {{ $opdName }}</h2>
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
    </div>
</section>
@endif