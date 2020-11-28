<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTrackingStepsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tracking_steps', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->id();
            $table->unsignedBigInteger('tracking_id');
            $table->unsignedTinyInteger('step_number');
            $table->string('step_name');
            $table->unsignedTinyInteger('take_number')->default(1);
            $table->boolean('complete')->default(0);
            $table->boolean('status')->default(1);
            $table->boolean('default')->default(0);
            $table->timestamps();

            $table->foreign('tracking_id')->references('id')->on('trackings')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tracking_steps');
    }
}
