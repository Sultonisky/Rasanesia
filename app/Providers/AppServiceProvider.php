<?php

namespace App\Providers;

use App\Models\Recipe;
use App\Models\Review;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */

    public function boot()
    {
        View::composer('backend.layouts.navbar', function ($view) {
            $latestRecipes = Recipe::with('user')->latest()->take(3)->get();
            $latestReviews = Review::with(['user', 'recipe'])->latest()->take(3)->get();

            $view->with('alertRecipes', $latestRecipes);
            $view->with('alertReviews', $latestReviews);
        });
    }
}
