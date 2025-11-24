@props(['documents'])

<section class="py-10">
    <div class="max-w-screen-xl mx-auto px-4">
        <h2 class="text-2xl font-bold mb-6">Dokumen Perencanaan</h2>

        @if($documents->isEmpty())
        <p class="text-gray-500">Belum ada dokumen perencanaan.</p>
        @else
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            @foreach($documents as $doc)
            <div class="p-5 border rounded-lg shadow-sm bg-white">
                <h3 class="text-xl font-semibold">{{ $doc->title }}</h3>

                <p class="text-gray-600 mt-2 line-clamp-3">
                    {!! Str::limit(strip_tags($doc->content), 150) !!}
                </p>

                <div class="mt-4 flex justify-between items-center">
                    <a href="{{ asset('storage/' . $doc->file) }}" target="_blank"
                        class="text-blue-600 hover:underline">
                        Lihat Dokumen
                    </a>

                    <span class="text-sm text-gray-500">
                        {{ $doc->created_at->isoFormat('DD MMMM YYYY') }}
                    </span>
                </div>
            </div>
            @endforeach
        </div>
        @endif
    </div>
</section>