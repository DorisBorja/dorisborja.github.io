<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLivestocksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('livestocks', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name', 50);
            $table->string('identification', 50)->nullable();
            $table->string('description', 200)->nullable();
            $table->enum('sex', ['Macho', 'Hembra']);
            $table->timestamp('birth_date')->nullable();
            $table->timestamp('purchase_date')->nullable();
            $table->timestamp('death_date')->nullable();
            $table->unsignedBigInteger('breed_id')->unsigned()->index();
            $table->bigInteger('user_id');
            $table->boolean('status');
            $table->text('image')->nullable();
            $table->timestamps();
            $table->softDeletes();
            $table->foreign('breed_id')->references('id')->on('breeds');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('livestocks');
    }
}
