<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FoodPack extends Model
{
    use HasFactory;
    public $timestamps = false;

    protected $fillable = ["label", "code", "price"];

    public $appends = ['model'];

    public function getModelAttribute(){
        return self::class;
    }
}
