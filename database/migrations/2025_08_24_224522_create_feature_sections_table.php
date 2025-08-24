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
        Schema::create('feature_sections', function (Blueprint $table) {
            $table->id();
            $table->string('slug')->unique(); // حقل فريد لتعريف السكشن، مثل "shipping-agents"
            $table->string('title_before_highlight');
            $table->string('highlighted_title');
            $table->string('title_after_highlight');
            $table->text('description');
            $table->string('button_text');
            $table->string('button_url');
            $table->string('image_path');
            $table->string('image_alt')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('feature_sections');
    }
};
