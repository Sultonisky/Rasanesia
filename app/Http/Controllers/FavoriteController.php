<?php

namespace App\Http\Controllers;

use App\Models\Favorite;
use App\Models\Recipe;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FavoriteController extends Controller
{
    public function index()
    {
        $favorites = Auth::user()->favoriteRecipes()->with('user')->get();
        return view('frontend.archive.favorite', compact('favorites'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'recipe_id' => 'required|exists:recipes,id'
        ]);

        $userId = Auth::id();
        $recipeId = $request->recipe_id;

        // Check if already favorited
        $existingFavorite = Favorite::where('user_id', $userId)
            ->where('recipe_id', $recipeId)
            ->first();

        if ($existingFavorite) {
            return response()->json([
                'success' => false,
                'message' => 'Resep sudah ada di favorit'
            ]);
        }

        Favorite::create([
            'user_id' => $userId,
            'recipe_id' => $recipeId
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Resep berhasil ditambahkan ke favorit'
        ]);
    }

    public function destroy(Request $request)
    {
        $request->validate([
            'recipe_id' => 'required|exists:recipes,id'
        ]);

        $userId = Auth::id();
        $recipeId = $request->recipe_id;

        $favorite = Favorite::where('user_id', $userId)
            ->where('recipe_id', $recipeId)
            ->first();

        if (!$favorite) {
            return response()->json([
                'success' => false,
                'message' => 'Resep tidak ditemukan di favorit'
            ]);
        }

        $favorite->delete();

        return response()->json([
            'success' => true,
            'message' => 'Resep berhasil dihapus dari favorit'
        ]);
    }

    public function toggle(Request $request)
    {
        $request->validate([
            'recipe_id' => 'required|exists:recipes,id'
        ]);

        $userId = Auth::id();
        $recipeId = $request->recipe_id;

        $favorite = Favorite::where('user_id', $userId)
            ->where('recipe_id', $recipeId)
            ->first();

        if ($favorite) {
            $favorite->delete();
            $isFavorited = false;
            $message = 'Resep dihapus dari favorit';
        } else {
            Favorite::create([
                'user_id' => $userId,
                'recipe_id' => $recipeId
            ]);
            $isFavorited = true;
            $message = 'Resep ditambahkan ke favorit';
        }

        return response()->json([
            'success' => true,
            'is_favorited' => $isFavorited,
            'message' => $message
        ]);
    }

    public function check(Request $request)
    {
        $request->validate([
            'recipe_id' => 'required|exists:recipes,id'
        ]);

        $userId = Auth::id();
        $recipeId = $request->get('recipe_id');

        $isFavorited = Favorite::where('user_id', $userId)
            ->where('recipe_id', $recipeId)
            ->exists();

        return response()->json([
            'is_favorited' => $isFavorited
        ]);
    }
}
