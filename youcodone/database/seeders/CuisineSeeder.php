<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Cuisine;

class CuisineSeeder extends Seeder
{
    public function run(): void
    {
        $cuisines = [
            'Française',
            'Italienne',
            'Japonaise',
            'Chinoise',
            'Marocaine',
            'Indienne',
            'Mexicaine',
            'Thaïlandaise',
            'Libanaise',
            'Espagnole',
            'Américaine',
            'Végétarienne',
            'Fast-Food',
            'Fruits de mer',
            'Grill',
        ];

        foreach ($cuisines as $cuisine) {
            Cuisine::create(['type' => $cuisine]);
        }
    }
}