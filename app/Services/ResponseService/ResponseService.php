<?php

namespace App\Services\ResponseService;

use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Redirector;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Route;
use Illuminate\Routing\ResponseFactory;

/**
 * Response Service
 */
class ResponseService
{
    /**
     * @var array<mixed> $result
     */
    private array   $result    = [];
    private ?string $next      = null;
    private ?string $back      = null;
    private ?string $next_view = null;
    private ?string $back_view = null;

    /**
     * @var array<string, mixed>
     */
    private ?array  $query     = null;

    public function __construct(){}

    /**
     * Store Result In Property
     * 
     * @param array<mixed> $result
     * @return \App\Services\ResponseService\ResponseService
     */
    public function result(array $result): self
    {
        $this->result = $result;
        return $this;
    }

    /**
     * Set Success Return Route
     * 
     * @param string $route
     * @return \App\Services\ResponseService\ResponseService
     */
    public function next(string $route): self
    {
        $this->next = $route;
        return $this;
    }

    /**
     * Set Failed Return Route
     * 
     * @param ?string $route
     * @return \App\Services\ResponseService\ResponseService
     */
    public function back(string $route = null): self
    {
        $this->back = $route;
        return $this;
    }

    /**
     * Set Success Return Route
     * 
     * @param string $view
     * @return \App\Services\ResponseService\ResponseService
     */
    public function next_view(string $view): self
    {
        $this->next_view = $view;
        return $this;
    }

    /**
     * Set Failed Return Route
     * 
     * @param string $view
     * @return \App\Services\ResponseService\ResponseService
     */
    public function back_view(string $view): self
    {
        $this->back_view = $view;
        return $this;
    }

    /**
     * Add Query To Response
     * @param array<mixed> $query
     * @return \App\Services\ResponseService\ResponseService
     */
    public function query(array $query): self
    {
        $this->query = $query;
        return $this;
    }

    /**
     * validate result
     * @return array
     */
    private function validate()
    {
        if(blank($this->result))
            return failed(_t("Result not set"));

        return success();
    }

    /**
     * build the response
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse|\Illuminate\Contracts\View\View
     */
    private function build(): JsonResponse|RedirectResponse|View
    {

        $responseData = $this->result;
        $validation = $this->validate();
        if(!$validation['status']) $responseData = $validation;

        if(IS_API_REQUEST){
            /** @var ResponseFactory $responseTo */
            $responseTo = response();
            return $responseTo->json($responseData);
        }

        /** @var Redirector $redirect */
        $redirect = redirect();

        if($responseData['status']){
            if($this->next_view){
                /** @var View $viewPage */
                $viewPage = view($this->next_view, $responseData);
                return $viewPage->with("success", $responseData['message'] ?? "");
            }

            if($this->next && Route::has($this->next)){
                return $redirect->route($this->next, $this->query)
                ->with("success", $responseData["message"] ?? '');
            }

            if($this->back && Route::has($this->back ?? "")){
                return $redirect->route($this->back, $this->query)
                ->with("success", $responseData["message"] ?? '');
            }

            return $redirect->back()->with("success", $responseData["message"] ?? '');
        }
        
        if($this->back_view){
            /** @var View $viewPage */
            $viewPage = view($this->back_view, $responseData);
            return $viewPage->with("error", $responseData['message'] ?? "");
        }

        if($this->back && Route::has($this->back ?? "")){
            return $redirect->route($this->back, $this->query)
            ->with("error", $responseData["message"] ?? '');
        }

        return $redirect->back()->with("error", $responseData["message"] ?? '');
    }

    /**
     * This method will send back response
     * @return JsonResponse|RedirectResponse|View
     */
    public function send(): JsonResponse|RedirectResponse|View
    {
        return $this->build();
    }
    
    /**
     * This method will throw back response
     * @return void
     */
    public function throw(): void
    {
        /** @var RedirectResponse $send */
        $send = $this->build();
        $send->throwResponse();
    }

    /**
     * Set Success Response
     * @param mixed $messageOrData
     * @param mixed $data
     * @param array<string, mixed> $topLevelData
     * @return \App\Services\ResponseService\ResponseService
     */
    public function success(mixed $messageOrData = null, mixed $data = [], array $topLevelData = []): self
    {
        $this->result = success($messageOrData, $data, $topLevelData);
        return $this;
    }

    /**
     * Set Failed Response
     * @param mixed $messageOrData
     * @param mixed $data
     * @param array<string, mixed> $topLevelData
     * @return \App\Services\ResponseService\ResponseService
     */
    public function failed(mixed $messageOrData = null, mixed $data = [], array $topLevelData = []): self
    {
        $this->result = failed($messageOrData, $data, $topLevelData);
        return $this;
    }
}
