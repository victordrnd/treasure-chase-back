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
            'label'=>'Pack nourriture classique',
            'code' => 'classic',
            'price' => 55
        ]);

        FoodPack::create([
            'label'=> 'Pack nourriture classique Halal',
            'code' => 'hallal',
            'price'=> 63
        ]);

        FoodPack::create([
            'label'=> 'Pack nourriture classique Veggie',
            'code' => 'veggie',
            'price'=> 63
        ]);


        FoodPack::create([
            'label' => 'Pack nourriture des BP',
            'code' => 'bp_pack',
            'price' => 50
        ]);
        
    }
}
