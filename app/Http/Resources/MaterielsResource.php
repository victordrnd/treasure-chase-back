<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class MaterielsResource extends JsonResource
{
    private $data;
    public function __construct($data)
    {
        $this->data = $data;
    }
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'pulls' => $this->data['pulls'],
            'foodpacks' => $this->data['foodpacks'],
            'materiel_categories' => $this->data['materiel_categories'],
            'forfaits' => $this->data['forfaits'],
            'assurances' => $this->data["assurances"]
        ];
    }
}
