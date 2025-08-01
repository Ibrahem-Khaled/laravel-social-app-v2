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
            $table->string('title')->nullable();
            $table->text('description')->nullable();
            $table->string('channel_name')->unique()->nullable()->comment('Unique channel name for the live stream');
            $table->string('thumbnail')->nullable()->comment('URL of the thumbnail image');
            $table->string('password')->nullable()->comment('Password for the live stream');

            $table->enum('type', ['live', 'audio_room'])->default('live');
            $table->enum('status', ['scheduled', 'live', 'ended'])->default('live'); // <-- تعديل مهم
            $table->bigInteger('likes')->default(0);
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
