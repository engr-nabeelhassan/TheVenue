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
            // Use unsigned big integers initially to avoid FK issues if parent tables don't exist yet
            $table->unsignedBigInteger('booking_id');
            $table->unsignedBigInteger('customer_id');
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

            $table->index('booking_id');
            $table->index('customer_id');
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
