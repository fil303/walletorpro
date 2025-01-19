<?php

namespace App\Http\Controllers\Admin;

use App\Models\Faq;
use App\Enums\Status;
use App\Models\Language;
use Yajra\DataTables\DataTables;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\FaqRequest;
use App\Services\FaqService\AppFaqService;
use App\Services\ResponseService\Response;
use App\Services\TableActionGeneratorService\FaqList\FaqList;

class FaqController extends Controller
{
    public function __construct(protected AppFaqService $faqService){}

    /**
     * Get FAQ Page
     * @return mixed
     */
    public function faqPage(): mixed
    {
        if(IS_API_REQUEST){
            $faq = Faq::query();

            return DataTables::of($faq)
            ->editColumn("status", function($lang){
                $statusData["items"] = [
                    "onchange" => 'updateFaqStatus(\''.$lang->uid.'\')',
                ];
                if($lang->status == Status::ENABLE) $statusData["items"]["checked"] = "";
                
                return view("admin.components.toggle", $statusData);
            })
            ->addColumn("action", fn($item) =>  FaqList::getInstance($item)->button())
            ->make(true);
        }
        return view("admin.faq.faq");
    }

    /**
     * Get Add Edit Faq Page
     * @param string $uid
     * @return mixed
     */
    public function addEditFaqPage(string $uid = null): mixed
    {
        $data = [];
        // $data["languages"] = Language::whereStatus(enum(Status::ENABLE))->get([
        //     "code as key","name as value"
        // ]);

        if($uid) $data['item'] = Faq::where("uid", $uid)->first();
        return view("admin.faq.addEditFaq", $data);
    }

    /**
     * Save Faq
     * @param \App\Http\Requests\Admin\FaqRequest $request
     * @return mixed
     */
    public function saveFaq(FaqRequest $request): mixed
    {
        return Response::send(
            $this->faqService->saveFaq($request),
            'faqPage'
        );
    }
 
    /**
     * Delete Faq
     * @param string $uid
     * @return mixed
     */
    public function faqDelete(string $uid): mixed
    {
        return Response::send(
            $this->faqService->faqDelete($uid)
        );
    }

    /**
     * Update Faq Status
     * @param string $uid
     * @return mixed
     */
    public function updateFaqStatus(string $uid): mixed
    {
        return Response::send(
            $this->faqService->faqStatus($uid)
        );
    }
}