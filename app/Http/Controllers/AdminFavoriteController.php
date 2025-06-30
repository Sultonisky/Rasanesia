<?php

namespace App\Http\Controllers;

use App\Models\Favorite;
use App\Models\User;
use App\Models\Recipe;
use Illuminate\Http\Request;

class AdminFavoriteController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $favorites = Favorite::with(['user', 'recipe'])->latest()->get();
        return view('backend.favorites.index', compact('favorites'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $users = User::all();
        $recipes = Recipe::all();
        return view('backend.favorites.create', compact('users', 'recipes'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'recipe_id' => 'required|exists:recipes,id',
        ]);

        // Check if favorite already exists
        $existingFavorite = Favorite::where('user_id', $request->user_id)
            ->where('recipe_id', $request->recipe_id)
            ->first();

        if ($existingFavorite) {
            return redirect()->back()->with('error', 'Favorit ini sudah ada!');
        }

        Favorite::create([
            'user_id' => $request->user_id,
            'recipe_id' => $request->recipe_id,
        ]);

        return redirect()->route('admin.favorites.index')->with('success', 'Favorit berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $favorite = Favorite::with(['user', 'recipe'])->findOrFail($id);
        return view('backend.favorites.show', compact('favorite'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $favorite = Favorite::findOrFail($id);
        $users = User::all();
        $recipes = Recipe::all();
        return view('backend.favorites.edit', compact('favorite', 'users', 'recipes'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'recipe_id' => 'required|exists:recipes,id',
        ]);

        $favorite = Favorite::findOrFail($id);

        // Check if the new combination already exists (excluding current record)
        $existingFavorite = Favorite::where('user_id', $request->user_id)
            ->where('recipe_id', $request->recipe_id)
            ->where('id', '!=', $id)
            ->first();

        if ($existingFavorite) {
            return redirect()->back()->with('error', 'Favorit dengan kombinasi user dan resep ini sudah ada!');
        }

        $favorite->update([
            'user_id' => $request->user_id,
            'recipe_id' => $request->recipe_id,
        ]);

        return redirect()->route('admin.favorites.index')->with('success', 'Favorit berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $favorite = Favorite::findOrFail($id);
        $favorite->delete();

        return redirect()->route('admin.favorites.index')->with('success', 'Favorit berhasil dihapus.');
    }

    public function trashed()
    {
        $favorites = Favorite::onlyTrashed()->get();
        return view('backend.favorites.trashed', compact('favorites'));
    }

    public function restore($id)
    {
        $favorite = Favorite::onlyTrashed()->findOrFail($id);
        $favorite->restore();
        return redirect()->route('admin.favorites.index')->with('success', 'Favorit berhasil direstore.');
    }
}
