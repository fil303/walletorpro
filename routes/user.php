<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\User\UserController;
use App\Http\Controllers\User\StakeController;
use App\Http\Controllers\User\ReportController;
use App\Http\Controllers\User\WalletController;
use App\Http\Controllers\User\BuyCoinController;
use App\Http\Controllers\User\ExchangeController;
use App\Http\Controllers\User\DashboardController;
use App\Http\Controllers\User\TransactionController;
use App\Http\Controllers\User\SupportTicketController;

Route::group(["middleware"=> "user"], function () {

    //Dashboard
    Route::get("dashboard",[DashboardController::class, "dashboard"])->name("userDashboard");
    
    //Profile
    Route::group(["prefix" => "profile"],function(){
        Route::get("/", [UserController::class, "profile"])->name("userProfile");
        Route::post("/",[UserController::class, "profileUpdateProcess"])->name("userProfileUpdate");
        Route::get("password-reset",[UserController::class, "passwordResetPage"])->name("userPasswordResetPage");
        Route::post("password-reset",[UserController::class, "passwordResetProcess"])->name("userPasswordReset");
        Route::get("2fa-setup",[UserController::class, "twoFactorSetupPage"])->name("twoFactorSetupPage");
        Route::post("2fa-setup",[UserController::class, "twoFactorSetupProcess"])->name("twoFactorSetup");
        Route::post("phone-verification",[UserController::class, "phoneVerificationProcess"])->name("phoneVerificationProcess");
    });
    
    //Wallets
    Route::group(["prefix" => "wallet"], function(){

        // Crypto Wallets
        Route::get("/", [ WalletController::class, "cryptoWalletPage" ])->name("cryptoWalletPage");
        Route::get("balance/{coin}", [ WalletController::class, "cryptoWalletBalance" ])->name("cryptoWalletBalance");
        Route::get("deposit/{coin}/{uid?}", [ WalletController::class, "cryptoWalletDepositPage" ])->name("cryptoWalletDepositPage");
        Route::get("withdrawal/{coin}/{uid?}", [ WalletController::class, "cryptoWalletWithdrawalPage" ])->name("cryptoWalletWithdrawalPage");
        Route::post("withdrawal", [ WalletController::class, "cryptoWalletWithdrawal" ])->name("cryptoWalletWithdrawal");

        // Fiat Wallets
        Route::get("fiat-wallets", [ WalletController::class, "fiatWalletPage" ])->name("fiatWalletPage");
    });
    Route::controller(TransactionController::class)->group(function(){

        // Buy Crypto
        Route::get("buy-crypto", "buyCryptoPage")->name("buyCryptoPage");
        Route::get("crypto-purchased-complete", "cryptoPurchasedComplete")->name("cryptoPurchasedComplete");
        Route::post("buy-crypto", "buyCrypto")->name("buyCrypto");
        Route::post("confirm-buy-crypto", "confirmBuyCrypto")->name("confirmBuyCrypto");
        Route::post("buy-crypto-process", "cryptoBuyProcess")->name("buyCryptoProcess");
        Route::get("crypto-price", "cryptoPrice")->name("cryptoBuyPrice");

        Route::get("transactions", "allTransactions")->name("allTransactions");
        Route::get("crypto-buy-transactions", "cryptoTransactions")->name("cryptoTransactions");
    });

    Route::controller(StakeController::class)->group(function(){
        Route::get("my-staking", "stakingHistoryPage")->name("stakingHistoryPage");
        Route::get("staking-plan-list", "userStakePage")->name("userStakePage");
        Route::post("open-stake", "userOpenStake")->name("userOpenStake");
        Route::post("submit-stake", "userSubmitStake")->name("userSubmitStake");
        Route::post("stop-auto-stake", "stopAutoStake")->name("stopAutoStake");
    });
    
    Route::group([ "prefix" => "support-center" ], function(){
        Route::get("/", [ SupportTicketController::class, "supportPage" ])->name("supportPage");
        Route::get("create/ticket", [ SupportTicketController::class, "openNewSupportTicketPage" ])->name("openNewSupportTicketPage");
        Route::get("ticket/attachment/download-{replay}-{index}", [ SupportTicketController::class, "supportTicketAttachmentDownload" ])->name("supportTicketAttachmentDownload");
        Route::get("support-ticket-{ticket}", [ SupportTicketController::class, "supportTicketPage" ])->name("supportTicketPage");
        Route::post("create-support-ticket", [ SupportTicketController::class, "submitNewSupportTicketPage" ])->name("submitNewSupportTicketPage");
        Route::post("replay-support-ticket", [ SupportTicketController::class, "replaySupportTicket" ])->name("replaySupportTicket");
        Route::group(["do_db_change" => true], function (){
            Route::get("close-ticket-{ticket}", [ SupportTicketController::class, "closeTicketPage" ])->name("closeTicketPage");
        });
    });

    Route::group(["prefix" => "coin-buy"], function(){
        Route::get('/',  [ BuyCoinController::class, "buyPage"])->name("coinBuyPage");
        Route::post('/', [ BuyCoinController::class, "coinBuyProcess"])->name("coinBuyProcess");
        Route::get('page-data', [ BuyCoinController::class, "buyPageData"])->name("buyPageData");
        Route::get("list", [ BuyCoinController::class, "buyCoinList"])->name(name: "buyCoinList");
        Route::get('model/{coin}', [BuyCoinController::class, "buyCoinModal"])->name(name: "buyCoinModal");
        Route::get('payment-method/{currency?}', [BuyCoinController::class, "buyCoinPaymentMethod"])->name(name: "buyCoinPaymentMethod");
        Route::get('price', [ BuyCoinController::class, "getBuyCoinPrice"])->name(name: "getBuyCoinPrice");
        Route::get('cancel-payment/{gateway}', [ BuyCoinController::class, "coinBuyCancel"])->name("coinBuyCancel");
        Route::get('confirm-payment/{gateway}', [ BuyCoinController::class, "coinBuyConfirm"])->name("coinBuyConfirm");
        Route::any('payment-ipn/{gateway}', [ BuyCoinController::class, "coinBuyPaymentIpn"])->withoutMiddleware(['auth', 'user'])->name("coinBuyPaymentIpn");
    });

    Route::group(["prefix" => "exchange"], function(){
        Route::get('/', [ ExchangeController::class, "exchangePage" ])->name("exchangePage");
        Route::get('/coins', [ ExchangeController::class, "exchangeCoins" ])->name("exchangeCoins");
        Route::get('/rate', [ ExchangeController::class, "exchangeRate" ])->name("exchangeRate");
        Route::post('/exchange', [ ExchangeController::class, "exchangeCoinProcess" ])->name("exchangeCoinProcess");
    });

    // Reports
    Route::group(["prefix" => "report"], function(){
        Route::get('/deposit', [ ReportController::class, "depositReportPage" ])->name("depositReportPage");
        
        Route::get('/withdrawal', [ ReportController::class, "withdrawalReportPage" ])->name("withdrawalReportPage");
        Route::get('/withdrawal/pending', [ ReportController::class, "withdrawalPendingReport" ])->name("withdrawalPendingReport");
        Route::get('/withdrawal/complete', [ ReportController::class, "withdrawalCompleteReport" ])->name("withdrawalCompleteReport");
        Route::get('/withdrawal/reject', [ ReportController::class, "withdrawalRejectReport" ])->name("withdrawalRejectReport");
        
        Route::get('/coin-purchase', [ ReportController::class, "coinPurchaseReportPage" ])->name("coinPurchaseReportPage");
        Route::get('/coin-exchange', [ ReportController::class, "coinExchangeReportPage" ])->name("coinExchangeReportPage");
        Route::get('/coin-staking', [ ReportController::class, "coinStakingReportPage" ])->name("coinStakingReportPage");
    });
});