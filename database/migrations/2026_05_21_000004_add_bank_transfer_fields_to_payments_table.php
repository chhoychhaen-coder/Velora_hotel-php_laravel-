<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('payments', function (Blueprint $table) {
            if (! Schema::hasColumn('payments', 'bank_sender_name')) {
                $table->string('bank_sender_name')->nullable()->after('receipt_path');
            }

            if (! Schema::hasColumn('payments', 'bank_reference')) {
                $table->string('bank_reference')->nullable()->after('bank_sender_name');
            }
        });
    }

    public function down(): void
    {
        Schema::table('payments', function (Blueprint $table) {
            if (Schema::hasColumn('payments', 'bank_reference')) {
                $table->dropColumn('bank_reference');
            }

            if (Schema::hasColumn('payments', 'bank_sender_name')) {
                $table->dropColumn('bank_sender_name');
            }
        });
    }
};
