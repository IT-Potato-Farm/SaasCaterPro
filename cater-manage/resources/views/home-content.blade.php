@extends('layouts.home-content-layout')

@section('content')

    {{-- {{dd($wcu)}} --}}

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
   
    <x-home-content.hero-content
        :title="$hero->title"
        :heading="$hero->heading"
        :description="$hero->description"
        :tecc="$hero->text_color"
        :bacimg="$hero->image"
    />

    <x-home-content.menu-section-content
        :title="$menu->title"
        :textcolor="$menu->text_color"
        :buttonColor="$menu->button_color_1"
        :buttonTextColor="$menu->button_text_1_color"

    />

    <x-home-content.why-choose-us-content
        :title="$wcu->title"
        :heading="$wcu->heading"
        :description="$wcu->description"
        :textcolor="$wcu->text_color"
    />

    <x-home-content.rating-section-content
        :star="$rating->image"
    />

    <x-home-content.about-us-content
        :title="$au->title" 
        :description="$au->description"
        :textcolor="$au->text_color"
    />

    <x-home-content.footer-content
        :logo="$footer->image"     
        :title="$footer->title"  
        :bacc="$footer->background_color"
        :teccc="$footer->text_color"
    />

@endsection