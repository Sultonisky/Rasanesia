<?php

namespace App\Imports;

use App\Models\Recipe;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class RecipesImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        // Validasi yang lebih ketat - name tidak boleh null atau kosong
        if (empty(trim($row['name'] ?? '')) || empty(trim($row['ingredients'] ?? '')) || empty(trim($row['steps'] ?? ''))) {
            Log::warning('Skipping row due to missing required fields:', $row);
            return null;
        }

        // Cek apakah resep dengan nama yang sama sudah ada untuk user_id=1
        $existing = Recipe::where('user_id', 1)
            ->where('name', trim($row['name']))
            ->first();
        if ($existing) {
            Log::info('Skipping duplicate recipe:', $row);
            return null;
        }

        // Log untuk debug (opsional)
        Log::info('Importing recipe row:', $row);

        return new Recipe([
            'user_id'     => 1,
            'name'        => trim($row['name']), // Pastikan name tidak null dan di-trim
            'description' => trim($row['description'] ?? ''),
            'ingredients' => trim($row['ingredients']),
            'steps'       => trim($row['steps']),
            'province'    => (!empty(trim($row['province'] ?? '')) && trim($row['province']) !== '?') ? trim($row['province']) : 'Tidak Diketahui',
            'foto'        => !empty(trim($row['foto'] ?? '')) ? trim($row['foto']) : null,
        ]);
    }
}
