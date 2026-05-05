<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->string('code')->unique();
            $table->string('category');
            $table->string('rarity');
            $table->string('district');
            $table->unsignedInteger('price');
            $table->string('short_description');
            $table->text('long_description');
            $table->string('dominant_color');
            $table->string('status')->default('disponible');
            $table->unsignedTinyInteger('signal_level')->default(0);
            $table->unsignedTinyInteger('agility')->default(0);
            $table->unsignedTinyInteger('spirit')->default(0);
            $table->unsignedTinyInteger('ferocity')->default(0);
            $table->string('image_path')->nullable();
            $table->boolean('is_featured')->default(false);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
