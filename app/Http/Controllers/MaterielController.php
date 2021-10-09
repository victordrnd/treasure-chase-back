<?php

namespace App\Http\Controllers;

use App\Http\Resources\MaterielsResource;
use App\Models\Assurance;
use App\Models\FoodPack;
use App\Models\Forfait;
use App\Models\Materiel;
use App\Models\MaterielCategory;
use App\Models\Pull;
use Illuminate\Http\Request;

class MaterielController extends Controller {
    public function list() {
        $forfaits = Forfait::all();
        $pulls = Pull::all();
        $foodpack = FoodPack::all();
        $materiel_categories = MaterielCategory::with('materiels')->get();
        $materiels = Materiel::whereNull('materiel_category_id')->get();
        $assurances = Assurance::all();
        return new MaterielsResource(array(
            'forfaits' => $forfaits,
            'pulls' => $pulls,
            'foodpacks' => $foodpack,
            'materiel_categories' => $materiel_categories,
            'assurances' => $assurances,
            'materiels' => $materiels
        ));
    }
}
