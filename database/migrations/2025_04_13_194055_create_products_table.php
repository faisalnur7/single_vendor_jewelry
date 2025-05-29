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

            // Foreign keys
            $table->foreignId('category_id')->constrained()->onDelete('cascade');
            $table->foreignId('sub_category_id')->nullable()->constrained()->onDelete('set null');
            $table->foreignId('child_sub_category_id')->nullable()->constrained()->onDelete('set null');

            // Product info
            $table->string('name');
            $table->string('slug')->unique();
            $table->string('sku')->unique();
            $table->text('description')->nullable();
            $table->text('short_description')->nullable();

            $table->decimal('max_price', 10, 2)->nullable()->default(0);
            $table->decimal('min_price', 10, 2)->nullable()->default(0);
            $table->decimal('price', 10, 2)->nullable()->default(0);
            $table->decimal('min_order_qty', 10, 2)->nullable()->default(0);
            $table->integer('stock')->default(0);

            // Variants will use this to refer to the parent product
            $table->unsignedBigInteger('parent_id')->default(0);
            $table->integer('has_variants')->default(0);

            $table->string('color')->nullable();
            $table->string('image')->nullable();
            $table->integer('status')->default(1); // 0 = inactive, 1 = active, 2 = draft
            $table->boolean('featured')->default(false);

            // Shipping & SEO
            $table->decimal('weight', 8, 2)->nullable();
            $table->string('unit')->nullable();
            $table->json('meta')->nullable();

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
