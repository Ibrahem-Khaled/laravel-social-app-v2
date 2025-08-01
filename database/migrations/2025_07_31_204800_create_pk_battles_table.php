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
        Schema::create('pk_battles', function (Blueprint $table) {
            $table->id();
            // ربط الجولة بالبث الأساسي
            $table->foreignId('live_streaming_id')->constrained('live_streamings')->cascadeOnDelete();

            // المذيعين المتنافسين
            $table->foreignId('host_one_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('host_two_id')->constrained('users')->cascadeOnDelete();

            // نتائج الجولة
            $table->unsignedBigInteger('host_one_score')->default(0);
            $table->unsignedBigInteger('host_two_score')->default(0);
            $table->foreignId('winner_id')->nullable()->constrained('users')->nullOnDelete();

            // حالة الجولة وتوقيتها
            $table->enum('status', ['requested', 'active', 'finished', 'cancelled'])->default('requested');
            $table->timestamp('started_at')->nullable();
            $table->timestamp('ends_at')->nullable(); // يحدد عند بدء الجولة (مثلاً: الآن + 5 دقائق)

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pk_battles');
    }
};
