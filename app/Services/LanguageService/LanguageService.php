<?php
namespace App\Services\LanguageService;

use Exception;
use App\Models\Language;
use App\Http\Requests\Admin\LanguageRequest;
use App\Services\LanguageService\AppLanguageService;

class LanguageService implements AppLanguageService
{
    public function __construct(){}

    /**
     * Save Language
     * @param \App\Http\Requests\Admin\LanguageRequest $language
     * @return array
     */
    public function saveLanguage(LanguageRequest $language): array
    {
        $successResponse = _t("Language added successfully");
        $successUpdateResponse = _t("Language updated successfully");
        
        $failedResponse = _t("Failed to add new language");
        $failedUpdateResponse = _t("Failed to update language");

        if(!isset($language->uid) && Language::where("code", $language->code)->first())
            return failed(_t("This language already exists"));

        $finder = ["uid" => isset($language->uid)? $language->uid: uniqueCode("L")];

        $languageData = [
            "name" => $language->name,
            "code" => $language->code,
            "status" => $language->status == true,
        ];

        try {
            if($lang = Language::updateOrCreate($finder, $languageData)){
                if(isset($language->uid)) return success($successUpdateResponse);
                return success($successResponse);
            }
            if(isset($language->uid)) return success($failedUpdateResponse);
            return success($failedResponse);
        } catch (Exception $e) {
            logStore("saveLanguage", $e->getMessage());
            return failed($e->getMessage());
        }
    }

    /**
     * Language Delete
     * @param mixed $uid
     * @return array
     */
    public function languageDelete($uid): array
    {
        if(! $language = Language::where("uid", $uid)->first())
            return failed(_t("Language not found"));

        if($language->delete())
            return success(_t("Language deleted successfully"));

        return failed(_t("Language failed to delete"));
    }

    /**
     * Language Status
     * @param mixed $uid
     * @return array
     */
    public function languageStatus($uid): array
    {
        if(! $language = Language::where("uid", $uid)->first())
            return failed(_t("Language not found"));

        $language->status = !$language->status;
        
        if($language->save())
            return success(_t("Language status update successfully"));

        return failed(_t("Language failed to update status"));
    }
}