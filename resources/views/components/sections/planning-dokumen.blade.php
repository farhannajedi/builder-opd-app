@props(['documents'])

@php

$opdSlug = env('APP_ID');
$opd = App\Models\Opd::where('slug', $opdSlug)->first();

$latestDocuments = $documents->where('opd_id', $opd?->id)->sortByDesc('published_at')->take(3);

$opdName = $opd?->name ?? 'Instansi';
@endphp

<div class="max-w-screen-lg mx-auto mb-9 w-full">
    <section class="max-w-screen-xl px-2 mx-auto w-full py-2 md:py-2">
        <!-- konten container utama -->
        <div class="grid grid-cols-1 gap-10">
            <!-- list dokuemen -->
            <div class="bg-white p-6 md:p-8 rounded-xl shadow-lg border border-gray-200">
                <p class="flex justify-center text-2xl font-bold text-gray-700 mb-2 pb-2">
                    <!-- notes: border-b itu border dibawah teks -->
                    Arsip Dokumen Perencanaan
                <div
                    class="w-full md:w-l h-0.5 mx-auto bg-gradient-to-r from-transparent via-orange-500 to-transparent">
                </div>
                </p>

                <div class="space-y-4 mt-4">
                    @forelse($latestDocuments as $doc)

                    <!-- link to detail halaman -->
                    <a href="/planning-dokumen/{{ $doc->slug }}"
                        class="block border border-gray-300 rounded-lg p-5 transition duration-300 hover:border-orange-400 hover:shadow-xl bg-white group"
                        style="text-decoration: none;">
                        <div class="flex item-start justify-between gap-4">
                            <!-- detail dokumen -->
                            <div class="flex items-start gap-4 flex-grow">
                                <!-- icon file statis -->
                                <div class="bg-blue-100 rounded-lg p-3 flex-none">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-orange-600"
                                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                        stroke-linecap="round" stroke-linejoin="round">
                                        <path d="M14 3v4a1 1 0 0 0 1 1h4" />
                                        <path d="M17 21H7a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h7l5 5v11a2 2 0 0 1-2 2z" />
                                    </svg>
                                </div>

                                <!-- detail dokumen -->
                                <div class="flex-grow space-y-1">
                                    <p
                                        class="text-lg font-bold text-gray-800 line-clamp-2 group-hover:text-orange-600 transition duration-150">
                                        {{ $doc->title }}
                                    </p>

                                    <!-- metadata -->
                                    <div class="flex flex-wrap text-sm text-gray-500 gap-x-4 gap-y-1 mt-1">
                                        <!-- tanggal diupload -->
                                        <div class="flex items-center gap-1">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 stroke-[1.5]"
                                                fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                            </svg>
                                            <span>{{ $doc->created_at->isoFormat('D MMMM Y') }}</span>
                                        </div>

                                        <!-- nama OPD -->
                                        <div class="flex items-center gap-1">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 stroke-[1.5]"
                                                viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                stroke-linecap="round" stroke-linejoin="round">
                                                <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2" />
                                                <circle cx="12" cy="7" r="4" />
                                            </svg>
                                            <span>{{ $doc->opd->name ?? 'OPD Tidak Diketahui' }}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- status dan indikator link -->
                            <div class="flex-none flex items-center gap-2">
                                <div
                                    class="bg-orange-600 text-white rounded-lg px-3 py-2 text-sm font-medium flex items-center gap-1">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 24 24"
                                        fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                        stroke-linejoin="round">
                                        <path d="M14 3v4a1 1 0 0 0 1 1h4" />
                                        <path d="M17 21H7a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h7l5 5v11a2 2 0 0 1-2 2z" />
                                    </svg>
                                    Detail File
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                        stroke-width="1.5" stroke="currentColor" class="size-4">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="m4.5 19.5 15-15m0 0H8.25m11.25 0v11.25"></path>
                                    </svg>
                                </div>
                            </div>
                        </div>
                    </a>

                    <!-- jika menggunakan forelse harus ada logika apabila data kosong -->
                    @empty
                    <div class="bg-gray-100 p-8 text-center rounded-lg text-gray-600">
                        <p>Belum ada dokumen perencanaan yang dipublikasikan saat ini.</p>
                    </div>
                    @endforelse
                </div>
                <footer class="flex pt-4 items-center gap-4">
                    <div class="flex-grow border-b border-yellow-500"></div>
                    <a wire:navigate="" href="/planning-dokumen"
                        class="inline-flex items-center gap-2 border border-slate-200 px-4 py-2 rounded-xl bg-orange-500 hover:bg-orange-600 text-white transition">
                        Selengkapnya
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor" class="size-4">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="m4.5 19.5 15-15m0 0H8.25m11.25 0v11.25">
                            </path>
                        </svg>
                    </a>
                </footer>
            </div>
        </div>
    </section>
</div>