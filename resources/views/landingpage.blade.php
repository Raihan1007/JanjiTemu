@extends('layouts.app')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/landing.css') }}">
    <link rel="stylesheet" href="{{ asset('css/footerlanding.css') }}">
    <link rel="stylesheet" href="{{ asset('css/footers.css') }}">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
@endpush

@section('content')
    <div class="landing-wrapper">
        @include('components.hero')
        @include('components.cara-kerja')
        @include('components.layanan')
        @include('components.faq')
        @include('components.cta')
        @include('footer.footerlanding')
    </div>
    <script>
        window.addEventListener('scroll', function() {
        const nav = document.querySelector('.logo-nav');
        // Jika scroll lebih dari 50px, tambahkan class 'scrolled'
        if (window.scrollY > 50) {
            nav.classList.add('scrolled');
        } else {
            nav.classList.remove('scrolled');
        }
    });
    </script>

@endsection