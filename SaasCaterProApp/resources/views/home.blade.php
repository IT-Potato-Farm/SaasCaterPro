@extends ('layouts.default')

@section ('title')
    SaasCaterPro
@endsection


@section ('body')
    <x-navbar />
    <x-hero/>
    <x-menu-section/>
    {{-- <x-menu-modal /> --}}
    <x-sweet-alert-menu />
    <x-why-choose-us />
    <x-ratingsection/>
    <x-about-us/>
    <x-footer/>

@endsection