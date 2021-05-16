<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Period extends Model
{
    protected $fillable = ["label"];
    public function paniers(){
        return $this->hasMany(Panier::class, "period_id");
    }
}
