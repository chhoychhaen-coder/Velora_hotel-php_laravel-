<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('payments', function (Blueprint $table) {
            if (! Schema::hasColumn('payments', 'bank_transfer_id')) {
                $table->foreignId('bank_transfer_id')
                    ->nullable()
                    ->after('method')
                    ->constrained('bank_transfers')
                    ->nullOnDelete();
            }
        });

        if (Schema::hasColumn('payments', 'payment_setting_id')) {
            DB::table('payments')
                ->whereNotNull('payment_setting_id')
                ->update(['bank_transfer_id' => DB::raw('payment_setting_id')]);
        }
    }

    public function down(): void
    {
        Schema::table('payments', function (Blueprint $table) {
            if (Schema::hasColumn('payments', 'bank_transfer_id')) {
                $table->dropConstrainedForeignId('bank_transfer_id');
            }
        });
    }
};
