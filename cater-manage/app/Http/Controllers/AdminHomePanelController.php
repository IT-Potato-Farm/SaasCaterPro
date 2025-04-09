<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\HomePageContent;

class AdminHomePanelController extends Controller
{
    public function index()
    {
        $HomePageContents = HomePageContent::paginate(1); 
        return view('admin.home-panel.index', compact('HomePageContents'));

    }

    public function edit($id)
    {
        $HomePageContents = HomePageContent::findOrFail($id);
        return view('admin.home-panel.edit', compact('HomePageContents'));
    }
    
    public function update(Request $request, $id)
    {
    
    $validated = $request->validate([
        'title' => 'nullable|string',
        'heading' => 'nullable|string',
        'description' => 'nullable|string',
        'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048', 
        'background_color' => 'nullable|string',
        'text_color' => 'nullable|string',
        'button_text_1_color' => 'nullable|string',
        'button_color_1' => 'nullable|string',
        'button_text_2_color' => 'nullable|string',
        'button_color_2' => 'nullable|string',
    ]);
 
    $HomePageContents = HomePageContent::findOrFail($id);

    $HomePageContents->title = $validated['title'] ?? $HomePageContents->title;
    $HomePageContents->heading = $validated['heading'] ?? $HomePageContents->heading;
    $HomePageContents->description = $validated['description'] ?? $HomePageContents->description;
    $HomePageContents->background_color = $validated['background_color'] ?? $HomePageContents->background_color;
    $HomePageContents->text_color = $validated['text_color'] ?? $HomePageContents->text_color;
    $HomePageContents->button_text_1_color = $validated['button_text_1_color'] ?? $HomePageContents->button_text_1_color;
    $HomePageContents->button_color_1 = $validated['button_color_1'] ?? $HomePageContents->button_color_1;
    $HomePageContents->button_text_2_color = $validated['button_text_2_color'] ?? $HomePageContents->button_text_2_color;
    $HomePageContents->button_color_2 = $validated['button_color_2'] ?? $HomePageContents->button_color_2;

    if ($request->hasFile('image')) {
       
        if ($HomePageContents->image) {
            $oldImagePath = public_path('images/' . $HomePageContents->image);
            if (file_exists($oldImagePath)) {
                unlink($oldImagePath); 
            }
        }

        $imagePath = $request->file('image')->getClientOriginalName();
        $request->file('image')->move(public_path('images'), $imagePath);
        $HomePageContents->image = $imagePath;
        
    }

    $HomePageContents->save();

    return redirect()->back()->with('success', 'Section updated successfully!');
    }
}
