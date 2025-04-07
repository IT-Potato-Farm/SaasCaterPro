<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminHomePanelController extends Controller
{
    public function index()
    {
        $content = DB::table('home_page_content')->get();
        return view('admin.home-panel.index', compact('content'));

    }

    Public function update(Request $request, $section)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'logo' => 'nullable|image|mimes:jpg,png,jpeg,gif|max:2048',
        ]);

        
        if ($request->hasFile('logo')) {
            $logoPath = $request->file('logo')->store('logos', 'public');
        } else {
            $logoPath = $request->input('existing_logo');  // Keep the existing logo if no new logo is uploaded
        }

        // Update the content in the database
        DB::table('home_page_content')
            ->where('section_name', $section)
            ->update([
                'content' => $request->input('title'),
                'image' => $logoPath,
            ]);

        return redirect()->route('admin.home-panel.index')->with('success', 'Content updated successfully.');
    }
    
}
