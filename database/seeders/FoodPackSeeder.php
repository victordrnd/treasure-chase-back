<?php

namespace Database\Seeders;

use App\Models\FoodPack;
use Illuminate\Database\Seeder;

class FoodPackSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        FoodPack::create([
            'label'=>'Classique',
            'code' => 'classic',
            'price' => 55
        ]);

        FoodPack::create([
            'label'=> 'Hallal',
            'code' => 'hallal',
            'price'=> 63
        ]);

        FoodPack::create([
            'label'=> 'Veggie',
            'code' => 'veggie',
            'price'=> 63
        ]);
    }
}
