<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSensorAdditionalActionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sensor_additional_actions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('sensor_id');
            $table->string('text');
            $table->string('route');
            $table->string('value')->nullable();

            $table->foreign('sensor_id')->references('id')->on('sensors');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sensor_additional_actions');
    }
}
