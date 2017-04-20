<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableProfile extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('profiles', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')
                ->unsigned()->index();

            // $table->foreign('user_id')
                // ->references('id')
                // ->on('users')
                // ->onDelete('cascade');
            $table->timestamps();
        });

        DB::beginTransaction();
        foreach (DB::connection()->select("select * from users") as $user)
            DB::insert('insert into profiles (user_id) values (?)', 
                [$user->id]);

        DB::commit();
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('profiles');
    }
}
