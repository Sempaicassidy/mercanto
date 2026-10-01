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
        Schema::table('categories', function (Blueprint $table) {
            $table->string('business_chain')->nullable()->after('description');
            $table->decimal('target_margin', 5, 2)->default(20.00)->after('business_chain');
            $table->integer('sort_order')->default(0)->after('target_margin');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('categories', function (Blueprint $table) {
            $table->dropColumn(['business_chain', 'target_margin', 'sort_order']);
        });
    }
};
