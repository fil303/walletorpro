<?php

namespace App\Exceptions;

use Throwable;
use Illuminate\Routing\Router;
use App\Facades\ResponseFacade;
use Illuminate\Http\JsonResponse;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Contracts\Support\Responsable;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;

class Handler extends ExceptionHandler
{
    /**
     * The list of the inputs that are never flashed to the session on validation exceptions.
     *
     * @var array<int, string>
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     */
    public function register(): void
    {
        $this->reportable(function (Throwable $e) {
            //
        });
    }

        /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Throwable  $e
     * @return Response|JsonResponse|RedirectResponse|View
     *
     * @throws \Throwable
     */
    public function render($request, Throwable $e)
    {
        if( env("APP_ENV", "production") !== "productions" ){
            // logStore("Error Render:", $e->getTraceAsString());
            // $referer = request()?->headers?->get('referer') ?? null;
            $backTo = null;
            $referer = $_SERVER['HTTP_REFERER'] ?? null;
            if(!($referer && Auth::check())) $backTo = "welcomePage";
            return ResponseFacade::failed(_t("Something went wrong"))->back($backTo)->send();
        }

        $e = $this->mapException($e);

        if (method_exists($e, 'render') && $response = $e->{'render'}($request)) {
            return Router::toResponse($request, $response);
        }

        if ($e instanceof Responsable) {
            return $e->toResponse($request);
        }

        $e = $this->prepareException($e);

        if ($response = $this->renderViaCallbacks($request, $e)) {
            return $response;
        }

        return match (true) {
            $e instanceof HttpResponseException => $e->getResponse(),
            $e instanceof AuthenticationException => $this->unauthenticated($request, $e),
            $e instanceof ValidationException => $this->convertValidationExceptionToResponse($e, $request),
            default => $this->renderExceptionResponse($request, $e),
        };
    }
}
