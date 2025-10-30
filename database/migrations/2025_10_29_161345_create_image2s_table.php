<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('image2s', function (Blueprint $table) {
            $table->id();
            $table->string('path');
            $table->integer('size')->nullable();
            $table->morphs('imageable'); // crea imageable_id y imageable_type
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('image2s');
    }
};
