@php
use App\Models\Opd;
use App\Models\Profil;

// Identifikasi OPD berdasarkan APP_ID
$opdSlug = env('APP_ID');
$opd = Opd::where('slug', $opdSlug)->first();

// Mengambil data profil milik OPD ini
$profil = Profil::where('opd_id', $opd?->id)->first();

$opdName = $opd->name ?? 'Instansi';
@endphp

@extends('layouts.app', ['activePage' => 'profil'])

@section('content')
<div class="w-full bg-slate-50/60 py-10 min-h-screen">
    <div class="max-w-screen-xl mx-auto px-4 sm:px-6 lg:px-8 space-y-8">

        <!-- Hero Banner -->
        <div
            class="relative overflow-hidden bg-slate-900 text-white rounded-3xl p-8 sm:p-12 shadow-lg border border-slate-800">
            <div class="absolute -right-10 -bottom-10 w-64 h-64 bg-brand/10 rounded-full blur-3xl pointer-events-none">
            </div>

            <div class="relative z-10 max-w-3xl space-y-3">
                <div
                    class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-brand-500/20 border border-brand-500/30 text-brand-400 text-[8px] font-extrabold uppercase tracking-widest">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="currentColor" class="size-6">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M15 9h3.75M15 12h3.75M15 15h3.75M4.5 19.5h15a2.25 2.25 0 0 0 2.25-2.25V6.75A2.25 2.25 0 0 0 19.5 4.5h-15a2.25 2.25 0 0 0-2.25 2.25v10.5A2.25 2.25 0 0 0 4.5 19.5Zm6-10.125a1.875 1.875 0 1 1-3.75 0 1.875 1.875 0 0 1 3.75 0Zm1.294 6.336a6.721 6.721 0 0 1-3.17.789 6.721 6.721 0 0 1-3.168-.789 3.376 3.376 0 0 1 6.338 0Z" />
                    </svg>

                    Profil & Identitas Resmi
                </div>
                <h1 class="text-xl sm:text-2xl font-black tracking-tight leading-tight">
                    Profil {{ $opdName }}
                </h1>
                <p class="text-xs sm:text-sm text-slate-300 leading-relaxed">
                    Mengenal lebih dekat gambaran umum, visi, misi, tugas pokok, serta struktur organisasi
                    {{ $opdName }}.
                </p>
            </div>
        </div>

        @if(!$profil)
        <!-- Jika Data Profil Belum Diisi di Admin -->
        <div class="bg-white rounded-3xl p-12 text-center border border-slate-200/80 shadow-sm space-y-3">
            <div
                class="p-4 bg-brand-light rounded-full text-brand border border-brand/20 w-12 h-12 flex items-center justify-center mx-auto">
                <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
            </div>
            <h3 class="text-base font-bold text-slate-800">Informasi Profil Belum Tersedia</h3>
            <p class="text-xs text-slate-500 max-w-md mx-auto">
                Admin {{ $opdName }} belum memperbarui atau menerbitkan data profil resmi instansi saat ini.
            </p>
        </div>
        @else

        <!--  Profil -->
        <div class="space-y-8">

            <!-- Kepala Dinas & Tentang Kami -->
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">

                <!-- Kepala Dinas & Sambutan -->
                <div
                    class="lg:col-span-5 bg-white rounded-3xl p-6 sm:p-8 border border-slate-200/80 shadow-sm space-y-6">
                    <div
                        class="relative rounded-2xl overflow-hidden bg-slate-100 aspect-[4/5] border border-slate-200 shadow-inner">
                        @if($profil->gambar)
                        <img src="{{ asset('storage/' . $profil->gambar) }}" alt="{{ $profil->nama_kepala_dinas }}"
                            class="w-full h-full object-cover">
                        @else
                        <div
                            class="w-full h-full flex flex-col items-center justify-center bg-slate-100 text-slate-400 p-6 text-center">
                            <svg class="w-16 h-16 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                    d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                            </svg>
                            <span class="text-xs font-semibold">Foto Pimpinan</span>
                        </div>
                        @endif
                        <div
                            class="absolute inset-x-0 bottom-0 bg-gradient-to-t from-slate-950 via-slate-950/60 to-transparent p-5 text-white">
                            <h3 class="text-base sm:text-lg font-bold leading-snug">
                                {{ $profil->nama_kepala_dinas ?? 'Pimpinan Instansi' }}
                            </h3>
                            <p class="text-xs text-brand font-medium mt-0.5">Kepala {{ $opdName }}</p>
                        </div>
                    </div>

                    @if($profil->sambutan_kepala)
                    <div class="space-y-2 pt-2 border-t border-slate-100">
                        <div class="flex items-center gap-2 text-slate-800 font-bold text-sm">
                            <span
                                class="text-[10px] font-extrabold text-slate-600 bg-slate-100 border border-slate-200 px-2.5 py-1 rounded-lg uppercase tracking-wider">
                                Sambutan Kepala {{ $opdName }}
                            </span>
                        </div>
                        <div class="prose prose-slate prose-xs text-slate-600 leading-relaxed italic">
                            {!! strip_tags($profil->sambutan_kepala, '<p><br><strong><b>') !!}
                        </div>
                    </div>
                    @endif
                </div>

                <!-- Gambaran Umum -->
                <div
                    class="lg:col-span-7 bg-white rounded-3xl p-6 sm:p-8 border border-slate-200/80 shadow-sm space-y-6">
                    <div>
                        <div class="flex items-center gap-2 text-slate-800 font-bold text-sm">
                            <span
                                class="text-[10px] font-extrabold text-slate-600 bg-slate-100 border border-slate-200 px-2.5 py-1 rounded-lg uppercase tracking-wider">
                                Gambaran Umum
                            </span>
                        </div>

                        <h2 class="text-lg sm:text-2xl font-bold text-slate-800 mt-3 leading-snug">
                            Tentang {{ $opdName }}
                        </h2>
                    </div>

                    <div class="prose prose-slate max-w-none text-slate-700 text-xs sm:text-sm leading-relaxed">
                        {!! $profil->tentang_kami ?? '<p class="text-slate-400 italic">Belum ada deskripsi profil
                            instansi.</p>' !!}
                    </div>

                    @if($profil->penjelasan_tugas)
                    <div class="p-4 bg-slate-50 rounded-2xl border border-slate-200/60 mt-6 space-y-1.5">
                        <div class="flex items-center gap-2 text-slate-800 font-bold text-sm">
                            <span
                                class="text-[10px] font-extrabold text-slate-600 bg-slate-100 border border-slate-200 px-2.5 py-1 rounded-lg uppercase tracking-wider">
                                Penjelasan Tugas Utama
                            </span>
                        </div>
                        <p class="text-xs text-slate-600 leading-relaxed">{{ $profil->penjelasan_tugas }}</p>
                    </div>
                    @endif
                </div>

            </div>

            <!-- Visi & Misi -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 sm:gap-8">

                <!-- Visi -->
                <div class="bg-white rounded-3xl p-6 sm:p-8 border border-slate-200/80 shadow-sm space-y-4">
                    <div class="flex items-center gap-3">
                        <div class="p-2.5 bg-brand-light text-brand rounded-xl">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                            </svg>
                        </div>
                        <h3 class="text-base sm:text-lg font-bold text-slate-800">Visi Instansi</h3>
                    </div>
                    <div class="prose prose-slate prose-xs text-slate-700 leading-relaxed pt-1">
                        {!! $profil->visi ?? '<p class="text-slate-400 italic">Visi belum diatur.</p>' !!}
                    </div>
                </div>

                <!-- Misi -->
                <div class="bg-white rounded-3xl p-6 sm:p-8 border border-slate-200/80 shadow-sm space-y-4">
                    <div class="flex items-center gap-3">
                        <div class="p-2.5 bg-brand-light text-brand rounded-xl">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4" />
                            </svg>
                        </div>
                        <h3 class="text-base sm:text-lg font-bold text-slate-800">Misi Instansi</h3>
                    </div>
                    <div class="prose prose-slate prose-xs text-slate-700 leading-relaxed pt-1">
                        {!! $profil->misi ?? '<p class="text-slate-400 italic">Misi belum diatur.</p>' !!}
                    </div>
                </div>

            </div>

            <!-- Tugas Pokok & Fungsi -->
            <div class="bg-white rounded-3xl p-6 sm:p-8 border border-slate-200/80 shadow-sm space-y-6">
                <div>
                    <div class="flex items-center gap-2 text-slate-800 font-bold text-sm">
                        <span
                            class="text-[10px] font-extrabold text-slate-600 bg-slate-100 border border-slate-200 px-2.5 py-1 rounded-lg uppercase tracking-wider">
                            Tupoksi
                        </span>
                    </div>
                    <h2 class="text-lg sm:text-xl font-bold text-slate-800 mt-2">Tugas Pokok & Fungsi</h2>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Tugas -->
                    <div class="p-5 bg-slate-50/80 rounded-2xl border border-slate-200/60 space-y-2">
                        <div class="flex items-center gap-2 text-slate-800 font-bold text-sm">
                            <span
                                class="text-[10px] font-extrabold text-slate-600 bg-slate-100 border border-slate-200 px-2.5 py-1 rounded-lg uppercase tracking-wider">
                                Tugas Utama
                            </span>
                        </div>
                        <div class="text-xs text-slate-700 leading-relaxed">
                            {!! $profil->tugas ?? '<p class="text-slate-400 italic">Tugas pokok belum diisi.</p>' !!}
                        </div>
                    </div>

                    <!-- Fungsi -->
                    <div class="p-5 bg-slate-50/80 rounded-2xl border border-slate-200/60 space-y-2">
                        <div class="flex items-center gap-2 text-slate-800 font-bold text-sm">
                            <span
                                class="text-[10px] font-extrabold text-slate-600 bg-slate-100 border border-slate-200 px-2.5 py-1 rounded-lg uppercase tracking-wider">
                                Fungsi Intansi
                            </span>
                        </div>
                        <div class="text-xs text-slate-700 leading-relaxed">
                            {!! $profil->fungsi ?? '<p class="text-slate-400 italic">Fungsi instansi belum diisi.</p>'
                            !!}
                        </div>
                    </div>
                </div>
            </div>

            <!-- Bagan Struktur Organisasi -->
            @if($profil->bagan_struktur)
            <div class="bg-white rounded-3xl p-6 sm:p-8 border border-slate-200/80 shadow-sm space-y-6">
                <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                    <div>
                        <div class="flex items-center gap-2 text-slate-800 font-bold text-sm">
                            <span
                                class="text-[10px] font-extrabold text-slate-600 bg-slate-100 border border-slate-200 px-2.5 py-1 rounded-lg uppercase tracking-wider">
                                Struktur Organisasi
                            </span>
                        </div>
                        <h2 class="text-lg sm:text-xl font-bold text-slate-800 mt-2">Bagan Struktur</h2>
                    </div>
                    <!-- <a href="{{ asset('storage/' . $profil->bagan_struktur) }}" target="_blank" download
                        class="inline-flex items-center gap-2 px-4 py-2 bg-brand text-brand text-xs font-bold rounded-xl hover:text-brand-500 hover:opacity-90 transition-opacity shadow-sm w-fit">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                        </svg>
                        <span>Unduh Gambar Bagan</span>
                    </a> -->
                </div>

                <div class="p-4 bg-slate-50 rounded-2xl border border-slate-200/80 overflow-hidden flex justify-center">
                    <img src="{{ asset('storage/' . $profil->bagan_struktur) }}"
                        alt="Bagan Struktur Organisasi {{ $opdName }}"
                        class="max-w-full h-auto rounded-xl shadow-sm object-contain max-h-[700px]">
                </div>
            </div>
            @endif
        </div>
        @endif
    </div>
</div>
@endsection