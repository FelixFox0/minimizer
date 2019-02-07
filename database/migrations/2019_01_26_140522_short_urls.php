<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ShortUrls extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('short_urls', function (Blueprint $table) {
            $table->increments('id');
            $table->string('originalUrl');
            $table->string('generatedUrl');
            $table->integer('viewed')->default(0);
            $table->string('instance');
            $table->unique(['generatedUrl', 'instance'], 'generatedUrlInstance');
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('shortUrls');
    }
}
