@props(['documents'])

@php
$latestDocuments = $documents->sortByDesc('published_at')->take(3);

$opdName = $latestDocuments->first()?->opd?->name ?? 'Instansi';
@endphp

<div class="max-w-screen-lg mx-auto w-full">
    <section class="max-w-screen-xl px-4 mx-auto w-full py-2 md:py-4">
        <!-- header halaman -->
        <div class="pt-4 mb-2 border-gray-300 pb-3">
            <p class="text-2xl md:text-2xl font-medium text-slate-700">Dokumen Perencanaan {{$opdName}}</p>
        </div>

        <!-- konten container utama -->
        <div class="grid grid-cols-1 gap-10">
            <!-- list dokuemen -->
            <div class="bg-white p-6 md:p-8 rounded-xl shadow-lg border border-gray-200">
                <p class="text-2xl font-semibold text-gray-700 mb-6 border-b pb-4">
                    <!-- border-b memberikan garis dibawah teks -->
                    Arsip Dokumen Perencanaan
                </p>

                <div class="space-y-4">
                    @forelse($latestDocuments as $doc)

                    <!-- link to detail halaman -->
                    <a href="/planning-dokumen/{{ $doc->slug }}"
                        class="block border border-gray-200 rounded-lg p-4 transition duration-300 hover:border-blue-400 bg-white group"
                        style="text-decoration: none;">
                        <div class="flex item-start justify-between gap-4">
                            <!-- detail dokumen -->
                            <div class="flex items-start gap-4 flex-grow">
                                <!-- icon file statis -->
                                <div class="bg-blue-100 rounded-lg p-3 flex-none">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-blue-600"
                                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                        stroke-linecap="round" stroke-linejoin="round">
                                        <path d="M14 3v4a1 1 0 0 0 1 1h4" />
                                        <path d="M17 21H7a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h7l5 5v11a2 2 0 0 1-2 2z" />
                                    </svg>
                                </div>

                                <!-- detail dokumen -->
                                <div class="flex-grow space-y-1">
                                    <p
                                        class="text-lg font-bold text-gray-800 line-clamp-2 group-hover:text-blue-600 transition duration-150">
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
                                    class="bg-blue-600 text-white rounded-lg px-3 py-2 text-sm font-medium flexitems-center gap-1">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 24 24"
                                        fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                        stroke-linejoin="round">
                                        <path d="M14 3v4a1 1 0 0 0 1 1h4" />
                                        <path d="M17 21H7a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h7l5 5v11a2 2 0 0 1-2 2z" />
                                    </svg>
                                    Detail File
                                </div>

                                <!-- tombol panah link -->
                                <div class="hidden md:block">
                                    <svg xmlns="http://www.w3.org/2000/svg"
                                        class="h-6 w-6 text-blue-500 group-hover:translate-x-1 transition duration-150"
                                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                        stroke-linecap="round" stroke-linejoin="round">
                                        <path d="M5 12h14M12 5l7 7-7 7" />
                                    </svg>
                                </div>
                            </div>
                        </div>
                    </a>
                    <!-- jika menggunakan forelse harus ada logika apabila data kosong -->
                    @empty
                    <div class="bg-gray-100 p-8 text-center rounded-lg text-gray-600">
                        <p>Tidak ada dokumen perencanaan yang ditemukan saat ini.</p>
                    </div>
                    @endforelse
                </div>
            </div>
        </div>
    </section>
</div>


