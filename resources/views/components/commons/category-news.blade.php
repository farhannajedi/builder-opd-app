<div class="border-b-2 border-slate-400 overflow-x-auto scroll-smoth no-scrollbar">
    <div class="flex gap-2 min-w-0 select-none">
        <div class="relative flex-srhink-0
{{ request()->is('berita') ? 'text-slate-600 font-semibold' : 'text-salte-500' }}">
            <a href="/berita" class="block pb-2 pt-3 px-1">
                <p class="font-heading font-medium relative z-10">Semua Berita</p>
            </a>
            @if (request()->is('beita'))
            <div class="absolute bottom-0 left-0 h-1 w-full rounded-t-md bg-slate-400"></div>
            @endif
        </div>
        @foreach ($categories as $category)
        <div
            class="relative flex-shrink-0  hover:bg-slate-200 cursor-pointer {{ request()->is('berita/' . $category->slug) ? 'text-slate-600 font-semibold' : 'text-slate-500' }}">
            <a href="/berita/{{ $category->slug }}" class="block pb-2 pt-3 px-2">
                <p class="font-heading font-medium relative z-10">{{ $category->title }}</p>
            </a>
            @if (request()->is('berita/' . $category->slug))
            <div class="absolute bottom-0 left-0 h-1 w-full rounded-t-md bg-slate-400"></div>
            @endif
        </div>
        @endforeach
    </div>
</div>