<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSemestersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('semesters', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->id();
            $table->integer('term');
            $table->unsignedBigInteger('year_start');
            $table->unsignedBigInteger('year_end');
            $table->boolean('current')->default(0);
            $table->timestamps();

            $table->unique(['term', 'year_start', 'year_end']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('semesters');
    }
}
