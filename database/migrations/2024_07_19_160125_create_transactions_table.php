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
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->timestamp('start_date');
            $table->timestamp('target_date')->nullable();
            $table->timestamp('end_date')->nullable();
            $table->timestamp('payment_date')->nullable();
            $table->foreignId('customer_id')->nullable()->constrained()->cascadeOnUpdate();
            $table->unsignedTinyInteger('status')->default(\App\Enum\TransactionStatus::WAITING);
            $table->unsignedTinyInteger('payment')->default(\App\Enum\PaymentStatus::PENDING_PAYMENT);
            $table->text('note')->nullable();
            $table->unsignedInteger('subtotal')->default(0);
            $table->unsignedInteger('discount')->default(0);
            $table->float('discount_percentage')->default(0.0);
            $table->unsignedInteger('tax')->default(0);
            $table->float('tax_percentage')->default(0.0);
            $table->unsignedInteger('additional_fee')->default(0);
            $table->unsignedInteger('grand_total')->default(0);
            $table->foreignId('user_id')->nullable()->constrained()->cascadeOnUpdate();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};
