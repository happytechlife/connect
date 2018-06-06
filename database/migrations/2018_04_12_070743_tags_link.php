<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class TagsLink extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tags_link', function (Blueprint $table) {
            $table->integer('id_entreprise');
            $table->integer('id_tag');

            //$table->foreign('id_tag')->references('id')->on('tags');
            //$table->foreign('id_entreprise')->references('id')->on('entreprises');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tags_link');
    }
}
