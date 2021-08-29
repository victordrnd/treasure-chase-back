<?php

namespace Database\Seeders;

use App\Models\HappyHour;
use Illuminate\Database\Seeder;

class HappyHourSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        HappyHour::create([
            'date' => '2021-09-06'
        ]);

        HappyHour::create([
            'date' => '2021-09-07'
        ]);

        HappyHour::create([
            'date' => '2021-09-09'
        ]);

        HappyHour::create([
            'date' => '2021-09-13'
        ]);

        HappyHour::create([
            'date' => '2021-09-14'
        ]);
    }
}
