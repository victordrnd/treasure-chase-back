<?php

namespace App\Imports;

use App\Models\Pumpkin;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\ToModel;

class PumpkinsImport implements ToCollection {
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function collection($rows) {
        Pumpkin::where('id', '>', 0)->delete();
        foreach ($rows as $row) {
            if (count($row) > 11) {
                if ($row[1] == "Payée") {
                    Pumpkin::create([
                        'reference' => $row[2],
                        'montant' => intval($row[5]),
                        'firstname' => $row[8],
                        'lastname' => $row[7],
                        'email' => $row[11],
                        'phone' => $row[10],
                        'date' => Carbon::createFromFormat('d/m/Y H:i:s', $row[0])->toDateString()
                    ]);
                }
            }
        }
    }
}
