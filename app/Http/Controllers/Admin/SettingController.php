<?php

namespace App\Http\Controllers\Admin;

use Exception;
use App\Enums\ThemeType;
use App\Mail\SendTestMail;
use App\Mail\CoinExchanged;
use App\Mail\CoinBuySuccess;
use Illuminate\Http\Request;
use App\Mail\CoinStakingStart;
use App\Facades\ResponseFacade;
use App\Mail\CoinStakingSuccess;
use App\Mail\CoinStakingAutoStart;
use Illuminate\Routing\Redirector;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;
use App\Services\CoinService\CoinService;
use App\Services\ResponseService\Response;
use App\Services\SettingService\AppSettingService;
use App\Http\Requests\Admin\Setting\LogoUpdateRequest;
use App\Http\Requests\Admin\Setting\CoinPaymentSaveRequest;
use App\Http\Requests\Admin\Setting\GoogleReCaptchaV2Request;
use App\Http\Requests\Admin\Setting\BasicSettingUpdateRequest;
use App\Http\Requests\Admin\Setting\EmailSettingUpdateRequest;
use App\Http\Requests\Admin\Setting\ThemeSettingUpdateRequest;
use App\Http\Requests\Admin\Setting\TwilioSmsSettingUpdateRequest;
use Illuminate\Support\Facades\Artisan;

class SettingController extends Controller
{
    public function __construct(private AppSettingService $service){}

    /**
     * View Setting Page
     * @return mixed
     */
    public function settingPage(): mixed
    {
        $data['general'] = get_settings();
        return view("admin.settings.settings", $data);
    }

    /**
     * View General Setting Page
     * @return mixed
     */
    public function generalSettingPage(): mixed
    {
        $data['general'] = get_settings();
        return view("admin.settings.general", $data);
    }

    /**
     * Update General Setting Page
     * @param \Illuminate\Http\Request $request
     * @return mixed
     */
    public function generalSettingUpdate(Request $request): mixed
    {
        /** @var Redirector $redirect */
        $redirect = redirect();

        $generalConfigDetails = [
            "app_name"  => $request->name ?? "",
            "app_copyright"  => $request->copyright ?? "",
        ];

        $response = $this->service->saveSettings($generalConfigDetails);
        
        if(isset($response['status']) && $response['status'])
            return $redirect->route("generalSettingPage")->with("success", $response['message']);
        return $redirect->route("generalSettingPage")->with("error", $response['message'] ?? _t('Something went wrong!'));
    }

    /**
     * View Email Setting Page
     * @return mixed
     */
    public function emailSettingPage(): mixed
    {
        return view("admin.settings.settings.email");
    }

    /**
     * View Basic Setting Page
     * @return mixed
     */
    public function basicSettingPage(): mixed
    {
        $data['email'] = get_settings();
        return view("admin.settings.settings.basic", $data);
    }

    /**
     * Save Basic Setting
     * 
     * @param \App\Http\Requests\Admin\Setting\BasicSettingUpdateRequest $request
     * @return mixed
     */
    public function basicSettingSave(BasicSettingUpdateRequest $request): mixed
    {
        $emailConfigDetails = [
            "app_name"                => $request->app_name ?? "",
            "record_per_page"         => $request->record_per_page ?? "",
            "app_timezone"            => $request->app_timezone ?? "",
            "app_language"            => $request->app_language   ?? "",
            "app_address"             => $request->app_address ?? "",
            "app_email"               => $request->app_email ?? "",
            "app_phone"               => $request->app_phone   ?? "",
            "app_footer_text"         => $request->app_footer_text ?? "",
           "app_new_user_registration"=> isset($request->app_new_user_registration),
            "app_user_secure_password"=> isset($request->app_user_secure_password),
            "app_agree_policy"        => isset($request->app_agree_policy),
            "app_force_ssl"           => isset($request->app_force_ssl),
            "app_email_verification"  => isset($request->app_email_verification),
            "app_email_notification"  => isset($request->app_email_notification),
            "app_push_notification"   => isset($request->app_push_notification),
            "app_kyc_verification"    => isset($request->app_kyc_verification),
        ];

        $response = $this->service->saveSettings($emailConfigDetails);
        if(is_success($response)) $response['message'] = _t("Basic setting update successfully");
        $response['message'] = _t("Basic setting failed to update");
        return ResponseFacade::result($response)->send();
    }

