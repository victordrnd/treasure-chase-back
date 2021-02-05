<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tombola extends Model
{
    protected $fillable = ["firstname","lastname", "email", "adresse", "filiere"];

}
