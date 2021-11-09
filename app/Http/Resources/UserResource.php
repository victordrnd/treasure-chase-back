<?php

namespace App\Http\Resources;

use App\Models\Panier;
use App\Models\Pumpkin;
use App\Models\Status;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource {
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request) {
        return [
            'id' => $this->id,
            'lastname' => $this->lastname,
            'firstname' => $this->firstname,
            'email' => $this->email,
            'phone' => $this->phone,
            'n_cheque' => $this->n_cheque,
            'filiere' => $this->filiere,
            'is_cotisant' => $this->is_cotisant,
            'is_allowed' => $this->is_allowed,
            'is_bde' => $this->is_bde,
            'is_liste' => $this->is_liste,
            'total_to_pay' => $this->panier->price ?? 0,
            'total_paid' => $this->billet->montant ?? 0,
            'date_paiement' => $this->billet->date ?? null,
            'status' => $this->whenLoaded('panier', function () {
                return $this->panier->status;
            }),
            'comments' => $this->comments,
            'position' => $this->whenLoaded('panier', function () {
                if(!is_null($this->panier)){
                    if($this->panier->status->code == "waiting_list"){
                        return Panier::where('completed_at', '<', $this->panier->completed_at)->where('status_id', Status::where('code', 'waiting_list')->first()->id)->count() + 1;
                    }
                }
                return null;
            }), 

        ];
    }
}
