<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('uuid')->unique();
            $table->string('username')->unique();
            $table->string('name');
            $table->string('email')->unique();
            $table->string('phone')->nullable()->unique();
            $table->string('avatar')->nullable();
            $table->text('bio')->nullable();
            $table->string('address')->nullable();
            $table->string('country')->nullable();
            $table->string('website')->nullable();
            $table->json('social_links')->nullable();
            $table->boolean('is_verified')->default(false);
            $table->enum('status', ['active', 'inactive', 'banned'])->default('active');
            $table->enum('gender', ['male', 'female'])->default('male')->nullable();
            $table->enum('role', ['admin', 'moderator', 'user', 'vip', 'streamer', 'website-data'])->default('user');
            $table->string('language')->default('ar');
            $table->text('expo_push_token')->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->date('birth_date')->nullable();
            $table->string('password')->nullable();
            $table->json('settings')->nullable();
            $table->rememberToken();
            $table->bigInteger('coins')->default(0);
            $table->bigInteger('points')->default(0);
            $table->timestamps();
        });

        DB::table('users')->insert([
            [
                'uuid' => 1,
                'username' => 'admin',
                'name' => 'Admin',
                'email' => 'admin@gmail.com',
                'password' => bcrypt('12345678'),
                'role' => 'admin',
                'is_verified' => true,
                'status' => 'active',
                'gender' => 'male',
                'language' => 'en',
            ],
            [
                'uuid' => 2,
                'username' => 'moderator',
                'name' => 'Moderator',
                'email' => 'moderator@gmail.com',
                'password' => bcrypt('12345678'),
                'role' => 'website-data',
                'is_verified' => true,
                'status' => 'active',
                'gender' => 'male',
                'language' => 'en',
            ]
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
