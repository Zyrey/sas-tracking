<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRequirementSchedulesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('requirement_schedules', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->id();
            $table->unsignedBigInteger('step_requirement_id');
            $table->date('date');
            $table->time('start_time');
            $table->time('end_time');
            $table->string('room');
            $table->boolean('current')->default(1);
            $table->text('remarks')->nullable();
            $table->timestamps();

            $table->foreign('step_requirement_id')->references('id')->on('step_requirements')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('requirement_schedules');
    }
}
