@extends('layouts.home-content-layout')

@section('content')

    {{-- {{ dd($navbar)}} --}}

    <x-home-content.navbar-content     
    :title="$navbar->title"
    :logo="$navbar->image"
    :bac="$navbar->background_color"
    :tec="$navbar->text_color"
    :buttonColor1="$navbar->button_color_1"
    :buttonTextColor1="$navbar->button_text_1_color" 
    :buttonColor2="$navbar->button_color_2"
    :buttonTextColor2="$navbar->button_text_2_color"  
    />
   
    {{-- <x-home-content.hero-content
        :title="$hero->title"
        :subtitle="$hero->heading"
        :description="$hero->description"
        :backgroundImage="$hero->image"
    />

    <x-home-content.menu-section-content
        :title="$menu->title"
        :buttonText1="$menu->button_text_1"
        :buttonColor1="$menu->button_color_1"
    />

    <x-home-content.why-choose-us-content
        :title="$whyChooseUs->title"
        :heading="$whyChooseUs->heading"
        :description="$whyChooseUs->description"
        :text_color="$whyChooseUs->text_color"
    />

    <x-home-content.rating-section-content
        :image="$rating->image"
    />

    <x-home-content.about-us-content
        :title="$aboutUs->title" 
        :description="$aboutUs->description"
        :text_color="$aboutUs->text_color"
    />

    <x-home-content.footer-content
        :logo="$footer->logo"     
        :title="$footer->title"  
        :text_color="$footer->text_color"
    /> --}}

@endsection