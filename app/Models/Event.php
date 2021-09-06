<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    use HasFactory;
    protected $fillable = ['code', "label"];

    public function user_events(){
        return $this->hasMany(UserEvent::class, 'event_id');
    }
}
