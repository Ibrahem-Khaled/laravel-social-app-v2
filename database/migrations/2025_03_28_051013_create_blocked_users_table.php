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
        Schema::create('blocked_users', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');          // المستخدم الذي يقوم بالحظر
            $table->unsignedBigInteger('blocked_user_id');    // المستخدم الذي تم حظره
            $table->timestamps();

            // تعريف المفاتيح الخارجية
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('blocked_user_id')->references('id')->on('users')->onDelete('cascade');

            // التأكد من عدم تكرار العلاقة لنفس الثنائي
            $table->unique(['user_id', 'blocked_user_id']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('blocked_users');
    }
};