    /**
     * View GDPR Setting Page
     * @return mixed
     */
    public function gdprSettingPage(): mixed
    {
        $data['email'] = get_settings();
        return view("admin.settings.settings.gdpr", $data);
    }

    /**
     * View Coin Provider Setting Page
     * @return mixed
     */
    public function coinProviderPage(): mixed
    {
        $data['email'] = get_settings();
        return view("admin.settings.settings.coin_provider", $data);
    }

    /**
     * View Coin Payment Setting Save
     * @param \App\Http\Requests\Admin\Setting\CoinPaymentSaveRequest $request
     * @return mixed
     */
    public function coinProviderCoinPaymentSave(CoinPaymentSaveRequest $request): mixed
    {
        $coinProviderUpdateData = [
            "coin_payment_public_key"    => $request->public_key ?? "",
            "coin_payment_private_key"   => $request->private_key ?? "",
            "coin_payment_ipn_marchant"  => $request->ipn_marchant ?? "",
            "coin_payment_ipn_secret"    => $request->ipn_secret ?? "",
        ];

        $response = $this->service->saveSettings($coinProviderUpdateData);
        $response['message'] =
            (success($response)) 
            ? _t("Coin Payment update successfully")
            : $response['message'] = _t("Coin Payment failed to update");
        return ResponseFacade::result($response)->send();
    }

    /**
     * Theme Setting Page
     * @return mixed
     */
    public function themeSettingPage(): mixed
    {
        $data['email'] = get_settings();
        return view("admin.settings.settings.theme", $data);
    }

    /**
     * Theme Setting Save
     * @param \App\Http\Requests\Admin\Setting\ThemeSettingUpdateRequest $request
     * @return mixed
     */
    public function themeSettingSave(ThemeSettingUpdateRequest $request): mixed
    {
        $themeType = ThemeType::tryFrom($request->type);
        $themeUpdateData = [
            "type"  => $request->type
        ];

        if($themeType == ThemeType::PRE_BUILD){
            $themeUpdateData["theme"]= $request->theme ?? "";
        }else{
            $themeUpdateData["primary"]= $request->primary ?? "";
            $themeUpdateData["secondary"]= $request->secondary ?? "";
            $themeUpdateData["accent"]= $request->accent ?? "";
            $themeUpdateData["neutral"]= $request->neutral ?? "";
        }

        $response = $this->service->saveSettings($themeUpdateData);
        $response['message'] =
            (success($response)) 
            ? _t("Theme update successfully")
            : $response['message'] = _t("Theme failed to update");
        return ResponseFacade::result($response)->send();
    }

    /**
     * Logo Setting Page
     * @return mixed
     */
    public function logoSettingPage(): mixed
    {
        return view("admin.settings.settings.logo");
    }
 
    /**
     * Logo Setting Save
     * @param \App\Http\Requests\Admin\Setting\LogoUpdateRequest $request
     * @return mixed
     */
    public function logoSettingSave(LogoUpdateRequest $request): mixed
    {
        $response = $this->service->updateLogo($request);
        return ResponseFacade::result($response)->send();
    }

    /**
     * Sms Setting Page
     * @return mixed
     */
    public function smsSettingPage(): mixed
    {
        $data['email'] = get_settings();
        return view("admin.settings.settings.sms", $data);
    }

    /**
     * Maintenance Setting Save
     * @return mixed
     */
    public function maintenanceSettingPage(): mixed
    {
        $data['email'] = get_settings();
        return view("admin.settings.settings.maintenance", $data);
    }

    /**
     * Seo Setting Page
     * @return mixed
     */
    public function seoSettingPage(): mixed
    {
        $data['email'] = get_settings();
        return view("admin.settings.settings.seo", $data);
    }

    /**
     * Captcha Setting Page
     * @return mixed
     */
    public function captchaSettingPage(): mixed
    {
        $data['email'] = get_settings();
        return view("admin.settings.settings.captcha", $data);
    }

