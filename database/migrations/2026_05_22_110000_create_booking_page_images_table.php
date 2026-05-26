<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('booking_page_images', function (Blueprint $table) {
            $table->id();
            $table->string('image_path')->nullable();
            $table->string('size_class')->default('w-100');
            $table->string('align_class')->default('text-start');
            $table->string('extra_style')->nullable();
            $table->unsignedInteger('sort_order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('booking_page_images');
    }
};
