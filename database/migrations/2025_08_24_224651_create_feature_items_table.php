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
        Schema::create('feature_items', function (Blueprint $table) {
            $table->id();

            // الربط بالجدول الرئيسي الجديد
            $table->foreignId('feature_section_id')
                ->constrained('feature_sections') // اسم الجدول الرئيسي
                ->onDelete('cascade');

            $table->string('text'); // نص الميزة
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('feature_items');
    }
};