<!-- section percobaan -->
<!-- <section id="file">
    <div class="w-full p-4 py-12">
        <div class="w-full md:max-w-6xl mx-auto space-y-8">
            <div class="w-full flex justify-center">
                <div class="space-y-2 text-center">
                    <h1 class="text-3xl font-bold text-emerald-500">
                        Publikasi Dokumen
                    </h1>
                    <h3 class="text-xl">
                        Publikasi Dokumen Kinerja Pemerintah
                    </h3>
                    <div
                        class="w-full md:w-xl h-0.5 mx-auto bg-gradient-to-r from-transparent via-emerald-500 to-transparent">
                    </div>
                </div>
            </div>
            <section class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div class="overflow-hidden flex items-center gap-4 shadow rounded-xl bg-white hover:shadow-md">
                    <div
                        class="aspect-3/4 w-32 h-full flex items-center justify-center overflow-hidden rounded-xl shrink-0 bg-slate-200">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor" class="size-10 text-emerald-500">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M19.5 14.25v-2.625a3.375 3.375 0 0 0-3.375-3.375h-1.5A1.125 1.125 0 0 1 13.5 7.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 0 0-9-9Z">
                            </path>
                        </svg>
                    </div>
                    <div class="p-4 space-y-2">
                        <h3 class="text-sm text-slate-500 line-clamp-1">
                            Rabu, 17 Desember 2025
                        </h3>
                        <h1 class="line-clamp-3">
                            PENGUMUMAN HASIL UJI KELAYAKAN DAN KEPATUTAN SELEKSI CALON DIREKSI PT.BUMI MERANTI
                            (PERSERODA) KABUPATEN KEPULAUAN MERANTI
                        </h1>
                        <div class="flex justify-start">
                            <a wire:navigate=""
                                href="https://merantikab.go.id/publikasi-dokumen/pengumuman-hasil-uji-kelayakan-dan-kepatutan-seleksi-calon-direksi-ptbumi-meranti-perseroda-kabupaten-kepulauan-meranti"
                                class="inline-flex items-center gap-2 px-3 py-1 border border-slate-200 rounded-xl text-slate-700 bg-white hover:bg-emerald-500 hover:text-white transition">
                                Selengkapnya
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke-width="1.5" stroke="currentColor" class="size-4">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="m4.5 19.5 15-15m0 0H8.25m11.25 0v11.25"></path>
                                </svg>
                            </a>
                        </div>
                    </div>
                </div>
                <div class="overflow-hidden flex items-center gap-4 shadow rounded-xl bg-white hover:shadow-md">
                    <div
                        class="aspect-3/4 w-32 h-full flex items-center justify-center overflow-hidden rounded-xl shrink-0 bg-slate-200">
                        <img src="https://admin.merantikab.go.id/storage/file-file/2025/12/01KC342WJM8Q6SR1EAWGXF3ZYM.png"
                            alt="image"
                            class="w-full h-full object-cover transition duration-300 ease-in-out hover:scale-110">
                    </div>
                    <div class="p-4 space-y-2">
                        <h3 class="text-sm text-slate-500 line-clamp-1">
                            Rabu, 10 Desember 2025
                        </h3>
                        <h1 class="line-clamp-3">
                            LOGO HUT-17 KABUPATEN KEPULAUAN MERANTI 2025
                        </h1>
                        <div class="flex justify-start">
                            <a wire:navigate=""
                                href="https://merantikab.go.id/publikasi-dokumen/logo-hut-17-kabupaten-kepulauan-meranti-2025"
                                class="inline-flex items-center gap-2 px-3 py-1 border border-slate-200 rounded-xl text-slate-700 bg-white hover:bg-emerald-500 hover:text-white transition">
                                Selengkapnya
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke-width="1.5" stroke="currentColor" class="size-4">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="m4.5 19.5 15-15m0 0H8.25m11.25 0v11.25"></path>
                                </svg>
                            </a>
                        </div>
                    </div>
                </div>
                <div class="overflow-hidden flex items-center gap-4 shadow rounded-xl bg-white hover:shadow-md">
                    <div
                        class="aspect-3/4 w-32 h-full flex items-center justify-center overflow-hidden rounded-xl shrink-0 bg-slate-200">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor" class="size-10 text-emerald-500">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M19.5 14.25v-2.625a3.375 3.375 0 0 0-3.375-3.375h-1.5A1.125 1.125 0 0 1 13.5 7.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 0 0-9-9Z">
                            </path>
                        </svg>
                    </div>
                    <div class="p-4 space-y-2">
                        <h3 class="text-sm text-slate-500 line-clamp-1">
                            Senin, 17 November 2025
                        </h3>
                        <h1 class="line-clamp-3">
                            Tahapan Persentasi Makalah Dan Wawancara Calon Direksi Bumd Pt.bumi Meranti
                        </h1>
                        <div class="flex justify-start">
                            <a wire:navigate=""
                                href="https://merantikab.go.id/publikasi-dokumen/tahapan-persentasi-makalah-dan-wawancara-calon-direksi-bumd-ptbumi-meranti"
                                class="inline-flex items-center gap-2 px-3 py-1 border border-slate-200 rounded-xl text-slate-700 bg-white hover:bg-emerald-500 hover:text-white transition">
                                Selengkapnya
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke-width="1.5" stroke="currentColor" class="size-4">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="m4.5 19.5 15-15m0 0H8.25m11.25 0v11.25"></path>
                                </svg>
                            </a>
                        </div>
                    </div>
                </div>
                <div class="overflow-hidden flex items-center gap-4 shadow rounded-xl bg-white hover:shadow-md">
                    <div
                        class="aspect-3/4 w-32 h-full flex items-center justify-center overflow-hidden rounded-xl shrink-0 bg-slate-200">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor" class="size-10 text-emerald-500">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M19.5 14.25v-2.625a3.375 3.375 0 0 0-3.375-3.375h-1.5A1.125 1.125 0 0 1 13.5 7.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 0 0-9-9Z">
                            </path>
                        </svg>
                    </div>
                    <div class="p-4 space-y-2">
                        <h3 class="text-sm text-slate-500 line-clamp-1">
                            Kamis, 13 November 2025
                        </h3>
                        <h1 class="line-clamp-3">
                            Pengumuman Seleksi Internet Service Provider Tahun Anggaran 2026
                        </h1>
                        <div class="flex justify-start">
                            <a wire:navigate=""
                                href="https://merantikab.go.id/publikasi-dokumen/pengumuman-seleksi-internet-service-provider-tahun-anggaran-2026"
                                class="inline-flex items-center gap-2 px-3 py-1 border border-slate-200 rounded-xl text-slate-700 bg-white hover:bg-emerald-500 hover:text-white transition">
                                Selengkapnya
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke-width="1.5" stroke="currentColor" class="size-4">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="m4.5 19.5 15-15m0 0H8.25m11.25 0v11.25"></path>
                                </svg>
                            </a>
                        </div>
                    </div>
                </div>
                <div class="overflow-hidden flex items-center gap-4 shadow rounded-xl bg-white hover:shadow-md">
                    <div
                        class="aspect-3/4 w-32 h-full flex items-center justify-center overflow-hidden rounded-xl shrink-0 bg-slate-200">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor" class="size-10 text-emerald-500">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M19.5 14.25v-2.625a3.375 3.375 0 0 0-3.375-3.375h-1.5A1.125 1.125 0 0 1 13.5 7.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 0 0-9-9Z">
                            </path>
                        </svg>
                    </div>
                    <div class="p-4 space-y-2">
                        <h3 class="text-sm text-slate-500 line-clamp-1">
                            Kamis, 23 Oktober 2025
                        </h3>
                        <h1 class="line-clamp-3">
                            Pengumuman Perpanjangan Jadwal Seleksi Calon Direksi Pt. Bumi Meranti (Perseroda) Kabupaten
                            Kepulauan Meranti
                        </h1>
                        <div class="flex justify-start">
                            <a wire:navigate=""
                                href="https://merantikab.go.id/publikasi-dokumen/pengumuman-perpanjangan-jadwal-seleksi-calon-direksi-pt-bumi-meranti-perseroda-kabupaten-kepulauan-meranti"
                                class="inline-flex items-center gap-2 px-3 py-1 border border-slate-200 rounded-xl text-slate-700 bg-white hover:bg-emerald-500 hover:text-white transition">
                                Selengkapnya
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke-width="1.5" stroke="currentColor" class="size-4">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="m4.5 19.5 15-15m0 0H8.25m11.25 0v11.25"></path>
                                </svg>
                            </a>
                        </div>
                    </div>
                </div>
                <div class="overflow-hidden flex items-center gap-4 shadow rounded-xl bg-white hover:shadow-md">
                    <div
                        class="aspect-3/4 w-32 h-full flex items-center justify-center overflow-hidden rounded-xl shrink-0 bg-slate-200">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor" class="size-10 text-emerald-500">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M19.5 14.25v-2.625a3.375 3.375 0 0 0-3.375-3.375h-1.5A1.125 1.125 0 0 1 13.5 7.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 0 0-9-9Z">
                            </path>
                        </svg>
                    </div>
                    <div class="p-4 space-y-2">
                        <h3 class="text-sm text-slate-500 line-clamp-1">
                            Rabu, 5 November 2025
                        </h3>
                        <h1 class="line-clamp-3">
                            Hasil Seleksi Administrasi Calon Direksi Bumd Pt.bumi Meranti
                        </h1>
                        <div class="flex justify-start">
                            <a wire:navigate=""
                                href="https://merantikab.go.id/publikasi-dokumen/hasil-seleksi-administrasi-calon-direksi-bumd-ptbumi-meranti"
                                class="inline-flex items-center gap-2 px-3 py-1 border border-slate-200 rounded-xl text-slate-700 bg-white hover:bg-emerald-500 hover:text-white transition">
                                Selengkapnya
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke-width="1.5" stroke="currentColor" class="size-4">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="m4.5 19.5 15-15m0 0H8.25m11.25 0v11.25"></path>
                                </svg>
                            </a>
                        </div>
                    </div>
                </div>
            </section>
            <footer class="flex items-center gap-4">
                <div class="flex-grow border-b border-emerald-500"></div>
                <a wire:navigate="" href="https://merantikab.go.id/publikasi-dokumen"
                    class="inline-flex items-center gap-2 border border-slate-200 px-4 py-2 rounded-xl bg-emerald-500 hover:bg-emerald-600 text-white transition">
                    Selengkapnya
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="currentColor" class="size-4">
                        <path stroke-linecap="round" stroke-linejoin="round" d="m4.5 19.5 15-15m0 0H8.25m11.25 0v11.25">
                        </path>
                    </svg>
                </a>
            </footer>
        </div>
    </div>
</section> -->