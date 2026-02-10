@php
use App\Models\Opd;

$opd = Opd::find(env('APP_ID'));

$news = App\Models\News::whereNotNull('published_at')->orderBy('published_at', 'desc')->limit(4)->get();
$documents = App\Models\PlanningDocument::orderBy('published_at', 'desc')->limit(4)->get();
$services = App\Models\Service::orderBy('published_at', 'desc')->limit(6)->get();
$galleries = App\Models\Galleries::orderBy('published_at', 'desc')->limit(6)->get();
@endphp

@extends('layouts.app', ['activePage' => 'beranda'])

@section('content')
<x-sections.berita :news="$news" />
<x-sections.planning-dokumen :documents="$documents" />
<x-sections.layanan :services="$services" />
<x-sections.galeri :galleries="$galleries" />
@endsection