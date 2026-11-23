@extends('adminlte::auth.login')

{{-- Override CSS untuk branding Media Wisata --}}
@push('adminlte_css')
<style>
    body.login-page {
        background: linear-gradient(135deg, #EB3238 0%, #FFF112 100%) !important;
        min-height: 100vh;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    .login-box {
        width: 400px;
        margin: 0 auto;
    }
    .login-logo {
        margin-bottom: 25px;
    }
    .login-logo b {
        color: #fff !important;
        font-size: 28px;
        text-shadow: 0 2px 4px rgba(0,0,0,0.2);
    }
    .login-card-body {
        border-radius: 12px;
        box-shadow: 0 15px 35px rgba(0,0,0,0.2);
        padding: 30px;
    }
    .login-card-body .login-box-msg {
        margin-bottom: 20px;
        font-weight: 600;
        color: #0C0F14;
    }
    .btn-primary {
        background-color: #EB3238 !important;
        border-color: #EB3238 !important;
        font-weight: 600;
    }
    .btn-primary:hover {
        background-color: #c9282e !important;
        border-color: #c9282e !important;
    }
    .input-group-text {
        background-color: #FFF8E7 !important;
        border-color: #EB3238 !important;
        color: #EB3238 !important;
    }
    .form-control:focus {
        border-color: #EB3238 !important;
        box-shadow: 0 0 0 0.2rem rgba(235, 50, 56, 0.25) !important;
    }
</style>
@endpush

{{-- Logo & judul --}}
@section('auth_title', '<b>Media</b> Wisata Admin')
@section('auth_logo', asset('images/logo-media-wisata.png'))

{{-- Form action ke route admin.login.post --}}
@section('login_url', route('admin.login.post'))
@section('login_method', 'POST')

{{-- Pesan selamat datang di login box --}}
@section('login_box_msg', 'Silakan masuk untuk mengakses panel admin')

{{-- Sembunyikan link register (admin tidak bisa registrasi mandiri) --}}
@section('register_link', '')

{{-- Sembunyikan link "lupa password" untuk sementara (bisa di-enable nanti) --}}
@section('forgot_password_link', '')

@push('adminlte_js')
<script>
    // Auto-focus ke field email
    document.addEventListener('DOMContentLoaded', function() {
        const emailInput = document.querySelector('input[type="email"]');
        if (emailInput) emailInput.focus();
    });
</script>
@endpush