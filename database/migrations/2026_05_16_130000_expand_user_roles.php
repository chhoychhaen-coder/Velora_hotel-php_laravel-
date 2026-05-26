<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        if (DB::connection()->getDriverName() === 'sqlite') {
            DB::table('users')->where('role', 'guest')->update(['role' => 'customer']);
            DB::table('users')->where('role', 'staff')->update(['role' => 'receptionist']);

            return;
        }

        DB::statement("ALTER TABLE users MODIFY role ENUM('customer', 'receptionist', 'manager', 'admin', 'guest', 'staff') NOT NULL DEFAULT 'customer'");
        DB::table('users')->where('role', 'guest')->update(['role' => 'customer']);
        DB::table('users')->where('role', 'staff')->update(['role' => 'receptionist']);
        DB::statement("ALTER TABLE users MODIFY role ENUM('customer', 'receptionist', 'manager', 'admin') NOT NULL DEFAULT 'customer'");
    }

    public function down(): void
    {
        if (DB::connection()->getDriverName() === 'sqlite') {
            DB::table('users')->where('role', 'customer')->update(['role' => 'guest']);
            DB::table('users')->where('role', 'receptionist')->update(['role' => 'staff']);
            DB::table('users')->where('role', 'manager')->update(['role' => 'admin']);

            return;
        }

        DB::statement("ALTER TABLE users MODIFY role ENUM('customer', 'receptionist', 'manager', 'admin', 'guest', 'staff') NOT NULL DEFAULT 'guest'");
        DB::table('users')->where('role', 'customer')->update(['role' => 'guest']);
        DB::table('users')->where('role', 'receptionist')->update(['role' => 'staff']);
        DB::table('users')->where('role', 'manager')->update(['role' => 'admin']);
        DB::statement("ALTER TABLE users MODIFY role ENUM('guest', 'admin', 'staff') NOT NULL DEFAULT 'guest'");
    }
};
