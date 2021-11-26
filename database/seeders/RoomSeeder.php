<?php

namespace Database\Seeders;

use App\Models\Room;
use Illuminate\Database\Seeder;

class RoomSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $places = [
        12, 12, 
        10,10,
        9,9,9,9,9,9,9,
        8,8,8,8,8,8,
        7,7,7,7,
        6,6,6,6,6,6,6,6,6,6,6,6,6,6,6,6,6,6,6,
        5,5,5,5,5,
        4,4,4,4,4,4,4];

        for ($i=0; $i < count($places); $i++) { 
            Room::create([
                'capacity' => $places[$i],
                'leader_id' => null,
                'is_private' => false,
                'is_liste' => false
            ]);
        }
    }
}
