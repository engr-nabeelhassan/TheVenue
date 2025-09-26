<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('booking_items', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('booking_id');

            $table->unsignedInteger('sr_no');
            $table->string('item_description');
            $table->decimal('quantity', 12, 2)->default(0);
            $table->decimal('rate', 12, 2)->default(0);
            $table->enum('discount_type', ['percent', 'lump']);
            $table->decimal('discount_value', 12, 2)->default(0); // if percent, store percent value; if lump, store amount
            $table->decimal('net_amount', 12, 2)->default(0);

            $table->timestamps();

            $table->foreign('booking_id')->references('id')->on('bookings')->cascadeOnUpdate()->cascadeOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('booking_items');
    }
};


