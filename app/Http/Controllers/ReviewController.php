<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Recipe;
use App\Models\Review;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $reviews = Review::with('recipe', 'user')->get();
        return view('backend.reviews.index', compact('reviews'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $recipes = Recipe::all();
        $users = User::all();
        return view('backend.reviews.create', compact('recipes', 'users'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $vaidateData = $request->validate([
            'recipe_id' => 'required|exists:recipes,id',
            'user_id' => 'required|exists:users,id',
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'required|string|max:255',
        ]);

        Review::create($vaidateData);
        return redirect()->route('reviews.index')->with('success', 'Review berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $review = Review::with('recipe', 'user')->findOrFail($id);
        return view('backend.reviews.show', compact('review'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $review = Review::with('recipe', 'user')->findOrFail($id);
        return view('backend.reviews.edit', compact('review'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validateData = $request->validate([
            'recipe_id' => 'required|exists:recipes,id',
            'user_id' => 'required|exists:users,id',
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'required|string|max:255',
        ]);

        Review::findOrFail($id)->update($validateData);
        return redirect()->route('reviews.index')->with('success', 'Review berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        Review::findOrFail($id)->delete();

        return redirect()->route('reviews.index')->with('success', 'Review berhasil dihapus.');
    }
}
