<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasTable('bookings') && Schema::hasTable('customers')) {
            Schema::table('bookings', function (Blueprint $table) {
                if (!Schema::hasColumn('bookings', 'customer_id')) {
                    return;
                }
                try { $table->dropForeign(['customer_id']); } catch (Throwable $e) {}
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
                    try { $table->dropForeign(['booking_id']); } catch (Throwable $e) {}
                    $table->foreign('booking_id')
                        ->references('id')
                        ->on('bookings')
                        ->cascadeOnDelete();
                }
                if (Schema::hasTable('customers') && Schema::hasColumn('payments', 'customer_id')) {
                    try { $table->dropForeign(['customer_id']); } catch (Throwable $e) {}
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
        if (Schema::hasTable('payments')) {
            Schema::table('payments', function (Blueprint $table) {
                // Drop FKs if they exist
                try { $table->dropForeign(['booking_id']); } catch (Throwable $e) {}
                try { $table->dropForeign(['customer_id']); } catch (Throwable $e) {}
            });
        }

        if (Schema::hasTable('bookings')) {
            Schema::table('bookings', function (Blueprint $table) {
                try { $table->dropForeign(['customer_id']); } catch (Throwable $e) {}
            });
        }
    }
};


