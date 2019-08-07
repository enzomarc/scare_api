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
        Schema::create('users', function (Blueprint $table) {
	        $table->bigIncrements('id');
	        $table->string('first_name')->nullable(false);
	        $table->string('last_name')->nullable(true);
	        $table->string('phone', 13)->nullable(false)->unique();
	        $table->string('email')->nullable(false)->unique();
	        $table->integer('clinic')->nullable(false);
	        $table->string('password')->nullable(false);
	        $table->string('avatar')->nullable(true);
	        $table->integer('type')->nullable(false)->default(0);
	        $table->boolean('active')->nullable(false)->default(false);
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
