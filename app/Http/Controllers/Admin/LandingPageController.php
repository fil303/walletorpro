<?php

namespace App\Http\Controllers\Admin;

use App\Facades\FileFacade;
use App\Models\Testimonial;
use Illuminate\Http\Request;
use App\Enums\FileDestination;
use App\Models\LandingSetting;
use App\Facades\ResponseFacade;
use Illuminate\Http\JsonResponse;
use Illuminate\Contracts\View\View;
use App\Http\Controllers\Controller;
use Yajra\DataTables\Facades\DataTables;
use App\Http\Requests\Admin\TestimonialRequest;
use App\Services\SettingService\AppSettingService;
use Illuminate\Support\Facades\View as ViewFactory;
use App\Http\Requests\Admin\Setting\Landing\LandingFaqSectionSettingRequest;
use App\Http\Requests\Admin\Setting\Landing\LandingHowSectionSettingRequest;
use App\Http\Requests\Admin\Setting\Landing\LandingThemeColorSettingRequest;
use App\Http\Requests\Admin\Setting\Landing\LandingWhySectionSettingRequest;
use App\Http\Requests\Admin\Setting\Landing\LandingHeroSectionSettingRequest;
use App\Services\TableActionGeneratorService\TestimonialList\TestimonialList;
use App\Http\Requests\Admin\Setting\Landing\LandingAboutSectionSettingRequest;
use App\Http\Requests\Admin\Setting\Landing\LandingSocialNetworkSettingRequest;
use App\Http\Requests\Admin\Setting\Landing\LandingWalletSectionSettingRequest;
use App\Http\Requests\Admin\Setting\Landing\LandingServiceSectionSettingRequest;
use App\Http\Requests\Admin\Setting\Landing\LandingTestimonialSectionSettingRequest;

class LandingPageController extends Controller
{
    public function __construct(protected AppSettingService $service){}

    /**
     * Get Landing Setting Page
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Contracts\View\View
     */
    public function landingPageSetting(Request $request): View
    {
        $landingData['landing_tab'] = $request->tab ?? 'colors';
        $landingData['landing'] = LandingSetting::get()->toSlugValue();
        return ViewFactory::make("admin.landing.index", $landingData);
    }

    /**
     * Get Landing Testimonial Page
     * @return \Illuminate\Contracts\View\View|\Illuminate\Http\JsonResponse
     */
    public function landingTestimonialsPage(): View|JsonResponse
    {
        if(IS_API_REQUEST){
            $testimonials = Testimonial::query();
            
            return DataTables::of($testimonials)
            ->editColumn("image", function($testimonial){
                return '<img src="'.$testimonial->getImage().'" alt="'.$testimonial->name.'" width="50" height="50" loading="lazy" />';
            })
            ->editColumn("status", function($testimonial){
                $statusData["items"] = [
                    "onchange" => "updateStatus('$testimonial->id')",
                ];
                if($testimonial->status) $statusData["items"]["checked"] = "";
                
                return view("admin.components.toggle", $statusData);
            })
            ->editColumn("created_at", function($testimonial){
                return date('M d, Y, h:i A', strtotime($testimonial->created_at ?? ''));
            })
            ->addColumn("action", fn($item) =>  TestimonialList::getInstance($item)->button())
            ->rawColumns(["image", "status", "action"])
            ->make(true);
        }
        return ViewFactory::make("admin.landing.testimonial.testimonial");
    }

    /**
     * Save Landing Testimonial
     * @param \App\Http\Requests\Admin\TestimonialRequest $request
     * @return mixed
     */
    public function landingTestimonialSave(TestimonialRequest $request): mixed
    {
        $testimonial = null;
        if(isset($request->id)){
            $testimonial = Testimonial::find($request->id);
            if(!$testimonial) return ResponseFacade::failed(_t("Testimonial not found"))->send();
        }

        $testimonialData = [
            "name"      => $request->name,
            "feedback"  => $request->feedback,
            "status"    => $request->status,
        ];

        if($request->hasFile('image')){
            if($testimonial) FileFacade::removePublicFile($testimonial->image ?? '');

            $testimonialData["image"] = 
            FileFacade::saveImage(
                $request->file('image'),
                FileDestination::APP_IMAGE_PATH,
            );
        }

        $testimonialOparetion = Testimonial::updateOrCreate(["id" => $request->id ?? 0], $testimonialData);
        if($testimonialOparetion){
            if(isset($request->id))
            return ResponseFacade::success(_t("Testimonial updated successfully"))->back('landingTestimonialsPage')->send();
            return ResponseFacade::success(_t("Testimonial created successfully"))->back('landingTestimonialsPage')->send();
        }
        if(isset($request->id))
        return ResponseFacade::failed(_t("Testimonial failed to update"))->back('landingTestimonialsPage')->send();
        return ResponseFacade::failed(_t("Testimonial failed to create"))->back('landingTestimonialsPage')->send();
    }

