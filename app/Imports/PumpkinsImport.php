<?php

namespace App\Imports;

use App\Models\Panier;
use App\Models\Pumpkin;
use App\Models\Status;
use App\Models\User;
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
        \DB::transaction(function () use ($rows) {
            Pumpkin::where('id', '>', 0)->delete();
            foreach ($rows as $row) {
                if (count($row) > 6) {
                    if ($row[1] == "SUCCEEDED") {
                        if (Pumpkin::where('email', $row[7])->exists()) {
                            $pumpkin = Pumpkin::where('email', $row[7])->first();
                            $pumpkin->increment('montant', intval($row[2]));
                        } else {
                            $phone = str_replace("33", "0", $row[8]);
                            $phone = str_replace("+", "", $phone);
                            $pumpkin = Pumpkin::create([
                                'montant' => intval($row[2]),
                                'firstname' => $row[5],
                                'lastname' => $row[6],
                                'email' => $row[7],
                                'phone' => $phone,
                                'date' => Carbon::createFromFormat('d/m/Y H:i:s', $row[0])->toDateString()
                            ]);
                        }
                        $user = User::where('email', $pumpkin->email)->first();
                        if(!is_null($user)){
                            if($pumpkin->montant == $user->panier->price){
                                Panier::where('id', $user->panier_id)->update([
                                    'status_id' => Status::where('code', 'finished')->first()->id
                                ]);
                            }
                        }
                    }
                }
            }
        });
    }
}
