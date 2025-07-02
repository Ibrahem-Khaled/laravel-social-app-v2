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
        Schema::create('wallets', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('wallet_name'); // اسم المحفظة (مثال: حسابي البنكي، محفظة فودافون)
            $table->string('wallet_type'); //  'bank_account', 'e_wallet', 'crypto', etc.
            $table->text('wallet_details'); // سيتم تشفيره
            $table->string('password')->nullable(); // كلمة مرور خاصة بالمحفظة (Hashed)
            $table->boolean('is_default')->default(false); // لتحديد المحفظة الافتراضية
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('wallets');
    }
};
