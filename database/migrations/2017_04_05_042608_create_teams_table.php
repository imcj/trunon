<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTeamsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('teams', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->timestamps();
        });

        Schema::table('users', function (Blueprint $table) {
            $table->integer('team_id')->default(-1)->index();
            // $table->integer('team_id')->unsigned();
            // $table->foreign('team_id')->references('id')->on('teams');
        });

        Schema::table('processes', function (Blueprint $table) {
            $table->integer('team_id')->default(-1)->index();
            $table->integer('owner_id')->default(-1)->index();
            // $table->integer('team_id')->unsigned();
            // $table->foreign('team_id')->references('id')->on('teams');
            // $table->integer('owner_id')->unsigned();
            // $table->foreign('owner_id')->references('id')->on('users');
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
            $table->dropColumn('team_id');
        });

        Schema::dropIfExists('teams');
    }
}
