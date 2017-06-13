<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRepositoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rsa', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->index();
            $table->string('private_key');
            $table->string('public_key')->nullable();
            $table->string('title');

            $table->timestamps();
        });

        Schema::create('repositories', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('rsa_id')->index();
            $table->string('url');
            
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
        Schema::dropIfExists('rsa');
        Schema::dropIfExists('repositories');
    }
}
