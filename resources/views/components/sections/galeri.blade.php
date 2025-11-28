@props(['galleries'])

<section class="py-10">
    <div class="max-w-7xl mx-auto px-4">
        <h2 class="text-2xl font-semibold mb-6">Galeri</h2>

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