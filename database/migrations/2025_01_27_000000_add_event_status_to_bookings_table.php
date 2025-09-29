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
        if (Schema::hasTable('bookings') && !Schema::hasColumn('bookings', 'event_status')) {
            Schema::table('bookings', function (Blueprint $table) {
                $table->enum('event_status', ['In Progress', 'Completed', 'Cancelled', 'Postponed'])->default('In Progress')->after('event_end_at');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasTable('bookings') && Schema::hasColumn('bookings', 'event_status')) {
            Schema::table('bookings', function (Blueprint $table) {
                $table->dropColumn('event_status');
            });
        }
    }
};