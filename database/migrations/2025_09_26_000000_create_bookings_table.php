<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('bookings', function (Blueprint $table) {
            $table->id();
            $table->date('invoice_date');
            $table->unsignedBigInteger('customer_id');
            $table->string('customer_name');
            $table->string('event_type'); // Wedding, Birthday, Corporate, Other
            $table->unsignedInteger('total_guests')->default(0);

            // Multi-day event support: store start and end datetime
            $table->dateTime('event_start_at');
            $table->dateTime('event_end_at');
            $table->enum('event_status', ['In Progress', 'Completed', 'Cancelled', 'Postponed'])->default('In Progress');

            // Payment fields
            $table->string('payment_status'); // Cash, Cheque, Online Transaction
            $table->enum('payment_option', ['advance', 'full'])->nullable();
            $table->decimal('advance_amount', 12, 2)->default(0);

            // Totals
            $table->decimal('items_subtotal', 12, 2)->default(0);
            $table->decimal('items_discount_amount', 12, 2)->default(0);
            $table->decimal('invoice_net_amount', 12, 2)->default(0);
            $table->decimal('invoice_total_paid', 12, 2)->default(0);
            $table->decimal('invoice_closing_amount', 12, 2)->default(0);
            $table->string('amount_in_words')->nullable();

            $table->text('remarks')->nullable();

            $table->timestamps();

            // Defer adding FK to a later migration to avoid ordering issues in fresh installs
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('bookings');
    }
};


