@props(['news'])

@if ($news->count() >= 4)
<section class="w-full bg-white py-10 md:py-20">
    <div class="max-w-screen-lg px-2 bg-white mx-auto grid gap-6">
        <p class="text-5xl font-medium text-slate-700">Berita Karimun</p>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

            {{-- FIRST NEWS --}}
            @php
            $first = $news;
            $firstImage = asset('storage/' . $first->image_url);
            @endphp

            <div class="h-72 md:h-96 bg-cover grid items-end" style="background-image: url('{{ $firstImage }}')">
                <div class="bg-slate-900/50 p-4 h-full flex flex-col gap-2 w-full justify-between">
                    <div>
                        <div class="w-fit whitespace-nowrap p-0.5 rounded-md text-slate-100 text-sm">
                            <p>{{ $first->published_at->isoFormat('D MMMM Y') }}</p>
                        </div>
                        <a href="/berita/{{ $first->slug }}"
                            class="hover:underline underline-offset-2 text-3xl leading-[1.2] font-medium hover:text-white text-slate-100 line-clamp-3">
                            {{ $first->title }}
                        </a>
                    </div>
                    <div class="flex justify-end">
                        <a href="/berita/{{ $first->slug }}"
                            class="ring-2 hover:bg-white ring-white p-2 rounded-full group duration-200 cursor-pointer">
                            <svg xmlns="http://www.w3.org/2000/svg"
                                class="h-6 w-6 text-white group-hover:text-slate-800 group-hover:rotate-45 duration-200"
                                fill="none" viewBox="0 0 24 24" stroke-width="1.7" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="m4.5 19.5 15-15m0 0H8.25m11.25 0v11.25" />
                            </svg>
                        </a>
                    </div>
                </div>
            </div>

            {{-- NEXT NEWS --}}
            <div class="h-full w-full grid grid-cols-2 gap-2 md:gap-4 auto-rows-fr">

                @foreach ($news->slice(1)->values() as $index => $item)
                @php
                $isSecond = $index === 0;
                $colSpan = $isSecond ? 'col-span-2 flex' : '';
                $image = asset('storage/' . $item->image_url);
                @endphp

                {{-- SECOND NEWS (Lebar) --}}
                @if ($isSecond)
                <div class="bg-slate-800 {{ $colSpan }} h-full w-full">
                    <div class="w-1/2 bg-cover h-full" style="background-image: url('{{ $image }}')">
                    </div>

                    <div class="w-1/2 h-full flex flex-col justify-between p-2 md:p-4 gap-2">
                        <div>
                            <div class="w-fit whitespace-nowrap p-0.5 rounded-md text-slate-100 text-sm">
                                <p>{{ $item->published_at->isoFormat('D MMMM Y') }}</p>
                            </div>
                            <a href="/berita/{{ $item->slug }}"
                                class="hover:underline underline-offset-2 text-xl leading-[1.2] font-light hover:text-white text-slate-50 line-clamp-3">
                                {{ $item->title }}
                            </a>
                        </div>
                        <div class="flex justify-end">
                            <a href="/berita/{{ $item->slug }}"
                                class="ring-1 hover:bg-white ring-white p-1.5 rounded-full group duration-200 cursor-pointer">
                                <svg xmlns="http://www.w3.org/2000/svg"
                                    class="h-5 w-5 text-white group-hover:text-slate-800 group-hover:rotate-45 duration-200"
                                    fill="none" viewBox="0 0 24 24" stroke-width="1" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="m4.5 19.5 15-15m0 0H8.25m11.25 0v11.25" />
                                </svg>
                            </a>
                        </div>
                    </div>
                </div>

                {{-- NEWS ITEM BIASA --}}
                @else
                <div class="h-full w-full bg-cover grid items-end" style="background-image: url('{{ $image }}')">
                    <div class="bg-slate-800/50 p-2 md:p-4 h-full flex gap-2 flex-col w-full justify-between">
                        <div>
                            <div class="w-fit p-0.5 rounded-md text-slate-100 text-sm">
                                <p>{{ $item->published_at->isoFormat('D MMMM Y') }}</p>
                            </div>
                            <a href="/berita/{{ $item->slug }}"
                                class="hover:underline underline-offset-2 text-xl leading-[1.2] font-light hover:text-white text-slate-50 line-clamp-3">
                                {{ $item->title }}
                            </a>
                        </div>
                        <div class="flex justify-end">
                            <a href="/berita/{{ $item->slug }}"
                                class="ring-1 hover:bg-white ring-white p-1.5 rounded-full group duration-200 cursor-pointer">
                                <svg xmlns="http://www.w3.org/2000/svg"
                                    class="h-5 w-5 text-white group-hover:text-slate-800 group-hover:rotate-45 duration-200"
                                    fill="none" viewBox="0 0 24 24" stroke-width="1" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="m4.5 19.5 15-15m0 0H8.25m11.25 0v11.25" />
                                </svg>
                            </a>
                        </div>
                    </div>
                </div>
                @endif

                @endforeach
            </div>

        </div>
    </div>
</section>
@endif