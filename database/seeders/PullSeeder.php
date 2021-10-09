<?php

namespace Database\Seeders;

use App\Models\Pull;
use Illuminate\Database\Seeder;

class PullSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Pull::create([
            'label' => 'Pull Unisexe',
            'taille' => 'XS',
            'price' => 0
        ]);

        Pull::create([
            'label' => 'Pull Unisexe',
            'taille' => 'S',
            'price' => 0
        ]);

        Pull::create([
            'label' => 'Pull Unisexe',
            'taille' => 'M',
            'price' => 0
        ]);

        Pull::create([
            'label' => 'Pull Unisexe',
            'taille' => 'L',
            'price' => 0
        ]);

        Pull::create([
            'label' => 'Pull Unisexe',
            'taille' => 'XL',
            'price' => 0
        ]);

        Pull::create([
            'label' => 'Pull Unisexe',
            'taille' => 'XXL',
            'price' => 0
        ]);
    }
}
