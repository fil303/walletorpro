<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LandingController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Admin\SettingController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('update-coin-price', [SettingController::class, "updateCoinPrice"]);
Route::get('run-app-command', [SettingController::class, "runAppCommand"]);

// Auth route
Route::group(['middleware' => "guest"],function (){
    Route::get('register', [AuthController::class,'registerPage'])->name('registerPage');
    Route::get('login', [AuthController::class,'loginPage'])->name('loginPage');
    Route::get('admin', [AuthController::class,'adminLoginPage'])->name('adminLoginPage');
    Route::post('register', [AuthController::class,'registerProccess'])->name('register');
    Route::post('login', [AuthController::class,'loginProcess'])->name('login');
    Route::post('forgot-password', [AuthController::class,'forgotPassword'])->name('forgotPassword');
    Route::post('password-reset', [AuthController::class,'passwordReset'])->name('passwordReset');
    Route::view("/two-factor-verification", "auth.two_factor")->name('twoFactorVerify')->middleware("auth");
    Route::post("/two-factor-verification", [AuthController::class,'twoFactorVerifyProcess'])->name('twoFactorVerifyProcess')->middleware("auth");
    Route::get('forgot-password', [AuthController::class,'forgotPasswordPage'])->name('forgotPasswordPage');
    Route::get("user-veryfication-{id}-{hash}", [AuthController::class,'userAccountVerification'])->name("userVerification");
    Route::get("password-reset", [AuthController::class,'passwordResetPage'])->name("passwordResetPage");
});
Route::get('logout', [AuthController::class,'logout'])->name('logout');
Route::get("send-otp", [AuthController::class,'sendOTPCode'])->name('sendOTPCode')->middleware("auth");

Route::get("/", [ LandingController::class, "welcomePage" ])->name("welcomePage");
Route::get("/about", [ LandingController::class, "aboutPage" ])->name("aboutPage");
Route::match(['get', 'post'], "/contact-us", [ LandingController::class, "contact_us" ])->name("contact_us");
Route::get("/privacy-policy", [ LandingController::class, "privacy_policy" ])->name("privacy_policy");
Route::get("terms-and-condition", [ LandingController::class, "terms_condition" ])->name("terms_condition");
Route::get("page/{slug}", [ LandingController::class, "customPage" ])->name("landingCustomPage");