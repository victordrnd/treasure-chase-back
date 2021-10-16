<?php

namespace Database\Seeders;

use App\Models\Status;
use Illuminate\Database\Seeder;

class StatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Status::create([
            'label' => 'Non complété',
            'code' => 'unfinished',
        ]);

        Status::create([
            'label' => "En file d'attente",
            'code' => 'waiting_list',
        ]);

        Status::create([
            'label' => 'Terminée',
            'code' => 'finished',
        ]);
    }
}
