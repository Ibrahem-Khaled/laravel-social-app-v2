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
        Schema::create('contact_messages', function (Blueprint $table) {
            // مفاتيح أساسية حديثة وقابلة للتجزئة أفقياً
            $table->ulid('id')->primary(); // ULID مدعوم في Laravel
            // إن كان المستخدم مسجلاً
            $table->foreignId('user_id')->nullable()
                ->constrained()->nullOnDelete(); // مهم: nullable قبل constrained

            // بيانات الزائر (عند عدم تسجيل الدخول)
            $table->string('guest_name')->nullable();
            $table->string('guest_email')->nullable()->index();
            $table->string('guest_phone', 30)->nullable();

            // محتوى الطلب
            $table->string('subject', 200);
            $table->longText('message');

            // تصنيفات وإدارة التذاكر
            $table->enum('status', ['open', 'pending', 'closed', 'spam'])->default('open');
            $table->enum('priority', ['low', 'normal', 'high', 'urgent'])->default('normal');
            $table->enum('category', ['general', 'support', 'sales', 'bug', 'feedback'])->default('general');
            $table->enum('source', ['web', 'mobile', 'api'])->default('web');

            // تتبع المسؤول عن الردّ (موظف دعم)
            $table->foreignId('assigned_to_id')->nullable()
                ->constrained('users')->nullOnDelete();

            // ميتاداتا مفيدة
            $table->ipAddress('ip_address')->nullable();
            $table->text('user_agent')->nullable();
            $table->timestamp('replied_at')->nullable();
            $table->json('meta')->nullable();

            $table->timestamps();
            $table->softDeletes();

            // فهارس لتحسين الاستعلام
            $table->index(['status', 'priority']);
            $table->index(['created_at']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('contact_messages');
    }
};
