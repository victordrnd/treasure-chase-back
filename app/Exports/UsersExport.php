<?php

namespace App\Exports;

use App\Models\ItemPanier;
use App\Models\Materiel;
use App\Models\MaterielCategory;
use App\Models\Panier;
use App\Models\Pumpkin;
use App\Models\User;
use Maatwebsite\Excel\Concerns\FromCollection;

class UsersExport implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        $data = [];
        $paniers = Panier::with('user', 'status', 'items')->get();
        foreach($paniers as $panier){
            $items = $panier->items->map(function($el){
                return $el->item;
            });
            $items = $items->toArray(); 
            $categories = MaterielCategory::all()->toArray();
            $materiel = ItemPanier::where('panier_id', $panier->id)->where('model_type', Materiel::class)->where('model_id', '!=', Materiel::where('code', 'casque')->first()->id)->first();
            $data[] = [
                'Nom' => $panier->user->lastname,
                'Prénom' => $panier->user->firstname,
                'Email' => $panier->user->email,
                'Téléphone' => $panier->user->phone,
                'Filiere' => $panier->user->filiere,
                'Status' => $panier->status->label,
                'Taille' => $panier->user->taille,
                'Poids' => $panier->user->poids,
                'Pointure' => $panier->user->pointure,
                'BDE' => $panier->user->is_bde ? "Oui" : "Non",
                'Cotisant' => $panier->user->is_cotisant ? "Oui" : "Non",
                'Listeux' => $panier->user->is_liste ? "Oui" : "Non",
                'N° Cheque' => $panier->user->n_cheque,
                'Ski/Snow' => $panier->user->is_surf ? "Snow" : "Ski",
                'Montant' => $panier->price,
                'Mode de paiement' => Pumpkin::where('email', $panier->user->email)->exists() ? "Pumpkin" : "Espèce",
                'Taille du Pull' => ($pull = self::search("model", "Pull", $items)) ? $pull['taille'] : null,
                'Forfait' => ($forfait = self::search("model", "Forfait", $items)) ? $forfait['label'] : "Pas de forfait",
                'Nourriture' => ($foodpack = self::search("model", "FoodPack", $items)) ? ucfirst($foodpack['code']) : null,
                'Assurance' => ($assurance = self::search("model", "Assurance", $items)) ? ucfirst($assurance['code']) : "Aucune",
                'Matériel' => $materiel ? $materiel->item->label : null,
                'Categorie' => $materiel ? (($category = self::search("id", $materiel->item->materiel_category_id, $categories)) ? $category["label"]  : null): null,
                'Casque' => ($casque = self::search("code", "casque", $items)) ? "Oui" : "Non"
            ];
        }
        array_unshift($data, array_keys($data[0]));
        return collect($data);
    }


    private function search(string $key, $value,array $array){
        foreach($array as $item){
            if(isset($item[$key])){
                if($item[$key] == $value)
                    return $item;
            }
        }
        return null;
    }

   
}
