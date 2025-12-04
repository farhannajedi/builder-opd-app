@php
// $firstNews = App\Models\News::with('category', 'opd')->firstOrFail();
$otherNews = App\Models\News::with('category', 'opd')->latest()->paginate(9);
@endphp

@extends('layouts.app', ['activePage' => 'berita'])

@section('content')
<div class="max-w-screen-lg mx-auto w-full">
    {{-- Hero Section --}}
    {{-- <section class="flex flex-col md:flex-row gap-8 items-center py-16 px-2">
      <div class="flex-1 md:w-1/2 w-full">
        <img src="{{ asset($firstNews->image_url) }}"
    class="w-full h-auto bg-cover rounded-lg ring-1 ring-zinc-300 shadow-md hover:shadow-lg"
    alt="{{ $firstNews->title }}">
</div>
<div class="flex-1 grid gap-4 place-content-center justify-start">
    <div class="flex items-center gap-2 text-slate-600 h-fit">
        <p>{{ $firstNews->published_at->isoFormat('d MMMM Y') }}</p>
        <x-icons.dot class="w-2 h-2" />
        <p>{{ $firstNews->category->title ?? '-' }}</p>
    </div>
    <h1 class="font-medium text-5xl leading-[1.1] text-slate-600 line-clamp-3">
        <a href="/berita/{{ $firstNews->slug }}" class="hover:underline underline-1">
            {{ $firstNews->title }}
        </a>

        <!-- Inline action button -->
        <a href="/berita/{{ $firstNews->slug }}" class="inline-flex items-center justify-center align-middle
             group rounded-lg
            hover:bg-orange-600 transition duration-200 ml-2">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                class="h-10 w-10 text-slate-600 group-hover:text-slate-100 group-hover:-rotate-45 transition duration-200">
                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                <path d="M5 12l14 0" />
                <path d="M13 18l6 -6" />
                <path d="M13 6l6 6" />
            </svg>
        </a>
    </h1>
</div>
</section> --}}
{{-- Hero Section --}}

<hr class="border-t-1 border-slate-200">

<section class="w-full slate-100  py-16">
    <div class="max-w-screen-lg px-2 grid gap-8 mx-auto w-full">
        {{-- Header Filter --}}
        {{-- Header --}}
        <div class="pt-4">
            <p class="text-4xl font-medium text-slate-800">Berita</p>
        </div>
        {{-- <div class="flex flex-col md:flex-row gap-2 justify-between items-start md:items-center">
          <div class="flex gap-4 items-center text-slate-500 font-medium">
            <div
              class="py-1.5 px-3 bg-white border border-slate-200 rounded-full text-orange-600 flex items-center gap-1 hover:bg-slate-200">
              <span>Semua Berita</span>
              <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                class="icon icon-tabler icons-tabler-outline icon-tabler-chevron-down">
                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                <path d="M6 9l6 6l6 -6" />
              </svg>
            </div>
          </div>
          <div class="bg-white w-full md:w-1/3 h-10 border border-slate-400 rounded-lg flex p-1">
            <input type="text" class="flex-1 focus:outline-none pl-2" placeholder="Pencarian">
            <button class="bg-white hover:bg-amber-300 rounded-r-md px-2">
              <svg xmlns="http://www.w3.org/2000/svg" class="text-slate-600 h-6 w-auto" viewBox="0 0 24 24" fill="none"
                stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                <path d="M10 10m-7 0a7 7 0 1 0 14 0a7 7 0 1 0 -14 0" />
                <path d="M21 21l-6 -6" />
              </svg>
            </button>
          </div>
        </div> --}}
        {{-- Header Filter --}}


        <div class="grid grid-cols-2 md:grid-cols-3 gap-6 md:gap-14">
            @forelse ($otherNews as $news)
            <div class="rounded-lg group">
                <img src="{{ asset($news->image_url) }}"
                    class="w-full h-auto min-h-32 max-h-44 duration-200 object-cover rounded-lg ring-1 ring-zinc-300 shadow-md hover:shadow-lg"
                    alt="{{ $news->title }}">
                <div class="text-sm flex items-center gap-2 pt-3 pb-1 text-slate-600 h-fit">
                    <p>{{ $news->published_at->isoFormat('d MMMM Y') }}</p>
                    {{-- <x-icons.dot class="w-1 h-1" /> --}}
                    {{-- <p>{{ $news->category->title ?? '-' }}</p> --}}
                </div>
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
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 stroke-2" fill="none" stroke="currentColor"
                        stroke-linecap="round" stroke-linejoin="round">
                        <path d="M15 6l-6 6l6 6" />
                    </svg>
                </a>
                <a href="{{ $otherNews->nextPageUrl() }}"
                    class="{{ $otherNews->hasMorePages() ? 'hover:text-slate-600 text-slate-500' : 'pointer-events-none text-slate-300' }} bg-white hover:bg-slate-200 rounded p-1 ring-1 ring-zinc-300">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 stroke-2" fill="none" stroke="currentColor"
                        stroke-linecap="round" stroke-linejoin="round">
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