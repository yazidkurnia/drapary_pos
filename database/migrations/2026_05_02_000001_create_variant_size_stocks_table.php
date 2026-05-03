<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('variant_size_stocks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_variant_id')
                  ->constrained('product_variants')
                  ->cascadeOnDelete();
            $table->foreignId('size_id')
                  ->constrained('sizes')
                  ->cascadeOnDelete();
            $table->integer('stock')->default(0);
            $table->timestamps();

            $table->unique(['product_variant_id', 'size_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('variant_size_stocks');
    }
};
