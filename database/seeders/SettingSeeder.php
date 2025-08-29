<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('settings')->insert([
            ['key' => 'android_app_url', 'value' => ''],
            ['key' => 'ios_app_url', 'value' => ''],
            ['key' => 'promotional_video_url', 'value' => ''],
            ['key' => 'visitor_counter', 'value' => '0'],
            ['key' => 'facebook_url', 'value' => ''],
            ['key' => 'twitter_url', 'value' => ''],
            ['key' => 'instagram_url', 'value' => ''],
            ['key' => 'linkedin_url', 'value' => ''],
            ['key' => 'youtube_url', 'value' => ''],
        ]);
    }
}
