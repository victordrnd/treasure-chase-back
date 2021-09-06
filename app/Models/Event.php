<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    use HasFactory;
    protected $fillable = ['code', "label"];

    public function users(){
        return $this->belongsToMany(User::class, 'user_events', 'user_id', 'event_id', 'id', 'id');
    }
}
