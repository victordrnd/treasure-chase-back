<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Panier extends Model
{
    use HasFactory;

    protected $fillable = ["completed_at", "status_id"];

    public $appends = ['price'];

    public function getPriceAttribute(){
        $total = 0;
        $user = User::where('panier_id', $this->id)->first();
        if($user->is_bde){
            $total += 250;
        }else{
            $total += $user->is_cotisant ? 335 : 375;
        }

        foreach($this->items as $item){
            $total += $item->item->price;
        }
        return $total;
    }

    public function items(){
        return $this->hasMany(ItemPanier::class, 'panier_id');
    }

    public function status(){
        return $this->belongsTo(Status::class);
    }
}
