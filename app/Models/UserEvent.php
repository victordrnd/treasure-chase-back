<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserEvent extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'event_id', 'asso'];
    protected $hidden = ['updated_at', 'user_id','event_id'];
    public function user(){
        return $this->belongsTo(UserScan::class, 'user_id');
    }

    public function event(){
        return $this->belongsTo(Event::class);
    }
}
