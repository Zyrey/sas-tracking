<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRequirementFacultiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('requirement_faculties', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->id();
            $table->unsignedBigInteger('step_requirement_id');
            $table->unsignedBigInteger('faculty_id');
            $table->unsignedTinyInteger('role');
            $table->boolean('current')->default(1);
            $table->text('remarks')->nullable();
            $table->timestamps();

            $table->unique(['step_requirement_id', 'faculty_id']);
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
        Schema::dropIfExists('requirement_faculties');
    }
}
