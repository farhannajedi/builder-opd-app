@php
use App\Models\News;

// Jika diakses dari domain pusat (misal: localhost/utama), APP_ID kosong.
// Jika diakses dari domain web child (misal: tp-pkk.test), APP_ID terisi dari .env child.

<!-- nantinya akan mengarahkan ke slug berdasarkan App id -->
$slug = getenv('APP_ID');

if (!$slug) {
// TAMPILAN utama: Melihat berita dari semua OPD
$otherNews = News::withoutGlobalScope('filterOPD')->with(['category', 'opd'])->latest()->paginate(9);

$opdName = "Semua Instansi";
} else {
// TAMPILAN ANAK: Otomatis terfilter oleh Trait BelongsToOpd
$otherNews = News::with(['category', 'opd'])->latest()->paginate(9);

// Ambil nama OPD secara dinamis untuk judul
$opdName = $otherNews->first()?->opd?->name ?? 'Instansi';
}

// Untuk keperluan debug tampilan yang Anda buat tadi
$currentAppId = $slug ?? 'Pusat (Global)';
@endphp

@extends('layouts.app', ['activePage' => 'berita'])

@section('content')
<!-- debug content -->
<div class="bg-gray-100 p-4 mb-4 text-xs font-mono">
    <p>Current APP_ID (Slug): {{ $currentAppId }}</p>
    <p>Data OPD Ditemukan: {{ $opdName }}</p>
</div>

<div class="max-w-screen-lg mx-auto w-full">

    <hr class="border-t-1 border-slate-200">

    <section class="w-full slate-100 py-16">
        <div class="max-w-screen-lg px-2 grid gap-8 mx-auto w-full">

            <!-- tampilan header -->
            <div class="pt-4">
                <!-- Nama OPD ditambahkan secara dinamis di sini -->
                <p class="text-4xl font-medium text-slate-800">Berita Terbaru {{ $opdName }}</p>
            </div>

            <!-- LIST BERITA  -->
            <div class="grid grid-cols-2 md:grid-cols-3 gap-6 md:gap-14">
                @forelse ($otherNews as $news)
                <div class="rounded-lg group">
                    <div
                        class="relative w-full aspect-[16/9] overflow-hidden rounded-lg ring-1 ring-zinc-300 shadow-md hover:shadow-lg">

                        <!-- 'images' dan prefix 'storage/' -->
                        <img src="{{ asset('storage/' . $news->images) }}"
                            class="absolute inset-0 w-full h-full object-cover duration-200" alt="{{ $news->title }}">
                    </div>

                    <div class="text-sm flex items-center gap-2 pt-3 pb-1 text-slate-600 h-fit">
                        <!-- Tanggal Publikasi  -->
                        <p>{{ $news->published_at->isoFormat('d MMMM Y') }}</p>

                        <!-- Kategori Berita  -->
                        @if ($news->category)
                        <x-icons.dot class="w-1 h-1" />
                        <p>{{ $news->category->title ?? '-' }}</p>
                        @endif
                    </div>

                    <!-- Judul Berita (Link ke Detail)  -->
                    <a href="/berita/{{ $news->slug }}"
                        class="text-lg font-medium text-slate-600 hover:underline underline-offset-2 cursor-pointer hover:text-orange-600">
                        {{ Str::limit($news->title, 80) }}
                    </a>
                </div>
                @empty
                <p class="col-span-full text-center text-slate-500">Belum ada berita untuk {{ $opdName }}.</p>
                @endforelse
            </div>

            <!-- halaman semua berita -->
            @if ($otherNews->hasPages())
            <div class="flex border-t border-slate-200 pt-6 justify-between items-center">
                <ul class="flex items-center gap-4 text-lg font-medium">
                    <!-- arahkan halaman -->
                    @php
                    $start = max(1, $otherNews->currentPage() - 2);
                    $end = min($otherNews->lastPage(), $otherNews->currentPage() + 2);
                    @endphp

                    @if ($start > 1)
                    <li>
                        <a href="{{ $otherNews->url(1) }}"
                            class="bg-white rounded py-1 px-2 ring-1 ring-zinc-200 text-slate-600 hover:bg-slate-200">1</a>
                    </li>
                    @if ($start > 2)
                    <li class="text-slate-400">...</li>
                    @endif
                    @endif

                    @for ($i = $start; $i <= $end; $i++) @if ($i==$otherNews->currentPage())
                        <li>
                            <a href="javascript:void(0)"
                                class="bg-orange-600 rounded py-1 px-2 ring-1 ring-zinc-200 text-white">
                                {{ $i }}
                            </a>
                        </li>
                        @else
                        <li>
                            <a href="{{ $otherNews->url($i) }}"
                                class="bg-white rounded py-1 px-2 ring-1 ring-zinc-200 text-slate-600 hover:bg-slate-200">
                                {{ $i }}
                            </a>
                        </li>
                        @endif
                        @endfor

                        @if ($end < $otherNews->lastPage())
                            @if ($end < $otherNews->lastPage() - 1)
                                <li class="text-slate-400">...</li>
                                @endif
                                <li>
                                    <a href="{{ $otherNews->url($otherNews->lastPage()) }}"
                                        class="bg-white rounded py-1 px-2 ring-1 ring-zinc-200 text-slate-600 hover:bg-slate-200">
                                        {{ $otherNews->lastPage() }}
                                    </a>
                                </li>
                                @endif
                </ul>

                <!-- arrow button -->
                <div class="flex gap-2">
                    <a href="{{ $otherNews->previousPageUrl() }}"
                        class="{{ $otherNews->onFirstPage() ? 'pointer-events-none text-slate-300' : 'hover:text-slate-600 text-slate-500' }} bg-white hover:bg-slate-200 rounded p-1 ring-1 ring-zinc-300">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 stroke-2" fill="none"
                            stroke="currentColor" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M15 6l-6 6l6 6" />
                        </svg>
                    </a>
                    <a href="{{ $otherNews->nextPageUrl() }}"
                        class="{{ $otherNews->hasMorePages() ? 'hover:text-slate-600 text-slate-500' : 'pointer-events-none text-slate-300' }} bg-white hover:bg-slate-200 rounded p-1 ring-1 ring-zinc-300">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 stroke-2" fill="none"
                            stroke="currentColor" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M9 6l6 6l-6 6" />
                        </svg>
                    </a>
                </div>
            </div>
            @endif

        </div>
    </section>

</div>
@endsection