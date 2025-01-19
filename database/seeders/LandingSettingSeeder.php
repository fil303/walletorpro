<?php

namespace Database\Seeders;

use App\Models\LandingSetting;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class LandingSettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // colors
        LandingSetting::firstOrCreate(["slug" => "primary_color"],   ["value" => "#1e40af"]);
        LandingSetting::firstOrCreate(["slug" => "secondary_color"], ["value" => "#f97316"]);
        LandingSetting::firstOrCreate(["slug" => "success_color"],   ["value" => "#22c55e"]);
        LandingSetting::firstOrCreate(["slug" => "info_color"],      ["value" => "#0ea5e9"]);

        // hero section
        LandingSetting::firstOrCreate(["slug" => "hero_section_badge_text"], ["value" => "All-in-One Crypto Solution"]);
        LandingSetting::firstOrCreate(["slug" => "hero_section_heading"],    ["value" => "Your Digital Wallet for a Smarter Future"]);
        LandingSetting::firstOrCreate(["slug" => "hero_section_subheading"], ["value" => "The ultimate app for buying, staking, and exchanging crypto, with a secure personal wallet. Take control of your crypto with unique wallets and effortless transactions"]);
        LandingSetting::firstOrCreate(["slug" => "hero_section_cta_text"],   ["value" => "Get Started"]);
        LandingSetting::firstOrCreate(["slug" => "hero_section_image"],      ["value" => "images/landing-hero-section-image.png"]);

        // about section
        LandingSetting::firstOrCreate(["slug" => "about_section_badge_text"], ["value" => "About Our Platform"]);
        LandingSetting::firstOrCreate(["slug" => "about_section_title"], ["value" => "Your Partner in the Crypto Revolution"]);
        LandingSetting::firstOrCreate(["slug" => "about_section_description"], ["value" => "Our mission is to make cryptocurrency accessible and secure for everyone. With a user-friendly interface, powerful features like staking and real-time exchanges, and a secure wallet system, we’re here to support your crypto journey every step of the way."]);
        LandingSetting::firstOrCreate(["slug" => "about_section_image"], ["value" => "images/landing-about-section-image.png"]);

        // how section
        LandingSetting::firstOrCreate(["slug" => "how_section_badge_text"], ["value" => "How It Works"]);
        LandingSetting::firstOrCreate(["slug" => "how_section_title"], ["value" => "How It Works"]);
        LandingSetting::firstOrCreate(["slug" => "how_section_step1_title"], ["value" => "Select Coin"]);
        LandingSetting::firstOrCreate(["slug" => "how_section_step1_description"], ["value" => "Choose the cryptocurrency you want to buy or sell"]);
        LandingSetting::firstOrCreate(["slug" => "how_section_step2_title"], ["value" => "Enter Amount"]);
        LandingSetting::firstOrCreate(["slug" => "how_section_step2_description"], ["value" => "Specify the amount and choose payment method"]);
        LandingSetting::firstOrCreate(["slug" => "how_section_step3_title"], ["value" => "Complete Transaction"]);
        LandingSetting::firstOrCreate(["slug" => "how_section_step3_description"], ["value" => "Confirm and receive coins in your wallet"]);
        LandingSetting::firstOrCreate(["slug" => "how_section_staking_step1_title"], ["value" => "Choose Staking Plan"]);
        LandingSetting::firstOrCreate(["slug" => "how_section_staking_step1_description"], ["value" => "Select from available coins and durations"]);
        LandingSetting::firstOrCreate(["slug" => "how_section_staking_step2_title"], ["value" => "Lock Period"]);
        LandingSetting::firstOrCreate(["slug" => "how_section_staking_step2_description"], ["value" => "Lock your assets for the chosen duration"]);
        LandingSetting::firstOrCreate(["slug" => "how_section_staking_step3_title"], ["value" => "Earn Rewards"]);
        LandingSetting::firstOrCreate(["slug" => "how_section_staking_step3_description"], ["value" => "Receive staking rewards after completion"]);
        LandingSetting::firstOrCreate(["slug" => "how_section_exchange_step1_title"], ["value" => "Select Pairs"]);
        LandingSetting::firstOrCreate(["slug" => "how_section_exchange_step1_description"], ["value" => "Choose the cryptocurrencies to exchange"]);
        LandingSetting::firstOrCreate(["slug" => "how_section_exchange_step2_title"], ["value" => "View Rate"]);
        LandingSetting::firstOrCreate(["slug" => "how_section_exchange_step2_description"], ["value" => "Check live exchange rates"]);
        LandingSetting::firstOrCreate(["slug" => "how_section_exchange_step3_title"], ["value" => "Confirm Swap"]);
        LandingSetting::firstOrCreate(["slug" => "how_section_exchange_step3_description"], ["value" => "Complete the exchange securely"]);

        // service section
        LandingSetting::firstOrCreate(["slug" => "service_section_badge_text"], ["value" => "Our Services"]);
        LandingSetting::firstOrCreate(["slug" => "service_section_title"], ["value" => "Comprehensive Crypto Solutions"]);
        LandingSetting::firstOrCreate(["slug" => "service_section_description"], ["value" => "Explore our range of services designed to meet your cryptocurrency needs"]);
        LandingSetting::firstOrCreate(["slug" => "service_section_feature1_title"], ["value" => "Purchase Crypto"]);
        LandingSetting::firstOrCreate(["slug" => "service_section_feature1_description"], ["value" => "Purchase cryptocurrencies easily with competitive rates and multiple payment options."]);
        LandingSetting::firstOrCreate(["slug" => "service_section_feature2_title"], ["value" => "Staking"]);
        LandingSetting::firstOrCreate(["slug" => "service_section_feature2_description"], ["value" => "Earn passive income by staking your crypto assets with competitive APY rates."]);
        LandingSetting::firstOrCreate(["slug" => "service_section_feature3_title"], ["value" => "Exchange"]);
        LandingSetting::firstOrCreate(["slug" => "service_section_feature3_description"], ["value" => "Swap between different cryptocurrencies instantly with best market rates."]);
        LandingSetting::firstOrCreate(["slug" => "service_section_image"], ["value" => "images/landing-service-section-image.png"]);

        // wallet section
        LandingSetting::firstOrCreate(["slug" => "wallet_section_badge_text"], ["value" => "Secure. Fast. Reliable."]);
        LandingSetting::firstOrCreate(["slug" => "wallet_section_title"], ["value" => "Personal Wallet Features"]);
        LandingSetting::firstOrCreate(["slug" => "wallet_section_feature1_title"],       ["value" => "Unique Addresses"]);
        LandingSetting::firstOrCreate(["slug" => "wallet_section_feature1_description"], ["value" => "Get individual wallet addresses for each supported cryptocurrency"]);
        LandingSetting::firstOrCreate(["slug" => "wallet_section_feature2_title"],       ["value" => "Secure Storage"]);
        LandingSetting::firstOrCreate(["slug" => "wallet_section_feature2_description"], ["value" => "Your assets are stored in secure, encrypted wallets"]);
        LandingSetting::firstOrCreate(["slug" => "wallet_section_feature3_title"],       ["value" => "Easy Transfers"]);
        LandingSetting::firstOrCreate(["slug" => "wallet_section_feature3_description"], ["value" => "Deposit and withdraw cryptocurrencies with ease"]);
        LandingSetting::firstOrCreate(["slug" => "wallet_section_feature4_title"],       ["value" => "Multi-Currency Support"]);
        LandingSetting::firstOrCreate(["slug" => "wallet_section_feature4_description"], ["value" => "Support for a wide range of cryptocurrencies"]);
        LandingSetting::firstOrCreate(["slug" => "wallet_section_feature5_title"],       ["value" => "Transaction History"]);
        LandingSetting::firstOrCreate(["slug" => "wallet_section_feature5_description"], ["value" => "Track all your wallet transactions in one place"]);
        LandingSetting::firstOrCreate(["slug" => "wallet_section_feature6_title"],       ["value" => "24/7 Access"]);
        LandingSetting::firstOrCreate(["slug" => "wallet_section_feature6_description"], ["value" => "Access your wallet anytime, anywhere"]);

        // testimonial section
        LandingSetting::firstOrCreate(["slug" => "testimonial_section_badge_text"], ["value" => "User Stories"]);
        LandingSetting::firstOrCreate(["slug" => "testimonial_section_title"], ["value" => "Our Users Speak for Us"]);
        LandingSetting::firstOrCreate(["slug" => "testimonial_section_description"], ["value" => "Our users are at the heart of everything we do. See how they’ve unlocked new opportunities in the crypto space with our reliable and feature-rich platform."]);

        // FAQ Section
        LandingSetting::firstOrCreate(["slug" => "faq_section_badge_text"], ["value" => "Got Questions?"]);
        LandingSetting::firstOrCreate(["slug" => "faq_section_title"], ["value" => "Frequently Asked Questions"]);
        LandingSetting::firstOrCreate(["slug" => "faq_section_description"], ["value" => "We’ve compiled answers to the most common questions about our platform. Can’t find what you’re looking for? Reach out to our support team."]);
        LandingSetting::firstOrCreate(["slug" => "faq_section_image"], ["value" => "images/landing-faq-section-image.png"]);
        
        // Social Network
        LandingSetting::firstOrCreate(["slug" => "social_facebook_url"], ["value" => "#"]);
        LandingSetting::firstOrCreate(["slug" => "social_twitter_url"],  ["value" => "#"]);
        LandingSetting::firstOrCreate(["slug" => "social_linkedin_url"], ["value" => "#"]);
    }
}
