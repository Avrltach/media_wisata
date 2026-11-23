@extends('customer.layouts.app')

@section('title', 'Profile — Media Wisata')

@section('content')
    @include('customer.profile.section.hero')
    @include('customer.profile.section.info')
    @include('customer.profile.section.edit-profile')
    @include('customer.profile.section.change-password')
@endsection