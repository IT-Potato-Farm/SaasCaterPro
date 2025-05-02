<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Utility;
use Illuminate\Support\Facades\Storage;

class UtilityController extends Controller
{
    public function index()
    {
        // $utilities = Utility::all();
        // return view('utilities.index', compact('utilities'));
    }

    public function create()
    {
        // return view('utilities.create');
    }

    public function store(Request $request)
    {
        try {
            $fields = $request->validate([
                'name'        => 'required|string|unique:utilities,name|max:255',
                'description' => 'nullable|string',
                'quantity'    => 'required|integer|min:1',
                'image'       => 'nullable|image|mimes:jpeg,png,jpg,gif|max:10240',
                'package_ids' => 'nullable|array', 
                'package_ids.*' => 'exists:packages,id', 
            ]);

            

            if ($request->hasFile('image')) {
                $fields['image'] = $this->handleImageUpload($request->file('image'));
            }

            $utility = Utility::create($fields);
            if ($request->has('package_ids') && is_array($request->package_ids)) {
                $utility->packages()->sync($request->package_ids);
            } else {
                // IF WALA, REMOVE NYAA
                $utility->packages()->detach();
            }
            
            return response()->json([
                'success' => true,
                'message' => 'Utility added successfully!',
                'utility' => $utility,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    protected function handleImageUpload($image)
    {
        return basename($image->store('utilities', 'public'));
    }

    public function show(string $id)
    {
        //
    }

    public function edit(string $id)
    {
        //
    }

    public function update(Request $request, string $id)
    {
        try {
            $utility = Utility::findOrFail($id);

            $data = $request->validate([
                'name'        => 'required|string|max:255|unique:utilities,name,' . $utility->id,
                'description' => 'nullable|string',
                'quantity'    => 'required|integer|min:1',
                'image'       => 'nullable|image|mimes:jpeg,png,jpg,gif|max:10240',
                'package_ids' => 'nullable|array', 
                'package_ids.*' => 'exists:packages,id', 
            ]);
            
            

            if ($request->hasFile('image')) {
                if ($utility->image && Storage::disk('public')->exists('utilities/' . $utility->image)) {
                    Storage::disk('public')->delete('utilities/' . $utility->image);
                }
                $data['image'] = basename($request->file('image')->store('utilities', 'public'));
            }

            $utility->update($data);
            // IF PROVIDED, PEDE AGAD ICONNECT SA PIVOT TABLE (PACKAGE UTILS)
            if ($request->has('package_ids') && is_array($request->package_ids)) {
                $utility->packages()->sync($request->package_ids);
            } else {
                // IF WALA, REMOVE NYAA
                $utility->packages()->detach();
            }

            session()->flash('success', 'Utility updated successfully!');
            return back();
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    public function destroy(string $id)
    {
        try {
            $utility = Utility::findOrFail($id);

            if ($utility->image && Storage::disk('public')->exists('utilities/' . $utility->image)) {
                Storage::disk('public')->delete('utilities/' . $utility->image);
            }

            $utility->delete();

            session()->flash('success', 'Utility deleted successfully!');
            return back();
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], 500);
        }
    }
}
