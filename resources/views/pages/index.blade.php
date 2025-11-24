@php
$news = App\Models\News::whereNotNull('published_at')->orderBy('published_at', 'desc')->limit(4)->get();
$documents = App\Models\PlanningDocument::orderBy('published_at', 'desc')->limit(3)->get();
$services = App\Models\Service::orderBy('published_at', 'desc')->limit(3)->get();
$services = App\Models\Service::orderBy('published_at', 'desc')->limit(3)->get();
@endphp

@extends('layouts.app', ['activePage' => 'beranda'])

@section('content')
<x-sections.berita :news="$news" />
<x-sections.planning-dokumen :documents="$documents" />
@endsection