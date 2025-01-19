<?php

namespace App\Http\Controllers\Admin;

use App\Enums\Status;
use App\Models\CustomPage;
use Illuminate\Http\Request;
use App\Facades\ResponseFacade;
use Illuminate\Http\JsonResponse;
use Illuminate\Contracts\View\View;
use App\Http\Controllers\Controller;
use Yajra\DataTables\Facades\DataTables;
use App\Http\Requests\Admin\CustomPageRequest;
use Illuminate\Support\Facades\View as ViewFactory;
use App\Services\TableActionGeneratorService\CustomPageListAction;

class CustomPageController extends Controller
{
    public function __construct(){}

    /**
     * Get Custom Page
     * @return \Illuminate\Contracts\View\View|\Illuminate\Http\JsonResponse
     */
    public function customPage(): View|JsonResponse
    {
        if(IS_API_REQUEST){
            $customPage = CustomPage::query();
            return DataTables::of($customPage)
            ->editColumn("status", function($customPage){
                $statusData["items"] = [
                    "onchange" => "updateStatus($customPage->id)",
                ];
                if($customPage->status == Status::ENABLE) $statusData["items"]["checked"] = "";
                return view("admin.components.toggle", $statusData);
            })
            ->addColumn("action", fn($item) =>  CustomPageListAction::getInstance($item)->button())
            ->rawColumns(["status", "action"])
            ->make(true);
        }
        return ViewFactory::make("admin.custom_page.index");
    }

    /**
     * Add And Edit Custom Page
     * @param int $id
     * @return \Illuminate\Contracts\View\View
     */
    public function customPageAddEdit(int $id = null): View
    {
        if($id){
            if($item = CustomPage::find($id))
            return ViewFactory::make("admin.custom_page.addEdit", compact("item"));
        }
        return ViewFactory::make("admin.custom_page.addEdit");
    }

    /**
     * Custom Page Save
     * @param \App\Http\Requests\Admin\CustomPageRequest $request
     * @return mixed
     */
    public function customPageSave(CustomPageRequest $request): mixed
    {
        $customPageData = [
            "name"    => $request->name,
            "title"   => $request->title,
            "slug"    => generate_unique_slug($request->title),
            "content" => $request->content_body,
            "status"  => $request->status,
        ];

        $db_response = CustomPage::updateOrCreate(["id" => $request->id ?? 0], $customPageData);
        if($db_response){
            if(isset($request->id))
                return ResponseFacade::success("Custom Page Updated Successfully.")->back('customPage')->send();
            return ResponseFacade::success("Custom Page Created Successfully.")->back('customPage')->send();
        }
        if(isset($request->id))
            return ResponseFacade::failed("Custom Page Update Failed.")->back('customPage')->send();
        return ResponseFacade::failed("Custom Page Creation Failed.")->back('customPage')->send();
    }

    /**
     * Update Custom Page Status
     * @return mixed
     */
    public function customPageStatus(): mixed
    {
        $response = CustomPage::find(request()->id ?? 0);
        if($response){
            $response->status = !$response->status?->value;
            $response->save();
            return ResponseFacade::success("Status Updated Successfully.")->send();
        }
        return ResponseFacade::failed("Status Update Failed.")->send();
    }
}
