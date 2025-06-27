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
        // Abaikan baris yang tidak punya nama, bahan, atau langkah
        if (empty($row['name']) || empty($row['ingredients']) || empty($row['steps'])) {
            return null;
        }

        // Log untuk debug (opsional)
        Log::info('Importing recipe row:', $row);

        return new Recipe([
            'user_id'     => $row['user_id'] ?? 1,
            'name'        => $row['name'],
            'description' => $row['description'] ?? '',
            'ingredients' => $row['ingredients'],
            'steps'       => $row['steps'],
            'province'    => (!empty($row['province']) && $row['province'] !== '?') ? $row['province'] : 'Tidak Diketahui',
            'foto'        => $row['foto'] ?? null,
        ]);
    }
}
