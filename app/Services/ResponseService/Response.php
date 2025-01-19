<?php

namespace App\Services\ResponseService;

use Illuminate\Routing\Redirector;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Route;
use Illuminate\Contracts\View\Factory;
use Illuminate\Routing\ResponseFactory;
use Illuminate\Http\Response as HttpResponse;
use Illuminate\Http\RedirectResponse as HttpWebResponse;

/**
 * Response Service
 * @template T
 */
class Response
{
    /**
     * Send Response
     * @param array<string, T> $response
     * @param string $route
     * @param \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|string $view
     * @return mixed
     */
    public static function send(array $response, string $route = null, Factory|View|string $view = null): mixed
    {
        if(IS_API_REQUEST){
            /** @var ResponseFactory $responseTo */
            $responseTo = response();
            return $responseTo->json($response);
        }

        $responseStatus = $response['status'] ?? false;

        if($view && !( !$responseStatus && $route )){
            if(gettype($view) == 'object') return $view;

            /** @var View $viewPage */
            $viewPage = view($view, $response['data'] ?? []);
            $viewPage = $viewPage->with(
                $responseStatus ? "success" : "error",
                $response['message'] ?? ""
            );
            return $viewPage;
        }

        /** @var Redirector $returnResponse */
        $returnResponse = redirect();
        return self::makeWebResponse($returnResponse, $response, $route);
    }

    /**
     * Make Web Response
     * @param Redirector $response
     * @param array<string, T> $responseData
     * @param string $route
     * @return HttpWebResponse|Redirector
     */
    public static function makeWebResponse(
        // HttpWebResponse|Redirector  $response,
        Redirector $response,
        array $responseData,
        string $route = null
    ):  HttpWebResponse|Redirector
    {
        ($route && Route::has($route)) 
            ? $response = $response->route($route)
            : $response = $response->back();

        (isset($responseData['status']) && $responseData['status'])
            ? $response = $response->with(
                "success", 
                $responseData['message'] ?? _t("Success")
            )
            : $response = $response->with(
                "error", 
                $responseData['message'] ?? _t("Failed")
            );

        return $response;
    }

    /**
     * Throw Response
     * @param array<string, T> $response
     * @param string $route
     * @param string $view
     * @return void
     */
    public static function throw(array $response, string $route = null, string $view = null): void
    {
        self::send($response, $route, $view)->throwResponse();
    }
}
