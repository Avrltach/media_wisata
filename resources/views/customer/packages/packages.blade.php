@extends('customer.layouts.app')

@section('title', 'Paket Wisata — Media Wisata')
@section('meta_description', 'Daftar paket wisata, event organizer, dan sewa transport dari Media Wisata.')

@section('content')
    @include('customer.packages.section.hero')
    @include('customer.packages.section.list')
@endsection