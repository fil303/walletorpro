<?php

namespace Database\Seeders;

use App\Models\SiteSetting;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class SiteSettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Basic Settings 
        SiteSetting::firstOrCreate(["slug" => "app_name"],["value" => ""]);
        SiteSetting::firstOrCreate(["slug" => "record_per_page"],["value" => ""]);
        SiteSetting::firstOrCreate(["slug" => "app_timezone"],["value" => ""]);
        SiteSetting::firstOrCreate(["slug" => "app_language"],["value" => ""]);
        SiteSetting::firstOrCreate(["slug" => "app_address"],["value" => ""]);
        SiteSetting::firstOrCreate(["slug" => "app_email"],["value" => ""]);
        SiteSetting::firstOrCreate(["slug" => "app_phone"],["value" => ""]);
        SiteSetting::firstOrCreate(["slug" => "app_footer_text"],["value" => ""]);
        SiteSetting::firstOrCreate(["slug" => "app_new_user_registration"],["value" => ""]);
        SiteSetting::firstOrCreate(["slug" => "app_user_secure_password"],["value" => ""]);
        SiteSetting::firstOrCreate(["slug" => "app_agree_policy"],["value" => ""]);
        SiteSetting::firstOrCreate(["slug" => "app_force_ssl"],["value" => ""]);
        SiteSetting::firstOrCreate(["slug" => "app_email_verification"],["value" => ""]);
        SiteSetting::firstOrCreate(["slug" => "app_email_notification"],["value" => ""]);
        SiteSetting::firstOrCreate(["slug" => "app_push_notification"],["value" => ""]);
        SiteSetting::firstOrCreate(["slug" => "app_kyc_verification"],["value" => ""]);

        // Email Setting
        SiteSetting::firstOrCreate(["slug" => "email_host"],["value" => ""]);
        SiteSetting::firstOrCreate(["slug" => "email_port"],["value" => ""]);
        SiteSetting::firstOrCreate(["slug" => "email_username"],["value" => ""]);
        SiteSetting::firstOrCreate(["slug" => "email_password"],["value" => ""]);
        SiteSetting::firstOrCreate(["slug" => "email_encryption"],["value" => ""]);
        SiteSetting::firstOrCreate(["slug" => "email_from"],["value" => ""]);

        // SMS Twilio Setting
        SiteSetting::firstOrCreate(["slug" => "sms_twilio_sid"],["value" =>   ""]);
        SiteSetting::firstOrCreate(["slug" => "sms_twilio_token"],["value" => ""]);
        SiteSetting::firstOrCreate(["slug" => "sms_twilio_phone"],["value" => ""]);

        // Logo & Favicon
        SiteSetting::firstOrCreate(["slug" => "app_logo"],["value" => "logo/app-logo.png"]);
        SiteSetting::firstOrCreate(["slug" => "app_fav"],["value" => "logo/app-favicon.png"]);
    }
}
