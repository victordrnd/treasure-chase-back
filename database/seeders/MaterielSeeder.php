<?php

namespace Database\Seeders;

use App\Models\Materiel;
use App\Models\MaterielCategory;
use Illuminate\Database\Seeder;

class MaterielSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Materiel::create([
            'label' => 'Pack complet',
            'code' => 'full_pack',
            'price' => 75,
            'materiel_category_id' => MaterielCategory::where('code', 'BRONZE')->first()->id
        ]);
        Materiel::create([
            'label' => 'Skis seuls',
            'code' => 'ski_only',
            'price' => 69,
            'materiel_category_id' => MaterielCategory::where('code', 'BRONZE')->first()->id
        ]);
        Materiel::create([
            'label' => 'Chaussures seules',
            'code' => 'shoes_only',
            'price' => 65,
            'materiel_category_id' => MaterielCategory::where('code', 'BRONZE')->first()->id
        ]);

        // DECOUVERTE
        Materiel::create([
            'label' => 'Pack complet',
            'code' => 'full_pack',
            'price' => 84,
            'materiel_category_id' => MaterielCategory::where('code', 'DECOUVERTE')->first()->id
        ]);
        Materiel::create([
            'label' => 'Skis seuls',
            'code' => 'ski_only',
            'price' => 79,
            'materiel_category_id' => MaterielCategory::where('code', 'DECOUVERTE')->first()->id
        ]);
        Materiel::create([
            'label' => 'Chaussures seules',
            'code' => 'shoes_only',
            'price' => 70,
            'materiel_category_id' => MaterielCategory::where('code', 'DECOUVERTE')->first()->id
        ]);


        //SENSATION
        Materiel::create([
            'label' => 'Pack complet',
            'code' => 'full_pack',
            'price' => 98,
            'materiel_category_id' => MaterielCategory::where('code', 'SENSATION')->first()->id
        ]);
        Materiel::create([
            'label' => 'Skis seuls',
            'code' => 'ski_only',
            'price' => 94,
            'materiel_category_id' => MaterielCategory::where('code', 'SENSATION')->first()->id
        ]);
        Materiel::create([
            'label' => 'Chaussures seules',
            'code' => 'shoes_only',
            'price' => 85,
            'materiel_category_id' => MaterielCategory::where('code', 'SENSATION')->first()->id
        ]);


        //DIAMANT
        Materiel::create([
            'label' => 'Pack complet',
            'code' => 'full_pack',
            'price' => 118,
            'materiel_category_id' => MaterielCategory::where('code', 'DIAMANT')->first()->id
        ]);
        Materiel::create([
            'label' => 'Skis seuls',
            'code' => 'ski_only',
            'price' => 114,
            'materiel_category_id' => MaterielCategory::where('code', 'DIAMANT')->first()->id
        ]);
        Materiel::create([
            'label' => 'Chaussures seules',
            'code' => 'shoes_only',
            'price' => 100,
            'materiel_category_id' => MaterielCategory::where('code', 'DIAMANT')->first()->id
        ]);

        Materiel::create([
            'label' => 'Casque de ski',
            'code' => 'casque',
            'price' => 24,
            'materiel_category_id' => null
        ]);
    }
}
