<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('tours', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('travelId');
            $table->uuid('uuid');
            $table->string('name');
            $table->dateTime('startingDate')->nullable();
            $table->dateTime('endingDate')->nullable();
            $table->integer('price');
            $table->timestamp('createdAt')->nullable();
            $table->timestamp('updatedAt')->nullable();

            $table->foreign('travelId')->references('id')->on('travels');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tours');
    }
};
