<?php

namespace App\Http\Controllers;

use App\Models\Recipe;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class RecipeController extends Controller
{
    public function index()
    {
        $recipes = Recipe::with('user')->latest()->get();
        return view('backend.recipes.index', compact('recipes'));
    }

    public function create()
    {
        return view('backend.recipes.create');
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

        return redirect()->route('admin.recipes.index')->with('success', 'Resep berhasil ditambahkan.');
    }

    public function show($id)
    {
        $recipe = Recipe::with('user')->findOrFail($id);
        return view('backend.recipes.show', compact('recipe'));
    }

    public function edit(Recipe $recipe)
    {
        return view('backend.recipes.edit', compact('recipe'));
    }

    public function update(Request $request, Recipe $recipe)
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

        if ($request->hasFile('foto')) {
            if ($recipe->foto) {
                Storage::disk('public')->delete($recipe->foto);
            }
            $data['foto'] = $request->file('foto')->store('recipes', 'public');
        }

        $recipe->update($data);

        return redirect()->route('admin.recipes.index')->with('success', 'Resep berhasil diperbarui.');
    }

    public function destroy(Recipe $recipe)
    {
        if ($recipe->foto) {
            Storage::disk('public')->delete($recipe->foto);
        }

        $recipe->delete();

        return redirect()->route('admin.recipes.index')->with('success', 'Resep berhasil dihapus.');
    }

    public function trashed()
    {
        $recipes = Recipe::onlyTrashed()->get();
        return view('backend.recipes.trashed', compact('recipes'));
    }

    public function restore($id)
    {
        $recipe = Recipe::onlyTrashed()->findOrFail($id);
        $recipe->restore();
        return redirect()->route('admin.recipes.index')->with('success', 'Resep berhasil direstore.');
    }
}
