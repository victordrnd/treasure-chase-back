<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreatePanierRequest;
use App\Http\Requests\SaveCartRequest;
use App\Models\ItemPanier;
use App\Models\Panier;
use App\Models\Period;
use App\Models\Status;
use Illuminate\Http\Request;

class PanierController extends Controller {
    
    public function show(){
        return Panier::where('id', auth()->user()->panier_id)->with('items')->firstOrFail();
    }

    public function saveCart(SaveCartRequest $req) {
        $user = auth()->user();
        if (is_null($user->panier_id)) {
            $panier = Panier::create([
                'status_id' => Status::where('code', 'unfinished')->first()->id
            ]);
            $user->panier_id = $panier->id;
            $user->save();
        }
        $touched_items = [];
        foreach ($req->items as $item) {
            $item = ItemPanier::updateOrCreate(
                [
                    'panier_id' => $user->panier_id,
                    'model_type' => "App\\Models\\" . $item['model'],
                    'model_id' => $item['id']
                ]
            );
            $touched_items[] = $item->id;
        }
        ItemPanier::where('panier_id', $user->panier_id)->whereNotIn('id', $touched_items)->delete();
        return $user->panier;
    }
}
