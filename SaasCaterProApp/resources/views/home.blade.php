@extends ('layouts.default')

@section ('title')
    SaasCaterPro
@endsection


@section ('body')
    <x-customer.navbar />
    <x-customer.hero/>
    <x-customer.menu-section/>
    {{-- <x-menu-modal /> --}}
    <x-customer.sweet-alert-menu />
    <x-customer.why-choose-us />
    <x-customer.ratingsection/>
    <x-customer.about-us/>
    <x-customer.footer/>
@endsection