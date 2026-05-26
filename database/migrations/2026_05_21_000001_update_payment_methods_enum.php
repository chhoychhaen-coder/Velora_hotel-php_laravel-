<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::table('payments')
            ->whereIn('method', ['paypal', 'cash'])
            ->update(['method' => 'credit_card']);

        if (DB::connection()->getDriverName() === 'sqlite') {
            return;
        }

        DB::statement("ALTER TABLE payments MODIFY method ENUM('credit_card', 'visa_card', 'mastercard', 'bank_transfer') NOT NULL");
    }

    public function down(): void
    {
        DB::table('payments')
            ->whereIn('method', ['visa_card', 'mastercard'])
            ->update(['method' => 'credit_card']);

        if (DB::connection()->getDriverName() === 'sqlite') {
            return;
        }

        DB::statement("ALTER TABLE payments MODIFY method ENUM('credit_card', 'paypal', 'bank_transfer', 'cash') NOT NULL");
    }
};
