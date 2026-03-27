use Illuminate\Support\Str;
@php

$announcements = App\Models\announcement::with('opd')->where('slug', $slug)->firstOrFail();

<!-- mengambil pengumuman lain -->
$otherAnnouncement = App\Models\announcement::where('opd_id', $announcement->opd_id)->where('id', '!=',
$announcement->id)->latest()->take(5)->get();

@endphp

@extends('layouts.app', ['activePage' => 'Detail Pengumuman'])

@section('content')
<!--  -->
<section class="max-w-screen-lg px-4 mx-auto w-full py-12">
    <nav class="flex mb-8 text-sm text-slate-500 gap-2">
        <a href="{{ url('/') }}" class="hover:text-blue-600 transition">Beranda</a>
        <span>/</span>
        <a href="{{ url('/pengumuman') }}" class="hover:text-blue-600 transition">Pengumuman</a>
        <span>/</span>
        <span class="text-slate-800 truncate font-medium">{{ Str::limit($announcement->title, 30) }}</span>
    </nav>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-12">

        <div class="lg:col-span-2 space-y-8">
            <div class="space-y-6">
                <div
                    class="inline-flex items-center gap-2 bg-blue-100 text-blue-700 px-4 py-1.5 rounded-full text-xs font-bold uppercase tracking-wider">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z" />
                    </svg>
                    Informasi Resmi
                </div>

                <h1 class="text-3xl md:text-4xl font-black text-slate-900 leading-tight">
                    {{ $announcement->title }}
                </h1>

                <div class="flex items-center gap-4 text-slate-500 text-sm border-y border-slate-100 py-4">
                    <div class="flex items-center gap-2">
                        <div
                            class="w-8 h-8 rounded-full bg-slate-200 flex items-center justify-center text-slate-600 font-bold text-xs">
                            {{ substr($announcement->opd->name ?? 'I', 0, 1) }}
                        </div>
                        <span class="font-bold text-slate-700">{{ $announcement->opd->name ?? 'Instansi' }}</span>
                    </div>
                    <span class="text-slate-300">|</span>
                    <div class="flex items-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                        {{ $announcement->created_at->isoFormat('D MMMM Y') }}
                    </div>
                </div>
            </div>

            @if($announcement->image)
            <div class="rounded-3xl overflow-hidden shadow-2xl shadow-blue-100 border border-slate-100">
                <img src="{{ asset('storage/' . $announcement->image) }}" alt="{{ $announcement->title }}"
                    class="w-full h-auto object-cover">
            </div>
            @endif

            <div class="prose prose-blue max-w-none">
                <div class="text-slate-700 leading-relaxed text-lg whitespace-pre-line">
                    {!! nl2br(e($announcement->description)) !!}
                </div>
            </div>

            <div class="pt-10 border-t border-slate-100">
                <a href="{{ url('/pengumuman') }}"
                    class="inline-flex items-center gap-3 bg-slate-100 text-slate-700 px-6 py-3 rounded-2xl font-bold hover:bg-blue-600 hover:text-white transition-all duration-300 group">
                    <svg xmlns="http://www.w3.org/2000/svg"
                        class="h-5 w-5 group-hover:-translate-x-1 transition-transform" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                    Daftar Pengumuman
                </a>
            </div>
        </div>

        <div class="space-y-8">
            <div class="bg-white rounded-3xl p-8 border border-slate-100 shadow-sm">
                <h3 class="text-xl font-black text-slate-800 mb-6 flex items-center gap-3">
                    <span class="w-1.5 h-6 bg-blue-600 rounded-full"></span>
                    Pengumuman Lainnya
                </h3>

                <div class="space-y-6">
                    @forelse ($otherAnnouncements as $item)
                    <a href="{{ url('pengumuman/' . $item->slug) }}" class="group block space-y-2">
                        <div class="flex items-center gap-2">
                            <span
                                class="text-[10px] font-bold text-blue-600 uppercase">{{ $item->created_at->diffForHumans() }}</span>
                        </div>
                        <h4
                            class="text-sm font-bold text-slate-800 line-clamp-2 group-hover:text-blue-600 transition-colors leading-snug">
                            {{ $item->title }}
                        </h4>
                        <div class="h-px w-full bg-slate-50 group-last:hidden"></div>
                    </a>
                    @empty
                    <div class="text-center py-4">
                        <p class="text-sm text-slate-400 italic">Tidak ada pengumuman lain.</p>
                    </div>
                    @endforelse
                </div>
            </div>

            <div
                class="bg-gradient-to-br from-blue-600 to-blue-800 rounded-3xl p-8 text-white shadow-xl shadow-blue-200 relative overflow-hidden">
                <div class="absolute -right-4 -bottom-4 opacity-10">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-32 w-32" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z" />
                    </svg>
                </div>

                <!-- <div class="relative z-10">
                    <h4 class="font-black text-xl mb-3">Ada Pertanyaan?</h4>
                    <p class="text-sm text-blue-100 mb-6 leading-relaxed">
                        Jika Anda memerlukan klarifikasi lebih lanjut mengenai pengumuman ini, jangan ragu untuk
                        menghubungi layanan informasi kami.
                    </p>
                    <a href="{{ url('/kontak') }}"
                        class="block text-center bg-white text-blue-700 py-3 rounded-2xl font-black text-sm hover:bg-blue-50 transition-all active:scale-95 shadow-lg">
                        Hubungi Kami
                    </a>
                </div> -->
            </div>
        </div>

    </div>
</section>
@endsection