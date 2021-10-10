<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ItemPanier extends Model
{
    use HasFactory;
    protected $fillable = ["model_id", "model_type", "panier_id"];

    public function forfait(){
        return $this->morphOne(Forfait::class, 'model');
    }

    public $appends = ['item'];

    protected $hidden = ['model_id', 'model_type', 'panier_id', 'id'];

    public function getItemAttribute(){
        return $this->model_type::find($this->model_id);
    }
}
