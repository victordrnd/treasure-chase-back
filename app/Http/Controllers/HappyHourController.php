<?php

namespace App\Http\Controllers;

use App\Models\HappyHour;
use Illuminate\Http\Request;

class HappyHourController extends Controller
{
    public function list(){
        return HappyHour::withCount("inscriptions")->get();
    }
}
