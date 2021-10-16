<?php

namespace Database\Seeders;

use App\Models\Materiel;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder {
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run() {
        $this->call(PullSeeder::class);
        $this->call(MaterielCategorySeeder::class);
        $this->call(MaterielSeeder::class);
        $this->call(FoodPackSeeder::class);
        $this->call(ForfaitSeeder::class);
        $this->call(AssuranceSeeder::class);
        $this->call(StatusSeeder::class);
    }
}
