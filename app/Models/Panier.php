<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Panier extends Model
{

    protected $fillable = ["firstname", "lastname", "filiere", "period_id"];


    public function period(){
        return $this->belongsTo(Period::class);
    }
}
