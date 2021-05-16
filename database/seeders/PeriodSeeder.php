<?php

namespace Database\Seeders;

use App\Models\Period;
use Illuminate\Database\Seeder;

class PeriodSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Period::create([
            'label' => 'Jeudi 20 mai'
        ]);

        Period::create([
            'label' => 'Jeudi 27 mai'
        ]);

        Period::create([
            'label' => 'Jeudi 03 juin'
        ]);

        Period::create([
            'label' => 'Jeudi 10 juin'
        ]);
    }
}
