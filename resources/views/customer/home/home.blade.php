@extends('customer.layouts.app', ['isHome' => true])

@section('title', 'Media Wisata — Travel Lokal Banyumas')
@section('meta_description', 'Media Wisata — Travel agent lokal Banyumas. Paket wisata, sewa transport, dan event organizer.')

@section('content')
    @include('customer.home.section.hero')
    @include('customer.home.section.stats')
    @include('customer.home.section.about')
    @include('customer.home.section.packages')
    @include('customer.home.section.gallery')
    @include('customer.home.section.testimonials')
    @include('customer.home.section.faq')
    @include('customer.home.section.cta')
@endsection