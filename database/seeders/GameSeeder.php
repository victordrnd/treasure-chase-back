<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Game;
class GameSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Game::create([
            "slug" => "memory",
            "score" => 400
        ]);

        Game::create([
            "slug" => "snake",
            "score" => 300
        ]);
        Game::create([
            "slug" => "soundpad",
            "score" => 300
        ]);
        Game::create([
            "slug" => "tetris",
            "score" => 400
        ]);
        Game::create([
            "slug" => "qrcode",
            "score" => 400
        ]);
        Game::create([
            "slug" => "piano",
            "score" => 400
        ]);
    }
}
