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
        $wcu = DB::table('home_page_content')->where('section_name', 'wcu')->first();
        $rating = DB::table('home_page_content')->where('section_name', 'rating')->first();
        $au = DB::table('home_page_content')->where('section_name', 'au')->first();
        $footer = DB::table('home_page_content')->where('section_name', 'footer')->first();

        return view('home-content', [
            'navbar' => $navbar, 'hero' => $hero, 'menu' => $menu, 'wcu' => $wcu, 'rating' => $rating, 'au' => $au, 'footer' => $footer
        ]);
    }
}
