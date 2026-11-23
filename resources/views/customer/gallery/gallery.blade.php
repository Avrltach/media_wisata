@extends('customer.layouts.app')

@section('title', 'Galeri — Media Wisata')
@section('meta_description', 'Galeri foto kegiatan Media Wisata — dokumentasi trip dan event.')

@section('content')
    @include('customer.gallery.section.hero')
    @include('customer.gallery.section.grid')
@endsection