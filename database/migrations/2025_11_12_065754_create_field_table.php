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
        Schema::create('fields', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->foreignId('category_field_id')->constrained('category_fields')->onDelete('cascade');
            $table->string('image')->nullable();
            $table->text('description');
            $table->integer('price_per_hour');
            $table->time('open_time');
            $table->time('close_time');
            $table->enum('status', ['available', 'maintenance', 'booked', 'closed', 'pending'])->default('available');
            $table->timestamps();
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('fields');
    }
};
