<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pumpkin extends Model
{
    use HasFactory;

    protected $fillable = [
        'reference',
        'montant',
        'email',
        'phone',
        'lastname',
        'firstname',
        'date'
    ];
}
