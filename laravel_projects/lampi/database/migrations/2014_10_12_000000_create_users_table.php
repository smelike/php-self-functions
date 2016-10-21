<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user', function (Blueprint $table) {
            $table->increments('id');
            $table->string('userAccount', 100)->unique();
            $table->string('password', 100);
            $table->string('token', 100);
            $table->string('name', 100)->nullable();
            $table->string('tel', 20)->nullable();
            $table->tinyInteger('position')->default(10);
            $table->tinyInteger('status')->default(0);
            //$table->rememberToken();
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
        Schema::dropIfExists('users');
    }
}
