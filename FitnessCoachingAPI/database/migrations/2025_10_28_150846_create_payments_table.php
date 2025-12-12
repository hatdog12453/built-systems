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
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('client_id')->constrained('clients')->cascadeOnDelete();
            $table->foreignId('admin_id')->constrained('admins')->cascadeOnDelete();
            $table->string('transaction_reference_no')->unique();
            $table->decimal('amount', 10, 2);
            $table->date('payment_date');
            $table->string('method');
            $table->string('status');
            $table->timestamps();
            
            // Note: Multiple payments per client are allowed for renewals
            // No unique constraint on client_id to allow multiple payments per client
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
