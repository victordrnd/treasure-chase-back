<?php

namespace App\Imports;

use App\Models\User;
use Maatwebsite\Excel\Concerns\ToCollection;
use Illuminate\Support\Str;

class UsersImport implements ToCollection {
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function collection($rows) {
        \DB::transaction(function () use ($rows) {
            foreach ($rows as $row) {
                User::firstOrCreate(
                    [
                        'email' => $row[5] ?? uniqid("cpe_")."@noemail.com",
                        'lastname' => Str::of($row[1])->title(),
                        'firstname' => Str::of($row[2])->title(),
                        'filiere' => str_replace(' ', '', $row[3]),
                        'phone' => str_replace(' ', '', "0".$row[4]),
                        'is_cotisant' => true
                    ]
                );
            }
        });
    }
}
