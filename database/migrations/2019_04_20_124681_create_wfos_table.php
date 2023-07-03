<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateWfosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('wfos', function (Blueprint $table) {
            $table->string('abbr', 3)->unique()->nullable(false);
            $table->string('fullname', 64)->nullable(false);
            $table->string('state', 2)->nullable(false);
            $table->string('tz', 1)->nullable(false);
            $table->string('url', 128)->nullable(false);
            $table->string('rid', 3)->nullable(false);
            $table->timestamps();

            $table->foreign('state')->references('abbr')->on('states');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('wfos');
    }
}
