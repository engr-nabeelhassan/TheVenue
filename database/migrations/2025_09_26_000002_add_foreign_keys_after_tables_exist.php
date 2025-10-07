<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasTable('bookings') && Schema::hasTable('customers')) {
            Schema::table('bookings', function (Blueprint $table) {
                if (!Schema::hasColumn('bookings', 'customer_id')) {
                    return;
                }
                
                $table->foreign('customer_id')
                    ->references('id')
                    ->on('customers')
                    ->cascadeOnUpdate()
                    ->restrictOnDelete();
            });
        }

        if (Schema::hasTable('payments')) {
            Schema::table('payments', function (Blueprint $table) {
                if (Schema::hasTable('bookings') && Schema::hasColumn('payments', 'booking_id')) {
                    $table->foreign('booking_id')
                        ->references('id')
                        ->on('bookings')
                        ->cascadeOnDelete();
                }
                
                if (Schema::hasTable('customers') && Schema::hasColumn('payments', 'customer_id')) {
                    $table->foreign('customer_id')
                        ->references('id')
                        ->on('customers')
                        ->cascadeOnDelete();
                }
            });
        }
    }

    public function down(): void
    {
        // No need to drop foreign keys in down() since migrate:fresh drops all tables
        // Individual rollback is handled by try-catch in up() method
    }
};


