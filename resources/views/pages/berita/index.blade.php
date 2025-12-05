@php
use App\Models\News;

// Mengambil semua berita terbaru, tanpa filter OPD (sesuai permintaan).
// Jika Anda ingin memfilter berdasarkan OPD, gunakan: ->where('opd_id', env('APP_ID'))
$otherNews = News::with('category', 'opd')
->latest()
->paginate(9);
@endphp

@extends('layouts.app', ['activePage' => 'berita'])

@section('content')
<div class="max-w-screen-lg mx-auto w-full">

    <hr class="border-t-1 border-slate-200">

    <section class="w-full slate-100 py-16">
        <div class="max-w-screen-lg px-2 grid gap-8 mx-auto w-full">

            {{-- Header --}}
            <div class="pt-4">
                <p class="text-4xl font-medium text-slate-800">Berita Terbaru</p>
            </div>

            {{-- LIST BERITA --}}
            <div class="grid grid-cols-2 md:grid-cols-3 gap-6 md:gap-14">
                @forelse ($otherNews as $news)
                <div class="rounded-lg group">

                    {{-- 'images' dan prefix 'storage/' --}}
                    <img src="{{ asset('storage/' . $news->images) }}"
                        class="w-full h-auto min-h-32 max-h-44 duration-200 object-cover rounded-lg ring-1 ring-zinc-300 shadow-md hover:shadow-lg"
                        alt="{{ $news->title }}">

                    <div class="text-sm flex items-center gap-2 pt-3 pb-1 text-slate-600 h-fit">
                        {{-- Tanggal Publikasi --}}
                        <p>{{ $news->published_at->isoFormat('d MMMM Y') }}</p>

                        {{-- Kategori Berita --}}
                        @if ($news->category)
                        <x-icons.dot class="w-1 h-1" />
                        <p>{{ $news->category->title ?? '-' }}</p>
                        @endif
                    </div>

                    {{-- Judul Berita (Link ke Detail) --}}
                    <a href="/berita/{{ $news->slug }}"
                        class="text-lg font-medium text-slate-600 hover:underline underline-offset-2 cursor-pointer hover:text-orange-600">
                        {{ Str::limit($news->title, 80) }}
                    </a>
                </div>
                @empty
                <p class="col-span-full text-center text-slate-500">Belum ada berita lainnya.</p>
                @endforelse
            </div>

            {{-- Custom Pagination --}}
            @if ($otherNews->hasPages())
            <div class="flex border-t border-slate-200 pt-6 justify-between items-center">
                <ul class="flex items-center gap-4 text-lg font-medium">
                    {{-- Page Links --}}
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

                {{-- Arrow buttons (duplicate optional) --}}
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