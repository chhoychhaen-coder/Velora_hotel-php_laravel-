<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('about_pages', function (Blueprint $table) {
            $table->id();
            $table->string('section_label')->default('About Us');
            $table->string('title')->default('Welcome to');
            $table->string('title_highlight')->default('Velora Hotel');
            $table->text('paragraph_one')->nullable();
            $table->text('paragraph_two')->nullable();
            $table->string('button_label')->default('Explore More');
            $table->string('button_link')->default('/booking');
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        Schema::create('about_features', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->unsignedInteger('sort_order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        Schema::create('about_gallery_images', function (Blueprint $table) {
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
        Schema::dropIfExists('about_gallery_images');
        Schema::dropIfExists('about_features');
        Schema::dropIfExists('about_pages');
    }
};
