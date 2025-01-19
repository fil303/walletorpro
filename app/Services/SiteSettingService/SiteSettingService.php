<?php

namespace App\Services\SiteSettingService;

use App\Models\SiteSetting;
use Illuminate\Support\Facades\App;
use Illuminate\Database\Query\Builder;
use Illuminate\Foundation\Application;
use App\Services\FaqService\FaqService;
use App\Services\AuthService\AuthService;
use App\Services\CoinService\CoinService;
use App\Services\FileService\FileService;
use App\Services\UserService\UserService;
use App\Services\FaqService\AppFaqService;
use App\Services\AdminService\AdminService;
use App\Services\StakeService\StakeService;
use App\Services\AdminService\IAdminService;
use App\Services\AuthService\AppAuthService;
use App\Services\CoinService\AppCoinService;
use App\Services\FileService\AppFileService;
use App\Services\UserService\AppUserService;
use App\Services\WalletService\WalletService;
use App\Services\StakeService\AppStakeService;
use App\Services\SettingService\SettingService;
use App\Services\WalletService\AppWalletService;
use App\Services\CurrencyService\CurrencyService;
use App\Services\ExchangeService\ExchangeService;
use App\Services\LanguageService\LanguageService;
use App\Services\ResponseService\ResponseService;
use App\Services\ExchangeService\IExchangeService;
use App\Services\SettingService\AppSettingService;
use App\Services\CurrencyService\AppCurrencyService;
use App\Services\LanguageService\AppLanguageService;
use App\Services\PaginationService\PaginationService;
use App\Services\UserCoinBuyService\UserCoinBuyService;
use App\Services\UserCoinBuyService\IUserCoinBuyService;
use App\Services\SiteSettingService\SiteSettingInterface;
use App\Services\SupportTicketService\SupportTicketService;
use App\Services\PaymentGatewayService\PaymentGatewayService;
use App\Services\SupportTicketService\AppSupportTicketService;
use App\Services\CoinTransactionService\CoinTransactionService;
use App\Services\PaymentGatewayService\AppPaymentGatewayService;
use App\Services\CoinTransactionService\AppCoinTransactionService;

class SiteSettingService implements SiteSettingInterface
{
    public function __construct(){
        // Check And Set Is This Request From Api Or Ajax
        defined("IS_API_REQUEST") ?:
        define('IS_API_REQUEST', (app('request')->wantsJson() || app('request')->ajax()));

        // Check And Set SiteSetting
        if(file_exists(storage_path('installed')))
        defined("SETTING") ?: define("SETTING", get_settings());

        Builder::macro("paginatePlus", function(mixed $data, int $page = 1, int $offset = null){
            /** @var Builder $this */
            return (new PaginationService)->paginate($this, $data, $page, $offset);
        });
    }

    /**
     * Set App Configure
     * @param object $settings
     * @return void
     */
    public static function setAppConfigure(object $settings): void
    {
        try {
            // Set Local Language
            if(request()->has('lang')) App::setLocale(request()->get('lang'));
            else App::setLocale((get_settings("app_locale") != "") ? get_settings("app_locale") : 'en');

            // set universal app data in view
            /** @var \Illuminate\Contracts\View\Factory $view */
            $view = view();
            $view->share("app", get_settings());

            // Set App Timezone
            // config(['app.timezone' => get_settings("app_timezone") ?? 'Asia/Dhaka']);
            // date_default_timezone_set(get_settings("app_timezone") ?? 'Asia/Dhaka');

            // Set Email Configuration
            config(['mail.mailers.smtp.host'       => get_settings("email_host")]);
            config(['mail.mailers.smtp.port'       => get_settings("email_port")]);
            config(['mail.mailers.smtp.username'   => get_settings("email_username")]);
            config(['mail.mailers.smtp.password'   => get_settings("email_password")]);
            config(['mail.mailers.smtp.encryption' => get_settings("email_encryption")]);
            config(['mail.from.address'            => get_settings("email_from")]);

            // Set Google reCaptcha V2
            config(['captcha.sitekey' => get_settings("google_recaptcha_v2_site_key")]);
            config(['captcha.secret'  => get_settings("google_recaptcha_v2_secret_key")]);

        } catch (\Exception $e) {
            logStore("setAppConfigure", $e->getMessage());
        }
    }

    /**
     * Load App Service
     * @param \Illuminate\Foundation\Application $app
     * @return void
     */
    public static function loadAppService(Application $app): void
    {
        try {

            // Setting Service listed in App Container
            $app->app->bind(AppAuthService::class,function() {
                return new AuthService;
            });
           
            // Admin Service listed in App Container
            $app->app->bind(IAdminService::class,function() {
                return new AdminService;
            });

            // Setting Service listed in App Container
            $app->app->bind(AppSettingService::class,function() {
                return new SettingService;
            });
           
            // User Service listed in App Container
            $app->app->bind(AppUserService::class,function() {
                return new UserService;
            });
            
            // Coin Service listed in App Container
            $app->app->bind(AppCoinService::class,function() {
                return new CoinService;
            });
            
            // File Service listed in App Container
            $app->app->bind(AppFileService::class,function() {
                return new FileService;
            });
            
            // Wallet Service listed in App Container
            $app->app->bind(AppWalletService::class,function() {
                return new WalletService;
            });
            
            // Language Service listed in App Container
            $app->app->bind(AppLanguageService::class,function() {
                return new LanguageService;
            });
            
            // FAQ Service listed in App Container
            $app->app->bind(AppFaqService::class,function() {
                return new FaqService;
            });
            
            // Currency Service listed in App Container
            $app->app->bind(AppCurrencyService::class,function() {
                return new CurrencyService;
            });
            
            // Currency Service listed in App Container
            $app->app->bind(AppPaymentGatewayService::class,function() {
                return new PaymentGatewayService;
            });
            
            // Coin Transaction Service listed in App Container
            $app->app->bind(AppCoinTransactionService::class,function() {
                return new CoinTransactionService;
            });
           
            // Stake Service listed in App Container
            $app->app->bind(AppStakeService::class,function() {
                return new StakeService;
            });
            
            // Stake Service listed in App Container
            $app->app->bind(AppSupportTicketService::class,function() {
                return new SupportTicketService;
            });
           
            // User Buy Coin Service listed in App Container
            $app->app->bind(IUserCoinBuyService::class,function() {
                return new UserCoinBuyService;
            });
            
            // Exchange Coin Service listed in App Container
            $app->app->bind(IExchangeService::class,function() {
                return new ExchangeService;
            });
            
            // Exchange Coin Service listed in App Container
            $app->app->bind("response_facade",function() {
                return new ResponseService;
            });

        } catch (\Exception $e) {
            logStore("loadAppService", $e->getMessage());
        }
    }
 
}