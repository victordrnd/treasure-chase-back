<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInscriptionHHSTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('inscription_hhs', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger("hh_id");
            $table->string("email");
            $table->string('filiere');
            $table->string('lastname');
            $table->string('firstname');
            $table->integer('scan_count')->default(0);
            $table->string('code')->unique();
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
        Schema::dropIfExists('inscription_hhs');
    }
}