    /**
     * Get Landing Testimonial
     * @param int $id
     * @return \Illuminate\Contracts\View\View
     */
    public function landingTestimonial(int $id = 0): View
    {
        $data = [];
        $testimonial = Testimonial::find($id);
        if($testimonial){
            $data['testimonial'] = $testimonial;
        }
        return ViewFactory::make("admin.landing.testimonial.addEdit", $data);
    }

    /**
     * Delete Landing Testimonial
     * @param int $id
     * @return mixed
     */
    public function landingTestimonialDelete(int $id): mixed
    {
        $testimonial = Testimonial::find($id);
        if(!$testimonial) return ResponseFacade::failed(_t("Testimonial not found"))->send();

        if($testimonial->delete()){
            FileFacade::removePublicFile($testimonial->image ?? '');
            return ResponseFacade::success(_t("Testimonial deleted successfully"))->send();
        }
        return ResponseFacade::failed(_t("Testimonial delete failed"))->send();
    }

    /**
     * Update Landing Testimonial Status
     * @param int $id
     * @return mixed
     */
    public function landingTestimonialStatus(int $id = 0): mixed
    {
        $testimonial = Testimonial::find($id);
        if(!$testimonial) return ResponseFacade::failed(_t("Testimonial not found"))->send();

        if($testimonial->update(['status' => !$testimonial->status])){
            return ResponseFacade::success(_t("Testimonial status updated successfully"))->send();
        }
        return ResponseFacade::failed(_t("Testimonial status update failed"))->send();
    }

    /**
     * Landing Theme Setting
     * @param \App\Http\Requests\Admin\Setting\Landing\LandingThemeColorSettingRequest $request
     * @return mixed
     */
    public function landingThemeColorSetting(LandingThemeColorSettingRequest $request): mixed
    {
        $colorData = [
            "primary_color"   => $request->primary_color,
            "secondary_color" => $request->secondary_color,
            "success_color"   => $request->success_color,
            "info_color"      => $request->info_color,
        ];
        $response = $this->service->saveLandingSettings($colorData);
        if(is_success($response)) return ResponseFacade::success(_t("Landing theme color updated successfully"))->send();
        return ResponseFacade::failed(_t("Landing theme color update failed"))->send();
    }

    /**
     * Landing Hero Section Setting
     * @param \App\Http\Requests\Admin\Setting\Landing\LandingHeroSectionSettingRequest $request
     * @return mixed
     */
    public function landingHeroSectionSetting(LandingHeroSectionSettingRequest $request): mixed
    {
        $heroSectionData = [
            "hero_section_badge_text" => $request->hero_section_badge_text,
            "hero_section_heading"    => $request->hero_section_heading,
            "hero_section_subheading" => $request->hero_section_subheading,
            "hero_section_cta_text"   => $request->hero_section_cta_text,
        ];

        if($request->hasFile('hero_section_image')){
            if($oldImage = LandingSetting::where('slug', 'hero_section_image')->first()){
                FileFacade::removePublicFile($oldImage->value ?? '');
            }

            $heroSectionData["hero_section_image"] = 
            FileFacade::saveImage(
                $request->file('hero_section_image'),
                FileDestination::APP_IMAGE_PATH,
                name: "landing-hero-section-image",
            );
        }

        $response = $this->service->saveLandingSettings($heroSectionData);
        if(is_success($response)) return ResponseFacade::success(_t("Landing hero section updated successfully"))->back("landingPageSetting")->query(['tab' => 'hero'])->send();
        return ResponseFacade::failed(_t("Landing hero section update failed"))->back("landingPageSetting")->query(['tab' => 'hero'])->send();
    }

