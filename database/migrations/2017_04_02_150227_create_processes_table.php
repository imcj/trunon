<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use App\Model\Process;

class CreateProcessesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('processes', function (Blueprint $table) {
            $processStatus = [
                Process::EXITED
            ];
            $table->increments('id');
            $table->string('name')->nullable();
            $table->string('identifier')->index();
            $table->enum('status', $processStatus)->nullable();
            $table->enum('deploy', ['CODE', 'ZIP'])->default('CODE');
            $table->text('code')->nullable();
            $table->unsignedSmallInteger('process_number')->default(1);
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
        Schema::dropIfExists('processes');
    }
}
