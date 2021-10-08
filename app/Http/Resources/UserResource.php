<?php

namespace App\Http\Resources;

use App\Models\Pumpkin;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $billet = Pumpkin::where('email', $this->email)->first();
        return [
            'id' => $this->id,
            'lastname' => $this->lastname,
            'firstname' => $this->firstname,
            'email' => $this->email,
            'phone' => $this->phone,
            'filiere' => $this->filiere,
            'is_cotisant' => $this->is_cotisant,
            'total_to_pay' => 0,
            'total_paid' => $billet->montant ?? 0,
            'date_paiement' => $billet->date ?? null
        ];
    }
}
