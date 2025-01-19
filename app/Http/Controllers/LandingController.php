<?php

namespace App\Http\Controllers;

use App\Models\Faq;
use App\Mail\Template;
use App\Enums\FaqPages;
use App\Mail\ContactUs;
use App\Models\CustomPage;
use App\Models\Testimonial;
use Illuminate\Http\Request;
use App\Models\LandingSetting;
use App\Facades\ResponseFacade;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Mail;
use App\Http\Requests\ContactUsRequest;
use Illuminate\Support\Facades\View as ViewFactory;

class LandingController extends Controller
{
    /**
     * Welcome Page
     * @return \Illuminate\Contracts\View\View
     */
    public function welcomePage(): View
    {
        $landingData['landing']      = LandingSetting::get()->toSlugValue();
        $landingData['testimonials'] = Testimonial::where("status", true)->get();
        $landingData['faqs']         = Faq::where("status", true)->where('page', FaqPages::HOME->value)->get();
        $landingData['pages']        = CustomPage::where("status", true)->get();
        return ViewFactory::make("index", $landingData);
    }

    /**
     * View About Page
     * @return \Illuminate\Contracts\View\View
     */
    public function aboutPage(): View
    {
        $landingData['landing']      = LandingSetting::get()->toSlugValue();
        $landingData['testimonials'] = Testimonial::where("status", true)->get();
        $landingData['faqs']         = Faq::where("status", true)->where('page', FaqPages::HOME->value)->get();
        $landingData['pages']        = CustomPage::where("status", true)->get();
        return ViewFactory::make("about", $landingData);
    }

    /**
     * View Contact Us Page
     * @param \App\Http\Requests\ContactUsRequest $request
     * @return mixed
     */
    public function contact_us(ContactUsRequest $request): mixed
    {
        if($request->isMethod("post")) {
            $admin_email = get_settings('app_email') ?? 'admin@example.com';
            Mail::to($admin_email)->send(new ContactUs(
                $request->subject,
                $request->message,
                $request->name,
                $request->email
            ));
            return ResponseFacade::success(_t("Your message sent successfully"))->send();
        }
        $landingData['landing'] = LandingSetting::get()->toSlugValue();
        $landingData['pages']   = CustomPage::where("status", true)->get();
        return ViewFactory::make("contact_us", $landingData);
    }

    /**
     * View Privacy Policy Page
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Contracts\View\View
     */
    public function privacy_policy(Request $request): View
    {
        $content = LandingSetting::where("slug", "privacy_policy")->first()->value ?? '';
        return ViewFactory::make("privacy_policy", compact('content'));
    }

    /**
     * View Terms & Conditions Page
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Contracts\View\View
     */
    public function terms_condition(Request $request): View
    {
        $content = LandingSetting::where("slug", "terms_condition")->first()->value ?? '';
        return ViewFactory::make("terms_and_conditions", compact('content'));
    }

    /**
     * View Custom Page
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Contracts\View\View
     */
    public function customPage(Request $request): View
    {
        $landingData['content'] = CustomPage::where("slug", $request->slug)->first()->content ?? '';
        $landingData['pages']   = CustomPage::where("status", true)->get();
        return ViewFactory::make("page", $landingData);
    }
}
