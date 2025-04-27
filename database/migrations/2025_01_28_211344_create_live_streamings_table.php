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
        Schema::create('live_streamings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->unsignedBigInteger('agency_id')->nullable();
            $table->string('title');
            $table->text('description')->nullable();
            $table->bigInteger('live_streaming_id')->unique()->nullable()->comment('ID of the live streaming from the streaming platform');
            $table->string('thumbnail')->nullable()->comment('URL of the thumbnail image');
            $table->string('password')->nullable()->comment('Password for the live stream');

            $table->enum('status', ['pending', 'live', 'completed', 'cancelled'])->default('live');
            $table->timestamp('scheduled_at')->nullable();

            $table->timestamps();
            $table->foreign('agency_id')->references('id')->on('agencies')->onDelete('cascade');
        });
    }
 
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('live_streamings');
    }
};
