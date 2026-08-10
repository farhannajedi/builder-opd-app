@php
$opdSlug = env('APP_ID');
$opd = App\Models\Opd::where('slug', $opdSlug)->first();

$opdId = $opd?->id;

// Layout website
$config = App\Models\OpdConfigs::where('opd_id', $opdId)->first();
$layout = $config?->homepage_layout ?? 'default';

// Filter seluruh data berdasarkan opd_id dan ambil yang paling baru (latest)
$announcement = App\Models\Announcement::where('opd_id', $opdId)->latest()->take(4)->get();
$news = App\Models\News::where('opd_id', $opdId)->with(['opd', 'category'])->latest()->take(5)->get();
$documents = App\Models\PlanningDocument::where('opd_id', $opdId)->with(['opd', 'category'])->latest()->take(3)->get();
$services = App\Models\Service::where('opd_id', $opdId)->latest()->take(6)->get();
$galleries = App\Models\Galleries::where('opd_id', $opdId)->latest()->take(6)->get();
@endphp

@extends('layouts.app', ['activePage' => 'beranda'])

@section('content')
<!-- mendaftarkan halaman section -->
<x-sections.hero />

<!-- Render tampilan layout berdasarkan config -->
@if ($layout === 'service_focus')
<!-- Layout focus layanan -->
<x-sections.layanan :services="$services" />
<x-sections.pengumuman :announcement="$announcement" />
<x-sections.berita :news="$news" />
<x-sections.planning-dokumen :documents="$documents" />
<x-sections.galeri :galleries="$galleries" />

@elseif ($layout === 'news_focus')
<!-- Layout yang fokus pada berita dan informasi -->
<x-sections.berita :news="$news" />
<x-sections.pengumuman :announcement="$announcement" />
<x-sections.layanan :services="$services" />
<x-sections.planning-dokumen :documents="$documents" />
<x-sections.galeri :galleries="$galleries" />

@else
<!-- Layout default -->
<x-sections.pengumuman :announcement="$announcement" />
<x-sections.berita :news="$news" />
<x-sections.planning-dokumen :documents="$documents" />
<x-sections.layanan :services="$services" />
<x-sections.galeri :galleries="$galleries" />
@endif
@endsection