    /**
     * Landing About Section Setting
     * @param \App\Http\Requests\Admin\Setting\Landing\LandingAboutSectionSettingRequest $request
     * @return mixed
     */
    public function landingAboutSectionSetting(LandingAboutSectionSettingRequest $request): mixed
    {
        $aboutSectionData = [
            "about_section_badge_text"  => $request->about_section_badge_text,
            "about_section_title"       => $request->about_section_title,
            "about_section_description" => $request->about_section_description,
        ];

        if($request->hasFile('about_section_image')){
            if($oldImage = LandingSetting::where('slug', 'about_section_image')->first()){
                FileFacade::removePublicFile($oldImage->value ?? '');
            }

            $aboutSectionData["about_section_image"] = 
            FileFacade::saveImage(
                $request->file('about_section_image'),
                FileDestination::APP_IMAGE_PATH,
                name: "landing-about-section-image",
            );
        }

        $response = $this->service->saveLandingSettings($aboutSectionData);
        if(is_success($response)) return ResponseFacade::success(_t("Landing about section updated successfully"))->back("landingPageSetting")->query(['tab' => 'about'])->send();
        return ResponseFacade::failed(_t("Landing about section update failed"))->back("landingPageSetting")->query(['tab' => 'about'])->send();
    }

    /**
     * Landing Why Section Setting
     * @param \App\Http\Requests\Admin\Setting\Landing\LandingWhySectionSettingRequest $request
     * @return mixed
     */
    public function landingWhySectionSetting(LandingWhySectionSettingRequest $request): mixed
    {
        $whySectionData = [
            "why_section_badge"       => $request->why_section_badge,
            "why_section_title"       => $request->why_section_title,
            "why_section_description" => $request->why_section_description,
        ];
        $response = $this->service->saveLandingSettings($whySectionData);
        if(is_success($response)) return ResponseFacade::success(_t("Landing why choose us section updated successfully"))->send();
        return ResponseFacade::failed(_t("Landing why choose us section update failed"))->send();
    }

    /**
     * Landing How Section Setting
     * @param \App\Http\Requests\Admin\Setting\Landing\LandingHowSectionSettingRequest $request
     * @return mixed
     */
    public function landingHowSectionSetting(LandingHowSectionSettingRequest $request): mixed
    {
        $howSectionData = [
            "how_section_badge_text" => $request->how_section_badge_text,
            // Coin Purchase
            "how_section_step1_title"       => $request->how_section_step1_title,
            "how_section_step1_description" => $request->how_section_step1_description,
            "how_section_step2_title"       => $request->how_section_step2_title,
            "how_section_step2_description" => $request->how_section_step2_description,
            "how_section_step3_title"       => $request->how_section_step3_title,
            "how_section_step3_description" => $request->how_section_step3_description,
            // staking
            "how_section_staking_step1_title"       => $request->how_section_staking_step1_title,
            "how_section_staking_step1_description" => $request->how_section_staking_step1_description,
            "how_section_staking_step2_title"       => $request->how_section_staking_step2_title,
            "how_section_staking_step2_description" => $request->how_section_staking_step2_description,
            "how_section_staking_step3_title"       => $request->how_section_staking_step3_title,
            "how_section_staking_step3_description" => $request->how_section_staking_step3_description,
            // exchange
            "how_section_exchange_step1_title"       => $request->how_section_exchange_step1_title,
            "how_section_exchange_step1_description" => $request->how_section_exchange_step1_description,
            "how_section_exchange_step2_title"       => $request->how_section_exchange_step2_title,
            "how_section_exchange_step2_description" => $request->how_section_exchange_step2_description,
            "how_section_exchange_step3_title"       => $request->how_section_exchange_step3_title,
            "how_section_exchange_step3_description" => $request->how_section_exchange_step3_description,
        ];
        $response = $this->service->saveLandingSettings($howSectionData);
        if(is_success($response)) return ResponseFacade::success(_t("Landing How It Work Section Updated Successfully"))->back("landingPageSetting")->query(['tab' => 'how'])->send();
        return ResponseFacade::failed(_t("Landing How It Work Section Update Failed"))->back("landingPageSetting")->query(['tab' => 'how'])->send();
    }

