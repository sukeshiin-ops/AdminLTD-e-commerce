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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();

            $table->foreignId('user_id')->constrained()->cascadeOnDelete();

            $table->text('order_address');

            $table->decimal('final_discount', 10, 2)->default(0);
            $table->decimal('final_tax', 10, 2)->default(0);
            $table->decimal('final_amount', 10, 2);

            $table->enum('status', ['pending', 'cancel', 'booked', 'delivered'])->default('pending'); // ✅ FIXED

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
