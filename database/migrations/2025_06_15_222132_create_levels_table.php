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
        Schema::create('levels', function (Blueprint $table) {
            $table->id();

            $table->unsignedInteger('level_number')->unique()->comment('رقم المستوى مثل 1، 2، 3...');
            $table->string('name')->nullable()->comment('اسم المستوى مثل "مبتدئ" أو "أسطورة"');
            $table->string('color')->nullable()->comment('لون مميز للمستوى بصيغة HEX مثل #FFD700');
            $table->string('icon')->nullable()->comment('مسار أو اسم ملف الأيقونة');
            $table->unsignedBigInteger('points_required')->default(0)->comment('عدد النقاط المطلوبة للوصول للمستوى');
            $table->boolean('is_active')->default(true)->comment('تفعيل أو تعطيل هذا المستوى');
            $table->text('description')->nullable()->comment('وصف المستوى');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('levels');
    }
};
