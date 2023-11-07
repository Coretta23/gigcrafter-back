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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            // $table->string('reference')->unique();
            // $table->string('about');
            // $table->string('basicprice');
            $table->string('price');
            // $table->string('standardprice');
            $table->string('description');
            // $table->string('premiumprice');
            $table->string('shortdescription');
            $table->string('coverimage');
            $table->foreignId('category')->constrained('categories')->cascadeOnUpdate()->cascadeOnDelete();
            // $table->integer('category');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
