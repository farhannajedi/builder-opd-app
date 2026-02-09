@props(['galleries'])

@php
$galleries = $galleries->sortByDesc('published_at')->take(3);

$opdName = $galleries->first()?->opd?->name ?? 'Instansi';
@endphp

<div class="w-full max-w-screen-lg px-4 bg-white mx-auto grid gap-6">
    <section class="w-full bg-white mb-2 py-10 md:py-20">
        <!-- card pembungkus utama -->
        <div class="bg-white p-6 md:p-8 rounded-xl shadow-xl border border-gray-200">
            <div class="text-center mb-6">
                <p class="flex justify-center text-xl font-semibold text-gray-700 mb-2 pb-2">
                    Galleri Foto
                </p>
                <div class="w-full h-0.5 mx-auto mt-2 bg-gradient-to-r from-transparent via-orange-500 to-transparent">

                </div>
            </div>

            <!-- daftar galleri -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @forelse ($galleries as $gal)
                <div class="bg-white rounded-lg shadow p-5 border border-gray-200">
                    <img src="{{ asset('storage/' . $gal->images) }}" alt="{{ $gal->title }}"
                        class="w-full h-48 object-cover rounded-md mb-4">

                    <h3 class="text-lg font-bold mb-2">
                        {{ $gal->title }}
                    </h3>

                    <p class="text-gray-600 text-sm line-clamp-3">
                        {{ $gal->description }}
                    </p>
                </div>
                @empty
                <p class="text-gray-500">Belum ada galeri tersedia.</p>
                @endforelse
            </div>
        </div>
    </section>
</div>