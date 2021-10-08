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
        \DB::transaction(function() use ($rows){
            Pumpkin::where('id', '>', 0)->delete();
            foreach ($rows as $row) {
                if (count($row) > 7) {
                    if ($row[1] == "SUCCEEDED") {
                        if(Pumpkin::where('email', $row[7])->exists()){
                            Pumpkin::where('email', $row[7])->first()->increment('montant', intval($row[2]));
                        }else{
                            Pumpkin::create([
                                'montant' => intval($row[5]),
                                'firstname' => $row[5],
                                'lastname' => $row[6],
                                'email' => $row[7],
                                'phone' => str_replace("33","0",$row[8]),
                                'date' => Carbon::createFromFormat('d/m/Y H:i:s', $row[0])->toDateString()
                            ]);
                        }
                    }
                }
            }
        });
    }
}
