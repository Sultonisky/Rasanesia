<?php

namespace App\Http\Controllers;

use App\Models\Recipe;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class FrontendRecipeController extends Controller
{
    public function create()
    {
        return view('frontend.recipes.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required',
            'ingredients' => 'required',
            'steps' => 'required',
            'province' => 'nullable',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg|max:2048'
        ]);

        $data = $request->except('foto');
        $data['user_id'] = Auth::id();

        if ($request->hasFile('foto')) {
            $data['foto'] = $request->file('foto')->store('recipes', 'public');
        }

        Recipe::create($data);

        return redirect()->route('main-home')->with('success', 'Resep berhasil ditambahkan!');
    }

    public function edit(Recipe $recipe)
    {
        // Pastikan user hanya bisa edit resepnya sendiri
        if ($recipe->user_id !== Auth::id()) {
            abort(403, 'Anda tidak memiliki akses untuk mengedit resep ini.');
        }

        return view('frontend.recipes.edit', compact('recipe'));
    }

    public function update(Request $request, Recipe $recipe)
    {
        // Pastikan user hanya bisa update resepnya sendiri
        if ($recipe->user_id !== Auth::id()) {
            abort(403, 'Anda tidak memiliki akses untuk mengupdate resep ini.');
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required',
            'ingredients' => 'required',
            'steps' => 'required',
            'province' => 'nullable',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg|max:2048'
        ]);

        $data = $request->except('foto');

        if ($request->hasFile('foto')) {
            if ($recipe->foto) {
                Storage::disk('public')->delete($recipe->foto);
            }
            $data['foto'] = $request->file('foto')->store('recipes', 'public');
        }

        $recipe->update($data);

        return redirect()->route('my-recipes')->with('success', 'Resep berhasil diperbarui!');
    }

    public function destroy(Recipe $recipe)
    {
        // Pastikan user hanya bisa hapus resepnya sendiri
        if ($recipe->user_id !== Auth::id()) {
            abort(403, 'Anda tidak memiliki akses untuk menghapus resep ini.');
        }

        if ($recipe->foto) {
            Storage::disk('public')->delete($recipe->foto);
        }

        $recipe->delete();

        return redirect()->route('my-recipes')->with('success', 'Resep berhasil dihapus!');
    }

    public function myRecipes()
    {
        $recipes = Recipe::where('user_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->paginate(12);
            
        return view('frontend.archive.my-recipes', compact('recipes'));
    }
} 