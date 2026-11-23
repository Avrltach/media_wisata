@extends('customer.layouts.app')

@section('title', 'Kontak — Media Wisata')
@section('meta_description', 'Hubungi Media Wisata untuk pemesanan paket wisata dan informasi layanan.')

@section('content')
    @include('customer.contact.section.hero')
    @include('customer.contact.section.info')
    @include('customer.contact.section.maps')
    @include('customer.contact.section.cta')
@endsection