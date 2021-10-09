<?php

namespace Database\Seeders;

use App\Models\Forfait;
use Illuminate\Database\Seeder;

class ForfaitSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Forfait::create([
            'label' => 'Pack forfait classique',
            'code' => 'classic',
            'price' => 0,
        ]);

        Forfait::create([
            'label' => 'Pas de forfait',
            'code' => 'no_forfait',
            'price' => -105,
        ]);
    }
}
