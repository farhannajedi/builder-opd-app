@php
$opdSlug = env('APP_ID');
$opd = App\Models\Opd::where('slug', $opdSlug)->first();

$opdId = $opd?->id;

$announcement = App\Models\Announcement::orderBy('published_at', 'desc')->limit(4)->get();
$news = App\Models\News::orderBy('published_at', 'desc')->limit(4)->get();
$documents = App\Models\PlanningDocument::orderBy('published_at', 'desc')->limit(4)->get();
$services = App\Models\Service::where('opd_id', $opdId)->orderBy('published_at', 'desc')->limit(6)->get();
$galleries = App\Models\Galleries::orderBy('published_at', 'desc')->limit(6)->get();
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