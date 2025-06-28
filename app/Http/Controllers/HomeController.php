<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Recipe;

class HomeController extends Controller
{
    public function welcome()
    {
        // Ambil 4 resep secara acak yang memiliki foto
        $randomRecipes = Recipe::whereNotNull('foto')
            ->where('foto', '!=', '')
            ->inRandomOrder()
            ->limit(4)
            ->get();

        // Jika tidak ada 4 resep dengan foto, ambil semua resep yang ada
        if ($randomRecipes->count() < 4) {
            $remainingCount = 4 - $randomRecipes->count();
            $additionalRecipes = Recipe::whereNull('foto')
                ->orWhere('foto', '')
                ->inRandomOrder()
                ->limit($remainingCount)
                ->get();
            
            $randomRecipes = $randomRecipes->merge($additionalRecipes);
        }

        // Jika masih kurang dari 4, gunakan gambar default
        $defaultImages = [
            'https://ik.imagekit.io/tvlk/blog/2023/12/batagor-shutterstock.jpg?tr=dpr-1.5',
            'https://blog.tokowahab.com/wp-content/uploads/2023/07/Resep-Bacem-Tahu-Tempe-Bumbunya-Meresap-Sampai-Ke-Dalam.-Simak-di-blog.tokowahab.com_.png',
            'https://asset.kompas.com/crops/13s3VjlTLJDabBTBmmS08XphFVY=/0x0:1000x667/750x500/data/photo/2020/07/30/5f2242077ea7b.jpg',
            'https://www.tagar.id/Asset/uploads2019/1642129532972-resep-nasi-liwet.jpeg'
        ];

        // Pastikan kita selalu punya 4 gambar
        $recipes = [];
        for ($i = 0; $i < 4; $i++) {
            if ($randomRecipes->count() > $i) {
                $recipe = $randomRecipes[$i];
                $recipes[] = [
                    'image' => $recipe->foto ?: $defaultImages[$i],
                    'name' => $recipe->name,
                    'alt' => $recipe->name
                ];
            } else {
                $recipes[] = [
                    'image' => $defaultImages[$i],
                    'name' => 'Resep Tradisional',
                    'alt' => 'Resep Tradisional'
                ];
            }
        }

        return view('frontend.home.welcome', compact('recipes'));
    }

    public function home()
    {
        // Ambil 4 resep secara acak yang memiliki foto
        $randomRecipes = Recipe::whereNotNull('foto')
            ->where('foto', '!=', '')
            ->inRandomOrder()
            ->limit(4)
            ->get();

        // Jika tidak ada 4 resep dengan foto, ambil semua resep yang ada
        if ($randomRecipes->count() < 4) {
            $remainingCount = 4 - $randomRecipes->count();
            $additionalRecipes = Recipe::whereNull('foto')
                ->orWhere('foto', '')
                ->inRandomOrder()
                ->limit($remainingCount)
                ->get();
            
            $randomRecipes = $randomRecipes->merge($additionalRecipes);
        }

        // Jika masih kurang dari 4, gunakan gambar default
        $defaultImages = [
            'https://ik.imagekit.io/tvlk/blog/2023/12/batagor-shutterstock.jpg?tr=dpr-1.5',
            'https://blog.tokowahab.com/wp-content/uploads/2023/07/Resep-Bacem-Tahu-Tempe-Bumbunya-Meresap-Sampai-Ke-Dalam.-Simak-di-blog.tokowahab.com_.png',
            'https://asset.kompas.com/crops/13s3VjlTLJDabBTBmmS08XphFVY=/0x0:1000x667/750x500/data/photo/2020/07/30/5f2242077ea7b.jpg',
            'https://www.tagar.id/Asset/uploads2019/1642129532972-resep-nasi-liwet.jpeg'
        ];

        // Pastikan kita selalu punya 4 gambar
        $recipes = [];
        for ($i = 0; $i < 4; $i++) {
            if ($randomRecipes->count() > $i) {
                $recipe = $randomRecipes[$i];
                $recipes[] = [
                    'image' => $recipe->foto ?: $defaultImages[$i],
                    'name' => $recipe->name,
                    'alt' => $recipe->name
                ];
            } else {
                $recipes[] = [
                    'image' => $defaultImages[$i],
                    'name' => 'Resep Tradisional',
                    'alt' => 'Resep Tradisional'
                ];
            }
        }

        return view('frontend.home.welcome', compact('recipes'));
    }

    public function mainHome()
    {
        // Section 1: 4 latest recipes
        $latestRecipes = Recipe::whereNotNull('foto')
            ->where('foto', '!=', '')
            ->orderBy('created_at', 'desc')
            ->limit(4)
            ->get();

        // Section 2: 4 best-rated recipes (by average rating)
        $bestRatedRecipes = Recipe::withAvg('reviews', 'rating')
            ->whereNotNull('foto')
            ->where('foto', '!=', '')
            ->orderByDesc('reviews_avg_rating')
            ->limit(4)
            ->get();

        // Section 3: group recipes by province (max 2 per province)
        $provinces = Recipe::select('province')->distinct()->pluck('province');
        $recipesByProvince = [];
        foreach ($provinces as $province) {
            $recipesByProvince[$province] = Recipe::where('province', $province)
                ->whereNotNull('foto')
                ->where('foto', '!=', '')
                ->inRandomOrder()
                ->limit(2)
                ->get();
        }

        return view('frontend.home.main-home', [
            'latestRecipes' => $latestRecipes,
            'bestRatedRecipes' => $bestRatedRecipes,
            'recipesByProvince' => $recipesByProvince,
        ]);
    }

    public function profile()
    {
        $user = auth()->user();
        return view('frontend.profile.index', compact('user'));
    }

    public function search(Request $request)
    {
        $query = $request->get('q', '');
        $recipes = collect();
        
        if ($query) {
            $recipes = Recipe::where('name', 'like', "%{$query}%")
                ->orWhere('ingredients', 'like', "%{$query}%")
                ->orWhere('province', 'like', "%{$query}%")
                ->whereNotNull('foto')
                ->where('foto', '!=', '')
                ->get();
        }
        
        return view('frontend.search.index', compact('recipes', 'query'));
    }

    public function allRecipes()
    {
        $recipes = Recipe::whereNotNull('foto')
            ->where('foto', '!=', '')
            ->orderBy('name')
            ->paginate(12);
            
        return view('frontend.recipes.index', compact('recipes'));
    }

    public function archive()
    {
        $recipes = Recipe::whereNotNull('foto')
            ->where('foto', '!=', '')
            ->orderBy('created_at', 'desc')
            ->paginate(12);
            
        return view('frontend.archive.index', compact('recipes'));
    }
}
