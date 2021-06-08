<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Feedbacks extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('feedbacks', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_cities');
            $table->foreign('id_cities')->references('id')->on('cities')->onDelete('cascade');
            $table->string('title');
            $table->text('text');
            $table->tinyInteger('rating');
            $table->string('img');
            $table->unsignedBigInteger('id_author');
            $table->foreign('id_author')->references('id')->on('users')->onDelete('cascade');
            $table->timestamp('date_create');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('feedbacks');
    }
}
