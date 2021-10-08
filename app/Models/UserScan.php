<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserScan extends Model
{
    use HasFactory;
    public $table = "user_scans";

    
    protected $fillable = [
        'firstname',
        'lastname',
        'email',
        'filiere',
        'code',
    ];
}
