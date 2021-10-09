<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MaterielCategory extends Model
{
    use HasFactory;
    public $timestamps = false;

    protected $fillable = ["label", "code", "description"];


    public function materiels(){
        return $this->hasMany(Materiel::class, 'materiel_category_id');
    }
}
