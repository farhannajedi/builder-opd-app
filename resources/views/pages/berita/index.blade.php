@php
$otherNews = App\Models\News::with('category', 'opd')->latest()->paginate(9);
@endphp

@extends('layouts.app', ['activePage' => 'berita'])

@section('content')
<div class="max-w-screen-lg mx-auto w-full">

    <section class="w-full slate-100 py-16">
        <div class="max-w-screen-lg px-2 grid gap-8 mx-auto w-full">

            <div class="pt-4">
                <p class="text-4xl font-medium text-slate-800">Berita</p>
            </div>

            <div class="grid grid-cols-2 md:grid-cols-3 gap-6 md:gap-14">
                @forelse ($otherNews as $item)
                <div class="rounded-lg group">

                    {{-- PERBAIKAN DI SINI --}}
                    <img src="{{ Storage::url($item->image_url) }}"
                        class="w-full h-auto min-h-32 max-h-44 duration-200 object-cover rounded-lg ring-1 ring-zinc-300 shadow-md hover:shadow-lg"
                        alt="{{ $item->title }}">

                    <div class="text-sm flex items-center gap-2 pt-3 pb-1 text-slate-600 h-fit">

                        {{-- PERBAIKAN: PASTIKAN published_at CASTING --}}
                        <p>{{ $item->published_at->isoFormat('d MMMM Y') }}</p>

                    </div>

                    <a href="/berita/{{ $item->slug }}"
                        class="text-lg font-medium text-slate-600 hover:underline underline-offset-2 cursor-pointer hover:text-orange-600">
                        {{ Str::limit($item->title, 80) }}
                    </a>

                </div>
                @empty
                <p class="col-span-full text-center text-slate-500">Belum ada berita lainnya.</p>
                @endforelse
            </div>

            {{-- Pagination tetap sama --}}
            @if ($otherNews->hasPages())
            ...
            @endif

        </div>
    </section>

</div>
@endsection