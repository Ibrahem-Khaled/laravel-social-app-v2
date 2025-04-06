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
        Schema::create('notifications', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->nullable(); // المستخدم المستلم للإشعار
            $table->text('message'); // نص الإشعار
            $table->boolean('is_read')->default(false); // حالة الإشعار (مقروء/غير مقروء)
            $table->unsignedBigInteger('related_id')->nullable(); // معرف الكائن المرتبط بالإشعار (مثل معرف المنشور أو المحادثة)
            $table->string('related_type')->nullable(); // نوع الكائن المرتبط بالإشعار (مثل "post" أو "conversation")
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('notifications');
    }
};
