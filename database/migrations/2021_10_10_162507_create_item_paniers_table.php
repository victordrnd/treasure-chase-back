<?php

use App\Models\Assurance;
use App\Models\FoodPack;
use App\Models\Forfait;
use App\Models\Materiel;
use App\Models\Pull;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateItemPaniersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('item_paniers', function (Blueprint $table) {
            $table->id();
            $table->string('model_type');
            $table->unsignedInteger('model_id');
            $table->unsignedInteger('panier_id');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('item_paniers');
    }
}
