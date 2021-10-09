<?php

namespace Database\Seeders;

use App\Models\MaterielCategory;
use Illuminate\Database\Seeder;

class MaterielCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        MaterielCategory::create([
            'label' => 'Bronze (Ski uniquement)',
            'code' => 'BRONZE',
            'description' => 'Recommandé pour les skieurs débutants'
        ]);

        MaterielCategory::create([
            'label' => 'Découverte (Snow ou Ski)',
            'code' => 'DECOUVERTE',
            'description' => 'Recommandé pour les skieurs intermédiaires'
        ]);

        MaterielCategory::create([
            'label' => 'Sensation (Snow ou Ski)',
            'code' => 'SENSATION',
            'description' => 'Recommandé pour les skieurs confirmés'
        ]);

        MaterielCategory::create([
            'label' => 'Diamant (Ski uniquement)',
            'code' => 'DIAMANT',
            'description' => 'Matériel haut de gamme, style et performance'
        ]);
    }
}
