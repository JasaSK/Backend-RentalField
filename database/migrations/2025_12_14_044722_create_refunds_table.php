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
        Schema::create('refunds', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('booking_id');
            $table->foreign('booking_id')->references('id')->on('bookings')->onDelete('cascade');
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->unsignedBigInteger('payment_id');
            $table->foreign('payment_id')->references('id')->on('payment')->onDelete('cascade');
            $table->unsignedInteger('amount_paid');
            $table->unsignedInteger('refund_amount')->nullable();
            $table->string('refund_method')->nullable();
            $table->string('account_number');
            $table->text('reason')->nullable();
            $table->string('proof')->nullable();
            $table->enum('refund_status', ['pending', 'approved', 'rejected'])->default('pending');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('refunds');
    }
};
