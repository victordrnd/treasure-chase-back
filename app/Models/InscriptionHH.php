<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InscriptionHH extends Model
{
    public $table = "inscription_hhs";
    protected $fillable = ['lastname', 'firstname', 'email', 'filiere', 'code', 'scan_count','hh_id'];


    public function hh(){
        return $this->belongsTo(HappyHour::class, "hh_id");
    }
}
