<?php

namespace Database\Seeders;

use App\Models\Faq;
use App\Enums\FaqPages;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class FaqSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        if(!Faq::first()){
            $faqs = [
                [
                    "uid"      => uniqueCode("FAQ"),
                    "question" => "How do I buy cryptocurrency on your platform?",
                    "answer"   => "To buy cryptocurrency, select the coin you want to purchase, specify the amount, choose a payment method, and complete the payment. Once the payment is processed, the purchased coins will be deposited into your personal wallet.",
                    "page"     => FaqPages::HOME->value,
                    "lang"     => 'en',
                    "status"   => true,
                ],
                [
                    "uid"      => uniqueCode("FAQ"),
                    "question" => "What is the process for selling cryptocurrency?",
                    "answer"   => "To sell cryptocurrency, select the coin you want to sell, specify the amount, and submit your request. The sale will be processed after admin confirmation, and the payment will be credited to your preferred payment method.",
                    "page"     => FaqPages::HOME->value,
                    "lang"     => 'en',
                    "status"   => true,
                ],
                [
                    "uid"      => uniqueCode("FAQ"),
                    "question" => "What is staking, and how does it work?",
                    "answer"   => "Staking is a way to earn passive income by locking your cryptocurrency for a specified duration. Select a coin from the staking list, choose a staking period, and earn profits when the staking period ends.",
                    "page"     => FaqPages::HOME->value,
                    "lang"     => 'en',
                    "status"   => true,
                ],
                [
                    "uid"      => uniqueCode("FAQ"),
                    "question" => "Can I stake any cryptocurrency?",
                    "answer"   => "No, only specific cryptocurrencies listed on our staking page are available for staking. Each coin has different staking durations and profit rates, which are displayed on the staking list.",
                    "page"     => FaqPages::HOME->value,
                    "lang"     => 'en',
                    "status"   => true,
                ],
                [
                    "uid"      => uniqueCode("FAQ"),
                    "question" => "How do I exchange one cryptocurrency for another?",
                    "answer"   => "To exchange cryptocurrencies, select the coin you want to exchange (e.g., BTC), specify the amount, and choose the desired coin to receive (e.g., USDT). The exchange will be processed using the current live exchange rate.",
                    "page"     => FaqPages::HOME->value,
                    "lang"     => 'en',
                    "status"   => true,
                ],
                [
                    "uid"      => uniqueCode("FAQ"),
                    "question" => "How does the personal wallet feature work?",
                    "answer"   => "Each user is assigned unique wallet addresses for each cryptocurrency. You can deposit coins to your wallet using these addresses or withdraw coins to another address securely.",
                    "page"     => FaqPages::HOME->value,
                    "lang"     => 'en',
                    "status"   => true,
                ],
                [
                    "uid"      => uniqueCode("FAQ"),
                    "question" => "Are there any fees for deposits, withdrawals, or exchanges?",
                    "answer"   => "Yes, certain services may include minimal fees, such as withdrawal fees or exchange transaction fees. You can view the fee details during the transaction process.",
                    "page"     => FaqPages::HOME->value,
                    "lang"     => 'en',
                    "status"   => true,
                ],
                [
                    "uid"      => uniqueCode("FAQ"),
                    "question" => "How long does it take for a deposit or withdrawal to process?",
                    "answer"   => "Deposits and withdrawals are usually processed within minutes, depending on the network confirmation time of the cryptocurrency. In rare cases, it might take longer due to network congestion.",
                    "page"     => FaqPages::HOME->value,
                    "lang"     => 'en',
                    "status"   => true,
                ],
                [
                    "uid"      => uniqueCode("FAQ"),
                    "question" => "Is my cryptocurrency safe in the personal wallet?",
                    "answer"   => "Yes, we prioritize security and use advanced encryption and wallet protection methods. However, we recommend enabling additional security features like two-factor authentication (2FA) for enhanced account safety.",
                    "page"     => FaqPages::HOME->value,
                    "lang"     => 'en',
                    "status"   => true,
                ],
                [
                    "uid"      => uniqueCode("FAQ"),
                    "question" => "What should I do if I face an issue with a transaction?",
                    "answer"   => "If you encounter any problems with a deposit, withdrawal, or any other transaction, please contact our support team via the Contact Us page. Provide transaction details, and we’ll assist you promptly.",
                    "page"     => FaqPages::HOME->value,
                    "lang"     => 'en',
                    "status"   => true,
                ],
            ];
            foreach($faqs as $faq) Faq::create($faq);
        }
    }
}
