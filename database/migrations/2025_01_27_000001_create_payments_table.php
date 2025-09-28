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
            $table->foreignId('booking_id')->constrained()->onDelete('cascade');
            $table->foreignId('customer_id')->constrained()->onDelete('cascade');
            $table->string('customer_name');
            $table->string('contact');
            $table->date('receipt_date');
            $table->enum('payment_method', ['Debit', 'Credit']);
            $table->enum('payment_status', ['Cash', 'Cheque', 'Online Transaction']);
            $table->decimal('previous_balance', 10, 2)->default(0);
            $table->decimal('add_amount', 10, 2)->default(0);
            $table->decimal('remaining_balance', 10, 2)->default(0);
            $table->text('remarks')->nullable();
            $table->timestamps();
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
