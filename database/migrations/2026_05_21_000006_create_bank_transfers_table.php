<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('bank_transfers', function (Blueprint $table) {
            $table->id();
            $table->string('bank_name');
            $table->string('account_name');
            $table->string('account_number');
            $table->string('qr_code_path')->nullable();
            $table->timestamps();
        });

        if (Schema::hasTable('payment_settings')) {
            DB::table('payment_settings')
                ->orderBy('id')
                ->get()
                ->each(function ($setting): void {
                    DB::table('bank_transfers')->insert([
                        'id' => $setting->id,
                        'bank_name' => $setting->bank_name ?: 'Bank Transfer',
                        'account_name' => $setting->account_name ?: 'Account',
                        'account_number' => $setting->account_number ?: 'N/A',
                        'qr_code_path' => $setting->qr_code_path,
                        'created_at' => $setting->created_at,
                        'updated_at' => $setting->updated_at,
                    ]);
                });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('bank_transfers');
    }
};
