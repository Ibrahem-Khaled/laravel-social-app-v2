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
        Schema::create('games', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // اسم اللعبة
            $table->string('image'); // مسار الصورة
            $table->text('url'); // رابط اللعبة
            $table->integer('position')->default(0); // للتحكم في ترتيب العرض
            $table->boolean('is_active')->default(true); // لتفعيل أو إخفاء اللعبة
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('games');
    }
};
