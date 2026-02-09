@php
// Ambil semua layanan yang sudah dipublish
$services = App\Models\Service::with('opd')->whereNotNull('published_at')->latest()->paginate(10);
@endphp

@extends('layouts.app', ['activePage' => 'Layanan'])

@section('content')
<div class="max-w-screen-lg mx-auto w-full">
    <section class="max-w-screen-xl px-4 mx-auto w-full py-12 md:py-16">

        <!-- Header Halaman  -->
        <div class="pt-4 mb-10 border-b border-gray-300 pb-3">
            <p class="text-4xl font-medium text-slate-800">
                Daftar Layanan
            </p>
        </div>

        <!-- List Layanan tersedia -->
        <div class="grid grid-cols-1 gap-10">

            <div class="bg-white p-6 md:p-8 rounded-xl shadow-lg border border-gray-200">
                <p class="text-2xl font-semibold text-gray-700 mb-6 border-b pb-4">
                    Layanan Tersedia
                </p>

                <div class="space-y-4">
                    @forelse ($services as $service)

                    <!-- kotak pembungkus content -->
                    <a href="/layanan/{{ $service->id }}"
                        class="block border border-gray-200 rounded-lg p-4 hover:shadow-md transition bg-white group"
                        style="text-decoration: none;">

                        <div class="flex items-start justify-between gap-4">

                            <!-- berada di kiri -->
                            <div class="flex items-start gap-4 flex-grow">
                                <div class="bg-blue-100 rounded-lg p-3 flex-none">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-orange-600"
                                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                        <path d="M12 20h9" />
                                        <path d="M12 4h9" />
                                        <path d="M4 9h16" />
                                        <path d="M4 15h16" />
                                    </svg>
                                </div>

                                <div class="flex-grow space-y-1">
                                    <p class="text-lg font-bold text-gray-800 group-hover:text-blue-600">
                                        {{ $service->name }}
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
                                            <span>{{ $service->created_at->isoFormat('D MMMM Y') }}</span>
                                        </div>

                                        <!-- OPD -->
                                        <div class="flex items-center gap-1">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 stroke-[1.5]"
                                                viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                stroke-linecap="round" stroke-linejoin="round">
                                                <path d="M3 21v-2a4 4 0 0 1 4-4h10a4 4 0 0 1 4 4v2" />
                                                <circle cx="12" cy="7" r="4" />
                                            </svg>
                                            <span>{{ $service->opd->name ?? 'OPD Tidak Diketahui' }}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- berada di kanan -->
                            <div class="flex items-center">
                                <span class="bg-blue-600 text-white rounded-lg px-3 py-2 text-sm">
                                    Detail
                                </span>
                            </div>

                        </div>
                    </a>

                    @empty
                    <div class="bg-gray-100 p-8 text-center rounded-lg text-gray-600">
                        Tidak ada layanan yang tersedia.
                    </div>
                    @endforelse
                </div>

                <!-- pagination -->
                @if ($services->hasPages())
                <div class="pt-6 border-t mt-6">
                    {{ $services->links() }}
                </div>
                @endif
            </div>
        </div>
    </section>
</div>
@endsection