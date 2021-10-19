<?php

namespace Database\Seeders;

use App\Models\Assurance;
use Illuminate\Database\Seeder;

class AssuranceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Assurance::create([
            'label' => 'Assurance Annulation',
            'price' => 20,
            'code' => 'annulation'
        ]);

        Assurance::create([
            'label' => 'Assurance Rapatriement',
            'price' => 27.5,
            'code' => 'rapatriement'
        ]);

        Assurance::create([
            'label' => 'Assurance Tout compris',
            'price' => 30,
            'code' => 'full'
        ]);
    }
}
