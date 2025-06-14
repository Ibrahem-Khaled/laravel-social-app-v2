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
        Schema::create('sell_coins', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('amount')->default(0);
            $table->float('price')->default(0);
            $table->text('icon')->nullable();
            $table->boolean('is_active')->default(true);
            $table->enum('platform', ['mobile', 'web'])->default('mobile');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sell_coins');
    }
};