    /**
     * Captcha Setting Save
     * @param \App\Http\Requests\Admin\Setting\GoogleReCaptchaV2Request $request
     * @return mixed
     */
    public function captchaSettingSave(GoogleReCaptchaV2Request $request): mixed
    {
        $captchaDetails = [
            "app_recaptcha_status"           => isset($request->app_recaptcha_status),
            "google_recaptcha_v2_site_key"   => $request->google_recaptcha_v2_site_key,
            "google_recaptcha_v2_secret_key" => $request->google_recaptcha_v2_secret_key,
        ];

        $response = $this->service->saveSettings($captchaDetails);
        if(is_success($response)) $response['message'] = _t("Google Re-Captcha V2 update successfully");
        else $response['message'] = _t("Google Re-Captcha V2 failed to update");
        return ResponseFacade::result($response)->send();
    }

    /**
     * Update Email Setting
     * @param EmailSettingUpdateRequest $request
     * @return mixed
     */
    public function emailSettingUpdate(EmailSettingUpdateRequest $request): mixed
    {
        /** @var Redirector $redirect */
        $redirect = redirect();

        $emailConfigDetails = [
            "email_host"  => $request->email_host ?? "",
            "email_port"  => $request->email_port ?? "",
            "email_username"  => $request->email_username ?? "",
            "email_password"  => $request->email_password ?? "",
            "email_encryption"  => $request->email_encryption ?? "",
            "email_from"  => $request->email_from ?? "",
        ];

        $response = $this->service->saveSettings($emailConfigDetails);
        
        if(isset($response['status']) && $response['status'])
            return $redirect->route("emailSettingPage")->with("success", $response['message']);
        return $redirect->route("emailSettingPage")->with("error", $response['message'] ?? _t('Something went wrong!'));
    }

    /**
     * Email Test
     * @param \Illuminate\Http\Request $request
     * @return mixed
     */
    public function emailTest(Request $request): mixed
    {
        /** @var Redirector $redirect */
        $redirect = redirect();

        if(blank($request->email))
            return $redirect->back()->with("error", _t("Email is required"));

        try {
            Mail::to($request->email)->queue(new SendTestMail());
            return $redirect->back()->with("success", _t("Test email sent successfully"));
        } catch (Exception $e) {
            logStore("SettingController emailTest", $e->getMessage());
            return $redirect->back()->with("error", _t("Test email sending failed"));
        }

    }

    /**
     * SMS Twilio Setting Page
     * @param \App\Http\Requests\Admin\Setting\TwilioSmsSettingUpdateRequest $request
     * @return mixed
     */
    public function smsTwilioSettingSave(TwilioSmsSettingUpdateRequest $request): mixed
    {
        $emailConfigDetails = [
            "sms_twilio_sid"  => $request->sms_twilio_sid   ?? "",
            "sms_twilio_token"=> $request->sms_twilio_token ?? "",
            "sms_twilio_phone"=> $request->sms_twilio_phone ?? "",
        ];

        $response = $this->service->saveSettings($emailConfigDetails);
        if(is_success($response)) $response['message'] = _t("Twilio setting update successfully");
        $response['message'] = _t("Twilio setting failed to update");
        return ResponseFacade::result($response)->send();
    }

    /**
     * Update CoinPayment Setting page
     * @return mixed
     */
    public function coinPaymentSettingPage(): mixed
    {
        $data['settings'] = get_settings();
        return view("admin.settings.coin_provider.coin_payment.coin_payment", $data);
    }

    /**
     * Update coin price
     * @return void
     */
    public function updateCoinPrice(): void
    {
        $coinService = new CoinService();
        $coinService->updateActiveCoinPrice();
    }

    /**
     * Clear app cache
     * @return mixed
     */
    public function clearCache(): mixed
    {
        Artisan::call('cache:clear');
        return ResponseFacade::success(_t("Cache cleared successfully"))->send();
    }

    /**
     * Run app commands
     * @return void
     */
    public function runAppCommand(): void
    {
        Artisan::call('schedule:run');
        Artisan::call('queue:work');
    }
}
