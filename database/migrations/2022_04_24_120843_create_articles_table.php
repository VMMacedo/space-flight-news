<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('articles', function (Blueprint $table) {
            $table->id();
            $table->string("title");
            $table->string("url");
            $table->string("imageUrl");
            $table->string("newsSite");
            $table->text("summary");
            $table->dateTimeTz("publishedAt");
            $table->dateTimeTz("updatedAt");
            $table->boolean("featured");
            $table->foreignId("events_id")->nullable();
            $table->uuid("launches_id")->nullable();
            $table->timestamps();

            $table->foreign('events_id')->references('id')->on('events');
            $table->foreign('launches_id')->references('id')->on('launches');
        });
        
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('articles');
    }
};
