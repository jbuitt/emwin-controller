<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStatesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('states', function (Blueprint $table) {
            $table->string('abbr', 2)->unique()->nullable(false);
            $table->string('name', 24)->nullable(false);
            $table->string('fips', 2)->nullable(false);
            $table->decimal('lon', 10, 5)->nullable(false);
            $table->decimal('lat', 9, 5)->nullable(false);
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
        Schema::dropIfExists('states');
    }
}
