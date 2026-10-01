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
        Schema::create('contracts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tenant_id')->constrained()->cascadeOnDelete();
            $table->string('contract_number')->unique();
            $table->string('title');
            $table->enum('type', ['lease', 'subscription', 'custom_license', 'service_agreement'])->default('lease');
            $table->enum('billing_cycle', ['monthly', 'quarterly', 'annually', 'one_time'])->default('annually');
            $table->decimal('amount', 15, 2)->default(0);
            $table->string('currency', 10)->default('TZS');
            $table->date('start_date');
            $table->date('end_date');
            $table->enum('status', ['active', 'pending', 'expired', 'terminated', 'grace_period'])->default('active');
            $table->enum('payment_status', ['paid', 'partial', 'pending', 'overdue'])->default('paid');
            $table->text('sla_terms')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('contracts');
    }
};
