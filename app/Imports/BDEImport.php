<?php

namespace App\Imports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use App\Models\User;
use Illuminate\Support\Str;

class BDEImport implements ToCollection {
    /**
     * @param Collection $collection
     */
    public function collection(Collection $rows) {
        \DB::transaction(function () use ($rows) {
            foreach ($rows as $row) {
                User::firstOrCreate(
                    ['email' => $row[4]],
                    [
                        'lastname' => Str::of($row[0])->title(),
                        'firstname' => Str::of($row[1])->title(),
                        'filiere' => trim($row[2]),
                        'phone' => "0".str_replace(' ', '', $row[3]),
                        'is_bde' => true
                    ]
                );
            }
        });
    }
}
