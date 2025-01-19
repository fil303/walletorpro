<?php

namespace App\Http\Controllers\Admin;

use App\Models\Language;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use App\Http\Controllers\Controller;
use App\Services\ResponseService\Response;
use App\Http\Requests\Admin\LanguageRequest;
use App\Services\LanguageService\AppLanguageService;
use App\Services\TableActionGeneratorService\LanguageList\LanguageList;

class LanguageController extends Controller
{
    public function __construct(protected AppLanguageService $languageService){}

    /**
     * Get Language Page
     * @return mixed
     */
    public function languagePage(): mixed
    {
        if(IS_API_REQUEST){
            $languages = Language::query();

            return DataTables::of($languages)
            ->editColumn("status", function($lang){
                $statusData["items"] = [
                    "onchange" => 'updateLanguageStatus(\''.$lang->uid.'\')',
                ];
                if($lang->status) $statusData["items"]["checked"] = "";
                
                return view("admin.components.toggle", $statusData);
            })
            ->addColumn("action", fn($item) =>  LanguageList::getInstance($item)->button())
            ->make(true);
        }
        return view("admin.language.language");
    }

    /**
     * Get Add Edit Language Page
     * @param string $uid
     * @return mixed
     */
    public function addEditLanguagePage(string $uid = null): mixed
    {
        $data = [];

        if($uid) $data['item'] = Language::where("uid", $uid)->first();
        return view("admin.language.addEditLanguage", $data);
    }

    /**
     * Save Language
     * @param \App\Http\Requests\Admin\LanguageRequest $request
     * @return mixed
     */
    public function saveLanguage(LanguageRequest $request): mixed
    {
       return Response::send(
            $this->languageService->saveLanguage($request),
            "languagePage"
       );
    }

    /**
     * Delete Language
     * @param string $uid
     * @return mixed
     */
    public function languageDelete(string $uid): mixed
    {
       return Response::send(
            $this->languageService->languageDelete($uid),
            "languagePage"
       );
    }

    /**
     * Update Language Status
     * @param string $uid
     * @return mixed
     */
    public function updateLanguageStatus(string $uid): mixed
    {
       return Response::send(
            $this->languageService->languageStatus($uid),
            "languagePage"
       );
    }
}
