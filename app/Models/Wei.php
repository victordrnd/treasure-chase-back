<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Wei extends Model
{
    use HasFactory;
    protected $fillable = ['firstname', 'lastname', 'email','filiere', 'phone', 'wei', 'cotiz', 'inte'];
}
