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
        Schema::create('conversation_users', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('conversation_id');
            $table->unsignedBigInteger('user_id');
            $table->enum('role', ['admin', 'member', 'moderator'])->default('member'); // دور المستخدم في المحادثة (مدير أو عضو)
            $table->boolean('is_muted')->default(false); // هل المستخدم مكتوم في المحادثة؟
            $table->boolean('is_blocked')->default(false); // هل المستخدم محظور في المحادثة؟
            $table->boolean('is_archived')->default(false); // هل المحادثة مؤرشفة؟
            $table->boolean('is_favorite')->default(false); // هل المحادثة مفضلة؟
            $table->timestamps();

            // Foreign key constraints
            $table->foreign('conversation_id')->references('id')->on('conversations')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('conversation_users');
    }
};
