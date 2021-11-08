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
use Illuminate\Support\Facades\Log;

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
                if (count($row) > 11) {
                    if ($row[1] == "Payée") {
                        if (Pumpkin::where('email', $row[12])->exists()) {
                            $pumpkin = Pumpkin::where('email', $row[12])->first();
                            $pumpkin->increment('montant', intval($row[5]));
                        } else {
                            $pumpkin = Pumpkin::create([
                                'montant' => intval($row[5]),
                                'firstname' => $row[8],
                                'lastname' => $row[7],
                                'email' => $row[12],
                                'phone' => $row[11],
                                'date' => Carbon::createFromFormat('d/m/Y H:i:s', $row[0])->toDateString()
                            ]);
                        }
                        
                        $user = User::where('email', $pumpkin->email)->first();
                        if(!is_null($user)){
                            if(!is_null($user->panier)){
                                if($pumpkin->montant >= ($user->panier->price-5)){
                                    Panier::where('id', $user->panier_id)->update([
                                        'status_id' => Status::where('code', 'finished')->first()->id
                                    ]);
                                }else if ($pumpkin->montant > 20 && ($pumpkin->montant < $user->panier->price)){
                                    Panier::where('id', $user->panier_id)->update([
                                        'status_id' => Status::where('code', 'waiting_second_paiement')->first()->id
                                    ]);
                                }
                            }
                        }else{
                            Log::debug('Updating panier failed status : '. json_encode($pumpkin));
                        }
                    }
                }
             }
        });
    }
}
