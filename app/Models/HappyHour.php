<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HappyHour extends Model
{
    public $timestamps = false;

    protected $fillable = ['date'];



    public function inscriptions(){
        return $this->hasMany(InscriptionHH::class, "hh_id");
    }
}
