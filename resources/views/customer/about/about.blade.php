@extends('customer.layouts.app')

@section('title', 'Tentang Kami — Media Wisata')
@section('meta_description', 'Tentang Media Wisata — perusahaan jasa perjalanan wisata dan transportasi di Banyumas.')

@section('content')
    @include('customer.about.section.hero')
    @include('customer.about.section.profile')
    @include('customer.about.section.faq')
@endsection