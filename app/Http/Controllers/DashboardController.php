<?php

namespace App\Http\Controllers;

use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class DashboardController extends Controller
{


    public function index()
    {
        $recipes = \App\Models\Recipe::select('province')
            ->selectRaw('count(*) as total')
            ->groupBy('province')
            ->orderBy('total', 'desc')
            ->get();

        $latestReviews = Review::with(['user', 'recipe'])
            ->latest()
            ->take(5)
            ->get();

        return view('backend.dashboard.dashboard', [
            'recipesCount'    => \App\Models\Recipe::count(),
            'reviewsCount'    => \App\Models\Review::count(),
            'usersCount'      => \App\Models\User::count(),
            'provinceCount'   => $recipes->count(),
            'provinceNames'   => $recipes->pluck('province'),
            'provinceCounts'  => $recipes->pluck('total'),
            'latestReviews'   => $latestReviews,
        ]);
    }


    public function profile()
    {
        return view('backend.dashboard.profile');
    }

    public function profileUpdate(Request $request)
    {
        $user = Auth::user();

        $validated = $request->validate([
            'name' => 'required|string|max:100',
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:255',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        // Handle Foto
        if ($request->hasFile('foto')) {
            // Hapus foto lama jika ada
            if ($user->foto && Storage::exists($user->foto)) {
                Storage::delete($user->foto);
            }

            // Simpan foto baru
            $validated['foto'] = $request->file('foto')->store('profile_photos', 'public');
        }

        $user->update($validated);

        return back()->with('success', 'Profil berhasil diperbarui.');
    }
}
