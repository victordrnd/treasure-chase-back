<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePumkinsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pumpkins', function (Blueprint $table) {
            $table->id();
            $table->string('reference');
            $table->double('montant');
            $table->string('email', 90);
            $table->string('phone', 10);
            $table->string('lastname', 30);
            $table->string('firstname', 40);
            $table->dateTime('date');
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
        Schema::dropIfExists('pumpkins');
    }
}
