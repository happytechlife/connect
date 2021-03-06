<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Entreprises extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('entreprises', function (Blueprint $table) {
            $table->increments('id');
            $table->string('description');
            $table->string('slug')->unique();
            $table->string('name');
            $table->string('file_name');
            $table->string('email');
            $table->integer('user_id');
            $table->string('facebook')->nullable();
            $table->string('twitter')->nullable();
            $table->integer('linkedin_id');
            $table->integer('community');
            //$table->foreign('user_id')->references('id')->on('users');
            //$table->foreign('id')->references('id_entreprise')->on('tags_link');
            //$table->foreign('community')->references('id')->on('community');
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
        Schema::dropIfExists('entreprises');
    }
}
