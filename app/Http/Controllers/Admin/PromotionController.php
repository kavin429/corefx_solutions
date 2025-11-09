<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Promotion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PromotionController extends Controller
{
    /** Show all promotions */
    public function index()
    {
        $promotions = Promotion::latest()->get();
        return view('admin.promotions', compact('promotions'));
    }

    /** Store new promotion */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'nullable|string|max:255',
            'description' => 'nullable|string|max:1000',
            'popup_image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'poster_small' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'poster_medium' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:4096',
            'poster_xmedium' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:4096',
            'poster_large' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:8192',
        ]);

        $data = [];
        foreach (['popup_image', 'poster_small', 'poster_medium', 'poster_xmedium', 'poster_large'] as $field) {
            if ($request->hasFile($field)) {
                $data[$field] = $request->file($field)->store('promotions', 'public');
            }
        }

        Promotion::create([
            'title' => $request->title,
            'description' => $request->description,
            'popup_enabled' => $request->has('popup_enabled'),
            'popup_image' => $data['popup_image'] ?? null,
            'poster_small' => $data['poster_small'] ?? null,
            'poster_medium' => $data['poster_medium'] ?? null,
            'poster_xmedium' => $data['poster_xmedium'] ?? null,
            'poster_large' => $data['poster_large'] ?? null,
        ]);

        return redirect()->back()->with('success', 'Promotion added successfully!');
    }

    /** Public page to show promotions */
    public function show()
    {
        $promotions = Promotion::latest()->get();
        return view('promotion', compact('promotions'));
    }

    public function toggle(Promotion $promotion) {
        $promotion->popup_enabled = !$promotion->popup_enabled;
        $promotion->save();
        return back()->with('success', 'Popup status updated.');
    }

    public function update(Request $request, Promotion $promotion)
    {
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string|max:500',
            'popup_image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'poster_small' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'poster_medium' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:4096',
            'poster_xmedium' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:4096',
            'poster_large' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:8192',
        ]);

        $data['popup_enabled'] = $request->has('popup_enabled');

        foreach (['popup_image', 'poster_small', 'poster_medium', 'poster_xmedium', 'poster_large'] as $field) {
            if ($request->hasFile($field)) {
                if ($promotion->$field) {
                    Storage::disk('public')->delete($promotion->$field);
                }
                $data[$field] = $request->file($field)->store('promotions', 'public');
            } else {
                $data[$field] = $promotion->$field;
            }
        }

        $promotion->update($data);

        return redirect()->back()->with('success', 'Promotion updated successfully.');
    }

    public function destroy(Promotion $promotion)
    {
        // Delete associated files
        foreach (['popup_image', 'poster_small', 'poster_medium', 'poster_xmedium', 'poster_large'] as $field) {
            if ($promotion->$field) {
                Storage::disk('public')->delete($promotion->$field);
            }
        }

        $promotion->delete();
        return back()->with('success', 'Promotion deleted successfully.');
    }
}
