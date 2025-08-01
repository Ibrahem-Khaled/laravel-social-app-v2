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
        Schema::create('user_gifts', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('sender_id')->nullable();
            $table->unsignedBigInteger('receiver_id');
            $table->unsignedBigInteger('gift_id');

            $table->foreignId('live_streaming_id')->constrained('live_streamings')->cascadeOnDelete(); // <-- ربط بالبث
            $table->foreignId('pk_battle_id')->nullable()->constrained('pk_battles')->nullOnDelete(); // <-- ربط بالجولة

            $table->integer('quantity')->default(1);
            $table->timestamps();

            $table->foreign('sender_id')->references('id')->on('users')->onDelete('set null');
            $table->foreign('receiver_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('gift_id')->references('id')->on('gifts')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_gifts');
    }
};
