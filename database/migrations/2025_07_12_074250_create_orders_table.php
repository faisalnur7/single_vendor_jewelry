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
            $table->unsignedBigInteger('user_id')->nullable();
            $table->text('billing_address')->nullable();
            $table->text('shipping_address')->nullable();

            $table->string('payment_option_name')->nullable(); // e.g., PayPal, Card, GPay
            $table->string('transaction_id')->nullable(); // Braintree transaction ID

            $table->string('status')->default(1); // e.g., pending, processing, shipped, completed

            $table->decimal('subtotal', 10, 2)->default(0.00);
            $table->decimal('shipping_charge', 10, 2)->default(0.00);
            $table->decimal('total', 10, 2)->default(0.00);

            $table->string('order_tracking_number')->nullable();
            $table->string('order_tracking_url')->nullable();

            $table->timestamp('start_processing_at')->nullable();
            $table->timestamp('packaged_at')->nullable();
            $table->timestamp('shipped_at')->nullable();
            $table->timestamp('completed_at')->nullable();

            $table->timestamps();

            // Optional: Foreign key constraint
            $table->foreign('user_id')->references('id')->on('users')->onDelete('set null');
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
