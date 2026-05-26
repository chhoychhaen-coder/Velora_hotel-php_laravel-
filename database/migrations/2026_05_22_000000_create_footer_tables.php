<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('footer_settings', function (Blueprint $table) {
            $table->id();
            $table->string('brand_name')->default('Velora Hotel');
            $table->text('tagline')->nullable();
            $table->string('company_section_title')->default('Company');
            $table->string('guest_section_title')->default('Guest');
            $table->string('contact_section_title')->default('Contact');
            $table->string('address')->nullable();
            $table->string('phone')->nullable();
            $table->string('email')->nullable();
            $table->string('copyright_text')->default('Velora Hotel. All rights reserved.');
            $table->string('bottom_link_label')->default('Back to home');
            $table->string('bottom_link_url')->default('/');
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        Schema::create('footer_links', function (Blueprint $table) {
            $table->id();
            $table->string('group')->default('company');
            $table->string('label');
            $table->string('url')->nullable();
            $table->string('route_name')->nullable();
            $table->string('icon')->nullable();
            $table->unsignedInteger('sort_order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('footer_links');
        Schema::dropIfExists('footer_settings');
    }
};
