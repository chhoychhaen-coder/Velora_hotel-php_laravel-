<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('contact_pages', function (Blueprint $table) {
            $table->id();
            $table->string('section_label')->default('Contact Us');
            $table->string('title')->default('Contact');
            $table->string('title_highlight')->default('For Any Query');
            $table->text('map_embed_url')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        Schema::create('contact_info_items', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('email');
            $table->unsignedInteger('sort_order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('contact_info_items');
        Schema::dropIfExists('contact_pages');
    }
};
