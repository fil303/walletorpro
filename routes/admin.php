<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\FaqController;
use App\Http\Controllers\Admin\CoinController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\StakeController;
use App\Http\Controllers\Admin\DepositController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Admin\CurrencyController;
use App\Http\Controllers\Admin\FiatCoinController;
use App\Http\Controllers\Admin\LanguageController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\CustomPageController;
use App\Http\Controllers\Admin\WithdrawalController;
use App\Http\Controllers\Admin\LandingPageController;
use App\Http\Controllers\Admin\SupportTicketController;
use App\Http\Controllers\Admin\PaymentGatewayController;

Route::group(["middleware"=> "admin"], function () {
    // Admin Dashboard
    Route::get("dashboard",[ DashboardController::class ,"dashboard"])->name("adminDashboard");

    // Admin Profile
    Route::get("profile",[ AdminController::class ,"profilePage"])->name("adminProfilePage");
    Route::post("profile",[ AdminController::class ,"profileUpdateProcess"])->name("profileUpdateProcess");
    Route::get("reset-password",[ AdminController::class ,"resetPasswordPage"])->name("adminResetPasswordPage");
    Route::post("reset-password",[ AdminController::class ,"resetPasswordProcess"])->name("adminResetPasswordProcess");

    // Settings
    Route::get("settings", [SettingController::class, "settingPage" ])->name("settingPage");
    Route::group(["prefix" => "setting"], function (){
        Route::get('clear-cache', [ SettingController::class, "clearCache" ])->name("clearCache");
        Route::get('basic', [ SettingController::class, "basicSettingPage" ])->name("basicSettingPage");
        Route::post('basic', [ SettingController::class, "basicSettingSave" ])->name("basicSettingSave");

        Route::get('theme', [ SettingController::class, "themeSettingPage" ])->name("themeSettingPage");
        Route::post('theme', [ SettingController::class, "themeSettingSave" ])->name("themeSettingSave");

        Route::get('logo', [ SettingController::class, "logoSettingPage" ])->name("logoSettingPage");
        Route::post('logo', [ SettingController::class, "logoSettingSave" ])->name("logoSettingSave");

        Route::get('coin_provider', [ SettingController::class, "coinProviderPage" ])->name("coinProviderPage");
        Route::post('coin_provider/coinpayment', [ SettingController::class, "coinProviderCoinPaymentSave" ])->name("coinProviderCoinPaymentSave");

        Route::get('email', [ SettingController::class, "emailSettingPage" ])->name("emailSettingPage");
        Route::post('email', [ SettingController::class, "emailSettingUpdate" ])->name("emailSettingSave");
        Route::post('email/test', [ SettingController::class, "emailTest" ])->name("emailTest");

        Route::get('gdpr', [ SettingController::class, "gdprSettingPage" ])->name("gdprSettingPage");

        Route::get('sms', [ SettingController::class, "smsSettingPage" ])->name("smsSettingPage");
        Route::post('sms/twilio', [ SettingController::class, "smsTwilioSettingSave" ])->name("smsTwilioSettingSave");

        Route::get('maintenance', [ SettingController::class, "maintenanceSettingPage" ])->name("maintenanceSettingPage");
        Route::get('seo', [ SettingController::class, "seoSettingPage" ])->name("seoSettingPage");
        
        Route::get('captcha', [ SettingController::class, "captchaSettingPage" ])->name("captchaSettingPage");
        Route::post('captcha', [ SettingController::class, "captchaSettingSave" ])->name("captchaSettingSave");
    });

    // User Management
    Route::group(["prefix" => "user"], function (){
        Route::get("/",     [UserController::class, "addUserPage" ])->name("addUserPage");
        Route::post("/",     [UserController::class, "addUser"     ])->name("addUser");
        Route::get("active", [UserController::class, "userActiveListPage" ])->name("activeUserList");
        Route::get("suspend",[UserController::class, "userSuspendListPage"])->name("suspendUserList");
        Route::get("delete", [UserController::class, "userDeleteListPage" ])->name("deleteUserList");
        Route::group(["do_db_change" => true], function (){
            Route::patch("edit",       [UserController::class, "editUser"           ])->name("editUser");
            Route::get("active-{uid}", [UserController::class, "activeUser"         ])->name("activeUser");
            Route::get("suspend-{uid}",[UserController::class, "suspendUser"        ])->name("suspendUser");
            Route::get("delete-{uid}", [UserController::class, "deleteUser"         ])->name("deleteUser");
            Route::get("force-delete-{uid}", [UserController::class, "forceDeleteUser"])->name("forceDeleteUser");
        });

        // User Wallet List
        Route::get("wallet", [UserController::class, "userWalletListPage"])->name("userWalletListPage");
    });

    // Currency Coin Management
    Route::group(["prefix" => "coin"], function (){
        Route::get("/",  [CoinController::class, "coinPage"])->name("coinsPage");
        Route::get("create", [CoinController::class, "addCoinPage"])->name("addCoinPage");
        Route::get("edit/{uid}", [CoinController::class, "editCoinPage"])->name("editCoinPage");
        Route::post("save",  [CoinController::class, "coinSave"])->name("coinSave");
        Route::post("update",[CoinController::class, "coinUpdate"])->name("coinUpdate");
        Route::post("status",[CoinController::class, "coinStatusUpdate"])->name("coinStatusUpdate");
        Route::get("purchase-report",[CoinController::class, "coinPurchaseReport"])->name("coinPurchaseReport");
        Route::get("exchange-report",[CoinController::class, "coinExchangeReport"])->name("coinExchangeReport");
        Route::group(["do_db_change" => true], function (){
            Route::get("delete-{uid}",[CoinController::class, "coinDelete"])->name("coinDelete");
        });
    });
    
    // Fiat Coin Management
    Route::get("fiat-coins", [FiatCoinController::class, "fiatCoinPage"])->name("fiatCoinPage");
   
    // Languages Management
    Route::get("languages", [LanguageController::class, "languagePage"])->name("languagePage");
    Route::get("language/{uid?}", [LanguageController::class, "addEditLanguagePage"])->name("addEditLanguagePage");
    Route::post("language-status-{uid?}",[LanguageController::class, "updateLanguageStatus"])->name("updateLanguageStatus");
    Route::post("language-save",  [LanguageController::class, "saveLanguage"])->name("saveLanguage");
    Route::group(["do_db_change" => true], function (){
        Route::get("language-delete-{uid}",[LanguageController::class, "languageDelete"])->name("languageDelete");
    });

    // FAQ Management
    Route::get("faqs", [FaqController::class, "faqPage"])->name("faqPage");
    Route::get("faq/{uid?}", [FaqController::class, "addEditFaqPage"])->name("addEditFaqPage");
    Route::post("faq-status-{uid?}",[FaqController::class, "updateFaqStatus"])->name("updateFaqStatus");
    Route::post("faq-save",  [FaqController::class, "saveFaq"])->name("saveFaq");
    Route::group(["do_db_change" => true], function (){
        Route::get("faq-delete-{uid}",[FaqController::class, "faqDelete"])->name("faqDelete");
    });

    // Currencies Management
    Route::get ("currencies", [CurrencyController::class, "currencyPage"])->name("currencyPage");
    Route::get ("currency/{code?}", [CurrencyController::class, "editCurrencyPage"])->name("editCurrencyPage");
    Route::post("currency-status-{code?}",[CurrencyController::class, "updateCurrencyStatus"])->name("updateCurrencyStatus");
    Route::post("currency-save",  [CurrencyController::class, "saveCurrency"])->name("saveCurrency");

    // Automated Gateways Management
    Route::get("automated-gateways", [PaymentGatewayController::class, "autoGatewayList"])->name("autoGatewayList");
    Route::get("automated-gateways/{uid}",  [PaymentGatewayController::class, "autoGatewayDetails"])->name("autoGatewayDetails");
    Route::post("update-automated-gateways",[PaymentGatewayController::class, "updateAutomatedGateway"])->name("updateAutomatedGateway");
    Route::post("update-gateway-status", [PaymentGatewayController::class, "updateGatewayStatus"])->name("updateGatewayStatus");
    Route::post("add-gateway-currency", [PaymentGatewayController::class, "addGatewayCurrency"])->name("addGatewayCurrency");
    Route::get("automated-gateway/currency/delete/{uid}/{currency_code}",  [PaymentGatewayController::class, "autoGatewayCurrencyDelete"])->name("autoGatewayCurrencyDelete");

    // Staking Management
    Route::get("stake-plan",    [StakeController::class, "stakePage"])->name("stakePage");
    Route::get("create-stake",  [StakeController::class, "createStakePage"])->name("createStakePage");
    Route::post("create-stake", [StakeController::class, "saveStakePlan"])->name("saveStakePlan");
    Route::post("update-stake", [StakeController::class, "updateStakePlan"])->name("updateStakePlan");
    Route::post("change-stake-status",[StakeController::class, "changeStatusStakePlan"])->name("changeStatusStakePlan");
    Route::get("edit-stake/{id}",  [StakeController::class, "editStakePlanPage"])->name("editStakePlan");
    Route::get("stake-report",     [StakeController::class, "stakeReportPage"])->name("stakeReportPage");
    Route::group(["do_db_change" => true], function (){
        Route::get("delete-stake/{id}",[StakeController::class, "deleteStakePlan"])->name("deleteStakePlan");
    });

    // Support Ticket Management
    Route::get('tickets',         [SupportTicketController::class,'index'])->name('adminTicketsIndex');
    Route::get('tickets/pending', [SupportTicketController::class,'pending'])->name('adminTicketsPending');
    Route::get('tickets/answered',[SupportTicketController::class,'answered'])->name('adminTicketsAnswered');
    Route::get('tickets/closed',  [SupportTicketController::class,'closed'])->name('adminTicketsClosed');
    Route::post('tickets/reply',  [SupportTicketController::class,'reply'])->name('adminTicketsReply');
    Route::group(["do_db_change" => true], function (){
        Route::get("tickets/close-ticket-{ticket}", [ SupportTicketController::class, "closeTicketPage" ])->name("closeTicket");
    });
    Route::get('tickets/{ticket}',[SupportTicketController::class,'show'])->name('adminTicketsShow');

    // Withdrawal Request
    Route::group(["prefix" => "withdrawal"], function (){
        Route::get("/", [ WithdrawalController::class, "withdrawalPage" ])->name("withdrawalPage");
        Route::get("/pending", [ WithdrawalController::class, "withdrawalPendingList" ])->name("withdrawalPendingList");
        Route::get("/confirm", [ WithdrawalController::class, "withdrawalConfirmList" ])->name("withdrawalConfirmList");
        Route::get("/reject", [ WithdrawalController::class, "withdrawalRejectList" ])->name("withdrawalRejectList");
        Route::group(["do_db_change" => true], function (){
            Route::get("/accept/{id}", [ WithdrawalController::class, "withdrawalAccept" ])->name("withdrawalAccept");
            Route::get("/reject/{id}", [ WithdrawalController::class, "withdrawalReject" ])->name("withdrawalReject");
        });
    });

    // Deposit
    Route::group(["prefix" => "deposit"], function (){
        Route::get("/", [ DepositController::class, "depositPage" ])->name("depositPage");
    });
  
    // Landing Page CMS
    Route::group(["prefix" => "landing-setting"], function (){
        Route::get("/", [ LandingPageController::class, "landingPageSetting" ])->name("landingPageSetting");

        Route::post("/theme-color", [ LandingPageController::class, "landingThemeColorSetting" ])->name("landingThemeColorSetting");
        Route::post("/hero-section", [ LandingPageController::class, "landingHeroSectionSetting" ])->name("landingHeroSectionSetting");
        Route::post("/about-section", [ LandingPageController::class, "landingAboutSectionSetting" ])->name("landingAboutSectionSetting");
        Route::post("/why-section", [ LandingPageController::class, "landingWhySectionSetting" ])->name("landingWhySectionSetting");
        Route::post("/how-section", [ LandingPageController::class, "landingHowSectionSetting" ])->name("landingHowSectionSetting");
        Route::post("/service-section", [ LandingPageController::class, "landingServiceSectionSetting" ])->name("landingServiceSectionSetting");
        Route::post("/wallet-section", [ LandingPageController::class, "landingWalletSectionSetting" ])->name("landingWalletSectionSetting");
        Route::post("/testimonials-section", [ LandingPageController::class, "landingTestimonialSectionSetting" ])->name("landingTestimonialSectionSetting");
        Route::post("/faq-section", [ LandingPageController::class, "landingFaqSectionSetting" ])->name("landingFaqSectionSetting");
        Route::post("/social-network", [ LandingPageController::class, "landingSocialNetworkSetting" ])->name("landingSocialNetworkSetting");
        Route::post("/terms-and-condition", [ LandingPageController::class, "landingTermsAndConditionSettingRequest" ])->name("landingTermsAndConditionSettingRequest");
        Route::post("/privacy-policy", [ LandingPageController::class, "landingPrivacyPolicySettingRequest" ])->name("landingPrivacyPolicySettingRequest");


        // Testimonial
        Route::get("/testimonials", [ LandingPageController::class, "landingTestimonialsPage" ])->name("landingTestimonialsPage");
        Route::post("/testimonial", [ LandingPageController::class, "landingTestimonialSave" ])->name("landingTestimonialSave");
        Route::get("/testimonial/{id?}", [ LandingPageController::class, "landingTestimonial" ])->name("landingTestimonial");
        Route::group(["do_db_change" => true], function (){
            Route::get("/delete/testimonial/{id}", [ LandingPageController::class, "landingTestimonialDelete" ])->name("landingTestimonialDelete");
            Route::get("/status/testimonial/{id?}", [ LandingPageController::class, "landingTestimonialStatus" ])->name("landingTestimonialStatus");
        });
    });

    // Custom Page
    Route::group(["prefix" => "custom-page"], function (){
        Route::get("/", [ CustomPageController::class, "customPage" ])->name("customPage");
        Route::post("/", [ CustomPageController::class, "customPageSave" ])->name("customPageSave");
        Route::get("/page/{id?}", [ CustomPageController::class, "customPageAddEdit" ])->name("customPageAddEdit");
        Route::post("/status/{id?}", [ CustomPageController::class, "customPageStatus" ])->name("customPageStatus");
        Route::group(["do_db_change" => true], function (){
            Route::get("/delete/{id}", [ CustomPageController::class, "customPageDelete" ])->name("customPageDelete");
        });
    });
 
});