    /**
     * Landing Service Section Setting
     * @param \App\Http\Requests\Admin\Setting\Landing\LandingServiceSectionSettingRequest $request
     * @return mixed
     */
    public function landingServiceSectionSetting(LandingServiceSectionSettingRequest $request): mixed
    {
        $serviceSectionData = [
            "service_section_badge_text" => $request->service_section_badge_text,
            "service_section_title"      => $request->service_section_title,
            "service_section_description"=> $request->service_section_description,
            // Feature 1
            "service_section_feature1_title"       => $request->service_section_feature1_title,
            "service_section_feature1_description" => $request->service_section_feature1_description,
            // Feature 2
            "service_section_feature2_title"       => $request->service_section_feature2_title,
            "service_section_feature2_description" => $request->service_section_feature2_description,
            // Feature 3
            "service_section_feature3_title"       => $request->service_section_feature3_title,
            "service_section_feature3_description" => $request->service_section_feature3_description,
        ];

        if($request->hasFile('service_section_image')){
            if($oldImage = LandingSetting::where('slug', 'service_section_image')->first()){
                FileFacade::removePublicFile($oldImage->value ?? '');
            }

            $serviceSectionData["service_section_image"] = 
            FileFacade::saveImage(
                $request->file('service_section_image'),
                FileDestination::APP_IMAGE_PATH,
                name: "landing-service-section-image",
            );
        }
        $response = $this->service->saveLandingSettings($serviceSectionData);
        if(is_success($response)) return ResponseFacade::success(_t("Landing Service Section Updated Successfully"))->back("landingPageSetting")->query(['tab' => 'service'])->send();
        return ResponseFacade::failed(_t("Landing Service Section Update Failed"))->back("landingPageSetting")->query(['tab' => 'service'])->send();
    }

    /**
     * Landing Wallet Section Setting
     * @param \App\Http\Requests\Admin\Setting\Landing\LandingWalletSectionSettingRequest $request
     * @return mixed
     */
    public function landingWalletSectionSetting(LandingWalletSectionSettingRequest $request): mixed
    {
        $walletSectionData = [
            "wallet_section_badge_text"           => $request->wallet_section_badge_text,
            "wallet_section_title"                => $request->wallet_section_title,
            "wallet_section_feature1_title"       => $request->wallet_section_feature1_title,
            "wallet_section_feature1_description" => $request->wallet_section_feature1_description,
            "wallet_section_feature2_title"       => $request->wallet_section_feature2_title,
            "wallet_section_feature2_description" => $request->wallet_section_feature2_description,
            "wallet_section_feature3_title"       => $request->wallet_section_feature3_title,
            "wallet_section_feature3_description" => $request->wallet_section_feature3_description,
            "wallet_section_feature4_title"       => $request->wallet_section_feature4_title,
            "wallet_section_feature4_description" => $request->wallet_section_feature4_description,
            "wallet_section_feature5_title"       => $request->wallet_section_feature5_title,
            "wallet_section_feature5_description" => $request->wallet_section_feature5_description,
            "wallet_section_feature6_title"       => $request->wallet_section_feature6_title,
            "wallet_section_feature6_description" => $request->wallet_section_feature6_description,
        ];
        $response = $this->service->saveLandingSettings($walletSectionData);
        if(is_success($response)) return ResponseFacade::success(_t("Landing wallet feature section updated successfully"))->back("landingPageSetting")->query(['tab' => 'wallet'])->send();
        return ResponseFacade::failed(_t("Landing wallet feature section update failed"))->back("landingPageSetting")->query(['tab' => 'wallet'])->send();
    }

    /**
     * Landing Testimonial Section Setting
     * @param \App\Http\Requests\Admin\Setting\Landing\LandingTestimonialSectionSettingRequest $request
     * @return mixed
     */
    public function landingTestimonialSectionSetting(LandingTestimonialSectionSettingRequest $request): mixed
    {
        $testimonialSectionData = [
            "testimonial_section_badge_text" => $request->testimonial_section_badge_text,
            "testimonial_section_title"      => $request->testimonial_section_title,
            "testimonial_section_description"=> $request->testimonial_section_description,
        ];
        $response = $this->service->saveLandingSettings($testimonialSectionData);
        if(is_success($response)) return ResponseFacade::success(_t("Landing testimonial section updated successfully"))->back("landingPageSetting")->query(['tab' => 'testimonials'])->send();
        return ResponseFacade::failed(_t("Landing testimonial section update failed"))->back("landingPageSetting")->query(['tab' => 'testimonials'])->send();
    }

