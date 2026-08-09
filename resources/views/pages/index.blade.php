@php
$opdSlug = env('APP_ID');
$opd = App\Models\Opd::where('slug', $opdSlug)->first();

$opdId = $opd?->id;

// Filter seluruh data berdasarkan opd_id dan ambil yang paling baru (latest)
$announcement = App\Models\Announcement::where('opd_id', $opdId)->latest()->take(4)->get();
$news = App\Models\News::where('opd_id', $opdId)->with(['opd', 'category'])->latest()->take(5)->get();
$documents = App\Models\PlanningDocument::where('opd_id', $opdId)->with(['opd', 'category'])->latest()->take(3)->get();
$services = App\Models\Service::where('opd_id', $opdId)->latest()->take(6)->get();
$galleries = App\Models\Galleries::where('opd_id', $opdId)->latest()->take(6)->get();
@endphp

@extends('layouts.app', ['activePage' => 'beranda'])

@section('content')
<!-- mendaftarkan halaman section agar tampil -->
<x-sections.hero />
<x-sections.pengumuman :announcement="$announcement" />
<x-sections.berita :news="$news" />
<x-sections.planning-dokumen :documents="$documents" />
<x-sections.layanan :services="$services" />
<x-sections.galeri :galleries="$galleries" />
@endsection