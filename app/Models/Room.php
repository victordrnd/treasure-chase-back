<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    use HasFactory;

    protected $fillable = [
        'leader_id',
        'capacity',
        'code',
        'is_private',
        'is_liste'
    ];

    // public $appends = ['members_count'];

    protected $hidden = [
        'updated_at',
        'created_at'
    ];

    public function members(){
        return $this->hasMany(User::class, "room_id");
    }



    // public function getMembersCountAttribute(){
    //     return count($this->members);
    // }
}
