<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLivestockMedicinesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('livestock_medicines', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->timestamp('date');
            $table->double('dose', 4, 2);
            $table->unsignedBigInteger('livestock_id')->unsigned()->index();
            $table->unsignedBigInteger('medicine_id')->unsigned()->index();
            $table->timestamps();
            $table->softDeletes();
            $table->foreign('livestock_id')->references('id')->on('livestocks');
            $table->foreign('medicine_id')->references('id')->on('medicines');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('livestock_medicines');
    }
}
