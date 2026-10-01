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
        Schema::create('product_units', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tenant_id')->constrained()->cascadeOnDelete();
            $table->foreignId('product_id')->constrained()->cascadeOnDelete();
            $table->string('unit_name'); // e.g. Kilo 1 (1kg), Nusu Kilo (500g), Robo Kilo (250g), Kibaba, Fungu, Kipande
            $table->string('short_code', 20)->nullable(); // e.g. 1kg, 500g, 250g, kibaba
            $table->decimal('quantity_ratio', 10, 4)->default(1.0000); // 1.0000 = 1 base unit, 0.5000 = 1/2 base unit, 0.2500 = 1/4 base unit
            $table->decimal('cost_price', 15, 2)->nullable();
            $table->decimal('selling_price', 15, 2)->default(0);
            $table->string('barcode')->nullable()->index();
            $table->boolean('is_default')->default(false);
            $table->timestamps();

            $table->index(['tenant_id', 'product_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_units');
    }
};
