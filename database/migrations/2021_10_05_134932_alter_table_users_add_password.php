<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterTableUsersAddPassword extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        \DB::statement('CREATE TABLE user_scans LIKE users');
        \DB::statement('INSERT user_scans SELECT * FROM users');
        Schema::table('users', function (Blueprint $table) {
            $table->string('password')->after('email')->nullable();
            //$table->string('filiere',18)->after('password');
            $table->string('phone', 12)->after('filiere')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('password');
            $table->dropColumn('phone');
            //$table->dropColumn('filiere');
        });
    }
}
