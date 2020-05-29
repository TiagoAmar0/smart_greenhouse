<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStateTextsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('state_texts', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('equipment_id')->unsigned();
            $table->string('value');
            $table->string('text');
            $table->timestamps();

            $table->foreign('equipment_id')->references('id')->on('equipments');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('state_texts');
    }
}