    /**
     * Landing Faq Section Setting
     * @param \App\Http\Requests\Admin\Setting\Landing\LandingFaqSectionSettingRequest $request
     * @return mixed
     */
    public function landingFaqSectionSetting(LandingFaqSectionSettingRequest $request): mixed
    {
        $faqSectionData = [
            "faq_section_badge_text" => $request->faq_section_badge_text,
            "faq_section_title"      => $request->faq_section_title,
            "faq_section_description"=> $request->faq_section_description,
        ];

        if($request->hasFile('faq_section_image')){
            if($oldImage = LandingSetting::where('slug', 'faq_section_image')->first()){
                FileFacade::removePublicFile($oldImage->value ?? '');
            }

            $faqSectionData["faq_section_image"] = 
            FileFacade::saveImage(
                $request->file('faq_section_image'),
                FileDestination::APP_IMAGE_PATH,
                name: "landing-faq-section-image",
            );
        }

        $response = $this->service->saveLandingSettings($faqSectionData);
        if(is_success($response)) return ResponseFacade::success(_t("Landing faq section updated successfully"))->back("landingPageSetting")->query(['tab' => 'faq'])->send();
        return ResponseFacade::failed(_t("Landing faq section update failed"))->back("landingPageSetting")->query(['tab' => 'faq'])->send();
    }

    /**
     * Landing Social Network Setting
     * @param \App\Http\Requests\Admin\Setting\Landing\LandingSocialNetworkSettingRequest $request
     * @return mixed
     */
    public function landingSocialNetworkSetting(LandingSocialNetworkSettingRequest $request): mixed
    {
        $socialNetworkSectionData = [
            "social_facebook_url" => $request->social_facebook_url,
            "social_twitter_url"  => $request->social_twitter_url,
            "social_linkedin_url" => $request->social_linkedin_url,
        ];
        $response = $this->service->saveLandingSettings($socialNetworkSectionData);
        if(is_success($response)) return ResponseFacade::success(_t("Landing network url updated successfully"))->back("landingPageSetting")->query(['tab' => 'social'])->send();
        return ResponseFacade::failed(_t("Landing social network url update failed"))->back("landingPageSetting")->query(['tab' => 'social'])->send();
    }

    /**
     * Landing Terms and Condition Setting
     * @param \Illuminate\Http\Request $request
     * @return mixed
     */
    public function landingTermsAndConditionSettingRequest(Request $request): mixed
    {
        if(!isset($request->terms_condition))
            return ResponseFacade::failed(_t("Terms and condition content required"))->back("landingPageSetting")->query(['tab' => 'terms_condition'])->send();

        $terms_condition = [
            "terms_condition" => $request->terms_condition,
        ];
        $response = $this->service->saveLandingSettings($terms_condition);
        if(is_success($response)) return ResponseFacade::success(_t("Terms and condition updated successfully"))->back("landingPageSetting")->query(['tab' => 'terms_condition'])->send();
        return ResponseFacade::failed(_t("Terms and condition update failed"))->back("landingPageSetting")->query(['tab' => 'terms_condition'])->send();
    }

    /**
     * Landing Privacy Policy Setting
     * @param \Illuminate\Http\Request $request
     * @return mixed
     */
    public function landingPrivacyPolicySettingRequest(Request $request): mixed
    {
        if(!isset($request->privacy_policy))
            return ResponseFacade::failed(_t("Privacy policy content required"))->query(['tab' => 'privacy_policy'])->send();

        $privacy_policy = [
            "privacy_policy" => $request->privacy_policy,
        ];
        $response = $this->service->saveLandingSettings($privacy_policy);
        if(is_success($response)) return ResponseFacade::success(_t("Privacy policy updated successfully"))->back("landingPageSetting")->query(['tab' => 'privacy_policy'])->send();
        return ResponseFacade::failed(_t("Privacy policy update failed"))->back("landingPageSetting")->query(['tab' => 'privacy_policy'])->send();
    }
}
