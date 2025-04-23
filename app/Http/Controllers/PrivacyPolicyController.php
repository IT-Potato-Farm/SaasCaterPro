<?php

namespace App\Http\Controllers;

use App\Models\PrivacyPolicy;
use Illuminate\Http\Request;

class PrivacyPolicyController extends Controller
{
    public function index()
    {
        $privacyPolicy = PrivacyPolicy::first();
        return view('admin.cms.privacy-policy', compact('privacyPolicy'));
    }
    public function show()
    {
        $privacyPolicy = PrivacyPolicy::first();
        return view('admin.privacy-policy.show', compact('privacyPolicy'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'last_updated' => 'nullable|string',
        ]);

        $privacyPolicy = PrivacyPolicy::first();
        $privacyPolicy->title = $request->input('title');
        $privacyPolicy->content = $request->input('content');
        $privacyPolicy->last_updated = now()->toDateString();
        $privacyPolicy->sections = json_encode([
            'introduction' => $request->input('content'), 
        ]);
        $privacyPolicy->save();

        return redirect()->back()->with('success', 'Privacy Policy updated successfully.');
    }
}
