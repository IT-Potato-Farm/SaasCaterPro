<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HomePageController extends Controller
{
    public function showHomePage()
    {
        $navbar = DB::table('home_page_content')->where('section_name', 'navbar')->first();
        $hero = DB::table('home_page_content')->where('section_name', 'hero')->first();
        $menu = DB::table('home_page_content')->where('section_name', 'menu')->first();
        $whyChooseUs = DB::table('home_page_content')->where('section_name', 'why-choose-us')->first();
        $rating = DB::table('home_page_content')->where('section_name', 'rating')->first();
        $aboutUs = DB::table('home_page_content')->where('section_name', 'about-us')->first();
        $footer = DB::table('home_page_content')->where('section_name', 'footer')->first();

        return view('home-content', [
            'navbar' => $navbar, 'hero' => $hero, 'menu' => $menu, 'whyChooseUs' =>$whyChooseUs, 'rating' => $rating, 'aboutUs' => $aboutUs, 'footer' => $footer
        ]);
    }
}
