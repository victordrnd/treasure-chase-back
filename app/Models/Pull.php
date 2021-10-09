<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pull extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $fillable = ["label", "price", "taille"];

    
}
