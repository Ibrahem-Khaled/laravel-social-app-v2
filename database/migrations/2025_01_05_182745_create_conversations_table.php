<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('conversations', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();              // اسم الجروب (اختياري للمحادثات الثنائية)
            $table->boolean('is_group')->default(false);     // هل هذه محادثة جماعية؟
            $table->unsignedBigInteger('created_by');
            $table->text('description')->nullable();             // وصف المحادثة (اختياري)
            $table->string('image')->nullable();             // صورة المحادثة (اختياري)
            $table->enum('type',['normal', 'private'])->default('normal');       // نوع المحادثة (عادي، خاص، أو غيره)
            $table->timestamps();

            $table->foreign('created_by')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('conversations');
    }
};
